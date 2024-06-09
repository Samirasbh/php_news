<?php
session_start();
require_once('./functions/pdo_connect.php');
$error = '';
if (
    (isset($_POST['email']) && $_POST['email'] !== '') &&
    (isset($_POST['password']) && $_POST['password'] !== '')
) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "email or password invalid";
    } else {
        $query = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$_POST['email']]);
        $user = $stmt->fetch();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['login'] = true;
            }
            header('location:http://localhost/php_basic/02-ex/panel');
        }
    }
} else {
    if (!empty($_POST)) {
        $error = 'enter all fields';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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

        width: 250px;
        height: 200px;
        border: 2px solid lightgrey;
        border-radius: 10px;
        padding: 20px 10px;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: center;
    }
</style>

<body>
    <section>
        <form method="post">
            <label for="email">Enter your email</label>
            <input type="email" id="email" name="email">

            <label for="password">Enter your password</label>
            <input type="password" id="password" name="password">

            <button type="submit">login</button>
        </form>
        <p><?= $error !== '' ? $error : ''  ?></p>
    </section>
</body>

</html>