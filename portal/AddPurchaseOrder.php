<?php
	include("Header.php");
	include_once("LoadProduct.php");
	include_once("module/PurchaseOrder.php");
?>

<br>
<div class="content">

	

        <div class="container-fluid bg-white">
			<!-- LIST VIEW STARTED -->
				<?php
					if($_SESSION['type'] != 'CUSTOMER'){

					$CustomerList 	= GetCustomerList();
					$OrderList 	= GetOrderStatus();
				?>

				<div class="row bg-white"  style="margin-top:30px;padding-top:10px;padding-bottom:10px">
				      <div class="col-md-12">
						<div class="col-md-5 pull-left">
						      <div class="row">
							      <label class="col-sm-4 col-form-label"><b>Customer</b></label>
							      <div class="col-sm-8">
								<div class="form-group bmd-form-group">
									   <select class="form-control"  name="customer" data-style="btn btn-link" id="customer" required>
                                                                		<option value=''>Select Customer</option>
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
					      <div class="col-md-6 pull-right">
						      <div class="row">
							      <label class="col-sm-4 col-form-label"><b>ORDER STATUS</b></label>
							      <div class="col-sm-8">
								<div class="form-group bmd-form-group">
									   <select class="form-control"  name="order_status" data-style="btn btn-link" id="order_status" required>
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
				      </div>					
				</div> 
				<?php
				}
				?>
				<div class="row" id="list_view" style=""> 
				      <div class="col-md-12">

					<ul class="nav nav-pills nav-pills-icons" role="tablist" id="switchinvoicetab">
					    <li class="nav-item">
						<a class="nav-link active" style="font-size:11px !important;" href="#dashboard-1" role="tab" data-toggle="tab" data-targ="showselectproduct">
						    <i class="material-icons">dashboard</i>
						    Select Product  
						</a>
					    </li>
					    <li class="nav-item" id="switchtoinvoice">
						<a class="nav-link" style="font-size:11px !important;" href="#schedule-1" role="tab" data-toggle="tab" data-targ="showinvoice">
						    <i class="material-icons">schedule</i>
						    Purchase Detail 
						</a>
					    </li>
					</ul>
					<div class="tab-content tab-space">
					    <div class="tab-pane active" id="dashboard-1">
						<div class="row hidden-xs" style="margin-top:30px;">
							<ul class="nav nav-pills switchcategory" style="width:auto;margin:auto">
								    <li class="nav-item">
									<a class="nav-link  active" id="category_allcategory" data-targ="allcategory" >
										ALL
									</a>
								    </li>
							<?php
							    $Product = LoadPage();
							    foreach($Product['CategoryName'] as $category){
							    ?>	
								    <li class="nav-item">
									<a class="nav-link " id="category_<?php echo str_replace(" ","_",$category);?>" style="font-size:11px !important;" href="Javascript:void(0);" data-targ="<?php echo str_replace(" ","_",$category);?>">
										<?php echo strtoupper($category); ?>
									</a>
								    </li>
							    <?php
							    }
							?>
							</ul>
						</div> 
						<div class="row hidden-md" style="margin-top:30px;">
							<select class="switchcategory_mobile form-control"  data-style="btn btn-link"  style="width:80%;margin:auto;">
								<option value='allcategory'>ALL</option>
							<?php
							    $Product = LoadPage();
							    foreach($Product['CategoryName'] as $category){
							    ?>	
									<option data-targ="<?php echo str_replace(" ","_",$category);?>" value="<?php echo str_replace(" ","_",$category);?>">
										<?php echo strtoupper($category); ?>
									</option>
							    <?php
							    }
							?>
							</select>
						</div> 
						<div class="row">
							<button type="button" rel="tooltip" class="btn btn-success" style="margin-left: auto;margin-right: 10px;margin-top: 10px;margin: 10px 10px 10px auto;"data-original-title="" title="" onclick="AddPurchaseOrder.SwitchTab()">
								Next
                  					</button>
						</div>
						<div class="row" id="list_view" style="margin-top:30px;"> 
							<?php 
								$data = $Product['data'];
								$ProductImage = $Product['ProductImage'];	
								foreach($data as $productid => $rs){
									?>
									<div class="col-md-3 col-sm-6 col-xs-6 allcategory <?php echo str_replace(" ","_",$rs['CategoryName']); ?>" style="height:auth;padding:5px">
											<p style="text-align:center;width:100%;height:30px"><u><?php echo $rs['ProductName'] ?></u></p>
										<div style="margin:auto;width:150px;heigth:100px;">
											<img src="../<?php echo $rs['Thumbnail'] ?>" style="width:150px;margin:auto;height:auto;max-height:150px;">		
										</div>
										<div style="text-align:center">
											<input type="number" id="product_<?php echo $productid ?>" class="form-control addproduct" data-productid="<?php echo $productid ?>" data-productname="<?php echo $rs['ProductName']?>" data-img="<?php echo $rs['Thumbnail'] ?>" style="width:80px;margin:auto;" placeholder="Qty">&nbsp;
										</div>
									</div>
									<?php
								}
							?>
						</div>
						<div class="row">
							<button type="button" rel="tooltip" class="btn btn-success" style="margin-left: auto;margin-right: 10px;margin-top: 10px;margin: 10px 10px 10px auto;"data-original-title="" title="" onclick="AddPurchaseOrder.SwitchTab()">
								Next
                  					</button>
						</div>
					    </div>
					    <div class="tab-pane" id="schedule-1">
						<div class="table-responsive">
						  <table class="table table-shopping" id="invoice_table">
						      <thead>
							  <tr>
							      <th class="text-center" colspan="2">Product</th>
							      <th class="text-left">Qty</th>
							      <th>Action</th>
							  </tr>
						      </thead>
						      <tbody>
						      </tbody>
						  </table>
							<div class="row">
								<button type="button" rel="tooltip" class="btn btn-success" style="margin-left: auto;margin-right: 10px;margin-top: 10px;margin: 10px 10px 10px auto;"data-original-title="" title="" onclick="AddPurchaseOrder.PlaceOrder()">
									Submit	
								</button>
							</div>
						</div>

					    </div>
					</div>	

				      </div>
            			</div>

			<!-- LIST VIEW ENDED HERE -->
        </div>
      </div>
<?php
	include("includes/JsResources.php");
?>
<script>
	
	var ProductAddToCard = {};

	var AddPurchaseOrder = {

			AddProduct     : function(){
						ProductAddToCard = {};
						$(".addproduct").each(function(){
							if($(this).val() > 0 && $(this).val() != ''){
								var productid = $(this).data('productid');
								var productname = $(this).data('productname');
								var productimage = $(this).data('img');
								ProductAddToCard[productid] = {
											'name' : productname,
											'img'  : productimage,
											'qty'  : $(this).val() 		
									};
							}
						});									
					},
			updateproduct	: function(){
						$("#invoice_table").on("change",".updateproduct",function(){
							var qty = $(this).val();
							var productid = $(this).data('productid');
							if(qty == '' || qty <= 0){
								alert("QTY SHOULD BE GREATER THAN ZERO");
								$(this).focus();
								return false;
							}
							$("#"+productid).val(qty);
							$("#"+productid).trigger('change');
						});

					},
			SwitchTab	: function(){
						$("#switchtoinvoice").find('a').click();			

					},
			RenderTable	: function(){		
						var tbody = '';
						$.each(ProductAddToCard,function(productid,productinfo){
							tbody += ' <tr><td><div class="img-container"><img src="../'+productinfo['img']+'" alt=""></div></td><td class="td-name">'+productinfo['name']+'</td><td><input type="number" data-productid="product_'+productid+'" class="form-control updateproduct" style="width:80px;" placeholder="Qty" value="'+productinfo['qty']+'"></td><td><button class="btn btn-danger" onclick="AddPurchaseOrder.RemoveProduct(\''+productid+'\')"><i class="material-icons">remove</i></button> </td>';
						});			
						if(tbody == '')
						{
							tbody += '<tr><td colspan="4" class="text-center">NO ITEM ADDED</td></tr>';
						}
						$("#invoice_table").find('tbody').html(tbody);
						document.body.scrollTop = 0;
                        document.documentElement.scrollTop = 0;
					},
			SwitchCategroy : function(){
					$(".switchcategory li a").on('click',function(){
						var findactive = $(".switchcategory").find("li a.active");
						var targ = $(this).data('targ');
						if(findactive.data('targ') == targ)
							return false;
						findactive.removeClass('active');
						$(this).addClass('active');
						$(".switchcategory_mobile").val(targ);
						$(".allcategory").fadeOut(function(){
							$("."+targ).fadeIn();
						});
					});
					
					$(".switchcategory_mobile").on('change',function(){
						var targ = $(".switchcategory_mobile").find("option:selected").val();

console.log(targ);
						var findactive = $(".switchcategory").find("li a.active");
						findactive.removeClass('active');
						$("#category_"+targ).addClass('active');
						$(".allcategory").fadeOut(function(){
							$("."+targ).fadeIn();
						});
					});
			},
			AutoRender	: function(){
					
					$(".addproduct").on('change',function(){
						AddPurchaseOrder.AddProduct();
					});


					$("#switchinvoicetab li a").on('click',function(){
							var targ = $(this).data('targ');
							if(targ == 'showinvoice'){
								AddPurchaseOrder.RenderTable();
							}
					});

			},
			RemoveProduct : function(id){
					$("#product_"+id).val('');
					this.AddProduct();
					this.RenderTable();	
			},
			PlaceOrder    : function(){
						var param = {};
						param.module    = 'PurchaseOrder';
						param.mode      = 'SavePurchaseOrder';
						<?php
							if($_SESSION['type'] != 'CUSTOMER'){
							?>	
						param.customer  	= $("#customer").val();
						param.order_status 	= $("#order_status").val();	
							<?php
							}

						?>
						param.PurchasedItem = JSON.stringify(ProductAddToCard);
						var obj = this; 
						var responsedata = Mpapp.fetchData(param,function(data){
								var flag = 'danger';   
								if(data['status']){
									flag = 'success';
									$(".addproduct").each(function(){
										$(this).val('');
									});
									obj.AddProduct();
									obj.RenderTable();	
								//	window.location.href="ViewPurchaseOrder.php";
								}
								md.showNotification('top','right',flag,data['msg']);	 
					
						});
	

			}, 		
			init : function(){
					this.SwitchCategroy();
					this.AutoRender();
					this.updateproduct();
			}
			
	};

	AddPurchaseOrder.init();
</script>

<?php
	include("Footer.php");
?>




