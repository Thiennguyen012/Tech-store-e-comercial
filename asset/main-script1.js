// đổi #main-content trong file index thành content của 1 file php khác bằng hàm loadPage(file) gọi ra trong button hoặc thẻ a
function loadPage(file, clickedLink = null) {
  // Load nội dung
  $("#main-content").load(file);

  // Xử lý class 'active' cho nav-link
  $(".nav-link").removeClass("active");
  if (clickedLink) {
    $(clickedLink).addClass("active");
  }
}

//script cho arrow up to top
$(document).ready(function () {
  $(window).scroll(function () {
    if ($(this).scrollTop()) {
      $(".arrow").fadeIn();
    } else {
      $(".arrow").fadeOut();
    }
  });
});
