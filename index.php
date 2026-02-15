<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // 🔹 CONFIGURATION SUPABASE
    $project_url = "https://uhqqzlpaybcyxrepisgi.supabase.co";
    $service_role_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InVocXF6bHBheWJjeXhyZXBpc2dpIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MDg0MDI3OCwiZXhwIjoyMDg2NDE2Mjc4fQ.zgY2AsO71vrf5V1lWW0J35nUtut1qUvfvGTRAHFRz7Y

"; // remplace si besoin

    // 🔹 Construire URL API
    $url = $project_url . "/rest/v1/Login?select=*&email=eq." 
           . urlencode($email) . "&password=eq." 
           . urlencode($password);

    // 🔹 Initialiser CURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $service_role_key",
        "Authorization: Bearer $service_role_key",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $message = "❌ Erreur connexion serveur.";
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
    <title>Connexion</title>
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
