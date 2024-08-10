"use strict";
function Core(){
    var self = this;
    this.init = function(){
        self.actionItem();
        self.actionMultiItem();
        self.actionForm();
        self.setTimezone();
        self.Payment();
        self.Header();
        self.Fix_pricing();
        self.ajax_pages();
        AOS.init();

        $( window ).on( "resize", function() {
            self.Fix_pricing();
        });

    };

    this.Header = function(){
        //self.Fix_header();
        $(window).scroll(function (event) {
            self.Fix_header();
        });

        $(document).on("click", ".scroll-top .icon", function(){
            $('html,body').animate({ scrollTop: 0 }, 0);
        });
        
        $('.feature-marque-run-1').liMarquee({
            direction: "left",
            hoverstop: false
        });

        $('.feature-marque-run-2').liMarquee({
            direction: "right",
            hoverstop: false
        });
    };

    this.Fix_pricing = function(){
        var pricing_top_height = 50;
        $(".pricing-top").each(function(index, el){
            if(pricing_top_height < $(this).height()){
                pricing_top_height = $(this).height();
            }
        });

        $(".pricing-feature-comparison,.pricing-top").height( pricing_top_height );

        var plan_post_height = 50;
        $(".plan-post").each(function(index, el){
            if(plan_post_height < $(this).height()){
                plan_post_height = $(this).height();
            }
        });

        $(".plan-post").height( plan_post_height );
    }

    this.Fix_header = function(){
        var header = $(".header");
        var scroll = $(window).scrollTop();
        if( scroll > 20 ){
            header.addClass("active");
        }else{
            header.removeClass("active");
        }
    };

    this.Payment = function(){
        $(document).on("change", ".plan_by", function(){
            if($(this).is(":checked")){
                $(".by_monthly").addClass("d-none");
                $(".by_annually").removeClass("d-none");
            }else{
                $(".by_monthly").removeClass("d-none");
                $(".by_annually").addClass("d-none");
            }
        });
    };

    this.setTimezone = function(){
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "https://api.ip.sb/geoip",
            "dataType": "jsonp",
            "method": "GET",
            "headers": {
                "Access-Control-Allow-Origin": "*"
            }
        }
        
        $.ajax(settings).done(function (response) {
            var timezone = response.timezone;
            $.post(PATH+"timezone", {csrf:csrf, timezone:timezone}, function(){}, 'json');
            $(".auto-select-timezone").val(timezone);
        });
    };

    this.actionItem= function(){
        $(document).on('click', ".actionItem", function(event) {
            event.preventDefault();    
            var that           = $(this);
            var action         = that.attr("href");
            var id             = that.data("id");
            var data           = $.param({csrf:csrf, id: id});

            self.ajax_post(that, action, data, null);
            return false;
        });
    };

    this.actionMultiItem= function(){
        $(document).on('click', ".actionMultiItem", function(event) {
            event.preventDefault();    
            var that           = $(this);
            var form           = that.closest("form");
            var action         = that.attr("href");
            var params         = that.data("params");
            var data           = form.serialize();
            var data           = data + '&' + $.param({csrf:csrf}) + "&" + params;
            self.ajax_post(that, action, data, null);
            return false;
        });
    };

    this.actionForm= function(){
        $(document).on('submit', ".actionForm", function(event) {
            event.preventDefault();    
            var that           = $(this);
            var action         = that.attr("action");
            var data           = that.serialize();
            var data           = data + '&' + $.param({csrf:csrf});
            
            self.ajax_post(that, action, data, null);
        });
    };

    this.ajax_post = function(that, action, data, _function){
        var confirm        = that.data("confirm");
        var transfer       = that.data("transfer");
        var type_message   = that.data("type-message");
        var rediect        = that.data("redirect");
        var content        = that.data("content");
        var append_content = that.data("append-content");
        var callback       = that.data("callback");
        var history_url    = that.data("history");
        var hide_overplay  = that.data("hide-overplay");
        var call_after     = that.data("call-after");
        var remove         = that.data("remove");
        var type           = that.data("result");
        var object         = false;

        if(type == undefined){
            type = 'json';
        }

        if(confirm != undefined){
            if(!window.confirm(confirm)) return false;
        }

        if(history_url != undefined){
            history.pushState(null, '', history_url);
        }

        if(!that.hasClass("disabled")){
            if(hide_overplay == undefined || hide_overplay == 1){
                self.overplay();
            }
            that.addClass("disabled");
            $.post(action, data, function(result){
                
                //Check is object
                if(typeof result != 'object'){
                    try {
                        result = $.parseJSON(result);
                        object = true;
                    } catch (e) {
                        object = false;
                    }
                }else{
                    object = true;
                }

                //Run function
                if(_function != null){
                    _function.apply(this, [result]);
                }

                //Callback function
                if(result.callback != undefined){
                    $("body").append(result.callback);
                }

                //Callback
                if(callback != undefined){
                    var fn = window[callback];
                    if (typeof fn === "function") fn(result);
                }

                //Using for update
                if(transfer != undefined){
                    that.removeClass("tag-success tag-danger").addClass(result.tag).text(result.text);
                }

                //Add content
                if(content != undefined && object == false){
                    if(append_content != undefined){
                        $("."+content).append(result);
                    }else{
                        $("."+content).html(result);
                    }
                }

                //Call After
                if(call_after != undefined){
                    eval(call_after);
                }

                //Remove Element
                if(remove != undefined){
                    that.parents('.'+remove).remove();
                }

                //Hide Loading
                self.overplay(true);
                that.removeClass("disabled");

                //Redirect
                self.redirect(rediect, result.status);

                //Message
                if(result.status != undefined){
                    if(result.status == "error"){
                        $(".show-message").removeClass("text-danger text-success").addClass("text-danger").html(result.message);
                    }else{
                        $(".show-message").removeClass("text-danger text-success").addClass("text-success").html(result.message);
                    }
                }

            }, type).fail(function() {
                that.removeClass("disabled");
            });
        }

        return false;
    };

    this.ajax_pages = function(){
        if( $(".ajax-pages").length > 0 ){
            var that = $(".ajax-pages");
            var url = that.attr('data-url');
            var filter = $(".ajax-filter");
            var loading = that.attr('data-loading');
            var class_result = that.attr('data-response');
            var call_after = that.attr("data-call-after");
            var call_success = that.attr("data-call-success");
            var per_page = that.attr("data-per-page");
            var current_page = that.attr("data-current-page");
            var total_items = that.attr("data-total-items");

            if(current_page == undefined || Number.isNaN(current_page)){
                current_page = 1;
                loading = 0;
                that.attr('data-page', 0);
                that.attr('data-loading', 0);
            }

            var data = { 
                csrf: csrf, 
                current_page: current_page, 
                per_page: per_page, 
                total_items: total_items 
            };

            if( filter.length > 0 ){
                filter.each( function( index, value ) {
                    var name = $(this).attr("name");
                    var value = $(this).val();
                    data[name] = value;
                } );
            }

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: data
            }).done(function(result) {
                $('.ajax-loading').hide();

                $(class_result).html( result.data );

                

                //Call After
                if(call_after != undefined){
                    eval(call_after);
                }

                //Call Success
                if(call_success != undefined && result.status == 'success'){
                    eval(call_success);
                }

                if( $(".paginationjs").length == 0 || total_items != result.total_items ){
                    that.attr("data-total-items", result.total_items );
                    total_items = result.total_items;

                    self.ajax_pages_actions();
                    self.pagination(total_items, per_page, current_page, ".ajax-pages");
                }
            });
        }
    };

    this.ajax_pages_actions = function(){
        $(".ajax-pages-search").keyup(function(e) {
            clearTimeout(timeout);
            timeout = setTimeout(function(){
                e.preventDefault();
                self.ajax_pages();
            }, 500);
            return false;   
        });

        $(".ajax-pages-search").keydown(function(e) {
            if(e.which == 13) {
                return false;
            }   
        });
    };

    this.pagination = function(total_items, per_page, current_page, el_return){
        if( $(".ajax-pagination").length > 0 ){
            $('.ajax-pagination').pagination({
                dataSource: function(done){
                    var result = [];
                    for (var i = 1; i <= total_items; i++) {
                        result.push(i);
                    }
                    done(result);
                },
                pageNumber: current_page,
                pageSize: per_page,
                callback: function(data, pagination) {
                    $(el_return).attr("data-current-page", pagination.pageNumber);
                    self.ajax_pages();
                }
            });
        }
    };

    this.callbacks = function(_function){
        $("body").append(_function);
    };

    this.redirect = function(_rediect, _status){
        if(_rediect != undefined && _status == "success"){
            setTimeout(function(){
                window.location.assign(_rediect);
            }, 1500);
        }
    };

    this.overplay = function(status){
        if(status == undefined){
            $(".loading").show();
            if($(".modal").hasClass("in")){
                $(".loading").addClass("top");
            }else{
                $(".loading").removeClass("top");
            }
        }else{
            $(".loading").hide();
        }
    };

    this.notify = function(_message, _type){
        if(_message != undefined && _message != ""){
            switch(_type){
                case "success":
                    var backgroundColor = "#04c8c8";
                    break;

                case "error":
                    var backgroundColor = "#f1416c";
                    break;

                default:
                    var backgroundColor = "#ffc700";
                    break;
            }

            iziToast.show({
                theme: 'dark',
                icon: 'fad fa-bells',
                title: '',
                position: 'bottomCenter',
                message: _message,
                backgroundColor: backgroundColor,
                progressBarColor: 'rgb(255, 255, 255, 0.5)',
            });
        }
    };
}

var Core = new Core();
$(function(){
    Core.init();
});