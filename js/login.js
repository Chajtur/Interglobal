$(document).ready(function(){

    $('#btnLogin').click( function(event) {
        event.preventDefault();
        login();
    });

    function login() {
    $user = $("#userName").val();
    $pass = $("#password").val();
    $.post("../controllers/Login.php", {user: $user, pass:$pass, action: 'login'})
        .done( function(resp) {
        resp = JSON.parse(resp);
        if (resp) {
            window.location.href = "main.php";
        } else {
            $('#liveAlertPlaceholder').show();
        }
        });
    }
});