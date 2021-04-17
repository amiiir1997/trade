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
</style>
<div class="body">
	<center>
		<table class="table">
			<tr>
				<th>
					time open
				</th>
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
			</tr>
			@foreach ($data['a'] as $trade)
				<tr>
					<td>
						{{$trade['timeopen']}}
					</td>
					<td>
						{{$trade['type']}}
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
				</tr>
			@endforeach
		</table>

	</center>
</div>