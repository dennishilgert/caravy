<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>

<body>
    <section>
        @if ($title === 'Hallo Welt!')

        <h1>Seitentitel:</h1>
        <p>{{ $title }}</p>

        @endif
    </section>
    <section>
        @foreach ($params as $param)

        <h1>Untenstehender Parameter:</h1>
        <p>{{ $param }}</p>

        @endforeach
    </section>
</body>

</html>