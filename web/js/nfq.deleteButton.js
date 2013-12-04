(function($){

    function bind(fn,obj) {
        return function() {
            fn.apply(obj,arguments);
        };
    }

    function DeleteButton() {};

    /**
     * @private
     */
    DeleteButton.prototype._create = function()
    {
        this._on(this.element,{
            "click": "onClick"
        });
    };

    /**
     * Event listener
     * @param event
     */
    DeleteButton.prototype.onClick = function(event) {
        event.preventDefault();
        this.delete();
    };

    /**
     * Sends delete request
     */
    DeleteButton.prototype.delete = function()
    {
        $.get(this.element.attr('href'), {}, bind(this._handleResponse, this),'json');
    };

    /**
     * Handles response
     */
    DeleteButton.prototype._handleResponse = function(data)
    {
        if (data.status == 'OK') {
            this.element.parents(".item").css( "background-color", "#E8CDCC" );
            this.element.parents(".item").fadeOut(300).unbind('click').attr('href', 'javascript:;');
        }else if (data.status == 'ERROR') {
            alert('ERROR: You probably tried deleting album`s title photo. Or you are unauthorized to delete this object.');
        } else {
            alert('Error handling request.');
        }
    };

    $.widget('nfq.DeleteButton', DeleteButton.prototype);

    $(".delete").DeleteButton();

})(jQuery);