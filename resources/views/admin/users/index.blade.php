<x-admin-layout title="{{ __('Users') }}" headButton="{{ __('Create User') }}" :routeHeadButton="route('admin.users.create')">
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Manage Users') }}</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
</x-admin-layout>