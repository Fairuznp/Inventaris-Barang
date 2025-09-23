<x-table-list>
    <x-slot name="header">
        <tr>
            <th style="width: 8%">#</th>
            <th style="width: 30%">Nama Kategori</th>
            <th style="width: 22%">Aksi</th>
        </tr>
    </x-slot>

    @forelse ($kategoris as $index => $kategori)
        <tr>
            <td>{{ ($kategoris->currentPage() - 1) * $kategoris->perPage() + $index + 1 }}</td>
            <td>{{ $kategori->nama_kategori }}</td>
            <td>
                @can('manage kategori')
                    <x-tombol-aksi href="{{ route('kategori.edit', $kategori->id) }}" type="edit" />
                    <x-tombol-aksi type="delete" 
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