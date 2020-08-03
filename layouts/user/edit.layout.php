<!DOCTYPE html>
<html lang="en">

@include('components/header');

<body>
    <form action="@yield('action');" method="POST">
        @method('PUT');
        <h3>ID:</h3>
        <p>@yield('id');</p>
        <h3>Benutzername</h3>
        <input type="text" name="username" id="username" value="@yield('username');">
        <h3>Vorname</h3>
        <input type="text" name="firstName" id="firstName" value="@yield('firstName');">
        <h3>Nachname</h3>
        <input type="text" name="lastName" id="lastName" value="@yield('lastName');">
        <h3>Email-Adresse</h3>
        <input type="text" name="email" id="email" value="@yield('email');">
        <br>
        <br>
        <input type="submit" value="Änderungen speichern">
    </form>
</body>

</html>