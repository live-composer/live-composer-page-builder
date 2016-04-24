/**
 * Modal Window Class file
 */

'use strict';

;(function(){

    DSLC.ModalWindow = function(params)
    {
        if(typeof params != 'object') return false;

        // Show Modal Window
        var modalWindowWrap = '<div class="dslca-prompt-modal dslca-prompt-modal-active" style="opacity: 1; display: block;">' +
        '<div class="dslca-prompt-modal-content"><div class="dslca-prompt-modal-msg">' +
         '<span class="dslca-prompt-modal-title">' + params.title + '</span>' +
          '<span class="dslca-prompt-modal-descr">' + params.content + '</span></div>';

                if(("confirm" in params) && ("cancel" in params)){
                    var modalWindowActions = '<div class="dslca-prompt-modal-actions">' +
                    '<a href="#" class="dslca-prompt-modal-confirm-hook"><span class="dslc-icon dslc-icon-ok">' +
                    '</span>Confirm</a><span class="dslca-prompt-modal-cancel-hook"><span class="dslc-icon dslc-icon-remove">' +
                    '</span>Cancel</span></div>';

                }else {
                    var modalWindowActions = '<div class="dslca-prompt-modal-actions">' +
                    '<a href="#" class="dslca-prompt-modal-confirm-hook"><span class="dslc-icon dslc-icon-ok">' +
                    '</span>OK</a></div>';
                }

        modalWindowWrap += modalWindowActions + '</div>';
        modalWindowWrap = jQuery(modalWindowWrap);

        // Confirm handler (function)
        if(typeof params.confirm == 'function'){

            modalWindowWrap.find('.dslca-prompt-modal-confirm-hook')
            .click(function(e)
            {
                modalWindowWrap.find('.dslca-prompt-modal-content').animate({
                    top: '55%'
                }, 400);

                modalWindowWrap.animate(
                    {opacity: 0},
                    400,
                    function()
                    {
                        jQuery(this).remove();
                        params.confirm();
                    }
                );
            });
        }

        // Cancel handler (function)
        if(typeof params.cancel == 'function'){

                modalWindowWrap.find('.dslca-prompt-modal-cancel-hook')
                .click(function(e){

                    modalWindowWrap.find('.dslca-prompt-modal-content').animate({
                        top: '55%'
                    }, 400);

                    modalWindowWrap.animate(
                        {opacity: 0},
                        400,
                        function()
                        {
                            jQuery(this).remove();
                            params.cancel();
                        }
                    );
                });
        }

        modalWindowWrap.hide();

        jQuery("body").append(modalWindowWrap);

        modalWindowWrap.css({opacity: 0}).show().animate({
            opacity: 1,
        }, 400);

        // Animate modal
        modalWindowWrap.find('.dslca-prompt-modal-content').css({top: '55%'}).animate({
            top: '50%'
        }, 400);
    }

}());