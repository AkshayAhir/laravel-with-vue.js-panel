<!-- selected_users.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Users PDF</title>
</head>
<body>
    <h1>Users List</h1>

    @foreach($users as $user)
        <div @if (!$loop->last) style="page-break-after: always;" @endif>
            <h3>Id: {{ $user->id }}</h3>
            <h3>First Name: {{ $user->firstname }}</h3>
            <h3>Last Name: {{ $user->lastname }}</h3>
            <h3>Email: {{ $user->email }}</h3>
            <h3>Address: {{ $user->address }}</h3>
            <h3>Phone: {{ $user->phone }}</h3><br>
            @php
            $qrCode = QrCode::size(110)->generate("ID: $user->id , First Name: $user->firstname , Last Name: $user->lastname , Email: $user->email, Address: $user->address , Phone: $user->phone");
        @endphp
        <h3>QR Code:</h3><img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code"><br><br>
        <h3>Bar Code:</h3><img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($user->id , 'C39') }}" alt="barCode">
        </div>
    @endforeach
</body>
</html>
