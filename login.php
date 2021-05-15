<?php
include_once dirname(__FILE__) . '/config.php';
include_once dirname(__FILE__) . '/connect.php';

error_reporting(~E_NOTICE);
$user_login = addslashes(trim($_POST['user_login']));
$pwd_login = addslashes(trim($_POST['pwd_login']));
$hashpass = hash_hmac('md5', $pwd_login, '/x!a@r-$r%an¨.&e&+f*f(f(a)');
if(isset($_POST['user_login']) and isset($_POST['pwd_login'])) {
?>
<?php 
if(isset($_POST["button"]))	
if ($_POST["button"] == "เข้าสู่ระบบ") {
if(trim($_POST["user_login"] && ($_POST["pwd_login"])) == "" ) 
{
?>
<script type="text/javascript">
localStorage.setItem("swal",
swal(
  'Do not leave empty!',
  'Tidak boleh kosong',
  'error'
)
</script>
<?php
}
?>

<?php
$result = pg_query("select login,password from accounts where login='$user_login' and password='$hashpass' "); 
$num = pg_num_rows($result) ;
?>

<?php
if($num <=0 ) 
{
?>
<script type="text/javascript">
swal(
  'Username or Password Invalid!',
  'Username atau kata sandi salah',
  'error'
)
</script>
<?php
}else{
$_SESSION['login_true'] = $_POST['user_login'];
?>
<script type="text/javascript">
swal(
  'Success!',
  'Berhasil masuk!',
  'success'
)
</script>
<?php
echo "<meta http-equiv='refresh' content='2 ;url=./?page=home'>";
}}}
?>
<form class="form-horizontal" method="post">
    <div class="form-group">
		
<div class="row" style="margin-top: 10px;">
  		<div class="col-md-8">
		  	<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
		<b><i class="fa fa-users"></i> MEMBER SYSTEM</b> <small></small>
	</div>
			
	<div class="card-body">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<form id="login-form">
					<input type="hidden" name="action" value="login">
					<div class="form-group">
						<label for="username"><i class="fa fa-user"></i> Username :</label>
						<input type="text" class="form-control" placeholder="Username" name="user_login" id="user_login">
					</div>
					<div class="form-group">
						<label for="password"><i class="fa fa-lock"></i> Password :</label>
						<input type="password" class="form-control" placeholder="Password" id="pwd_login" name="pwd_login">
					</div>
				</form>
			
				<button type="submit" name="button" class="btn btn-success btn-block " value="เข้าสู่ระบบ"><i class="fa fa-sign-in hvr-icon"></i> Login</button>
				<a class="btn btn-danger btn-block " href="index.php?page=register"><i class="fa fa-user-plus hvr-icon"></i> Register</a>
			</div>
		</div>
	</div>
</form>	</div>
		
