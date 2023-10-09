<?php
    $conn = mysqli_connect("localhost", "id21372683_sensor", "H0#0s4p13?5", "id21372683_sensormonitoring"); // Membuat koneksi ke database

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); // Jika koneksi gagal, tampilkan pesan kesalahan dan hentikan eksekusi skrip
    }

    $query = "SELECT temperature, humidity FROM dht11"; // Query SQL untuk mengambil data temperatur dan kelembapan dari tabel "dht11"
    $query_run = mysqli_query($conn, $query); // Menjalankan query SQL dan menyimpan hasilnya dalam variabel $query_run
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEMPERATURE & HUMIDITY MONITORING</title>

    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <link rel="shortcut icon" href="assets/img/temperature-control.png" type="image/x-icon">
    <link href="./dist/output.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="jquery/jquery-3.4.0.min.js"></script>
    <script type="text/javascript" src="jquery/mdb.min.js"></script>
    <script type="text/javascript" src="jquery/jquery-latest.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        var refreshid = setInterval(function() {
            $('#tempcontainer').load('temperaturechart.php');
            $('#humcontainer').load('humiditychart.php');
        }, 1000);
    </script>

    <style>
        body {
            overflow: auto;
        }

        #sensorData td {
            padding-top: 12px;
            padding-bottom: 12px;
            padding-left: 16px;
            padding-right: 16px;
        }

        #sensorData tr {
            font-weight: normal;
            border-bottom: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }

        #sensorData tr:first-child {
            color: #2563eb;
            font-weight: bold;
        }

        #sensorData tr:last-child {
            border: none;
        }

        .card-wrap {
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <div class="my-4 mx-4">
        <div class="p-2 bg-gray-900 card-wrap">
            <div class="flex flex-col md:flex-row">
                <!-- Left Card -->
                <div class="w-full p-2">
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 dark:hover:bg-gray-700">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-base text-start tracking-widest">TEMPERATURE</p>
                            <div class="flex gap-2">
                                <p class="text-xs text-end font-light" id="temperaturedate"></p>
                                <p class="text-xs text-end font-light" id="temperaturetime"></p>
                            </div>
                        </div>
                        <p class="my-4 text-[50px] text-center font-normal"><span id="checktemperature"> 0 </span>°C</p>
                    </div>
                </div>
                <!-- Right Card -->
                <div class="w-full p-2">
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 dark:hover:bg-gray-700">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-base text-start tracking-widest">HUMIDITY</p>
                            <div class="flex gap-2">
                                <p class="text-xs text-end font-light" id="humiditydate"></p>
                                <p class="text-xs text-end font-light" id="humiditytime"></p>
                            </div>
                        </div>
                        <p class="my-4 text-[50px] text-center font-normal"><span id="checkhumidity"> 0 </span>%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row my-4 mx-4 gap-4 card-wrap">
        <!-- Kolom Kiri -->
        <div class="w-full">
            <div class="card-wrap p-4 bg-gray-900 border border-gray-500" style="max-height: 550px;">
                <!-- Table -->
                <?php
                // Membuat koneksi ke database MySQL
                $conn = mysqli_connect("localhost", "id21372683_sensor", "H0#0s4p13?5", "id21372683_sensormonitoring"); // Membuat koneksi ke database

                // Cek koneksi
                if (mysqli_connect_errno()) {
                    die("Conn database gagal: " . mysqli_connect_error());
                }

                // Query untuk mengambil nilai tertinggi temperature
                $query_max_temperature = "SELECT MAX(temperature) AS nilai_tertinggi_temperature FROM dht11";
                $result_max_temperature = mysqli_query($conn, $query_max_temperature);
                $row_max_temperature = mysqli_fetch_assoc($result_max_temperature);

                // Query untuk mengambil nilai terendah temperature
                $query_min_temperature = "SELECT MIN(temperature) AS nilai_terendah_temperature FROM dht11";
                $result_min_temperature = mysqli_query($conn, $query_min_temperature);
                $row_min_temperature = mysqli_fetch_assoc($result_min_temperature);

                // Query untuk mengambil rata-rata temperature
                $query_avg_temperature = "SELECT AVG(temperature) AS rata_rata_temperature FROM dht11";
                $result_avg_temperature = mysqli_query($conn, $query_avg_temperature);
                $row_avg_temperature = mysqli_fetch_assoc($result_avg_temperature);

                // Query untuk mengambil nilai tertinggi humidity
                $query_max_humidity = "SELECT MAX(humidity) AS nilai_tertinggi_humidity FROM dht11";
                $result_max_humidity = mysqli_query($conn, $query_max_humidity);
                $row_max_humidity = mysqli_fetch_assoc($result_max_humidity);

                // Query untuk mengambil nilai terendah humidity
                $query_min_humidity = "SELECT MIN(humidity) AS nilai_terendah_humidity FROM dht11";
                $result_min_humidity = mysqli_query($conn, $query_min_humidity);
                $row_min_humidity = mysqli_fetch_assoc($result_min_humidity);

                // Query untuk mengambil rata-rata humidity
                $query_avg_humidity = "SELECT AVG(humidity) AS rata_rata_humidity FROM dht11";
                $result_avg_humidity = mysqli_query($conn, $query_avg_humidity);
                $row_avg_humidity = mysqli_fetch_assoc($result_avg_humidity);

                // Menutup conn ke database
                mysqli_close($conn);
                ?>
                <div class="relative rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-200 text-sm uppercase">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Temperature</th>
                                    <th scope="col" class="px-4 py-3">Humidity</th>
                                    <th scope="col" class="px-4 py-3">Date</th>
                                    <th scope="col" class="px-4 py-3">Time</th>
                                </tr>
                            </thead>
                            <tbody id="sensorData">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex columns-2 gap-4 mt-4">
                    <div class="w-full text-white text-xs font-light tracking-widest">
                        <p class="pt-2 pb-4">Temperature</p>
                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-6">
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#00ff11" viewBox="0 0 256 256">
                                    <path d="M213.66,202.34a8,8,0,0,1-11.32,11.32L128,139.31,53.66,213.66a8,8,0,0,1-11.32-11.32l80-80a8,8,0,0,1,11.32,0Zm-160-68.68L128,59.31l74.34,74.35a8,8,0,0,0,11.32-11.32l-80-80a8,8,0,0,0-11.32,0l-80,80a8,8,0,0,0,11.32,11.32Z"></path>
                                </svg>
                                <p><span id="max_temperature"></span></p>
                            </div>
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#ffde05" viewBox="0 0 256 256">
                                    <path d="M213.66,122.34a8,8,0,0,1,0,11.32l-80,80a8,8,0,0,1-11.32,0l-80-80a8,8,0,0,1,11.32-11.32L128,196.69l74.34-74.35A8,8,0,0,1,213.66,122.34Zm-91.32,11.32a8,8,0,0,0,11.32,0l80-80a8,8,0,0,0-11.32-11.32L128,116.69,53.66,42.34A8,8,0,0,0,42.34,53.66Z"></path>
                                </svg>
                                <p><span id="min_temperature"></span></p>
                            </div>
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#30dbfd" viewBox="0 0 256 256">
                                    <path d="M54.8,119.49A35.06,35.06,0,0,1,49.05,128a35.06,35.06,0,0,1,5.75,8.51C60,147.24,60,159.83,60,172c0,25.94,1.84,32,20,32a12,12,0,0,1,0,24c-19.14,0-32.2-6.9-38.8-20.51C36,196.76,36,184.17,36,172c0-25.94-1.84-32-20-32a12,12,0,0,1,0-24c18.16,0,20-6.06,20-32,0-12.17,0-24.76,5.2-35.49C47.8,34.9,60.86,28,80,28a12,12,0,0,1,0,24c-18.16,0-20,6.06-20,32C60,96.17,60,108.76,54.8,119.49ZM240,116c-18.16,0-20-6.06-20-32,0-12.17,0-24.76-5.2-35.49C208.2,34.9,195.14,28,176,28a12,12,0,0,0,0,24c18.16,0,20,6.06,20,32,0,12.17,0,24.76,5.2,35.49A35.06,35.06,0,0,0,207,128a35.06,35.06,0,0,0-5.75,8.51C196,147.24,196,159.83,196,172c0,25.94-1.84,32-20,32a12,12,0,0,0,0,24c19.14,0,32.2-6.9,38.8-20.51C220,196.76,220,184.17,220,172c0-25.94,1.84-32,20-32a12,12,0,0,0,0-24Z"></path>
                                </svg>
                                <p><span id="avg_temperature"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full text-white text-xs font-light tracking-widest">
                        <p class="pt-2 pb-4">Humidity</p>
                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-6">
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#00ff11" viewBox="0 0 256 256">
                                    <path d="M213.66,202.34a8,8,0,0,1-11.32,11.32L128,139.31,53.66,213.66a8,8,0,0,1-11.32-11.32l80-80a8,8,0,0,1,11.32,0Zm-160-68.68L128,59.31l74.34,74.35a8,8,0,0,0,11.32-11.32l-80-80a8,8,0,0,0-11.32,0l-80,80a8,8,0,0,0,11.32,11.32Z"></path>
                                </svg>
                                <p><span id="max_humidity"></span></p>
                            </div>
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#ffde05" viewBox="0 0 256 256">
                                    <path d="M213.66,122.34a8,8,0,0,1,0,11.32l-80,80a8,8,0,0,1-11.32,0l-80-80a8,8,0,0,1,11.32-11.32L128,196.69l74.34-74.35A8,8,0,0,1,213.66,122.34Zm-91.32,11.32a8,8,0,0,0,11.32,0l80-80a8,8,0,0,0-11.32-11.32L128,116.69,53.66,42.34A8,8,0,0,0,42.34,53.66Z"></path>
                                </svg>
                                <p><span id="min_humidity"></span></p>
                            </div>
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#30dbfd" viewBox="0 0 256 256">
                                    <path d="M54.8,119.49A35.06,35.06,0,0,1,49.05,128a35.06,35.06,0,0,1,5.75,8.51C60,147.24,60,159.83,60,172c0,25.94,1.84,32,20,32a12,12,0,0,1,0,24c-19.14,0-32.2-6.9-38.8-20.51C36,196.76,36,184.17,36,172c0-25.94-1.84-32-20-32a12,12,0,0,1,0-24c18.16,0,20-6.06,20-32,0-12.17,0-24.76,5.2-35.49C47.8,34.9,60.86,28,80,28a12,12,0,0,1,0,24c-18.16,0-20,6.06-20,32C60,96.17,60,108.76,54.8,119.49ZM240,116c-18.16,0-20-6.06-20-32,0-12.17,0-24.76-5.2-35.49C208.2,34.9,195.14,28,176,28a12,12,0,0,0,0,24c18.16,0,20,6.06,20,32,0,12.17,0,24.76,5.2,35.49A35.06,35.06,0,0,0,207,128a35.06,35.06,0,0,0-5.75,8.51C196,147.24,196,159.83,196,172c0,25.94-1.84,32-20,32a12,12,0,0,0,0,24c19.14,0,32.2-6.9,38.8-20.51C220,196.76,220,184.17,220,172c0-25.94,1.84-32,20-32a12,12,0,0,0,0-24Z"></path>
                                </svg>
                                <p><span id="avg_humidity"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table -->
            </div>


            <div class="flex flex-col sm:flex-row gap-4 my-4">
                <!-- Card 1 -->
                <div class="flex-2 bg-gray-900 text-xs text-white p-4 card-wrap">
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-2">
                        <div class="flex justify-start mb-5">
                            <div>
                                <p class="text-base uppercase font-normal text-gray-900">Gauge Chart Data Sensor</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 items-center dark:border-gray-700 justify-between mt-5">
                            <div class="flex justify-between items-center">
                                <!-- Button -->
                                <!-- Modal toggle -->
                                <button data-modal-target="firstModal" data-modal-toggle="firstModal" class="block text-white bg-gray-900 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-normal rounded-lg text-xs px-6 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    SHOW CHART
                                </button>

                                <!-- Main modal -->
                                <div id="firstModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-2xl max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Temperature & Humidity Gauge Chart
                                                </h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="firstModal">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="p-6 space-y-6">
                                                <!-- Content -->
                                                <!-- Chart -->
                                                <div class="mx-auto max-w-screen-xl">
                                                    <div class="grid md:grid-cols-2">
                                                        <div class="items-center justify-center  flex flex-col dark:bg-gray-800 dark:border-gray-700">
                                                            <p class="text-center text-gray-900 tracking-widest text-sm font-medium">TEMPERATURE</p>
                                                            <div class="flex justify-center" id="chart_div"></div>
                                                        </div>
                                                        <div class="items-center justify-center flex flex-col dark:bg-gray-800 dark:border-gray-700">
                                                            <p class="text-center text-gray-900 tracking-widest text-sm font-medium">HUMIDITY</p>
                                                            <div class="flex justify-center" id="chart_div2"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Chart -->
                                            </div>
                                            <!-- Modal footer -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="flex-1 bg-gray-900 text-xs text-white p-4 border border-gray-500 card-wrap">
                    <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-2">
                        <div class="flex justify-start mb-5">
                            <div>
                                <p class="text-base uppercase font-normal text-gray-900">Temperature & Humidity Line Chart</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 items-center dark:border-gray-700 justify-between mt-5">
                            <div class="flex justify-between items-center">
                                <!-- Button -->
                                <!-- Modal toggle -->
                                <button data-modal-target="secondModal" data-modal-toggle="secondModal" class="block text-white bg-gray-900 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-normal rounded-lg text-xs px-6 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    SHOW CHART
                                </button>

                                <!-- Main modal -->
                                <div id="secondModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-6xl max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Temperatur & Humidity Line Chart
                                                </h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="secondModal">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="p-6">
                                                <div id="tempContainer"></div>
                                                <div class="mt-8" id="humContainer"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="w-full">
            <div class="card-wrap p-4 bg-gray-900" style="min-height: 531px;">
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 dark:hover:bg-gray-700">
                    <h1 class="uppercase mb-4 text-4xl font-bold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Involve <mark class="px-2 text-white bg-blue-600 rounded dark:bg-blue-500">IoT</mark> in your life.</h1>
                    <p class="uppercase text-lg text-justify pt-4 font-normal text-gray-500 lg:text-base dark:text-gray-400">Involve IoT in your life, and you'll experience a future where technology improves every aspect of your world. Embrace it and watch your daily routine become more connected than ever.</p>
                </div>
                <div class="flex gap-4 mt-4 rounded-lg dark:border-gray-700 dark:hover:bg-gray-700">
                    <!-- Card 1 -->
                    <div class="w-full bg-white rounded-lg p-4">
                        <div class="card-body">
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-500 uppercase">Team Information</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#737373" viewBox="0 0 256 256">
                                    <path d="M244.8,150.4a8,8,0,0,1-11.2-1.6A51.6,51.6,0,0,0,192,128a8,8,0,0,1-7.37-4.89,8,8,0,0,1,0-6.22A8,8,0,0,1,192,112a24,24,0,1,0-23.24-30,8,8,0,1,1-15.5-4A40,40,0,1,1,219,117.51a67.94,67.94,0,0,1,27.43,21.68A8,8,0,0,1,244.8,150.4ZM190.92,212a8,8,0,1,1-13.84,8,57,57,0,0,0-98.16,0,8,8,0,1,1-13.84-8,72.06,72.06,0,0,1,33.74-29.92,48,48,0,1,1,58.36,0A72.06,72.06,0,0,1,190.92,212ZM128,176a32,32,0,1,0-32-32A32,32,0,0,0,128,176ZM72,120a8,8,0,0,0-8-8A24,24,0,1,1,87.24,82a8,8,0,1,0,15.5-4A40,40,0,1,0,37,117.51,67.94,67.94,0,0,0,9.6,139.19a8,8,0,1,0,12.8,9.61A51.6,51.6,0,0,1,64,128,8,8,0,0,0,72,120Z"></path>
                                </svg>
                            </div>
                            <div class="mt-8">
                                <p class="text-sm text-gray-500 text-justify uppercase">This website is the result of a group assignment in the Introduction to IoT course for monitoring temperature and humidity.</p>
                            </div>
                            <div class="flex gap-2 mt-4">
                                <a class="px-6 py-2 uppercase bg-gray-900 rounded-lg text-xs text-white" href="">members of the group</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="w-full bg-white rounded-lg p-4">
                        <div class="w-full card-body">
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-500 uppercase">Resource Information</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#737373" viewBox="0 0 256 256">
                                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm16-40a8,8,0,0,1-8,8,16,16,0,0,1-16-16V128a8,8,0,0,1,0-16,16,16,0,0,1,16,16v40A8,8,0,0,1,144,176ZM112,84a12,12,0,1,1,12,12A12,12,0,0,1,112,84Z"></path>
                                </svg>
                            </div>
                            <div class="mt-8">
                                <p class="text-sm text-gray-500 text-justify uppercase">You can easily download temperature and humidity sensor data for analysis needs, as well as the source code for this project which is open on GitHub.</p>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2 mt-4">
                                <a class="px-6 py-2  bg-gray-900 rounded-lg text-xs text-white" href="getcsvfile.php">CSV</a>
                                <a class="px-6 py-2 bg-gray-900 rounded-lg text-xs text-white" href="">GITHUB</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <!-- Script Card -->
    <script>
        $(document).ready(function() {
            // Fungsi untuk memuat data sensor dari server
            function loadSensorData() {
                $.get("getdatasensor.php", function(data) {
                    // Menguraikan data JSON yang diterima dari server
                    var sensorData = JSON.parse(data);

                    // Menyimpan data temperature dan humidity ke elemen HTML dengan ID yang sesuai
                    $("#checktemperature").text(sensorData.temperature);
                    $("#checkhumidity").text(sensorData.humidity);

                    // Menyimpan data tanggal ke elemen HTML dengan ID "temperaturedate" dan "humiditydate"
                    $("#temperaturedate").text(sensorData.tanggal);
                    $("#humiditydate").text(sensorData.tanggal);

                    // Menyimpan data waktu ke elemen HTML dengan ID "temperaturetime" dan "humiditytime"
                    $("#temperaturetime").text(sensorData.waktu);
                    $("#humiditytime").text(sensorData.waktu);
                });
            }

            // Memuat data sensor pertama kali saat dokumen HTML telah dimuat sepenuhnya
            loadSensorData();

            setInterval(loadSensorData, 2000); // Setiap 2 detik
        });


        window.onload = () => {
            let el = document.querySelector('[alt="www.000webhost.com"]').parentNode.parentNode;
            el.parentNode.removeChild(el);
        }
    </script>

    <!-- Script Table -->
    <script>
        $(document).ready(function() {
            // Maksimum jumlah data yang akan ditampilkan
            var maxDataCount = 5;
            var sensorDataArray = [];

            // Fungsi yang akan memuat data sensor dari server
            function loadSensorData() {
                // Mengirim permintaan GET ke "getdatasensor.php" untuk mendapatkan data sensor
                $.get("getvaluedatasensor.php", function(data) {
                    // Mengakses tabel dengan id "sensorData" di HTML
                    var table = $("#sensorData");

                    // Menghapus semua baris tabel
                    table.empty();

                    // Menambahkan data sensor ke tabel
                    for (var i = 0; i < data.length; i++) {
                        var sensorData = data[i];
                        var newRow = $("<tr>");

                        // Menambahkan data temperature dengan satuan °C ke dalam baris tabel
                        newRow.append("<td>" + sensorData.temperature + " °C</td>");

                        // Menambahkan data humidity dengan satuan % ke dalam baris tabel
                        newRow.append("<td>" + sensorData.humidity + " %</td>");

                        // Menambahkan data date
                        newRow.append("<td>" + sensorData.tanggal + "</td>");

                        // Menambahkan data time
                        newRow.append("<td>" + sensorData.waktu + "</td>");

                        // Menambahkan baris baru di bagian atas tabel
                        table.append(newRow);
                    }
                });
            }

            // Panggil fungsi loadSensorData() saat dokumen HTML telah dimuat sepenuhnya
            loadSensorData();

            // Set interval untuk memperbarui data sensor setiap beberapa detik (contoh: setiap 2 detik)
            setInterval(function() {
                loadSensorData();
            }, 2000);
        });
    </script>

    <!-- Script Google Chart -->
    <script type="text/javascript">
        $(document).ready(function() {
            google.charts.load('current', {
                'packages': ['gauge']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var options = {
                    width: 200,
                    height: 200,
                    greenFrom: 0,
                    greenTo: 25,
                    redFrom: 75,
                    redTo: 100,
                    yellowFrom: 25,
                    yellowTo: 75,
                    max: 100,
                    min: 0,
                    minorTicks: 5,
                };

                var options2 = {
                    width: 200,
                    height: 200,
                    greenFrom: 0,
                    greenTo: 25,
                    redFrom: 75,
                    redTo: 100,
                    yellowFrom: 25,
                    yellowTo: 75,
                    max: 100,
                    min: 0,
                    minorTicks: 5,
                };

                var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
                var chart2 = new google.visualization.Gauge(document.getElementById('chart_div2'));

                function updateChart() {
                    $.ajax({
                        url: 'getdatasensor.php',
                        dataType: 'json',
                        success: function(data) {
                            var temperature = parseFloat(data.temperature);
                            var humidity = parseFloat(data.humidity);

                            var data1 = google.visualization.arrayToDataTable([
                                ['Label', 'Value'],
                                ['', temperature]
                            ]);

                            var data2 = google.visualization.arrayToDataTable([
                                ['Label', 'Value'],
                                ['', humidity]
                            ]);

                            chart.draw(data1, options);
                            chart2.draw(data2, options2);

                            // Update the real-time data
                            $('#realtime_data').html('Temperature: ' + temperature + '&deg;C, Humidity: ' + humidity + '%');
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }

                // Initial chart rendering
                updateChart();

                setInterval(updateChart, 2000); // Setiap 2 detik
            }
        });
    </script>

    <!-- Script Line Chart -->
    <script>
        var refhreshID = setInterval(function() {
            $('#tempContainer').load('temperaturechart.php');
            $('#humContainer').load('humiditychart.php');
        }, 2000); // Setiap 2 detik
    </script>

    <!-- Script Analytic -->
    <script>
        function updateMaxMinAvgData() {
            // Menggunakan AJAX untuk mengambil data dari server
            $.ajax({
                url: 'refreshanalytic.php', // Ganti dengan URL yang sesuai
                dataType: 'json',
                success: function(data) {
                    // Mengisi elemen-elemen HTML dengan data yang diterima
                    $('#max_temperature').text(data.max_temperature + ' °C');
                    $('#min_temperature').text(data.min_temperature + ' °C');
                    $('#avg_temperature').text(data.avg_temperature + ' °C');

                    $('#max_humidity').text(data.max_humidity + ' %');
                    $('#min_humidity').text(data.min_humidity + ' %');
                    $('#avg_humidity').text(data.avg_humidity + ' %');
                }
            });
        }

        // Memanggil fungsi updateMaxMinAvgData() untuk pertama kali saat halaman dimuat
        updateMaxMinAvgData();

        // Mengatur interval untuk memperbarui data setiap beberapa detik (misalnya, setiap 2 detik)
        setInterval(updateMaxMinAvgData, 2000); // Setiap 2 detik
    </script>
</body>

</html>