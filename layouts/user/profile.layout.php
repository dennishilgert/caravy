<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil von @yield('username');</title>
</head>

<body>
    <h2>ID:</h2>
    @yield('id');
    <br>
    <h2>Username:</h2>
    @yield('username');
    <br>
    <h2>First name:</h2>
    @yield('firstName');
    <br>
    <h2>Last name:</h2>
    @yield('lastName');
    <br>
    <h2>Email:</h2>
    @yield('email');
</body>

</html>