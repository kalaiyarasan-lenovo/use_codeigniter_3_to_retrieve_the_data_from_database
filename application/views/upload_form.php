<!DOCTYPE html>
<html>
<head>
    <title>Upload MCQ Excel File</title>
    <style>
        /* Basic Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #ffffff;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
        }

        input[type="file"] {
            display: block;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-bottom: 25px;
            font-size: 16px;
        }

        button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #45a049;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Upload MCQ Excel File</h2>

    <?php echo form_open_multipart('excel/import'); ?>
        <input type="file" name="excel_file" required />
        <button type="submit">Upload</button>
    <?php echo form_close(); ?>
</div>

</body>
</html>
