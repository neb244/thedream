



<!DOCTYPE html>
<html>
<head>
    <title>Convertisseur de devises</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Convertisseur de devises</h1>
        <form method="post">
            <label for="amount">Montant :</label>
            <input type="text" id="amount" name="amount" required>

            <label for="currency">Devise :</label>
            <select id="currency" name="currency" required>
                <option value="EUR">Euro</option>
                <option value="USD">Dollar</option>
                <!-- Ajoutez d'autres devises si nécessaire -->
            </select>

            <label for="direction">Sens :</label>
            <select id="direction" name="direction" required>
                <option value="to_euro">Euro -> Devise</option>
                <option value="from_euro">Devise -> Euro</option>
            </select>

            <input type="submit" value="Convertir">
        </form>
        <div>
        <?php
$err = "";
$response = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["amount"]) && is_numeric($_POST["amount"])) {
        $amount = $_POST["amount"];
        $currency = $_POST["currency"];
        $direction = $_POST["direction"];

        $curl = curl_init();
        $api_url ="https://currency-converter18.p.rapidapi.com/api/v1/convert?from={$currency}&to={$direction}&amount={$amount}";
        
        
//////////////////////////////////////////////////////////////////////////////////////


curl_setopt_array($curl, [
	CURLOPT_URL => $api_url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: currency-converter18.p.rapidapi.com",
		"X-RapidAPI-Key: f3ff27069fmsh15d9ff35b8a27f8p1bcb6djsn7e8dd81aafd4"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}

        $response = curl_exec($curl);
        $err = curl_error($curl);
        var_dump($response);

        curl_close($curl);

        if ($err) {
            echo "Erreur lors de la requête à l'API : " . $err;
        } else {
            $data = json_decode($response, true);

            if (isset($data['rates'])) {
                $rate = ($direction === "to_euro") ? $data['rates']['EUR'] : $data['rates'][$currency];
                $converted_currency = ($direction === "to_euro") ? "EUR" : $currency;
                $result = $rate * $amount;

                echo "<h2>Résultat de la conversion :</h2>";
                echo "<p>$amount $currency = $result $converted_currency</p>";
            } else {
                echo "Erreur : Impossible d'obtenir les taux de conversion.";
            }
        }
    } else {
        echo "Veuillez entrer un montant valide.";
    }
}
?>
        </div>
    </div>
</body>
</html>
