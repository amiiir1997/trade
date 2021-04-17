<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Oflinecandle;

class OflineMACDController extends Controller
{
	public function test(){
		//return $response = Http::get('https://fapi.binance.com/fapi/v1/klines',['symbol' => "BTCUSDT" , 'interval' => '5m' , 'limit' => 1]);
		//return $this->getcandle(5);
		//return $response = Http::get('https://fapi.binance.com/fapi/v1/klines',['symbol' => "BTCUSDT" , 'interval' => '5m' , 'limit' => 2]);
		//return $this->oflinecci();
		//Oflinecandle::where ('interval' , '5m')->delete();
		//return  Oflinecandle::where('interval' , '1m')->where('symbol' , 'BTCUSDT1')->orderby('start')->get();
		//echo date('m/d/Y H:i:s', 26970775*60 + 4.5*60*60);
		//return $this->multisell();
		//return $this->shibma();
		//return $this->getdata(5);
		//return $this->oflinerobot();
		return $this->doublemacd();
	}

	public function getdata($number){
		$x26 = 2/27;
    	$x12 = 2/13;
    	$x9 = 2 / 10;
    	$num = 1618246800000/60000 - (17280 * $number );
    	$flag = 1400;
    	$j = 0;
    	$response = Http::get('https://fapi.binance.com/fapi/v1/klines',['symbol' => "BTCUSDT" , 'interval' => '5m' , 'limit' => 300 , 'startTime' => ($num-(300 *$number)) * 60000]);
    	$ema12 = $response[0][4];
		$ema26 = $response[0][4];
		$ema9 = ($ema12-$ema26);
		for($i = 1 ; $i < 300 ; $i++){
    		$ema12 = $response[$i][4] * $x12 + $ema12 * (1-$x12);
			$ema26 = $response[$i][4] * $x26 + $ema26 * (1-$x26);
			$ema9 = ($ema12-$ema26) * $x9 + $ema9 * (1-$x9);
    	}
    	echo '<center><table>';
    	echo '<tr>';
    		echo '<th>'.'time'.'</th>';
    		echo '<th>'.'open'.'</th>';
    		echo '<th>'.'close'.'</th>';
    		echo '<th>'.'high'.'</th>';
    		echo '<th>'.'low'.'</th>';
    		echo '<th>'.'26'.'</th>';
    		echo '<th>'.'12'.'</th>';
    		echo '<th>'.'signal'.'</th>';
    		echo '</tr>';
    	for(;1;){
		$ccicandle = Http::get('https://fapi.binance.com/fapi/v1/klines',['symbol' => "BTCUSDT" , 'interval' => '5m' , 'limit' => $flag+19 , 'startTime' => ($num-(19*$number)) * 60000])->json();
    	$response = Http::get('https://fapi.binance.com/fapi/v1/klines',['symbol' => "BTCUSDT" , 'interval' => '5m' , 'limit' => $flag , 'startTime' => $num * 60000]);
    	for( $i = 0 ; $i < $flag ; $i++)
    	{
    		$ema26 = $ema26 * (1-$x26) + $response[$i][4] * $x26;
    		$ema12 = $ema12 * (1-$x12) + $response[$i][4] * $x12;
    		$ema9 = $ema9 * (1-$x9) + ($ema12 - $ema26 ) * $x9;
    		echo '<tr>';
    		echo '<td>'.date('m/d/Y H:i:s', ($response[$i][0]/1000 + 4.5*60*60)).'</td>';
    		echo '<td>'.$response[$i][1].'</td>';
    		echo '<td>'.$response[$i][4].'</td>';
    		echo '<td>'.$response[$i][2].'</td>';
    		echo '<td>'.$response[$i][3].'</td>';
    		echo '<td>'.$ema26.'</td>';
    		echo '<td>'.$ema12.'</td>';
    		echo '<td>'.$ema9.'</td>';
    		echo '</tr>';
    	}
    	if($flag != 1400)
    		break;
    	$num = $num +($flag * $number);
    	if($num > 1618246800000/60000-($flag*$number)){
    		$flag =(1618246800000/60000- $num)/$number;
    	}
    	}
    	echo '</table></center>';
    }

    public function getcandle($number){
    	$x26 = 2/27;
    	$x12 = 2/13;
    	$x9 = 2 / 10;
    	$x52 = 2/53;
    	$x24 = 2/25;
    	$x18 = 2 / 19;
    	$x13 = 2/14;
    	$x6 = 2/7;
    	$x5 = 2 / 6;
    	$num = 1618656000000/60000 - (365 * 24 * 12 * $number );
    	$flag = 1400;
    	$j = 0;
    	$response = Http::get('https://fapi.binance.com/fapi/v1/klines',['symbol' => "BTCUSDT" , 'interval' => '5m' , 'limit' => 1000 , 'startTime' => ($num-(1000 *$number)) * 60000]);
    	$ema12 = $response[0][4];
		$ema26 = $response[0][4];
		$ema9 = ($ema12-$ema26);
		$ema24 = $response[0][4];
		$ema52 = $response[0][4];
		$ema18 = ($ema24-$ema52);
		$ema6 = $response[0][4];
		$ema13 = $response[0][4];
		$ema5 = ($ema6-$ema13);
		for($i = 1 ; $i < 500 ; $i++){
    		$ema12 = $response[$i][4] * $x12 + $ema12 * (1-$x12);
			$ema26 = $response[$i][4] * $x26 + $ema26 * (1-$x26);
			$ema9 = ($ema12-$ema26) * $x9 + $ema9 * (1-$x9);
			$ema24 = $response[$i][4] * $x24 + $ema24 * (1-$x24);
			$ema52 = $response[$i][4] * $x52 + $ema52 * (1-$x52);
			$ema18 = ($ema24-$ema52) * $x18 + $ema18 * (1-$x18);
			$ema6 = $response[$i][4] * $x6 + $ema6 * (1-$x6);
			$ema13 = $response[$i][4] * $x13 + $ema13 * (1-$x13);
			$ema5 = ($ema6-$ema13) * $x5 + $ema5 * (1-$x5);
    	}
    	for(;1;){
		//$ccicandle = Http::get('https://fapi.binance.com/fapi/v1/klines',['symbol' => "BTCUSDT" , 'interval' => '5m' , 'limit' => $flag+19 , 'startTime' => ($num-(19*$number)) * 60000])->json();
    	$response = Http::get('https://fapi.binance.com/fapi/v1/klines',['symbol' => "BTCUSDT" , 'interval' => '5m' , 'limit' => $flag , 'startTime' => $num * 60000]);
    	$data = [];
    	for( $i = 0 ; $i < $flag ; $i++)
    	{
    		$data[$i]['interval'] ='5m';
    		$data[$i]['symbol'] = 'BTC1Y';
    		$data[$i]['start'] = $response[$i][0]/60000;
    		$data[$i]['open'] = $response[$i][1];
    		$data[$i]['high'] = $response[$i][2];
    		$data[$i]['low']= $response[$i][3];
    		$data[$i]['close'] = $response[$i][4];
    		$ema26 = $ema26 * (1-$x26) + $response[$i][4] * $x26;
    		$ema12 = $ema12 * (1-$x12) + $response[$i][4] * $x12;
    		$ema9 = $ema9 * (1-$x9) + ($ema12 - $ema26 ) * $x9;
    		$data[$i]['ema26'] = $ema26;
    		$data[$i]['ema12'] = $ema12;
    		$data[$i]['signal9'] = $ema9;
    		$ema52 = $ema52 * (1-$x52) + $response[$i][4] * $x52;
    		$ema24 = $ema24 * (1-$x24) + $response[$i][4] * $x24;
    		$ema18 = $ema18 * (1-$x18) + ($ema24 - $ema52 ) * $x18;
    		$data[$i]['ema52'] = $ema52;
    		$data[$i]['ema24'] = $ema24;
    		$data[$i]['signal18'] = $ema18;
    		$ema13 = $ema13 * (1-$x13) + $response[$i][4] * $x13;
    		$ema6 = $ema6 * (1-$x6) + $response[$i][4] * $x6;
    		$ema5 = $ema5 * (1-$x5) + ($ema6 - $ema13 ) * $x5;
    		$data[$i]['ema13'] = $ema13;
    		$data[$i]['ema6'] = $ema6;
    		$data[$i]['signal5'] = $ema5;
			//$data[$i]['cci']=$this->SMA(array_slice($ccicandle, $i, $i+20),20);
    	}
		Oflinecandle::insert($data);
    	if($flag != 1400)
    		break;
    	$num = $num +($flag * $number);
    	if($num > 1618656000000/60000-($flag*$number)){
    		$flag =(1618656000000/60000- $num)/$number;
    	}
    	
    	echo $j.'<br>';
    	$j++;
    	}
    	
    }
    
    private function oflinerobot(){
    	$offset = 0;
    	$limit = 3000;
    	$ideax = 2/(1+9);
    	$position = 'short';
    	$high = 0;
    	$low = 10000000;
    	$tradenum = 0 ;
    	$data['a'][$tradenum]['type'] = 0;
		$data['a'][$tradenum]['open'] = 0;
		$data['a'][$tradenum]['timeopen']=0;
		$tradeflag = 0 ;
		while($offset < 17280){
		$candles = Oflinecandle::where('interval' , '5m')->where('symbol' , 'BTC1.5X')->orderby('start')->offset($offset)->limit ($limit)->get();
			$offset = $offset + $limit;
    	foreach ($candles as $candle){ 
    		if($tradeflag == 1){
    			$data['a'][$tradenum]['open'] = $candle['open'];
				$data['a'][$tradenum-1]['close'] = $candle['open'];
    		}
    		$tradeflag = 0 ;
			$histogram =($candle['ema12'] - $candle['ema26'] ) - $candle['signal'];
			if($histogram > 0 && $position != 'long'){
				$data['a'][$tradenum+1]['type'] = 'Long';
				$tradeflag = 1;
				if($high < $candle['high'])
    				$high = $candle['high'];
    			if($low > $candle['low'])
    				$low = $candle['low'];
				$data['a'][$tradenum]['high'] = $high;
				$data['a'][$tradenum]['low'] = $low;
				$data['a'][$tradenum+1]['timeopen'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
				$position = 'long';
				$high = 0;
				$low = 10000000;
				$tradenum++;
			}
    		else if ($histogram < 0 && $position != 'short'){
    			$data['a'][$tradenum+1]['type'] = 'Short';
				$tradeflag = 1;
				if($high < $candle['high'])
    				$high = $candle['high'];
    			if($low > $candle['low'])
    				$low = $candle['low'];
				$data['a'][$tradenum]['high'] = $high;
				$data['a'][$tradenum]['low'] = $low;
				$data['a'][$tradenum+1]['timeopen'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
				$position = 'short';
				$high = 0;
				$low = 10000000;
				$tradenum++;
    		}
    		if($high < $candle['high'])
    			$high = $candle['high'];
    		if($low > $candle['low'])
    			$low = $candle['low'];
    	}
		}
		$data['a'][$tradenum]['close'] = 0;
		$data['a'][$tradenum]['high'] =0;
		$data['a'][$tradenum]['low'] = 0;
		//return $data;
		return view('oflinepage')->with('data' ,$data);
    }

	private function multisell(){
		$offset = 0;
		$open = 0;
    	$limit = 3000;
		$candles = Oflinecandle::where('interval' , '5m')->where('symbol' , 'BTCUSDT1')->orderby('start')->limit ($limit)->get();
		$position = 'short';
    	$high = 0;
    	$low = 10000000;
    	$tradenum = 0 ;
		$data['a'][$tradenum]['type'] = 0;
		$data['a'][$tradenum]['open'] = 0;
		$data['a'][$tradenum]['timeopen']=0;
		$tradeflag = 0 ;
		$initialstate = 1;
		while($offset < 84960){
		$candles = Oflinecandle::where('interval' , '5m')->where('symbol' , 'BTCUSDT1')->orderby('start')->offset($offset)->limit ($limit)->get();
			$offset = $offset + $limit;
    	foreach ($candles as $candle){ 
    		if($tradeflag == 1){
    			$data['a'][$tradenum]['open'] = $candle['open'];
				$close = $this->oneminsignal($lastopen , $open ,$lastposition);
				$temp['close'] =$candle['open'];
				$temp['timeclose'] =  date('m/d/Y H:i:s', $candle['start']*60 + 4.5*60*60);
				array_push($close, $temp);
				$data['a'][$tradenum-1]['close'] = $close;
				
    		}
    		$tradeflag = 0 ;
			$histogram =($candle['ema12'] - $candle['ema26'] ) - $candle['signal'];
			if($histogram > 0 && $position != 'long'){
				$data['a'][$tradenum+1]['type'] = 'Long';
				$tradeflag = 1;
				if($high < $candle['high'])
    				$high = $candle['high'];
    			if($low > $candle['low'])
    				$low = $candle['low'];
				$data['a'][$tradenum]['high'] = $high;
				$data['a'][$tradenum]['low'] = $low;
				$data['a'][$tradenum+1]['timeopen'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
				$lastopen = $open;
				$open = $candle['start']+5;
				$position = 'long';
				$lastposition = 'short';
				$high = 0;
				$low = 10000000;
				$tradenum++;
			}
    		else if ($histogram < 0 && $position != 'short'){
    			$data['a'][$tradenum+1]['type'] = 'Short';
				$tradeflag = 1;
				if($high < $candle['high'])
    				$high = $candle['high'];
    			if($low > $candle['low'])
    				$low = $candle['low'];
				$data['a'][$tradenum]['high'] = $high;
				$data['a'][$tradenum]['low'] = $low;
				$data['a'][$tradenum+1]['timeopen'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
				$lastopen = $open;
				$open = $candle['start']+5;
				$position = 'short';
				$lastposition = 'long';
				$high = 0;
				$low = 10000000;
				$tradenum++;
    		}
    		if($high < $candle['high'])
    			$high = $candle['high'];
    		if($low > $candle['low'])
    			$low = $candle['low'];
    	}
		}
		$data['a'][$tradenum]['close'] = [];
		$data['a'][$tradenum]['high'] =0;
		$data['a'][$tradenum]['low'] = 0;
		//return $data;
		return view('multisell')->with('data' ,$data);
	}
	
	private function oneminsignal($start , $end ,$position){
		$ret = [];
		if ($position == 'long'){
		$pos = 0 ;
		}
		else {
			$pos = 1;
		}
		$i = 0;
		$tradeflag = 0;
		$candles = Oflinecandle::where('interval' , '1m')->where('symbol' , 'BTCUSDT1')->where('start' , '>=' , $start)->where ('start' , '<' , $end)->orderby('start')->get();
		foreach ($candles as $candle){
			if($tradeflag){
				$ret[$i]['close'] = $candle['open'];
				$ret[$i]['timeclose'] =  date('m/d/Y H:i:s', ($candle['start'])*60 + 4.5*60*60);
				$i++;
			}
			$tradeflag = 0;
			$histogram =($candle['ema12'] - $candle['ema26'] ) - $candle['signal'];
			if($position = 'long'){
				if($pos){
					if($histogram < 0){
						$tradeflag = 1 ;
						$pos = 0;
					}
				}
				if($histogram > 0)
					$pos = 1;
			}
			else{
				if(!$pos){
					if($histogram > 0){
						$tradeflag = 1 ;
						$pos = 1;
					}
				}
				if($histogram < 0)
					$pos = 0;
			}
		}
		return $ret;
	}
	
	private function CCI($candles , $number){
		$sma = 0;
		$mean = 0;
		for($i = 0 ; $i < $number ; $i++)
			$price[$i] = ($candles[$i][2]+$candles[$i][3]+$candles[$i][4])/3;
		for($i = 0 ; $i < $number  ;$i++)
			$sma = $sma + $price[$i];
		$sma = $sma / $number;
		for($i = 0 ; $i < $number  ;$i++){
			$mean = $mean + abs($price[$i]-$sma);
		}
		$mean = $mean / $number;
		
		$cci = ($price[$number -1] - $sma)/0.015 /$mean;
		return $cci;
	}
	
	private function SMA($candles , $number){
		$sma = 0;
		for($i = 0 ; $i < $number  ;$i++)
			$sma = $sma + $candles[$i][4];
		$sma = $sma / $number;
		return $sma;
	}
	
	private function shibma(){
    }

    private function oflinecci(){
    	$intrade = 0;
    	$starttrade = 0 ;
    	$finishtrade = 0 ;
    	$result = 0;
    	$offset = 0;
    	$limit = 3000;
    	$ideax = 2/(1+9);
    	$position = 'short';
    	$high = 0;
    	$low = 10000000;
    	$tradenum = -1 ;
		$tradeflag = 0 ;
		while($offset < 17280){
		$candles = Oflinecandle::where('interval' , '5m')->where('symbol' , 'BTCCCI')->orderby('start')->offset($offset)->limit ($limit)->get();
			$offset = $offset + $limit;
    	foreach ($candles as $candle){ 
    		if($starttrade == 1){
    			$data['a'][$tradenum]['open'] = $candle['open'];
    			$tradenum = $tradenum-1;
    		}
    		if($finishtrade == 1){
  				$data['a'][$tradenum]['close'] = $candle['open'];
  				$data['a'][$tradenum]['resultbool']=0;
				if($data['a'][$tradenum]['type'] == 'Long'){
					$result = $result - ($data['a'][$tradenum]['close']-$data['a'][$tradenum]['open'])/$data['a'][$tradenum]['open'];
					$data['a'][$tradenum]['result']=($data['a'][$tradenum]['close']-$data['a'][$tradenum]['open'])/$data['a'][$tradenum]['open'];
					if($data['a'][$tradenum]['close'] > $data['a'][$tradenum]['open'])
						$data['a'][$tradenum]['resultbool']=1;
				}
				else{
					$result = $result + ($data['a'][$tradenum]['close']-$data['a'][$tradenum]['open'])/$data['a'][$tradenum]['open'];
					$data['a'][$tradenum]['result']=-1 * ($data['a'][$tradenum]['close']-$data['a'][$tradenum]['open'])/$data['a'][$tradenum]['open'];
					if($data['a'][$tradenum]['close'] < $data['a'][$tradenum]['open'])
						$data['a'][$tradenum]['resultbool']=1;
				}
    		}
    		if($starttrade == 1){
    			$tradenum = $tradenum+1;
    		}
    		$starttrade = 0 ;
    		$finishtrade = 0;
			$histogram =($candle['ema12'] - $candle['ema26'] ) - $candle['signal'];
			if($intrade){
				if($histogram < 0 && $position == 'long'){
					$finishtrade = 1;
					if($high < $candle['high'])
    					$high = $candle['high'];
    				if($low > $candle['low'])
    					$low = $candle['low'];
					$data['a'][$tradenum]['high'] = $high;
					$data['a'][$tradenum]['low'] = $low;
					$data['a'][$tradenum]['timeclose'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
					$intrade = 0 ;
				}
    			else if ($histogram > 0 && $position == 'short'){
					$finishtrade = 1;
					if($high < $candle['high'])
    					$high = $candle['high'];
    				if($low > $candle['low'])
    					$low = $candle['low'];
					$data['a'][$tradenum]['high'] = $high;
					$data['a'][$tradenum]['low'] = $low;
					$data['a'][$tradenum]['timeclose'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
					$intrade = 0 ;
    			}
			}
			if(!$intrade){
			if($histogram > 0  && $candle['cci'] > 100){
				$tradenum++;
				$data['a'][$tradenum]['type'] = 'Long';
				$starttrade = 1;
				$data['a'][$tradenum]['timeopen'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
				$position = 'long';
				$high = 0;
				$low = 10000000;
				$intrade = 1;
			}
    		else if ($histogram < 0 && $candle['cci'] < -100){
    			$tradenum++;
    			$data['a'][$tradenum]['type'] = 'Short';
				$starttrade = 1;;
				$data['a'][$tradenum]['timeopen'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
				$position = 'short';
				$high = 0;
				$low = 10000000;
				$intrade = 1;
    		}
    		}
    		if($high < $candle['high'])
    			$high = $candle['high'];
    		if($low > $candle['low'])
    			$low = $candle['low'];
    	}
		}
		$data['a'][$tradenum]['high'] = 0;
		$data['a'][$tradenum]['low'] = 0;
		$data['a'][$tradenum]['close'] = 0;
		$data['a'][$tradenum]['timeclose'] = 0;
		$data['a'][$tradenum]['result'] = 0;
		$data['a'][$tradenum]['resultbool'] = 0;
		$data['result'] = $result;
		//return $data;
		return view('oflinepage')->with('data' ,$data);
    }

    private function doublemacd(){
    	$sleepcount = 0;
    	$negcount =0;
    	$poscount =0;
    	$sumhisto = 1000;
    	$limitclose = 0;
    	$maxhisto = 100;
    	$highlimitpercent = 0.03;
    	$lowlimitpercent = 0.02;
    	$sum = 0;
    	$hissmalpos = 2;
    	$halfclose = 0;
    	$tradeleft = 1;
    	$intrade = 0;
    	$starttrade = 0 ;
    	$finishtrade = 0 ;
    	$highlimitprice = 0;
    	$lowlimitprice = 0;
    	$offset = 0;
    	$limit = 5000;
    	$position = 'short';
    	$high = 0;
    	$low = 10000000;
    	$tradenum = -1 ;
		$tradeflag = 0 ;
		$count = 0;
		$lasttraderesult=0;
		while($offset < 365*12*24){
		$candles = Oflinecandle::where('interval' , '5m')->where('symbol' , 'BTC1Y')->orderby('start')->offset($offset)->limit ($limit)->get();
			$offset = $offset + $limit;
    	foreach ($candles as $candle){ 
    		if($starttrade == 1){
    			$data['a'][$tradenum]['open'] = $candle['open'];
    			if($data['a'][$tradenum]['type'] == 'Long'){
    				$highlimitprice =$data['a'][$tradenum]['open'] + $highlimitpercent * $data['a'][$tradenum]['open'];
    				$lowlimitprice = $data['a'][$tradenum]['open'] - $lowlimitpercent * $data['a'][$tradenum]['open'];
    			}
    			else{
					$highlimitprice = $data['a'][$tradenum]['open'] + $lowlimitpercent * $data['a'][$tradenum]['open'];
    				$lowlimitprice = $data['a'][$tradenum]['open'] - $highlimitpercent * $data['a'][$tradenum]['open'];
    			}
    		}
    		/*if($halfclose){
    			$data['a'][$tradenum-1]['close'] = $candle['open'];
    			$data['a'][$tradenum-1]['result'] = ($data['a'][$tradenum-1]['close']-$data['a'][$tradenum-1]['open'])/$data['a'][$tradenum-1]['open'];
    			if($data['a'][$tradenum-1]['type'] == 'Short')
    				$data['a'][$tradenum-1]['result']=-1 *$data['a'][$tradenum-1]['result'];
    			$sum = $sum + $data['a'][$tradenum-1]['result'] * $data['a'][$tradenum-1]['percent'];
    		}*/
    		$starttrade = 0 ;
    		$finishtrade = 0;
    		$halfclose = 0;
    		$limitclose = 0;
			$histogram =($candle['ema24'] - $candle['ema52']) - $candle['signal18'];
			if($intrade){
				//$hissmal = ($candle['ema6'] - $candle['ema13']) - $candle['signal5'];
				if($histogram < $maxhisto / 100000 && $position == 'long'){
					$finishtrade = 1;
					$data['a'][$tradenum]['high'] = $high;
					$data['a'][$tradenum]['low'] = $low;
					$data['a'][$tradenum]['percent'] = $tradeleft;
					$data['a'][$tradenum]['timeclose'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
					$intrade = 0 ;
				}
    			else if ($histogram > -1 * $maxhisto / 10000 && $position == 'short'){
					$finishtrade = 1;
					$data['a'][$tradenum]['high'] = $high;
					$data['a'][$tradenum]['low'] = $low;
					$data['a'][$tradenum]['percent'] = $tradeleft;
					$data['a'][$tradenum]['timeclose'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
					$intrade = 0 ;
    			}
    			/*else if( $tradeleft > 1 && $hissmal < 0 && $position == 'long' && $hissmalpos == 1){
    				$halfclose = 1;
    				$tradeleft = $tradeleft-0.2;
					$data['a'][$tradenum]['high'] = $high;
					$data['a'][$tradenum]['low'] = $low;
					$data['a'][$tradenum]['percent'] = 0.2;
					$data['a'][$tradenum]['timeclose'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
					$tradenum++;
					$data['a'][$tradenum]['type'] = 'Long';
					$data['a'][$tradenum]['timeopen'] = $data['a'][$tradenum-1]['timeopen'];
					$data['a'][$tradenum]['open'] = $data['a'][$tradenum-1]['open'];
    			}
    			else if( $tradeleft > 1 && $hissmal > 0 && $position == 'short' && $hissmalpos == 0){
    				$halfclose = 1;
    				$tradeleft = $tradeleft-0.2;
					$data['a'][$tradenum]['high'] = $high;
					$data['a'][$tradenum]['low'] = $low;
					$data['a'][$tradenum]['percent'] = 0.2;
					$data['a'][$tradenum]['timeclose'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
					$tradenum++;
					$data['a'][$tradenum]['type'] = 'Short';
					$data['a'][$tradenum]['timeopen'] = $data['a'][$tradenum-1]['timeopen'];
					$data['a'][$tradenum]['open'] = $data['a'][$tradenum-1]['open'];
    			}*/
    			else if ($candle['high'] > $highlimitprice && $tradeleft > 0){
    				if($high < $candle['high'])
    					$high = $candle['high'];
    				if($low > $candle['low'])
    					$low = $candle['low'];
    				$limitclose= 1;
					$data['a'][$tradenum]['high'] = $high;
					$data['a'][$tradenum]['low'] = $low;
					$data['a'][$tradenum]['percent'] = $tradeleft;
					$data['a'][$tradenum]['close'] = $highlimitprice;
					$data['a'][$tradenum]['timeclose'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
					$tradeleft = 0;
					$intrade = 0 ;
    			}
    			else if ($candle['low'] < $lowlimitprice && $tradeleft > 0){
    				if($high < $candle['high'])
    					$high = $candle['high'];
    				if($low > $candle['low'])
    					$low = $candle['low'];
    				$limitclose= 1;
					$data['a'][$tradenum]['high'] = $high;
					$data['a'][$tradenum]['low'] = $low;
					$data['a'][$tradenum]['percent'] = $tradeleft;
					$data['a'][$tradenum]['close'] = $lowlimitprice;
					$data['a'][$tradenum]['timeclose'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
					$tradeleft = 0;
					$intrade = 0 ;
    			}
    			/*if($hissmal > 0)
    				$hissmalpos=1;
    			else
    				$hissmalpos = 0;*/
    		}
    		if($finishtrade == 1){
  				$data['a'][$tradenum]['close'] = $candle['close'];
  				$data['a'][$tradenum]['result'] = ($data['a'][$tradenum]['close']-$data['a'][$tradenum]['open'])/$data['a'][$tradenum]['open'];
    			if($data['a'][$tradenum]['type'] == 'Short')
    				$data['a'][$tradenum]['result']=-1 *$data['a'][$tradenum]['result'];
    			if($data['a'][$tradenum]['sleep'] == 0){
    				if($data['a'][$tradenum]['result']>0)
    					$poscount++;
    				else
    					$negcount++;
    				$sum = $sum + $data['a'][$tradenum]['result'] * $data['a'][$tradenum]['percent'];
    			}
    		}
    		if($limitclose==1){
  				$data['a'][$tradenum]['result'] = ($data['a'][$tradenum]['close']-$data['a'][$tradenum]['open'])/$data['a'][$tradenum]['open'];
    			if($data['a'][$tradenum]['type'] == 'Short')
    				$data['a'][$tradenum]['result']=-1 *$data['a'][$tradenum]['result'];
    			if($data['a'][$tradenum]['sleep'] == 0){
    				if($data['a'][$tradenum]['result']>0)
    					$poscount++;
    				else
    					$negcount++;
    				$sum = $sum + $data['a'][$tradenum]['result'] * $data['a'][$tradenum]['percent'];
    			}
    		}
			if(!$intrade){
			if($histogram > 0 && $position != 'long'){
    			$count++;
    			$tradenum++;
    			$data['a'][$tradenum]['sleep'] = 0;
    			if($tradenum > 2)
    				if($data['a'][$tradenum-1]['result'] > 0.010 || 0){
    					$sleepcount ++;
						$data['a'][$tradenum]['sleep'] = 1;
					}
				$data['a'][$tradenum]['type'] = 'Long';
				$starttrade = 1;
				$data['a'][$tradenum]['timeopen'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
				$position = 'long';
				$high = 0;
				$low = 10000000;
				$intrade = 1;
				$tradeleft = 1;
				$hissmalpos = 2;
				$maxhisto = 0;
				$sumhisto = 0;
			}
    		else if ($histogram < 0 && $position != 'short'){
    			$count++;
    			$tradenum++;
    			$data['a'][$tradenum]['sleep'] = 0;
    			if($tradenum > 0){
    				if($data['a'][$tradenum-1]['result'] > 0.010 || 0){
    					$sleepcount ++;
						$data['a'][$tradenum]['sleep'] = 1;
					}
				}
    			$data['a'][$tradenum]['type'] = 'Short';
				$starttrade = 1;;
				$data['a'][$tradenum]['timeopen'] = date('m/d/Y H:i:s', ($candle['start']+5)*60 + 4.5*60*60);
				$position = 'short';
				$high = 0;
				$low = 10000000;
				$intrade = 1;
				$tradeleft = 1;
				$hissmalpos = 2;
				$maxhisto = 0;
				$sumhisto = 0;
				
    		}
    		}
    		if($high < $candle['high'])
    			$high = $candle['high'];
    		if($low > $candle['low'])
    			$low = $candle['low'];
    		if($maxhisto < abs($histogram))
    			$maxhisto = abs($histogram);
    		$sumhisto += abs($histogram);
    	}
		}
		if($tradenum != -1){
			$data['a'][$tradenum]['high'] = 0;
			$data['a'][$tradenum]['low'] = 0;
			$data['a'][$tradenum]['close'] = 0;
			$data['a'][$tradenum]['timeclose'] = 0;
			$data['a'][$tradenum]['percent'] = 0;
			$data['a'][$tradenum]['result'] = 0;
			$data['sum']=$sum;
			$data['count']=$count;
			$data['poscount']=$poscount;
			$data['negcount']=$negcount;
			$data['sleepcount'] = $sleepcount;
		}
		//return $data;
		return view('dubmacd')->with('data' ,$data);
	}

	private function order($symbol ,$side , $positionSide , $type , $quantity , $reduceOnly ,$price){

	}
}
