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
    <thead class="thead-dark">
    <tr>
        <th scope="col">العنوان</th>
        <th scope="col">البيانات</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row">الاسم</th>
        <td>{{ $user->name }}</td>
    </tr>
    <tr>
        <th scope="row">البريد الالكتروني</th>
        <td>{{ $user->email }}</td>
    </tr>
    <tr>
        <th scope="row">رقم الجوال</th>
        <td>{{ $user->phone }}</td>
    </tr>

    <tr>
        <th scope="row">وقت محاولة التدخول</th>
        <td>{{ \Carbon\Carbon::now()->format('Y/m/d H:i') }}</td>
    </tr>

    <tr>
        <th scope="row">كود التحقق</th>
        <td>{{ $user->otp }}</td>
    </tr>
    </tbody>
</table>

<table class="table">
    <thead class="thead-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row">1</th>
        <td>Mark</td>
    </tr>
    </tbody>
</table>

</body>
</html>
