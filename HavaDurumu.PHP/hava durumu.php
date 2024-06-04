<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sehir"])) {
    $sehir = $_POST["sehir"];
    $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=" . $sehir . "&appid=c2503d75acef9a2592a61913527587b2&units=metric";
    
    $response = @file_get_contents($apiUrl); 
    if ($response === FALSE) {
        $hata = "API'ye bağlanırken bir hata oluştu.";
    } else {
        $data = json_decode($response, true);
    
        if ($data && $data["cod"] == 200) {
            $havaDurumu = $data["weather"][0]["description"];
            $sicaklik = $data["main"]["temp"];
            $sehirAdi = $data["name"];
        } else {
            $hata = "Hava durumu verileri alınamadı. Hata kodu: " . $data["cod"] . " - " . $data["message"];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hava Durumu</title>
</head>
<body>
    <h1>Hava Durumu</h1>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="sehir">Şehir: </label>
        <input type="text" name="sehir" id="sehir" required>
        <button type="submit">Hava Durumunu Göster</button>
    </form>

    <?php if (isset($hata)): ?>
        <p><?php echo $hata; ?></p>
    <?php elseif (isset($havaDurumu) && isset($sicaklik) && isset($sehirAdi)): ?>
        <h2><?php echo $sehirAdi; ?> Hava Durumu</h2>
        <p>Hava Durumu: <?php echo $havaDurumu; ?></p>
        <p>Sıcaklık: <?php echo $sicaklik; ?>°C</p>
    <?php endif; ?>
</body>
</html>
