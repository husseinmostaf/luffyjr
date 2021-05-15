<div class="row" style="margin-top: 10px;">
  		<div class="col-md-8">
		  	<div class="card text-white bg-dark" align="left" style="margin-bottom: 10px;">
	<div class="card-header" style="padding: 7px;">
					<h5><b><i class="fa fa-university"></i> Ranking Clan</b></h5>
				</div>
			  	<div class="card-body">
						<tbody>

  <div class="form-group">
   <table id="myTable" class="table table-dark" >  
        <thead>  
          <tr>  
            <th>No</th>  
            <th>Rank Clan</th>  
            <th>Nama Clan</th>  
            <th>Exp Clan</th> 
    
          </tr>  
        </thead>  
        <tbody>  

        <?php
                  $strClan = "SELECT * FROM clan_data order by clan_exp desc limit 200";
                  $num = 1;
                  foreach ($connec->query($strClan) as $row) 
                  {     
                    ?>                               
          <tr>             
            <td><?php echo $num;?></td>  
            <td><img src="dist/images/clan/<?php echo pg_escape_string($row['clan_rank']); ?>.jpg")"></td> 			
            <td><?php echo pg_escape_string($row['clan_name']); ?></td>    
            <td><?php echo pg_escape_string($row['clan_exp']); ?></td>   
          <?php
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