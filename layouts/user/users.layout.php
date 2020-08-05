<!DOCTYPE html>
<html lang="en">

@include('components/header');

<body>
    <h2>Benutzer-Liste</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Benutzername</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>Email</th>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
            <td>{{ $user->email }}</td>
        </tr>
        @endforeach
    </table>

    @include('components/footer');
</body>

</html>