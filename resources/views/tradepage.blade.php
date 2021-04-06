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
					Robot_id
				</th>
				<th>
					Small
				</th>
				<th>
					Big
				</th>
				<th>
					Signal
				</th>
				<th>
					Interval
				</th>
				<th>
					Symbol
				</th>
				<th>
					Position
				</th>
				<th>
					Coin
				</th>
				<th>
					Dollar
				</th>
				<th>
					Limit
				</th>
				<th>
					Smoothing
				</th>
				<th>
					State
				</th>
			</tr>
			<tr>
				<td>
					{{$data['robot']['robot_id']}}
				</td>
				<td>
					{{$data['robot']['small']}}
				</td>
				<td>
					{{$data['robot']['big']}}
				</td>
				<td>
					{{$data['robot']['signal']}}
				</td>
				<td>
					{{$data['robot']['interval']}}
				</td>
				<td>
					{{$data['robot']['symbol']}}
				</td>
				<td>
					{{$data['robot']['position']}}
				</td>
				<td>
					{{$data['robot']['coin']}}
				</td>
				<td>
					{{$data['robot']['dollar']}}
				</td>
				<td>
					{{$data['robot']['limit']}}
				</td>
				<td>
					{{$data['robot']['smoothing']}}
				</td>
				<td>
					{{$data['robot']['state']}}
				</td>
			</tr>
		</table>
		<table class="table">
			<tr>
				<th>
					Tradelist_id
				</th>
				<th>
					Price
				</th>
				<th>
					Type
				</th>
				<th>
					Histogram
				</th>
				<th>
					Balance
				</th>
				<th>
					Time
				</th>
			</tr>
			@foreach ($data['macdtrades'] as $trade)
				<tr>
					<td>
						{{$trade['tradelist_id']}}
					</td>
					<td>
						{{$trade['price']}}
					</td>
					<td>
						{{$trade['type']}}
					</td>
					<td>
						{{$trade['histogram']}}
					</td>
					<td>
						{{$trade['balance']}}
					</td>
					<td>
						{{$trade['time']}}
					</td>
				</tr>
			@endforeach
		</table>
		<a href="../off/{{$data['robot']['robot_id']}}"><div class="button off">Off</div></a>
		<a href="../on/{{$data['robot']['robot_id']}}"><div class="button on">On</div></a>
		<a href="../remove/{{$data['robot']['robot_id']}}"><div class="button remove">remove</div></a><br>
		@foreach ($data['list'] as $robot)
			<a href="../robot/{{$robot['robot_id']}}">{{$robot['robot_id']}}</a>&nbsp;&nbsp;
		@endforeach
		<a href="../newrobot">New Robot</a>

	</center>
</div>