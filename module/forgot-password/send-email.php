<?php
require 'send-mail-handler.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Link awesome font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Link bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <!-- Link google font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="../../asset/bootstrap/css/bootstrap.min.css" />

    <link rel="stylesheet" href="../../asset/style1.css" />
    <title>Technologia</title>
</head>

<body>

    <body>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="form-control bg-white shadow-sm">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold">Reset your Password</h3>
                            <p class="text-muted mb-0">Enter your email to get verify code</p>
                        </div>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" required>
                            </div>

                            <button type="submit" name="action" value="send_code" class="btn btn-dark w-100">
                                Send code
                            </button>
                        </form>
                        <!-- line -->
                        <div>
                            <hr style="border: 1px solid #9da1a6" />
                        </div>
                        <div class="justify-content d-flex mt-4">
                            <div>
                                <small class="text" style="margin-right: 5px">Don't have an account yet?</small>
                            </div>

                            <div>
                                <small><a href="../../Registration.php" class="text-success">Register now!</a></small>
                            </div>
                        </div>
                        <div class="justify-content d-flex mt-4">
                            <div>
                                <small class="text" style="margin-right: 5px">You already have an accout!</small>
                            </div>

                            <div>
                                <small><a href="../../Login.php" class="text-success">Sign in</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    </body>

</html>