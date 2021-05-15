<?php
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

error_reporting(~E_NOTICE);
$user_login = addslashes(trim($_POST['user_login']));
$pwd_login = addslashes(trim($_POST['pwd_login']));
$hashpass = hash_hmac('md5', $pwd_login, $config['md5_salt']);

if(isset($_POST['user_login']) and isset($_POST['pwd_login'])) {

?>
<?php 
if (!isset($config)){exit;}
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
echo "<meta http-equiv='refresh' content='1 ;url=./?page=download'>";
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
  'Email atau kata sandi salah',
  'error'
)
</script>
<?php
echo "<meta http-equiv='refresh' content='1 ;url=./?page=download'>";
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
echo "<meta http-equiv='refresh' content='1 ;url=./?page=download'>";
}}}
?>
<?php
if(isset($_POST["button"]))	
{	
if ($_POST["button"] == "Memperbaiki akun terdaftar")
{
	pg_query("UPDATE accounts SET online = false WHERE login = '".$_SESSION['login_true']."'");
?>
<script type="text/javascript">
swal(
  'Success!',
  'เBerhasil menyelesaikan akun terdaftar!',
  'success'
)
</script>
<?php
echo "<meta http-equiv='refresh' content='1 ;url=./?page=download'>";
}}
?>
<?php
if(isset($_POST["button2"]))	
{	
if ($_POST["button2"] == "Edit ID Bug")
{
	
	pg_query("UPDATE accounts SET player_id='".$Random."' WHERE login = '".$_SESSION['login_true']."'");
	pg_query("UPDATE friends SET owner_id='".$Random."' WHERE owner_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE friends SET friend_id='".$Random."' WHERE friend_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE player_bonus SET player_id='".$Random."' WHERE player_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE player_configs SET owner_id='".$Random."' WHERE owner_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE player_events SET player_id='".$Random."' WHERE player_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE player_items SET owner_id='".$Random."' WHERE owner_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE player_messages SET owner_id='".$Random."' WHERE owner_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE player_missions SET owner_id='".$Random."' WHERE owner_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE player_titles SET owner_id='".$Random."' WHERE owner_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE nick_history SET player_id='".$Random."' WHERE player_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE clan_data SET owner_id='".$Random."' WHERE owner_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE clan_invites SET player_id='".$Random."' WHERE player_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE webshop_log SET player_id='".$Random."' WHERE player_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE web_promotion_log SET player_id='".$Random."' WHERE player_id ='".$dbarr['player_id']."'");
	pg_query("UPDATE history_topup SET player_id='".$Random."' WHERE player_id ='".$dbarr['player_id']."'");
?>
<script type="text/javascript">
swal(
  'Success!',
  'เแก้ไขไอดีบัคสำเร็จ!',
  'success'
)
</script>
<?php
echo "<meta http-equiv='refresh' content='1 ;url=./?page=register'>";
}}
?>
<script type='text/javascript'>
function check_email(elm){
    var regex_email=/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*\@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.([a-zA-Z]){2,4})$/
    if(!elm.value.match(regex_email)){
        alert('Silakan masukkan alamat email yang valid');
    }else{

}
}
</script>
				<div class="row" style="margin-top: 10px;">
  		<div class="col-md-8">
		  	<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
		<b><i class="fa fa-user-plus"></i> REGISTER</b> <small></small>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6 offset-md-3">
			
					<form method="post" action="saveregister.php">
					<div class="form-group">
						<label for="username"><i class="fa fa-user"></i> Username :</label>
					
						<input style="margin-top: 0px;" type="txt" class="form-control" id="txtUsername" name="txtUsername" placeholder="Username">
					</div>
					<div class="form-group">
						<label for="password"><i class="fa fa-lock"></i> Password :</label>
						<input style="margin-top: 0px;" type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Password">
					</div>
					<div class="form-group">
						<label for="re_password"><i class="fa fa-lock"></i> Re-Password :</label>
						<input style="margin-top: 0px;" type="password" class="form-control" id="txtConPassword" name="txtConPassword" placeholder="Ulangin password">
					</div>
					<div class="form-group">
						<label for="email"><i class="fa fa-envelope"></i> E-mail :</label>
						<input style="margin-top: 0px;" type="txt" class="form-control" onblur="check_email(this)" id="email" name="email" placeholder="Email">
					</div>
					<div class="form-group">
						<label for="captcha"><i class="fa fa-lock"></i> Captcha : <img src="captcha.php" id="captcha" style="height: 25px"/></label>
						<input class="form-control " type="text" name="captcha" id="captcha" placeholder="Masukan kode captcha">
					</div>
				
			
				<input name="submit" type="submit" class="btn btn-danger btn-block" value="Register"/>
				</form>
			</div>
		</div>
	</div>
</div>


  			
