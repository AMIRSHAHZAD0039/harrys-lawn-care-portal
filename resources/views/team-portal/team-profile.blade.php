<x-layout>

<link rel="stylesheet" href="{{asset('team-portal_assets/leads_assigned.css')}}">
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

{{-- Profile-only additions. Base cb-*/ld-* tokens come from leads_assigned.css.
     If the shared classes are NOT in that file, tell me and I'll inline them. --}}
<style>

    .tp-idcard{
        background:var(--cb-card,#181818);
        border:1px solid var(--cb-line,#262626);
        border-radius:20px;padding:24px;
        display:flex;align-items:center;gap:18px;margin-bottom:20px;
    }
    .tp-avatar{
        width:64px;height:64px;border-radius:18px;flex:0 0 auto;
        background:rgba(182,228,79,.15);color:var(--cb-lime,#b6e44f);
        display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:800;
    }
    .tp-idcard h2{font-size:20px;font-weight:700;color:var(--cb-white,#f3f3f3)}
    .tp-idcard p{font-size:13px;color:var(--cb-gray,#7d7d7d);margin-top:3px}

    .tp-panel{background:#111;border:1px solid var(--cb-line,#262626);border-radius:20px;padding:24px}
    .tp-panel-head{display:flex;align-items:center;gap:12px;margin-bottom:20px}
    .tp-panel-ic{
        width:42px;height:42px;border-radius:12px;flex:0 0 auto;
        background:rgba(182,228,79,.15);color:var(--cb-lime,#b6e44f);
        display:flex;align-items:center;justify-content:center;font-size:16px;
    }
    .tp-panel-head h3{font-size:16px;font-weight:700;color:var(--cb-white,#f3f3f3)}
    .tp-panel-head span{font-size:12px;color:var(--cb-gray,#7d7d7d);display:block;margin-top:2px}

    .tp-divider{height:1px;background:var(--cb-line,#262626);margin:22px 0}
    .tp-section-label{font-size:12px;font-weight:600;letter-spacing:.5px;text-transform:uppercase;color:var(--cb-gray,#7d7d7d);margin-bottom:14px}
    .tp-hint{font-size:11.5px;color:var(--cb-gray-d,#5a5a5a);margin-top:6px}

    .tp-flash{
        background:rgba(46,192,106,.14);color:#43d07f;border:1px solid rgba(46,192,106,.3);
        padding:13px 15px;border-radius:12px;margin-bottom:18px;
        font-size:13.5px;font-weight:500;display:flex;align-items:center;gap:9px;
    }
    .tp-errbox{
        background:rgba(239,83,80,.12);color:#f2726f;border:1px solid rgba(239,83,80,.3);
        padding:13px 15px;border-radius:12px;margin-bottom:18px;font-size:13px;
    }
    .tp-errbox ul{margin:0;padding-left:18px}

    .tp-actions{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-top:22px;flex-wrap:wrap}

    .tp-logout{
        background:transparent;border:1px solid var(--cb-line,#262626);
        color:var(--cb-gray,#7d7d7d);cursor:pointer;font-family:inherit;
        font-size:13px;font-weight:600;padding:11px 16px;border-radius:12px;
        display:inline-flex;align-items:center;gap:8px;transition:.15s;
    }
    .tp-logout:hover{background:rgba(239,83,80,.14);border-color:transparent;color:#f2726f}

    a{
        text-decoration:none;
    }

    /* ===== TOP-BAR NAV + MOBILE TOGGLE (replaces the left sidebar) ===== */
    .cb-top{ position:relative; }   /* anchor for the mobile dropdown */

    .tb-burger{
        display:none;                /* desktop: hidden */
        width:42px;height:42px;border-radius:12px;
        background:#151515;border:1px solid var(--cb-line,#262626);
        color:#f3f3f3;cursor:pointer;font-size:16px;
        align-items:center;justify-content:center;flex:0 0 auto;
    }

    .cb-nav .cb-pill{ text-decoration:none; }
    .cb-nav form{ margin:0; }

    @media(max-width:760px){
        .tb-burger{ display:inline-flex; }

        /* nav collapses into a dropdown under the top bar.
           !important forces override of leads_assigned.css's ≤760px
           `.cb-nav{display:none}` rule (present in your mockup), which
           I cannot re-inspect here — makes the toggle deterministic. */
        .cb-nav{
            display:none !important;
            position:absolute;
            top:calc(100% + 8px);
            left:0;right:0;
            flex-direction:column;
            align-items:stretch;
            gap:6px;
            background:#121212;
            border:1px solid var(--cb-line,#262626);
            border-radius:16px;
            padding:10px;
            z-index:300;
            box-shadow:0 20px 50px rgba(0,0,0,.55);
        }
        .cb-nav.tb-open{ display:flex !important; }
        .cb-nav .cb-pill{ width:100%; justify-content:flex-start; }
        .cb-nav form{ width:100%; }
        .cb-nav form .cb-pill{ width:100%; }
        .cb-nav .cb-search-top{ display:none; }
    }
</style>

<div class="cb-app">

    <!-- TOP BAR -->
    <header class="cb-top">
      <div class="cb-logo">
           <img src="{{asset('images/harry_lawns-logo.png')}}" style="width:100%;">
        </div>
        
        {{-- mobile toggle --}}
        <button class="tb-burger" id="tbBurger" type="button" aria-label="Toggle menu" aria-expanded="false">
            <i class="fa-solid fa-bars"></i>
        </button>

        {{-- PRIMARY NAV (moved from sidebar into top bar; real route links) --}}
        <nav class="cb-nav" id="tbNav">
            <a href="{{ route('team.dashboard') }}" class="cb-pill {{ request()->routeIs('team.dashboard') ? 'is-active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a href="{{ route('team.jobs') }}" class="cb-pill {{ request()->routeIs('team.jobs') ? 'is-active' : '' }}">
                <i class="fa-solid fa-clipboard-list"></i> My Jobs
            </a>
            <a href="{{ route('team.history') }}" class="cb-pill {{ request()->routeIs('team.history') ? 'is-active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i> History
            </a>
            <a href="{{ route('team.profile') }}" class="cb-pill {{ request()->routeIs('team.profile') ? 'is-active' : '' }}">
                <i class="fa-solid fa-user"></i> Profile
            </a>

            {{-- Logout is POST — reuses the existing hidden #tpLogoutForm below (no duplicate form) --}}
            <button type="button" class="cb-pill" style="color:#f2726f"
                    onclick="document.getElementById('tpLogoutForm').submit();">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>

            <button class="cb-search-top" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
        </nav>

        <div class="cb-profile">
            <div class="cb-pname"><b>{{ session('team_name', $team->name) }}</b><span>Field Crew</span></div>
            <div class="cb-avatar">
                <svg viewBox="0 0 46 46"><circle cx="23" cy="18" r="8" fill="rgba(255,255,255,.35)"/><path d="M9 42c0-8 6.3-13 14-13s14 5 14 13" fill="rgba(255,255,255,.3)"/></svg>
            </div>
        </div>
    </header>

    <!-- HEADER -->
    <div class="cb-head">
        <div>
            <h1 class="cb-title">Profile</h1>
            <p class="ld-subtitle">Manage your account email and password</p>
        </div>
    </div>

    <!-- LAYOUT (sidebar removed — nav now lives in the top bar) -->
    <div class="cb-layout">

        <!-- MAIN -->
        <main class="ld-main">

            <div class="tp-grid">

                @if(session('success'))
                    <div class="tp-flash">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="tp-errbox">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- IDENTITY CARD --}}
                <div class="tp-idcard">
                    <div class="tp-avatar">
                        {{ strtoupper(substr($team->name, 0, 2)) }}
                    </div>
                    <div>
                        <h2>{{ $team->name }}</h2>
                        <p><i class="fa-solid fa-envelope"></i> {{ $team->email ?? 'No email set' }}</p>
                    </div>
                </div>

                {{-- EDIT PANEL --}}
                <div class="tp-panel">

                    <div class="tp-panel-head">
                        <div class="tp-panel-ic"><i class="fa-solid fa-user-gear"></i></div>
                        <div>
                            <h3>Account Settings</h3>
                            <span>Update your login email or set a new password</span>
                        </div>
                    </div>

                    <form action="{{ route('team.profile.update') }}" method="POST">
                        @csrf

                        <div class="tp-section-label">Email Address</div>

                        <div class="ld-field">
                            <label>Login Email *</label>
                            <input type="email" name="email"
                                   value="{{ old('email', $team->email) }}"
                                   placeholder="name@email.com" required>
                        </div>

                        <div class="tp-divider"></div>

                        <div class="tp-section-label">Change Password</div>

                        <div class="ld-field">
                            <label>New Password</label>
                            <input type="password" name="password"
                                   placeholder="Leave blank to keep current password">
                            <div class="tp-hint">Minimum 8 characters. Leave empty to change email only.</div>
                        </div>

                        <div class="ld-field" style="margin-top:14px">
                            <label>Confirm New Password</label>
                            <input type="password" name="password_confirmation"
                                   placeholder="Re-enter new password">
                        </div>

                        <div class="tp-divider"></div>

                        <div class="tp-section-label">Confirm It's You</div>

                        <div class="ld-field">
                            <label>Current Password *</label>
                            <input type="password" name="current_password"
                                   placeholder="Enter your current password" required>
                            <div class="tp-hint">Required to save any change.</div>
                        </div>

                        <div class="tp-actions">
                            <a href="{{ route('team.logout') }}" class="tp-logout"
                               onclick="event.preventDefault(); document.getElementById('tpLogoutForm').submit();">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out
                            </a>

                            <button type="submit" class="ld-btn ld-btn-primary">
                                <i class="fa-solid fa-floppy-disk"></i> Save Changes
                            </button>
                        </div>

                    </form>

                    {{-- separate logout form (POST) — used by BOTH the nav Logout and the panel Log Out.
                         Kept outside the profile form; nesting forms is invalid HTML --}}
                    <form id="tpLogoutForm" action="{{ route('team.logout') }}" method="POST" style="display:none">
                        @csrf
                    </form>

                </div>

            </div>

        </main>
    </div>
</div>

<script>
    // Mobile top-bar nav toggle (replaces the removed sidebar).
    (function(){
        const burger = document.getElementById('tbBurger');
        const nav    = document.getElementById('tbNav');
        if(!burger || !nav) return;

        function close(){
            nav.classList.remove('tb-open');
            burger.setAttribute('aria-expanded','false');
            burger.querySelector('i').className = 'fa-solid fa-bars';
        }

        burger.addEventListener('click', function(e){
            e.stopPropagation();
            const open = nav.classList.toggle('tb-open');
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
            burger.querySelector('i').className = open ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
        });

        document.addEventListener('click', function(e){
            if(nav.classList.contains('tb-open') && !nav.contains(e.target) && !burger.contains(e.target)){
                close();
            }
        });

        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape' && nav.classList.contains('tb-open')) close();
        });
    })();
</script>

</x-layout>