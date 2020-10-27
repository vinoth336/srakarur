	var Refferal={
			Create : function(){
				$("#PostRefferal").on('submit',function(e){
						e.preventDefault();
						if($("#PostRefferal").valid() == false){
							return false;
						}
						var param = ($("#PostRefferal")).serializeFormJSON();

						console.log(param);
						var responsedata = Mpapp.fetchData(param,function(data){
						var s_type      = 'success';
						if(!data['success']){
							Mpapp.showNotification(data['message'],'danger');
						}else{
							Mpapp.showNotification('ADDED SUCCESSFULLY','success');
						}
						Refferal.ViewRefferenceList();
						$("#reffered_friendtab").trigger('click');	
						$("#PostRefferal").trigger('reset');	
					});

				});
			},
			show_refferal : function(){
					this.ViewRefferenceList();
					$("#RefferalModel").modal('show');


			},
			CloseModel  : function(){
					$("#RefferalModel").modal('hide');
			},
			ViewRefferenceList : function(){
					
					var param = {};
					param.module = 'Referral';
					param.mode   = 'ViewReferral';
                                	var responsedata = Mpapp.fetchData(param,function(data){
                                        var s_type      = 'success';
                                        if(!data['success']){
                                                Mpapp.showNotification(data['message'],'danger');
                                        }else{
                                       
						var rs = data['info']['data'];
						var no_of_records = data['info']['no_of_records'];
						
						if(no_of_records == 0){
							html_c = '<tr><td colspan="5" align="center">NO FRIENDS YOU REFFERED</td></tr>';
							$("#refference_list").find('tbody').html(html_c);	
							return ;	
						}	
						var html_c = '';
						var i = 1;
						$.each(rs,function(key,val){
							html_c += '<tr>';
							html_c += '<td style="text-align:center">'+i+'</td>';
							html_c += '<td>'+val['legal_name']+'</td>';
							html_c += '<td style="text-align:center">'+val['created_on']+'</td>';
							html_c += '<td style="text-align:center">'+val['leadstatus']+'</td>';
							html_c += '<td style="text-align:center">'+val['is_convertto_account']+'</td>';
							html_c += '</tr>';
							i++;

						}); 
						$("#refference_list").find('tbody').html(html_c);	

					}
					});	
			}
		}
