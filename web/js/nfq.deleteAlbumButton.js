(function($){

    function bind(fn,obj) {
        return function() {
            fn.apply(obj,arguments);
        };
    }

    function DeleteAlbumButton() {};

    /**
     * @private
     */
    DeleteAlbumButton.prototype._create = function()
    {
        this._on(this.element,{
            "click": "onClick"
        });
    };

    /**
     * Event listener
     * @param event
     */
    DeleteAlbumButton.prototype.onClick = function(event) {
        event.preventDefault();
        this.delete();
    };

    /**
     * Sends delete request
     */
    DeleteAlbumButton.prototype.delete = function()
    {
        $.get(this.element.attr('href'), {}, bind(this._handleResponse, this),'json');
    };

    /**
     * Handles response
     */
    DeleteAlbumButton.prototype._handleResponse = function(data)
    {
        this.element.parents(".item").css( "background-color", "#E8CDCC" );
        if (data.status != 'OK') {
            alert('Error handling response');
        }
        this.element.parents(".item").fadeOut(300).unbind('click').attr('href', 'javascript:;');
    };

    $.widget('nfq.DeleteAlbumButton', DeleteAlbumButton.prototype);

    $(".delete").DeleteAlbumButton();

})(jQuery);