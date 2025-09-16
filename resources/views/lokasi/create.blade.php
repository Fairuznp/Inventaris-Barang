<x-main-layout title-page="Tambah Lokasi">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col">
                <form class="card col-lg-6" action="{{ route('lokasi.store') }}" method="POST">
                    <div class="card-body">
                        @include('lokasi.partials._form')
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-main-layout>