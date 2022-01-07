$(document).ready(function () {
  $("#addCustomer").on("submit", function (e) {
    let pw = $("#pw").val();
    let cpw = $("#cpw").val();

    if ($("input[name=gender]:checked").length < 1) {
      Swal.fire("Please Select Gender", "", "question");
      return false;
    } else if (pw.length < 6) {
      Swal.fire("Password Must Contain At Least 6 Characters", "", "warning");
      return false;
    } else if (pw != cpw) {
      Swal.fire("Password Confirmation Doesn't Match", "", "error");
      return false;
    }
  });

  /////////////////// Pw Visibility Toggle /////////////////
  $("#pw_append").on("click", function (e) {
    if ($("#pw").prop("type") == "password") {
      $("#pw").prop("type", "text");
    } else {
      $("#pw").prop("type", "password");
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

  ////////////////////////////// Check User Existence ///////////////////////////
  $("#nic").on("keyup", function (e) {
    let nic = $(this).val();

    if (nic != "") {
      $.ajax({
        url: "../controller/customer_controller.php?type=checkNic_Existence",
        type: "POST",
        cache: false,
        data: { nic: nic },
        success: function (res) {
          if (res == "yes") {
            $("#nic_response").html("This nic Already Has Been Taken");
            $("#submit").prop("disabled", true);
          } else {
            $("#nic_response").html("");
            $("#submit").prop("disabled", false);
          }
        },
        error: function () {
          console.log("Error");
        },
      });
    }
  });

  /////////////////////////// Pw Strength Meter ////////////////////////
  $("#pw").on("keyup", function (e) {
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
});

function readURL(x) {
  if (x.files && x.files[0]) {
    let reader = new FileReader();

    reader.onload = function (e) {
      $("#prev_img").attr("src", e.target.result);
    };
    reader.readAsDataURL(x.files[0]);
  } else {
    $("#prev_img").attr("src", "");
  }
}
