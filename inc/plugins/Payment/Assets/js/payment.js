"use strict";
function Payment(){
    var self = this;
    var timeout;

    this.init = function(){
        self.action();
    };

    this.action = function(){
        $(document).on("change", ".plan_by", function(){

            console.log();

            if($(this).val() == 2){
                $(".by_monthly").addClass("d-none");
                $(".by_annually").removeClass("d-none");
            }else{
                $(".by_monthly").removeClass("d-none");
                $(".by_annually").addClass("d-none");
            }
        });

        $(document).on("click", ".btnMakePayment", function(){
            var plan_by = $(".plan_by:checked").val();
            var url = $(this).attr("href");
            window.location.assign(url+"/"+plan_by);
            return false;
        });
    }
}

var Payment = new Payment();
$(function(){
    Payment.init();
});