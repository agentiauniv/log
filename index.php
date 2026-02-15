<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password_input = trim($_POST["password"]);

    $project_url = "https://uhqqzlpaybcyxrepisgi.supabase.co";
    $api_key = "sb_publishable_8zJ55HCmtuFhw1ClkAed2g_NdQ1GNqZ"; // Mets ta vraie clé anon

    $url = $project_url . "/rest/v1/login?select=*";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $api_key",
        "Authorization: Bearer $api_key",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    foreach ($data as $user) {

        $email_db = trim(str_replace(["\n", "\r"], '', $user["email"]));
        $password_db = trim(str_replace(["\n", "\r"], '', $user["password"]));

        if ($email_db === $email && $password_db === $password_input) {

            $message = "✅ Connexion réussie ! Matricule : " . htmlspecialchars($user["Matricule"]);
            break;
        } else {
            $message = "❌ Email ou mot de passe incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>

<h1>Connexion</h1>

<form method="POST">
    <label>Email :</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Se connecter</button>
</form>

<br>

<div>
    <?php echo $message; ?>
</div>

</body>
</html>
