<!DOCTYPE html>
<html lang="en">

@include('components/header');

<body>
    <form action="@yield('action');" method="POST">
        <h3>Benutzername</h3>
        <input type="text" name="username" placeholder="Benutzername">
        <h3>Vorname</h3>
        <input type="text" name="firstName" placeholder="Vorname">
        <h3>Nachname</h3>
        <input type="text" name="lastName" placeholder="Nachname">
        <h3>Email-Adresse</h3>
        <input type="text" name="email" placeholder="Email-Adresse">
        <h3>Passwort</h3>
        <input type="password" name="password" placeholder="Passwort">
        <h3>Passwort Wiederholen</h3>
        <input type="password" name="passwordRepeat" placeholder="Passwort Wiederholen">
        <br>
        <br>
        <input type="submit" value="Benutzer erstellen">
        <br>
        @message('info');
    </form>
</body>

</html>