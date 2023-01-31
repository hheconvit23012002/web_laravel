<form method="post" action="{{ route('process_login') }}">
    @csrf
    email
    <input type="email" name="email">
    <br>
    password
    <input type="password" name="password">
    <br>
    <button>login</button>
    <a href="{{ route('register') }}">Register</a>
</form>
