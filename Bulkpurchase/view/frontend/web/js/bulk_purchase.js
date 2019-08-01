define([
    "jquery",
    "jquery/ui"
], function($){

    "use strict";
     
    function main(config, element) {
        var $element = $(element);
        var AjaxUrl = config.AjaxUrl;
         
        var dataForm = $('#contact-form');
        dataForm.mage('validation', {});
         
        $(document).on('click','.bulk_purch_btn',function() {

                $(this).attr('disabled',true);
                $(this).val('Adding...');

                var cls = $(this).attr('class');
                var cls_part = cls.split(" ");

                if(cls_part[1]!='')
                {
                    var btn_cls = cls_part[1];
                    var bcls = btn_cls.split('pop_add');
                    var pid = bcls[1];

                    $.post(AjaxUrl, $('#bulk_add_form' + pid).serialize(), function(result) 
                    {

                        var response = $.parseJSON(result);

                        if(response.resp=='Success')
                        {
                            alert('Items added to cart successfully');
                            var cls_btn = '.'+cls_part[1];
                            $(cls_btn).val('Added to cart');
                        }
                        else
                        {
                            alert(response.resp);
                            var cls_btn = '.'+cls_part[1];
                            $(cls_btn).val('Add to Cart');
                            $(cls_btn).removeAttr('disabled');
                        }

                    });
                    
                }             
                
            });
    };

    return main;
     
     
});