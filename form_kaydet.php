<?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "xaleynakaplanoglu@gmail.com";
$password = "031431.Serkan";
$service_name = "mesajlar";

$conn = oci_connect($username, $password, $servername."/".$service_name);

// Veritabanı bağlantısı kontrolü
if (!$conn) {
    $e = oci_error();
    die("Veritabanına bağlantı sağlanamadı: " . $e['message']);
}

// İletişim bilgilerini alma ve veritabanına ekleme
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // SQL sorgusu
    $sql = "INSERT INTO ileti (isim, email, mesaj) VALUES (:name, :email, :message)";

    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":name", $name);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":message", $message);

    $result = oci_execute($stmt);

    if ($result) {
        echo "İletişim bilgileri başarıyla kaydedildi.";
    } else {
        $e = oci_error($stmt);
        echo "Hata: " . $e['message'];
    }

    oci_free_statement($stmt);
}

oci_close($conn);
?>