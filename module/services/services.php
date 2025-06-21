<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" onclick="loadPage('module/main-content/main-content.php', this); return false;">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Services</li>
        </ol>
    </nav>
</div>

<section class="mt-2 mb-5">
    <div class="container">
        <h1 class="text-center mb-5 fw-bold">Our Services</h1>
        <div class="row g-4">

            <!-- Laptop cleaning -->
            <div class="col-md-4">
                <a href="#" onclick="loadPage('module/services/laptop-cleaning/laptop-cleaning.php', this, 'laptopcleaning'); return false;">
                    <div class="card service-card border-0 shadow-sm h-100 p-3 rounded-4">
                        <div class="card-body">
                            <div class="mb-3 text-warning fs-1"><i class="bi bi-laptop"></i></div>
                            <h5 class="card-title fw-bold">Laptop Cleaning</h5>
                            <p class="card-text">In-depth internal and external cleaning and maintaining to keep your laptop running cool and smooth.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Repair -->
            <div class="col-md-4">
                <a href="#" onclick="loadPage('module/services/repair/repair.php', this, 'repair'); return false;">
                    <div class="card service-card border-0 shadow-sm h-100 p-3 rounded-4">
                        <div class="card-body">
                            <div class="mb-3 text-warning fs-1"><i class="bi bi-tools"></i></div>
                            <h5 class="card-title fw-bold">Repair Services</h5>
                            <p class="card-text">Fast and reliable repair services for laptops, cameras, and other tech devices. Diagnosis and free consultation included.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Security camera installation -->
            <div class="col-md-4">
                <a href="#" onclick="loadPage('module/services/install-cam/install-cam.php', this, 'installcam'); return false;">
                    <div class="card service-card border-0 shadow-sm h-100 p-3 rounded-4">
                        <div class="card-body">
                            <div class="mb-3 text-warning fs-1"><i class="bi bi-camera-video"></i></div>
                            <h5 class="card-title fw-bold">Security Camera Installation</h5>
                            <p class="card-text">Install high-quality security cameras with optimal placement and configuration for 24/7 protection of your property.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Warranty -->
            <div class="col-md-4">
                <a href="#" onclick="loadPage('module/services/warranty/warranty.php', this, 'warranty'); return false;">
                    <div class="card service-card border-0 shadow-sm h-100 p-3 rounded-4">
                        <div class="card-body">
                            <div class="mb-3 text-warning fs-1"><i class="bi bi-shield-check"></i></div>
                            <h5 class="card-title fw-bold">Warranty</h5>
                            <p class="card-text">Check warranty status, process warranty claims, and ensure that your products get repaired or replaced promptly.</p>
                        </div>
                    </div>
                </a>
            </div>
            <hr>
            <div class="col-md-12 text-center mt-5 py-5 mb-5 bg-white rounded-4 shadow-sm">
                <h2 class=" py-4">Book a service with us today!</h2>
                <button class="btn btn-dark rounded-4 w-25" onclick="location.href='index.php?act=book-services'">Book Now</button>
                <button class="btn btn-dark rounded-4 w-25" onclick="location.href='index.php?act=book-result'">View booked history</button>
            </div>


        </div>
    </div>
</section>