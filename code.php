<?php
if(isset($_POST["button"]))	
{	
if ($_POST["button"] == "Tambahkan kode")
{
		$sql = "SELECT * FROM web_item_code WHERE code_name = '".$_POST["code"]."'";
		$query = pg_query($sql);
		$rows = pg_fetch_array($query);
		$row = pg_num_rows($query);
$strSQL = "SELECT * FROM web_item_code_log WHERE login = '".$_SESSION['login_true']."' AND code = '".$_POST["code"]."'";
$objQuery = pg_query($strSQL);
$objResult = pg_fetch_array($objQuery);
$numrows = pg_num_rows($objQuery);
$day = $rows['item_day']*86400;
if($_POST["code"]==""){
?>
<script type="text/javascript">
swal(
  'ERROR!',
  'Silakan masukkan kode redeem',
  'error'
)
</script>
<?php	
}
	else if($numrows==1){
?>
<script type="text/javascript">
swal(
  'ERROR!',
  'Anda telah menggunakan KODE REDEEM ini.!',
  'error'
)
</script>
<?php
echo "<meta http-equiv='refresh' content='1 ;url=index.php?page=itemcode'>";
	}
	else if($row==1){
?>
<script type="text/javascript">
swal(
  'SUCCESS!',
  'Selamat kamu mendapatkan <?php echo $rows['code_alert']; ?>',
  'success'
)
</script>
<?php
if($rows['type_code'] == '1'){
	$sqli = "SELECT * FROM player_items WHERE owner_id='".$dbarr['player_id']."' AND item_id = '".$rows['item_id']."'";
$iquery = pg_query($sqli);
$row_i = pg_fetch_array($iquery);
if($row_i['equip'] == '2'){
	?>
<script type="text/javascript">
swal(
  'ERROR!',
  'Item telah digunakan. Tidak dapat menggunakan kode redeem  ini!',
  'error'
)
</script>
<?php
}else if($row_i['equip'] == 3){
	?>
	<script type="text/javascript">
	swal(
		'ERROR!',
		'Anda sudah memiliki item ini. Tidak dapat menggunakan kode redeem ini lagi!',
		'error'
	)
	</script>
	<?php

}else{
		pg_query("INSERT INTO player_items (owner_id, item_id, item_name, count, category, equip) VALUES ('".$dbarr['player_id']."', '".$rows['item_id']."', '".$rows['item_name']."', '".$day."', '".$rows['item_category']."' , '1')");
		pg_query("INSERT INTO web_item_code_log (code, login, status) VALUES ('".$rows['code_name']."', '".$_SESSION['login_true']."', 1)"); 
		echo "<meta http-equiv='refresh' content='1 ;url=index.php?page=itemcode'>";
	}
/*
pg_query("INSERT INTO web_item_code_log (code, login, status) VALUES ('".$rows['code_name']."', '".$_SESSION['login_true']."', 1)"); 
pg_query("INSERT INTO player_items (owner_id, item_id, item_name, count, category, equip) VALUES ('".$dbarr['player_id']."', '".$rows['item_id']."', '".$rows['item_name']."', '".$day."', '".$rows['item_category']."' , '1')"); //ไอเทมในเกม
echo "<meta http-equiv='refresh' content='1 ;url=index.php?page=itemcode'>";*/
}else if($rows['type_code'] == '2'){
	pg_query("INSERT INTO web_item_code_log (code, login, status) VALUES ('".$rows['code_name']."', '".$_SESSION['login_true']."', 1)"); 
	pg_query("UPDATE accounts SET coin = coin+'".$rows['count_number']."' WHERE player_id = '".$dbarr['player_id']."'"); //Coin หน้าเว็บ
	echo "<meta http-equiv='refresh' content='1 ;url=index.php?page=itemcode'>";
}else if($rows['type_code'] == '3'){
	pg_query("INSERT INTO web_item_code_log (code, login, status) VALUES ('".$rows['code_name']."', '".$_SESSION['login_true']."', 1)"); 
	pg_query("UPDATE accounts SET money = money+'".$rows['count_number']."' WHERE player_id = '".$dbarr['player_id']."'"); //Cash ในเกม
	echo "<meta http-equiv='refresh' content='1 ;url=index.php?page=itemcode'>";
}else if($rows['type_code'] == '4'){
	pg_query("INSERT INTO web_item_code_log (code, login, status) VALUES ('".$rows['code_name']."', '".$_SESSION['login_true']."', 1)"); 
	pg_query("UPDATE accounts SET gp = gp+'".$rows['count_number']."' WHERE player_id = '".$dbarr['player_id']."'"); //Point ในเกม
	echo "<meta http-equiv='refresh' content='1 ;url=index.php?page=itemcode'>";
}else if($rows['type_code'] == '5'){
	pg_query("INSERT INTO web_item_code_log (code, login, status) VALUES ('".$rows['code_name']."', '".$_SESSION['login_true']."', 1)"); 
	pg_query("UPDATE accounts SET exp = exp+'".$rows['count_number']."' WHERE player_id = '".$dbarr['player_id']."'"); //EXP ในเกม
	echo "<meta http-equiv='refresh' content='1 ;url=index.php?page=itemcode'>";
}else if($rows['type_code'] == '6'){
	pg_query("INSERT INTO web_item_code_log (code, login, status) VALUES ('".$rows['code_name']."', '".$_SESSION['login_true']."', 1)"); 
	pg_query("UPDATE accounts SET coin_ip = coin_ip+'".$rows['count_number']."' WHERE player_id = '".$dbarr['player_id']."'"); //Gold ในเกม
	echo "<meta http-equiv='refresh' content='1 ;url=index.php?page=itemcode'>";
}

	}
  else{
?>
<script type="text/javascript">
swal(
  'ERROR!',
  'Redeem code tidak ada!',
  'error'
)
</script>
<?php
echo "<meta http-equiv='refresh' content='1 ;url=index.php?page=itemcode'>";	  
  }
}
}
?>
<div class="row" style="margin-top: 10px;">
  		<div class="col-md-8">
		  	<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
		<b><i class="fa fa-key"></i> Redeem code</b> <small></small>
	</div>
	<div class="card-body" style="padding: 10px;">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<form method="post">
					<input type="hidden" name="action" value="redeemcode">
					<div class="form-group">
						<input class="form-control " type="text" name="code" id="code" placeholder="Masukkan kode redeem">
					</div>
				
					<center><button type="submit" name="button" class="btn btn-success"  value="Tambahkan kode"><i class="fa fa-check hvr-icon"></i> Redeem</button></center>
				</form>
			</div>
		</div>
	</div>
</div>
