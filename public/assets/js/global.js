$(document).ready(function(){
    window.Holded = {};
    Holded.pageName = $(document.body).data('pageName');

    // Show flash messages if any:
    $(".flash-messages-hidden > div[data-key]").each(function(){
        var elem    = $(this);
        var errType = elem.data('key');
        var text    = elem.html();
        alertify[errType](text);
    });
})