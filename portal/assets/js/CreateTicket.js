


var MerchantTicket = {


	init		  : function(){
				this.setFormValidation('#PostTicket');

	},	
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

	OpenModel	: function(){
				$('#CreateTicketModel').modal('show');
	},
	CloseModel	: function(){
				$('#CreateTicketModel').modal('hide');

	},
	CreateTicket	: function(){

			if(!$("#PostTicket").valid())
				return false;

			var param = ($("#PostTicket")).serializeFormJSON();
                                var responsedata = Mpapp.fetchData(param,function(data){
                                        var s_type      = 'success';
                                        if(!data['success']){
                                                Mpapp.showNotification(data['message'],'danger');
                                        }else{
                                                Mpapp.showNotification(data['message'],'success');
                                        }

					MerchantTicket.CloseModel();
					$("#ticket_description").val('');
					if(typeof $("#viewticket_datatable").html() != undefined)
						ViewTicket.GetViewTicket();	
                                });
	
			 return false;	
	}


};

$(document).ready(function(){
	MerchantTicket.init();
});
