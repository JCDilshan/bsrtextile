$(document).ready(function () {
  $("#changePw").on("submit", function (e) {
    let pw = $("#npw").val();
    let cpw = $("#cpw").val();

    if (pw.length < 6) {
      Swal.fire("Password Must Contain At Least 6 Characters", "", "warning");
      return false;
    } else if (pw != cpw) {
      Swal.fire("Password Confirmation Doesn't Match", "", "error");
      return false;
    }
  });

  /////////////////////////// Pw Strength Meter ////////////////////////
  $("#npw").on("keyup", function (e) {
    let pw = $(this).val();

    let corr_pw = pw.replace(/\s/g, "");
    $(this).val(corr_pw);

    // Regex Patters //
    const pw_weak_1 = /^[a-zA-Z]{6,}$/;
    const pw_weak_2 = /^[0-9]{6,}$/;
    const pw_medium = /(?=.*[a-zA-Z])(?=.*[0-9])(?=.{6,})(^((?![\W\_]).)*$)/;
    const pw_strong = /(?=.*[\W\_])(?=.{6,})/;

    if (corr_pw.match(pw_weak_1) != null || corr_pw.match(pw_weak_2) != null) {
      $("#progressBar").css({ width: "33.333%", backgroundColor: "red" });
      $("#progressBar").html("Weak");
    } else if (corr_pw.match(pw_medium) != null) {
      $("#progressBar").css({ width: "66.666%", backgroundColor: "orange" });
      $("#progressBar").html("Medium");
    } else if (corr_pw.match(pw_strong) != null) {
      $("#progressBar").css({ width: "100%", backgroundColor: "green" });
      $("#progressBar").html("Strong");
    } else {
      $("#progressBar").css({ width: "0%" });
      $("#progressBar").html("");
    }
  });

  /////////////////// Pw Visibility Toggle /////////////////
  $("#pw_append").on("click", function (e) {
    if ($("#npw").prop("type") == "password") {
      $("#npw").prop("type", "text");
    } else {
      $("#npw").prop("type", "password");
    }

    $("#pw_icon").toggleClass("fa-eye fa-eye-slash");
  });

  $("#cpw_append").on("click", function (e) {
    if ($("#cpw").prop("type") == "password") {
      $("#cpw").prop("type", "text");
    } else {
      $("#cpw").prop("type", "password");
    }

    $("#cpw_icon").toggleClass("fa-eye fa-eye-slash");
  });
});
