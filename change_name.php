<?php
session_start();
/*include_once('inc/include.php');
include_once('config.php');*/
//include_once dirname(__FILE__) . '/inc/include.php';
include_once dirname(__FILE__) . '/config.php';
include_once dirname(__FILE__) . '/connect.php';

$username = $_POST['username'];
$new_name = $_POST['new_name'];



function utf8_strlen($str)

    {
      $c = strlen($str);

      $l = 0;
      for ($i = 0; $i < $c; ++$i)
      {
         if ((ord($str[$i]) & 0xC0) != 0x80)
         {
            ++$l;
         }
      }
      return $l;
    }


if(strlen($new_name) <= 1)
{
    echo "<script>alert('Nama harus memiliki minimal 2 karakter');window.location.href='index.php?page=nickname';</script>";
    /*$_SESSION['toastr'] = array(
    'type'      => 'error', // or 'success' or 'info' or 'warning'
    'message' => 'กรุณากรอกชื่อผู้ใช้งาน!!',
    'title'     => 'ผิดพลาด!'
    );
    header('Location: '.$url);
    exit;*/
}
/*
else if (utf8_strlen($token) <= 12) 
{
    echo "<script>alert('ไอดี ต้องมีอย่างน้อย 13 ตัวอักษร');window.location.href='index.php?page=nickname';</script>";
}
*/
else

{
	//$strAcc = "SELECT * FROM accounts WHERE login = '".$username."'";
	$stmt = $connec->prepare('SELECT * FROM accounts WHERE login = :user');
	$stmt->bindParam(':user', $username, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);	
    //foreach ($connec->query($strAcc) as $row2)
	if($result['coin'] >= $config['price_name']){
       /* if ((!preg_match('/[A-Za-z0-9_~\-!. \[\]@#\$%\^&\*\(\)]+$/', $new_name)) or (strlen($new_name)>20)){
    echo "<script>alert('ชื่อห้ามเกิน 20 ตัวอักษร และห้ามเป็นภาษาไทย.');window.location.href='index.php?page=nickname';</script>";
    die();
  }else{*/
    $sth = $connec->prepare("SELECT * FROM accounts WHERE login = ?");
    $sth->execute([$username]);
    $result = $sth->fetch(PDO::FETCH_ASSOC);
	
    if($result){
        //echo "<script>alert('มีชื่อผู้ใช้งานนี้ในระบบแล้ว');window.location.href='index.php?page=nickname';</script>";
      /*  $ISp_Res = $connec->prepare("UPDATE accounts SET player_name = '".$new_name."' WHERE login = '".$username."'");
        $ISp_Res->execute();*/
		 $sql = 'UPDATE accounts '
     . 'SET player_name = :psw '
     . 'WHERE login = :p_id';
     $stmt = $connec->prepare($sql);                                  
     $stmt->bindParam(':psw', $new_name, PDO::PARAM_STR); 
     $stmt->bindParam(':p_id', $username, PDO::PARAM_STR);         
     $stmt->execute();
		$ISp_Res2 = $connec->prepare("UPDATE accounts SET coin = coin-'".$config['price_name']."' WHERE login = ?");
        $ISp_Res2->execute([$username]);
         echo "<script>alert('Nama berhasil diganti!');window.location.href='index.php?page=nickname';</script>";
       /* $_SESSION['toastr'] = array(
    'type'      => 'error', // or 'success' or 'info' or 'warning'
    'message' => 'มีชื่อผู้ใช้งานนี้ในระบบแล้ว!!',
    'title'     => 'ผิดพลาด!'
    );
        header('Location: '.$url);
        exit; */  
    }else{
          /*
          header('Content-type: text/plain');
          header('Content-Disposition: attachment;filename="token.enc"');
          print $token;
          */
           echo "<script>alert('Nama pengguna tidak ditemukan');window.location.href='index.php?page=nickname';</script>";
        /*$_SESSION['toastr'] = array(
    'type'      => 'success', // or 'success' or 'info' or 'warning'
    'message' => 'สมัครสมาชิกเสร็จเรียบร้อย!!',
    'title'     => 'สำเร็จ!'
    );
        header('Location: '.$url);
        exit;  */  
    }
    }else{
          /*
          header('Content-type: text/plain');
          header('Content-Disposition: attachment;filename="token.enc"');
          print $token;
          */
           echo "<script>alert('Coin anda tidak cukup');window.location.href='index.php?page=nickname';</script>";
        /*$_SESSION['toastr'] = array(
    'type'      => 'success', // or 'success' or 'info' or 'warning'
    'message' => 'สมัครสมาชิกเสร็จเรียบร้อย!!',
    'title'     => 'สำเร็จ!'
    );
        header('Location: '.$url);
        exit;  */  
    }


  
}
?>