<?php
    $host = "localhost";
    $username = "id21372683_sensor"; 
    $password = "H0#0s4p13?5"; 
    $database = "id21372683_sensormonitoring";

    // Membuat koneksi ke database MySQL menggunakan mysqli_connect
    $conn = mysqli_connect($host, $username, $password, $database);

    // Memeriksa apakah koneksi berhasil atau gagal
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Menjalankan query SQL untuk mengambil semua data dari tabel "dht11"
    $query = "SELECT * FROM dht11";
    $result = mysqli_query($conn, $query);

    // Memeriksa apakah query SQL berhasil atau gagal
    if (!$result) {
        die("Kueri SQL gagal: " . mysqli_error($conn));
    }

    // Nama file CSV yang akan dibuat
    $nama_file = 'TemperatureHumidityData.csv';

    // Membuka file CSV untuk penulisan
    $handle = fopen($nama_file, 'w');

    // Memeriksa apakah file CSV berhasil dibuka
    if (!$handle) {
        die("Gagal membuka file CSV untuk penulisan.");
    }

    // Menulis data dari hasil query ke dalam file CSV
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($handle, $row);
    }

    // Menutup file CSV
    fclose($handle);

    // Mengatur header untuk menyediakan file CSV sebagai unduhan
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $nama_file . '"');
    readfile($nama_file);

    // Menutup koneksi ke database
    mysqli_close($conn);

    // Menghapus file CSV setelah digunakan
    unlink($nama_file);
?>
