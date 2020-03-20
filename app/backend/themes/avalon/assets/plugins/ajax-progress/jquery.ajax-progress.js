(function( $ ) {
    var stack = [];

    $(document)
        .ajaxSend(function(event, jqxhr, settings) {
            if(!stack.length) {
                $(document).skylo('start');
            }
            stack.push(settings.url);
        })
        .ajaxComplete(function(event, jqxhr, settings) {
            for(var key in stack) {
                if (stack[key] == settings.url) {
                    stack.splice(key, 1);
                    break;
                }
            }

            if(!stack.length) {
                $(document).skylo('end');
            }
        });

})( jQuery );