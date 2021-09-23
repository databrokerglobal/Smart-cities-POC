$(document).ready(function(){  
    
    Array.prototype.slice.call(document.querySelectorAll('.nav-item a[href^="#"]'), 0).forEach(function(anchor) {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    var path = window.location.pathname;
    $.each( $("#topnav .nav-link"), function(key, elem){
        if( $('#activeCommunity').val() && $(elem).attr("href").indexOf($('#activeCommunity').val().toLowerCase())>=0){
            $(elem).addClass('active');
        }
    });

    $.each($("#community option"), function(key, elem){     
        var option_text = window.location.pathname.split("/")[1];
        if($(elem).attr("community-name")){
            if( $(elem).attr("community-name").toLowerCase()  == option_text.replace("_", " ") ){
                $(elem).prop('selected', true);
            }            
        }        
    });

    $.each($("#theme option"), function(key, elem){     
        var themeId = window.location.pathname.split("/")[3];
        var filterBy = window.location.pathname.split('/')[2];
        if(themeId && filterBy=="theme"){
            if($(elem).attr("value")){
                if( $(elem).attr("value") == themeId){
                    $(elem).prop('selected', true);
                }            
            }    
        }    
    });

    $.each($("#region option"), function(key, elem){     
        var regionIdx = window.location.pathname.split("/")[3];
        var filterBy = window.location.pathname.split('/')[2];
        if(regionIdx && filterBy=="region"){
            if($(elem).attr("value")){
                if( $(elem).attr("value") == regionIdx){
                    $("#region input[name='region']").val(regionIdx);
                    $("#region .select span").html($(elem).html()); 
                    $("#region .select").addClass("chosen"); 
                }            
            }    
        }    
    });

    $.each($("#region .region-select span.region"), function(key, elem){     
        var regionIdx = window.location.pathname.split("/")[3];
        var filterBy = window.location.pathname.split('/')[2];
        if(regionIdx && filterBy=="region"){
            if($(elem).attr("region-id")){
                if( $(elem).attr("region-id") == regionIdx){
                    $(elem).addClass('active');
                    $("#region input[name='region']").val($(elem).attr('region-id'));
                    $("#region .select span").html($(elem).html()); 
                    $("#region .select").addClass("chosen"); 
                }            
            }    
        }    
    });

    var community = $("#community").val();
    $.each( $("#theme option"), function(key, elem){                        
        if( community != 'all' && $(elem).attr('value') != 'all' && community  != $(elem).attr("community-id") ){
            $(elem).remove();
        }            
    });
    
    $('[data-toggle="tooltip"]').tooltip();

    $(".blog-content .tab-content .tab-pane:first-child").addClass("active");

    $(".dropdown-menu").each(function(){ $(this).css({right: -($(this).width()/2+20)+"px"}); });

    $("#register_nl_section form").submit(function(e){
        e.preventDefault();
        
        var community = [];
        $(this).find("input[name='community[]']").each(function(i){
            
            if($(this).is(":checked")){
                community.push($(this).val());
            }
            
        });    
        $(this).find(".error_notice").hide();
        if(community.length == 0 ){
            $(this).find(".error_notice").show();
        }

        return false;
    })

    $("#profile-edit-section form").submit(function(e){
    	e.preventDefault();
    	$.ajax({
    		method:'post',
    		url: $(this).attr('action'),
    		data: $(this).serialize(),
    		dataType: 'json',
    		success:function(response){
    			$("span.invalid-feedback").hide();
                $('.is-invalid').removeClass('is-invalid');
    			$("span.invalid-feedback").find("strong").empty();
    			if(response.success == false ){
    				$.each(response.result, function(key, value){    		                    
    					if(typeof value == 'object'){
    						$.each(value, function(a, b){ 	
                                if(key=="password"){
                                    //$("span.feedback."+key).find("strong").html(b);
                                    $('span.feedback.'+key).addClass('invalid-feedback');
                                } else if(key=="password_confirmation"){
                                    $("span.feedback."+key).find("strong").html(b);
                                    $('span.feedback.'+key).addClass('invalid-feedback');
                                }
    							else $("span.invalid-feedback."+key).find("strong").html(b);
    						});
    					}else{
                            if(key=='password'){
                                //$("span.feedback."+key).find("strong").text(value);
                                $('span.feedback.'+key).addClass('invalid-feedback');
                            }else if(key=='password_confirmation'){
                                $("span.feedback."+key).find("strong").text(value);
                                $('span.feedback.'+key).addClass('invalid-feedback');
                            }
    						else $("span.invalid-feedback."+key).find("strong").text(value);
    					}    				
                        $('#'+key).addClass('is-invalid');	
    					$("span.invalid-feedback."+key).show();
    				});
    			}else{
    				window.location.href = "/profile";
    			}
    		}
    	});
    	return false;
    });

    if($.fn.imageuploadify){
    	$('input[type="file"]').imageuploadify();
    }    

    $(".custom-dropdown >div.select").click(function(){	    	
    	$(this).parent().find(">ul").toggle();
        if($(this).parent().hasClass('dropdown-open')) $(this).parent().removeClass('dropdown-open');
        else $(this).parent().addClass('dropdown-open');
    });

    $(".custom-dropdown .custom-dropdown-menu button").click(function(){
        if($(this).closest(".custom-dropdown").hasClass('dropdown-open'))
            $(this).closest(".custom-dropdown").removeClass('dropdown-open');
    	var select_box = $(this).parent().parent();
    	select_box.toggle();
    	var show_box = $(this).closest('.custom-dropdown').find('>.select');
        $(show_box).addClass("chosen");
    	var region = select_box.find("input[name='region[]']").val();
    	
    	var regionIdx = [];
    	var region = [];
    	$("input[name='region[]'").each(function(i){
    		if($(this).attr('type') == 'checkbox'){
    			if($(this).is(":checked")){
    				regionIdx.push($(this).val());		
    				region.push($(this).attr('region'));	
    			}
    		}
    		else if($(this).attr('type') == 'hidden'){
    			if($(this).val()){
    				regionIdx.push($(this).val());	
    				region.push($(this).parent().find(".select").text());		
    			}
    		}
    		
    	});
        if(select_box.find(".custom-select2 select").val()){
            regionIdx.push(select_box.find(".custom-select2 select").val());    
            region.push(select_box.find(".custom-select2 select").find("option:checked").text());
        }        
    	        
    	show_box.find("span").html(region.join(', '));
    	$("input[name='offercountry']").val(regionIdx.join(','));
    });

    $("#region.custom-dropdown .custom-dropdown-menu select").change(function(){        
        var select_box = $(this).parent().parent();
        select_box.toggle();
        
        var region = $(this).val();
        var regionName = $(this).find("option:selected").text();

        var show_box = $(this).closest('.custom-dropdown').find('>.select');
        $(show_box).addClass("chosen");
        show_box.find("span").html(regionName);

        $("input[name='region']").val(region);
    });

    $("#region.custom-dropdown .custom-dropdown-menu span.region").click(function(){        
       var select_box = $(this).parent();
       select_box.toggle();

       $("input[name='region']").val( $(this).attr("region-id") );
       var show_box = $(this).closest('.custom-dropdown').find('>.select');
        $(show_box).addClass("chosen");
       var regionName = $(this).text();
       show_box.find("span").html(regionName);
       
    });
    
    var validate = function (cur_step, elem) {                
        cur_step.find('.error_notice').removeClass('active'); 
        // cur_step.find('.error_notice').hide();
        var elem_name = $(elem).attr("name");
        if (elem_name) {
            elem_name = elem_name.replace('[]','');
            if( $(elem).val().trim() === "" && $(elem).attr('remotefile') === undefined){
                cur_step.find('.error_notice.'+elem_name).show();
            } else if(!$(elem).is(":checked") && $(elem).attr('type')=='checkbox'){
                cur_step.find('.error_notice.'+elem_name).show();
            } else {
                cur_step.find('.error_notice.'+elem_name).hide();
            }
        }
    };
    $(".data-offer .step").each(function(key, elem){
    	var cur_step = $(this);
    	cur_step.find('.error_notice').hide();

        cur_step.find("input, textarea, select").on('blur', function (evt) {
            validate(cur_step, evt.target);
        });
    });
	
    $(".data-offer .step button.btn-next").click(function(e){
        var cur_step = $(this).closest("div.step");

        cur_step.find("input, textarea, select").each(function(key, elem) {
            validate(cur_step, elem);
        });
    	var allow_next = true;
    	cur_step.find('.error_notice').each(function(key, elem){    		
    		if( $(elem).css('display') == "block"){
    			allow_next = false;
    		}
    	});

    	if( allow_next == true ){
    		var next = cur_step.next();

	    	cur_step.removeClass("current back");
	    	next.addClass('current');	
            window.scrollTo(0, 0); 
    	}

    });
    $(".data-offer .step a.back-icon").click(function(e){
    	var cur_step = $(this).closest("div.step");
    	var prev = cur_step.prev();

    	cur_step.removeClass("current back");
    	prev.addClass('current back');
        window.scrollTo(0, 0); 
    });

    function validateURL(s) {
       var regexp = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
       return regexp.test(s);
    }   
    const serialize_form = function(form){
        var jsonObj = {};
        var formSerializeArr = form.serializeArray();
        jQuery.map( formSerializeArr, function( n, i ) {
            jsonObj[n.name] = n.value;
        });
        return JSON.stringify(jsonObj);
	}
    $('.period_select input[type="number"]').on('input', function(e){
        var val = $(this).val();
        if(parseFloat(val) < 1 || !(parseFloat(val)>0)){            
            $(this).closest('.period_select').find('.error_notice.'+$(this).attr('name')+'_min').show();
        }else{
            $(this).closest('.period_select').find('.error_notice.'+$(this).attr('name')+'_min').hide();
        }
		
		if(parseFloat(val) > 999999999 && (parseFloat(val)>0)){            
            $(this).closest('.period_select').find('.error_notice.'+$(this).attr('name')+'_max').show();
        }else{
            $(this).closest('.period_select').find('.error_notice.'+$(this).attr('name')+'_max').hide();
        }
    });
    $("#add_product").submit(function(e){
        e.preventDefault();

        var bidType = $('input[name="period"]:checked').val();
        var dataType = $('input[name="format"]:checked').val();
        var productType = $(".product_type:checked").length;
        var _this = this;
        var formValues = JSON.parse(serialize_form($(this)));
        $(_this).find('.error_notice').hide(); 

        $(_this).find("input, textarea, select").each(function(key, elem){     
            $(_this).find('.error_notice').removeClass('active');
            if( $(elem).val() == "" && $(elem).attr("name") != undefined){
                var elem_name = $(elem).attr("name").replace('[]','');
                var period_radio = $(this).parent().parent().parent().find('input[type="radio"]');

                if( period_radio.length >0 ){
                    if( period_radio.is(':checked') ){
                        $(_this).find('.error_notice.'+elem_name).show();                    
                    }                    
                }else{
                    if(elem_name != 'dataUrl' && elem_name !="streamIP" && elem_name != "streamPort" 
                        && elem_name != "no_bidding_price" && elem_name != "no_bidding_period"
                        && elem_name != "bidding_possible_price" && elem_name != "bidding_possible_period")
                        $(_this).find('.error_notice.'+elem_name).show();
                }                
            } if(!validateURL($("#licenseUrl").val())){
                $(_this).find('.error_notice.licenceUrl').show();
            } if(bidType=="no_bidding" ){
                let added_price_periods = $('.nobidprice').length;
                if(added_price_periods <= 0){                    
                    $(_this).find('.error_notice.no_bidding_price').hide();
                    $(_this).find('.error_notice.no_bidding_period').hide();
                    $(_this).find('.error_notice.no_bidding_add_single_period').show();
                }
            } if(bidType=="bidding_possible"){
                let added_price_periods = $('.bidprice').length;
                if(added_price_periods <= 0){
                    $(_this).find('.error_notice.bidding_possible_price').hide();
                    $(_this).find('.error_notice.bidding_possible_period').hide();
                    $(_this).find('.error_notice.bidding_possible_add_single_period').show();
                }
            } if(bidType=="free"){               
                if($('input[name="sourcetype"]:checked').val() == 'self' && !validateURL($("#dataUrl").val())){
                    $(_this).find('.error_notice.dataUrl').show();
                }else if($('input[name="sourcetype"]:checked').val() == 'dxc' && ($('#dxc').val() == '' || $('#did').val() =='')) {

                    $(_this).find('.error_notice.dxcDataSource').show();
                }                
                
            } if(dataType=="Stream" && $('#streamIP').val() == ""){
                $(_this).find('.error_notice.streamIP').show();
            } if(dataType=="Stream" && $('#streamPort').val() == ""){
                $(_this).find('.error_notice.streamPort').show();
            } if(productType == 0){                
                $(_this).find('.error_notice.type').show();
            }

        });
        if(formValues.format === undefined){
            $(_this).find('.error_notice.format').show();
        } 
        if(formValues.period === undefined){
            $(_this).find('.error_notice.period').show();
        }

        var submit_flag = true;
        $(_this).find('.error_notice').each(function(key, elem){          
            if( $(elem).css('display') != "none"){
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
                        window.location.href = response.redirect;
                    }
                }
            });
        }

        return false;
    });

    var theme_select_obj = $("#theme option");
    $("#community").change(function(){      
              
        //window.location.href = '/'+ community.toLowerCase().replace(" ", "_");
        filter_dataoffer();

        var community = $("#community").val();
        if(community != 'all'){
           $("#theme").html(theme_select_obj);

            $.each( $("#theme option"), function(key, elem){                        
                if( community != 'all' && $(elem).attr('value') != 'all' && community  != $(elem).attr("community-id") ){
                    $(elem).remove();
                }            
            });  
            $('#theme').val('all');      
            var community_name = $("#community").find("option:selected").attr("community-name");
           
            if( community_name ){
                if($('input[name="region"]').val()) {
                  // window.location.href = window.location.origin + "/" + community_name.toLowerCase().replace(' ','_') + "/region/" + $('input[name="region"]').val();
                    window.location.href = WEBSITE_URL + "/" + community_name + "/region/" + $('input[name="region"]').val();
                }
                else {
                  // window.location.href = window.location.origin + "/" + community_name.toLowerCase().replace(' ','_');
                    window.location.href = WEBSITE_URL + "/" + community_name;
                }
            }
        }else{
            let cur_theme = $("#theme").val();            
            $.ajax({
                method: 'get',
                url: WEBSITE_URL +'/getAllThemes',
                dataType: 'json',
                success: function(res){
                    let themes = res.themes;                    
                    let options = '<option value="all">All themes</option>';
                    for(let i=0; i<themes.length; i++){
                        if(themes[i].themeIdx == cur_theme)
                            options+= '<option value="'+ themes[i].themeIdx+'" community-id="'+themes[i].communityIdx+'" selected>'+themes[i].themeName+'</option>';
                        else
                            options+= '<option value="'+ themes[i].themeIdx+'" community-id="'+themes[i].communityIdx+'">'+themes[i].themeName+'</option>';
                    }
                    $("#theme").html(options);
                }
            })
        }
    });

    $("#theme").change(function(){                
        filter_dataoffer();
    });

    $("#region select").change(function(){
        filter_dataoffer();
        $("#region span.region").removeClass('active');
    });

    $("#region span.region").click(function(){        
        $("#region select").val("");
        $("#region span.region").removeClass('active');
        $(this).addClass('active');
        filter_dataoffer();
    });

    function filter_dataoffer(loadmore){
        var loadmore = loadmore || false;
        var crsf = $("input[name='_token']").val();        
        var community = $("#community").val();
        var theme = $("#theme").val();
        var theme_text = $("#theme option:selected").text();
        var region1 = $("#region select").val();
        var region2 = $("#region span.region.active").attr("region-id");

        region = region1==""?region2:region1;
        var region_text = $('#region .select >span').html();
        if($("#region span.region.active").text() == "World") region = "";
        var data = {_token: crsf, community: community, theme:theme, region:region, loadmore:loadmore }        
        $.ajax({
            type: "post",
            url : WEBSITE_URL+'/offer/filter',
            data : data,
            dataType: 'json',
            success: function(res){ 
                             
                var list= "";
                $.each(res.offers, function(key, elem){                                       
                   
                    list += 
                        '<div class="col-md-4 mb-20">' +
                            '<div class="card card-profile card-plain mb-0">' +
                                '<div class="card-header">' +

                                    '<a href="'+WEBSITE_URL +'/offers_by_id/'+elem.offerIdx+'">' ;

                        if(elem.offerImage && elem.offerImage != "null"){
                            list +='<img class="img" src="'+elem.offerImage+'" />';
                        }else{
                            list +='<img class="img" src="'+WEBSITE_URL +'/uploads/offer/default.png" />';
                        }
                            list += '</a>'+
                                '</div>'+
                                '<div class="card-body text-left">'+
                                    '<h4 class="offer-title card-title">'+elem.offerTitle+'</h4>'+
                                    '<h6 class="offer-location card-category">';
                                    if(typeof elem.region == 'object'){
                                        $.each(elem.region, function(a, b){
                                            list += '<span>'+b.regionName+'</span>';
                                        });
                                    }else{
                                        list += '<span>'+elem.regionName+'</span>';
                                    }    
                                    if(elem.provider.companyURL.indexOf('https')>-1){
                                        list+='</h6>'+ '<a href="'+WEBSITE_URL +'/company/'+elem.companyIdx+'/offers">';
                                        if(elem.provider.companyLogo){
                                            list+='<img class="img" src="'+WEBSITE_URL +'/uploads/company/thumb/'+elem.provider.companyLogo+'" />';    
                                        }else{
                                            list+='<img class="img" src="'+WEBSITE_URL +'/uploads/company/default_thumb.png" />';    
                                        }
                                        list+='</a>'+ 
                                        '</div>'+
                                    '</div>'+
                                '</div>';   
                                    }else{
                                        list+='</h6>'+ '<a href="'+WEBSITE_URL +'/company/'+elem.companyIdx+'/offers">'
                                        if(elem.provider.companyLogo){
                                            list+='<img class="img" src="'+WEBSITE_URL +'/uploads/company/thumb/'+elem.provider.companyLogo+'" />';    
                                        }else{
                                            list+='<img class="img" src="'+WEBSITE_URL +'/uploads/company/default_thumb.png" />';    
                                        }
                                        list+='</a>'+ 
                                        '</div>'+
                                    '</div>'+
                                '</div>'; 
                                }                   
                });
                if( theme_text != 'All themes' ){
                    $('.theme_text').html("/" + theme_text);
                }else{
                    $('.theme_text').html("");
                }
                if(region) $('.region_text').html("/" + region_text);
                else $('.region_text').html("");
                //list = '<div class="row">' + list + '</div>';
                var offercount = $("#offer-count span");
                if(loadmore == false){
                    $("#offer-list .row").html(list);   
                    if(res.offers.length == 0){
                        $('#no-offers').css('display','block');
                        $("#offer-count").css('display','none');
                    }
                    offercount.html( res.offers.length );
                }else{
                    $("#offer-list .row").append(list);    
                    offercount.html( parseInt( offercount.text() ) + res.offers.length );
                }   

                var totalcount = $("input[name='totalcount']").val();
                
                $("#offer_loadmore").parent().removeClass('hide');
                
                if( parseInt(offercount.text()) >= res.total_count ){
                    $("#offer_loadmore").parent().addClass('hide');                    
                }                

            }
        });

    }

    $("#bids a.nav-link").click(function(){
        $($("#bids a.nav-link")).removeClass('active');
        $("#bids .bid").removeClass("open");
        $(this).find(".bid").addClass("open");
    });
    
    if( $(".text-wrapper textarea").length>0){
        $(".text-wrapper textarea").each(function(index, element){
            $(element).parent().find('.char-counter span').eq(0).text($(element).val().length);
            var text_length = $(element).attr('maxlength');
            $(element).parent().find('.char-counter span').eq(1).text(parseInt( text_length ) - $(element).val().length);
        });
    }
    $(".text-wrapper textarea").keyup(function(){
        var text = $(this).val();
        
        $(this).parent().find('.char-counter span').eq(0).text(text.length);
        var text_length = $(this).attr('maxlength');
        $(this).parent().find('.char-counter span').eq(1).text(parseInt( text_length ) - text.length);
    });

    // $("#community_box").change(function(){
    //     $("#commuFonity_title i").attr("data-original-title", $(this).find("option:selected").attr("tooltip-text"));
    // });
    $("#community_title i").hover(function(){
        $('#'+$(this).attr('aria-describedby')+' .tooltip-inner').html($('.tooltip-text').html());
        $('#'+$(this).attr('aria-describedby')+' .tooltip-inner').css('min-width', '600px');
    });

    function product_period(){    
        console.log('add more row triggered!')    ;
        $('.period .period_select').hide();
        $("input[name='period']:checked").parent().parent().find('.period_select').show();
        
        if($("input[name='period']:checked").val() == 'free' && $("input[name='format']:checked").val() != "Stream"){

            $('#self-source').show();
            $('#dxc-data-source').attr('checked',false);
            $('#self-data-source').attr('checked',true);
        }else{
            $('#self-source').hide();
            $('#self-data-source').attr('checked',false);
            $('#dxc-data-source').attr('checked',true);
        }
    }

    $("input[name='period']").change(function(){        
        product_period();       
    });
    if($('#productIdx').val() == undefined)
            product_period();

    function product_format(){
        $('.stream_detail').hide();
        $("input[name='format']:checked").parent().parent().find('.stream_detail').show();
    }

    $('.add-price').on('click',function(){

        if($(this).attr('role') == 'bid'){
            $(this).parent().parent().find('.error_notice.bidding_possible_price').hide();
            $(this).parent().parent().find('.error_notice.bidding_possible_period').hide();
        }
        if($(this).attr('role') == 'nobid'){
            $(this).parent().parent().find('.error_notice.no_bidding_price').hide();
            $(this).parent().parent().find('.error_notice.no_bidding_period').hide();
        }
        let price = $(this).parent().find('.bidding_price').val();
        let period = $(this).parent().find('.bidding_period').val();

        let error = 0;
        if( price == '' || price == undefined){
            if($(this).attr('role') == 'bid'){               
                $(this).parent().parent().find('.error_notice.bidding_possible_price').show();
            }
            if($(this).attr('role') == 'nobid'){
                $(this).parent().parent().find('.error_notice.no_bidding_price').show();               
            }            
            error = 1;
        }
        else if(price < 1){
            if($(this).attr('role') == 'bid'){               
                $(this).parent().parent().find('.error_notice.bidding_possible_price').show();
            }
            if($(this).attr('role') == 'nobid'){
                $(this).parent().parent().find('.error_notice.no_bidding_price').show();               
            }           
            error = 1;
        }
        else if(price > 999999999 ){
			if($(this).attr('role') == 'bid'){               
                $(this).parent().parent().find('.error_notice.bidding_possible_price_max').show();
            }
            if($(this).attr('role') == 'nobid'){
                $(this).parent().parent().find('.error_notice.no_bidding_price_max').show();               
            }
			error = 1;
		}
        else if(price.indexOf('.') != -1 && price.substring(price.indexOf('.')).length > 3){
			if($(this).attr('role') == 'bid'){               
                $(this).parent().parent().find('.error_notice.bidding_possible_price_max').show();
            }
            if($(this).attr('role') == 'nobid'){
                $(this).parent().parent().find('.error_notice.no_bidding_price_max').show();               
            }
			error = 1;
		}        
        
        let role = $(this).attr('role');
        let combination = price+period;      
        //console.log('ErrorVal: '+error);
        let arrCombination = [];
        let checkval = $('#'+role+'_priceperiod').val();
        let arrsplit = checkval.split(",");

        if(error == 0){
            
            if($.inArray(combination,arrsplit) != -1) {
                //console.log('found');
                $(this).parent().parent().find(".error_notice."+role+"_repeat").show();
                error = 1;
            }
            else {
                //console.log('not found');
                $(this).parent().parent().find(".error_notice."+role+"_repeat").hide();
                arrCombination.push(combination);
            }
            arrCombination.push(checkval);
            //console.log(arrCombination);
        }
        
        if(error == 0){
            let inputs = '<input  type="hidden" class="bidprice" name="b_price[]" value="'+price+'" >'
                        +'<input  type="hidden" name="b_period[]" value="'+period+'" >'
                        +'<input  type="hidden" class="b_priceperiod" name="b_priceperiod[]" value="'+price+period+'" >';
        
            if($(this).attr('role') == 'nobid'){               
                
                 inputs = '<input  type="hidden" class="nobidprice" name="nb_price[]" value="'+price+'" >'
                             +'<input  type="hidden" name="nb_period[]" value="'+period+'" >'
                             +'<input  type="hidden" class="nb_priceperiod" name="nb_priceperiod[]" value="'+price+period+'" >';
            }
            
            let element = '<div class="row price_period">'
                          +inputs
                          +'<p class="col-md-1 col-sm-1"></p>'
                          +'<p class="col-md-3 col-sm-3 para">'+price+' for 1'+period+'</p>'	
                          +'<p class="col-md-2 col-sm-2 para danger cursur-pointer" onclick="removeme(this)"><i class="fa fa-times"></i></p>'											
                          +'</div>';
            $('#'+role+'_priceperiod').val(arrCombination);
            $(this).parent().parent().find('.selected_price_periods').append(element);
            $(this).parent().find('.bidding_price').val('');
            $(this).parent().find('.bidding_period').val('').trigger('change');
        }
       
    });
    

    $("input[name='format']").change(function(){
        product_format();
    });
    product_format();

    $(".data_publish").click(function(e){
        e.preventDefault();

        var data_type = $(this).attr('data-type')
        var data_id = $(this).attr('data-id')
        if(data_type && data_id){
            $.ajax({
                type: "post",
                url : '/data/update-status',
                data : {update:'publish', dataType: data_type, dataId: data_id},
                dataType: 'json',
                success: function(res){
                    if(res.success == true){
                        window.location.reload();    
                    }
                }
            });
        }        
    });

    $(".data_unpublish").click(function(){
        var modal;
        if($(this).attr('data-type')=='offer') modal = $("#unpublishOfferModal");
        else if($(this).attr('data-type')=='product') modal = $("#unpublishProductModal");
        $(modal).find("input[name='data_type']").val($(this).attr('data-type'));
        $(modal).find("input[name='data_id']").val($(this).attr('data-id'));
    });
    $("#unpublishOfferModal button.unpublish").click(function(e){
        e.preventDefault();
        var data_type = $(this).closest('.modal').find("input[name='data_type']").val();
        var data_id = $(this).closest('.modal').find("input[name='data_id']").val();
        
        if(data_type && data_id){
            $.ajax({
                type: "post",
                url : '/data/update-status',
                data : {update: 'unpublish', dataType: data_type, dataId: data_id},
                dataType: 'json',
                success: function(res){
                    
                    if(res.success == true){
                        window.location.reload();    
                    }
                }
            });
        }        
    });
    $("#unpublishProductModal button.unpublish").click(function(e){
        e.preventDefault();
        var data_type = $(this).closest('.modal').find("input[name='data_type']").val();
        var data_id = $(this).closest('.modal').find("input[name='data_id']").val();
        if(data_type && data_id){
            $.ajax({
                type: "post",
                url : '/data/update-status',
                data : {update: 'unpublish', dataType: data_type, dataId: data_id},
                dataType: 'json',
                success: function(res){
                    if(res.success == true){
                        window.location.reload();    
                    }
                }
            });
        }        
    });
    $("#offer_loadmore").click(function(){        
        filter_dataoffer($("#offer-list .card").length);
    });

    $('a[data-target="#deleteModal"]').click(function(){        
        $('#deleteModal').find("input[name='list_userIdx']").val( $(this).attr('user-id') );
        if( $(this).parent().parent().hasClass('invited') ){
            $('#deleteModal').find("input[name='user_type']").val( 'pendding' );
        }else{
            $('#deleteModal').find("input[name='user_type']").val( 'registered' );
        }
    });

    function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;     
      return regex.test(email);
    }

    //share free access to data  start

   

    $('#shareFreeAccessModal .more_email').click(function(e){
        
        e.preventDefault();
        var emails_number = $(".free_access_email_lists label").length;        
        var input_field = '<label class="pure-material-textfield-outlined">'+
                                '<input type="email" id="email'+(emails_number+1)+'" name="linked_email[]" class="form-control2 input_data" placeholder=" "  value="">'+
                                '<span>Email '+(emails_number+1)+'</span>'+
                                '<div class="error_notice">Email format is incorrect.</div>'+
                           '</label>';
            
        $(".free_access_email_lists").append(input_field);        
    });

    $('#shareFreeAccessModal').on('hidden.bs.modal', function (e) {
        $(this)
          .find("input,textarea,select")
             .val('')
             .end()
          .find("input[type=checkbox], input[type=radio]")
             .prop("checked", "")
             .end();
      })

    $('#shareFreeAccessModal .invite').click(function(e){        
        var flag = false;
        var flag_a = false;
        $.each($('#shareFreeAccessModal').find('input[type="email"]'), function(index, elem){
            if($(elem).val()!=""){
                $("#shareFreeAccessModal .free_access_email_lists>.error_notice").hide();
                if(isEmail($(elem).val()) == false){
                    $(elem).parent().find(".error_notice").show();                    
                    flag = false;                     
                }else{
                    $(elem).parent().find(".error_notice").hide();                                    
                    flag = true; 
                }  
                flag_a = true;                                    
            }            
        });
        if(flag_a==false){
            $("#shareFreeAccessModal .free_access_email_lists>.error_notice").show();
            return;
        }
        $(this).html("Inviting");
        console.log('helo');
        if(flag){            
            $.ajax({
                type: "post",
                url : '/invite_user_for_free_access',
                data : $("#shareFreeAccessModal form").serialize(),
                dataType: 'json',
                success: function(res){                    
                    if(res.success == true){
                        $("#shareFreeAccessModal .invalid-feedback").css({'display':'block','color':'green'});                        
                        setTimeout(function() {
                            $("#shareFreeAccessModal .invite").html("Invite");
                            $("#shareFreeAccessModal").modal('hide');
                            window.location.reload();        
                        }, 2000);
                        
                    }
                },
                error:function(status){
                    console.log(status);
                }
            });
        }    
    });

    //share free access to data  end

    $('#deleteModal .confirm').click(function(e){
        var user_id = $("#deleteModal").find("input[name='list_userIdx']").val();     
        var type = $("#deleteModal").find("input[name='user_type']").val();        

        if(user_id){
            $.ajax({
                type: "post",
                url : '/user/delete',
                data : {user_id: user_id, _token:$("#deleteModal").find('input[name="_token"]').val(), type: type},
                dataType: 'json',
                success: function(res){
                    if(res.success == true){
                        window.location.reload();    
                    }
                }
            });
        }    
    });
    $('#buy-data').submit(function(e){
        
        e.preventDefault();
        var form = $(this);
        var id=$('#offerIdx').val();
        var pid=$('#productIdx').val();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback strong').html("");
        $.ajax({
            url: '/data/buy/'+id+'/'+pid,
            method: 'post',
            data: $(this).serialize(),
            success: function(response){
                if(response.success == true){
                    if(response.redirect !== undefined){
                        window.location.href = response.redirect;
                    }else{
                        if(!form.data('cc-on-file')){
                            Stripe.setPublishableKey(form.data('stripe-publishable-key'));
                            try{
                                Stripe.createToken({
                                    number: $('#card_number').val(),
                                    cvc: $('#cvc').val(),
                                    exp_month: $('#exp_month').val(),
                                    exp_year: $('#exp_year').val()
                                }, stripeResponseHandler);
                            }catch(e){
                                console.log(e);
                                $('#load_div').css('display','none');
                            }
                        }
                    }
                }else{
                    $('#load_div').css('display','none');
                    if(response.result !==undefined){
                        result = response.result;
                        $.each(result, function(field,messages){
                            $("#"+field).addClass('is-invalid');
                            $('.invalid-feedback.'+field+" strong").html(messages[0]);
                        });
                    }
                    if(response.redirect !== undefined){
                        window.location.href = response.redirect;
                    }
                }      
            }
        })
    });
    function stripeResponseHandler(status, response){
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            $('.error').addClass('hide');
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $('#buy-data').find('input[type=text]').empty();
            $('#buy-data').append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $('#buy-data').get(0).submit();
        }
    }

    //share offer
    $('#shareModal .more_email').click(function(e){        
        /* e.preventDefault(); */
        var emails_number = $("#share_count").val();
        var input_field = '<div class="row item'+(+emails_number+1)+'"><div class="col-md-10">'+
                            '<label class="pure-material-textfield-outlined">'+
                                    '<input type="email" id="email'+(+emails_number+1)+'" name="linked_email[]" class="form-control2 input_data" placeholder=" "  value="">'+
                                    '<span>Email '+(+emails_number+1)+'</span>'+
                                    '<div class="error_notice">Email format is incorrect.</div>'+
                            '</label>'+
                            '</div>'+
                            '<div class="col-md-2">'+
                                    '<a id="'+(+emails_number+1)+'" class="removemail"><i class="fa fa-times" aria-hidden="true"></i></a>'+
                            '</div></div>';
            
        $(".email_lists").append(input_field); 
        $("#share_count").val(1+ +emails_number);       
    });
   /*  $('#shareModal .removemail').on('click',function(e){        
       
       
    }); */
    $(document).on('click','#shareModal .removemail',function(e){

        e.preventDefault();
        if($(".email_lists label").length > 1){
            
            var id = $(this).attr('id');            
            $('.item'+id).remove();
        }else{
            
        }
      
      });

        $('#shareModal .shareoffer').click(function(e){
            var flag = false;
            var flag_a = false;
            $.each($('#shareModal').find('input[type="email"]'), function(index, elem){
                if($(elem).val()!=""){
                    $("#shareModal .email_lists>.error_notice").hide();
                    if(isEmail($(elem).val()) == false){
                        $(elem).parent().find(".error_notice").show();                    
                        flag = false;                     
                    }else{
                        $(elem).parent().find(".error_notice").hide();                                    
                        flag = true; 
                    }  
                    flag_a = true;                                    
                }            
            });
            if(flag_a==false){
                $("#shareModal .email_lists>.error_notice").show();
            }
            $(this).html("Sharing..");
            if(flag){            
                $.ajax({
                    type: "post",
                    url : '/data/share_offer',
                    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				        },
                    data : $("#shareModal form").serialize(),
                    dataType: 'json',
                    success: function(res){                        
                        if(res.success == true){
                            $("#shareModal .share-feedback").css('display', 'block').css('color','green');
                            $("#shareModal .shareoffer").html("Share");
                            setTimeout(function(){
                                $("#shareModal").modal('hide');
                                window.location.reload();        
                            }, 2000);
                            
                        }
                    },
                    error:function(status){
                        console.log(status);
                    }
                });
            }    
        });


        $('#addOrgModal .addorg').click(function(e){
            var flag = true;
            var flag_a = false;
            
            if($('#orgName').val() == false){
                $('#orgName').parent().find(".error_notice").html('Enter organization name.').show();                                 
                flag = false;                     
            }else{
                $('#orgName').parent().find(".error_notice").hide();                                    
                flag = true; 
            }  
            
            if(flag){            
                $(this).html("Adding..").attr('disabled',true);
                $.ajax({
                    type: "post",
                    url : '/profile/add_org',
                    data : $("#addOrgModal form").serialize(),
                    dataType: 'json',
                    success: function(res){                        
                        if(res.success == true){
                            $("#addOrgModal .add-org-feedback").css({'display':'block','color':'green'});
                            $("#addOrgModal .addorg").html("Add").attr('disabled',false);

                            setTimeout(function(){
                               
                                $("#addOrgModal").modal('hide');                                
                                if($('#fromPage').val() == ''){
                                    window.location.reload();      
                                }
                                $("#addOrgModal .add-org-feedback").css({'display':'none','color':'green'});
                                $("#addOrgModal form").find("input,textarea,select")
                                    .val('')
                                    .end();
                                
                            }, 2000); 
                        }
                    }
                });
            }    
        });
    
        $('#editOrgModal .editorg').click(function(e){
            var flag = true;
            
            if($('#editOrgName').val() == false){
                $('#editOrgName').parent().find(".error_notice").show();                    
                flag = false;                     
            }else{
                $('#editOrgName').parent().find(".error_notice").hide();                                    
                flag = true; 
            }  
            
            if(flag){            
                $(this).html("Updating..").attr('disabled',true);
                $.ajax({
                    type: "post",
                    url : '/profile/edit_org',
                    data : $("#editOrgModal form").serialize(),
                    dataType: 'json',
                    success: function(res){                        
                        if(res.success == true){
                            $("#editOrgModal .add-org-feedback").css({'display':'block','color':'green'});
                            $("#editOrgModal .editorg").html("Update").attr('disabled',false);
                            
                            setTimeout(function(){
                                $("#editOrgModal").modal('hide');
                                window.location.reload();      
                            }, 2000);
                              
                        }
                    }
                });
            }    
        });

        $('#inviteUserOrg .inviteuser').click(function(e){
            var flag = true;
            
            const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            
            if($('#orgUserEmail').val() == ''){
                $('#orgUserEmail').parent().find(".error_notice").show();                    
                flag = false;                     
            }else{
                
                let res = re.test($('#orgUserEmail').val());  
                if(!res){
                    $('#orgUserEmail').parent().find(".error_notice").html('Please enter valid email.').show();
                    flag = false;   
                }else{
                    $('#orgUserEmail').parent().find(".error_notice").hide();                                    
                    flag = true; 
                }
            }  
            
            if(flag){            
                $(this).html("Inviting..").attr('disabled',true);
                $.ajax({
                    type: "post",
                    url : '/profile/add_org_user',
                    data : $("#inviteUserOrg form").serialize(),
                    dataType: 'json',
                    success: function(res){                    
                        if(res.success == true){
                            $("#inviteUserOrg .add-org-user-feedback").css({'display':'block','color':'green'});
                            $("#inviteUserOrg .inviteuser").html("Confirm").attr('disabled',false);
                            
                            setTimeout(function() {
                                $("#inviteUserOrg .add-org-user-feedback").css({'display':'none','color':'green'});
                                $("#inviteUserOrg").modal('hide');
                                
                                if($('#invitePage').val() == ''){
                                    window.location.reload();      
                                }else if( $('#invitePage').val() == 'product'){
                                    addUsersToProduct('addedit');
                                }else if( $('#invitePage').val() == 'details'){

                                    addUsersToProductDetailsPage($('#inviteProductIdx').val());
                                }
                                $("#inviteUserOrg form").find("input,textarea,select")
                                    .val('')
                                    .end();
                                
                                }, 2000);
                              
                        }/* if result comes false */
                        else if(res.success == false) {
                            $("#inviteUserOrg .add-org-user-error").css({'display':'block','color':'red'});
                            $("#inviteUserOrg .inviteuser").html("Confirm").attr('disabled',false);
                            setTimeout(function() {
                                $("#inviteUserOrg .add-org-user-error").css({'display':'none','color':'red'});
                                $("#inviteUserOrg").modal('hide');
                                
                                if($('#invitePage').val() == ''){
                                    window.location.reload();      
                                }
                                $("#inviteUserOrg form").find("input,textarea,select")
                                    .val('')
                                    .end();
                                
                            }, 1000);
                        }
                    }
                });
            }    
        });

        $('#editInvitedOrgUser .editInviteduser').click(function(e){
            var flag = true;
            
            if($('#editOrgUserEmail').val() == ''){
                $('#editOrgUserEmail').parent().find(".error_notice").show();                    
                flag = false;                     
            }else{
                $('#editOrgUserEmail').parent().find(".error_notice").hide();                                    
                flag = true; 
            }  
            
            if(flag){            
                $(this).html("Updating..").attr('disabled',true);
                $.ajax({
                    type: "post",
                    url : '/profile/edit_org_user',
                    data : $("#editInvitedOrgUser form").serialize(),
                    dataType: 'json',
                    success: function(res){                        
                        if(res.success == true){
                            $("#editInvitedOrgUser .edit-org-user-feedback").css({'display':'block','color':'green'});
                            $("#editInvitedOrgUser .editInviteduser").html("Update").attr('disabled',false);
                            
                            setTimeout(function() {
                                $("#editInvitedOrgUser").modal('hide');
                                window.location.reload();      
                            }, 2000);
                              
                        }
                    }
                });
            }    
        });

        $('#resendInvitation .resendInvite').click(function(e){
            var flag = 'automatic';
            
            var ele = $('.sendInviteAutomatic'); 
              
            for(i = 0; i < ele.length; i++) { 
                if(ele[i].checked) 
                    flag = ele[i].value; 
            } 
            
            if(flag == 'automatic'){            
                $(this).html("Sending..").attr('disabled',true);
                $.ajax({
                    type: "post",
                    url : '/profile/resend_org_user_invite',
                    data : $("#resendInvitation form").serialize(),
                    dataType: 'json',
                    success: function(res){                        
                        if(res.success == true){
                            $("#resendInvitation .edit-org-user-feedback").css({'display':'block','color':'green'});
                            $("#resendInvitation .resendInvite").html("Resend Invite").attr('disabled',false);
                            
                            setTimeout(function() {
                                $("#resendInvitation").modal('hide');
                                window.location.reload();      
                            }, 2000);
                              
                        }
                    }
                });
            }else{
                $("#resendInvitation").modal('hide');                
            }   
        });


        $('#shareDataProdcuts .shareUsers').click(function(e){
            var flag = true;
            var flag_a = false;
            
            if($('#selected_products').val() == ''){                
                $("#shareDataProdcuts .share-product-error-feedback").css({'display':'block','color':'red'});               
                flag = false;                     
            }else{
                $("#shareDataProdcuts .share-product-error-feedback").css({'display':'none','color':'red'});                                    
                flag = true; 
            }  
            
            if(flag){            
                $(this).html("Sharing...").attr('disabled',true);
                $.ajax({
                    type:'post',
                    url:'/data/offers/share_data_proucts',
                    data : $("#shareDataProdcuts form").serialize(),
                    dataType: 'json',
                    success: function(res){                        
                        if(res.success == true){
                            $("#shareDataProdcuts .share-product-feedback").css({'display':'block','color':'green'});
                            $("#shareDataProdcuts .shareUsers").html("Share").attr('disabled',false);;

                            setTimeout(function() {
                               
                                $("#shareDataProdcuts").modal('hide');
                              
                                $("#shareDataProdcuts .share-product-feedback").css({'display':'none','color':'green'});
                                $("#shareDataProdcuts form").find("input,textarea,select")
                                    .val('')
                                    .end();
                                window.location.reload();
                                
                            }, 2000); 
                        }
                    }
                });
            }    
        });

        $('#selectUserForProductModal .inviteUsers').click(function(e){
            var flag = true;
            if(flag){            
                $(this).html("Mapping..").attr('disabled',true);
                $.ajax({
                    type: "post",
                    url : '/profile/invite_users_to_data_product',
                    data : $("#selectUserForProductModal form").serialize(),
                    dataType: 'json',
                    success: function(res){                        
                        if(res.success == true){
                            $("#selectUserForProductModal .invite-users-feedback").css({'display':'block','color':'green'});
                            $("#selectUserForProductModal .inviteUsers").html("Map With Users").attr('disabled',false);
                            
                            setTimeout(function() {
                                $("#selectUserForProductModal .invite-users-feedback").css({'display':'none','color':'green'});
                                $("#selectUserForProductModal").modal('hide');                                 
                            }, 2000);
                              
                        }
                    }
                });
            }    
        });
    
        $("#resendInvitation").on("hidden.bs.modal", function () {
            // put your default event here            
            $('#sendAutomatic').prop('checked',true);
        });


});

   
function removeAccessToOffer(id,elm){
    
    $(elm).attr('disabled',true);
    $(elm).text('Removing...');

    $.ajax({
        type: "post",
        url : '/data/remove_access_to_offer',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        data :{'shareIdx':id},
        dataType: 'json',
        success: function(res){            
            if(res.success == true){
               
                window.location.reload();    
            }
        },
        error:function(status){
            console.log(status);
        }
    });
}
/*Dropdown Menu*/
$('.dropdown-container .dropdown').click(function () {
    $(this).attr('tabindex', 1).focus();
    $(this).toggleClass('active');
    $(this).find('.dropdown-menu').slideToggle(300);    
});
$('.dropdown-container .dropdown').focusout(function () {
    $(this).removeClass('active');
    $('.dropdown-container .dropdown-menu').slideUp(300);
});
$('.dropdown-container .dropdown .dropdown-menu li').click(function () {
    $(this).parents('.dropdown-container .dropdown').find('span').text($(this).text());
    $(this).parents('.dropdown-container .dropdown').find('input').attr('value', $(this).attr('value')).change();
});

$(".nav-tabs .nav-link").click(function(){
    $(".nav-tabs .nav-link").removeClass('active');
    $(this).addClass('active');
});
/*End Dropdown Menu*/
$("#copyToClipboard").click(function(){    
    var copyText = $("#uniqueId").html();    
    copyTextToClipboard(copyText);
});
function copyTextToClipboard(text) {
    var textArea = document.createElement( "textarea" );
    textArea.value = text;
    document.body.appendChild( textArea );
    textArea.select();
    try {
        var successful = document.execCommand( 'copy' );
        var msg = successful ? 'successful' : 'unsuccessful';        
    } catch (err) {
        console.log('Oops, unable to copy');
    }
    document.body.removeChild( textArea );
}
var navbar_menu_visible = 0;
$(document).on('click', '.navbar-toggler', function() {
    $toggle = $(this);
  
    if (navbar_menu_visible == 1) {
      $('html').removeClass('nav-open');
      navbar_menu_visible = 0;
      $('#bodyClick').remove();
      setTimeout(function() {
        $toggle.removeClass('toggled');
      }, 150);
  
      $('html').removeClass('nav-open-absolute');
    } else {
      setTimeout(function() {
        $toggle.addClass('toggled');
      }, 180);
  
  
      div = '<div id="bodyClick" style="display:none"></div>';
      $(div).appendTo("body").click(function() {
        $('html').removeClass('nav-open');
  
        if ($('nav').hasClass('navbar-absolute')) {
          $('html').removeClass('nav-open-absolute');
        }
        navbar_menu_visible = 0;
        $('#bodyClick').remove();
        setTimeout(function() {
          $toggle.removeClass('toggled');
        }, 150);
      });
  
      if ($('nav').hasClass('navbar-absolute')) {
        $('html').addClass('nav-open-absolute');
      }
  
      $('html').addClass('nav-open');
      navbar_menu_visible = 1;
    }
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

	// Auto Hide Success and Error custom messages
	$(".jq-auto-hide").fadeTo(5000, 500).slideUp(500, function() {
		$(".jq-auto-hide").slideUp(5000);
	});

function editOrgationazation(orgIdx,orgName){
    $('#orgIdx').val(orgIdx);
    $('#editOrgName').val(orgName);
    $('#editOrgModal').modal('show');

}
function deleteOrganization(orgIdx){

    let res = confirm('Are you sure to delete organization?\n');
    if(res){
        $.ajax({

            method:'post',
            url: '/profile/delete_org',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
    		data: {'orgIdx':orgIdx},
    		dataType: 'json',
    		success:function(response){                
                window.location.reload(); 
            }

        });
    }
}


function inviteUser(orgIdx,from,productIdx){    
    var from = from || '';
	var productIdx = productIdx || '';
    if(from == 'product'){
        $('#selectUserModal').modal('hide');  
        $('#invitePage').val('product');  
    }
    if(from == 'details'){
        $('#selectUserForProductModal').modal('hide');  
        $('#invitePage').val('details'); 
        $('#inviteProductIdx').val(productIdx); 
    }
    $('#inviteorgIdx').val(orgIdx);    
    $('#inviteUserOrg').modal('show');

}
function editUser(orgIdx,orgUserIdx,orgUserEmail){
    
    $('#editorgIdx').val(orgIdx);
    $('#orgUserIdx').val(orgUserIdx); 
    $('#editOrgUserEmail').val(orgUserEmail);    
    $('#editInvitedOrgUser').modal('show');
}
function deleteOrgUser(orgUserIdx){

    let res = confirm('Are you sure to delete user?');
    if(res){
        $.ajax({

            method:'post',
            url: '/profile/delete_org_user',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
    		data: {'orgUserIdx':orgUserIdx},
    		dataType: 'json',
    		success:function(response){                
                window.location.reload(); 
            }

        });
    }
}

function resendInvitation(orgUserIdx){

$('#inviteUserIdx').val(orgUserIdx);
    $('#resendInvitation').modal('show');

}

function addUsersToProduct(from){    
    var from = from || '';
    $.ajax({
                type: "get",
                url : '/profile/get_organizations',                    
                dataType: 'json',
                success: function(res){                    
                    if(res.success == true){
                        if(res.sharingOrganisations.length > 0){
                            
                            let content = '';
                            let users = [];
                            let selected_users = '';
                            if(from == ''){
                                selected_users = $('#selected_users').val();                                
                            }else{                                
                                selected_users = $('#addeditselected_users').val();
                            }
                                                        

                            if(selected_users != ''){                                
                                users = selected_users.split(',');        
                            }
                           
                            $.each(res.sharingOrganisations,function(key,element){                                
                                content +='<tr><td  class="accordion-toggle collapsed colspan3"  id="accordion1" data-toggle="collapse" data-parent="#accordion'+key+'" href="#collapse'+key+'" >'
                                            +'<div class="row"><div class="col-8"><span class="expand-button"></span>'+element['orgName']+' ('+element['org_users'].length+')</div>'
                                            +'<div class="col-4"> <a  title="add user" onclick="inviteUser(&quot;'+element['orgIdx']+'&quot;,&quot;product&quot;)">'
                                            +'<i class="icon material-icons mdl-badge my-icon">person_add</i>'
                                            +'</a></div></div></td></tr>'
                                            +'<tr class="hide-table-padding">'                                                
                                            +'<td colspan="3">'
                                            +'<div id="collapse'+key+'" class="collapse in p-3">';
                                        if(element['org_users'].length > 0){    
                                            $.each(element['org_users'],function(key1,user){
                                                let is_selected = '';
                                                if($.inArray(""+user['orgUserIdx'],users) != -1){
                                                    is_selected = '#88e9d6';
                                                }
                                                let status = '<div class="dot pending-dot"></div>'; 
                                                if(user['isUserRegistered'] == true){
                                                        status = '<div class="dot active-dot"></div>';
                                                }
                                                content +='<div class="row">'
                                                                    +'<div class="col-8 pt-1">'+user['orgUserEmail']+'</div>'
                                                                    +'<div class="col-1 pt-1">'
                                                                    +status
                                                                    +'</div>'
                                                                    +'<div class="col-3">'
                                                                        +'<a class="btn btn-sm btn-danger select-button" style="background:'+is_selected+'" title="select user" onclick="selectUser(&quot;'+user['orgUserIdx']+'&quot;,&quot;'+user['orgUserEmail']+'&quot,&quot;'+element['orgName']+'&quot;,this,&quot;addedit&quot;)"> select</a>'
                                                                    +'</div>'
                                                                +'</div><br>'
                                                                
                                                            });
                                            +'</div></td></tr>';
    
                                        }
                                                                                   
                            });                       
                            $('#org_list').html(content);
                            $('#selectUserModal').modal('show');								
                        }else{
                            $('#confirmingFrom').val('');
                            $('#confirmBox').modal('show');
                        
                        }
                    }
                }
    });


    
}
function addUsersToProductDetailsPage(productIdx){
    var productIdx = productIdx || '';
    $.ajax({
                type: "get",
                url : '/profile/get_organizations',   
                data:{'productIdx':productIdx},                 
                dataType: 'json',
                success: function(res){                    
                    if(res.success == true){
                        if(res.sharingOrganisations.length > 0){
                            
                            let content = '';
                            let users = [];
                            let selected_users = res.product_sahre_users;
                            $('#selected_users').val(res.product_sahre_users);
                            $('#selected_productIdx').val(productIdx);
                            if(selected_users != ''){
                                users = selected_users.split(',');        
                            }
                            
                            $.each(res.sharingOrganisations,function(key,element){                                
                                content +='<tr><td  class="accordion-toggle collapsed colspan3"  id="accordion1" data-toggle="collapse" data-parent="#accordion'+key+'" href="#collapse'+key+'" >'
                                            +'<div class="row"><div class="col-8"><span class="expand-button"></span>'+element['orgName']+' ('+element['org_users'].length+')</div>'
                                            +'<div class="col-4"> <a  title="add user" onclick="inviteUser(&quot;'+element['orgIdx']+'&quot;,&quot;details&quot;,&quot;'+productIdx+'&quot;)">'
                                            +'<i class="icon material-icons mdl-badge my-icon">person_add</i>'
                                            +'</a></div></div></td></tr>'
                                            +'<tr class="hide-table-padding">'                                                
                                            +'<td colspan="3">'
                                            +'<div id="collapse'+key+'" class="collapse in p-3">';
                                        if(element['org_users'].length > 0){    
                                            $.each(element['org_users'],function(key1,user){
                                                let is_selected = '';
                                                if($.inArray(""+user['orgUserIdx'],users) != -1){
                                                    is_selected = '#88e9d6';
                                                }
                                                let status = '<div class="dot pending-dot"></div>'; 
                                                if(user['isUserRegistered'] == true){
                                                        status = '<div class="dot active-dot"></div>';
                                                }
                                                content +='<div class="row">'
                                                                    +'<div class="col-8 pt-1">'+user['orgUserEmail']+'</div>'
                                                                    +'<div class="col-1 pt-1">'
                                                                    +status
                                                                    +'</div>'
                                                                    +'<div class="col-3">'
                                                                        +'<a class="btn btn-sm btn-danger select-button" style="background:'+is_selected+'" title="select user" onclick="selectUser(&quot;'+user['orgUserIdx']+'&quot;,&quot;'+user['orgUserEmail']+'&quot,&quot;'+element['orgName']+'&quot;,this)"> select</a>'
                                                                    +'</div>'
                                                                +'</div><br>'
                                                                
                                                            });
                                            +'</div></td></tr>';
    
                                        }
                                                                                   
                            });                       
                            $('#org_user_list').html(content);
                            $('#selectUserForProductModal').modal('show');								
                        }else{

                            $('#confirmingFrom').val('detailspage');
                            $('#confirmBox').modal('show');
                        
                        }
                    }
                }
    });


    
}

function showAddOrg(){

    $('#fromPage').val('product');
    $('#confirmBox').modal('hide');    
    $('#addOrgModal').modal('show');
}
function selectUser(orgUserIdx,orgUserEmail,orgName,elem,from){
    var from = from || '';
    let users = [];
    let selected_users = $('#selected_users').val();
    if(from == 'addedit'){
        
        selected_users = $('#addeditselected_users').val();
    }
    if(selected_users != ''){
        users = selected_users.split(',');        
    }
    let index = users.indexOf(""+orgUserIdx);
    if(index == -1){

        users.push(orgUserIdx);
        let content ='<div class="col-lg-12" style="margin: 0.5% 0;" id="selected_user_'+orgUserIdx+'">'
                     +'<div class="col-md-5" style="float:left"><a href="javascript:void(0)">'+orgName+'('+orgUserEmail+')</a></div>'
                     +'<div class="col-md-2" style="float:left"  title="Remove user">'
                     +'<a onclick="removeSelectedUser(&quot;'+orgUserIdx+'&quot;)"><i class="icon material-icons mdl-badge my-icon">highlight_off</i><a>'
                     +'</div>'
                     +'</div>';
                     
        $('#selected_users_list').append(content);    
        $('#selected_users').val(users.join(','));
        if(from == 'addedit'){
        
            $('#addeditselected_users').val(users.join(','));
        }
        $(elem).css('background','#88e9d6');
    }   
}
function removeSelectedUser(orgUserIdx){    
    
    let users = $('#selected_users').val();
    let selected_users = users.split(',');
    let index = selected_users.indexOf(""+orgUserIdx);
    if(index != -1){

        selected_users.splice(index,1)
    }
    $('#selected_users').val(selected_users.join(','));
    $('#addeditselected_users').val(selected_users.join(','));//removes deleted users from list
    $("#selected_user_"+orgUserIdx).remove();
}

function sahreDataProducts(id,OrgOrProduct){
    if(OrgOrProduct == 'org'){
        $('#ShareProductOrgIdx').val(id);
        $('#ShareProductOrgUserIdx').val('');
    }else{
        $('#ShareProductOrgIdx').val('');
        $('#ShareProductOrgUserIdx').val(id);
    }

    $.ajax({
        type:'post',
        url:'/data/offers/get_data_products',   
        data : {'id':id,'OrgOrProduct':OrgOrProduct},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',     
        success:function(response){            
            let content = "";
            {/* <a class="btn btn-sm btn-danger select-button" title="select user" onclick="alert()">'+'Select All</a> */}
            let selected_products = [];
            $.each(response.data,function(key,element){                
                /* $('#selected_products').val(products.join(','));
                $(elem).css('background','#88e9d6').html('Unselect'); */
                content +='<tr><td  class="accordion-toggle collapsed colspan3"  id="accordion'+key+'" data-toggle="collapse" data-parent="#accordion'+key+'" href="#collapse'+key+'" >'
                            +'<div class="row"><div class="col-8"><span class="expand-button"></span><b>'+element['offerTitle']+' ('+element['offer_products'].length+')</b></div>'
                            +'<div class="col-4"> </div></div></td></tr>'
                            +'<tr class="hide-table-padding">'                                                
                            +'<td colspan="3">'
                            +'<div id="collapse'+key+'" class="collapse in p-3">';
                        if(element['offer_products'].length > 0){    
                            $.each(element['offer_products'],function(key1,product){
                                let is_selected = '';
                                let button = '<a class="btn btn-sm btn-danger select-button" title="select user" onclick="selectProduct(&quot;'+product['productIdx']+'&quot;,this)"> select</a>';
                                if(product['is_selected'] == true){
                                    selected_products.push(product['productIdx']);
                                     button = '<a style="background:#88e9d6" class="btn btn-sm btn-danger select-button" title="select user" onclick="selectProduct(&quot;'+product['productIdx']+'&quot;,this)"> Unselect</a>';
                                }
                                                               
                                content +='<div class="row">'
                                                    +'<div class="col-8 pt-1"><b>'+product['productTitle']+'</b></div>'                                                   
                                                    +'<div class="col-3">'
                                                        +button
                                                    +'</div>'
                                                +'</div><br>'
                                                
                                            });
                            +'</div></td></tr>';

                        }

                $('#products_list').html(content);
                                                                   
            });
            $('#selected_products').val(selected_products.join(','));
        },
        error:function(status){
            console.log(status);
        }
    })

    $('#shareDataProdcuts').modal('show');
}

function selectProduct(productIdx,elem){

    let products = [];
    let selected_products = $('#selected_products').val();
    if(selected_products != ''){
        products = selected_products.split(',');        
    }
    let index = products.indexOf(""+productIdx);
    if(index > -1){
        
        products.splice(index,1);        
        $('#selected_products').val(products.join(','));
        $(elem).css('background','#f33527').html('Select');  
       
    }else{

        products.push(productIdx);         
        $('#selected_products').val(products.join(','));
        $(elem).css('background','#88e9d6').html('Unselect');      
    }
}

function shareProducts(){

    $.ajax({
        type:'post',
        url:'/data/offers/share_data_proucts',   
        data : $("#shareDataProdcuts form").serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',     
        success:function(response){            
        }
    });   
}

function checkProductType(type){    
    var n = jQuery(".product_type:checked").length;
    var isPrivateChecked = false;
    if (n > 0){
        jQuery(".product_type:checked").each(function(){            
            if($(this).val() == 'PRIVATE')
                isPrivateChecked = true
        });
    }
    if(isPrivateChecked){
        $('#selected_users_list').css('display','flex');
        $('#add_users').css('display','inline');        
    }else{

        $('#selected_users_list').css('display','none');
        $('#add_users').css('display','none');
    }
}

function inviteTypeChnage(type,ele){
    if(type == 'automatic'){

        $('#resend_automatic').css('display','block');
        $('#resend_manula').css('display','none');
    }else{

        $('#resend_automatic').css('display','none');
        $('#resend_manula').css('display','block');
    }
}

function copyInviteLink(str,elm) {		

    var value= '<input value="'+str+'" id="selVal" style="opacity:0.1" />';
    $(value).insertAfter('#linkcopied');
    $("#selVal").select();
    document.execCommand("Copy");
    $('body').find("#selVal").remove();
    $('#linkcopied').css('display','block');
    setTimeout(function(){ 
        $('#linkcopied').css('display','none');            
    }, 1000); 

}

function addEmailsToShare($productIdx){
    $('#invite_productIdx').val($productIdx);
    $('#shareFreeAccessModal').modal('show');
}
function removeme(ele){
    $(ele).parent().remove();
}

function showcomment(comment){            
    $('#showBuyerComment').html(comment);
    $('#buyerCommentModal').modal('show');
}

    

