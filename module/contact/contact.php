<div class="container-fluid py-5"
    style="background: linear-gradient(135deg,rgb(234, 235, 240) 0%,rgb(71, 69, 73) 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center text-white mb-5">
                <h1 class="display-4 fw-bold mb-3">Contact Us</h1>
                <p class="lead">We are always ready to support you. Leave your information and we will respond as soon
                    as possible!</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Contact Form -->
        <div class="col-lg-8 ">
            <div class="bg-white py-4 rounded-4 shadow-sm h-100">
                <div class="card-body p-4 ">
                    <h3 class="card-title mb-4 text-center">
                        <i class="fas fa-envelope text-dark me-2"></i>
                        Send Message
                    </h3>

                    <form id="contactForm" action="module/contact/contact-handler.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label fw-semibold">
                                    <i class="fas fa-user text-dark me-1"></i>
                                    First Name *
                                </label>
                                <input type="text" class="form-control form-control-md" id="firstName" name="firstName"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label fw-semibold">
                                    <i class="fas fa-user text-dark me-1"></i>
                                    Last Name *
                                </label>
                                <input type="text" class="form-control form-control-md" id="lastName" name="lastName"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="fas fa-envelope text-dark me-1"></i>
                                    Email *
                                </label>
                                <input type="email" class="form-control form-control-md" id="email" name="email"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-semibold">
                                    <i class="fas fa-phone text-dark me-1"></i>
                                    Phone Number
                                </label>
                                <input type="tel" class="form-control form-control-md" id="phone" name="phone">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label fw-semibold">
                                <i class="fas fa-tag text-dark me-1"></i>
                                Subject *
                            </label>
                            <select class="form-select" id="subject" name="subject" required style="font-size: 1rem;">
                                <option value="">Select subject...</option>
                                <option value="general">General Question</option>
                                <option value="service">Service</option>
                                <option value="support">Technical Support</option>
                                <option value="partnership">Partnership</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label fw-semibold">
                                <i class="fas fa-comment text-dark me-1"></i>
                                Message *
                            </label>
                            <textarea class="form-control" id="message" name="message" rows="6"
                                placeholder="Enter your message content..." required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark rounded-4">
                                <i class="fas fa-paper-plane me-2"></i>
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Info & Map -->
        <div class="col-lg-4">
            <!-- Contact Information -->
            <div class="bg-white py-3 rounded-4 shadow-sm mb-4">
                <div class="card-body p-4 ">
                    <h4 class="card-title mb-4 text-center">
                        <i class="fas fa-info-circle text-dark me-2"></i>
                        Contact Information
                    </h4>

                    <div class="contact-info">
                        <div class="d-flex align-items-start mb-3">
                            <div class="flex-shrink-0">
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-semibold">Address</h6>
                                <p class="text-muted mb-0">141 Chien Thang, Tan Trieu<br>Thanh Tri, Ha Noi, Vietnam</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3">
                            <div class="flex-shrink-0">
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="fas fa-phone"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-semibold">Phone</h6>
                                <p class="text-muted mb-0">
                                    <a href="tel:+84123456789" class="text-decoration-none">+84 123 456 789</a><br>
                                    <a href="tel:+84987654321" class="text-decoration-none">+84 987 654 321</a>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3">
                            <div class="flex-shrink-0">
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-semibold">Email</h6>
                                <p class="text-muted mb-0">
                                    <a href="mailto:info@company.com"
                                        class="text-decoration-none">info@company.com</a><br>
                                    <a href="mailto:support@company.com"
                                        class="text-decoration-none">support@company.com</a>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-semibold">Working Hours</h6>
                                <p class="text-muted mb-0">
                                    Monday - Friday: 8:00 - 17:30<br>
                                    Saturday: 8:00 - 12:00<br>
                                    Sunday: Closed
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="shadow-sm bg-white rounded-4 py-4">
                <div class="card-body p-4 text-center">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-share-alt text-dark me-2"></i>
                        Connect With Us
                    </h5>
                    <!-- Socials -->
                    <div>
                        <a href="https://www.facebook.com/" target="_blank"><i
                                class="bi bi-facebook me-3 text-decoration-none text-dark fs-4"></i></a>
                        <a href="https://www.instagram.com/" target="_blank"><i
                                class="bi bi-instagram me-3 text-decoration-none text-dark fs-4"></i></a>
                        <a href="https://x.com/" target="_blank"><i
                                class="bi bi-twitter-x me-3 text-decoration-none text-dark fs-4"></i></a>
                        <a href="https://www.youtube.com/" target="_blank" class="mt-3"><i
                                class="bi bi-youtube me-3 text-decoration-none text-dark fs-3"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map Section -->
<div class="container p-0 mt-0">
    <div class="row">
        <div class="col-12">
            <div class="map-container" style="height: 400px; background: #f8f9fa;">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.660469221864!2d105.86592631495326!3d21.030731892636764!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab60f0bb2b85%3A0x5e8d8af9fa4b8de6!2zMTQxIENoaeG6v24gVGjhuq9uZywgVMOibiBUcmnhu4d1LCBUaGFuaCBUcsOsLCBIw6AgTuG7mWksIFZp4buHdCBOYW0!5e0!3m2!1sen!2s!4v1640995200000!5m2!1sen!2s"
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="container py-5 bg-white mt-5 mb-5 py-3 rounded-4 shadow-sm">
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
            <h2 class="display-6 fw-bold mb-3">Frequently Asked Questions</h2>
            <p class="lead text-muted">Common questions from our customers</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item mb-3 border-0 shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            <i class="fas fa-question-circle text-dark me-2"></i>
                            How do I schedule an appointment?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            You can schedule an appointment through the contact form above, call us directly, or email
                            us. We will confirm a suitable time with you.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 border-0 shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq2">
                            <i class="fas fa-question-circle text-dark me-2"></i>
                            What is the response time?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We are committed to responding within 24 business hours. For urgent cases, please call us
                            directly.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 border-0 shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq3">
                            <i class="fas fa-question-circle text-dark me-2"></i>
                            Do you provide support outside business hours?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We have 24/7 emergency support service. Please contact our hotline for assistance outside
                            business hours.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Contact Form Handling
        document.addEventListener('DOMContentLoaded', function () {
            const contactForm = document.getElementById('contactForm');
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            contactForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Remove existing alerts
                const existingAlert = contactForm.querySelector('.alert');
                if (existingAlert) {
                    existingAlert.remove();
                }

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';

                // Collect form data
                const formData = new FormData(contactForm);
                const data = Object.fromEntries(formData.entries());

                // Send to PHP handler
                fetch('contact-handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(result => {
                        const alertType = result.success ? 'success' : 'danger';
                        const icon = result.success ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';

                        showAlert(alertType, icon, result.message);

                        if (result.success) {
                            contactForm.reset();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('danger', 'fas fa-exclamation-triangle', 'An error occurred. Please try again.');
                    })
                    .finally(() => {
                        // Reset button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    });
            });

            function showAlert(type, icon, message) {
                const alert = document.createElement('div');
                alert.className = `alert alert-${type} alert-dismissible fade show`;
                alert.innerHTML = `
            <i class="${icon} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

                contactForm.insertBefore(alert, contactForm.firstChild);

                // Auto dismiss after 5 seconds
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 5000);
            }
        });
</script>