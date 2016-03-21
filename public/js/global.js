(function(globals) {
    'use strict';
    $(function() {
        $('#logout').click(function() {
            $.post('/logout', '', function() {
                window.location="/";
            });
        });
    });
})(this);
