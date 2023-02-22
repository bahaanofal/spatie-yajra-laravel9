<x-admin-layout title="{{ __('Roles') }}" headButton="{{ __('Create Role') }}" :routeHeadButton="route('admin.roles.create')">
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Manage Roles') }}</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
</x-admin-layout>