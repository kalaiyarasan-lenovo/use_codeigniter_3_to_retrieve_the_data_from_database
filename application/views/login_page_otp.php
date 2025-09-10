<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Login</title>
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
        .btn-primary, .btn-success {
            border-radius: 12px;
            padding: 10px;
            font-size: 16px;
            font-weight: 500;
        }
        .title {
            font-weight: 700;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card p-4">

                <h3 class="text-center mb-4 title">Login with OTP</h3>

                <!-- Error -->
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>

                <!-- Success -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>

                <!-- Single Form -->
                <form method="post">

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" 
                               value="<?= $this->session->flashdata('email_entered') ?? '' ?>"
                               placeholder="Enter your email" required
                               <?= $this->session->flashdata('otp_sent') ? 'readonly' : '' ?>>
                        <div class="form-text">We will send an OTP to this email.</div>
                    </div>

                    <!-- OTP (visible only after OTP sent) -->
                    <div class="mb-3" id="otpBox" style="<?= $this->session->flashdata('otp_sent') ? '' : 'display:none;' ?>">
                        <label class="form-label">Enter OTP</label>
                        <input type="text" name="otp" class="form-control" placeholder="Enter OTP"
                               <?= $this->session->flashdata('otp_sent') ? 'autofocus' : '' ?>>
                        <div class="form-text">Check your email for the OTP.</div>
                    </div>

                    <!-- Buttons -->
                    <?php if ($this->session->flashdata('otp_sent')): ?>
                        <button type="submit" formaction="<?= site_url('login_with_otp/check_otp') ?>" 
                                class="btn btn-success w-100">Verify OTP</button>
                    <?php else: ?>
                        <button type="submit" formaction="<?= site_url('login_with_otp/send_otp') ?>" 
                                class="btn btn-primary w-100">Send OTP</button>
                    <?php endif; ?>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-0">New user? <a href="<?= site_url('user_sign1/signup'); ?>">Sign up here</a></p>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
