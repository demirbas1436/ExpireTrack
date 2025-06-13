# 📦 MySQL PHP CRUD Projesi

Bu proje, PHP ve MySQL kullanılarak geliştirilmiş **CRUD (Create, Read, Update, Delete)** uygulamasıdır. Kullanıcı yönetimi, dosya yükleme ve görsel destek sunar.

---

## 📑 İçindekiler

- [🚀 Özellikler](#-özellikler)
- [🗂️ Proje Yapısı](#️-proje-yapısı)
- [⚙️ Gereksinimler](#️-gereksinimler)
- [🔧 Kurulum](#-kurulum)
- [🛠️ Veritabanı Yapılandırması](#️-veritabanı-yapılandırması)
- [🎬 Tanıtım Videosu](#-tanıtım-videosu)
- [🖼️ Ekran Görüntüleri](#️-ekran-görüntüleri)
- [🔒 Güvenlik Notları](#-güvenlik-notları)
- [✨ Katkıda Bulunma](#-katkıda-bulunma)
- [📄 Lisans](#-lisans)

---

## 🚀 Özellikler

- Kullanıcı kayıt ve giriş sistemi  
- Yetkilendirme kontrolü  
- Ürün ekleme, listeleme, düzenleme ve silme  
- Dosya yükleme ve görüntüleme desteği  
- PHP `password_hash` ve `password_verify` ile güvenli şifreleme  
- Basit, anlaşılır ve genişletilebilir kod yapısı

---

## 🗂️ Proje Yapısı

```
mysql_proje/
│
├── add_product.php          
├── dashboard.php            
├── delete_product.php       
├── edit_product.php         
├── index.php                
├── login.php                
├── login_process.php        
├── logout.php               
├── register.php             
├── register_process.php     
├── view_file.php            
│
├── includes/
│   ├── auth.php             
│   └── db.php               
│
└── uploads/                 
```

---

## ⚙️ Gereksinimler

- PHP 7.x veya üzeri  
- MySQL veya MariaDB  
- Apache veya Nginx sunucusu  
- Tarayıcı erişimi (Chrome, Firefox vb.)

---

## 🔧 Kurulum

1. Proje dosyalarını sunucunuza veya `htdocs` (XAMPP) klasörüne kopyalayın.  
2. `includes/db.php` dosyasında veritabanı bağlantı bilgilerinizi güncelleyin:
   ```php
   $servername = "localhost";
   $username = "kullanici_adiniz";
   $password = "şifreniz";
   $dbname = "veritabani_adiniz";
   ```
3. Veritabanı tablolarını oluşturmak için:
   ```sql
   CREATE TABLE users (
     id INT AUTO_INCREMENT PRIMARY KEY,
     username VARCHAR(50) NOT NULL UNIQUE,
     password VARCHAR(255) NOT NULL
   );

   CREATE TABLE products (
     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(100) NOT NULL,
     description TEXT,
     price DECIMAL(10,2),
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   ```
4. Tarayıcıda `http://localhost/mysql_proje` adresine gidin.

---

## 🛠️ Veritabanı Yapılandırması

- `users` tablosu: Kullanıcı bilgilerini tutar.  
- `products` tablosu: Ürün detayları ve fiyat bilgilerini tutar.  
- Gerektiğinde ek tablolar oluşturup projeyi genişletebilirsiniz.

---

## 🎬 Tanıtım Videosu

[Demo Videosunu İzle](https://www.youtube.com/watch?v=4dztHVLFQJ8)
---

## 🖼️ Ekran Görüntüleri


![Dashboard](![Ekran görüntüsü 2025-06-13 205544](https://github.com/user-attachments/assets/9fba9df6-03d2-4c39-99d6-2d5d2ba1e1fb)
)  
![Ürün Ekleme](![Ekran görüntüsü 2025-06-13 205723](https://github.com/user-attachments/assets/f0bbd1a8-41a9-426e-a761-998e7fb7bcf5)
)  


---

## 🔒 Güvenlik Notları

- Şifreler PHP’nin yerleşik fonksiyonları ile hashlenir.  
- `auth.php` ile yetkisiz erişimler kontrol edilir.  
- Dosya yükleme boyutu ve türü için ek kontroller ekleyebilirsiniz.

---

## ✨ Katkıda Bulunma

Proje, PHP öğrenmek isteyen geliştiricilere açıktır. Katkı sağlamak için fork yapıp pull request gönderin!

---

## 📄 Lisans

Bu proje [MIT Lisansı](LICENSE) ile lisanslanmıştır. İstediğiniz gibi kullanabilir ve değiştirebilirsiniz.
