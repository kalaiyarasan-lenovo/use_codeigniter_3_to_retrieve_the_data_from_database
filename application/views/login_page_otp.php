<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send OTP</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.15);
        }

        .form-control {
            border-radius: 12px;
        }

        .btn-primary {
            border-radius: 12px;
            padding: 10px;
            font-size: 16px;
            font-weight: 500;
        }

        .title {
            font-weight: 700;
            color: #333;
        }

        .new-user {
            text-align: center;
            margin-top: 15px;
        }

        .new-user a {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
        }

        .new-user a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card p-4">

                    <h3 class="text-center mb-4 title">🔐 Send OTP</h3>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= $this->session->flashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= site_url('login_with_otp/send_otp') ?>">

                        <!-- user name -->
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter your username"
                                required>
                            <div class="form-text">* Your Username.</div>
                        </div>

                        <!-- Gmail -->
                        <div class="mb-3">
                            <label class="form-label">Gmail Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email"
                                required>
                            <div class="form-text">* Your Gmail.</div>

                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="phone" class="form-control" placeholder="Enter your password"
                                required>
                            <div class="form-text">* Your Phone Number.</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Send OTP</button>
                    </form>

                    <div class="text-center mt-3">
                        <p class="mb-0">Are you a new user? <a href="<?php echo site_url('user_sign/signup'); ?>">Sign
                                up here</a></p>
                        <small class="text-muted">* Just sign up once – then use your email or username to log in
                            anytime.</small>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>