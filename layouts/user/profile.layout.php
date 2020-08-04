<!-- 
    Used variables:

    $title
    $id
    $username
    $firstName
    $lastName
    $email
    
 -->

<!DOCTYPE html>
<html lang="en">

@include('components/header');

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