<!DOCTYPE html>
<html>
<head>
    <title>Login Confirmation OTP</title>
</head>
<body>
<h1>رمز التحقق للدخول للوحة التحكم</h1>
<p>
    قام موظف بمحاولة الدخول للوحة تحكم كيان
</p>
<table class="table">
    <thead>
    <tr>
        <th scope="col">الاسم</th>
        <th scope="col">البريد الالكتروني</th>
        <th scope="col">الموبايل</th>
        <th scope="col">وقت الدخول</th>
        <th scope="col">كود التحقق</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row">{{ $user->name }}</th>
        <td>{{ $user->email }}</td>
        <td>{{ $user->phone }}</td>
        <td>{{ \Carbon\Carbon::now()->format('Y/m/d H:i') }}</td>
        <td>{{ $user->otp }}</td>
    </tr>
    </tbody>
</table>
</body>
</html>
