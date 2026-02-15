<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    // 🔹 CONFIGURATION SUPABASE
    $project_url = "https://uhqqzlpaybcyxrepisgi.supabase.co";
    $service_role_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InVocXF6bHBheWJjeXhyZXBpc2dpIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzA4NDAyNzgsImV4cCI6MjA4NjQxNjI3OH0.LNQMIQs7euI7-4MMJWU_maqT6WdXq6lWuueCtF3kE24";

    // 🔹 URL API (table Login)
    $url = $project_url . "/rest/v1/Login?email=eq." . urlencode($email) . "&password=eq." . urlencode($password);

    // 🔹 Initialiser CURL
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $service_role_key",
        "Authorization: Bearer $service_role_key",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);

    // 🔹 Vérifier erreur CURL
    if ($response === false) {
        $message = "❌ Erreur CURL: " . curl_error($ch);
    } else {

        $data = json_decode($response, true);

        if (!empty($data)) {
            $message = "✅ Connexion réussie !";
        } else {
            $message = "❌ Email ou mot de passe incorrect.";
        }
    }

    curl_close($ch);
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
