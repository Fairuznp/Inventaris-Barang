# 📋 **Invenbar API Documentation**

Dokumentasi API untuk sistem peminjaman barang Invenbar. API ini menyediakan endpoint untuk aplikasi mobile/web client untuk mengakses data barang dan mengelola permintaan peminjaman.

## 🔗 **Base URL**

```
http://localhost/api/v1
```

## 📖 **Table of Contents**

-   Authentication
-   Status Information
-   Barang Endpoints
-   Loan Request Endpoints
-   Error Handling
-   Response Format
-   Example Usage

---

## 🔐 **Authentication**

Saat ini API bersifat **public** dan tidak memerlukan authentication untuk mengakses endpoint. Untuk endpoint yang memerlukan user identification, gunakan parameter `user_identifier`.

---

## 📊 **Status Information**

### **Loan Request Status Options:**

| Status      | Description                | User Actions              | Admin Actions     | Cancel Requirements     |
| ----------- | -------------------------- | ------------------------- | ----------------- | ----------------------- |
| `pending`   | Menunggu persetujuan admin | ✅ Cancel (dengan alasan) | ✅ Approve/Reject | Alasan min. 10 karakter |
| `approved`  | Disetujui oleh admin       | ❌ No actions             | ✅ Track return   | -                       |
| `rejected`  | Ditolak oleh admin         | ❌ No actions             | ❌ No actions     | -                       |
| `cancelled` | Dibatalkan oleh user       | ❌ No actions             | ❌ No actions     | -                       |

### **Status Transitions:**

```
pending → approved (by admin)
pending → rejected (by admin)
pending → cancelled (by user with required reason)
```

**Note:** Setelah status berubah dari `pending`, tidak ada perubahan status lebih lanjut yang diizinkan.

### **Cancel Business Rules:**

1. **Status Requirement:** Hanya request dengan status `pending` yang dapat dibatalkan
2. **User Verification:** User hanya dapat membatalkan request milik sendiri (sesuai `user_identifier`)
3. **Reason Mandatory:** Alasan pembatalan **wajib diisi** dengan minimal 10 karakter dan maksimal 500 karakter
4. **Admin Tracking:** Alasan pembatalan akan tersimpan di `admin_notes` untuk tracking
5. **Real-time Notification:** Admin akan mendapat notifikasi real-time saat ada pembatalan

---

## 📦 **Barang Endpoints**

### **GET /barangs**

Mendapatkan daftar barang yang dapat dipinjam.

**Query Parameters:**

-   `search` (string, optional) - Pencarian berdasarkan nama atau kode barang
-   `kategori_id` (integer, optional) - Filter berdasarkan kategori
-   `lokasi_id` (integer, optional) - Filter berdasarkan lokasi
-   `page` (integer, optional) - Nomor halaman untuk pagination

**Example Request:**

```http
GET /api/v1/barangs?search=laptop&kategori_id=1&page=1
```

**Example Response:**

```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "nama_barang": "Laptop Dell Inspiron",
                "kode_barang": "LP001",
                "deskripsi": "Laptop untuk keperluan kantor",
                "stok": 5,
                "satuan": "unit",
                "tanggal_pengadaan": "2024-01-15",
                "dapat_dipinjam": true,
                "gambar": "laptop.jpg",
                "kategori": {
                    "id": 1,
                    "nama_kategori": "Elektronik"
                },
                "lokasi": {
                    "id": 1,
                    "nama_lokasi": "Gudang A"
                },
                "created_at": "2024-10-01T10:30:00.000000Z",
                "updated_at": "2024-10-01T10:30:00.000000Z"
            }
        ],
        "first_page_url": "http://localhost/api/v1/barangs?page=1",
        "from": 1,
        "last_page": 3,
        "last_page_url": "http://localhost/api/v1/barangs?page=3",
        "next_page_url": "http://localhost/api/v1/barangs?page=2",
        "path": "http://localhost/api/v1/barangs",
        "per_page": 12,
        "prev_page_url": null,
        "to": 12,
        "total": 30
    }
}
```

---

### **GET /barangs/{id}**

Mendapatkan detail barang berdasarkan ID.

**Path Parameters:**

-   `id` (integer, required) - ID barang

**Example Request:**

```http
GET /api/v1/barangs/1
```

**Example Response:**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "nama_barang": "Laptop Dell Inspiron",
        "kode_barang": "LP001",
        "deskripsi": "Laptop untuk keperluan kantor dengan spesifikasi Intel Core i5",
        "stok": 5,
        "satuan": "unit",
        "tanggal_pengadaan": "2024-01-15",
        "dapat_dipinjam": true,
        "gambar": "laptop.jpg",
        "kategori": {
            "id": 1,
            "nama_kategori": "Elektronik"
        },
        "lokasi": {
            "id": 1,
            "nama_lokasi": "Gudang A"
        },
        "available_stock": 3,
        "created_at": "2024-10-01T10:30:00.000000Z",
        "updated_at": "2024-10-01T10:30:00.000000Z"
    }
}
```

---

### **GET /categories**

Mendapatkan daftar semua kategori barang.

**Example Request:**

```http
GET /api/v1/categories
```

**Example Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nama_kategori": "Elektronik",
            "created_at": "2024-10-01T10:30:00.000000Z",
            "updated_at": "2024-10-01T10:30:00.000000Z"
        },
        {
            "id": 2,
            "nama_kategori": "Furniture",
            "created_at": "2024-10-01T10:30:00.000000Z",
            "updated_at": "2024-10-01T10:30:00.000000Z"
        }
    ]
}
```

---

### **GET /locations**

Mendapatkan daftar semua lokasi penyimpanan barang.

**Example Request:**

```http
GET /api/v1/locations
```

**Example Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nama_lokasi": "Gudang A",
            "created_at": "2024-10-01T10:30:00.000000Z",
            "updated_at": "2024-10-01T10:30:00.000000Z"
        },
        {
            "id": 2,
            "nama_lokasi": "Ruang Server",
            "created_at": "2024-10-01T10:30:00.000000Z",
            "updated_at": "2024-10-01T10:30:00.000000Z"
        }
    ]
}
```

---

## 📝 **Loan Request Endpoints**

### **GET /loan-requests**

Mendapatkan daftar permintaan peminjaman berdasarkan user identifier.

**Query Parameters:**

-   `user_identifier` (string, required) - Email atau identifier unik user
-   `status` (string, optional) - Filter berdasarkan status: `pending`, `approved`, `rejected`
-   `page` (integer, optional) - Nomor halaman untuk pagination

**Example Request:**

```http
GET /api/v1/loan-requests?user_identifier=john.doe@example.com&status=pending
```

**Example Response:**

```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "user_identifier": "john.doe@example.com",
                "nama_peminjam": "John Doe",
                "kontak_peminjam": "081234567890",
                "instansi_peminjam": "PT. Example",
                "jumlah": 2,
                "tanggal_pinjam": "2024-12-01",
                "tanggal_kembali": "2024-12-05",
                "keterangan": "Untuk presentasi klien",
                "status": "pending",
                "admin_notes": null,
                "approved_by": null,
                "approved_at": null,
                "barang": {
                    "id": 1,
                    "nama_barang": "Laptop Dell Inspiron",
                    "kode_barang": "LP001",
                    "kategori": {
                        "id": 1,
                        "nama_kategori": "Elektronik"
                    },
                    "lokasi": {
                        "id": 1,
                        "nama_lokasi": "Gudang A"
                    }
                },
                "created_at": "2024-10-01T10:30:00.000000Z",
                "updated_at": "2024-10-01T10:30:00.000000Z"
            }
        ],
        "total": 5
    }
}
```

---

### **POST /loan-requests**

Membuat permintaan peminjaman baru.

**Request Body:**

```json
{
    "user_identifier": "john.doe@example.com",
    "barang_id": 1,
    "nama_peminjam": "John Doe",
    "kontak_peminjam": "081234567890",
    "instansi_peminjam": "PT. Example",
    "jumlah": 2,
    "tanggal_pinjam": "2024-12-01",
    "tanggal_kembali": "2024-12-05",
    "keterangan": "Untuk presentasi klien"
}
```

**Validation Rules:**

-   `user_identifier`: required, string, max:255
-   `barang_id`: required, exists in barangs table
-   `nama_peminjam`: required, string, max:255
-   `kontak_peminjam`: required, string, max:255
-   `instansi_peminjam`: optional, string, max:255
-   `jumlah`: required, integer, min:1
-   `tanggal_pinjam`: required, date, today or future
-   `tanggal_kembali`: required, date, after tanggal_pinjam
-   `keterangan`: optional, string, max:1000

**Example Request:**

```http
POST /api/v1/loan-requests
Content-Type: application/json

{
    "user_identifier": "john.doe@example.com",
    "barang_id": 1,
    "nama_peminjam": "John Doe",
    "kontak_peminjam": "081234567890",
    "instansi_peminjam": "PT. Example",
    "jumlah": 2,
    "tanggal_pinjam": "2024-12-01",
    "tanggal_kembali": "2024-12-05",
    "keterangan": "Untuk presentasi klien"
}
```

**Success Response (201):**

```json
{
    "success": true,
    "message": "Permintaan peminjaman berhasil diajukan",
    "data": {
        "id": 15,
        "user_identifier": "john.doe@example.com",
        "nama_peminjam": "John Doe",
        "kontak_peminjam": "081234567890",
        "instansi_peminjam": "PT. Example",
        "jumlah": 2,
        "tanggal_pinjam": "2024-12-01",
        "tanggal_kembali": "2024-12-05",
        "keterangan": "Untuk presentasi klien",
        "status": "pending",
        "barang": {
            "id": 1,
            "nama_barang": "Laptop Dell Inspiron",
            "kode_barang": "LP001",
            "kategori": {
                "nama_kategori": "Elektronik"
            },
            "lokasi": {
                "nama_lokasi": "Gudang A"
            }
        },
        "created_at": "2024-10-01T14:22:33.000000Z",
        "updated_at": "2024-10-01T14:22:33.000000Z"
    }
}
```

---

### **GET /loan-requests/{id}**

Mendapatkan detail permintaan peminjaman berdasarkan ID.

**Path Parameters:**

-   `id` (integer, required) - ID loan request

**Query Parameters:**

-   `user_identifier` (string, required) - Email atau identifier unik user untuk validasi kepemilikan

**Example Request:**

```http
GET /api/v1/loan-requests/15?user_identifier=john.doe@example.com
```

**Example Response:**

```json
{
    "success": true,
    "data": {
        "id": 15,
        "user_identifier": "john.doe@example.com",
        "nama_peminjam": "John Doe",
        "kontak_peminjam": "081234567890",
        "instansi_peminjam": "PT. Example",
        "jumlah": 2,
        "tanggal_pinjam": "2024-12-01",
        "tanggal_kembali": "2024-12-05",
        "keterangan": "Untuk presentasi klien",
        "status": "approved",
        "admin_notes": "Disetujui untuk kebutuhan presentasi",
        "approved_by": 1,
        "approved_at": "2024-10-01T15:30:00.000000Z",
        "barang": {
            "id": 1,
            "nama_barang": "Laptop Dell Inspiron",
            "kode_barang": "LP001",
            "kategori": {
                "nama_kategori": "Elektronik"
            },
            "lokasi": {
                "nama_lokasi": "Gudang A"
            }
        },
        "approver": {
            "id": 1,
            "name": "Admin User"
        },
        "created_at": "2024-10-01T14:22:33.000000Z",
        "updated_at": "2024-10-01T15:30:00.000000Z"
    }
}
```

---

### **PATCH /loan-requests/{id}/cancel**

Membatalkan permintaan peminjaman (hanya untuk status pending). **Alasan pembatalan wajib diisi minimal 10 karakter.**

**Path Parameters:**

-   `id` (integer, required) - ID loan request

**Request Body:**

```json
{
    "user_identifier": "john.doe@example.com",
    "reason": "Tidak jadi meminjam karena kebutuhan sudah terpenuhi dari sumber lain"
}
```

**Field Requirements:**

-   `user_identifier` (string, required) - Email/phone identifier user
-   `reason` (string, required) - Alasan pembatalan, minimal 10 karakter, maksimal 500 karakter

**Example Request:**

```http
PATCH /api/v1/loan-requests/15/cancel
Content-Type: application/json

{
    "user_identifier": "john.doe@example.com",
    "reason": "Tidak jadi meminjam karena kebutuhan sudah terpenuhi dari sumber lain"
}
```

**Success Response (200):**

```json
{
    "success": true,
    "message": "Permintaan peminjaman berhasil dibatalkan",
    "data": {
        "id": 15,
        "user_identifier": "john.doe@example.com",
        "nama_peminjam": "John Doe",
        "kontak_peminjam": "+62812345678",
        "status": "cancelled",
        "admin_notes": "Dibatalkan oleh user: Tidak jadi meminjam karena kebutuhan sudah terpenuhi dari sumber lain",
        "barang": {
            "id": 3,
            "nama_barang": "Projector Epson",
            "kode_barang": "PRJ001"
        },
        "updated_at": "2024-10-01T15:45:00.000000Z"
    }
}
```

**Error Responses:**

**Validation Error - Missing Reason (422):**

```json
{
    "success": false,
    "message": "Validation error",
    "errors": {
        "reason": ["The reason field is required."]
    }
}
```

**Validation Error - Reason Too Short (422):**

```json
{
    "success": false,
    "message": "Validation error",
    "errors": {
        "reason": ["The reason must be at least 10 characters."]
    }
}
```

**Only Pending Requests Can Be Cancelled (400):**

```json
{
    "success": false,
    "message": "Hanya permintaan dengan status pending yang dapat dibatalkan. Status saat ini: approved"
}
```

**Request Not Found (404):**

```json
{
    "success": false,
    "message": "Permintaan tidak ditemukan"
}
```

---

## ❌ **Error Handling**

### **Validation Error (422):**

```json
{
    "success": false,
    "message": "Validation error",
    "errors": {
        "barang_id": ["The selected barang id is invalid."],
        "jumlah": ["The jumlah must be at least 1."]
    }
}
```

### **Not Found Error (404):**

```json
{
    "success": false,
    "message": "Barang tidak ditemukan atau tidak dapat dipinjam"
}
```

### **Business Logic Error (400):**

```json
{
    "success": false,
    "message": "Stok tidak mencukupi"
}
```

### **Server Error (500):**

```json
{
    "success": false,
    "message": "Terjadi kesalahan pada server"
}
```

---

## 📊 **Response Format**

Semua response menggunakan format JSON dengan struktur standar:

### **Success Response:**

```json
{
    "success": true,
    "message": "Optional success message",
    "data": {
        /* response data */
    }
}
```

### **Error Response:**

```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        /* validation errors if applicable */
    }
}
```

---

## 🚀 **Example Usage**

### **JavaScript/Fetch Example:**

```javascript
// Get all items
const getItems = async (search = "", categoryId = null) => {
    const params = new URLSearchParams();
    if (search) params.append("search", search);
    if (categoryId) params.append("kategori_id", categoryId);

    const response = await fetch(`/api/v1/barangs?${params}`);
    const data = await response.json();

    if (data.success) {
        return data.data;
    } else {
        throw new Error(data.message);
    }
};

// Create loan request
const createLoanRequest = async (requestData) => {
    const response = await fetch("/api/v1/loan-requests", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(requestData),
    });

    const data = await response.json();

    if (data.success) {
        return data.data;
    } else {
        throw new Error(data.message);
    }
};
```

### **cURL Examples:**

```bash
# Get items with search
curl -X GET "http://localhost/api/v1/barangs?search=laptop" \
     -H "Accept: application/json"

# Create loan request
curl -X POST "http://localhost/api/v1/loan-requests" \
     -H "Content-Type: application/json" \
     -H "Accept: application/json" \
     -d '{
       "user_identifier": "john.doe@example.com",
       "barang_id": 1,
       "nama_peminjam": "John Doe",
       "kontak_peminjam": "081234567890",
       "jumlah": 2,
       "tanggal_pinjam": "2024-12-01",
       "tanggal_kembali": "2024-12-05",
       "keterangan": "Untuk presentasi"
     }'

# Get user's loan requests
curl -X GET "http://localhost/api/v1/loan-requests?user_identifier=john.doe@example.com" \
     -H "Accept: application/json"
```

---

## 📝 **Notes**

1. **Pagination**: Endpoint yang mengembalikan list data menggunakan Laravel pagination dengan 12 items per halaman.
2. **Date Format**: Semua tanggal menggunakan format `YYYY-MM-DD`.
3. **Timestamps**: Menggunakan format ISO 8601 UTC.
4. **File Upload**: Endpoint untuk upload gambar belum tersedia di versi API ini.
5. **Rate Limiting**: Belum diimplementasikan, tetapi direkomendasikan untuk production.

---

## 🔄 **Changelog**

### Version 1.0.0 (Current)

-   Initial API release
-   Basic CRUD operations for items and loan requests
-   Pagination support
-   Error handling implementation

---

**🛠️ Development Team**: Invenbar Development Team  
**📅 Last Updated**: October 2024  
**📧 Contact**: admin@invenbar.com
