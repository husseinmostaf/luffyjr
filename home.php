<div class="row" style="margin-top: 10px;">
  		<div class="col-md-8">
		  	<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
		<center><marquee bgcolor="black" style="color:#cc0000;" >welcome to enjoy server pb </marquee></center>
	</div>
	<div class="card-body">
		<div class="card text-white bg-dark shadowbox" align="left" style="margin-bottom: 10px;">
			<div class="card-body" style="padding: 0">
				<div id="newscarousel" class="carousel slide carousel-fade" data-ride="carousel" style="height: 325px !important">
					<ol class="carousel-indicators">
						<li data-target="#carouselExampleIndicators" data-slide-to="0"class="active"></li><li data-target="#carouselExampleIndicators" data-slide-to="1"></li>					</ol>
					<div class="carousel-inner">
					<div class="carousel-item active"><img src="dist/images/news/17-3-1.jpg" class="d-block w-100" style="height: 325px !important"></div><div class="carousel-item "><img src="dist/images/news/17-3-1.jpg" class="d-block w-100" style="height: 325px !important"></div>					</div>
					<a class="carousel-control-prev" href="#newscarousel" role="button" data-slide="prev">
					    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
					    <span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#newscarousel" role="button" data-slide="next">
					    <span class="carousel-control-next-icon" aria-hidden="true"></span>
					    <span class="sr-only">Next</span>
					</a>
					<script>
						$('#newscarousel').carousel({
					  	interval: 3500
						})
					</script>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
		<b><i class="fa fa-newspaper-o"></i> NEWS & UPDATE</b> <small></small>
	</div>
	<div class="card-body">
		<p><a href="<?php echo $config['newslink01'] ?>" style="color: #FFF;text-decoration: none;"><span class="badge badge-success">News</span> <b><?php echo $config['news01'] ?></b>  </a></p><p><a href="<?php echo $config['newslink02'] ?>" style="color: #FFF;text-decoration: none;"><span class="badge badge-success">News</span> <b><?php echo $config['news02'] ?></b>  </a></p><p><a href="<?php echo $config['newslink03'] ?>" style="color: #FFF;text-decoration: none;"><span class="badge badge-success">News</span> <b><?php echo $config['news03'] ?></b> </a></p>	</div>
</div>
			<!--
<script>
$( document ).ready(function() {
    swal({
	  	title: '<?php echo $config['web_name']; ?> - Point Blank',
	  	html: '<img src="dist/images/news/17-3-4.png" class="img-fluid">',
	  	confirmButtonColor: '#ff5656',
	});
});
</script> -->
	  	