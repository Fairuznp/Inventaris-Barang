<x-main-layout title-page="{{ 'Tambah Kategori' }}">
    <div class="row">
        <div class="col-lg-6">
            <form class="card col-lg-6" action="{{ route('kategori.store') }}" method="POST">
                <div class="card-body">
                    @csrf
                    @include('kategori.partials._form')
                </div>
            </form>
        </div>
    </div>
</x-main-layout>