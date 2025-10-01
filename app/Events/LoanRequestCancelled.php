<?php

namespace App\Events;

use App\Models\LoanRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoanRequestCancelled implements ShouldBroadcast
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
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('admin-notifications'),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->loanRequest->id,
            'nama_peminjam' => $this->loanRequest->nama_peminjam,
            'barang_nama' => $this->loanRequest->barang->nama_barang,
            'barang_kode' => $this->loanRequest->barang->kode_barang,
            'jumlah' => $this->loanRequest->jumlah,
            'status' => $this->loanRequest->status,
            'admin_notes' => $this->loanRequest->admin_notes,
            'created_at' => $this->loanRequest->created_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Get the broadcast event name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'loan-request.cancelled';
    }
}
