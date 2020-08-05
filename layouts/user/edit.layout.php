<!DOCTYPE html>
<html lang="en">

@include('components/header');

<body>
    <h3>ID:</h3>
    <p>@yield('user->id');</p>
    <form action="@yield('action');" method="POST">
        @method('PUT');
        <input type="hidden" name="id" value="@yield('user->id');">
        <input type="hidden" name="oldUsername" value="@yield('user->username');">
        <h3>Benutzername</h3>
        <input type="text" name="username" value="@yield('user->username');">
        <h3>Vorname</h3>
        <input type="text" name="firstName" value="@yield('user->first_name');">
        <h3>Nachname</h3>
        <input type="text" name="lastName" value="@yield('user->last_name');">
        <h3>Email-Adresse</h3>
        <input type="text" name="email" value="@yield('user->email');">
        <br>
        <br>
        <input type="submit" value="Änderungen speichern">
    </form>

    @include('components/footer');
</body>

</html>