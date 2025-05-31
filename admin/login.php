<?php
session_start();
include '../db/connection.php';
$error_message = '';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Untuk sementara, gunakan kredensial hardcoded
    // Dalam aplikasi nyata, Anda harus mengambil dari database dan menggunakan password_hash / password_verify
    $admin_user = 'admin';
    $admin_pass_hash = password_hash('admin123', PASSWORD_DEFAULT); // Contoh password hash

    // if ($username === $admin_user && password_verify($password, $admin_pass_hash)) { // Jika menggunakan hashing
    if ($username === $admin_user && $password === 'admin123') { // Versi sederhana tanpa hash
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error_message = "Username atau password salah!";
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login - Desa Cikondang</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        body { display: flex; align-items: center; justify-content: center; min-height: 100vh; background-color: #f8f9fa; }
        .login-form { width: 100%; max-width: 330px; padding: 15px; margin: auto; }
    </style>
</head>
<body class="text-center">
    <form class="login-form" method="POST" action="login.php">
        <img class="mb-4" src="../img/logo.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Admin Login</h1>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="inputUsername" name="username" class="form-control mb-2" placeholder="Username" required autofocus>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control mb-3" placeholder="Password" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
        <p class="mt-5 mb-3 text-muted">&copy; Desa Cikondang <?php echo date("Y"); ?></p>
    </form>
</body>
</html>