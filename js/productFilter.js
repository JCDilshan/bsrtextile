$(document).ready(function () {
  let collId = $("#collId").val();
  let brandId = $("input[name=brandId]:checked").val();
  let collTypeId = $("input[name=CollTypeId]:checked").val();
  let categoryId = $("input[name=CatId]:checked").val();

  $.ajax({
    url: "../controller/product_controller.php?type=filterProducts",
    type: "GET",
    cache: false,
    data: {
      collId: collId,
      collTypeId: collTypeId,
      brandId: brandId,
      categoryId: categoryId,
    },
    success: function (res) {
      $("#content").html(res);
    },
    error: function () {
      console.log("error");
    },
  });

  $("input[name=brandId], input[name=CollTypeId], input[name=CatId]").on(
    "change",
    function (e) {
      let collId = $("#collId").val();
      let brandId = $("input[name=brandId]:checked").val();
      let collTypeId = $("input[name=CollTypeId]:checked").val();
      let categoryId = $("input[name=CatId]:checked").val();

      $.ajax({
        url: "../controller/product_controller.php?type=filterProducts",
        type: "GET",
        cache: false,
        data: {
          collId: collId,
          collTypeId: collTypeId,
          brandId: brandId,
          categoryId: categoryId,
        },
        success: function (res) {
          $("#content").html(res);
        },
        error: function () {
          console.log("error");
        },
      });
    }
  );
});
