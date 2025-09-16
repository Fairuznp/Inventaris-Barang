<x-main-layout title-page="{{ 'Edit Kategori' }}">
    <div class="row">
        <div class="col-lg-6">
            <form class="card col-lg-6" action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                <div class="card-body">
                    @method('PUT')
                    @include('kategori.partials._form', ['update' => true])
                </div>
            </form>
        </div>
    </div>
</x-main-layout>