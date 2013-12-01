(function($){

    $('form').submit(function(e) {

        var url = $(this).attr('action');

        $.ajax({
            type: 'POST',
            url: url,
            data: $(this).serialize(),
            dataType: 'html',
            success: function(msg){
                if (msg == 'OK') {
                    var magnificPopup = $.magnificPopup.instance;
                    magnificPopup.updateItemHTML();
                } else {
                    alert('Error handling request.')
                }

            }
        });

        return false;

    });

})(jQuery);