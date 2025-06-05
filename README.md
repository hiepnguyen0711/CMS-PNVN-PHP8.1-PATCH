# 🔧 Patch PHP 8.1 cho dự án CMS PHUONG NAM VINA

Bản vá này giúp mã nguồn **CMS PHUONG NAM VINA** tương thích với PHP 8.1 bằng cách cập nhật một số file có cú pháp hoặc hàm không còn được hỗ trợ.

---

## 📋 Nội dung bản vá

- Thay thế hàm `each()` bằng `foreach()` (do `each()` bị loại bỏ từ PHP 8.0)
- Gỡ bỏ `get_magic_quotes_gpc()` (đã bị loại hoàn toàn)
- Chuyển đổi constructor kiểu cũ thành `__construct()` (theo chuẩn PHP 7+)
- Giữ nguyên cấu trúc thư mục để dễ dàng sao chép vào project

---

## ⚙️ Hướng dẫn sử dụng (cách nhanh nhất)

### ✅ Bước 1: Mở terminal tại thư mục gốc project CMS PHUONG NAM VINA

### ✅ Bước 2: Chạy 1 dòng lệnh sau:

```bash
git clone https://github.com/hiepnguyen0711/CMS-PNVN-PHP8.1-PATCH.git temp-patch && cp -r temp-patch/* ./ && rm -rf temp-patch
```

> ⚠️ Lưu ý: Thao tác này sẽ **tự động ghi đè** các file đã chỉnh sửa vào đúng vị trí tương ứng trong source.

---

## 📁 Danh sách file được cập nhật

- `Mobile_Detect.php`
- `admin/ckeditor/samples/old/assets/posteddata.php`
- `admin/filemanager/dialog.php`
- `admin/lib/class.php`
- `admin/lib/Mobile_Detect.php`
- `smtp/class.phpmailer.php`
- `smtp/class.smtp.php`
- `sources/index.php`
- `sources/module/page/page-content.php`
- `sources/templates/js.php`

---

## 🤝 Hỗ trợ & Liên hệ

Nếu bạn cần trợ giúp khi cập nhật, hãy tạo issue trong repo GitHub này hoặc liên hệ trực tiếp qua:

📘 Facebook: [facebook.com/G.N.S.L.7](https://www.facebook.com/G.N.S.L.7/)

---

## 💖 Ủng hộ tác giả

Nếu bạn thấy bản vá này hữu ích, có thể ủng hộ mình qua thông tin chuyển khoản:

- **Số tài khoản:** `0601 5576 3127`
- **Chủ tài khoản:** NGUYEN VAN HIEP
- **Ngân hàng:** Sacombank
- **Chi nhánh:** PGD LÊ VĂN QUỚI

Cảm ơn bạn đã sử dụng ✨ **HIEP NGUYEN** ✨
