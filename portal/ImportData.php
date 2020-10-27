<?php
	include("Header.php");
	include_once("module/Import.php");
	include_once("PHPExcel/PHPExcel.php");
	global $request;
	frame_request();
?>

<div class="content">
        <div class="container-fluid">
			<!-- ADD OR EDIT CATEGORY -->
				  <div class="row " >
				  <?php
					$Import = new ImportData();
					$Import->init();	
					@extract($Import->fields);	
				  ?>	

			    <div class="col-md-12">
			      <div class="card ">
				<div class="card-body ">
				<?php
				    if($error)
					echo "<h5>".$error."</h5><br>"; 
				    else
				    	echo "<h5> NO OF RECORDS IN FILES : $noofrecords , NO OF SUCCESSFULLY INSERTED RECORDS : $inserted </h5><br>";	
				    if(count($duplicate) > 0)
				    {
					    echo '<div class="row">';
					    echo '<p style="text-align:center;width:100%;font-size:13px;color:red">FOLLOWING RECORDS USERNAME ARE ALREADY EXISTS IN SYSTEM, SO KINDLY CHANGE AND IMPORT AGAIN</p>';
						    foreach($duplicate as $key => $content){
							echo '<div class="col-md-12" style="margin-bottom:10px;border-bottom:1px solid #ccc"><div class="row">';
							foreach($header as $key => $clm){
								$mandatory = '';
								if(in_array($clm,$Import->mandatory_fields)){
										$mandatory = '<i style="color:red">*</i>';
										}
										echo "<span class='col-md-3' style='margin-bottom:5px;'><b>".$clm."&nbsp;$mandatory</b><br>".$content[$key]."</span>"; 			
										}
							echo '</div></div>';
						    }
					    echo '</div>';
				     }
				    if(count($invalid_insert) > 0)
				    {
					    echo '<div class="row">';
					    echo '<p style="text-align:center;width:100%;font-size:13px;color:red">FOLLOWING RECORDS MANDATORY FIELDS ARE MISSING, PLEASE FIX AND UPDATE IT AGAIN</p>';
						    foreach($invalid_insert as $key => $content){
							echo '<div class="col-md-12" style="margin-bottom:10px;border-bottom:1px solid #ccc"><div class="row">';
								foreach($header as $key => $clm){
								 $mandatory = '';
								 if(in_array($table_header[$clm],$Import->mandatory_fields)){
									$mandatory = '<i style="color:red">*</i>';
								 }
								echo "<span class='col-md-2' style='margin-bottom:5px;'><b>".$clm."&nbsp;$mandatory</b><br>" . ( $mandatory && $content[$key] == '' ? '<b style="color:red">Please Fill it</b>' : $content[$key])."</span>"; 			
								}
							echo '</div></div>';
						    }
					    echo '</div>';
				     }
				 ?>
				<br>
				 <button type="button" class="btn btn-primary pull-right" onclick="window.location.href='<?php echo $request['module'].".php" ?>'">Back To The Module</button>	
				</div>
				</div>
			      </div>
				    </div>
				  </div>
				  </div>
			<!-- ADD OR EDIT CATEGORY ENDED -- >
            </div>
        </div>
      </div>
<?php
	include("includes/JsResources.php");
?>
<?php
	include("Footer.php");
?>




