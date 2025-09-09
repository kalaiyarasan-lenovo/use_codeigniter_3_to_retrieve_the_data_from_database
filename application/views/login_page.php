<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .form-text {
            font-size: 0.85rem;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card p-4">
                    <h3 class="text-center mb-4 title">Login Page</h3>
                    <form method="post" action="<?php echo site_url('login_with_pass/login'); ?>">

                        <!-- Username -->
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="email" name="username" class="form-control" placeholder="Enter your Gmail ID"
                                required>
                            <div class="form-text">* Your Gmail will be used as your username.</div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Enter your phone number" required>
                            <div class="form-text">* Your mobile number will be used as your password.</div>
                        </div>

                        <?php if (!empty($login_error)): ?>
                            <p style="color:red;"><?php echo $login_error; ?></p>
                        <?php endif; ?>

                        <!-- Login Button -->
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    <!-- Sign Up -->
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