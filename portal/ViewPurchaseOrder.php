<?php
	include("Header.php");
	include_once("module/PurchaseOrder.php");

	$CustomerList   = GetCustomerList();
	$OrderList      = GetOrderStatus();
	$default_date   = date("01/m/Y")." - ".date("d/m/Y");
?>



<div class="content">
        <div class="container-fluid">	
		<div id="purchaseorder_list">	
			  <div class="row bg-white"  style="padding-top:10px;padding-bottom:10px;margin-top:15px">
				<div class="col-md-12">
				    <form  id="searchblock">
					<input type="hidden" name="module" value="PurchaseOrder" />	
					<input type="hidden" name="mode" value="PurchaseOrderList" />	
                                      <div class="col-md-12">
					<?php
						if($_SESSION['type'] !='CUSTOMER'){
					?>
                                                <div class="col-md-5 pull-left">
                                                      <div class="row">
                                                              <label class="col-sm-4 col-form-label"><b>Customer</b></label>
                                                              <div class="col-sm-8">
                                                                <div class="form-group bmd-form-group">
                                                                           <select class="form-control"  name="customer" data-style="btn btn-link" id="customer" >
                                                                                <option value=''>Select All</option>
                                                                                <?php
                                                                                        foreach($CustomerList as $key => $info){
                                                                                        echo "<option value='{$info['id']}' >{$info['customername']}</option>";
                                                                                        }
                                                                                ?>

                                                                            </select>
                                                                          <span class="bmd-help">Select Customer</span>
                                                                </div>
                                                              </div>
                                                     </div>
                                                </div>
					<?php
					 }
					?>	
                                              <div class="col-md-6 pull-right">
                                                      <div class="row">
                                                              <label class="col-sm-4 col-form-label"><b>ORDER STATUS</b></label>
                                                              <div class="col-sm-8">
                                                                <div class="form-group bmd-form-group">
                                                                           <select class="form-control"  name="order_status" data-style="btn btn-link" id="order_status" >
                                                                                <option value=''>Select All Status</option>
                                                                                <?php
                                                                                        foreach($OrderList as $key => $info){
                                                                                                echo "<option value='{$info['id']}' >{$info['status']}</option>";
                                                                                        }
                                                                                ?>
                                                                            </select>
                                                                          <span class="bmd-help">Select Order Status</span>
                                                                </div>
                                                              </div>
                                                     </div>
                                              </div>
				
                                              <div class="col-md-5 pull-left">
                                                      <div class="row">
                                                              <label class="col-sm-4 col-form-label"><b>DATE</b></label>
                                                              <div class="col-sm-8">
                                                                <div class="form-group bmd-form-group">
									 <input type="text" class="daterange" name="date" id="daterange_value" placeholder="FROM AND TO DATE" value="<?php echo $default_date ?>" style="margin-top:7px;width:186px;" />

                                                                </div>
                                                              </div>
                                                     </div>
                                              </div>
                                              <div class="col-md-3 <?php if($_SESSION['type'] == 'CUSTOMER'){ echo 'pull-right';}else{ echo 'pull-left'; } ?>">
                                                      <div class="row">
                                                              <div class="col-sm-8 <?php if($_SESSION['type'] == 'CUSTOMER'){ echo 'pull-right';}else{ echo 'pull-left'; } ?>">
									<button type="button" onclick="ViewPurchaseOrder.GetViewPurchaseOrder()" class="btn btn-info">Search</button>
                                                              </div>
                                                     </div>
                                              </div>
                                      </div>
					</form>
                                </div>
				</div>

	

			<!-- LIST VIEW STARTED -->
				<div class="row" id="list_view" style="margin-top:30px;"> 
				      <div class="col-md-12">
					<div class="card">
						  <div class="card-header card-header-icon card-header-rose">
						    <div class="card-icon">
						      <i class="material-icons">assignment</i>
						    </div>
						    <h4 class="card-title ">Purchase Order List</h4>
						  </div>
						  <div class="card-body table-full-width table-hover">
							      <div class=" pull-right">
									<a href="AddPurchaseOrder.php"  class="btn btn-primary">New Purchase Order</a>
							      </div>
							    <div class="table-responsive">
							      <table class="table table-striped datatable" id="load_purchaseorder_table">
								<thead class="">
								</thead>
								<tbody>
								</tbody>
							      </table>
							    </div>
						  </div>
					</div>
				      </div>
            			</div>
			<!-- LIST VIEW ENDED HERE -->
        	</div>
		<div id="purchaseorder_detail" class="hide">
			  <div class="row bg-white"  style="padding-top:10px;padding-bottom:10px;margin-top:15px">
				<button class="btn btn-danger ml-auto" onclick="ViewPurchaseOrder.ShowPage('purchaseorder_list','purchaseorder_detail')" type="button">Back</button> 
				<div class="col-md-12" id="detail" style="">
					<div class="row">
						<div class="col-md-4">
							<img src="../img/logo_wh.PNG"  style="max-height:3.25em"/>
						</div>
						<div class="col-md-4 ml-auto" >
							<h3><b>PURCHASE ORDER</b></h3><br>
							<div><b >Date : <span class="purchaseinfo" id="purchaseDate"></span></b></div>
							<div><b >PO NUMBER : <span class="purchaseinfo"  id="purchaseNo"></span></b></div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 mr-auto">
							<h5><b><u>Vendor</u></b></h5>
							<span  class="purchaseinfo" id="clientName"></span>,<br>
							<span  class="purchaseinfo" id="addressLine1"></span>,<br>
							<span  class="purchaseinfo" id="addressLine2"></span>,<br>
							Phone No : <span  class="purchaseinfo" id="phoneNo"></span>,<br>
							Email Id : <span  class="purchaseinfo" id="emailId"></span><br>
						</div>
					</div>	
					<hr>
					<div class="row">
						<table class="table table-bordered table-striped dataTable" id="purchasedetail_table">
							<thead>
								<tr>
								<th>SNO</th>
								<th>Product Name</th>
								<th>Qty</th>
								</tr>
							</thead>
							<tbody>



							</tbody>
						</table>
					</div>

				</div>
			  </div>
		</div>	


		</div>
      </div>

<?php
	if($_SESSION['type'] == 'admin'){
?>
		
<!-- Modal -->
<div class="modal fade" id="ShowUpdateStatusModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form method="post" action="index.php" id="updatestatusform">
		<input type="hidden" name="module" value="PurchaseOrder" />
		<input type="hidden" name="mode" value="ChangeStatus" />
		<input type="hidden" name="purchaseorderid" value="" />		
		<table >
			<tr>
			<td> UPDATE STATUS </td>
			<td>
				<select name="update_po_order_status" class="" id="update_po_order_status">
					<option value=''>Select All Status</option>
					<?php
						foreach($OrderList as $key => $info){
							echo "<option value='{$info['id']}' >{$info['status']}</option>";
						}
					?>
				</select>
			</td>
			</tr>
		</table>	

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="ViewPurchaseOrder.UpdateStatus()">Save changes</button>
      </div>
    </div>
  </div>
</div>	
<?php
}
?>

<?php
	include("includes/JsResources.php");
?>
<script>
	var EditForm = $("#edit_form");
	var ListView = $("#list_view"); 
	var ViewPurchaseOrder = {

		GetViewPurchaseOrder : function(){
				      var param = {};
				      param = $("#searchblock").serializeFormJSON();
				
				      var obj = this;
				      var responsedata = Mpapp.fetchData(param,function(data){
						obj.SetDate(data);
						      });
				      return false;
		},
		SetDate : function(data){
			var table = $("#load_purchaseorder_table");
		
			if (table.hasClass('dataTable')) {
				table.dataTable().fnClearTable();
				table.dataTable().fnDestroy();
			}


			var thead = '<tr>';
			$.each(data['Header'] , function(key,label){
				thead += '<th>'+label+'</th>';
			});		
			thead += '</tr>';
			table.find('thead').html(thead);
			if(data['no_of_records'] == 0){
				var tbody = "";
				table.find('tbody').html(tbody);
			}

			var tbody = '';
			var obj = this;
			if(data['no_of_records'] > 0){
				$.each(data['data'],function(key,rs){
					tbody += "<tr>";
					$.each(data['Header'],function(clm,label){

						if(clm == 'po_code'){
							tbody += "<td ><a href='#' class='pull-right' onclick='ViewPurchaseOrder.viewOrderList(\""+rs['purchaseorderid']+"\")'>"+rs[clm]+"</a></td>";
						}
						<?php

						if($_SESSION['type'] == 'admin'){
						?>
						else if(clm == 'status'){
							tbody += "<td ><span>"+rs[clm]+"</span><a href='#' class='pull-right' onclick='ViewPurchaseOrder.ShowStatusModel(\""+rs['purchaseorderid']+"\",\""+rs['order_status']+"\")'><i class='material-icons' title='UDPDATE STATUS'>edit</i></a></td>";
						}
						<?php
						}
						?>
						else {		
							tbody += "<td>"+rs[clm]+"</td>";
						}
					});
					tbody += '</tr>';
				});
			}
			table.find('tbody').html(tbody);
			Mpapp.scrollTop();
			table.DataTable({
                                                "pagingType": "full_numbers",
                                                iDisplayLength: 50,
                                                responsive: true,
                                                language: {
                                                  search: "_INPUT_",
                                                  searchPlaceholder: "Search records",
                                                },
						dom: 'Blfrtip',
                                                 buttons: [
                                                               { extend: 'print', className: 'btn-sm btn-info',title:''},
								       { extend: 'excel', className: 'btn-sm btn-info',title:'' ,text:'export', 

									action: function ( e, dt, button, config ) {
											var data = "customer="+$("#customer").val()+"&order_status="+$("#order_status").val()+"&date="+$("#daterange_value").val();
											window.location = 'ExportPurchaseOrder.php?'+data;
								       } 
							       }
                                                 ],

                                        });     
 
 
		},
		<?php
			if($_SESSION['type'] == 'admin')
			{
		?>
			ShowStatusModel : function(purchaseorderid , updatestatus){
					$("#update_po_order_status").val(updatestatus);
					$("[name='purchaseorderid']").val(purchaseorderid);	
					$("#ShowUpdateStatusModel").modal('show');
			},
			UpdateStatus : function(){
					
				      var param = {};
				      param = $("#updatestatusform").serializeFormJSON();
				      var obj = this;
				      var responsedata = Mpapp.fetchData(param,function(data){
						      var flag = 'error';    
						      if(data['status'])
						      flag = 'success';
						      md.showNotification('top','right',flag,data['msg']);
						      if(data['status']){
							      ViewPurchaseOrder.GetViewPurchaseOrder();
							      $("#ShowUpdateStatusModel").modal('hide');
						      }	
					});
				      return false;

			},
		<?php
			}
		?>	
		viewOrderList : function(purchaseOrderId){
		
				      var param = {};
				      param.module = 'PurchaseOrder';
				      param.mode = 'PurchaseOrderDetail';
				      param.purchaseorderid = purchaseOrderId;
				      var obj = this;
				      var responsedata = Mpapp.fetchData(param,function(data){
							Mpapp.scrollTop();
							obj.setPurchaseOrder(data);
						      });
				      return false;
		},
		setPurchaseOrder : function(data){
				
					$(".purchaseinfo").each(function(){
						$(this).html('');
					});	
					if(data.status){
						var rs = data['data']['info'];
							$("#purchaseDate").html(rs['created_on']);
							$("#purchaseNo").html(rs['po_code']);
							$("#clientName").html(rs['customer_name']);
							$("#addressLine1").html(rs['address']);
							$("#addressLine2").html(rs['city']+" , "+rs['state']+" , "+rs['zipcode']);
							$("#phoneNo").html(rs['phoneno']);
							$("#emailId").html(rs['email']);
						
						var i = 1;
						var tbody = '';
						$.each(data['data']['items'],function(key,rs){
							tbody += '<tr>';
							tbody += '<td>'+i+'</td>';
							tbody += '<td>'+rs['productname']+'</td>';
							tbody += '<td>'+rs['qty']+'</td>';
							tbody += '</tr>';
							i++;
						});		
						$("#purchaseorder_detail").find("tbody").html(tbody);
						this.ShowPage('purchaseorder_detail','purchaseorder_list');	
					}
				


		},
		ShowPage : function(showpage , hidepage){
				$("#"+showpage).removeClass('hide');
				$("#"+hidepage).addClass('hide');
		},
		init : function(){
			this.GetViewPurchaseOrder();
		}
	};
	
</script>
<script>
		ViewPurchaseOrder.init();
</script>
<?php
	include("Footer.php");
?>




