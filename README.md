# Tugas Pertemuan 11 - Exploratory Data Analysis (EDA) Kelulusan Mahasiswa

## Identitas

* Nama : Dafiq Bisma Al alawy
* NIM : 411232060
* Mata Kuliah: Grafik dan Virtualisasi Data
* Pertemuan: 11

---

## Deskripsi

Project ini merupakan implementasi Exploratory Data Analysis (EDA) untuk menganalisis faktor-faktor yang mempengaruhi kelulusan mahasiswa tepat waktu menggunakan Laravel.

Analisis yang dilakukan meliputi:

* Pola titik (Scatter Plot)
* Distribusi kelulusan
* Analisis korelasi
* Rata-rata IPK
* Rata-rata kehadiran
* Identifikasi anomali (outlier)

---

## Teknologi yang Digunakan

* Laravel 13
* PHP 8.3
* MySQL
* Chart.js

---

## Struktur Data

Dataset mahasiswa berisi informasi:

* IPK
* Kehadiran
* SKS Lulus
* Status Kerja
* Kelulusan Tepat Waktu

---

## Cara Menjalankan Project

1. Clone repository

```bash
git clone https://github.com/dbismaa/tugas-pertemuan-11-eda.git
```

2. Masuk ke folder project

```bash
cd tugas-pertemuan-11-eda
```

3. Install dependency

```bash
composer install
```

4. Copy file environment

```bash
copy .env.example .env
```

5. Atur koneksi database pada file `.env`

6. Import database SQL ke MySQL

7. Jalankan aplikasi

```bash
php artisan serve
```

8. Buka browser

```text
http://127.0.0.1:8000/praktikum-eda
```

---

## Fitur Dashboard

* Dashboard Ringkasan Data
* Scatter Plot Kelulusan Mahasiswa
* Distribusi Kelulusan
* Analisis Korelasi
* Analisis Anomali
* Tabel Data Mahasiswa

---

## Repository

https://github.com/dbismaa/tugas-pertemuan-11-eda

## Link Bukti Berhasil Running

https://drive.google.com/file/d/1AEqcwqC1z5FtqEJGZxM9XS0Oi24wTSx-/view?usp=sharing
