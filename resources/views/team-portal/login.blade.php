<x-layout>

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
    /* CRM login — self-contained, matches dashboard tokens.
       No dependency on login-page.css. */
    :root{
        --cb-bg:#0c0c0c;
        --cb-card:#181818;
        --cb-lime:#b6e44f;
        --cb-white:#f3f3f3;
        --cb-gray:#7d7d7d;
        --cb-gray-d:#5a5a5a;
        --cb-line:#262626;
    }

    .lg-wrap{
        font-family:'Poppins',sans-serif;
        min-height:100vh;
        background:
            radial-gradient(900px 380px at 50% -10%, rgba(182,228,79,0.06), transparent 70%),
            #000;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:20px;
    }

    .lg-card{
        width:100%;
        max-width:420px;
        background:var(--cb-card);
        border:1px solid var(--cb-line);
        border-radius:24px;
        padding:38px 34px;
        box-shadow:0 30px 80px rgba(0,0,0,.55);
    }

    .lg-logo{
       
        width:50%;
        display:flex;align-items:center;justify-content:center;
        margin:0 auto 20px;
    }
    .lg-logo svg{width:28px;height:28px}

    .lg-card h1{
        font-size:26px;
        font-weight:800;
        color:var(--cb-white);
        text-align:center;
        letter-spacing:.3px;
    }
    .lg-card .lg-sub{
        font-size:13.5px;
        color:var(--cb-gray);
        text-align:center;
        margin-top:6px;
        margin-bottom:26px;
    }

    /* flash / error */
    .lg-flash{
        background:rgba(46,192,106,.14);color:#43d07f;
        border:1px solid rgba(46,192,106,.3);
        padding:12px 14px;border-radius:12px;margin-bottom:16px;
        font-size:13.5px;font-weight:500;display:flex;align-items:center;gap:9px;
    }
    .lg-err{
        background:rgba(239,83,80,.12);color:#f2726f;
        border:1px solid rgba(239,83,80,.3);
        padding:12px 14px;border-radius:12px;margin-bottom:16px;
        font-size:13.5px;font-weight:500;display:flex;align-items:center;gap:9px;
    }

    /* inputs */
    .lg-field{position:relative;margin-bottom:16px}
    .lg-field i{
        position:absolute;left:15px;top:50%;transform:translateY(-50%);
        color:var(--cb-gray-d);font-size:14px;pointer-events:none;
    }
    .lg-field input{
        width:100%;
        background:#141414;
        border:1px solid var(--cb-line);
        border-radius:12px;
        padding:14px 14px 14px 42px;
        color:var(--cb-white);
        font-family:inherit;
        font-size:14px;
        outline:none;
        transition:.16s;
    }
    .lg-field input::placeholder{color:var(--cb-gray-d)}
    .lg-field input:focus{
        border-color:var(--cb-lime);
        box-shadow:0 0 0 3px rgba(182,228,79,.14);
    }

    .lg-btn{
        width:100%;
        background:var(--cb-lime);
        color:#15240a;
        border:none;
        border-radius:12px;
        padding:14px;
        font-family:inherit;
        font-size:15px;
        font-weight:700;
        cursor:pointer;
        margin-top:6px;
        display:flex;align-items:center;justify-content:center;gap:8px;
        transition:.16s;
    }
    .lg-btn:hover{filter:brightness(1.06)}
    .lg-btn:active{transform:scale(.99)}

    .lg-foot{
        text-align:center;
        font-size:12.5px;
        color:var(--cb-gray);
        margin-top:20px;
    }
</style>

<div class="lg-wrap">

    <div class="lg-card">

        {{-- logo (same mark as your dashboard chrome) --}}
        <div class="lg-logo">
                     <img src="{{asset('images/harry_lawns-logo.png')}}" style="width:100%;">

        </div>

        <h1>Welcome Back</h1>
        <p class="lg-sub">Sign in to continue to your team portal</p>

        @if(session('success'))
            <div class="lg-flash">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="lg-err">
                <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('team.login.submit') }}">
            @csrf

            <div class="lg-field">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Email Address"
                       value="{{ old('email') }}" required autofocus>
            </div>

            <div class="lg-field">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="lg-btn">
                Login <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <div class="lg-foot">
            Harry's Lawn Care — Team Portal
        </div>

    </div>

</div>

</x-layout>