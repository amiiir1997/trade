<style>
	.body {
		margin : 5%;
		padding: 2%;
		border:dashed;
		border-color: #aaa;
	}
	.table{
		width :90%;
		margin-bottom: 2%;
		border-collapse: collapse;

	}
	th ,td {
		border :1px solid #aaa;
		text-align: center;
	}
	.button {
		text-align: center;
		vertical-align: center;
		width: 7%;
		height: 3%;
		border-radius: 1vw;
		margin-bottom: 0.5%;
		}
	.off{
		background-color: #d00;
	}
	.on{
		background-color: #0d0;
	}
	.remove{
		background-color: #00d;
		color : #fff;
	}
	.green {
		background-color: #0F0;
	}
	.red {
		background-color: #F00;
	}
	.sleep {
		background-color: #ccc;
	}
</style>
<div class="body">
	<center>
		{{$data['count']}}-------------->{{$data['sum']}}-----------<span class="green">{{$data['poscount']}}</span>-----------<span class="red">{{$data['negcount']}}</span>-----------<span>{{$data['sleepcount']}}</span>
		<table class="table">
			<tr>
				<th>
					time open
				</th>
				<th>
					time close
				</th>
				<th>
					open
				</th>
				<th>
					close
				</th>
				<th>
					high
				</th>
				<th>
					low
				</th>
				<th>
					%
				</th>
				<th>
					result
				</th>
				<th>
					type
				</th>
			</tr>
			@foreach ($data['a'] as $trade)
				<tr class = @if ($trade['sleep'] == 1) 'sleep' @endif>
					<td>
						{{$trade['timeopen']}}
					</td>
					<td>
						{{$trade['timeclose']}}
					</td>
					
					<td>
						{{$trade['open']}}
					</td>
					<td>
						{{$trade['close']}}
					</td>
					<td>
						{{$trade['high']}}
					</td>
					<td>
						{{$trade['low']}}
					</td>
					<td>
						{{$trade['percent']}}
					</td>
					<td class = @if ($trade['result'] > 0) 'green' @else 'red' @endif>
						{{$trade['result']}}
					</td>
					<td>
						{{$trade['type']}}
					</td>
				</tr>
			@endforeach
		</table>

	</center>
</div>