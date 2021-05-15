<?php
session_start();
include_once dirname(__FILE__) . '/config.php';
include_once dirname(__FILE__) . '/connect.php';

function encripitar($pass){
    $salt = '/x!a@r-$r%an¨.&e&+f*f(f(a)';
    $output = hash_hmac('md5', $pass, $salt);
    return $output;
}

function GenerateRandomString($length = 40) 
{
	return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/=+', ceil($length/strlen($x)) )),1,$length);
}
$Random = GenerateRandomString(40);

function getRealIpAddr(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

$result = pg_query("SELECT * FROM accounts");// Limite de email por contas
$num_rows = pg_num_rows($result);
$_SESSION['id'] = $num_rows + 1;
$captcha = $_POST['captcha'];
$captchacorrect = $_SESSION['cap_code'];
$ip = getRealIpAddr();

//$result3 = pg_query("SELECT * FROM accounts WHERE lastip='".$ip."'");
//$num_rows2 = pg_num_rows($result3);
$redrirac = "index.php?page=register";

	if(trim($_POST["txtUsername"]) == ""){
		echo("<script> alert('Isi semua informasi!');</script><script>window.location='".$redrirac."';</script>");
		exit();	
	}elseif(trim($_POST["txtPassword"]) == ""){
		echo("<script> alert('Isi semua informasi.!');</script><script>window.location='".$redrirac."';</script>");
		exit();	
	}elseif(trim($_POST["txtConPassword"]) == ""){
		echo("<script> alert('Isi semua informasi!');</script><script>window.location='".$redrirac."';</script>");
		exit();	
	}elseif(trim($_POST["email"]) == ""){
		echo("<script> alert('Isi semua informasi!');</script><script>window.location='".$redrirac."';</script>");
		exit();	
	}elseif(trim($_POST["captcha"]) == ""){
		echo("<script> alert('Isi semua informasi!');</script><script>window.location='".$redrirac."';</script>");
		exit();	
	}elseif($_POST["txtPassword"] != $_POST["txtConPassword"]){
		echo("<script> alert('Kata sandi tidak cocok!');</script><script>window.location='".$redrirac."';</script>");
		exit();	
	}elseif (trim($_POST['captcha']) != $_SESSION['cap_code']){
		echo "<script>alert('Kode Captcha Salah !');</script><script>window.location='".$redrirac."';</script>";
		exit();
	}else{
		$strSQL5 = "SELECT * FROM accounts WHERE email = '".trim($_POST["email"])."' ";// Verifica email
		$objQuery5 = pg_query($strSQL5);
		$objResult5 = pg_fetch_array($objQuery5);
		if($objResult5){
			echo("<script> alert('Email ini sudah digunakan.!');</script><script>window.location='".$redrirac."';</script>");
			exit();
		}else{
			$strSQL = "SELECT * FROM accounts WHERE login = '".trim($_POST['txtUsername'])."' "; // Verifica  ID
			$objQuery = pg_query($strSQL);
			$objResult = pg_fetch_array($objQuery);
			if($objResult){
				echo("<script> alert('Username telah digunakan!');</script><script>window.location='".$redrirac."';</script>");
				exit();
			}else{	
				$strSQL = "INSERT INTO accounts (login,password,email,token) VALUES ('".$_POST["txtUsername"]."','".encripitar($_POST["txtPassword"])."','".$_POST["email"]."','".encripitar($_POST["txtPassword"])."')";   //Alterar Cash e Gold inicial //Change cash and gold
				$objQuery = pg_query($strSQL);
		
				$_SESSION['username'] = $_POST['txtUsername'];
				
				echo "<script>alert('Akun berhasil dibuat');</script><script>window.location='index.php?page=home';</script>";
			}
		}
	}
	
	pg_close();
?>
