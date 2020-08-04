<!DOCTYPE html>
<html lang="en">

@include('components/header');

<body>
    <form action="@yield('action');" method="POST">
        @method('DELETE');
        <input type="hidden" name="id" value="@yield('id');">
        <h3>ID</h3>
        <p>@yield('id');</p>
        <h3>Benutzername</h3>
        <p>@yield('username');</p>
        <br>
        <p>Sind Sie sicher, dass Sie den Benutzer löschen möchten?</p>
        <br>
        <input type="submit" value="Benutzer löschen">
    </form>
</body>

</html>