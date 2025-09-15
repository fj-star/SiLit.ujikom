<p align="center">
    <a href="#" target="_blank">
        <img src="https://cdn-icons-png.flaticon.com/512/809/809957.png" width="120" alt="Laundry Logo">
    </a>
</p>

<p align="center">
<a href="https://github.com/username/laundry-app/actions"><img src="https://img.shields.io/github/actions/workflow/status/username/laundry-app/laravel.yml?branch=main" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="#"><img src="https://img.shields.io/github/v/release/username/laundry-app" alt="Latest Stable Version"></a>
<a href="LICENSE"><img src="https://img.shields.io/github/license/username/laundry-app" alt="License"></a>
</p>

---

## 🧺 About Laundry Management System

**Laundry Management System** adalah aplikasi berbasis **Laravel** untuk membantu usaha laundry dalam mengelola:
- Data pelanggan
- Data layanan & treatment
- Transaksi laundry (status: pending, proses, selesai)
- Metode pembayaran
- Laporan transaksi  

Dengan aplikasi ini, manajemen laundry menjadi lebih mudah, cepat, dan terstruktur.

---

## 🚀 Features

- Autentikasi (Admin & Pelanggan)  
- CRUD Layanan, Pelanggan, dan Transaksi  
- Status Order: Pending, Proses, Selesai  
- SweetAlert untuk notifikasi interaktif  
- Laporan transaksi berdasarkan tanggal  
- Responsive Design (Bootstrap/Tailwind)  

---

## 🛠️ Installation

```bash
git clone https://github.com/fj-star/SiLit.ujikom.git
cd laundry-app
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
