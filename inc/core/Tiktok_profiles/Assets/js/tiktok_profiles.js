"use strict";
function Tiktok(){
    var self = this;
    this.init = function(){
        self.get_qrcode();
        self.check_login();
    };

    this.get_qrcode = function(){
        if( $(".tiktok-qr-code").length > 0 ){

            var instance_id = $(".tiktok-qr-code").data("instance-id");
            $.ajax({
                url: PATH + "tiktok_profiles/get_qrcode/" + instance_id,
                type: 'GET',
                dataType: "json",
                success: function(result){
                    console.log(result);

                    if(result.status == "success"){
                        $(".tiktok-code").html('<img class="w-300 h-300" src="'+result.qrcode+'">');
                    }else{
                        $(".tiktok-code").html(`
                            <div class="alert alert-danger">
                                `+result.message+`
                            </div>
                        `)
                    }
                },
                error: function(result){}
            });

        }
    };

    this.check_login = function(){
        if( $(".tiktok-qr-code").length > 0 ){

            var instance_id = $(".tiktok-qr-code").data("instance-id");
            $.ajax({
                url: PATH + "tiktok_profiles/check_login/" + instance_id,
                type: 'GET',
                dataType: "json",
                success: function(result){
                    if(result.status == "success"){
                        location.assign( PATH + "account_manager" );
                    }else{
                        setTimeout( function(){
                            self.check_login();
                        } , 2000);
                    }
                },
                error: function(result){}
            });

        }
    };
}

var Tiktok = new Tiktok();
$(function(){
    Tiktok.init();
});