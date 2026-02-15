<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password_input = trim($_POST["password"]);

    // 🔹 Configuration Supabase
    $project_url = "https://uhqqzlpaybcyxrepisgi.supabase.co";
    $api_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InVocXF6bHBheWJjeXhyZXBpc2dpIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MDg0MDI3OCwiZXhwIjoyMDg2NDE2Mjc4fQ.zgY2AsO71vrf5V1lWW0J35nUtut1qUvfvGTRAHFRz7Y
"; // ⚠️ Remplace par ta vraie clé anon publique

    // 🔹 Requête : chercher par email uniquement
    $url = $project_url . "/rest/v1/login?select=*&email=eq." . urlencode($email);

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

    if (!empty($data)) {

        $password_db = trim($data[0]["password"]);

        if ($password_input === $password_db) {

            $matricule = $data[0]["Matricule"];

            $message = "✅ Connexion réussie !<br>Matricule : " . htmlspecialchars($matricule);

        } else {
            $message = "❌ Mot de passe incorrect.";
        }

    } else {
        $message = "❌ Email introuvable.";
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
