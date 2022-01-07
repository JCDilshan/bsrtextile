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
