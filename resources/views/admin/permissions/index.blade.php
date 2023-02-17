<x-admin-layout title="Permissions" headButton="Create Permission" :routeHeadButton="route('admin.permissions.create')">
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Permissions</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
</x-admin-layout>