<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Email et mot de passe corrects (à changer si tu veux)
    $correct_email = "admin@gmail.com";
    $correct_password = "123456";

    if ($email === $correct_email && $password === $correct_password) {
        $message = "✅ Connexion réussie !";
    } else {
        $message = "❌ Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Connexion</h2>

<form method="POST">
    <label>Email :</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Se connecter</button>
</form>

<p><?php echo $message; ?></p>

</body>
</html>
