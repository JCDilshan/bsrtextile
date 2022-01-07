$(document).ready(function () {
  $("[data-toggle=tooltip]").tooltip();

  $("#orderRecordsTable, #feedbackTable").DataTable();

  $(".dataTables_filter input[type=search]").css({
    width: "250px",
  });

  $(".viewOrderDetailsBtn").on("click", function (e) {
    let invoiceId = $(this).val();

    $.ajax({
      url: "../controller/order_controller.php?type=viewOrderDetails",
      type: "POST",
      cache: false,
      data: { invoiceId: invoiceId },
      success: function (res) {
        $("#viewOrderDetails").html(res);
      },
      error: function () {
        console.log("Error");
      },
    });
  });

  $(".feedbackModalBtn").on("click", function (e) {
    let invoiceId = $(this).val();

    $("#feedBackModal").modal("show");
    $("#invoiceId").val(invoiceId);
  });

  $("#feedbackButton").on("click", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../controller/feedback_controller.php?type=addFeedback",
      type: "POST",
      data: $("#feedbackForm").serialize(),
      cache: false,
      success: function (res) {
        if (res == "ok") {
          Swal.fire({
            title: "Thank You !!",
            text: "Your Feedback",
            icon: "success",
            showConfirmButton: false,
            timer: 2000,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "OOps",
            text: "Something Went Wrong. Please Try Again",
            icon: "error",
          });
        }

        $("#feedBackModal").modal("hide");
      },
      error: function () {
        console.log("Error");
      },
    });
  });
});
