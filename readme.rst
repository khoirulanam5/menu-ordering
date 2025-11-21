# Sistem Pemesanan Makanan dengan Moving Average

Sistem pemesanan makanan modern yang dilengkapi dengan fitur **peramalan stok menggunakan Metode Moving Average**, landing page menarik, serta manajemen operasional restoran/kedai secara lengkap. Sistem ini mendukung beberapa role pengguna dan dibangun menggunakan **CodeIgniter 3**, **MySQL**, serta **HTML**, **CSS**, **JavaScript**, dan **Bootstrap**.

---

## 🍽️ Fitur Utama

### 🛒 Pemesanan Makanan

* Pemesanan langsung oleh pelanggan
* Keranjang belanja
* Riwayat pemesanan
* Estimasi waktu penyajian

### 🔮 Forecasting Stok (Moving Average)

* Prediksi kebutuhan bahan berdasarkan data penjualan sebelumnya
* Mengurangi risiko kehabisan atau kelebihan stok
* Dashboard grafik peramalan

### 💵 Transaksi & Kasir

* Input pesanan dari kasir
* Pembayaran tunai/non-tunai
* Cetak struk
* Rekap transaksi harian/bulanan

### 📦 Manajemen Produk & Bahan

* Data menu makanan
* Harga, kategori, foto
* Monitoring stok bahan

### 👥 Role Pengguna

* **Pemilik** – Melihat laporan, analitik, forecasting, dan mengelola produk
* **Kasir** – Input pesanan dan mengelola transaksi
* **Pelanggan** – Pemesanan makanan via landing page

### 🎨 Landing Page Menarik

* Tampilan modern & responsif
* Menu makanan dengan foto
* Testimoni & kontak
* CTA untuk pemesanan

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** CodeIgniter 3
* **Database:** MySQL
* **Frontend:** HTML5, CSS3, JavaScript, Bootstrap
* **Forecasting:** Metode Moving Average

---

## 📂 Struktur Folder Contoh

```
application/
│── controllers/
│── models/
│── views/
public/
│── assets/
│   ├── css/
│   ├── js/
│   ├── img/
database/
│── schema.sql
README.md
```

---

## 🔧 Cara Instalasi

1. Clone repository:

   ```bash
   git clone <repo-url>
   ```

2. Pindah ke folder project:

   ```bash
   cd pemesanan-makanan
   ```

3. Import database:

   * Buat database baru
   * Import file `schema.sql`

4. Konfigurasi environment:

   * Atur `base_url` pada `application/config/config.php`
   * Atur koneksi MySQL pada `application/config/database.php`

5. Jalankan aplikasi:

   ```
   http://localhost/pemesanan-makanan
   ```

---

## 📸 Screenshot (Opsional)

Tambahkan screenshot di bawah ini:

```
![Landing Page](assets/img/landing.png)
![Dashboard](assets/img/dashboard.png)
![Forecasting](assets/img/moving-average.png)
```

---

## 📞 Kontak

Untuk informasi lebih lanjut, silakan hubungi pemilik aplikasi.

---

## 📄 Lisensi

Open Source / Private – sesuaikan kebutuhan Anda.
