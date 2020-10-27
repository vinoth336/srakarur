<?php
include("Header.php");
$city  = array('Chennai','Coimbatore','Madurai','Tiruchirappalli','Tiruppur','Salem','Erode','Tirunelveli','Vellore','Thoothukkudi','Dindigul','Thanjavur','Vellore','Virudhunagar','Karur','The Nilgiris District','Krishnagiri','Kanyakumari','Kanchipuram','Namakkal','Sivaganga','Cuddalore','Cuddalore','Thanjavur','Tiruvannamalai','Coimbatore','Virudhunagar','Vellore','Pudukkottai','Vellore','Vellore','Nagapattinam');
$state = array('Uttar Pradesh','Maharashtra','Bihar','West Bengal','Madhya Pradesh','Tamil Nadu','Rajasthan','Karnataka','Gujarat','Andhra Pradesh','Odisha','Telangana','Kerala','Jharkhand','Assam','Punjab','Chhattisgarh','Haryana','Uttarakhand','Himachal Pradesh','Tripura','Meghalaya','Manipur','Nagaland','Goa','Arunachal Pradesh','Mizoram','Sikkim','Delhi','Jammu and Kashmir','Puducherry','Chandigarh','Andaman and Nicobar Islands','Dadra and Nagar Haveli','Ladakh','Daman and Diu','Lakshadweep');	
?>
<style>
.block_header{
margin-bottom:10px;
padding:10px;
border-bottom:1px solid #ccc; 
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
			    <h4 class="card-title">Add/Edit Customer</h4>
			  </div>
			</div>
			<div class="card-body ">
			  <form method="get" action="/" class="form-horizontal" onSubmit="return Customer.SaveCustomer()" id="customer_field" >
			    <h4 align="center" class="block_header">BASIC INFORMATION</h4>
			    <div class="row">
				    <div class="col-md-6">	
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Name</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="text" class="form-control" name="customer_name" required>
						  <input type="hidden" class="form-control" name="customer_id">
						  <span class="bmd-help">Add / Edit Customer Name</span>
						</div>
					      </div>
					    </div>
				    </div>
				    <div class="col-md-6">	
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Username</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="text" class="form-control" name="username" >
						  <span class="bmd-help">Add / Edit Contact Username</span>
						</div>
					      </div>
					    </div>
				    </div>
			    </div>
			    <div class="row">
				    <div class="col-md-6">	
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Code</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="text" class="form-control" name="customer_code" required>
						  <span class="bmd-help">Add / Edit Customer Code</span>
						</div>
					      </div>
					    </div>
				    </div>
				    <div class="col-md-6">	
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Contact Person</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="text" class="form-control" name="contact_person" >
						  <span class="bmd-help">Add / Edit Contact Person</span>
						</div>
					      </div>
					    </div>
				    </div>
			    </div>
			    <h4 align="center" class="block_header">CONTACT INFORMATION</h4>
			    <div class="row">
				    <div class="col-md-6">	
					    <div class="row">
					      <label class="col-sm-2 col-form-label label-checkbox">Address</label>
					      <div class="col-sm-10 checkbox-radios">
						<div class="form-group bmd-form-group">
						  <textarea class="form-control" name="address" required></textarea>
						  <span class="bmd-help">Add / Edit Address</span>
						</div>
					      </div>	
					    </div>
				   </div>
				    <div class="col-md-6">	
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Zipcode</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="text" class="form-control" name="zipcode" >
						  <span class="bmd-help">Add / Edit Contact Person</span>
						</div>
					      </div>
					    </div>
				    </div>
			    </div>
			    <div class="row">
				    <div class="col-md-6">	
					    <div class="row">
					      <label class="col-sm-2 col-form-label">City</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <select name="city" class="form-control" data-style="btn btn-link" >
<?php
foreach($city as $val){
echo "<option value='$val' >$val</option>";	
}
?>
						  </select>
						  <span class="bmd-help">Add / Edit Phone</span>
						</div>
					      </div>
					    </div>
				    </div>
				    <div class="col-md-6">	
					    <div class="row">
					      <label class="col-sm-2 col-form-label">State</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <select name="state" class="form-control" data-style="btn btn-link" >
<?php
foreach($state as $val){
echo "<option value='$val' ".($val == 'Tamil Nadu' ? 'selected' : '')." >$val</option>";	
}
?>
						  </select>
						  <span class="bmd-help">Add / Edit Phone</span>
						</div>
					      </div>
					    </div>
				    </div>
			     </div>
			    <div class="row">
				    <div class="col-md-6">	
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Phone No</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="number" class="form-control" name="phoneno" maxlength="10" minlength="10" required>
						  <span class="bmd-help">Add / Edit Phone</span>
						</div>
					      </div>
					    </div>
				    </div>
				    <div class="col-md-6">	
					    <div class="row">
					      <label class="col-sm-2 col-form-label">Email</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="email" class="form-control" name="email" >
						  <span class="bmd-help">Add / Edit Phone</span>
						</div>
					      </div>
					    </div>
				    </div>
			     </div>
			    <h4 align="center" class="block_header">TAX INFORMATION</h4>
			    <div class="row">
				    <div class="col-md-6">	
					    <div class="row">
					      <label class="col-sm-2 col-form-label">GST NO</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="text" class="form-control" name="gstno">
						  <span class="bmd-help">Add / Edit Contact Person</span>
						</div>
					      </div>
					    </div>
				    </div>
				    <div class="col-md-6">	
					    <div class="row">
					      <label class="col-sm-2 col-form-label">TIN NO</label>
					      <div class="col-sm-10">
						<div class="form-group bmd-form-group">
						  <input type="number" class="form-control" name="tinno">
						  <span class="bmd-help">Add / Edit Phone</span>
						</div>
					      </div>
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
				<button type="submit" class="btn btn-primary pull-right __web-inspector-hide-shortcut__">Save<div class="ripple-container"></div></button>
				&nbsp;<button type="button" onclick="Customer.CancelEditForm()" class="btn btn-danger pull-right __web-inspector-hide-shortcut__">Cancel<div class="ripple-container"></div></button>
			    </div>

			  </form>
			</div>
		      </div>
		    </div>
		  </div>
	<!-- ADD OR EDIT CATEGORY ENDED -- >
	<!-- LIST VIEW STARTED -->
		<div class="row" id="list_view" style="margin-top:30px;"> 
		      <div class="col-md-6 ml-auto hide" id="import_section">
				<form method="post" action="ImportData.php"  enctype="multipart/form-data">
				<input type="hidden" name="module" value="Customer" >
				Choose File <input type="file" name="importfile" class="form-control" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
				<button type="button" class="btn btn-danger" onclick="ImportModule.HideImportSection()">Cancel</button>
				<button type="submit" name="submit_import" class="btn btn-primary">Import</button>
				</form>
		      </div>

		      <div class="col-md-4 ml-auto">
				<button onclick="Customer.ShowEditForm()" class="btn btn-primary pull-right">Add Customer</button>
				<button onclick="ImportModule.ShowImportSection()" class="btn btn-info pull-right">Import</button>
		      </div>	
		      <div class="col-md-12">
			<div class="card">
			  <div class="card-header card-header-icon card-header-rose">
			    <div class="card-icon">
			      <i class="material-icons">assignment</i>
			    </div>
			    <h4 class="card-title "> Customer List</h4>
			  </div>
			  <div class="card-body table-full-width table-hover">
			    <div class="table-responsive">
			      <table class="table table-striped" id="load_customer_table">
				<thead class="">
				 <tr>
				   <th>
					Status  
				  </th>
				  <th>
					Customer Code  
				  </th>
				   <th>
					Name  
				  </th>
				  <th>
				      Login Id
				  </th>
				  <th>
					City
				  </th>
				  <th>
					Phone No	
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
var Customer = {


GetCustomer : function(){
var param = {};
param.module    = 'Customer';
param.mode      = 'ListCustomer';
var obj = this;
var responsedata = Mpapp.fetchData(param,function(data){
obj.SetDate(data);
});
return false;
},
SetDate : function(data){
var table = $("#load_customer_table");
if(data['no_of_records'] == 0){
	var tbody = "<tr><td colspan='5' style='text-align:center'>NO OF RECORDS</td></tr>";
	table.find('tbody').html(tbody);
	return false;
}

var tbody = '';
var obj = this;
$.each(data['data'],function(key,rs){
	tbody += "<tr>";
	tbody += "<td>"+obj.StatusTemplate((rs['status'] == 1 ? 'checked' : ''),rs['id'])+"</td>";
	tbody += "<td>"+rs['customer_code']+"</td>";
	tbody += "<td>"+rs['customer_name']+"</td>";
	tbody += "<td>"+rs['username']+"</td>";
	tbody += "<td>"+rs['city']+"</td>";
	tbody += "<td>"+rs['phoneno']+"</td>";
	tbody += "<td><a onclick='Customer.EditCustomer(\""+rs['id']+"\")' href='Javascript:void(0)'><i class='material-icons' >edit</i></a><a  onclick='Customer.RemoveCustomer(\""+rs['id']+"\")' href='Javascript:void(0)'><i class='material-icons'>close</i></a><a title='UPDATE PASSWORD'  onclick='Customer.GetPasswordUpdateConfirmation(\""+rs['id']+"\")' href='Javascript:void(0)'><i class='material-icons'>person</i></a></td></tr>";
});
table.find('tbody').html(tbody);
table.DataTable({
"pagingType": "full_numbers",
	iDisplayLength: 50,
	responsive: true,
	order:[[1, 'asc']],
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
	'<input class="form-check-input" type="checkbox" '+status+' name="status"  value="1" onChange="Customer.ChangeStatus(this)" data-id=\''+id+'\'>'+
	'<span class="form-check-sign">'+
	'<span class="check"></span>'+
	'</span>'+
	'</label>'+
	'</div>';
return template;
},
EditCustomer : function(id){

var param = {};
param.module    = 'Customer';
param.mode      = 'EditCustomer';
param.customer_id	      = id;
var responsedata = Mpapp.fetchData(param,function(data){

	Mpapp.scrollTop();	
	var container = EditForm;
	if(data['no_of_records'] == 0){
		container.find("input,select,textarea").each(function(){
			$(this).val('');
		});
		return false;
	}
	var content = data['data'];
	$.each(content,function(fieldname,value){
		var field = container.find('[name="'+fieldname+'"]');
		if(typeof field.val() != 'undefined'){
			field.val(value);
		}
	});

	var ischecked = content['status'] == 1 ? true : false; 
	container.find('[name="status"]').prop('checked' , ischecked);
	container.removeClass('hide');
	ListView.addClass('hide');	

});
return false;

},
SaveCustomer : function(){

var container = EditForm; 
var param =  $("#customer_field").serializeFormJSON();
param.module    = 'Customer';
param.mode      = 'SaveCustomer';
param.status		= container.find('[name="status"]').is(":checked") ? 1 : 0;
var obj = this;
var responsedata = Mpapp.fetchData(param,function(data){
	var flag = 'error';	
	if(data['status']){
		flag = 'success';
		obj.GetCustomer();
		obj.CancelEditForm();
	}
	var message='Password Changed Successfully Please Login Again';
	md.showNotification('top','right',flag,data['msg']);

});
return false;

},
ChangeStatus : function(obj){
var param = {};
param.module    = 'Customer';
param.mode      = 'ChangeStatus';
param.customer_id	      		= $(obj).data('id');
param.status		= $(obj).is(":checked") ? 1 : 0;
var responsedata = Mpapp.fetchData(param,function(data){
	var flag = 'error';	
	if(data['status'])
		flag = 'success';
	md.showNotification('top','right',flag,data['msg']);


});
},
GetPasswordUpdateConfirmation : function(obj){
bootbox.confirm("ARE YOU SURE WANT TO UPDATE PASSWORD ?",function(result){
	if(result)
		Customer.UpdatePassword(obj);
});
},
UpdatePassword : function(customerid){
var param = {};
param.module    = 'Customer';
param.mode      = 'UpdatePassword';
param.customer_id   = customerid;
var responsedata = Mpapp.fetchData(param,function(data){
	var flag = 'error';    
	if(data['status'])
		flag = 'success';
	md.showNotification('top','right',flag,data['msg']);

});
},

RemoveCustomer : function(id){
var param = {};
param.module    = 'Customer';
param.mode      = 'RemoveCustomer';
param.customer_id	      = id;
if(!confirm("ARE YOU SURE WANT TO REMOVE THIS CATEGORY AND THEY PRODUCTS ?"))
	return false;	
var obj = this;
var responsedata = Mpapp.fetchData(param,function(data){
	var flag = 'error';	
	if(data['status'])
		flag = 'success';

	obj.GetCustomer();
	md.showNotification('top','right',flag,data['msg']);

});
},
ShowEditForm : function(){
EditForm.removeClass('hide');
EditForm.find("input,select,textarea").each(function(){
	$(this).val('');
});
ListView.addClass('hide');
},
CancelEditForm : function(){
EditForm.find('[name="customer_name"]').val('');
EditForm.find('[name="customer_id"]').val('');
EditForm.find('[name="status"]').prop('checked',false);
EditForm.addClass('hide');
ListView.removeClass('hide');
},
init : function(){
this.GetCustomer();
}
};

</script>
<script>
Customer.init();
</script>
<?php
include("Footer.php");
?>




