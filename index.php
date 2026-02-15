<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $supabase_url = getenv("SUPABASE_URL");
    $supabase_key = getenv("SUPABASE_KEY");

    $url = $supabase_url . "/rest/v1/Login?email=eq." . urlencode($email) . "&password=eq." . urlencode($password);

    $headers = [
        "apikey: $supabase_key",
        "Authorization: Bearer $supabase_key",
        "Content-Type: application/json"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $message = "Erreur connexion serveur.";
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
    <title>Login Supabase</title>
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
