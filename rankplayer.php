<?php
@session_start();
include_once dirname(__FILE__) . '/config.php';
include_once dirname(__FILE__) . '/connect.php';
error_reporting(0);
?>
<div class="row" style="margin-top: 10px;">
  		<div class="col-md-8">
		  	<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 5px;">
					<h5><b><i class="fa fa-bar-chart"></i> Ranking Player</b></h5>
				</div>
			  	<div class="card-body">
						<tbody>

  <div class="form-group">
   <table id="myTable" class="table table-dark" >  
        <thead>  
          <tr>  
            <th>No</th>  
            <th>Nickname</th>  
            <th>EXP</th>     
            <th>Status</th>                
          </tr>  
        </thead>  
        <tbody>  

        <?php
                  $strRank = "SELECT * FROM accounts order by exp desc limit 100 ";
				  $position = pg_query("SELECT * FROM accounts WHERE exp>'$exp' AND rank<'54' AND player_name<>'' AND rank>'10' ");
				  $position = pg_num_rows($position);
				  $exp = $ranking['exp'];
				  $pos = $position+1;	
                  $num = 1;
                  foreach ($connec->query($strRank) as $row)
                  {
					  
                    $rank_killdeath   =     round($row['kills_count'] / ($row['kills_count']+$row['deaths_count']) * 100)."%";
                    $rank_winrate   =   round($row['fights_win'] / ($row['fights_win']+$row['fights_lost']) * 100)."%";
					
                    ?>                               
          <tr>             
            <td><?php echo $num;?></td>  
            <td><img src="dist/images/rank/<?php echo pg_escape_string($row['rank']); ?>.gif"> <?php echo pg_escape_string($row['player_name']); ?></td>  
            <td><?php echo number_format($row['exp']); ?></td>   
            <td>
              <?php if($row['online'] == true){ ?>
                <span class="badge badge-pill badge-success" style="background-color: green;">Online</span>
            <?php }else { ?>
                <span class="badge badge-pill badge-success" style="background-color: red;">Offline</span>
            </td>     
          </tr>         
          <?php
      }
                $num++;
              }
                ?>
        </tbody>  
      </table>  

  </div>
							</tr>
													<tr>
												</tbody>
					</table>
				</div>


					</div>
<script>
$(document).ready(function(){
    $('#myTable').dataTable();
});
</script>