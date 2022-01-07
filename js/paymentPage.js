$(document).ready(function () {
  let current_fs, next_fs, previous_fs;
  let total_steps = $("fieldset").length;
  let current = 1;

  $("fieldset").slice(1).hide();

  function setProgressBar(curr_step) {
    let percent = (100 / total_steps) * curr_step;

    $(".progress-bar").css("width", percent + "%");
  }

  setProgressBar(current);

  /////////////////////// Onclick Next button ///////////////////////
  $(".next").on("click", function (e) {
    let fname = $("#fname").val();

    if (fname == "") {
      $("#fnamealert").html("This Field is Required").addClass("text-danger");
      return false;
    } else {
      current_fs = $(this).parent();
      next_fs = $(this).parent().next();

      current_fs.fadeOut(100);
      next_fs.fadeIn(500);

      let nextFs_index = $("fieldset").index(next_fs);
      $("#progressbar > li").eq(nextFs_index).addClass("active");

      setProgressBar(++current);
    }
  });

  /////////////////////// Onclick Previous button //////////////////////
  $(".previous").on("click", function (e) {
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    current_fs.fadeOut(100);
    previous_fs.fadeIn(500);

    let currentFs_index = $("fieldset").index(current_fs);
    $("#progressbar > li").eq(currentFs_index).removeClass("active");

    setProgressBar(--current);
  });

  //////////////////////////// Card Validation /////////////////////
  $("#paymentForm").on("submit", function (e) {
    let crdName = $("#nameOfCrd").val();
    let crdNum = $("#cardNum").val();
    let month = $("#month").val();
    let year = $("#year").val();
    let cvv = $("#cvv").val();

    const crdPatt = /^[0-9]{16}$/;

    if (
      crdNum.match(crdPatt) == null ||
      crdNum != 1234123412341234 ||
      crdName == "" ||
      month == "" ||
      year == "" ||
      cvv != 999
    ) {
      Swal.fire("Process Error", "Invalid Card", "error");
      return false;
    }
  });
});
