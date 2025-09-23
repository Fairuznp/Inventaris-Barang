<x-table-list>
    <x-slot name="header">
        <tr>
            <th style="width: 8%">#</th>
            <th style="width: 70%">Nama Lokasi</th>
            <th style="width: 22%">Aksi</th>
        </tr>
    </x-slot>

    @forelse ($lokasis as $index => $lokasi)
        <tr>
            <td>{{ ($lokasis->currentPage() - 1) * $lokasis->perPage() + $index + 1 }}</td>
            <td>{{ $lokasi->nama_lokasi }}</td>
            @can('manage lokasi')
                <td>
                    <x-tombol-aksi href="{{ route('lokasi.show', $lokasi->id) }}" type="show" />
                    <x-tombol-aksi href="{{ route('lokasi.edit', $lokasi->id) }}" type="edit" />
                    <x-tombol-aksi type="delete" 
                        data-name="{{ $lokasi->nama_lokasi }}" 
                        data-url="{{ route('lokasi.destroy', $lokasi->id) }}" />
                </td>
            @else
                <td>
                    <x-tombol-aksi href="{{ route('lokasi.show', $lokasi->id) }}" type="show" />
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