<x-layout>
    <link rel="stylesheet" href="{{asset('css/login-page.css')}}">
    <body class="theme1">

    <div class="login-box">
        <h1>Admin Signup</h1>

        @if($errors->any())
            <div style="color:red;margin-bottom:10px;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.register') }}">
            @csrf
            <div class="input">
                <input type="text" name="name" placeholder="Full Name" required>
            </div>
            <div class="input">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            </div>

            <button class="btn">Sign Up →</button>
        </form>

        <p style="margin-top:10px;">Already have an account? <a href="{{ route('admin.login') }}">Login</a></p>
    </div>
    </body>
</x-layout>
