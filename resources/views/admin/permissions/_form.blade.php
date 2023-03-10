<div class="form-group">
    <div class="mb-4">
        <label style="color:black" for="name" class="form-label ">{{ __('Name') }}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name='name' value="{{ old('name', $permission->name) }}" placeholder="{{ __('Permission Name') }}">
        @error('name')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ __($button) }}</button>