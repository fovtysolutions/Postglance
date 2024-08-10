"use strict";
function Ai_content_generator(){
    var self = this;
    this.init = function(){
        $(document).on("click", ".aig-categories .item", function(){
            var pid = $(this).data("pid");
            var name = $(this).data("name");
            var icon = $(this).data("icon");
            var color = $(this).data("color");

            $(".aig-choice i").attr("class", icon).css("color", color);
            $(".aig-choice .name").text(name);
            $(".aig-headline .inactive").addClass("d-none");
            $(".aig-headline .active").removeClass("d-none");
            $(".aig-categories").addClass("d-none");
            $(".aig-list-items").removeClass("d-none");
            $(".aig-list-items li").addClass("d-none");
            $(".aig-scroll").scrollTop(0);
            $(".aig-list-items ul li").each(function(index, value){
                if( $(this).data("pid") == pid ){
                    $(this).removeClass("d-none");
                }
            });
        });

        $(document).on("click", ".aig-headline .active", function(){
            $(".aig-categories").removeClass("d-none");
            $(".aig-list-items").addClass("d-none");
            $(".aig-list-items li").addClass("d-none");
            $(".aig-headline .inactive").removeClass("d-none");
            $(".aig-headline .active").addClass("d-none");
            $(".aig-scroll").scrollTop(0);
        });

        $(document).on("click", ".aig-list-items ul li a", function(){
            var prompt = $(this).text();
            $("textarea[name='prompt']").val(prompt);

        });

        $(document).on("click", ".aig-modal .aig-results a", function(){
            var name = $(".aig-modal").data("name");
            var caption = $(this).find("span").text();
            $("textarea[name="+name+"]").val(caption).trigger("change");
            $("textarea[name="+name+"]").data("emojioneArea").editor.html(caption);
            $('#Ai_content_generatorModal').modal('hide');
            return false;
        });
    };

}

var Ai_content_generator = new Ai_content_generator();
$(function(){
    Ai_content_generator.init();
});