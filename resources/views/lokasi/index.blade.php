<x-main-layout title-page="Lokasi">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @include('lokasi.partials.toolbar')
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @include('lokasi.partials.list-lokasi')
    </div>
</x-main-layout>