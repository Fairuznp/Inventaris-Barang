<x-main-layout title-page="{{ 'Tambah User' }}">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col">
                <form class="card col-lg-6" action="{{ route('user.store') }}" method="POST">
                    <div class="card-body">
                        @csrf
                        @include('user.partials._form')
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-main-layout>