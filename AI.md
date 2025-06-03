# 🤖 Yapay Zeka Destekli Geliştirme Günlüğü

Bu dosya, "🧾 Garanti ve Fatura Takip Sistemi" projesi geliştirilirken ChatGPT'den alınan destekleri içermektedir.

---

## 📅 2025-06-02

**Kullanıcı:**
“Garanti ve Fatura Takip Sistemi” adında bir PHP + MySQL projesi yapmak istiyorum. Ödevde kullanıcı kaydı, giriş, bilgi girişi, düzenleme, silme gibi işlemler olacak. Bana dosya yapısı ve veritabanı önerir misin?

**ChatGPT:**
Elbette! Örnek bir klasör yapısı:

- `register.php`, `login.php`, `logout.php`
- `dashboard.php` (listeleme)
- `add_product.php`, `edit_product.php`, `delete_product.php`
- `includes/db.php` (veritabanı)
- `includes/auth.php` (oturum kontrolü)
- `style.css` (tema)
- Bootstrap ile responsive tasarım

Veritabanı yapısı:

```sql
CREATE DATABASE garanti_takip;

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

---

## 📅 2025-06-03

**Kullanıcı:**
Dashboard’da ürün listesi boş gözüküyor, hata alıyorum: `Warning: foreach() argument must be of type array|object, null given`.

**ChatGPT:**
Bu hata `$products` değişkeninin boş olmasından kaynaklı. Veritabanından ürünleri çeken kodda bir hata olabilir. `fetch_all(MYSQLI_ASSOC)` ile diziye çevirip kontrol et:

```php
$result = $conn->query($sql);
$products = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
```

---

## 📅 2025-06-04

**Kullanıcı:**
Tüm sayfalar Bootstrap ile responsive olsun ama hazır tema kullanmak istemiyorum.

**ChatGPT:**
Tamam! Bootstrap CSS’i sadece kütüphane olarak ekleyelim. Tüm sayfalarda `container`, `row`, `col`, `form-control`, `btn`, `table` gibi sınıfları kullanarak sade, ama uyumlu bir görünüm elde edebiliriz.

---

## 📅 2025-06-05

**Kullanıcı:**
`README.md` ve `AI.md` dosyalarını oluşturur musun?

**ChatGPT:**
✅ `README.md` ve bu belge (`AI.md`) oluşturuldu. GitHub’a yüklenmesi ve tanıtım videosu bağlantısının eklenmesi gerektiği hatırlatıldı.

---

## Genel Notlar:

- Tüm şifreler `password_hash()` ile şifrelenmiştir.
- Oturum işlemleri `$_SESSION` ile yapılmıştır.
- Dış kaynak olarak yalnızca Bootstrap CSS/JS kullanılmıştır.
- Framework (Laravel vs.) veya dış PHP kütüphanesi kullanılmamıştır.