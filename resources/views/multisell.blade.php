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
</style>
<div class="body">
	<center>
		<table class="table">
			<tr>
				<th>
					type
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
					time open
				</th>
				<th>
					time close
				</th>
				<th>
					%
				</th>
			</tr>
			@foreach ($data['a'] as $trade)
				@foreach ($trade['close'] as $close)
				<tr>
					<td>
						{{$trade['type']}}
					</td>
					<td>
						{{$trade['open']}}
					</td>
					<td>
						{{$close['close']}}
					</td>
					<td>
						{{$trade['high']}}
					</td>
					<td>
						{{$trade['low']}}
					</td>
					<td>
						{{$trade['timeopen']}}
					</td>
					<td>
						{{$close['timeclose']}}
					</td>
					<td>
						{{ ($loop->index +1)}}
					</td>
				</tr>
				@endforeach
			@endforeach
		</table>

	</center>
</div>