<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TNPSC Selection</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #ff512f, #f09819);
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            font-size: 16px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar a i {
            margin-right: 10px;
        }

        /* Main Content */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Top Bar */
        .topbar {
            background: linear-gradient(90deg, #ff512f, #f09819);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        /* Content Area */
        .content {
            flex: 1;
            display: flex;
            justify-content: flex-start;
            /* push to the left */
            align-items: flex-start;
            /* push to the top */
            padding: 30px;
            /* add spacing from edges */
        }


        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        .card h2 {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>TNPSC Group 4</h2>
        <h3>General studies</h3>
        <a href="<?= site_url('excel_retrieve/display'); ?>"><i class="fa-solid fa-book"></i> Online Test 1</a>
        <h3>Maths</h3>
        <a href="<?= site_url('apti'); ?>"><i class="fa-solid fa-book"></i>Apti_Reas_Set 1</a>
        <a href="<?= site_url('auth/index'); ?>"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <!-- Main -->
    <div class="main">
        <!-- Topbar -->
        <div class="topbar">
            Welcome, <?= ucfirst($this->session->userdata('username')); ?>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="card">
                <h2>user datails:</h2>
                <p><b>Username:</b><?= ucfirst($this->session->userdata('username')); ?></p>
                <p><b>Email:</b><?= ucfirst($this->session->userdata('email')); ?></p>
            </div>
        </div>
    </div>
</body>

</html>