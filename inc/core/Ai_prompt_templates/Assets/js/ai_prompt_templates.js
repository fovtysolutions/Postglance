"use strict";
function Ai_prompt_templates(){
    var self = this;
    this.init = function(){
    };

    this.saveContent = function(result){
        Core.ajax_pages();
        $('#addPromptTemplate').modal('hide');
    };
}

var Ai_prompt_templates = new Ai_prompt_templates();
$(function(){
    Ai_prompt_templates.init();
});