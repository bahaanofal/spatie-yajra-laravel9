@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $message)
            - {{ $message }}
        @endforeach
    </div>
@endif
<x-admin-layout title="Edit Permission" headButton="Permissions" :routeHeadButton="route('admin.permissions.index')">

    <form action="{{ route('admin.permissions.update', $permission->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('admin.permissions._form', [
            'button' => 'Update'    
        ])
    </form>

</x-admin-layout>