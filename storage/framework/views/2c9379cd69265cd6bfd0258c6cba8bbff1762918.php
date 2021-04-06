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
					<?php echo e($data['robot']['robot_id']); ?>

				</td>
				<td>
					<?php echo e($data['robot']['small']); ?>

				</td>
				<td>
					<?php echo e($data['robot']['big']); ?>

				</td>
				<td>
					<?php echo e($data['robot']['signal']); ?>

				</td>
				<td>
					<?php echo e($data['robot']['interval']); ?>

				</td>
				<td>
					<?php echo e($data['robot']['symbol']); ?>

				</td>
				<td>
					<?php echo e($data['robot']['position']); ?>

				</td>
				<td>
					<?php echo e($data['robot']['coin']); ?>

				</td>
				<td>
					<?php echo e($data['robot']['dollar']); ?>

				</td>
				<td>
					<?php echo e($data['robot']['limit']); ?>

				</td>
				<td>
					<?php echo e($data['robot']['smoothing']); ?>

				</td>
				<td>
					<?php echo e($data['robot']['state']); ?>

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
			<?php $__currentLoopData = $data['macdtrades']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td>
						<?php echo e($trade['tradelist_id']); ?>

					</td>
					<td>
						<?php echo e($trade['price']); ?>

					</td>
					<td>
						<?php echo e($trade['type']); ?>

					</td>
					<td>
						<?php echo e($trade['histogram']); ?>

					</td>
					<td>
						<?php echo e($trade['balance']); ?>

					</td>
					<td>
						<?php echo e($trade['time']); ?>

					</td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>
		<a href="../off/<?php echo e($data['robot']['robot_id']); ?>"><div class="button off">Off</div></a>
		<a href="../on/<?php echo e($data['robot']['robot_id']); ?>"><div class="button on">On</div></a>
		<a href="../remove/<?php echo e($data['robot']['robot_id']); ?>"><div class="button remove">remove</div></a><br>
		<?php $__currentLoopData = $data['list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $robot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<a href="../robot/<?php echo e($robot['robot_id']); ?>"><?php echo e($robot['robot_id']); ?></a>&nbsp;&nbsp;
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<a href="../newrobot">New Robot</a>

	</center>
</div><?php /**PATH C:\xampp\htdocs\trade\resources\views/tradepage.blade.php ENDPATH**/ ?>