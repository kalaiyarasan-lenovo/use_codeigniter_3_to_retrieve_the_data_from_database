<!DOCTYPE html>
<html>
<head>
    <title>Upload Excel File</title>
</head>
<body>

<h2>Upload Excel File (MCQ Questions)</h2>

<?php echo form_open_multipart('excel/import'); ?>
    <input type="file" name="excel_file" required />
    <br><br>
    <button type="submit">Upload</button>
<?php echo form_close(); ?>

</body>
</html>
