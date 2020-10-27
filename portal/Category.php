<?php
	include("Header.php");
?>

<div class="content">
        <div class="container-fluid">
			<!-- ADD OR EDIT CATEGORY -->
				  <div class="row hide" id="edit_form">
				    <div class="col-md-12">
				      <div class="card ">
					<div class="card-header card-header-rose card-header-text">
					  <div class="card-text">
					    <h4 class="card-title">Add/Edit Category</h4>
					  </div>
					</div>
					<div class="card-body ">
					  <form method="get" action="/" class="form-horizontal">
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Category Name</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="text" class="form-control" name="category_name">
						  <input type="hidden" class="form-control" name="category_id">
						  <span class="bmd-help">Add / Edit Category Name</span>
						</div>
					      </div>
					    </div>
					    <div class="row">
					      <label class="col-sm-2 col-form-label label-checkbox">Status</label>
					      <div class="col-sm-10 checkbox-radios">
						<div class="form-check">
						  <label class="form-check-label">
						    <input class="form-check-input" type="checkbox" value="1" name="status"> 
						    <span class="form-check-sign">
						      <span class="check"></span>
						    </span>
						  </label>
						</div>
					      </div>	
					    </div>
						<button type="button" onclick="Category.SaveCategory()" class="btn btn-primary pull-right __web-inspector-hide-shortcut__">Save<div class="ripple-container"></div></button>
						&nbsp;<button type="button" onclick="Category.CancelEditForm()" class="btn btn-danger pull-right __web-inspector-hide-shortcut__">Cancel<div class="ripple-container"></div></button>
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
						<button onclick="Category.ShowEditForm()" class="btn btn-primary">Add Category</button>
				      </div>	
				      <div class="col-md-12">
					<div class="card">
					  <div class="card-header card-header-icon card-header-rose">
					    <div class="card-icon">
					      <i class="material-icons">assignment</i>
					    </div>
					    <h4 class="card-title "> Category List</h4>
					  </div>
					  <div class="card-body table-full-width table-hover">
					    <div class="table-responsive">
					      <table class="table table-striped datatable" id="load_category_table">
						<thead class="">
						 <tr>
						   <th class="">
						   	Status  
						  </th>
						   <th>
						   	Category  
						  </th>
						  <th class="not-export">
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
<script>
	var EditForm = $("#edit_form");
	var ListView = $("#list_view"); 
	var Category = {

		
		GetCategory : function(){
				      var param = {};
				      param.module    = 'Category';
				      param.mode      = 'ListCategory';
				      var obj = this;
				      var responsedata = Mpapp.fetchData(param,function(data){
						obj.SetDate(data);
						      });
				      return false;
		},
		SetDate : function(data){
			var table = $("#load_category_table");
			if(data['no_of_records'] == 0){
				var tbody = "<tr><td colspan='3' style='text-align:center'>NO OF RECORDS</td></tr>";
				table.find('tbody').html(tbody);
				return false;
			}

			var tbody = '';
			var obj = this;
			$.each(data['data'],function(key,rs){
				tbody += "<tr>";
				tbody += "<td>"+obj.StatusTemplate((rs['status'] == 1 ? 'checked' : ''),rs['id'])+"</td>";
				tbody += "<td>"+rs['category_name']+"</td>";
				tbody += "<td><a onclick='Category.EditCategory(\""+rs['id']+"\")' href='Javascript:void(0)'><i class='material-icons' >edit</i></a><a  onclick='Category.RemoveCategory(\""+rs['id']+"\")' href='Javascript:void(0)'><i class='material-icons'>close</i></a></td></tr>";
			});
			table.find('tbody').html(tbody);
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
											    data = (input.prop('checked')) ? "Active" : "In Active";	
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
											    data = (input.prop('checked')) ? "Active" : "In Active";	
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
                                '<input class="form-check-input" type="checkbox" '+status+' name="status"  value="1" onChange="Category.ChangeStatus(this)" data-id=\''+id+'\'>'+
                                '<span class="form-check-sign">'+
                                  '<span class="check"></span>'+
                                '</span>'+
                              '</label>'+
                            '</div>';
			return template;
		},
		EditCategory : function(id){

				      var param = {};
				      param.module    = 'Category';
				      param.mode      = 'EditCategory';
				      param.id	      = id;
				      var responsedata = Mpapp.fetchData(param,function(data){
								 Mpapp.scrollTop();			
								if(data['no_of_records'] == 0){
										return false;
								}
								var container = EditForm;
								var content = data['data'];
								container.find('[name="category_name"]').val(content['category_name']);
								container.find('[name="category_id"]').val(content['id']);

								var ischecked = content['status'] == 1 ? true : false; 
								container.find('[name="status"]').prop('checked' , ischecked);
							
								container.removeClass('hide');
								ListView.addClass('hide');	

						      });
				      return false;

		},
		SaveCategory : function(){

				      var container = EditForm; 
				      var param = {};
				      param.module    = 'Category';
				      param.mode      = 'SaveCategory';
				      param.id	      		= container.find('[name="category_id"]').val();
				      param.category_name	= container.find('[name="category_name"]').val();
				      param.status		= container.find('[name="status"]').is(":checked") ? 1 : 0;
				      var obj = this;
				      var responsedata = Mpapp.fetchData(param,function(data){
						 var flag = 'error';	
						 if(data['status']){
							flag = 'success';
							obj.GetCategory();
							obj.CancelEditForm();
						 }
						      var message='Password Changed Successfully Please Login Again';
						      md.showNotification('top','right',flag,data['msg']);

				      });

		},
		ChangeStatus : function(obj){
				      var param = {};
				      param.module    = 'Category';
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
		RemoveCategory : function(id){
				      var param = {};
				      param.module    = 'Category';
				      param.mode      = 'RemoveCategory';
				      param.id	      = id;
				      if(!confirm("ARE YOU SURE WANT TO REMOVE THIS CATEGORY AND THEY PRODUCTS ?"))
					return false;	
				      var obj = this;
				      var responsedata = Mpapp.fetchData(param,function(data){
						 var flag = 'error';	
						 if(data['status'])
							flag = 'success';
						
						obj.GetCategory();
						md.showNotification('top','right',flag,data['msg']);

				      });
		},
		ShowEditForm : function(){
			EditForm.removeClass('hide');
			ListView.addClass('hide');
		},
		CancelEditForm : function(){
			EditForm.find('[name="category_name"]').val('');
			EditForm.find('[name="category_id"]').val('');
			EditForm.find('[name="status"]').prop('checked',false);
			EditForm.addClass('hide');
			ListView.removeClass('hide');
		},
		init : function(){
			this.GetCategory();
		}
	};
	
</script>
<script>
		Category.init();
</script>
<?php
	include("Footer.php");
?>



