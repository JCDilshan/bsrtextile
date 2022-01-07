$(document).ready(function () {
  $(".remove").on("click", function (e) {
    e.preventDefault();
    let itemId = $(this).parents("tr").find(".itemId").val();

    $.ajax({
      url: "../common/cartSession.php?type=removeItem",
      type: "POST",
      cache: false,
      data: { itemId: itemId },
      success: function (res) {
        $.ajax({
          url: "../controller/cart_controller.php?type=removeItem",
          type: "POST",
          cache: false,
          data: { itemId: itemId },
          success: function (res) {
            location.reload();
          },
          error: function () {
            console.log("Ajax error");
          },
        });
      },
      error: function () {
        console.log("Ajax error");
      },
    });
  });

  //////////////////////// Increase Product //////////////////////////
  $(".increaseProd").on("click", function (e) {
    let itemId = $(this).parents("tr").find(".itemId").val();

    $.ajax({
      url: "../controller/stock_controller.php?type=getInfoByStockId",
      type: "GET",
      data: { stockId: itemId },
      cache: false,
      dataType: "JSON",
      success: function (res) {
        if (res != "error") {
          if (res.stock_count > 0) {
            $.ajax({
              url: "../common/cartSession.php?type=IncreaseQty",
              type: "POST",
              cache: false,
              data: { itemId: itemId },
              success: function (res) {
                $.ajax({
                  url: "../controller/cart_controller.php?type=addItem",
                  type: "POST",
                  cache: false,
                  data: { stockId: itemId },
                  success: function (res) {
                    location.reload();
                  },
                  error: function () {
                    console.log("Ajax error");
                  },
                });
              },
              error: function () {
                console.log("Ajax error");
              },
            });
          } else {
            Swal.fire(
              "Sorry Cannot Increase Quantity",
              "Not Enough Stock",
              "error"
            );
          }
        }
      },
      error: function () {
        console.log("Ajax Error");
      },
    });
  });

  ///////////////////////// Decrease Product /////////////////////////
  $(".decreaseProd").on("click", function (e) {
    let itemId = $(this).parents("tr").find(".itemId").val();
    let prodQty = $(this).parents("tr").find(".prodQty").val();

    if (prodQty > 1) {
      $.ajax({
        url: "../common/cartSession.php?type=DecreaseQty",
        type: "POST",
        cache: false,
        data: { itemId: itemId },
        success: function (res) {
          $.ajax({
            url: "../controller/cart_controller.php?type=decreaseQty",
            type: "POST",
            cache: false,
            data: { stockId: itemId },
            success: function (res) {
              location.reload();
            },
            error: function () {
              console.log("Ajax error");
            },
          });
        },
        error: function () {
          console.log("Ajax error");
        },
      });
    }
  });
});
