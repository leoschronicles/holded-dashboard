$(document).ready(function(){
    var pageName = Holded.pageName.split(":").pop();
    
    var num = Math.ceil(Math.random() * 4);
    $(".auth .container").addClass("bg" + num);
});