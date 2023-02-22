@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $message)
            - {{ $message }} <br>
        @endforeach
    </div>
@endif
<x-admin-layout title="{{ __('Create Permission') }}" headButton="{{ __('Permissions') }}" :routeHeadButton="route('admin.permissions.index')">

    <form action="{{ route('admin.permissions.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('admin.permissions._form', [
            'button' => "Create"    
        ])
    </form>

</x-admin-layout>