
jQuery(document).ready(function() {
    function add() {
        var collectionHolder = $('#nfqakademija_gallerybundle_phototype_tags');
        var prototype = collectionHolder.attr('data-prototype');
        form = prototype.replace(/__name__label__/g, collectionHolder.children().length);
        collectionHolder.append(form);
    }

    $(".record_actions").delegate("a.jslink", "click", function(event){
        event.preventDefault();
        add();
    });
});