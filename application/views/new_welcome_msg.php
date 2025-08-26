<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Form</title>
</head>
<body>
    <h1>Hello, <?=$this->session->userdata('savename')?></h1>
    <h1>Welcome to this session</h1>
    <form method='post'  action="<?=base_url('index.php/new_wel/save') ?>">
        <input type="text" name="name">
        <input type="submit" value="save">
    </form>
</body>
</html> 
<?php if($this->session->has_userdata('savename')){ ?>
            <a href="<?=base_url('index.php/new_wel/clear') ?>">clear</a>
<?php } ?>