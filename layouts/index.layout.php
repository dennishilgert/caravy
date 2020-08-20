<!DOCTYPE html>
<html lang="en">

@include('components/header');

<body>

    <section>
        @foreach ( $params as $param )

        <h1>Untenstehender Parameter:</h1>
        <p>{{ $param }}</p>

        @endforeach
    </section>

    @include('components/footer');
</body>

</html>