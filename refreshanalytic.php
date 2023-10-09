<?php
    $conn = mysqli_connect("localhost", "id21372683_sensor", "H0#0s4p13?5", "id21372683_sensormonitoring"); // Membuat koneksi ke database

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mengambil statistik temperatur
    $query_temperature = "SELECT MAX(temperature) AS max_temperature, MIN(temperature) AS min_temperature, AVG(temperature) AS avg_temperature FROM dht11";
    $result_temperature = mysqli_query($conn, $query_temperature);
    $row_temperature = mysqli_fetch_assoc($result_temperature);

    // Query untuk mengambil statistik kelembapan
    $query_humidity = "SELECT MAX(humidity) AS max_humidity, MIN(humidity) AS min_humidity, AVG(humidity) AS avg_humidity FROM dht11";
    $result_humidity = mysqli_query($conn, $query_humidity);
    $row_humidity = mysqli_fetch_assoc($result_humidity);

    // Mengonversi nilai statistik ke tipe data integer
    $max_temperature_int = intval($row_temperature['max_temperature']);
    $min_temperature_int = intval($row_temperature['min_temperature']);
    $avg_temperature_int = intval($row_temperature['avg_temperature']);
    $max_humidity_int = intval($row_humidity['max_humidity']);
    $min_humidity_int = intval($row_humidity['min_humidity']);
    $avg_humidity_int = intval($row_humidity['avg_humidity']);

    // Menutup koneksi ke database MySQL
    mysqli_close($conn);

    // Membentuk array dengan nilai-nilai statistik
    $data = array(
        'max_temperature' => $max_temperature_int,
        'min_temperature' => $min_temperature_int,
        'avg_temperature' => $avg_temperature_int,
        'max_humidity' => $max_humidity_int,
        'min_humidity' => $min_humidity_int,
        'avg_humidity' => $avg_humidity_int
    );

    // Mengatur header HTTP untuk respons JSON
    header('Content-Type: application/json');

    // Mengembalikan data statistik dalam format JSON
    echo json_encode($data);
?>
