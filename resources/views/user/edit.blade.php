<x-main-layout>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit User</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            @include('user.partials._form', ['update' => true])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>