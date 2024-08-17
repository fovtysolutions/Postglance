"use strict";
function Whatsapp(){
    var self = this;
    this.init = function(){
        self.profiles();
        self.check_login();
        self.template();
        self.import_contact();
    };

    this.profiles = function(){
        $(document).on("click", ".seclect-shedule-time a", function(){
            var type = $(this).data("time");
            var hours = false;
            switch(type) {
                case "daytime":
                    hours = [7,8,9,10,11,12,13,14,15,16,17,18];
                    break;

                case "nighttime":
                    hours = [18,19,20,21,22,23,0,1,2,3,4,5,6];
                    break;

                case "odd":
                    hours = [1,3,5,7,9,11,13,15,17,19,21,23];
                    break;

                case "even":
                    hours = [0,2,4,6,8,10,12,14,16,18,20,22];
                    break;

                case "all":
                    hours = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];
                    break;
            }

            $(".schedule_time option").each(function(){
                var value = $(this).val();
                if( hours.includes( parseInt( value ) )  ){
                    $(this).attr("selected","selected");
                }else{
                    $(this).removeAttr("selected");
                }
                $(".schedule_time").change();
            });

        });
    };

    this.check_login = function(){
        if( $(".wa-qr-code").length > 0 ){

            var instance_id = $(".wa-qr-code").data("instance-id");
            $.ajax({
                url: PATH + "whatsapp_profiles/check_login/" + instance_id,
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

    this.template = function(){
        $(document).on("click", ".btn-wa-add-section", function(){
            var option = $(".wa-template-data-section").html();
            var count_msg_item = $(".wa-template-section .wa-template-section-item").length;
            option = option.replace(/{count}/g, (count_msg_item + 1));
            Core.emoji("btn_msg_display_text_"+count_msg_item);
            $(".wa-template-section").append(option);
            $(".wa-empty").hide();
        });

        $(document).on("click", ".btn-wa-add-list-option", function(){
            var that = $(this);
            var section_count = $(this).parents(".wa-template-section-item").attr("data-count");
            var option = $(".wa-template-data-option").html();
            option = option.replace(/{count}/g, parseInt(section_count));
            $(this).parents(".wa-template-section-item").find(".wa-template-option").append(option);
            $(".wa-empty").hide();
        });

        $(document).on("click", ".btn-wa-add-option", function(){
            var option = $(".wa-template-data-option").html();
            var count_msg_item = $(".wa-template-option .wa-template-option-item").length;
            option = option.replace(/{count}/g, (count_msg_item + 1));
            $(".wa-template-option").append(option);
            $(".wa-empty").hide();
            
            Core.emoji("btn_msg_display_text_"+count_msg_item);

            if( count_msg_item >= 2 ){
                $(".wa-template-wrap-add").addClass("d-none");
            }else{
                $(".wa-template-wrap-add").removeClass("d-none");
            }
        });

        $(document).on("click", ".wa-template-option-remove", function(){
            $(this).parents(".wa-template-option-item").remove();
            if( $(".wa-template-option .wa-template-option-item").length >= 3 ){
                $(".wa-template-wrap-add").addClass("d-none");
            }else{
                $(".wa-template-wrap-add").removeClass("d-none");
            }

            if($(".wa-template-option .wa-template-option-item").length == 0){
                $(".wa-empty").show();
            }
            return false;
        });

        $(document).on("click", '.radio-tab', function(){
            $(this).siblings().removeClass("text-primary");
            $(this).addClass("text-primary").find("input[type='radio']").prop('checked',true);
        });

    };

    this.import_contact = function(){
        if( $("#import_whatsapp_contact").length > 0 ){
            var url = $("#import_whatsapp_contact").data("action");

            $(document).on( 'change', '#import_whatsapp_contact', function(){
                var form_data = new FormData();
                var totalfiles = document.getElementById('import_whatsapp_contact').files.length;
                for (var index = 0; index < totalfiles; index++) {
                    form_data.append("files[]", document.getElementById('import_whatsapp_contact').files[index]);
                }

                Core.overplay();
                
                $(this).val('');
                $.ajax({
                    url: url, 
                    type: 'post',
                    data: form_data,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                            }
                        }, false);
                        xhr.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                            }
                        }, false);
                        return xhr;
                    },
                    success: function (result) {
                        Core.overplay(true);
                        if(result.status == "success"){
                            window.location.reload();
                        }else{
                            Core.notify(result.message, result.status);
                        }
                    }
                });

                return false;
            } );
        }
    };

}

var Whatsapp = new Whatsapp();
$(function(){
    Whatsapp.init();
});