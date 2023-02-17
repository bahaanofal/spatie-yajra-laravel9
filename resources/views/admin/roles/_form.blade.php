<div class="form-group">
    <div class="mb-4">
        <label style="color:black" for="name" class="form-label ">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name='name' value="{{ old('name', $role->name) }}" placeholder="Role Name">
        @error('name')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
</div>
<div class="form-group col">
    <h4>Permissions:</h4>
    <div class="mb-4">
        @foreach($permissions as $permission)
        @if(in_array($permission->id, $rolePermissions))
        <input type="checkbox" name="permissions[]" value="{{$permission->name}}" checked> {{$permission->name}} <br />
        @else
        <input type="checkbox" name="permissions[]" value="{{$permission->name}}"> {{$permission->name}} <br />
        @endif
        @endforeach
    </div>
</div>

<button type="submit" class="btn btn-primary">{{$button}}</button>