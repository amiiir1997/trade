<style>
	.body {
		margin : 5%;
		padding: 2%;
		border:dashed;
		border-color: #aaa;
		width :40%;
		height: 40%;
	}
	input{
		width : 40%;
		height: 9%;
		margin-right: 10%;
		float : right;

	}
	label{
		margin-right: auto;
		width : 40%;
		height: 9%;
		margin-left: 10%;
		float: left;
	}

</style>
<center>
	<div class="body">
		<form action='./newrobotexecute' method="get">
			<label>small:</label>
			<input type="text" value = '12' name="small"><br>
			<label>big:</label>
			<input type="text" value = '26' name="big"><br>
			<label>signal:</label>
			<input type="text" value = '9' name="signal"><br>
			<label>limit:</label>
			<input type="text" value = '200' name="limit"><br>
			<label>interval:</label>
			<input type="text" value = '5m' name="interval"><br>
			<label>smoothing:</label>
			<input type="text" value = '2' name="smoothing"><br>
			<label>coin:</label>
			<input type="text" value = '0' name="coin"><br>
			<label>dollar:</label>
			<input type="text" value = '1000'  name="dollar"><br>
			<label>symbol:</label>
			<input type="text" value = 'BTCUSDT' name="symbol"><br>
			<input type="submit" value='create'>
		</form>
	</div>
</center><?php /**PATH /var/www/html/trade/resources/views/NewMacdRobot.blade.php ENDPATH**/ ?>