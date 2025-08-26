<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert</title>
</head>
<body>
    <h1>insert the data</h1>
    <form action="<?=base_url('index.php/user_data/savedata')?>" method="post">
        <label for="username">username:
            <input type="text" name="user_name">
        </label>
        <br><br>
        <label for="email">email:
            <input type="email" name="email">
        </label>
        <br><br>
        <label for="password">password:
            <input type="password" name="password">
        </label>
        <br><br>
        <label for="confirm_password">confirm_password:
            <input type="password" name="confirm_pass">
        </label>
        <br><br>
        <input type="submit" name="save" value="save">
    </form>
</body>
</html>