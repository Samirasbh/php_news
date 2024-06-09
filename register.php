<?php
require_once('./functions/pdo_connect.php');

$error = '';
if ((isset($_POST['submit'])) && (isset($_POST['first_name']) && $_POST['first_name'] !== '')
    && (isset($_POST['last_name']) && $_POST['last_name'] !== '') && (isset($_POST['email']) && $_POST['email'] !== '')
    && (isset($_POST['password']) && $_POST['password'] !== '')
) {
    if (trim(strlen($_POST['password'])) >= 8 && trim(strlen($_POST['password'])) <= 12) {

        if ($_POST['password'] === $_POST['pass_confirm']) {
            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$_POST['email']]);
            $user = $stmt->fetch();
            if ($user === false) {
                $add_query = "INSERT INTO users SET first_name = ?,last_name = ?,email = ?,password = ?";
                $statement = $conn->prepare($add_query);
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $statement->execute([$_POST['first_name'], $_POST['last_name'], $_POST['email'], $password]);

                header('location:http://localhost/php_basic/02-ex/login.php');
            } else {
                $error = 'email exists. try another email address.';
            }
        } else {
            $error = 'oops.check your password and confirmation password';
        }
    } else {
        $error = 'password length must be in range 8 to 12';
    }
} else {
    if (!empty($_POST)) {
        $error = 'enter all of fields';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        section {
            width: 100vw;
            height: 100vh;
            flex-direction: column;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {

            width: 300px;
            height: 400px;
            border: 2px solid lightgrey;
            border-radius: 10px;
            padding: 20px 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
        }
    </style>
</head>

<body>

    <section>
        <form method="post">
            <label for="fname">Enter your first name</label>
            <input type="text" id="fname" name="first_name" placeholder="first name">

            <label for="lname">Enter your last name</label>
            <input type="text" id="lname" name="last_name" placeholder="last name">

            <label for="email">Enter your email</label>
            <input type="email" id="email" name="email" placeholder="email">

            <label for="password">Enter your password</label>
            <input type="password" id="password" name="password" placeholder="8 to 12 charactors">

            <label for="pass_conf">Enter your password again</label>
            <input type="password" id="pass_conf" name="pass_confirm" placeholder="confirm password">

            <input type="submit" value="sign up" name="submit">
        </form>
        <p><?= $error !== '' ? $error : '' ?></p>
    </section>
</body>

</html>