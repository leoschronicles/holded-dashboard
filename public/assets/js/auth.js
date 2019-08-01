$(document).ready(function(){
    var pageName = Holded.pageName.split(":").pop();
    var form = $("#auth-form");

    var AuthPage = {
        signin: function(){
            // /account/login
        }
    }; // [END] AuthPage object

    // Execute corresponding method depending on the page
    if(!AuthPage[pageName])
        throw `Method ${pageName} not found!`;
    AuthPage[pageName]();
});