@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $message)
            - {{ $message }} <br>
        @endforeach
    </div>
@endif
<x-admin-layout title="{{ __('Create User') }}" headButton="{{ __('Users') }}" :routeHeadButton="route('admin.users.index')">

    <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('admin.users._form', [
            'button' => "Create"
        ])
    </form>

</x-admin-layout>