<x-table-list>
    <x-slot name="header">
        <tr>
            <th style="width: 8%">#</th>
            <th style="width: 25%">Nama</th>
            <th style="width: 30%">Email</th>
            <th style="width: 15%">Role</th>
            <th style="width: 22%">Aksi</th>
        </tr>
    </x-slot>

    @forelse ($users as $index => $user)
        <tr>
            <td>{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if ($user->getRoleNames()->isNotEmpty())
                    <span class="badge bg-primary">{{ $user->getRoleNames()->first() }}</span>
                @else
                    <span class="badge bg-secondary">Belum Ada Role</span>
                @endif
            </td>
            <td>
                <x-tombol-aksi href="{{ route('user.edit', $user->id) }}" type="edit" />
                <x-tombol-aksi href="#" type="delete" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalDelete" 
                    data-name="{{ $user->name }}" 
                    data-url="{{ route('user.destroy', $user->id) }}" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle"></i>
                    Data user belum tersedia.
                </div>
            </td>
        </tr>
    @endforelse

    <x-slot name="footer">
        {{ $users->links() }}
    </x-slot>
</x-table-list>

<x-modal-delete />

@push('scripts')
<script>
    // Script untuk modal delete user
    const modalDelete = document.getElementById('modalDelete');
    modalDelete.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const name = button.getAttribute('data-name');
        const url = button.getAttribute('data-url');
        
        const modalBody = modalDelete.querySelector('.modal-body');
        const deleteForm = modalDelete.querySelector('#deleteForm');
        
        modalBody.innerHTML = `Apakah Anda yakin ingin menghapus user <strong>"${name}"</strong>?`;
        deleteForm.action = url;
    });
</script>
@endpush