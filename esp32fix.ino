#include <DHT.h>             // Memasukkan library untuk sensor DHT (Digunakan untuk membaca data suhu dan kelembaban)
#include <WiFi.h>            // Memasukkan library untuk modul WiFi (Digunakan untuk menghubungkan ke jaringan WiFi)
#include <HTTPClient.h>      // Memasukkan library untuk melakukan permintaan HTTP (Digunakan untuk mengirim data ke server web)

#define DHTPIN 2             // Pin tempat Anda menghubungkan sensor DHT11
#define DHTTYPE DHT11        // Tipe sensor DHT yang digunakan (DHT11)
DHT dht(DHTPIN, DHTTYPE);    // Membuat objek DHT untuk sensor

const char* ssid = "spontan.";      // SSID (nama jaringan WiFi) yang akan digunakan
const char* password = "uuuhhhuuuyyy";  // Kata sandi WiFi

const char* host = "sensormooonitoring.000webhostapp.com"; // URL Hosting

void setup() {
  Serial.begin(9600);       // Menginisialisasi komunikasi serial dengan kecepatan 9600 bps
  dht.begin();              // Menginisialisasi sensor DHT

  // Menghubungkan ke jaringan WiFi menggunakan SSID dan kata sandi yang telah ditentukan
  WiFi.begin(ssid, password);
  Serial.print("Connecting...");
  while (WiFi.status() != WL_CONNECTED) {  // Menunggu hingga terhubung ke jaringan WiFi
    Serial.print(".");
    delay(500);  // Jeda setiap 0.5 detik sebelum mencoba lagi
  }
  Serial.print("WiFi Connected");  // Pesan konfirmasi bahwa WiFi terhubung
}

void loop() {
  float temperature = dht.readTemperature();  // Membaca data suhu dari sensor DHT
  float humidity = dht.readHumidity();        // Membaca data kelembaban dari sensor DHT

  // Menampilkan data suhu dan kelembaban di serial monitor
  Serial.print("Suhu: ");
  Serial.print(temperature);
  Serial.print(" °C, Kelembaban: ");
  Serial.print(humidity);
  Serial.println(" %");

  WiFiClient client;

  const int httpPort = 80;  // Port HTTP yang umum digunakan (80)
  if (!client.connect(host, httpPort)) {  // Mencoba menghubungkan ke server web
    Serial.print("Connection Failed");  // Pesan jika koneksi ke server web gagal
    return;
  }

  String Link;
  HTTPClient http;

  // Membuat URL dengan data suhu dan kelembaban yang akan dikirimkan ke server web
  Link = "http://" + String(host) + "/datasend.php?temperature=" + String(temperature) + "&humidity=" + String(humidity);
  http.begin(Link);  // Memulai permintaan HTTP ke alamat URL
  http.GET();  // Melakukan permintaan GET

  String response = http.getString();  // Mendapatkan respons dari server web
  Serial.print(response);
  http.end();  // Mengakhiri permintaan HTTP

  delay(2000);  // Jeda selama 2 detik sebelum membaca data sensor lagi
}
