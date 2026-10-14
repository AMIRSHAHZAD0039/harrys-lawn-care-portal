
<x-layout>
    <link rel="stylesheet" href="{{asset('css/login-page.css')}}">

<body class="theme1">

<div class="login-box">

    <h1>Welcome Back</h1>
    <p>Sign in to continue your journey</p>

    @if(session('success'))
        <div style="color:green;margin-bottom:10px;">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div style="color:red;margin-bottom:10px;">{{ $errors->first() }}</div>
    @endif


    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="input">
            <input type="email" name="email" placeholder="Email Address" required>
        </div>

        <div class="input">
            <input type="password" name="password" placeholder="Password" required>
        </div>



        <button class="btn">Login →</button>
    </form>


{{--    <p style="margin-top:10px;">Don't have an account? <a href="{{ route('admin.register') }}">Sign Up</a></p>--}}

</div>

<!-- LAMP -->

<div class="lamp" onclick="changeTheme(event)">

    <div class="wire"></div>

    <div class="lamp-head">
        <div class="lamp-glow"></div>
        <div class="bulb"></div>
    </div>

    <div class="light"></div>

</div>

<script>

    let theme = 1;

    function changeTheme(e){

        /* ripple effect */

        let ripple = document.createElement("div");
        ripple.className="ripple";

        ripple.innerHTML="<span></span><span></span><span></span>";

        ripple.style.left = e.clientX+"px";
        ripple.style.top = e.clientY+"px";

        document.body.appendChild(ripple);

        /* change theme after animation */

        setTimeout(()=>{

            theme++;

            if(theme>4){
                theme=1;
            }

            document.body.className="theme"+theme;

        },300);

        /* remove ripple */

        setTimeout(()=>{
            ripple.remove();
        },1200);

    }

</script>
</body>
</x-layout>

