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

document.getElementById('filterButton').addEventListener('click', function () {
  const formData = new FormData(document.getElementById('filterForm'));

  fetch('module/product/filter.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById('productList').innerHTML = data;
    })
    .catch((error) => console.error('Error:', error));
});

document.querySelector('.form-select').addEventListener('change', function () {
  const form = document.getElementById('filterForm');
  const formData = new FormData(form);
  formData.append('sortBy', this.value); // Thêm giá trị sắp xếp vào form data

  const queryString = new URLSearchParams(formData).toString();
  loadPage('module/product/product.php?' + queryString);
});

