<?php
    // Konfigurasi untuk koneksi ke database MySQL
    $host = "localhost"; 
    $username = "id21372683_sensor"; 
    $password = "H0#0s4p13?5"; 
    $database = "id21372683_sensormonitoring"; 

    // Membuat koneksi ke database MySQL menggunakan mysqli_connect
    $connect = mysqli_connect($host, $username, $password, $database);

    // Memeriksa apakah koneksi berhasil atau tidak
    if (!$connect) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Mendapatkan tanggal dan waktu saat ini dalam zona waktu Asia/Jakarta
    date_default_timezone_set('Asia/Jakarta');
    $currentDate = date('Y-m-d'); // Format tanggal: YYYY-MM-DD
    $currentTime = date('H:i:s'); // Format waktu: HH:MM:SS

    // Mendapatkan data temperatur dan kelembapan dari parameter GET, jika tersedia
    $temperature = isset($_GET['temperature']) ? $_GET['temperature'] : '';
    $humidity = isset($_GET['humidity']) ? $_GET['humidity'] : '';

    // Mengatur ulang nilai auto-increment tabel "dht11" ke 1
    mysqli_query($connect, "ALTER TABLE dht11 AUTO_INCREMENT=1");

    // Menyimpan data temperatur, kelembapan, tanggal, dan waktu ke dalam tabel "dht11"
    $save = mysqli_query($connect, "INSERT INTO dht11 (temperature, humidity, tanggal, waktu) VALUES ('$temperature', '$humidity', '$currentDate', '$currentTime')");

    // Menampilkan pesan sukses atau gagal berdasarkan hasil penyimpanan data
    if ($save) {
        echo "Data berhasil disimpan!";
    } else {
        echo "Data gagal disimpan!";
    }
?>
