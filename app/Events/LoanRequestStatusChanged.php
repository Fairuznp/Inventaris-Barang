<?php

namespace App\Events;

use App\Models\LoanRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoanRequestStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $loanRequest;

    /**
     * Create a new event instance.
     */
    public function __construct(LoanRequest $loanRequest)
    {
        $this->loanRequest = $loanRequest;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('user-notifications.' . $this->loanRequest->user_identifier),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'loan-request.status-changed';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->loanRequest->id,
            'status' => $this->loanRequest->status,
            'admin_notes' => $this->loanRequest->admin_notes,
            'barang_nama' => $this->loanRequest->barang->nama_barang,
            'message' => $this->getStatusMessage()
        ];
    }

    private function getStatusMessage()
    {
        switch ($this->loanRequest->status) {
            case 'approved':
                return "Permintaan peminjaman {$this->loanRequest->barang->nama_barang} telah disetujui!";
            case 'rejected':
                return "Permintaan peminjaman {$this->loanRequest->barang->nama_barang} ditolak.";
            default:
                return "Status permintaan peminjaman berubah menjadi {$this->loanRequest->status}";
        }
    }
}
