$(document).ready(function () {
  //////////////////////////////// Email Existence /////////////////////
  $("#nemail").on("keyup", function (e) {
    let email = $(this).val();

    if (email != "") {
      $.ajax({
        url: "../controller/customer_controller.php?type=checkEmail_Existence",
        type: "POST",
        cache: false,
        data: { email: email },
        success: function (res) {
          if (res == "yes") {
            $("#email_response").html("This Email Already Has Been Taken");
            $("#registerBtn").prop("disabled", true);
          } else {
            $("#email_response").html("");
            $("#registerBtn").prop("disabled", false);
          }
        },
        error: function () {
          console.log("Error");
        },
      });
    }
  });

  /////////////////////////// Pw Visibility ///////////////////////////
  $("#pw_append").on("click", function (e) {
    if ($("#pw").prop("type") == "password") {
      $("#pw").prop("type", "text");
    } else {
      $("#pw").prop("type", "password");
    }

    $("#pw_icon").toggleClass("fa-eye fa-eye-slash");
  });
});
