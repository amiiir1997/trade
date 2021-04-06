<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Macdrobot;
use App\Macdtrade;
use App\Ema;
use App\Data;

class MACDController extends Controller
{
	public function test(){
		//return $this->Candle('BTCUSDT' , 10 , '1m');
		//return $this->Histogram(12 , 26 ,9 ,'BTCUSDT' , 10 , '5m',2);
		//$candle = $this->Candle('BTCUSDT',250,'1m');
		//return $this->InitialEMA('5m' , 12 ,26 ,9 , $candle , 250,2);
		//return $this->Check(4);
		//for ($i=0;$i <1000;$i++){
			//$n = new Data;
			//$n->close = $candle[$i][4];
			//$n->save();
			//echo $candle[$i][4].'<br>';
		//}
		//return $this->testdata();
		return $this->Price('BTCUSDT');
	}

	private function testdata(){
		$candle = $this->Candle('BTCUSDT',200,'1m');
		$x=2/(1+12);
		$ema = 0;
		for($i=0 ; $i < 199 ; $i++)
			$ema = $candle[$i][4] * $x + $ema * (1-$x);
		return $ema;

	}

	public function off($robot_id){
    	Macdrobot::where('robot_id',$robot_id)->update(['state' => 'off']);
    	return redirect('/macd/robot/'.$robot_id);
    }

    public function on($robot_id){
    	Macdrobot::where('robot_id',$robot_id)->update(['state' => 'on']);
    	return redirect('/macd/robot/'.$robot_id);
    }

    public function remove($robot_id){
    	Macdrobot::where('robot_id',$robot_id)->delete();
    	$temp = Macdrobot::select('robot_id')->orderbydesc('robot_id')->first();
    	if(is_null($temp))
    		return redirect('/macd/newrobot');
		return redirect('/macd/robot/'.$temp['robot_id']);
    }

	public function robotpage($robot_id){
    	$data ['robot'] = Macdrobot::where('robot_id',$robot_id)->first();
    	$data['macdtrades'] = Macdtrade::where('robot_id', $robot_id)->get();
    	$data ['list'] = Macdrobot::select ('robot_id')->get();
    	return view('tradepage')->with('data' ,$data);
    }

	public function run(){
    	$time = Http::get('https://api.binance.com/api/v3/time')['serverTime'];
    	$robots = Macdrobot::where('state','on')->where('closetime' , '<=' , $time/60000)->select('robot_id')->get();
    	foreach ($robots as $robot){ 
			$this->Check($robot['robot_id']);
		}
		$n = new Data;
		$n->close =1;
		$n->save();
	}

	public function newrobotpage(){
		return view('NewMacdRobot');
	}

	public function newrobotexecute(Request $request){
		$new = new Macdrobot;
		$new->small=$request->input('small');
		$new->big=$request->input('big');
		$new->signal=$request->input('signal');
		$new->limit=$request->input('limit');
		$new->interval=$request->input('interval');
		$new->smoothing=$request->input('smoothing');
		$new->coin=$request->input('coin');
		$new->dollar=$request->input('dollar');
		$new->symbol=$request->input('symbol');
		$new->state='on';
		$new->position='initial';
		$candle = $this->Candle($request->input('symbol'),$request->input('limit'),$request->input('interval'));
		$new->closetime = ($candle [$request->input('limit')-1][6]+1)/60000;
		$ema = $this->InitialEMA( $request->input('interval') , $request->input('small') ,$request->input('big') ,$request->input('signal') , $candle , $request->input('limit') ,$request->input('smoothing'));
		$new->smallema=$ema['small'];
		$new->bigema=$ema['big'];
		$new->signalema=$ema['signal'];
		$new->save();
		$temp = Macdrobot::select('robot_id')->orderbydesc('robot_id')->first()['robot_id'];
		return redirect('/macd/robot/'.$temp);
	}

	private function Price($symbol){
    	return Http::get('https://fapi.binance.com/fapi/v1/premiumIndex',['symbol' => $symbol])['markPrice'];
    }

	private function Short($robot_id ,$histogram){
		$robot = Macdrobot::where('robot_id' ,$robot_id)->first();
    	$price = $this->Price($robot['symbol']);
    	Macdrobot::where('robot_id' ,$robot_id)->update(['position' => 'short' , 'dollar' => $robot['dolar']+$robot['coin']*$price * 0.999 , 'coin' => 0]);
    	$add = new Macdtrade;
    	$add->price = $price;
		$add->histogram = $histogram;
    	$add->type = 'sell';
		$add->balance = $robot['dolar']+$robot['coin']*$price * 0.999;
    	$add->robot_id = $robot_id;
    	$add->save();
    }

	private function Long($robot_id ,$histogram){
		$robot = Macdrobot::where('robot_id' ,$robot_id)->first();
    	$price = $this->Price($robot['symbol']);
    	Macdrobot::where('robot_id' ,$robot_id)->update(['position' => 'long' , 'coin' => ($robot['coin']+$robot['dollar']/$price * 0.999) , 'dollar' => 0 ]);
    	$add = new Macdtrade;
    	$add->price = $price;
    	$add->type = 'buy';
		$add->balance = ($robot['coin']+$robot['dollar']/$price * 0.999);
		$add->histogram = $histogram;
    	$add->robot_id = $robot_id;
    	$add->save();
    }

    private function Check($robot_id){
    	$robot = Macdrobot::where('robot_id' ,$robot_id)->first();
		if(!$candle = $this->Candle($robot['symbol'] , 2 , $robot['interval'])){
    		return 'error';
    	}
		$smallema = $this->EMA($robot['smoothing'],$robot['small'],$candle[0][4] , $robot['smallema']);
		$bigema = $this->EMA($robot['smoothing'],$robot['big'],$candle[0][4] , $robot['bigema']);
		$signalema =  $this->EMA($robot['smoothing'],$robot['signal'], $smallema-$bigema, $robot['signal']);
    	$histogram =($smallema - $bigema ) - $signalema;
    	if($histogram > 0 && $robot['position'] != 'long')
    		$this->Long($robot_id ,$histogram);
    	else if ($histogram < 0 && $robot['position'] != 'short')
    		$this->Short($robot_id ,$histogram);
    	if($robot['interval'] == '1m')
    		$next = $robot['closetime'] + 1;
    	else if($robot['interval'] == '3m')
    		$next = $robot['closetime'] + 3;
    	else if($robot['interval'] == '5m')
    		$next = $robot['closetime'] + 5;
    	else if($robot['interval'] == '15m')
    		$next = $robot['closetime'] + 15;
    	Macdrobot::where('robot_id' ,$robot_id)->update(['closetime' => $next , 'smallema' => $smallema , 'bigema' => $bigema , 'signalema' => $signalema , 'macd' => $smallema-$bigema]);

    }

    private function Histogram($small , $big ,$signal ,$symbol , $limit , $interval,$smoothing){
    	if(!$candle = $this->Candle("BTCUSDT" , $limit , $interval)){
    		return 'error';
    	}
    	$macd = $this->EMA($smoothing,$small,$candle , $limit) - $this->EMA($smoothing,$big,$candle , $limit);
    	$signalline = $this->EMA($smoothing,$signal,$candle , $limit);
    	$histogram = $macd-$signalline;
    	return $histogram;
    }

    private function EMA($smoothing,$number,$price , $lastema){
		$x= $smoothing/(1+$number);
    	$ema = $price * $x + $lastema * (1-$x);
    	return $ema;
    }

    private function Candle($symbol , $limit , $interval){
    	$response = Http::get('https://fapi.binance.com/fapi/v1/klines',['symbol' => $symbol , 'interval' => $interval , 'limit' => $limit]);
    	if(!$response->ok())
    		return 0;
    	return $response;

    }

    private function InitialEMA( $interval , $small ,$big ,$signal , $candle , $limit,$smoothing){
		$smallema = $candle[0][4];
		$bigema = $candle[0][4];
		$signalema = ($smallema-$bigema);
		$smallx=$smoothing/(1+$small);
		$bigx=$smoothing/(1+$big);
		$signalx=$smoothing/(1+$signal);
		for($i = 1 ; $i < $limit-1 ; $i++){
    		$smallema = $candle[$i][4] * $smallx + $smallema * (1-$smallx);
			$bigema = $candle[$i][4] * $bigx + $bigema * (1-$bigx);
			$signalema = ($smallema-$bigema) * $signalx + $signalema * (1-$signalx);
    	}
		$ema['small'] = $smallema;
		$ema['big'] = $bigema;
		$ema['signal'] = $signalema;
		return $ema;
    }
}
