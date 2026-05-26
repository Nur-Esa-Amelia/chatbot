# Chatbot Diskominfo - Update v2.0

## 📋 Fitur Baru

Plugin chatbot telah diupdate dengan 2 fitur utama:

### 1. **Mode Pertanyaan** 
- User dapat menanyakan hal apapun seputar informasi yang tersedia di tabel `wp_chatbot_faq`
- Chatbot akan otomatis mencari jawaban berdasarkan keyword yang cocok
- Jika tidak menemukan keyword yang sesuai, akan menampilkan pesan "Maaf, informasi tidak ditemukan"

### 2. **Mode Pengaduan** 
- User dapat mengajukan pengaduan/keluhan
- Flow pengaduan terdiri dari 2 pertanyaan wajib:
  1. **Pertanyaan 1**: Keluhan (apa keluhan/masalah anda?)
  2. **Pertanyaan 2**: Email (berapa email anda untuk kami hubungi?)
- Pengaduan akan tersimpan di tabel `wp_pengaduan` dengan status "pending"
- Admin akan mendapatkan notifikasi di halaman admin panel untuk mengelola pengaduan

---

## 🗄️ Database Schema

### Tabel: `wp_chatbot_faq`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | mediumint | Primary Key |
| keyword | varchar(255) | Kata kunci untuk pencarian |
| jawaban | text | Jawaban untuk keyword tersebut |

### Tabel: `wp_pengaduan` (Baru)
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | mediumint | Primary Key |
| keluhan | text | Isi keluhan dari pengguna |
| email_pelapor | varchar(255) | Email pengguna yang melaporkan |
| jawaban_admin | text | Jawaban dari admin (nullable) |
| status | varchar(20) | Status pengaduan: 'pending' atau 'selesai' |
| tanggal_buat | datetime | Waktu pengaduan dibuat |
| tanggal_update | datetime | Waktu pengaduan terakhir diupdate |

---

## 🚀 Cara Menggunakan

### Untuk User (Frontend)
1. Buka website dan klik tombol chatbot di sudut kanan bawah
2. Pilih salah satu dari 2 opsi:
   - **❓ Pertanyaan**: Tanya apapun tentang informasi di website
   - **📢 Pengaduan**: Laporkan keluhan atau masalah

#### Flow Pertanyaan
- Ketik pertanyaan anda
- Chatbot akan mencari jawaban otomatis dari database

#### Flow Pengaduan
1. Klik tombol "📢 Pengaduan"
2. Ketik keluhan/masalah anda secara detail
3. Ketik email anda (untuk dihubungi kembali)
4. Pengaduan akan terkirim ke admin

### Untuk Admin (Backend)
1. Login ke WordPress Admin Panel
2. Pergi ke menu **"Pengaduan Chatbot"** (di sidebar)
3. Anda akan melihat daftar semua pengaduan yang masuk
4. Klik tombol **"Edit & Balas"** untuk:
   - Melihat detail keluhan
   - Menulis jawaban/solusi
   - Mengubah status (pending → selesai)
5. Klik **"Simpan & Kirim Email"** - sistem akan:
   - Menyimpan jawaban ke database
   - Otomatis mengirim email dengan jawaban ke email pengguna

---

## 📧 Email Configuration

Sistem akan otomatis mengirim email ke pelapor dengan format:

**Subject**: Balasan Pengaduan Anda - Diskominfo

**Isi Email**:
```
Halo,

Terimakasih telah melaporkan keluhan kepada kami. Berikut adalah tanggapan kami:

[JAWABAN DARI ADMIN]

Terima kasih telah menjadi bagian dari komunitas kami.

Best Regards,
Diskominfo
```

**Catatan**: Pastikan konfigurasi email server WordPress sudah benar agar email dapat terkirim.

---

## 🔒 Validasi & Keamanan

- **Email Validation**: Email yang diinput akan divalidasi sebelum disimpan
- **Required Fields**: Keluhan dan email adalah field wajib isi
- **XSS Protection**: Semua input user di-escape untuk mencegah XSS attack
- **CSRF Protection**: Menggunakan WordPress nonce untuk form admin
- **Sanitization**: Semua input di-sanitize sebelum disimpan ke database

---

## 🔧 Developer Notes

### AJAX Endpoints

1. **Pencarian FAQ** (Mode Pertanyaan)
   - Action: `chatbot_response`
   - Method: POST
   - Parameter: `message` (string)
   - Return: Jawaban dari database atau pesan default

2. **Simpan Pengaduan** (Mode Pengaduan)
   - Action: `chatbot_save_complaint`
   - Method: POST
   - Parameter: `keluhan`, `email`
   - Return: JSON response dengan success/error message

### Filter & Hook

Developers bisa menggunakan filter/hook berikut:
- `chatbot_faq_response` - Filter respons FAQ
- `chatbot_complaint_email_subject` - Filter subject email pengaduan
- `chatbot_complaint_email_message` - Filter isi email pengaduan

---

## 🐛 Troubleshooting

### Email tidak terkirim?
- Pastikan WordPress email configuration sudah benar
- Check logs di `wp-content/debug.log`
- Verifikasi email address valid

### Pengaduan tidak tersimpan?
- Check browser console untuk error
- Verify database permissions
- Pastikan tabel `wp_pengaduan` sudah dibuat

### Pertanyaan tidak menemukan jawaban?
- Check keywords di tabel `wp_chatbot_faq`
- Pastikan keyword sudah ditambahkan dengan format yang tepat (comma-separated)

---

## 📝 Changelog

### v2.0 (Current)
- ✅ Tambah Mode Pengaduan dengan flow 2 pertanyaan
- ✅ Buat tabel `wp_pengaduan` untuk menyimpan pengaduan
- ✅ Admin panel untuk kelola pengaduan
- ✅ Email notification ke pelapor saat admin mengirim jawaban
- ✅ Status tracking (pending/selesai)

### v1.0 (Previous)
- FAQ searching berdasarkan keyword

---

## 👨‍💻 Author
Amelia

## 📞 Support
Untuk bantuan lebih lanjut, hubungi developer team.
