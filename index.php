<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $project_url = "https://uhqqzlpaybcyxrepisgi.supabase.co";
    $service_role_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InVocXF6bHBheWJjeXhyZXBpc2dpIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MDg0MDI3OCwiZXhwIjoyMDg2NDE2Mjc4fQ.zgY2AsO71vrf5V1lWW0J35nUtut1qUvfvGTRAHFRz7Y

";

    $url = $project_url . "/rest/v1/Login?select=*&email=eq." 
           . urlencode($email) . "&password=eq." 
           . urlencode($password);

    echo "<h3>URL envoyée :</h3>";
    echo $url . "<br><br>";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $service_role_key",
        "Authorization: Bearer $service_role_key",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);

    echo "<h3>Réponse Supabase :</h3>";
    echo "<pre>";
    print_r($response);
    echo "</pre>";

    curl_close($ch);
}
?>

<form method="POST">
    Email: <input type="email" name="email"><br><br>
    Mot de passe: <input type="text" name="password"><br><br>
    <button type="submit">Test</button>
</form>
