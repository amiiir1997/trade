<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use App\Matrade;
use App\Matradelist;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test(){
    	$this->newtrade();
    }


    public function newtrade(){
	$trade = new Matrade;
	$trade->small=7;
	$trade->big = 20;
	$trade->intervall = '30m';
	$trade->symbol = 'ADAUSDT';
	$trade->position = 'short';
	$trade->coin = 0;
	$trade->dollar = 1000;
	$trade->triger = 0;
	$trade->state = 'on' ;
	$response = Http::get('https://api.binance.com/api/v3/klines',['symbol' => $trade->symbol , 'interval' => $trade->intervall , 'limit' =>1]);
	$trade->closetime = $response [0][6];
	$trade->save();
	}

    public function run(){
    	$time = Http::get('https://api.binance.com/api/v3/time')['serverTime'];
    	$trades = Matrade::where('state','on')->where('closetime' , '<' , $time)->select('trade_id')->get();
    	foreach ($trades as $trade){ 
			$this->Check($trade['trade_id']);
		}

    }

    public function off($trade_id){
    	Matrade::where('trade_id',$trade_id)->update(['state' => 'off']);
    	return redirect('/tradepage/'.$trade_id);
    }
    public function on($trade_id){
    	Matrade::where('trade_id',$trade_id)->update(['state' => 'on']);
    	return redirect('/tradepage/'.$trade_id);
    }

    public function tradepage($trade_id){
    	$data ['trade'] = Matrade::where('trade_id',$trade_id)->first();
    	$data['tradelist'] = Matradelist::where('trade_id', $trade_id)->get();
    	return view('tradepage')->with('data' ,$data);
    }

    private function Long($trade_id){
	$trade = Matrade::where('trade_id' ,$trade_id)->first();
    	$price = $this->Price($trade['symbol']);
    	Matrade::where('trade_id' ,$trade_id)->update(['position' => 'long' , 'coin' => ($trade['coin']+$trade['dollar']/$price * 0.999) , 'dollar' => 0 ]);
    	$add = new Matradelist;
    	$add->price = $price;
    	$add->type = 'buy';
    	$add->trade_id = $trade_id;
    	$add->save();
    }

    private function Short($trade_id){
	$trade = Matrade::where('trade_id' ,$trade_id)->first();
    	$price = $this->Price($trade['symbol']);
    	Matrade::where('trade_id' ,$trade_id)->update(['position' => 'short' , 'dollar' => $trade['dolar']+$trade['coin']*$price * 0.999 , 'coin' => 0]);
    	$add = new Matradelist;
    	$add->price = $price;
    	$add->type = 'sell';
    	$add->trade_id = $trade_id;
    	$add->save();
    }


    private function Check($trade_id){
    	$trade = Matrade::where('trade_id' ,$trade_id)->first();
    	$masmall = $this->CalculateMa($trade['small'],$trade['intervall'],$trade['symbol']);
    	$mabig = $this->CalculateMa($trade['big'],$trade['intervall'],$trade['symbol']);
    	if($masmall > $mabig && $trade['position'] != 'long')
    		$this->Long($trade_id);
    	else if($masmall < $mabig && $trade['position'] != 'short')
    		$this->Short($trade_id);
    	if($trade['intervall'] == '1m')
    		$next = intval($trade['closetime']) + 60000;
    	else if($trade['intervall'] == '3m')
    		$next = intval($trade['closetime']) + 60000*3;
    	else if($trade['intervall'] == '5m')
    		$next = intval($trade['closetime']) + 60000*5;
    	else if($trade['intervall'] == '15m')
    		$next = intval($trade['closetime']) + 60000*15;
    	Matrade::where('trade_id' ,$trade_id)->update(['closetime' => strval($next)]);
    }

    private function Price($symbol){
    	return Http::get('https://api.binance.com/api/v3/ticker/price',['symbol' => $symbol])['price'];
    }

    private function Updatetriger($trade_id){
    	$trade = Matrade::find($trade_id);
    	$triger = $this->Triger($trade['small'] , $trade['big']  , $trade['intervall']  , $trade['symbol'] );
    	Matrade::find($trade_id)->update(['triger' => $triger]);
    	return 1;
    }

    private function Triger($small , $big , $interval , $symbol){
    	$masmall = $this->CalculateMa($small,$interval,$symbol);
    	$mabig = $this->CalculateMa($big,$interval,$symbol);
    	echo $masmall."<br>";
    	echo $mabig."<br>";
    	$trigger = (($mabig*$small*($big-1))-($masmall*$big*($small-1)))/($big-$small);
    	return $trigger;
    }

    private function CalculateMa($limit , $interval , $symbol){
    	if($limit == 0)
    		return 0;
    	$response = Http::get('https://api.binance.com/api/v3/klines',['symbol' => $symbol , 'interval' => $interval , 'limit' => $limit+1]);
    	if(!$response->ok())
    		return 0;
    	$ma = 0;
    	for($i= 0 ; $i < $limit-1 ; $i++){
			$ma=$ma + $response[$i][4];
    	}
    	$ma = $ma / ($limit-1);
    	return $ma;
    }
}
