@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $message)
            - {{ $message }} <br>
        @endforeach
    </div>
@endif
<x-admin-layout title="{{ __('Create Role') }}" headButton="{{ __('Roles') }}" :routeHeadButton="route('admin.roles.index')">

    <form action="{{ route('admin.roles.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('admin.roles._form', [
            'button' => "Create"    
        ])
    </form>

</x-admin-layout>