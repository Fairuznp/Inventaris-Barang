<x-main-layout titlePage="Detail Permintaan Peminjaman">
    <div class="container py-4">
        <h1 class="h4 mb-4">Detail Permintaan Peminjaman</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ $loanRequest->barang->nama_barang ?? '-' }}</h5>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item"><strong>Nama Peminjam:</strong> {{ $loanRequest->nama_peminjam }}</li>
                    <li class="list-group-item"><strong>Kontak:</strong> {{ $loanRequest->kontak_peminjam }}</li>
                    <li class="list-group-item"><strong>Instansi:</strong> {{ $loanRequest->instansi_peminjam ?? '-' }}</li>
                    <li class="list-group-item"><strong>Jumlah:</strong> {{ $loanRequest->jumlah }}</li>
                    <li class="list-group-item"><strong>Tanggal Pinjam:</strong> {{ $loanRequest->tanggal_pinjam->format('d/m/Y') }}</li>
                    <li class="list-group-item"><strong>Tanggal Kembali:</strong> {{ $loanRequest->tanggal_kembali->format('d/m/Y') }}</li>
                    <li class="list-group-item"><strong>Keterangan:</strong> {{ $loanRequest->keterangan ?? '-' }}</li>
                    <li class="list-group-item"><strong>Status:</strong> <span class="badge {{ $loanRequest->status_badge_class }}">{{ $loanRequest->status_text }}</span></li>
                    
                    @if($loanRequest->hasCancellationReason())
                        <li class="list-group-item">
                            <strong>💬 Alasan Pembatalan:</strong> 
                            <div class="mt-2 p-3 bg-light rounded border-start border-warning border-4">
                                <i class="fas fa-user text-muted me-2"></i>
                                {{ $loanRequest->cancellation_reason }}
                            </div>
                        </li>
                    @elseif($loanRequest->admin_notes)
                        <li class="list-group-item">
                            <strong>📝 Catatan Admin:</strong> 
                            <div class="mt-2 p-3 bg-light rounded">
                                {{ $loanRequest->admin_notes }}
                            </div>
                        </li>
                    @endif
                </ul>
                <a href="{{ route('loan-requests.index') }}" class="btn btn-secondary">Kembali ke Daftar Permintaan</a>
            </div>
        </div>
    </div>
</x-main-layout>
