/**
 * Modal Window Class file
 */

'use strict';
/**
 * Shows modal window
 *
 * @param {object} params
 * @params.title         {string} - modal window title
 * @params.content       {string}- modal window description
 * @params.confirm       {function} - modal window confirm action
 * @params.cancel        {function} - modal window cancel action
 * @params.cancel_title  {string} - modal window cancel title
 * @params.confirm_title {string} - modal window confirm title
 * @params.ok_title {string} - modal window OK title
 */
LiveComposer.Builder.UI.CModalWindow = function(params) {

    if(typeof params != 'object' || this.instancesExists === true) return false;

    var self = this;

    // Show Modal Window
    var modalWindowWrap = '<div class="dslca-prompt-modal dslca-prompt-modal-active">' +
    '<div class="dslca-prompt-modal-content"><div class="dslca-prompt-modal-msg">' +
     '<span class="dslca-prompt-modal-title">' + params.title + '</span>' +
      '<span class="dslca-prompt-modal-descr">' + params.content + '</span></div>';

      var modalWindowActions = '';

    if (params.confirm || params.cancel) {

        modalWindowActions = '<div class="dslca-prompt-modal-actions">' +
        '<a href="#" class="dslca-prompt-modal-confirm-hook"><span class="dslc-icon dslc-icon-ok">' +
        '</span>' + (params.confirm_title ? params.confirm_title : 'Confirm') + '</a><span class="dslca-prompt-modal-cancel-hook"><span class="dslc-icon dslc-icon-remove">' +
        '</span>' + (params.cancel_title ? params.cancel_title : 'Cancel') +'</span></div>';
    } else {

        modalWindowActions = '<div class="dslca-prompt-modal-actions">' +
        '<a href="#" class="dslca-prompt-modal-confirm-hook"><span class="dslc-icon dslc-icon-ok">' +
        '</span>' + (params.ok_title ? params.ok_title : 'OK') + '</a></div>';
    }

    modalWindowWrap += modalWindowActions + '</div>';
    modalWindowWrap = jQuery(modalWindowWrap);

    if (typeof params.confirm != 'function') params.confirm = function(){};
    if (typeof params.cancel != 'function') params.cancel = function(){};

    // Confirm handler (function)

    modalWindowWrap.find('.dslca-prompt-modal-confirm-hook')
    .click(function(e)
    {
        e.stopPropagation();

        modalWindowWrap.find('.dslca-prompt-modal-content').animate({
            top: '55%'
        }, 400);

        modalWindowWrap.animate(
            {opacity: 0},
            400,
            function()
            {
                params.confirm();
                self.instancesExists = false;
                jQuery(this).remove();
                // – moved here as it prevent some JS to get value on time
            }
        );

        return false;
    });

    // Cancel handler (function)

    modalWindowWrap.find('.dslca-prompt-modal-cancel-hook')
    .click(function(e){

        e.stopPropagation();

        modalWindowWrap.find('.dslca-prompt-modal-content').animate({
            top: '55%'
        }, 400);

        modalWindowWrap.animate(
            {opacity: 0},
            400,
            function()
            {
                jQuery(this).remove();
                self.instancesExists = false;
                params.cancel();
            }
        );

        return false;
    });

    modalWindowWrap.hide();
    jQuery("body").append(modalWindowWrap);

    modalWindowWrap.css({opacity: 0}).show().animate({
        opacity: 1,
    }, 400);

    // Animate modal
    modalWindowWrap.find('.dslca-prompt-modal-content').css({top: '55%'}).animate({
        top: '50%'
    }, 400);

    this.instancesExists = true;
}