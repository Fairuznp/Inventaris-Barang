<x-table-list>
    <x-slot name="header">
        <tr>
            <th style="width: 8%">#</th>
            <th style="width: 70%">Nama Lokasi</th>
            @can('manage lokasi')
                <th style="width: 22%">Aksi</th>
            @endcan
        </tr>
    </x-slot>

    @forelse ($lokasis as $index => $lokasi)
        <tr>
            <td>{{ ($lokasis->currentPage() - 1) * $lokasis->perPage() + $index + 1 }}</td>
            <td>{{ $lokasi->nama_lokasi }}</td>
            @can('manage lokasi')
                <td>
                    <x-tombol-aksi href="{{ route('lokasi.edit', $lokasi->id) }}" type="edit" />
                    <x-tombol-aksi href="#" type="delete" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalDelete" 
                        data-name="{{ $lokasi->nama_lokasi }}" 
                        data-url="{{ route('lokasi.destroy', $lokasi->id) }}" />
                </td>
            @endcan
        </tr>
    @empty
        <tr>
            <td colspan="{{ auth()->user()->can('manage lokasi') ? '3' : '2' }}" class="text-center">
                <div class="alert alert-danger mb-0">
                    <i class="fas fa-exclamation-triangle"></i>
                    Data lokasi belum tersedia.
                </div>
            </td>
        </tr>
    @endforelse

    <x-slot name="footer">
        {{ $lokasis->links() }}
    </x-slot>
</x-table-list>

<x-modal-delete />

@push('scripts')
<script>
    // Script untuk modal delete lokasi
    const modalDelete = document.getElementById('modalDelete');
    modalDelete.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const name = button.getAttribute('data-name');
        const url = button.getAttribute('data-url');
        
        const modalBody = modalDelete.querySelector('.modal-body');
        const deleteForm = modalDelete.querySelector('#deleteForm');
        
        modalBody.innerHTML = `Apakah Anda yakin ingin menghapus lokasi <strong>"${name}"</strong>?`;
        deleteForm.action = url;
    });
</script>
@endpush