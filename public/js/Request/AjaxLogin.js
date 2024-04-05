$(document).ready(function () {
    $("#loginButton").click(function () {
        var email = $("#email").val();
        var password = $("#password").val();

        $.ajax({
            type: "POST",
            url: "../../../controller/Login.php",
            data: { email: email, password: password },
            dataType: "json",
            success: function (response) {
                if (response.message === "Successful connection") {
                    window.location.href = response.redirect;
                } else {
                    alert("Wrong password / email or this account is disabled")
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
});
