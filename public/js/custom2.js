$(document).ready(function() {
	$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {            
		if (!$(this).next().hasClass('show')) {
		$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
		}
		var $subMenu = $(this).next(".dropdown-menu");
		$subMenu.toggleClass('show');
		$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
		$('.dropdown-submenu .show').removeClass("show");
		});
		return false;
	});
		
    if ($('.adv-combo-wrapper select').length > 0 && $.fn.select2) {
        // $('.adv-combo-wrapper select').select2({
        // 	placeholder: 'Please Select',
        // 	width: '100%',
        // });
        
        // $country_list = $('.country_list .adv-combo-wrapper select');
        
        // $country_list.select2({
        // 	placeholder: $country_list.attr('placeholder') || 'Please Select',
        // 	width: '100%',
        // });

        // $business_list = $('.business_list .adv-combo-wrapper select');
        // $business_list.select2({
        //     placeholder: $business_list.attr('placeholder') || 'Please select',
        //     width: '100%'
        // });

        // $role_list = $('.role_list .adv-combo-wrapper select');
        // $role_list.select2({
        //     placeholder: $role_list.attr('placeholder') || 'Please select',
        //     width: '100%'
        // });

        // $region_list = $('.region_list .adv-combo-wrapper select');
        // $region_list.select2({
        //     placeholder: $region_list.attr('placeholder') || 'Please select',
        //     width: '100%'
        // });
        var selectObjs = $('.adv-combo-wrapper select');
        selectObjs.each(function(index, elem){
            $(elem).select2({
                placeholder: $(elem).attr('placeholder') || 'Please select',
                width: '100%',
            });
        })

        $('select.no-search').select2({
        	 minimumResultsForSearch: -1
        });

        $("#region select").select2({
            dropdownCssClass : 'region_dropdown'
        });
    }

    if ($('.faq-entry .dropdown-arrow').length > 0) {
        $('.faq-entry').last().addClass('expanded');
        $('.faq-entry .dropdown-arrow').parent().click( function() {
            $(this).closest('.faq-entry').toggleClass('expanded');
        });
    }

    $("#edit_product").submit(function(e){
        e.preventDefault();
        var _this = this;
        
        $(_this).find('.error_notice').hide();

        $(_this).find("input, textarea, select").each(function(key, elem){                           
            $(_this).find('.error_notice').removeClass('active');
            if( $(elem).val() == "" ){
                var elem_name = $(elem).attr("name").replace('[]','');
                var period_radio = $(this).parent().parent().parent().find('input[type="radio"]');

                if( period_radio.length >0 ){
                    if( period_radio.is(':checked') ){
                        $(_this).find('.error_notice.'+elem_name).show();                    
                    }                    
                }else{
                    $(_this).find('.error_notice.'+elem_name).show();
                }                
            }            
        });

        var submit_flag = true;
        $(_this).find('.error_notice').each(function(key, elem){            
            if( $(elem).css('display') == "block"){
                submit_flag = false;
            }
        });

        if( submit_flag ){
            $.ajax({
                method:'post',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                success:function(response){                    
                    if(response.success == true ){
                        console.log(response);
                        // window.location.href = "/data/offers/"+ $('input[name="offerIdx"]').val();
                        window.location.href = response.redirect;
                    }
                }
            });
        }

        return false;
    });

    checkStatusChanged = function(checkObj) {
        var container = $(checkObj).closest('.limited-check-group');
        var limit = container.attr('max-check') || 5;
        var checkedlist = $(container).find('input[type=checkbox]:checked');
        if(checkedlist.length > limit) {
            checkObj.checked = false;
        }
        var resultField = $(container).find('input[type=hidden]');
        if (resultField.length > 0) {
            checkedlist = $(container).find('input[type=checkbox]:checked');
            var results = [];
            $.each(checkedlist, function(i, checkbox) {
                let key = $(checkbox).attr('key');
                results.push(key);
            });
            $(resultField).val(results.join(','));
        }
    };

    setupMaxLimitCheckGroup = function() {
        console.log('setupMaxLimitCheckGroup');
        $ele = $('.limited-check-group input[type=checkbox]');
        $ele.on('change', function(evt) {
            checkStatusChanged(this);
        });
        checkStatusChanged($ele[0]);
    };
    setupMaxLimitCheckGroup();
	
	$(".more_dropdown a").click(function(){
        $(this).find("i").toggle();
        $(this).parent().find("div").toggle();
    });
	
	$('#inviteModal .invite').click(function(e){
        var flag = 0;
        var flag_a = false;
        $.each($('#inviteModal').find('input[type="email"]'), function(index, elem){
            if($(elem).val()!=""){
                $("#inviteModal .email_lists>.error_notice").hide();
                if(isEmail($(elem).val()) == false){
                    $(elem).parent().find(".error_notice").show();                    
                    flag++;                     
                }else if($(elem).val().length > 100){
                    $(elem).parent().find(".error_notice_limit").show(); 
                    flag++; 
                }else{
                    $(elem).parent().find(".error_notice").hide(); 
                    $(elem).parent().find(".error_notice_limit").hide();                                    
                    /* flag++; */ 
                }  
                flag_a = true;                                    
            }            
        });
                
        if(flag_a==false){
            $("#inviteModal .email_lists>.error_notice").show();
        }
        
        if(flag == 0 && flag_a == true){   
            $(this).html("Inviting");         
            $.ajax({
                type: "post",
                url : '/invite',
                data : $("#inviteModal form").serialize(),
                dataType: 'json',
                success: function(res){                    
                    if(res.success == true){
                        $("#inviteModal .invalid-feedback").css('display', 'block');
                        $("#inviteModal .invite").html("Invite");
                        $("#inviteModal").modal('hide');
                        window.location.reload();    
                    }
                }
            });
        }    
    });
	
	$('#inviteModal .more_email').click(function(e){
        e.preventDefault();
        var emails_number = $(".email_lists label").length;
        var input_field = '<label class="pure-material-textfield-outlined">'+
                                '<input type="email" id="email'+(emails_number+1)+'" name="linked_email[]" class="form-control2 input_data" placeholder=" "  value="">'+
                                '<span>Email '+(emails_number+1)+'</span>'+
                                '<div class="error_notice">Email format is incorrect.</div>'+
                                '<div class="error_notice_limit">Email may not be greater than 100 characters.</div>'+
                           '</label>';
            
        $(".email_lists").append(input_field);        
    });

});
$(".btn-refresh").click(function(){
    $.ajax({
        type:'GET',
        url:'/refresh_captcha',
        success:function(data){
            $(".captcha span").html(data.captcha);
        }
    });
});

