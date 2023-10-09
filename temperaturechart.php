<?php
    $host = "localhost";
    $username = "id21372683_sensor"; 
    $password = "H0#0s4p13?5"; 
    $database = "id21372683_sensormonitoring";

    // Membuat koneksi ke database MySQL menggunakan mysqli_connect
    $connect = mysqli_connect($host, $username, $password, $database);

    // Menjalankan query SQL untuk mengambil ID terbesar dari tabel "dht11"
    $sqlID = mysqli_query($connect, "SELECT MAX(id) FROM dht11");
    $dataID = mysqli_fetch_array($sqlID);
    $lastID = $dataID['MAX(id)'];
    $firstID = $dataID[0] - 5; // Menghitung ID awal yang akan digunakan untuk mengambil data

    // Menjalankan query SQL untuk mengambil tanggal dari tabel "dht11" berdasarkan rentang ID
    $waktu = mysqli_query($connect, "SELECT waktu FROM dht11 WHERE id>='$firstID' AND id<='$lastID' ORDER BY id ASC");

    // Menjalankan query SQL untuk mengambil data temperatur dari tabel "dht11" berdasarkan rentang ID
    $temperature = mysqli_query($connect, "SELECT temperature FROM dht11 WHERE id>='$firstID' AND id<='$lastID' ORDER BY id ASC");
?>

<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800">
    <canvas id="tempChart" class="w-full"></canvas>
</div>

<script>
    var canvas = document.getElementById("tempChart");
    var data = {
        labels: [
            <?php
            while ($data_waktu = mysqli_fetch_array($waktu)) {
                echo '"' . $data_waktu['waktu'] . '",';
            }
            ?>
        ],
        datasets: [{
            label: "Temperature",
            fill: false,
            borderColor: "rgba(27, 79, 195, 1)",
            lineTension: 0.5,
            pointRadius: 5,
            pointBackgroundColor: "rgba(27, 79, 195, 1)",
            data: [
                <?php
                while ($data_temperature = mysqli_fetch_array($temperature)) {
                    echo $data_temperature['temperature'] . ',';
                }
                ?>
            ]
        }, ],
    };

    var option = {
        showLines: true,
        animation: {
            duration: 0
        },
    };

    var myLineChart = Chart.Line(canvas, {
        data: data,
        options: option,
    });
</script>