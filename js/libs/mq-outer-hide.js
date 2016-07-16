/**
 * Hide element when click on another element on the page
 *
 * @author Alexey Petlenko
 */
jQuery.fn.outerHide = function(params)
{
    var $ = jQuery;
    params = params ? params : {};

    var self = this;

    if ( 'destroy' == params ) {

        $(document).unbind('click.outer_hide');
        return false;
    }

    $(document).bind('click.outer_hide', function(e) {

        if ($(e.target).closest(self).length == 0 &&
            e.target != self &&
            $.inArray($(e.target)[0], $(params.clickObj)) == -1 &&
            $(self).css('display') != 'none'
        )
        {
            if(params.clbk)
            {
                params.clbk();
            }else{
                $(self).hide();
            }
        }
    });
}