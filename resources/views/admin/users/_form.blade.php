<div class="form-group">
    <div class="mb-4">
        <label style="color:black" for="name" class="form-label ">{{ __('Name') }}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name='name' value="{{ old('name', $user->name) }}" placeholder="{{ __('User Name') }}">
        @error('name')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
</div>
<div class="form-group">
    <div class="mb-4">
        <label style="color:black" for="email" class="form-label ">{{ __('Email') }}</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name='email' value="{{ old('email', $user->email) }}" placeholder="{{ __('Email') }}">
        @error('email')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mb-4">
    <label style="color:black" for="image_path" class="form-label ">Image</label><br>
    @if($user->image_path)
    <img src="{{ asset('storage/' . $user->image_path) }}" width="200" alt="">
    @endif
    <input type="file" class="form-control @error('image_path') is-invalid @enderror" id="image_path" name='image_path' >
    @error('image_path')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>

<div class="row">
    <div class="form-group col">
        <h4>{{ __('Roles') }} :</h4>
        <div class="mb-4">
            @foreach($roles as $role)
            @if(in_array($role->id, $userRoles))
            <input type="checkbox" name="roles[]" value="{{$role->id}}" checked> {{$role->name}} <br />
            @else
            <input type="checkbox" name="roles[]" value="{{$role->id}}"> {{$role->name}} <br />
            @endif
            @endforeach
        </div>
    </div>
    <div class="form-group col">
        <h4>{{ __('Permissions') }} :</h4>
        <div class="mb-4">
            @foreach($permissions as $permission)
            @if(in_array($permission->id, $userPermissions))
            <input type="checkbox" name="permissions[]" value="{{$permission->id}}" checked> {{$permission->name}} <br />
            @else
            <input type="checkbox" name="permissions[]" value="{{$permission->id}}"> {{$permission->name}} <br />
            @endif
            @endforeach
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">{{__($button)}}</button>