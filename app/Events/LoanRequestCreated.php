<?php

namespace App\Events;

use App\Models\LoanRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoanRequestCreated implements ShouldBroadcast
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
            new Channel('admin-notifications'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'loan-request.created';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->loanRequest->id,
            'nama_peminjam' => $this->loanRequest->nama_peminjam,
            'barang_nama' => $this->loanRequest->barang->nama_barang,
            'jumlah' => $this->loanRequest->jumlah,
            'created_at' => $this->loanRequest->created_at->diffForHumans(),
            'message' => "Permintaan peminjaman baru dari {$this->loanRequest->nama_peminjam}"
        ];
    }
}
