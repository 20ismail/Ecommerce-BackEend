<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Login</button>
    <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>

</form>
