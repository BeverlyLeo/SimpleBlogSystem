<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $db->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $res = $db->query("SELECT * FROM blog_system_bloggers WHERE email = '$email'");

    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['bloggerID'] = $user['bloggerID'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            echo "Wrong password.";
        }
    } else {
        echo "No user found.";
    }
}
?>

<form method="POST">
    <h2>Login</h2>
    <input type="email" name="email" required placeholder="Email"><br>
    <input type="password" name="password" required placeholder="Password"><br>
    <button type="submit">Login</button>
</form>
