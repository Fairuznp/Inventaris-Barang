<x-main-layout title-page="Edit Lokasi">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col">
                <form class="card col-lg-6" action="{{ route('lokasi.update', $lokasi->id) }}" method="POST">
                    <div class="card-body">
                        @method('PUT')
                        @include('lokasi.partials._form', ['update' => true])
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-main-layout>