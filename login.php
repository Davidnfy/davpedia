<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <form action="proses_login.php" method="POST">
        <h2>Login</h2>
        <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
            <div class="error-message">
                <p>Username atau password salah! <i class="fas fa-times-circle"></i></p>
            </div>
        <?php endif; ?>

        <label for="username">👤 Username:</label>
        <div class="input-container">
            <i class="fas fa-user"></i>
            <input type="text" name="username" required><br><br>
        </div>

        <label for="password">🔒 Password:</label>
        <div class="input-container">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" required><br><br>
        </div>

        <input type="submit" value="Login">
    </form>
</body>
</html>