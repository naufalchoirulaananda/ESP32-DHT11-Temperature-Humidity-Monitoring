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

    // Menjalankan query SQL untuk mengambil data terbaru dari tabel "dht11"
    $sql = mysqli_query($connect, "SELECT * FROM dht11 ORDER BY id DESC");

    // Mengambil data hasil query
    $data = mysqli_fetch_array($sql);

    // Mengambil nilai dari data
    $temperature = $data['temperature'];
    $humidity = $data['humidity'];
    $tanggal = $data['tanggal'];
    $waktu = $data['waktu'];

    // Memeriksa apakah data temperatur dan kelembapan kosong dan mengaturnya ke 0 jika kosong
    if ($temperature == "") $temperature = 0;
    if ($humidity == "") $humidity = 0;

    // Mengembalikan data dalam format JSON
    echo json_encode(array(
        'temperature' => $temperature,
        'humidity' => $humidity,
        'tanggal' => $tanggal,
        'waktu' => $waktu
    ));
?>
