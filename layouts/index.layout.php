<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>

<body>
    <section>
        @if (1 > 0)

        <h1>Seitentitel: {{ $title }}</h1>

        @endif
    </section>
    <section>
        @foreach ($params as $param)

        <h1>{{ $param }}</h1>

        @endforeach
    </section>
</body>

</html>