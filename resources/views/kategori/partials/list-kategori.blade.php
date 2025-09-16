<x-table-list>
    <x-slot name="header">
        <tr>
            <th style="width: 8%">#</th>
            <th style="width: 30%">Nama Kategori</th>
            <th style="width: 40%">Deskripsi</th>
            <th style="width: 22%">Aksi</th>
        </tr>
    </x-slot>

    @forelse ($kategoris as $index => $kategori)
        <tr>
            <td>{{ ($kategoris->currentPage() - 1) * $kategoris->perPage() + $index + 1 }}</td>
            <td>{{ $kategori->nama_kategori }}</td>
            <td>{{ $kategori->deskripsi ?? '-' }}</td>
            <td>
                @can('manage kategori')
                    <x-tombol-aksi href="{{ route('kategori.edit', $kategori->id) }}" type="edit" />
                    <x-tombol-aksi href="#" type="delete" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalDelete" 
                        data-name="{{ $kategori->nama_kategori }}" 
                        data-url="{{ route('kategori.destroy', $kategori->id) }}" />
                @endcan
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle"></i>
                    Data kategori belum tersedia.
                </div>
            </td>
        </tr>
    @endforelse
</x-table-list>

@can('manage kategori')
<x-modal-delete />

@push('scripts')
<script>
    // Script untuk modal delete kategori
    const modalDelete = document.getElementById('modalDelete');
    modalDelete.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const name = button.getAttribute('data-name');
        const url = button.getAttribute('data-url');
        
        const modalBody = modalDelete.querySelector('.modal-body');
        const deleteForm = modalDelete.querySelector('#deleteForm');
        
        modalBody.innerHTML = `Apakah Anda yakin ingin menghapus kategori <strong>"${name}"</strong>?`;
        deleteForm.action = url;
    });
</script>
@endpush
@endcan