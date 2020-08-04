<!DOCTYPE html>
<html lang="en">

@include('components/header');

<body>
    <h3>ID:</h3>
    <p>@yield('id');</p>
    <form action="@yield('action');" method="POST">
        @method('PUT');
        <input type="hidden" name="id" value="@yield('id');">
        <h3>Benutzername</h3>
        <input type="text" name="username" value="@yield('username');">
        <h3>Vorname</h3>
        <input type="text" name="firstName" value="@yield('firstName');">
        <h3>Nachname</h3>
        <input type="text" name="lastName" value="@yield('lastName');">
        <h3>Email-Adresse</h3>
        <input type="text" name="email" value="@yield('email');">
        <br>
        <br>
        <input type="submit" value="Änderungen speichern">
    </form>
</body>

</html>