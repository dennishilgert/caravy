<!DOCTYPE html>
<html lang="en">

@include('components/header');

<body>
    <form action="@yield('action');" method="POST">
        <h3>Benutzername</h3>
        <input type="text" name="username" placeholder="Benutzername">
        <h3>Passwort</h3>
        <input type="password" name="password" placeholder="Passwort">
        <br>
        <br>
        <input type="submit" value="Anmelden">
    </form>
    <br>
    @message('info');
</body>

</html>