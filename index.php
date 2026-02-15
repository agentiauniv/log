<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password_input = trim($_POST["password"]);

    // 🔹 CONFIGURATION SUPABASE
    $project_url = "https://uhqqzlpaybcyxrepisgi.supabase.co";
    $api_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InVocXF6bHBheWJjeXhyZXBpc2dpIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzA4NDAyNzgsImV4cCI6MjA4NjQxNjI3OH0.LNQMIQs7euI7-4MMJWU_maqT6WdXq6lWuueCtF3kE24"; // ⚠️ Mets ta vraie clé anon ici

    // 🔹 Requête par email uniquement
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

    if (curl_errno($ch)) {
        echo "Erreur CURL : " . curl_error($ch);
        exit;
    }

    curl_close($ch);

    // 🔎 AFFICHER LA REPONSE BRUTE (DEBUG)
    echo "<h3>Réponse brute Supabase :</h3>";
    echo "<pre>";
    print_r($response);
    echo "</pre>";

    $data = json_decode($response, true);

    if (!empty($data)) {

        $password_db = trim($data[0]["password"]);

        if ($password_input === $password_db) {

            $matricule = $data[0]["Matricule"];
            $message = "✅ Connexion réussie ! Matricule : " . htmlspecialchars($matricule);

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

