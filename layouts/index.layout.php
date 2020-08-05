<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title');</title>
</head>

<body>


    <section>
        @foreach ($params as $param)

        <h1>Untenstehender Parameter:</h1>
        <p>{{ $param }}</p>

        @endforeach
    </section>

    @include('components/footer');
</body>

</html>