<form method="POST" action="{{ route('register') }}">
    @csrf
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
    <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
