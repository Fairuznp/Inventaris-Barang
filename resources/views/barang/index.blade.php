<x-main-layout titlePage="{{ __('Barang') }}">
    <div class="card-body">
        @include('barang.partials.toolbar')
        <x-notif-alert class="mt-2" />
    </div>
    @include('barang.partials.list-barang')
    <div class="card-body">
        {{ $barangs->links() }}
    </div>
</x-main-layout>