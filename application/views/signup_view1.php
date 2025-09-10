<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
            box-shadow: 0px 8px 25px rgba(0,0,0,0.15);
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
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card p-4">
                <h3 class="text-center mb-4 title">📝 Signup Page</h3>

                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                <?php elseif($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <form method="post" action="<?php echo site_url('user_sign1/register'); ?>">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter your name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter your phone number" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Signup</button>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-0">Already have an account? 
                        <a href="<?php echo site_url('login_with_otp'); ?>">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
