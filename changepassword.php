<?php
function encripitar($pass){
    $salt = '/x!a@r-$r%an¨.&e&+f*f(f(a)';
    $output = hash_hmac('md5', $pass, $salt);
    return $output;
}

if (!isset($_SESSION['login_true'])) {
echo "<script>alert('Silakan login terlebih dahulu!');</script><script>window.location = 'index.php';</script>";
exit;
}


if(@$_POST['go']){
		$username = $_SESSION['login_true'];
		$password = $_POST['oldpassword'];
		$pass = $_POST['oldpass'];
		$npassword = $_POST['newpassword'];
		$rpassword = $_POST['rpassword'];
		$captchacorrect = $_SESSION['cap_code'];

		$sql = "SELECT * FROM accounts WHERE login = '$username' ";
		$query = pg_query($sql);
		$numrows = pg_num_rows($query);

		while ($rows = pg_fetch_array($query)){
			$dbuser = $rows['login'];
			$dbpassword = $rows['password'];
		}

		if ($pass == '' || $npassword == '' || $rpassword == ''){
			?>
<script type="text/javascript">
swal(
  'Error !',
  'Silakan lengkapi semua informasi!',
  'error'
)
</script>
<?php
echo "<meta http-equiv='refresh' content='2 ;url=index.php?page=password'>";
		}elseif ($npassword != $rpassword){
		
			?>
<script type="text/javascript">
swal(
  'Error !',
  'Konfirmasi kata sandi tidak cocok!',
  'error'
)
</script>
<?php
echo "<meta http-equiv='refresh' content='2 ;url=index.php?page=password'>";
		}elseif (encripitar($pass) != $dbpassword){
			?>
<script type="text/javascript">
swal(
  'Error !',
  'Kata sandi lama salah!',
  'error'
)
</script>
<?php
echo "<meta http-equiv='refresh' content='2 ;url=index.php?page=password'>";
		}elseif ($key != $dbkey){
			?>
<script type="text/javascript">
swal(
  'Error !',
  'Kata sandi baru Anda sama dengan kata sandi lama!',
  'error'
)
</script>
<?php
echo "<meta http-equiv='refresh' content='2 ;url=index.php?page=password'>";
		}else{
			$encryptpass = encripitar($npassword);

			pg_query("UPDATE accounts SET password = '$encryptpass' WHERE login = '$username'");
			session_destroy();
			?>
<script type="text/javascript">
swal(
  'Success !',
  'Kata sandi berhasil diubah!',
  'success'
)
</script>
<?php
echo "<meta http-equiv='refresh' content='2 ;url=index.php?page=home'>";

		}
}
?>
<div class="row" style="margin-top: 10px;">
  		<div class="col-md-8">
		  	<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
		<b><i class="fa fa-lock"></i> PASSWORD</b> <small></small>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<form name="submit" " method="post">
					<input type="hidden" name="action" value="changepassword">
					<div class="form-group">
						<label for="oldpass"><i class="fa fa-lock"></i> Old Password :</label>
						<input class="form-control " type="password" name="oldpass" id="oldpass" placeholder="Kata sandi saat ini" autofocus>
					</div>
					<div class="form-group">
						<label for="newpass"><i class="fa fa-key"></i> New Password :</label>
						<input class="form-control " type="password" name="newpassword" id="newpassword" placeholder="Kata sandi baru"><p></p>
						<input class="form-control " type="password" name="rpassword" id="rpassword" placeholder="Ulangin kata sandi baru">
					</div>
					<button name="go" id="btn_change_password" type="submit" class="btn btn-danger btn-block " value="เUbah kata sandi"><i class="fa fa-cog hvr-icon"></i> Ubah kata sandi</button>
				
				</form>
			</div>
		</div>
	</div>
</div>	 