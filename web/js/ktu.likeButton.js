(function($){

    function bind(fn,obj) {
        return function() {
            fn.apply(obj,arguments);
        };
    }

    function LikeButton() {};

    /**
     * @private
     */
    LikeButton.prototype._create = function()
    {
        this._on(this.element,{
            "click": "onClick"
        });
    };

    /**
     * Event listener
     * @param event
     */
    LikeButton.prototype.onClick = function(event) {
        event.preventDefault();
        this.like();
    };

    /**
     * Sends like request
     */
    LikeButton.prototype.like = function()
    {
        $.get(this.element.attr('href'), {}, bind(this._handleResponse, this),'json');
    };

    /**
     * Handles response
     */
    LikeButton.prototype._handleResponse = function(data)
    {
        if (data.status == 'OK') {
            var likes = $(".like-count");
            likes.text( Number( likes.text() ) + 1 );
        }else if (data.status == 'EXISTS') {
            alert('You already liked this photo!');
        } else {
            alert('Error handling request.');
        }
    };

    $.widget('ktu.LikeButton', LikeButton.prototype);

    $(".like").LikeButton();

})(jQuery);