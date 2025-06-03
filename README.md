# 🧾 Garanti ve Fatura Takip Sistemi

📦 **“Aldığın Ürünlerin Faturasını, Garantisini Unutma!”**

Bu proje, kullanıcıların satın aldıkları ürünlerin fatura bilgilerini ve garanti sürelerini takip etmelerini sağlayan basit, işlevsel bir web uygulamasıdır.

## 🔧 Teknolojiler
- PHP (yalın)
- MySQL
- Bootstrap (CDN ile)
- HTML, CSS, JavaScript

## 📂 Özellikler
- ✅ Kullanıcı kaydı ve şifreli giriş
- ✅ Oturum yönetimi (Session)
- ✅ Ürün/fatura kaydı (Create)
- ✅ Kayıtları listeleme (Read)
- ✅ Bilgi güncelleme (Update)
- ✅ Kayıt silme (Delete)
- ✅ Garanti süresi hesaplama (kalan gün)
- ✅ Mobil uyumlu arayüz (Bootstrap)

## 🗃️ Veritabanı Tasarımı

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255)
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  product_name VARCHAR(100),
  brand VARCHAR(100),
  purchase_date DATE,
  warranty_period INT,
  invoice_number VARCHAR(100),
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
```

## 🖼️ Ekran Görüntüleri

![Giriş Sayfası](screenshots/login.png)
![Ürün Listesi](screenshots/dashboard.png)

> Not: `screenshots` klasörüne `.png` dosyalarını eklemeyi unutmayın.

## 🎥 Tanıtım Videosu

📺 İzlemek için: [Tanıtım Videosu (YouTube)](https://youtu.be/your-video-link) *(ya da Google Drive bağlantınız)*

## 🚀 Kurulum

1. Veritabanını `garanti_takip.sql` olarak oluşturun.
2. `includes/db.php` içinde veritabanı bağlantınızı güncelleyin.
3. Tarayıcınızda `localhost/projeniz` adresini açın.

## 👤 Geliştirici

- Adınız: **Murat**
- Yapay zeka desteği: `AI.md` dosyasına bakınız.
