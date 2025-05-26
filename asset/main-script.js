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

document.querySelectorAll(".navbar-nav .nav-link").forEach((link) => {
  link.addEventListener("click", function () {
    // Bỏ class active khỏi các mục khác
    document
      .querySelectorAll(".navbar-nav .nav-link")
      .forEach((item) => item.classList.remove("active"));
    // Thêm class active vào mục được chọn
    this.classList.add("active");
  });
});
