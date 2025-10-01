<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_identifier',
        'barang_id',
        'nama_peminjam',
        'kontak_peminjam',
        'instansi_peminjam',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'keterangan',
        'status',
        'admin_notes',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'approved_at' => 'datetime'
    ];

    protected $dispatchesEvents = [
        'created' => \App\Events\LoanRequestCreated::class,
        'updated' => \App\Events\LoanRequestStatusChanged::class,
    ];

    // Relationships
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function peminjaman()
    {
        return $this->hasOne(Peminjaman::class, 'request_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Helper methods
    public function canBeApproved()
    {
        return $this->status === 'pending' && 
               $this->barang->dapat_dipinjam && 
               $this->barang->stok_baik_tersedia >= $this->jumlah;
    }

    public function canBeCancelled()
    {
        return $this->status === 'pending';
    }

    public function approve($adminId, $notes = null)
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $adminId,
            'approved_at' => now(),
            'admin_notes' => $notes
        ]);

        return $this;
    }

    public function reject($adminId, $notes)
    {
        $this->update([
            'status' => 'rejected',
            'approved_by' => $adminId,
            'admin_notes' => $notes
        ]);

        return $this;
    }

    public function cancel($reason)
    {
        if (empty($reason) || strlen(trim($reason)) < 10) {
            throw new \InvalidArgumentException('Alasan pembatalan harus diisi minimal 10 karakter');
        }
        
        $this->update([
            'status' => 'cancelled',
            'admin_notes' => "Dibatalkan oleh user: " . $reason
        ]);

        return $this;
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-warning text-dark',
            'approved' => 'bg-success text-white',
            'rejected' => 'bg-danger text-white',
            'cancelled' => 'bg-secondary text-white',
            default => 'bg-secondary text-white'
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status)
        };
    }

    public function getCancellationReasonAttribute()
    {
        if ($this->status === 'cancelled' && $this->admin_notes) {
            return str_replace('Dibatalkan oleh user: ', '', $this->admin_notes);
        }
        return null;
    }

    public function hasCancellationReason()
    {
        return $this->status === 'cancelled' && !empty($this->cancellation_reason);
    }
}
