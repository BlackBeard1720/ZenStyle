@props(['name'])

@error($name)
    <p class="text-theme-xs text-error-500 mt-1.5">{{ $message }}</p>
@enderror
