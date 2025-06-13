<?php
include_once(__DIR__ . '/search-logic.php');
?>

<!-- Search Form -->
<div class="container my-4">
    <form action="index.php" method="GET" class="row justify-content-center">
        <input type="hidden" name="act" value="products">
        <div class="col-12 col-md-6 d-flex">
            <input type="text" name="query" class="form-control me-2" placeholder="Search for products...">
            <button type="submit" class="btn btn-dark">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
</div>

<!-- Card 1: Product Info -->
<div class="container mb-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Computers, Cameras & Accessories</h5>
            <p class="card-text">
                Discover high-performance computers, smart security cameras, and must-have accessories. Simple,
                reliable, and built to last.
            </p>
            <a href="#" class="btn btn-outline-dark"
                onclick="loadPage('module/product/product.php',this,'products'); return false;">Explore Products</a>
        </div>
    </div>
</div>

<!-- Card 2: Store Promotions -->
<div class="container mb-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Exclusive In-Store Offers</h5>
            <p class="card-text">
                Enjoy up to 50% off, free nationwide shipping, and up to 2 years of official warranty. Clean deals,
                no distractions.
            </p>
        </div>
    </div>
</div>