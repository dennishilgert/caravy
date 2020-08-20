<!DOCTYPE html>
<html lang="en">

@include('components/header');

<body>
    <h3>ID:</h3>
    <p>@yield('user->id');</p>
    <form action="@yield('action');" method="POST">
        @method('PUT');
        <input type="hidden" name="id" value="@yield('user->id');">
        <h3>Benutzer-Rechte</h3>

        @foreach ( $availablePermissions as $permission )
        <label for="{{ $permission->name }}">{{ $permission->name }}</label>
        <input type="checkbox" name="{{ $permission->name }}" id="{{ $permission->name }}" @if ( \Caravy\Support\Arr::contains($assignedPermissions, $permission->name) ) checked @endif>
        @endforeach

        <br>
        <br>
        <input type="submit" value="Änderungen speichern">
        <br>
        <div id="response"></div>
    </form>

    @include('components/footer');
</body>

</html>