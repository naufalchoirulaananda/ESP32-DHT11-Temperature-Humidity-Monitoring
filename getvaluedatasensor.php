<?php
    $host = "localhost";
    $username = "id21372683_sensor"; 
    $password = "H0#0s4p13?5"; 
    $database = "id21372683_sensormonitoring"; 

    // Membuat koneksi ke database MySQL menggunakan mysqli_connect
    $connect = mysqli_connect($host, $username, $password, $database);

    // Memeriksa apakah koneksi berhasil atau gagal
    if (!$connect) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Menjalankan query SQL untuk mengambil 5 data terbaru dari tabel "dht11"
    $sql = mysqli_query($connect, "SELECT * FROM dht11 ORDER BY id DESC LIMIT 5");

    // Membuat array untuk menyimpan data sensor
    $sensorData = array();

    // Mengambil data hasil query dan memasukkannya ke dalam array
    while ($row = mysqli_fetch_assoc($sql)) {
        $sensorData[] = array(
            'temperature' => $row['temperature'],
            'humidity' => $row['humidity'],
            'tanggal' => $row['tanggal'],
            'waktu' => $row['waktu']
        );
    }

    // Mengatur header HTTP untuk mengindikasikan bahwa respons akan berupa JSON
    header('Content-Type: application/json');

    // Mengembalikan data sensor dalam format JSON
    echo json_encode($sensorData);
?>
