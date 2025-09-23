<div class="modal fade" id="modalDelete" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="" id="deleteForm">
            @csrf
            @method('delete')

            <div class="modal-header">
                <h1 class="modal-title fs-5">
                    <i class="bi bi-exclamation-diamond text-danger"></i>
                    Konfirmasi Hapus
                </h1>
            </div>

            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
            </div>

            <div class="modal-footer">
                <x-secondary-button data-bs-dismiss="modal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Yes, Hapus!') }}
                </x-danger-button>
            </div>
        </form>
    </div>
</div>