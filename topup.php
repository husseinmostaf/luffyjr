<?php
if (!isset($config)){exit;}
error_reporting(~E_NOTICE);
$result = pg_query("select * from accounts where login='$_SESSION[login_true]'") or die ("Err Can not to result");
$dbarr =pg_fetch_array($result);

$cPlayer = $connec->prepare('SELECT player_id FROM accounts');
$cPlayer->execute();
$countPlayer = $cPlayer->rowCount();

$cPlayer1 = $connec->prepare('SELECT player_id FROM accounts');
$cPlayer1->execute();
$countPlayer1 = $cPlayer1->rowCount();

$cPlayerOnline = $connec->prepare('SELECT player_id FROM accounts WHERE online = true');
$cPlayerOnline->execute();
$countPlayerOnline = $cPlayerOnline->rowCount();

function GenerateRandomString($length = 8) 
{
	return substr(str_shuffle(str_repeat($x='0123456789', ceil($length/strlen($x)) )),3,$length);
}
$Random = GenerateRandomString(8);

?>
<head>

<meta charset="UTF-8">
</head>
<?php
if(isset($_POST["button"]))	
{	
if ($_POST["button"] == "เติมเงิน")
{
$pay = pg_query("select * from web_history_topup where truemoney_pin='".$_POST["truemoney_pin"]."'");
$pg_fetch_array = pg_fetch_array($pay);

		if (strlen($_POST["truemoney_pin"]) < 14 || !is_numeric($_POST["truemoney_pin"])) {
		?>
		<script type="text/javascript">
		swal(
		'แจ้งเตือน',
		'กรอกรหัสบัตรทรูมันนี่ 14 หลักและเป็นตัวเลขเท่านั้น',
		'warning'
		)
		</script>
		<?php
		}else{
			$password = $_POST["truemoney_pin"];
			$curl = curl_init('' . $config['merchant'] . '&password=' . $password . '&resp_url=' . $config['resp_url']);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_TIMEOUT, 10);
			curl_setopt($curl, CURLOPT_HEADER, FALSE);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
			$curl_content = curl_exec($curl);
			if($curl_content === false)
			{
			    echo "false";
			}
			curl_close($curl);
			if(strpos($curl_content,'SUCCEED') !== FALSE)
			{
				$isTransaction = substr($curl_content, 8, 10);
			    $strSQL = "INSERT INTO web_history_topup( player_id, tranid, truemoney_pin, amount) VALUES( $dbarr[player_id], '$isTransaction', $password, 0)";
			    $objQuery = pg_query($strSQL);
				?>
				<script type="text/javascript">
				swal(
				'แจ้งเตือน',
				'ได้รับบัตรทรูมันนี่แล้ว กำลังตรวจสอบ...',
				'success'
				)
				</script>
				<?php
			}else{
				?>
				<script type="text/javascript">
				swal(
				'แจ้งเตือน',
				'<?php echo $curl_content;?>',
				'warning'
				)
				</script>
				<?php
			}
    }
}
}
?>
	<div class="row" style="margin-top: 10px;">
  		<div class="col-md-8">
		  	<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
		<b><i class="fa fa-money"></i> TOPUP</b> <small></small>
	</div>
	<div class="card-body">
		<div class="alert alert-warning" role="alert">
		</div>

		<form name="topup_truemoney" method="POST">
		</form>

		<table style="width: 100%;border: 1px solid #fff;">
			<thead class="text-center">
				<tr style="border-bottom: 1px solid #fff">
				<p>TOP-UP yang anda berikan akan membantu keberlangsungan server ini</p>
<p>2.000 coin = Rp5.000</p>
<p>8.000 coin = Rp10.000</p>
<p>12.000 coin = Rp15.000</p>
<p>15.000 coin = Rp20.000</p>
<p>20.000 coin = Rp25.000</p>
<p>50.000 coin = Rp100.000</p>
<p>Paket Clan Gunnery Gold = Rp100.000</p>
<p>Weapon Permanent Pilih salah 1 = Rp150.000</p>
</div>
<hr>
<h6>NB : Sebelum transfer konfirmasi GM terlebih dahulu.</h6>
<h6>WA : +62 821-6141-6577 </h6>
<table>
<h6>Format TOP-UP </h6>
<h6>Player ID :</h6>
<h6>Username :</h6>
<h6>Coin :</h6>
<h6>Bukti Transfer :</h6>
<h8>*Diproses paling lambat 1x24 jam setelah dana masuk ke GM*</h8>
<center><img src="dist/images/tf.png" alt="Bank BRI"></center>
</table>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="card text-white bg-dark shadowbox" align="left" style="margin-bottom: 10px;">
	<div class="card-body">
		            <thead>
		                <tr>

		                 
		                </tr>
		            </thead>

								<tbody>
  <?php
$strhistopup = "SELECT * FROM web_history_topup order by amount desc limit 10";
$qrtopup = pg_query($strhistopup);
$num = 1;

while ($rstopup = pg_fetch_array($qrtopup)) { 
$resulttopup = pg_query("select * from accounts where player_id='".$rstopup['player_id']."'");
$dbarrtopup =pg_fetch_array($resulttopup);
?>


								  </tr>
<?php $num++; } ?>
								</tbody>
		            <tbody>
		            		            </tbody>
		        </table>
	</div>
</div>

<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-body">
		<center>
		</center>
	</div>
</div>

<script type="text/javascript">
$(document).ready( function () {
    $('#topuphistory').DataTable();
} );
</script>	  
