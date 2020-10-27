var async_false	= {'async' : true};

var Mpapp = {

	notify	: function(msg,type){
		var a_type = 'warning';
		if(type == 'success')
			a_type = 'success'
		
		$.notify({
			      icon: "add_alert",
			      message: msg 

			 }, {
			      type: a_type,
			      timer: 3000,
			      placement: {
				from: 'top',
				align: 'right'
			      }
			});
		
	}, 
	loaddatatable : function(id){

                                        $('#'+id).DataTable({
                                                   dom: 'Bfrtip',
                                                 buttons: [
                                                               { extend: 'print', className: 'btn-sm btn-success',title:''},
                                                               { extend: 'excel', className: 'btn-sm btn-success',title:'' ,text: 'export'}
                                                 ],

                                                "pagingType": "full_numbers",
                                                "lengthMenu": [
                                                  [10, 25, 50, "All"]
                                                ],
                                                iDisplayLength: 10,
                                                responsive: true,
                                                language: {
                                                  search: "_INPUT_",
                                                  searchPlaceholder: "Search records",
                                                }
                                        });     
         },
	fetchData : function(param,callback='',extraparam=null){


		if(param == '')
			return ;

		  var dfparam =   {'url' : 'index.php', 'dataType' : 'json' };
		  var responsedata	=  '';
                        $.extend(dfparam,extraparam);
                        $.ajax(
                                $.extend(dfparam,
                                {
                                dfparam,
                                "data"          : param,
				"beforeSend"	: function(){
								Mpapp.showloader();	
						},
                                "success"       : function(data){
							Mpapp.hideloader();
							if(callback != ''){
                                                        	callback(data)
							}
							responsedata = data;
                                                },
				"errro"		: function(){
							$("#ajaxloader").css('display','none');	

						}

                                }));
				return responsedata;		
	},
	HandleResponse : function(code){

				switch(code){
					case 1501 :  window.location.href = 'logout.php?status=Session Expired';
						       break;

				}

	},
	
	scrollTop 	: function(){

				  var body = $("html, body");
				  			body.stop().animate({scrollTop:0}, 500, 'swing', function() { 
						  });				
				$("#gotoPortal").focus();	

			},		
	

	selectpicker	: function(elm = ''){

			},
	datepicker	: function(){
				
				$(".daterange").each(function(){
					$(this).daterangepicker({
						'autoApply' : true,
						locale : {
						'format' : 'DD/MM/YYYY' 
						},
						 maxDate: new Date() 
					});
				});
			


			},

	Mpalert		: function(message){
				swal({ 
				    title: message, 
				    buttonsStyling: false, 
				    confirmButtonClass: "btn btn-success" 
				}).catch(swal.noop)	

			},
	showNotification: function(msg,s_type) {

				  color = Math.floor((Math.random() * 6) + 1);

				  $.notify({
					icon: "add_alert",
					message: msg 

					}, {
					type: s_type,
					timer: 3000,
					placement: {
					from: 'top',
					align: 'right' 
					}
				});
  	},
	formatcurrency	: function(container){

				container.find('.currency').each(function(){
					var h = $(this).text();
					var n = h.replace(/[^0-9.-]/g,'');
					var o = h.replace(/[^0-9.]/g,'');
					if($(this).attr('data-type') == 'negative' || n < 0){
						n = ((Number(o)).formatMoney(2, '.', ','));
						//$(this).attr('data-type','negative');
						$(this).html("<font color='red'>$("+n+")</font>");
					}
					else{
						n = ((Number(o)).formatMoney(2, '.', ','));
						$(this).html("$"+n);
					}
				});

			},
	formdatecondition : function(block,param){
			
				if(block        == 'fetchmonthly_record'){
					param.filter    = 'monthly';
					param.month     = $("#month_value").val();
					param.year      = $("#year_value").val();
				}else if(block  == 'fetchdaily_record'){
					param.filter    = 'daily';
					param.date      = $("#quick_jump").val();
				}else if(block  == 'fetchcustom_record'){
					param.filter    = 'custom';
					var temp        = ($("#daterange_value").val()).split('-');
					param.from_date = temp[0].trim();
					param.to_date   = temp[1].trim();
					console.log(temp);

				}else{
					Mpapp.Mpalert('INVALID ACCESS');       
					return false; 
				}
					param.vnumber = $("#vnumber").val();
				return param
			},
	showloader	: function(){
				$(document).find("#ajaxloader").css('display','block');
				return 1;
	},
	hideloader	: function(){
				$(document).find("#ajaxloader").css('display','none');
				return 1;
	},
	showgreeting	: function(){
				 setTimeout(function(){$("#user_greeting_block").fadeIn('normal',function(){$(this).css('display','block');});},1400);
			},
	show_contact_no	: function(){

					$(".show_support_contact_no").on('click',function(){
				
						$("#support_name").html('');
						$("#support_body").html('');
						var target		= $(this).data('target');
						var supportname		= $(this).data('supportname');
						$("#support_name").html(supportname);
						$("#support_body").html($("#"+target).html());
						$("#ShowSupportModal").modal('show');

					});	
				

			},
	show_vnumber   : function(){
					var param = {};
					param.module    = 'Equipments';
					param.mode      = 'EquipmentForVnumber';
					var responsedata = Mpapp.fetchData(param,function(data){
						Mpapp.render_vnumber(data);              
					});
                        },
	show_feedback  : function(){
				$("#ShowFeedback").modal('show');	
                        },
	hide_feedback  : function(){
				$("#ShowFeedback").modal('hide');	
                        },
	refferal_formvalidation : function(){
				
					  $('#PostRefferal').validate({
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
	render_vnumber	: function(data){
					var responsedata = typeof data['info'] == 'undefined' ? [] : data['info'] ;	
					var template	= $("#vnumber_template").html();
					var htmlc	= '';
					$.each(responsedata,function(key,datainfo){
								console.log(datainfo);
                                                                var temp = template;
                                                                temp = temp.replace('PRODUCTNAME',datainfo['productname']);
                                                                temp = temp.replace('TIDNO',datainfo['assetname']);
                                                                temp = temp.replace('SERIALNO',datainfo['serialnumber']);
                                                                htmlc += '<tr>'+temp+'</tr>';  
                                         });
					if(htmlc == ''){
						htmlc ='';	
					}
					var table	=   $("#vnumber_tablebody");
					var dtable      = table.DataTable();
					dtable.destroy();
	
					table.find('tbody').html(htmlc);
					this.loaddatatable('vnumber_tablebody');
					$("#ShowVnumberModal").modal('show');

			}      
	
};

(function ($) {
    $.fn.serializeFormJSON = function () {

        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
})(jQuery);



$(document).ready(function(){
		Mpapp.showgreeting();
		Mpapp.datepicker();
		Mpapp.show_contact_no();	
		Mpapp.refferal_formvalidation();	
		var isNotMobile = true;
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		isNotMobile = false

		}


		if(isNotMobile){
		$(window).on('scroll , ps-scroll-y',function(){
			if($(".daterangepicker").is(":visible"))
			{
			$(".daterange").data('daterangepicker').hide();
			}

			});
		}

	$('body').on('page.dt', function() {
			Mpapp.scrollTop();
	});
});
