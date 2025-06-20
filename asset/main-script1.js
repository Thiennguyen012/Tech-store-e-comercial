// đổi #main-content trong file index thành content của 1 file php khác bằng hàm loadPage(file) gọi ra trong button hoặc thẻ a
function loadPage(file, clickedLink = null, act = "", productId = "") {
  $("#main-content").load(file, function () {
    // Thay đổi URL mà không load lại trang
    if (act) {
      if (act === "single-product" && productId) {
        history.pushState({ act: act, productId: productId }, "", `index.php?act=${act}&id=${productId}`);
      } else {
        history.pushState({ act: act }, "", `index.php?act=${act}`);
      }
    }
    // Khởi động lại carousel nếu có
    const myCarousel = document.querySelector("#carouselExampleCaptions");
    if (myCarousel) {
      new bootstrap.Carousel(myCarousel, {
        interval: 3000,
        ride: "carousel",
      });
      updateCarouselImages(); // Cập nhật ảnh responsive
    }
  });
}

// Khi người dùng nhấn nút "Back" hoặc "Forward"
window.onpopstate = function (event) {
  const act = event.state?.act || "";
  let file = "module/main-content/main-content.php";
  switch (act) {
    // Mục products
    case "products":
      file = "module/product/product.php";
      break;
    // Thêm case cho single product
    case "single-product":
      const productId = event.state?.productId || "";
      file = `module/product/single_product.php?id=${productId}`;
      break;
    //
    // Mục about
    case "about":
      file = "module/about-us/about-us.php";
      break;
    // Mục services
    case "services":
      file = "module/services/services.php";
      break;
    case "laptopcleaning":
      file = "module/services/laptop-cleaning/laptop-cleaning.php";
      break;
    case "installcam":
      file = "module/services/install-cam/install-cam.php";
      break;
    case "repair":
      file = "module/services/repair/repair.php";
      break;
    case "warrantly":
      file = "module/services/warrantly/warrantly.php";
      break;
    case "book-services":
      file = "module/services/book-services.php";
      break;
    //Mục contact
    case "contact":
      file = "module/contact/contact.php";
      break;
    //Mục cart
    case "cart":
      file = "module/cart/cart.php";
      break;
    // mục checkout
    case "checkout":
      file = "module/checkout/checkout.php";
      break;
    case "checkout-result":
      file = "module/checkout/checkout-result.php";
      break;
    //Mục profile
    case "profile":
      file = "module/user-profile/user-profile.php";
      break;
    //Mục user order
    case "order":
      file = "module/user-order/user-order.php";
      break;
    default:
      file = "module/main-content/main-content.php";
  }
  $("#main-content").load(file);
};

//script cho arrow up to top
$(document).ready(function () {
  // Hiện/ẩn nút scroll
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $(".arrow").fadeIn();
    } else {
      $(".arrow").fadeOut();
    }
  });

  // Scroll lên đầu khi click
  $("#scrollToTop").click(function (e) {
    e.preventDefault(); // Ngăn chuyển hướng khi href="#"
    $("html, body").animate({ scrollTop: 0 }, 200);
  });
});

document.getElementById("filterButton").addEventListener("click", function () {
  const formData = new FormData(document.getElementById("filterForm"));

  fetch("module/product/filter.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("productList").innerHTML = data;
    })
    .catch((error) => console.error("Error:", error));
});

document.querySelector(".form-select").addEventListener("change", function () {
  const form = document.getElementById("filterForm");
  const formData = new FormData(form);
  formData.append("sortBy", this.value); // Thêm giá trị sắp xếp vào form data

  const queryString = new URLSearchParams(formData).toString();
  loadPage("module/product/product.php?" + queryString);
});

$("#addcart-submit").click(function () {
  $.post(
    $("#addToCartForm").attr("action"),
    $("#addToCartForm :input").serializeArray(),
    function info() {
      $("#response").empty();
      $("#response").html(info);
    }
  );
  $("#addToCartForm").submit(function () {
    return false;
  });
});
function updateCarouselImage() {
  const aspectRatio = window.innerHeight / window.innerWidth;

  const slide1 = document.getElementById("slide-img1");
  const slide2 = document.getElementById("slide-img2");
  const slide3 = document.getElementById("slide-img3");

  if (aspectRatio > 0.9) {
    slide1.src = "./img/product-banner/zenbook14-smalll.jpg";
    slide2.src = "./img/product-banner/vivo s16-small.jpg";
    slide3.src = "./img/product-banner/zenbook a14-small.jpg";
  } else {
    slide1.src = "./img/product-banner/zenbook14.jpg";
    slide2.src = "./img/product-banner/vivo s16.jpg";
    slide3.src = "./img/product-banner/zenbook a14.jpg";
  }
}

window.addEventListener("load", updateCarouselImage);
window.addEventListener("resize", updateCarouselImage);
