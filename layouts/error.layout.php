<!DOCTYPE html>
<html lang="en">

@include('components/header');

<body>
    <h3>Error @yield('code');</h3>
    <P>@yield('message');</P>

    @include('components/footer');
</body>

</html>