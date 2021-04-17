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
			</tr>
			<?php $__currentLoopData = $data['a']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td>
						<?php echo e($trade['type']); ?>

					</td>
					<td>
						<?php echo e($trade['open']); ?>

					</td>
					<td>
						<?php echo e($trade['close']); ?>

					</td>
					<td>
						<?php echo e($trade['high']); ?>

					</td>
					<td>
						<?php echo e($trade['low']); ?>

					</td>
					<td>
						<?php echo e($trade['timeopen']); ?>

					</td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>

	</center>
</div><?php /**PATH C:\xampp\htdocs\trade\resources\views/oflinepage.blade.php ENDPATH**/ ?>