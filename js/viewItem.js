$(document).ready(function () {
  $(".change").on("click", function (e) {
    let changeImg = $(this).attr("data-full");

    $(".full > img").hide().attr("src", changeImg).fadeIn();

    $(".selected").removeClass();
    $(this).addClass("selected");
  });

  $(".full > img").on("click", function (e) {
    $("[data-fancybox]").fancybox();
  });

  $("#sizeId").on("change", function (e) {
    let sizeId = $(this).val();
    let productId = $("#productId").val();

    if (sizeId != "") {
      $.ajax({
        url: "../controller/stock_controller.php?type=getStockInfo",
        type: "GET",
        dataType: "JSON",
        cache: false,
        data: { sizeId: sizeId, productId: productId },
        success: function (res) {
          if (res != "error") {
            if (res.stock_count > 0) {
              $("#setPrice").html(res.stock_sell_price);
              $("#productPrice").val(res.stock_sell_price);
              $("#stockId").val(res.stock_id);
              $("#addToCart").prop("disabled", false);
            } else {
              $("#setPrice").html("Not Enough Stock");
              $("#productPrice").val("");
              $("#stockId").val("");
              $("#addToCart").prop("disabled", true);
            }
          }
        },
        error: function () {
          console.log("error");
        },
      });
    }
  });

  $("#addToCartForm").on("submit", function (e) {
    let sizeId = $("#sizeId").val();
    let stockId = $("#stockId").val();

    if (sizeId == "") {
      Swal.fire("Please Select Size", "", "warning");
      return false;
    } else {
      $.ajax({
        url: "../controller/cart_controller.php?type=addItem",
        type: "POST",
        cache: false,
        data: { stockId: stockId },
        success: function (res) {},
        error: function () {
          console.log("Error");
        },
      });
    }
  });
});
