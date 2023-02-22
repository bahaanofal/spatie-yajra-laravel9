@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $message)
            - {{ $message }}
        @endforeach
    </div>
@endif
<x-admin-layout title="{{ __('Edit User') }}" editedObject="{{ $user->id }}" headButton="{{ __('Users') }}" :routeHeadButton="route('admin.users.index')">

    <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('admin.users._form', [
            'button' => "Update"    
        ])
    </form>

</x-admin-layout>