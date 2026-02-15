<?php

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = urlencode(trim($_POST["email"]));
    $password = urlencode(trim($_POST["password"]));

    $url = getenv("SUPABASE_URL") . "/rest/v1/Login?email=eq.$email&password=eq.$password";

    $anon_key = getenv("SUPABASE_KEY");

    $headers = [
        "Content-Type: application/json",
        "apikey: $anon_key",
        "Authorization: Bearer $anon_key"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (!empty($data)) {
        $message = "Connexion réussie ✅";
    } else {
        $message = "Email ou mot de passe incorrect ❌";
    }
}
?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br><br>
    <button type="submit">Se connecter</button>
</form>

<br>
<strong><?php echo $message; ?></strong>
