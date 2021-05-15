<?php
if(isset($_POST["button"]))	
{	
if ($_POST["button"] != null)
{
		$sql = "SELECT * FROM webshop_sell WHERE item_id = '".$_POST["button"]."'";
		$query = pg_query($sql);
		$rows = pg_fetch_array($query);
$day = $rows['day']*86400;
if($dbarr['coin'] < $rows['price']){
?>
<script type="text/javascript">
swal(
  'SUCCESS!',
  'Koin Anda tidak cukup!',
  'error'
)
</script>
<?php
echo "<meta http-equiv='refresh' content='1 ;url=index.php?page=shop'>";
	}
  else{
?>
<script type="text/javascript">
swal(
  'SUCCESS!',
  'Barang berhasil dibeli',
  'success'
)
</script>
<?php
$sqli = "SELECT * FROM player_items WHERE owner_id='".$dbarr['player_id']."' AND item_id = '".$rows['item_id']."'";
$iquery = pg_query($sqli);
$row_i = pg_fetch_array($iquery);
if($row_i['equip'] == 1){
	pg_query("UPDATE player_items SET count = count + '".$day."' WHERE object_id='".$row_i['object_id']."'");
	pg_query("UPDATE accounts SET coin = coin - '".$rows['price']."' WHERE player_id = '".$dbarr['player_id']."'");
	pg_query("INSERT INTO webshop_log (player_id, item_name,day,date,price) VALUES ('".$dbarr['player_id']."', '".$rows['image']."', '".$rows['day']."', '".date("Y-m-d H:i:s", time())."','".$rows['price']."')"); 
		echo "<meta http-equiv='refresh' content='1 ;'>";
	}else if($row_i['equip'] == 2){
		?>
		<script type="text/javascript">
		swal(
			'ERROR!',
			'Item telah digunakan. Tidak bisa membeli berulang kali !',
			'error'
		)
		</script>
		<?php
echo "<meta http-equiv='refresh' content='1 ;url=index.php?page=shop'>";
	}else if($row_i['equip'] == 3){
		?>
		<script type="text/javascript">
		swal(
			'ERROR!',
			'Anda sudah memiliki item ini secara permanen. Tidak bisa membeli berulang kali !',
			'error'
		)
		</script>
		<?php
echo "<meta http-equiv='refresh' content='1 ;url=index.php?page=shop'>";
	}else{
		pg_query("INSERT INTO player_items (owner_id, item_id, item_name, count, category, equip) VALUES ('".$dbarr['player_id']."', '".$rows['item_id']."', '".$rows['item_name']."', '".$day."', '".$rows['item_category']."' , '1')");
		pg_query("UPDATE accounts SET coin = coin - '".$rows['price']."' WHERE player_id = '".$dbarr['player_id']."'");
		pg_query("INSERT INTO webshop_log (player_id, item_name,day,date,price) VALUES ('".$dbarr['player_id']."', '".$rows['image']."', '".$rows['day']."', '".date("Y-m-d H:i:s", time())."','".$rows['price']."')"); 
		echo "<meta http-equiv='refresh' content='1 ;'>";
	}
	}
}
}
?>
<div class="row" style="margin-top: 10px;">
  		<div class="col-md-8">
		  	<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
		<b><i class="fa fa-shopping-cart"></i> SHOP</b> <small></small>
	</div>
	<div class="card-body">
		<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<li class="nav-item w-25 text-center">
				    <a class="nav-link active" data-toggle="pill" href="#shop-1" role="tab" aria-selected="true">Assault Weapon</a>
				</li>
							<li class="nav-item w-25 text-center">
				    <a class="nav-link " data-toggle="pill" href="#shop-2" role="tab" aria-selected="true">SMG Weapon</a>
				</li>
							<li class="nav-item w-25 text-center">
				    <a class="nav-link " data-toggle="pill" href="#shop-3" role="tab" aria-selected="true">Sniper</a>
				</li>
							<li class="nav-item w-25 text-center">
				    <a class="nav-link " data-toggle="pill" href="#shop-4" role="tab" aria-selected="true">Shoutgun</a>
				</li>
							<li class="nav-item w-25 text-center">
				    <a class="nav-link " data-toggle="pill" href="#shop-5" role="tab" aria-selected="true">Pistol</a>
				</li>
							<li class="nav-item w-25 text-center">
				    <a class="nav-link " data-toggle="pill" href="#shop-6" role="tab" aria-selected="true">Malee</a>
				</li>
							<li class="nav-item w-25 text-center">
				    <a class="nav-link " data-toggle="pill" href="#shop-7" role="tab" aria-selected="true">Mask/Karakter</a>
				</li>
							<li class="nav-item w-25 text-center">
				    <a class="nav-link " data-toggle="pill" href="#shop-8" role="tab" aria-selected="true">ITEM</a>
				</li>
					</ul>
		<hr class="bord">
		<div class="tab-content" id="pills-tabContent">
			
			<div class="tab-pane fade show active" id="shop-1" role="tabpanel">
			<form method="post" id="onlyform">
			<div class="row">	
			 <?php
				$strshop = "SELECT * FROM webshop_sell where menu='1'";
				$qrshop = pg_query($strshop);
				while ($rsshop = pg_fetch_array($qrshop)) { 
			?>
			<div class="col-md-4">
						<div class="card" style="margin-bottom: 15px;background-color: rgba(0,0,0,0) !important;border: 3px inset rgba(170, 43, 255, 0.7);border-radius: 5px;">
						  	<img class="card-img-top" src="./dist/images/items/weapon/<?php echo $rsshop['image'];?>">
							<div class="card-body">
							    <center><h5 class="card-title"><b> <?php echo $rsshop['item_name'];?></b></h5></center>
							    <p style="margin-bottom: 5px;"><i class="fa fa-btc"></i> Harga :  <?php echo $rsshop['price'];?> Coin</p>
							    <p><i class="fa fa-clock-o"></i> Durasi :  <?php echo $rsshop['day'];?> Hari </p>
								<input name="item_id" type="hidden" id="item_id" value="<?php echo $rsshop['item_id']; ?>">
								<button type="submit" name="button" class="btn btn-primary btn-block" value="<?php echo $rsshop['item_id']; ?>">Beli sekarang</button>
							    							</div>
						</div>
					</div>
			<?php } ?>
			</div>
			</form>
			</div>
			<div class="tab-pane fade " id="shop-2" role="tabpanel">
			<form method="post" id="onlyform">
			<div class="row">	
			 <?php
				$strshop = "SELECT * FROM webshop_sell where menu='2'";
				$qrshop = pg_query($strshop);
				while ($rsshop = pg_fetch_array($qrshop)) { 
			?>
			<div class="col-md-4">
						<div class="card" style="margin-bottom: 15px;background-color: rgba(0,0,0,0) !important;border: 3px inset rgba(170, 43, 255, 0.7);border-radius: 5px;">
						  	<img class="card-img-top" src="./dist/images/items/weapon/<?php echo $rsshop['image'];?>">
							<div class="card-body">
							    <center><h5 class="card-title"><b> <?php echo $rsshop['item_name'];?></b></h5></center>
							    <p style="margin-bottom: 5px;"><i class="fa fa-btc"></i> Harga :  <?php echo $rsshop['price'];?> Coin</p>
							    <p><i class="fa fa-clock-o"></i> Durasi :  <?php echo $rsshop['day'];?> Hari</p>
								<input name="item_id" type="hidden" id="item_id" value="<?php echo $rsshop['item_id']; ?>">
								<button type="submit" name="button" class="btn btn-primary btn-block" value="<?php echo $rsshop['item_id']; ?>">Beli sekarang</button>
							    							</div>
						</div>
					</div>
			<?php } ?>
			</div>
			</form>
			</div>
			<div class="tab-pane fade " id="shop-3" role="tabpanel">
			<form method="post" id="onlyform">
			<div class="row">	
			 <?php
				$strshop = "SELECT * FROM webshop_sell where menu='3'";
				$qrshop = pg_query($strshop);
				while ($rsshop = pg_fetch_array($qrshop)) { 
			?>
			<div class="col-md-4">
						<div class="card" style="margin-bottom: 15px;background-color: rgba(0,0,0,0) !important;border: 3px inset rgba(170, 43, 255, 0.7);border-radius: 5px;">
						  	<img class="card-img-top" src="./dist/images/items/weapon/<?php echo $rsshop['image'];?>">
							<div class="card-body">
							    <center><h5 class="card-title"><b> <?php echo $rsshop['item_name'];?></b></h5></center>
							    <p style="margin-bottom: 5px;"><i class="fa fa-btc"></i> Harga:  <?php echo $rsshop['price'];?> Coin</p>
							    <p><i class="fa fa-clock-o"></i> Durasi :  <?php echo $rsshop['day'];?> Hari</p>
								<input name="item_id" type="hidden" id="item_id" value="<?php echo $rsshop['item_id']; ?>">
								<button type="submit" name="button" class="btn btn-primary btn-block" value="<?php echo $rsshop['item_id']; ?>">Beli sekarang</button>
							    							</div>
						</div>
					</div>
			<?php } ?>
			</div>
			</form>
			</div>
			<div class="tab-pane fade " id="shop-4" role="tabpanel">
			<form method="post" id="onlyform">
			<div class="row">	
			 <?php
				$strshop = "SELECT * FROM webshop_sell where menu='4'";
				$qrshop = pg_query($strshop);
				while ($rsshop = pg_fetch_array($qrshop)) { 
			?>
			<div class="col-md-4">
						<div class="card" style="margin-bottom: 15px;background-color: rgba(0,0,0,0) !important;border: 3px inset rgba(170, 43, 255, 0.7);border-radius: 5px;">
						  	<img class="card-img-top" src="./dist/images/items/weapon/<?php echo $rsshop['image'];?>">
							<div class="card-body">
							    <center><h5 class="card-title"><b> <?php echo $rsshop['item_name'];?></b></h5></center>
							    <p style="margin-bottom: 5px;"><i class="fa fa-btc"></i> Harga:  <?php echo $rsshop['price'];?> Coin</p>
							    <p><i class="fa fa-clock-o"></i> Durasi :  <?php echo $rsshop['day'];?> Hari</p>
								<input name="item_id" type="hidden" id="item_id" value="<?php echo $rsshop['item_id']; ?>">
								<button type="submit" name="button" class="btn btn-primary btn-block" value="<?php echo $rsshop['item_id']; ?>">Beli sekarang</button>
							    							</div>
						</div>
					</div>
			<?php } ?>
			</div>
			</form>
			</div>
			<div class="tab-pane fade " id="shop-5" role="tabpanel">
			<form method="post" id="onlyform">
			<div class="row">	
			 <?php
				$strshop = "SELECT * FROM webshop_sell where menu='5'";
				$qrshop = pg_query($strshop);
				while ($rsshop = pg_fetch_array($qrshop)) { 
			?>
			<div class="col-md-4">
						<div class="card" style="margin-bottom: 15px;background-color: rgba(0,0,0,0) !important;border: 3px inset rgba(170, 43, 255, 0.7);border-radius: 5px;">
						  	<img class="card-img-top" src="./dist/images/items/weapon/<?php echo $rsshop['image'];?>">
							<div class="card-body">
							    <center><h5 class="card-title"><b> <?php echo $rsshop['item_name'];?></b></h5></center>
							    <p style="margin-bottom: 5px;"><i class="fa fa-btc"></i> Harga:  <?php echo $rsshop['price'];?> Coin</p>
							    <p><i class="fa fa-clock-o"></i> Durasi :  <?php echo $rsshop['day'];?> Hari</p>
								<input name="item_id" type="hidden" id="item_id" value="<?php echo $rsshop['item_id']; ?>">
								<button type="submit" name="button" class="btn btn-primary btn-block" value="<?php echo $rsshop['item_id']; ?>">Beli sekarang</button>
							    							</div>
						</div>
					</div>
			<?php } ?>
			</div>
			</form>
			</div>
			<div class="tab-pane fade " id="shop-6" role="tabpanel">
			<form method="post" id="onlyform">
			<div class="row">	
			 <?php
				$strshop = "SELECT * FROM webshop_sell where menu='6'";
				$qrshop = pg_query($strshop);
				while ($rsshop = pg_fetch_array($qrshop)) { 
			?>
			<div class="col-md-4">
						<div class="card" style="margin-bottom: 15px;background-color: rgba(0,0,0,0) !important;border: 3px inset rgba(170, 43, 255, 0.7);border-radius: 5px;">
						  	<img class="card-img-top" src="./dist/images/items/weapon/<?php echo $rsshop['image'];?>">
							<div class="card-body">
							    <center><h5 class="card-title"><b> <?php echo $rsshop['item_name'];?></b></h5></center>
							    <p style="margin-bottom: 5px;"><i class="fa fa-btc"></i> Harga:  <?php echo $rsshop['price'];?> Coin</p>
							    <p><i class="fa fa-clock-o"></i> Durasi :  <?php echo $rsshop['day'];?> Hari</p>
								<input name="item_id" type="hidden" id="item_id" value="<?php echo $rsshop['item_id']; ?>">
								<button type="submit" name="button" class="btn btn-primary btn-block" value="<?php echo $rsshop['item_id']; ?>">Beli sekarang</button>
							    							</div>
						</div>
					</div>
			<?php } ?>
			</div>
			</form>
			</div>
			<div class="tab-pane fade " id="shop-7" role="tabpanel">
			<form method="post" id="onlyform">
			<div class="row">	
			 <?php
				$strshop = "SELECT * FROM webshop_sell where menu='7'";
				$qrshop = pg_query($strshop);
				while ($rsshop = pg_fetch_array($qrshop)) { 
			?>
			<div class="col-md-4">
						<div class="card" style="margin-bottom: 15px;background-color: rgba(0,0,0,0) !important;border: 3px inset rgba(170, 43, 255, 0.7);border-radius: 5px;">
						  	<img class="card-img-top" src="./dist/images/items/weapon/<?php echo $rsshop['image'];?>">
							<div class="card-body">
							    <center><h5 class="card-title"><b> <?php echo $rsshop['item_name'];?></b></h5></center>
							    <p style="margin-bottom: 5px;"><i class="fa fa-btc"></i> Harga:  <?php echo $rsshop['price'];?> Coin</p>
							    <p><i class="fa fa-clock-o"></i> Durasi :  <?php echo $rsshop['day'];?> Hari</p>
								<input name="item_id" type="hidden" id="item_id" value="<?php echo $rsshop['item_id']; ?>">
								<button type="submit" name="button" class="btn btn-primary btn-block" value="<?php echo $rsshop['item_id']; ?>">Beli sekarang</button>
							    							</div>
						</div>
					</div>
			<?php } ?>
			</div>
			</form>
			</div>
			<div class="tab-pane fade " id="shop-8" role="tabpanel">
			<form method="post" id="onlyform">
			<div class="row">	
			 <?php
				$strshop = "SELECT * FROM webshop_sell where menu='8'";
				$qrshop = pg_query($strshop);
				while ($rsshop = pg_fetch_array($qrshop)) { 
			?>
			<div class="col-md-4">
						<div class="card" style="margin-bottom: 15px;background-color: rgba(0,0,0,0) !important;border: 3px inset rgba(170, 43, 255, 0.7);border-radius: 5px;">
						  	<img class="card-img-top" src="./dist/images/items/weapon/<?php echo $rsshop['image'];?>">
							<div class="card-body">
							    <center><h5 class="card-title"><b> <?php echo $rsshop['item_name'];?></b></h5></center>
							    <p style="margin-bottom: 5px;"><i class="fa fa-btc"></i> Harga:  <?php echo $rsshop['price'];?> Coin</p>
							    <p><i class="fa fa-clock-o"></i> Durasi :  <?php echo $rsshop['day'];?> Hari</p>
								<input name="item_id" type="hidden" id="item_id" value="<?php echo $rsshop['item_id']; ?>">
								<button type="submit" name="button" class="btn btn-primary btn-block" value="<?php echo $rsshop['item_id']; ?>">Beli sekarang</button>
							    							</div>
						</div>
					</div>
			<?php } ?>
			</div>
			</form>
			</div>
								
								
			
		</div>
	</div>
</div>

<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
		<b><i class="fa fa-list"></i> SHOP HISTORY</b>
	</div>
	<div class="card-body">
		 <table id="myTable" class="table table-dark" >  
        <thead>  
          <tr>  
		 <th><center>#</center></th>
            <th><center>Item</center></th>
            <th><center>Harga</center></th>  
            <th><center>Pembelian</center></th>  
  
          </tr>  
        </thead>  
        <tbody>  

        <?php
$strhistopup = "SELECT * FROM webshop_log where player_id='".$dbarr['player_id']."' order by date desc limit 10";
$qrtopup = pg_query($strhistopup);
$num = 1;

while ($rstopup = pg_fetch_array($qrtopup)) { 
?>                           
          <tr>      	
		<th><center><?php echo $num++; ?></center></th>
            <td><center><img src="./dist/images/items/weapon/<?php echo pg_escape_string($rstopup['item_name']); ?>" style="width:25%"></center> </td>  
            <td><center><?php echo $rstopup['price'];?></center></td>  
            <td><center><?php echo $rstopup['date'];?></center></td>  
	
          </tr>         
          <?php
      }
                $num++;
              
                ?>
        </tbody>  
      </table>  
		<script type="text/javascript">
		$(document).ready( function () {
		    $('#buyitemhistory').DataTable({ "order": [[ 0, "desc" ]] });
		} );
		</script>
	</div>
</div>	  	
<script>
$(document).ready(function(){
    $('#myTable').dataTable();
});
</script>