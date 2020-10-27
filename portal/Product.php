<?php
	include("Header.php");
	include_once('Engine.php');
	global $db;
	$sql = "select a.id , a.category_name from sra_category as a where status = 1 order by a.category_name ;";
	$ex  = $db->query($sql);
	$no_of_records = $db->NumRows($ex);
	while($rs = $db->FetchByAssoc($ex)){
		$category[$rs['id']] = $rs['category_name'];
	}

?>
 <link href="assets/css/dropzone.css" rel="stylesheet" />
<style>
.product_thumbnail{
	width:120px;
	margin:auto;	
	
}
</style>
<div class="content">
        <div class="container-fluid">
			<!-- ADD OR EDIT CATEGORY -->
				  <div class="row hide" id="edit_form">
				    <div class="col-md-12">
				      <div class="card ">
					<div class="card-header card-header-rose card-header-text">
					  <div class="card-text">
					    <h4 class="card-title">Add/Edit Product</h4>
					  </div>
					</div>
					<div class="card-body ">
					  <form method="post" class="form-horizontal" enctype="multipart/form-data" onsubmit="return Product.ValidateForm();">
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Product Name</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="text" class="form-control" name="productname" id="productname" required>
						  <input type="hidden" class="form-control" name="product_id" id="product_id">
						  <span class="bmd-help">Add / Edit Product Name</span>
						</div>
					      </div>
					    </div>
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Product Code</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="text" class="form-control" name="productcode" id="productcode" required>
						  <span class="bmd-help">Add / Edit Product Code</span>
						</div>
					      </div>
					    </div>
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Category Name</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
							<select class="form-control"  name="categoryname" data-style="btn btn-link" id="categoryname" required>
								<option value=''>Select Category</option>
							<?php
								foreach($category as $id => $name){
									echo "<option value='$id' >$name</option>";	
								}
							?>
							</select>
						</div>
					      </div>
					    </div>
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Product Price</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="text" class="form-control" name="price" id="price" required>
						  <span class="bmd-help">Add / Edit Product Price</span>
						</div>
					      </div>
					    </div>
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Tax Price</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="text" class="form-control" name="tax" id="tax" max="100" min="0" >
						  <span class="bmd-help">Add / Edit Product Tax</span>
						</div>
					      </div>
					    </div>
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Discount Price</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="text" class="form-control" name="discount_price" id="discount_price" required>
						  <span class="bmd-help">Add / Edit Product Price</span>
						</div>
					      </div>
					    </div>
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Description</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <textarea class="form-control" name="description" id="description" required></textarea>
						  <span class="bmd-help">Add / Edit Product Description</span>
						</div>
					      </div>
					    </div>
					    <div class="row">
					      	  <label class="col-sm-2 col-form-label">Product Image</label>
						  <div class="col-md-6">
							  <div class="form-group bmd-form-group">
								  <div  id="drag_and_drop_zone_updatereceipt"   style="margin:auto;height:auto;min-width:185px;border:2px dashed #0087F7;cursor:pointer;border-radius: 3px 3px;padding-bottom: 30px;" class="dropzone">
									  <div class="dz-message" data-dz-message="" style="margin-top:5px;text-align:center;color:#ccc">
										Drop Files Here <br> (or) <br>Click Here
									  </div>
								   </div>
							   </div>
						   </div>
						  <div class="col-md-3 hide" id="product_selected_image_block">
							  <div class="form-group bmd-form-group">
								<h5>Product Image</h5>
								<img src="assets/img/dashboard.png" style="width:150px" />
							   </div>
						   </div>
  					    </div>	
	
					    <div class="row">
					      <label class="col-sm-2 col-form-label label-checkbox">Status</label>
					      <div class="col-sm-10 checkbox-radios">
						<div class="form-check">
						  <label class="form-check-label">
						    <input class="form-check-input" type="checkbox" value="1" name="status" id="status" checked> 
						    <span class="form-check-sign">
						      <span class="check"></span>
						    </span>
						  </label>
						</div>
					      </div>	
					    </div>
						<button type="button" id="upload_chargebackreceipt" class="hide"  ></button>
						<button type="submit"  class="btn btn-primary pull-right __web-inspector-hide-shortcut__">Save<div class="ripple-container"></div></button>
						&nbsp;<button type="button" onclick="Product.CancelEditForm()" class="btn btn-danger pull-right __web-inspector-hide-shortcut__">Cancel<div class="ripple-container"></div></button>
					    </div>
					  </form>
					</div>
				      </div>
				    </div>
				  </div>
			<!-- ADD OR EDIT CATEGORY ENDED -- >
			<!-- LIST VIEW STARTED -->
				<div class="row" id="list_view" style="margin-top:30px;"> 
				      <div class="col-sm-2 ml-auto">
						<button onclick="Product.ShowEditForm()" class="btn btn-primary">Add Product</button>
				      </div>	
				      <div class="col-md-12">
					<div class="card">
					  <div class="card-header card-header-icon card-header-rose">
					    <div class="card-icon">
					      <i class="material-icons">assignment</i>
					    </div>
					    <h4 class="card-title "> Product List</h4>
					  </div>
					  <div class="card-body table-full-width table-hover">
					    <div class="table-responsive">
					      <table class="table table-striped" id="load_product_table">
						<thead class="">
						 <tr>
						   <th>
						   	Status  
						  </th>
						   <th class="not-export" style="width:150px;">
						   	 Image 
						  </th>
						  <th>Product Code</th>
						  <th style="width:150px;">
						   	Category  
						  </th>
						  <th>
						   	Product  
						  </th>
						  <th>
						      Price
						  </th>
						  <th>
						     With Tax 
						  </th>
						  <th class="not-export" style="width:150px;">
						   	Action 
						  </th>
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

			<!-- LIST VIEW ENDED HERE -->
        </div>
      </div>
<?php
	include("includes/JsResources.php");
?>
<script type="text/javascript" src="assets/js/dropzone.js"></script>
<script>
	var EditForm = $("#edit_form");
	var ListView = $("#list_view"); 
	var Product = {

		
		GetProduct : function(){
				      var param = {};
				      param.module    = 'Product';
				      param.mode      = 'ListProduct';
				      var obj = this;
				      var responsedata = Mpapp.fetchData(param,function(data){
						obj.SetDate(data);
						      });
				      return false;
		},
		SetDate : function(data){
			var table = $("#load_product_table");
			if(data['no_of_records'] == 0){
				var tbody = "<tr><td colspan='3' style='text-align:center'>NO OF RECORDS</td></tr>";
				table.find('tbody').html(tbody);
				return false;
			}

			var tbody = '';
			var obj = this;
			$.each(data['data'],function(key,rs){
				rs['tax'] = Number(rs['tax'] <= 0 || rs['tax'] == '' ? 0 : rs['tax']);
				rs['price'] = Number(rs['price'] <= 0 || rs['price'] == '' ? 0 : rs['price']);
				tbody += "<tr>";
				tbody += "<td>"+obj.StatusTemplate((rs['status'] == 1 ? 'checked' : ''),rs['id'])+"</td>";
				tbody += "<td style='text-align:center'><img src='../"+rs['thumbnail']+"' class='product_thumbnail'></td>";
				tbody += "<td><b>"+rs['productcode']+"</b></td>";
				tbody += "<td>"+rs['categoryname']+"</td>";
				tbody += "<td>"+rs['productname']+"</td>";
				tbody += "<td>"+rs['price']+"</td>";
				var withTax = rs['price'] + ( rs['tax']/ rs['price'] * 100) ;
				tbody += "<td><a href='Javascript:void(0);' title='Tax: "+ rs['tax'] +"' >"+ withTax.toFixed(2) +"</a></td>";
				tbody += "<td><a onclick='Product.EditProduct(\""+rs['id']+"\")' href='Javascript:void(0)'><i class='material-icons' >edit</i></a><a  onclick='Product.RemoveProduct(\""+rs['id']+"\")' href='Javascript:void(0)'><i class='material-icons'>close</i></a></td></tr>";
			});
			table.find('tbody').html(tbody);
			  table.DataTable({
                                                "pagingType": "full_numbers",
                                                iDisplayLength: 50,
                                                "bDestroy": true,
                                                responsive: true,
                                                language: {
                                                  search: "_INPUT_",
                                                  searchPlaceholder: "Search records",
                                                },
                                                dom: 'Blfrtip',
                                                buttons: [
                                                               { 
                                                                    extend: 'print', 
                                                                    className: 'btn-sm btn-info',
                                                                    title:'',
                                                                    exportOptions: {
                                                                        columns: ':not(".not-export")',
                                                                        format: {
                                                                                body: function ( data, row, column, node ) {
                                                                                        if(column == 0){
                                                                                            var input = $(data).find('input[type="checkbox"]');
                                                                                            data = (input.is(':checked')) ? "Active" : "In Active";    
                                                                                            return data;        
                                                                                        }
                                                                                        return data;
                                                                                }  
                                                                        }     
                                                                    },
                                                               },
                                                               { 
                                                                    extend: 'excel', 
                                                                    className: 'btn-sm btn-info',
                                                                    title:'' ,
                                                                    text:'export',
                                                                    exportOptions: {
                                                                        columns: ':not(".not-export")',
                                                                        format: {
                                                                                body: function ( data, row, column, node ) {
                                                                                        if(column == 0){
                                                                                            var input = $(data).find('input[type="checkbox"]');
                                                                                            data = (input.is(':checked')) ? "Active" : "In Active";    
                                                                                            return data;        
                                                                                        }
                                                                                        return data;
                                                                                }  
                                                                        }     

                                                                    }   
                                                               }
                                                ]
                                        });

		},
		StatusTemplate : function(status,id){
			var template = '<div class="form-check">'+
                              '<label class="form-check-label">'+
                                '<input class="form-check-input" type="checkbox" '+status+' name="status"  value="1" onChange="Product.ChangeStatus(this)" data-id=\''+id+'\'>'+
                                '<span class="form-check-sign">'+
                                  '<span class="check"></span>'+
                                '</span>'+
                              '</label>'+
                            '</div>';
			return template;
		},
		EditProduct : function(id){
				 Mpapp.scrollTop();
				      var param = {};
				      param.module    = 'Product';
				      param.mode      = 'EditProduct';
				      param.id	      = id;
				      var responsedata = Mpapp.fetchData(param,function(data){
								
								if(data['no_of_records'] == 0){
										return false;
								}
								$("html, body").animate({ scrollTop: 0 }, "slow");
								var container = EditForm;
								var content = data['data'];
								container.find('[name="productname"]').val(content['productname']);
								container.find('[name="product_id"]').val(content['id']);
								container.find('[name="description"]').val(content['description']);
								container.find('[name="categoryname"]').val(content['category_id']);
								var ischecked = content['status'] == 1 ? true : false; 
								container.find('[name="status"]').prop('checked' , ischecked);
								container.find('[name="productcode"]').val(content['productcode']);
								container.find('[name="price"]').val(content['price']);
								container.find('[name="tax"]').val(content['tax']);
								container.find('[name="discount_price"]').val(content['discount_price']);
								if(content['thumbnail'] != ''){
									$("#product_selected_image_block").removeClass('hide');
									$("#product_selected_image_block").find('img').attr('src','../'+content['thumbnail']);
									
								}else{
									$("#product_selected_image_block").addClass('hide');
								}	
								container.removeClass('hide');
								ListView.addClass('hide');	

						      });
				      return false;

		},
		UploadFile : function(){

				         $('#drag_and_drop_zone_updatereceipt').dropzone({
                                                                url:'index.php?module=Product&mode=SaveProduct',
                                                                thumbnailWidth:300,
                                                                thumbnailHeight:150,
                                                                addRemoveLinks:true,
                                                                autoProcessQueue:false,
                                                                maxFiles:1,	
								timeout: 900000,
                                                                maxFilesize: 1000,
                                                                uploadMultiple:true,
                                                                paramName:'filename',
                                                                parallelUploads:1,
                                                                acceptedFiles:'image/*',
                                                                init:function(){
                                                                                var drag_and_drop_zone=this;
                                                                                $('#upload_chargebackreceipt').click(function(){
                                                                                         if(drag_and_drop_zone.getQueuedFiles().length > 0 )
                                                                                         {
                                                                                                drag_and_drop_zone.processQueue();
                                                                                         }else{
												if($("#product_id").val() == ''){
                                                                                                Mpapp.Mpalert("PLEASE UPLOAD THE PRODUCT IMAGE");
                                                                                                return false;
												}
												Product.SaveProduct();	
                                                                                        }       
                
                                                                                });     
                                                                        this.on('addedfile',function(file){

                                                                        });
                                                                        this.on('sending',function(file,xhr,formData){
                                                                                $("#upload_chargebackreceipt").attr('disabled',true);
                                                                                formData.append('filename', file);
                                                                                formData.append('productname', $("[name='productname']").val() );
                                                                                formData.append('status', $("#status").is(":checked") ? 1 : 0 );
                                                                                formData.append('id', $("#product_id").val() );
                                                                                formData.append('categoryname', $("#categoryname").val() );
                                                                                formData.append('description', $("#description").val() );
                                                                                formData.append('productcode', $("#productcode").val() );
                                                                                formData.append('price', $("#price").val() );
                                                                                formData.append('discount_price', $("#discount_price").val() );
                                                                                var obj = this; 
                                                                                xhr.ontimeout = (() => {
                                                                                  /*Execute on case of timeout only*/
                                                                                    $("#UpdateReceipt").modal('hide');
                                                                                    alert('Response Timeout. Visit Document Pages To Confirm Whether Document is Uploaded or Not, Please Try Again Only if the Document Is Not Found');
                                                                                    $("#upload_chargebackreceipt").attr('disabled',false);                      
                                                                                        obj.removeFile(file);
                                                                                        $("#productname").val('');
                                                                                        $("#categoryname").val('');
                                                                                        $("#description").html('');
                                                                                        $("#status").prop('checked',false);
                                                                                });
                                                                        });
                                                                        this.on('error',function(file,errorMessage){
                                                                                Mpapp.Mpalert(errorMessage);
                                                                                this.removeFile(file);
                                                                                $("#upload_chargebackreceipt").attr('disabled',false);
                                                                                return false;
                                                                        });
                                                                        this.on('totaluploadprogress',function(progress){
                                                                                $('.roller').width(progress + '%');
                                                                        });
                                                                        this.on("queuecomplete", function (progress){
                                                                                $('.meter').delay(999).slideUp(999);
                                                                        });
                                                                        this.on("complete", function(file){
                                                                                this.removeFile(file);
                                                                                Mpapp.showNotification('Updated Successfully','success');
										$("#productname").val('');
										$("#categoryname").val('');
										$("#description").html('');
										$("#status").prop('checked',false);
                                                                                $("#upload_chargebackreceipt").attr('disabled',false);
										Product.GetProduct();
										Product.CancelEditForm();
                                                                        });
                                                                }
                                                        });
		
				      	


		},	
		SaveProduct : function(){

                                      var container = EditForm; 
                                      var param = {};
                                      param.module    = 'Product';
                                      param.mode      = 'SaveProduct';
                                      param.id          	= container.find('[name="product_id"]').val();
                                      param.categoryname        = container.find('[name="categoryname"]').val();
                                      param.productname         = container.find('[name="productname"]').val();
                                      param.description         = container.find('[name="description"]').val();
                                      param.productcode         = container.find('[name="productcode"]').val();
                                      param.price         	= container.find('[name="price"]').val();
                                      param.tax         	= container.find('[name="tax"]').val();
                                      param.discount_price      = container.find('[name="discount_price"]').val();
                                      param.status              = container.find('[name="status"]').is(":checked") ? 1 : 0;
                                      var obj = this;
                                      var responsedata = Mpapp.fetchData(param,function(data){
                                                 var flag = 'error';    
                                                 if(data['status']){
                                                        flag = 'success';
							container.find('[name="product_id"]').val('');
							container.find('[name="categoryname"]').val('');
							container.find('[name="productname"]').val('');
							container.find('[name="description"]').html('');
							container.find('[name="status"]').prop('checked',true);
                                                        obj.GetProduct();
                                                        obj.CancelEditForm();
                                                 }
						 md.showNotification('top','right',flag,data['msg']);

                                      });

                },
		ChangeStatus : function(obj){
				      var param = {};
				      param.module    = 'Product';
				      param.mode      = 'ChangeStatus';
				      param.id	      		= $(obj).data('id');
				      param.status		= $(obj).is(":checked") ? 1 : 0;
				      var responsedata = Mpapp.fetchData(param,function(data){
						 var flag = 'error';	
						 if(data['status'])
							flag = 'success';
						      var message='Password Changed Successfully Please Login Again';
						      md.showNotification('top','right',flag,data['msg']);


				      });
		},
		RemoveProduct : function(id){
				      var param = {};
				      param.module    = 'Product';
				      param.mode      = 'RemoveProduct';
				      param.id	      = id;
				      if(!confirm("ARE YOU SURE WANT TO REMOVE THIS CATEGORY AND THEY PRODUCTS ?"))
					return false;	
				      var obj = this;
				      var responsedata = Mpapp.fetchData(param,function(data){
						 var flag = 'error';	
						 if(data['status'])
							flag = 'success';
						
						obj.GetProduct();
						md.showNotification('top','right',flag,data['msg']);

				      });
		},
		ShowEditForm : function(){
			EditForm.find('form').trigger("reset");	
			$("#product_selected_image_block").find('img').attr('src','');
			EditForm.removeClass('hide');
			ListView.addClass('hide');
		},
		CancelEditForm : function(){
			EditForm.find('form').trigger("reset");	
			$("#product_selected_image_block").find('img').attr('src','');
			EditForm.find('[name="status"]').prop('checked',false);
			EditForm.addClass('hide');
			ListView.removeClass('hide');
		},
		ValidateForm : function(){
				if($("#productname").val() == ''){
					$("#productname").focus();
					md.showNotification('top','right','error',"Product Name Should Not Empty");
					return false;

				}
				
				if($("#categoryname").val() == ''){
					$("#categoryname").focus();
					md.showNotification('top','right','error',"Category Name Should Not Empty");
					return false;
				}
				if($("#description").val() == ''){
					$("#description").focus();
					md.showNotification('top','right','error',"Description Should Not Empty");
					return false;
				}
	
				$("#upload_chargebackreceipt").trigger('click');
				return false;
		},
		init : function(){
			this.GetProduct();
			this.UploadFile();
		}
	};

	 // Prepare the preview for profile picture
        $("#wizard-picture").change(function() {
            readURL(this);
        });

	
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

	
</script>
<script>
		Product.init();
</script>
<?php
	include("Footer.php");
?>




