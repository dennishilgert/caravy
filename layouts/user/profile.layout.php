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
    @message('info');
    <br>
    <h2>ID:</h2>
    @yield('user->id');
    <br>
    <h2>Username:</h2>
    @yield('user->username');
    <br>
    <h2>First name:</h2>
    @yield('user->first_name');
    <br>
    <h2>Last name:</h2>
    @yield('user->last_name');
    <br>
    <h2>Email:</h2>
    @yield('user->email');
</body>

</html>