<?php
include("Header.php");
    $city  = array('Chennai','Coimbatore','Madurai','Tiruchirappalli','Tiruppur','Salem','Erode','Tirunelveli','Vellore','Thoothukkudi','Dindigul','Thanjavur','Vellore','Virudhunagar','Karur','The Nilgiris District','Krishnagiri','Kanyakumari','Kanchipuram','Namakkal','Sivaganga','Cuddalore','Cuddalore','Thanjavur','Tiruvannamalai','Coimbatore','Virudhunagar','Vellore','Pudukkottai','Vellore','Vellore','Nagapattinam');
        $state = array('Uttar Pradesh','Maharashtra','Bihar','West Bengal','Madhya Pradesh','Tamil Nadu','Rajasthan','Karnataka','Gujarat','Andhra Pradesh','Odisha','Telangana','Kerala','Jharkhand','Assam','Punjab','Chhattisgarh','Haryana','Uttarakhand','Himachal Pradesh','Tripura','Meghalaya','Manipur','Nagaland','Goa','Arunachal Pradesh','Mizoram','Sikkim','Delhi','Jammu and Kashmir','Puducherry','Chandigarh','Andaman and Nicobar Islands','Dadra and Nagar Haveli','Ladakh','Daman and Diu','Lakshadweep');

	global $db;
	$username = $_SESSION['sra_username'];
	if($_SESSION['type'] == 'CUSTOMER'){
		$sql = "select * , customer_name as 'name' from sra_customer where username='$username'";
	}elseif($_SESSION['type'] != 'CUSTOMER'){
		$sql = "select *  from sra_users where username='$username'";
	}
		$ex  = $db->query($sql);
		$rs  = $db->FetchByAssoc($ex);
        


?>

<div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Profile</h4>
                  <p class="card-category">Keep Your Profile, Always UPDATED</p>
                </div>
                <div class="card-body">
                  <form id="updateprofile" method="post" onsubmit="Javascript:return Profile.SaveProfile()">

		    <input type="hidden" name="module" value="ViewProfile" />	
		    <input type="hidden" name="mode" value="UpdateProfile" />	
		   <?php

			if($_SESSION['type'] == 'CUSTOMER'){
		   ?>	
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Username</label>
                          <input type="text" class="form-control" disabled value="<?php echo $rs['username']; ?>">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">CUSTOMER CODE</label>
                          <input type="text" class="form-control" disabled value="<?php echo $rs['customer_code']; ?>">
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Email address</label>
                          <input type="email" class="form-control" name="email" required value="<?php echo $rs['email'] ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" class="form-control" name="name" required value="<?php echo $rs['name'] ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Contact Person</label>
                          <input type="text" class="form-control" name="contact_person" required value="<?php echo $rs['contact_person'] ?>">
                        </div>
                      </div>
                    </div>
		   <?php
			}else{
		   ?>			
			
			    <div class="row">
			      <div class="col-md-3">
				<div class="form-group bmd-form-group">
				  <label class="bmd-label-floating">Username</label>
				  <input type="text" class="form-control" disabled value="<?php echo $rs['username']; ?>">
				</div>
			      </div>
			      <div class="col-md-6">
				<div class="form-group bmd-form-group">
				  <label class="bmd-label-floating">Role</label>
				  <input type="text" class="form-control" disabled value="<?php echo strtoupper($_SESSION['type']); ?>">
				</div>
			      </div>
			    </div>
			    <div class="row">
			      <div class="col-md-6">
				<div class="form-group bmd-form-group">
				  <label class="bmd-label-floating">Name</label>
				  <input type="text" class="form-control" name="name" required value="<?php echo $rs['name'] ?>">
				</div>
			      </div>
			      <div class="col-md-6">
				<div class="form-group bmd-form-group">
				  <label class="bmd-label-floating">Email address</label>
				  <input type="email" class="form-control" name="email" required value="<?php echo $rs['email'] ?>">
				</div>
			      </div>
			    </div>
		   <?php
			}
		   ?>
				

                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Phone No</label>
                          <input type="text" class="form-control" name="phoneno" required value="<?php echo $rs['phoneno'] ?>">
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Adress</label>
                          <input type="text" class="form-control" name="address" required value="<?php echo $rs['address'] ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating"></label>
			  <select name="city" class="form-control" data-style="btn btn-link" required>
						<option value=''>Select City</option>
					<?php
						foreach($city as $val){
							echo "<option value='$val' ".($rs['city'] == $val ? 'selected' : '')." >$val</option>";
						}
					?>
                           </select>

                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating"></label>
			   <select name="state" class="form-control" required >
						<option value=''>Select State</option>
					<?php
						foreach($state as $val){
							echo "<option value='$val' ".($val == $rs['state'] ? 'selected' : '')." >$val</option>";
						}
					?>
			  </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Postal Code</label>
                          <input type="text" class="form-control" name="zipcode" required value="<?php echo $rs['zipcode'];?>" >
                        </div>
                      </div>
		   </div>
		   <?php

			if($_SESSION['type'] == 'CUSTOMER'){
		   ?>		
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">GST NO</label>
                          <input type="text" class="form-control" required name="gst_no"  value="<?php echo $rs['gstno'];?>"  >
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">TIN NO</label>
                          <input type="text" class="form-control" required name="tin_no"  value="<?php echo $rs['tinno'];?>" >
                        </div>
                      </div>
                    </div>
		  <?php
			}
		  ?>
                    <button type="submit" class="btn btn-primary pull-right">Update Profile</button>
                    <button type="button" class="btn btn-info pull-right" onclick="Profile.OpenModal()">Change Password</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!--- CHANGE PASSWORD MODAL START HERE -->

	<div class="modal fade " id="ChangeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style=" padding-right: 15px;">
                        <div class="modal-dialog ">
                          <div class="modal-content">
                            <div class="modal-header btn-info">
                              <h3 class="modal-title"><strong>Change password</strong></h3>
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <i class="material-icons" style="color: white;font-weight: bold;">clear</i>
                              </button>
                            </div>
                            <div class="modal-body">
					   <form novalidate="novalidate" method="post" action="index.php" id="changepassword_form"  onsubmit = "return Profile.ChangePassword();">
							<div class="form-group bmd-form-group">
							      <label for="old_password" class="bmd-label-floating">Old Password *</label>
							      <input aria-required="true" class="form-control" id="c_password" required="true" name="old_password" type="password" minlength="6" maxlength="30">
							</div>
							<div class="form-group bmd-form-group">
							      <label for="new_password" class="bmd-label-floating">New Password *</label>
							      <input aria-required="true" class="form-control" id="n_password" required="true" name="new_password" type="password" minlength="6" maxlength="30">
							</div>
							<div class="form-group bmd-form-group">
							      <label for="confirm_password" class="bmd-label-floating"> Confirm Password *</label>
							      <input aria-required="true" class="form-control" id="n_password2" required="true" equalto="#n_password" name="confirm_password" type="password" minlength="6">
							    </div>
							</div>
						      <div class="text-center">
							<button type="submit"  class="btn btn-success btn-round mt-4">Save</button>
						      </div>
					 </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

      <!--- CHANGE PASSWORD MODAL END HERE -->		
<?php
   include("includes/JsResources.php");
?>
<script>


	var Profile = {

		SavePassword : function(){


		},
		setFormValidation : function(){
                              $(id).validate({
                                highlight: function(element) {
                                  $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
                                  $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
                                },
                                success: function(element) {
                                  $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
                                  $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
                                },
                                errorPlacement: function(error, element) {
                                  $(element).closest('.form-group').append(error);
                                }
                              });

		},
		SaveProfile : function(){
				  if($("#updateprofile").valid() == false)
					  return false;

				  var param = $("#updateprofile").serialize();
				  Mpapp.fetchData(param,function(data){

						var flag = 'danger';    
                                                if(data['status']){
                                                        flag = 'success';
							//window.location.reload();
						}
                                                md.showNotification('top','right',flag,data['msg']);


				  });	
					
				  return false;
		},
		OpenModal : function(){
				   $('#ChangeModal').modal('show');
				   $('#n_password').val('');
				   $('#c_password').val('');
		},
		ChangePassword : function(){

                                                  if($("#changepassword_form").valid() == false)
                                                          return false;
        
                                                  var userid=$('#userid').val();
                                                  var new_password=$('#n_password').val();
                                                  var old_password=$('#c_password').val();
                                                  var param = {};
                                                  param.module    = 'ViewProfile';
                                                  param.mode      = 'ChangePassword';
                                                  param.new_password      = new_password;
                                                  param.userid      = userid;
                                                  param.old_password      = old_password;
                                                  Mpapp.fetchData(param,function(data){
console.log(data);
								  var flag = 'danger';    
								  if(data['status']){
								  	flag = 'success';
									$('#ChangeModal').modal('hide');
									$('#n_password').val('');
									$('#c_password').val('');
								  }
								  md.showNotification('top','right',flag,data['message']);

                                                  });
                                                return false;
		}	

	}
	$(document).ready(function(){
			Profile.setFormValidation('#updateprofile');
			Profile.setFormValidation('#changepassword_form');
	});


</script>

<?php
   include("Footer.php");
?>   
   


