# 🐝 BeeCook — Where Quality Meets Flavor

**Aplikasi web resep makanan yang dibangun dengan Laravel + Livewire + Tailwind CSS**

## 🍽️ Tentang Proyek

**BeeCook** adalah aplikasi web platform resep makanan yang menampilkan berbagai kategori masakan seperti Main Course, Beverages, Appetizer, Side Dish, dan Dessert. Aplikasi ini mengkonsumsi data dari **external REST API** yang telah disediakan oleh Gbee Glow Indonesia.

Proyek ini bertujuan untuk mendemonstrasikan kemampuan dalam:
- Membangun tampilan yang sesuai dengan desain UI/UX (pixel-perfect dari Figma)
- Mengintegrasikan frontend dengan REST API eksternal
- Menulis kode yang bersih, terstruktur, dan mudah dikembangkan
- Membuat tampilan yang **responsif** di semua ukuran layar

---

## 🖥️ Tampilan Halaman

| Halaman | Deskripsi |
|---------|-----------|
| **Beranda** | Hero section, kategori makanan, dan form newsletter |
| **List Resep** | Daftar semua resep dengan filter kategori dan pagination |
| **Detail Resep** | Informasi lengkap resep: nutrisi, bahan-bahan, dan cara masak |
| **Kelola Resep** | Untuk delete dan tambah gambar menu |
| **Form Buat Resep** | Untuk tambah dan edit menu |

---

## 🛠️ Tech Stack

| Kategori | Teknologi |
|----------|-----------|
| **Backend Framework** | Laravel 12.x |
| **Frontend Reaktif** | Livewire 4.x |
| **CSS Framework** | Tailwind CSS 4.x |
| **Templating** | Blade Template Engine |
| **Language** | PHP 8.2+, JavaScript (ES Module) |
| **Package Manager** | Composer, NPM |

---

## ✨ Fitur

### Halaman Beranda
- Hero section dengan headline **"Where Quality Meets Flavor"**
- Tombol **Eksplor Sekarang** menuju halaman list resep
- Counter pengguna aktif
- Galeri kategori makanan yang dapat diklik (Main Course, Beverages, Appetizer, Side Dish, Dessert)
- Section newsletter dengan form subscribe email
- Foto chef ilustrasi

### Halaman List Resep
- **Filter kategori** (Semua / Main Course / Beverages / Appetizer / Side Dish / Dessert)
- **Grid resep** 3 kolom (desktop), 2 kolom (tablet), 1 kolom (mobile)
- Setiap card resep menampilkan: gambar, kategori, durasi memasak, dan judul
- **Pagination** dengan navigasi previous/next dan nomor halaman

### Halaman Detail Resep
- **Banner gambar** full-width dengan overlay judul resep
- Informasi **Kategori** dan **Durasi** memasak
- Deskripsi resep
- **Infomasi Nutrisi** (Kalori, Protein, Lemak, Karbohidrat) dalam card box
- **Daftar Bahan-bahan** lengkap
- **Cara Masak** dengan langkah bernomor

### Umum
- Navigasi **Navbar** responsif dengan hamburger menu di mobile
- **Footer** dengan Partnership, Bantuan, dan ikon sosial media (TikTok, Facebook, Instagram, X)
- Integrasi dengan **External REST API** dari `https://frontend-api.gbeeglow.id`
- Tampilan **responsif** penuh di desktop, tablet, dan mobile

---

## ⚙️ Persyaratan Sistem

Sebelum memulai, pastikan sistem kamu memenuhi persyaratan berikut:

- **PHP** >= 8.2
- **Composer** >= 2.x
- **Git**
- Database: **SQLite** (default) atau MySQL

---

## 🚀 Instalasi & Menjalankan Proyek

### 1. Clone Repositori

```bash
git clone https://github.com/yogabagaskurniawan/BeeCook_YogaBagasKurniawan.git
cd BeeCook_YogaBagasKurniawan
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database

Secara default proyek menggunakan SQLite. Buat file database-nya:

```bash
touch database/database.sqlite
php artisan migrate
```

> Jika ingin menggunakan MySQL, ubah konfigurasi di file `.env`:
> ```env
> DB_CONNECTION=mysql
> DB_HOST=127.0.0.1
> DB_PORT=3306
> DB_DATABASE=beecook
> DB_USERNAME=root
> DB_PASSWORD=
> ```
> Lalu jalankan `php artisan migrate`

### 5. Jalankan Aplikasi

**jalankan proyek:**

```bash
# Terminal 1 — Laravel server
php artisan serve

```

### 6. Buka di Browser

```
http://localhost:8000
```

---

## 🔌 Konfigurasi API

Proyek ini mengkonsumsi data dari REST API eksternal Gbee Glow Indonesia.

### Base URL API

```
https://frontend-api.gbeeglow.id
```

### Tambahkan ke `.env`

```env
API_BASE_URL=https://frontend-api.gbeeglow.id
```

### Verifikasi Koneksi API

Setelah konfigurasi, pastikan API dapat diakses dengan melakukan request ke endpoint `/WELCOME`. Response yang diharapkan adalah status **200 OK**.

---

## 📝 Konteks Recruitment Test

Proyek ini dikerjakan sebagai bagian dari seleksi **Frontend Developer** di **Gbee Glow Indonesia**.

**Detail Test:**
- **Framework yang digunakan:** Laravel (sesuai pilihan peserta)
- **Desain referensi:** Figma (Recruitment Frontend Gbee Glow Indonesia)
- **API:** REST API dari `https://frontend-api.gbeeglow.id`

**Requirement yang dikerjakan:**
- ✅ Halaman Beranda (Home)
- ✅ Halaman List Resep dengan filter kategori & pagination
- ✅ Halaman Detail Resep
- ✅ Halaman Kelola Resep
- ✅ Halaman Tambah dan Edit Resep
- ✅ Tampilan responsif (desktop & mobile)
- ✅ Integrasi dengan External REST API
- ✅ Tampilan semaksimal mungkin sesuai desain Figma

---

## 🖥️ Preview

### Halaman Beranda

![Preview Beranda](https://github.com/yogabagaskurniawan/BeeCook_YogaBagasKurniawan/blob/main/public/preview/beranda.png)

---

### Halaman List Resep

![Preview NFT Display & Send](https://github.com/yogabagaskurniawan/BeeCook_YogaBagasKurniawan/blob/main/public/preview/list.png)

---

### Halaman Detail Resep

![Preview NFT Display & Send](https://github.com/yogabagaskurniawan/BeeCook_YogaBagasKurniawan/blob/main/public/preview/detail.png)

---

### Halaman Kelola Resep

![Preview NFT Display & Send](https://github.com/yogabagaskurniawan/BeeCook_YogaBagasKurniawan/blob/main/public/preview/kelola.png)

---

### Halaman Form Kelola Resep

![Preview NFT Display & Send](https://github.com/yogabagaskurniawan/BeeCook_YogaBagasKurniawan/blob/main/public/preview/form.png)

---

## 👨‍💻 Author

**Yoga Bagas Kurniawan**

- GitHub: [@yogabagaskurniawan](https://github.com/yogabagaskurniawan)

---

<div align="center">

**BeeCook** — *Where Quality Meets Flavor* 🍳

Dibuat dengan ❤️ menggunakan Laravel & Tailwind CSS

</div>
