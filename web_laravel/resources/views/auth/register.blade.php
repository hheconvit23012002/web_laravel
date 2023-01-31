<form action="{{ route('process_register') }}" method="post">
    @csrf
    Email
    <input type="email" name="email">
    <br>
    Name
    <input type="text" name="name">
    <br>
    Password
    <input type="password" name="password">
    <br>
    <button>Register</button>
</form>
