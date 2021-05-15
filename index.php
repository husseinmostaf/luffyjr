<?php
session_start();
include_once dirname(__FILE__) . '/config.php';
include_once dirname(__FILE__) . '/connect.php';
$result = pg_query("select * from accounts where login='".@$_SESSION[login_true]."'") or die ("Err Can not to result");
$dbarr = pg_fetch_array($result);

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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $config['web_title']; ?></title>
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/hover-min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/datatables.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/style.css">
	<link rel="icon" href="dist/images/favicon.ico">
	<meta charset="utf-8">
	<script src="https://www.google.com/recaptcha/api.js?hl=th"></script>
	<script src="dist/js/jquery-3.3.1.min.js"></script>
	<script src="dist/js/sweetalert2.min.js"></script>
	<script src="dist/js/bootstrap.min.js"></script>
	<script src="dist/js/datatables.min.js"></script>
	<script src="dist/js/custom.js?v=0.0001"></script>
	<meta name="author" content="Point Blank Redemption">
<meta name="keywords" content="PB RDM,RDM,Redemption,privateserver,private server 2019,private server 2020,Point Blank Redemption,game online">
<meta name="description" content="Point Blank Redemption di ciptakan untuk kalian apa bila bosa bermain point blank official">
</head>
<body>
<center>
	<div  style="margin-top: 100px;">
		<img src="dist/images/logo.png" class="img-fluid " width="500" height="500">
	</div>
</center>
<div class="container" style="margin-top: 150px;">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-top: 25px;">
	    <a class="navbar-brand" href="index.php?page=home"><?php echo $config['web_name']; ?></a>
	    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
	      	<span class="navbar-toggler-icon"></span>
	    </button>

	    <div class="navbar-collapse collapse" id="navbarColor01">
		    <ul class="navbar-nav mr-auto">
		        <li class="nav-item  ">
		          	<a class="nav-link" href="index.php?page=home"><i class="fa fa-home"></i> Home</a>
		        </li>
				<br>
				<?php
			if (!isset($_SESSION['login_true'])) { ?>
			<!-- ยังไม่ล็อคอิน -->
				 <li class="nav-item  ">
		          	<a class="nav-link" href="index.php?page=login"><i class="fa fa-sign-in"></i> Login</a>
		        </li>
		        <li class="nav-item  ">
		          	<a class="nav-link" href="index.php?page=register"><i class="fa fa-user-plus"></i> Register</a>
		        </li>
	<?php }else{?>
	<!-- ล็อคอินแล้ว -->

		        <li class="nav-item  ">
		          	<a class="nav-link" href="index.php?page=topup"><i class="fa fa-money"></i> Top-up</a>
		        </li>
	<?php }?>
		        						        <li class="nav-item  ">
		          	<a class="nav-link" href="index.php?page=rank.player"><i class="fa fa-bar-chart"></i> Ranking Player</a>
		        </li>
				  <li class="nav-item  ">
		          	<a class="nav-link" href="index.php?page=rank.clan"><i class="fa fa-university"></i> Ranking Clan</a>
		        </li>
		        <li class="nav-item ">
					<a class="nav-link" href="index.php?page=cmd"><i class="fa fas fa-cog"></i> Peraturan</a>
		        </li>
		        <li class="nav-item  ">
		          	<a class="nav-link" href="index.php?page=download"><i class="fa fa-cloud-download"></i> Download</a>
				</li>
		        <li class="nav-item ">
					<a class="nav-link" href="index.php?page=exp"><i class="fa fa-table"></i> Tabel EXP</a>
		        </li>
					<li class="nav-item ">
					<a class="nav-link" href="https://discord.gg/WXetN25kqN"><i class="fa fa-headphones"></i> Discord</a>
		        </li>
		    </ul>
	    </div>
  	</nav>
  	<?php if(@$_GET['page'] == "rank.player" ) {
    include("rankplayer.php");
    }else if(@$_GET['page'] == "rank.clan" ) {
    include("rankclan.php");
    }else if(@$_GET['page'] == "login" ) {
    include("login.php");
    }else if(@$_GET['page'] == "shop" ) {
    include("shop.php");
	 }else if(@$_GET['page'] == "cmd" ) {
    include("cmd.php");
    }else if(@$_GET['page'] == "logout" ) {
		include("logout.php");
	}else if(@$_GET['page'] == "sql_error" ) {
    include("sql_error.php");
    }else if(@$_GET['page'] == "register" ) {
    include("register.php");
	}else if(@$_GET['page'] == "download" ) {
    include("download.php");
	}else if(@$_GET['page'] == "topup" ) {
		include("topup.php");
	}else if(@$_GET['page'] == "ipbonus" ) {
		include("ipbonus.php");
	}else if(@$_GET['page'] == "pccafe" ) {
		include("pc_cafe.php");
	}else if(@$_GET['page'] == "promotion" ) {
    include("promotion.php");
	}else if(@$_GET['page'] == "nickname" ) {
    include("nickcolor.php");
	}else if(@$_GET['page'] == "exp" ) {
    include("exp.php");
	}else if(@$_GET['page'] == "password" ) {
    include("changepassword.php");
	}else if(@$_GET['page'] == "itemcode" ) {
		include("code.php");
    }else{
    include("home.php");
    } ?>
	  	</div>
	  	<div class="col-md-4">
  			<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
		<b><i class="fa fa-signal"></i> SERVER STATUS</b> <small></small>
	</div>
	<div class="card-body">
		<center><p><img src="dist/images/star.png" width="25" height="25;"> EXP Boosted : <span class="badge badge-danger"><?php echo $config['rate_xp'] ?>%</span></p>
		<p><img src="dist/images/star.png" width="25" height="25;"> Point Boosted : <span class="badge badge-danger"><?php echo $config['rate_gp'] ?>%</span></p>
		<ul class="list-unstyled">
			<li class="media" style="border-bottom: 1px dashed rgba(255,255,255,0.4)">
				<div class="media-body">
				    <h4 class="mt-0" style="margin-bottom: 0;">Server Status</h4>
					  <?php
		if($config['server_status'] == "online"){
?>
				    <span style="color: green"><b><i class='fa fa-check'></i> Online</b></span>
				<?php }else{ ?>
					<span style="color: red"><b><i class='fa fa-close'></i>Maintenance</b></span>
			<?php }?>
			</div>

			<li class="media" style="border-bottom: 1px dashed rgba(255,255,255,0.4)">
				<div class="media-body">
				    <h4 class="mt-0" style="margin-bottom: 0;">Account Register </h4>
				    <i class="fa fa-users text-info"></i> <?php echo pg_escape_string($countPlayer1); ?> Akun
				</div>
			</li>
						</li>
				<img class="mr-3" src="" width="48">
				<div class="media-body">
				    <i class="fa fa-circle-o-notch fa-spin text-success">  </i> Pemain online :   <?php echo pg_escape_string($countPlayerOnline); ?> <br>
				    <i class="fa fa-circle-o-notch fa-spin text-success">  </i> Server online selama : 
				<script> 
				var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec")
				function countup(yr,m,d){
				var today=new Date()
				var todayy=today.getYear()
				if (todayy < 1000)
				todayy+=1900
				var todaym=today.getMonth()
				var todayd=today.getDate()
				var todaystring=montharray[todaym]+" "+todayd+", "+todayy
				var paststring=montharray[m-1]+" "+d+", "+yr
				var difference=(Math.round((Date.parse(todaystring)-Date.parse(paststring))/(24*60*60*1000))*1)
				difference+=" "
				document.write(" "+difference+" ")
				}
				//พิมพ์วันเรียงตามดังนี้  ( ปี ค.ศ./เดือน/วัน)
				countup(2020,01,01)
                </script> Hari
				</div>
			</li>
		</ul>
	</div>
</div>
<?php
			if (!isset($_SESSION['login_true'])) { ?>
			<!-- ยังไม่ล็อคอิน -->
	<?php }else{?>
	<?php
if(isset($_POST["button2"]))	
{	
if ($_POST["button2"] == "Logout")
{
session_destroy();
?>
<script>
swal(
  'Exit!',
  'Keluar!',
  'error'
)

</script>
<?php
echo "<meta http-equiv='refresh' content='2 ;url=./?page=home'>";
exit;
}}
?>
	<form class="form-horizontal" method="post">
    <div class="form-group">
	<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
		<b><i class="fa fa-users"></i> User Login</b>
	</div>
	<div class="card-body">
				<p><i class="fa fa-user"></i> Nickname : <img src="dist/images/rank/<?php echo $dbarr['rank']; ?>.gif"> <?php if($dbarr['player_name']==""){echo "Belum ada nama";}else{echo $dbarr['player_name'];} ?><?php
											if($dbarr['esport'] == "0"){

											}else{
												?>
										
												<?php
											}
											?>
											<?php
											if($dbarr['pc_cafe'] == "0"){

											}else{
												?>
												<img src="dist/images/pccafe/<?php echo $dbarr['pc_cafe']; ?>.jpg">
												<?php
											}
											?></p>
				<p><i class="fa fa-id-badge"></i> Username : <b id="playerpoint"><?php echo $dbarr['login']; ?></b> </p>
				<p><i class="fa fa-id-badge"></i> Player ID : <b id="playerpoint"><?php echo $dbarr['player_id']; ?></b> </p>
				<p><i class="fa fa-id-badge"></i> Last IP : <b id="playerpoint"><?php echo $dbarr['lastip']; ?></b> </p>				
				<p><i class="fa fa-envelope"></i> Email : <b id="playerpoint"><?php echo $dbarr['email']; ?></b> </p>	
				<p><i class="fa fa-level-up"></i> EXP : <b id="playerpoint"><?php echo $dbarr['exp']; ?></b> </p>
				<p><i class="fa fa-circle"></i> Point : <b id="playerpoint"><?php echo $dbarr['gp']; ?></b> </p>
				<p><i class="fa fa-usd"></i> Cash : <b id="playerpoint"><?php echo $dbarr['money']; ?></b> </p>
				<p><i class="fa fa-btc"></i> Coin : <b id="playerpoint"><?php echo $dbarr['coin']; ?></b> </p>
				<a class="btn btn-primary btn-block " href="index.php?page=password"><i class="fa fa-lock hvr-icon"></i> Ubah kata sandi</a>
				
		
		<button type="submit" name="button2" data-aos="fade-up" class="btn btn-danger btn-block" value="Logout"><i class="fa fa-sign-out hvr-icon"></i> Logout</button>
	</div>
</div>
</div>
  </form>
	<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
		<b><i class="fa fa-list"></i> USER MENU</b>
	</div>
	<div class="card-body">
		<a href="index.php?page=shop" class="btn btn-danger btn-block gradient "><i class="fa fa-shopping-cart hvr-icon"></i> Shop</a>
		<a href="index.php?page=itemcode" class="btn btn-info btn-block "><i class="fa fa-key hvr-icon"></i> Redeem code</a>
	</div>
</div>

	<!-- ล็อคอินแล้ว -->
	<?php }?>


<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
		<b><i class="fa fa-facebook-official"></i> FANPAGE</b> </small>
	</div>
	<div class="card-body">
		<iframe src="https://www.facebook.com/plugins/page.php?href=<?php echo $config['facebook_fanpage_link']; ?>&tabs=timeline&width=320&height=130&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true" width="100%" style="border:none;overflow:hidden;margin-bottom: -25px;" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
	</div>
</div>  		</div>
	  	<div class="col-md-12">
	  		<div style="margin-bottom: 100px">
</div>	  	</div>
	</div>
</div>
</body>
<center>
<div class="" style="background-color:#2a2c2d!important">
  <div class="contx" style="padding:8px;color:#FFF; text-align:center;">
    <small style="font-size:14px;">Copyright &copy; 2020 POINT BLANK <a href="https://fb.me/pb.rdm" target="_blank" style="color:#FF3333;text-decoration:underline;">REDEMPTION</a></small>
  </div>
		</center>
</html>