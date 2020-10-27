var ChangePassword = {

  setFormValidation : function (id){
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
			form_validation = 0;
        }
      });
    },
	

   Update_Password : function()
			{

				if($("#ChangePassword").valid() == false)
						return false;
				Mpapp.showloader();
				var param = ($("#ChangePassword")).serializeFormJSON();
				var responsedata = Mpapp.fetchData(param,function(data){
					var s_type	= 'success';
					if(!data['status']){
						Mpapp.showNotification(data['message'],'danger');
					}else{
						Mpapp.showNotification(data['message'],'success');
						setTimeout(function(){ window.location.href='Dashboard.php' ; },1500);
					}


				}); 

				return false;

   			}

	}

   $(document).ready(function(){
		ChangePassword.setFormValidation('#ChangePassword');

   });	
