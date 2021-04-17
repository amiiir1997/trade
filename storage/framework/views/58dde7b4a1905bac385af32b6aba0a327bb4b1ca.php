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
		<?php echo e($data['count']); ?>--------------><?php echo e($data['sum']); ?>-----------<span class="green"><?php echo e($data['poscount']); ?></span>-----------<span class="red"><?php echo e($data['negcount']); ?></span>-----------<span><?php echo e($data['sleepcount']); ?></span>
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
			<?php $__currentLoopData = $data['a']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr class = <?php if($trade['sleep'] == 1): ?> 'sleep' <?php endif; ?>>
					<td>
						<?php echo e($trade['timeopen']); ?>

					</td>
					<td>
						<?php echo e($trade['timeclose']); ?>

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
						<?php echo e($trade['percent']); ?>

					</td>
					<td class = <?php if($trade['result'] > 0): ?> 'green' <?php else: ?> 'red' <?php endif; ?>>
						<?php echo e($trade['result']); ?>

					</td>
					<td>
						<?php echo e($trade['type']); ?>

					</td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>

	</center>
</div><?php /**PATH /var/www/html/trade/resources/views/dubmacd.blade.php ENDPATH**/ ?>