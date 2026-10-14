<x-layout>

<style> a{ text-decoration:none; } </style>
<link rel="stylesheet" href="{{asset('team-portal_assets/dashboard.css?v=1')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

{{-- Dashboard content styling. Base cb-* chrome comes from dashboard.css.
     Colour tokens referenced with fallbacks matching your design system. --}}
<style>
    .td-main{flex:1;min-width:0}

    /* ===== TOP-BAR NAV + MOBILE TOGGLE (replaces the sidebar nav) ===== */
    .cb-top{position:relative}              /* anchor for the mobile dropdown */

    .tb-burger{
        display:none;                       /* desktop: hidden */
        width:42px;height:42px;border-radius:12px;
        background:#151515;border:1px solid var(--cb-line,#262626);
        color:var(--cb-white,#f3f3f3);cursor:pointer;font-size:16px;
        align-items:center;justify-content:center;flex:0 0 auto;
    }

    .cb-nav .cb-pill{text-decoration:none}  /* anchors styled as pills */
    .cb-nav form{margin:0} @media(max-width:760px){
        .tb-burger{display:inline-flex}

        /* nav collapses into a dropdown under the top bar.
           !important guarantees override of any dashboard.css mobile rule
           (which I cannot see — this makes the toggle deterministic). */
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
        .cb-nav.tb-open{display:flex !important}
        .cb-nav .cb-pill{width:100%;justify-content:flex-start}
        .cb-nav form{width:100%}
        .cb-nav form .cb-pill{width:100%}
        .cb-nav .cb-search{display:none}    /* hide decorative search in mobile menu */
    }

    /* KPI cards */
    .td-kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:18px}
    .td-kpi{
        background:var(--cb-card,#181818);
        border:1px solid var(--cb-line,#262626);
        border-radius:18px;padding:20px;
    }
    .td-kpi-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
    .td-kpi-ic{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:16px;flex:0 0 auto}
    .td-ic-total{background:rgba(255,255,255,.08);color:#eaeaea}
    .td-ic-done{background:rgba(46,192,106,.15);color:#42cf7c}
    .td-ic-pend{background:rgba(246,149,30,.15);color:#f6a83f}
    .td-ic-skip{background:rgba(239,83,80,.15);color:#f2726f}
    .td-kpi-num{font-size:30px;font-weight:800;line-height:1;color:var(--cb-white,#f3f3f3)}
    .td-kpi-lbl{font-size:12px;color:var(--cb-gray,#7d7d7d);margin-top:6px}  @media(max-width:1024px){.td-kpis{grid-template-columns:repeat(2,1fr)}}
    @media(max-width:520px){.td-kpis{grid-template-columns:1fr 1fr}}

    /* progress card */
    .td-prog{
        background:var(--cb-card,#181818);
        border:1px solid var(--cb-line,#262626);
        border-radius:18px;padding:22px;margin-bottom:18px;
    }
    .td-prog-head{display:flex;align-items:baseline;justify-content:space-between;margin-bottom:14px}
    .td-prog-head h3{font-size:14px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--cb-white,#f3f3f3)}
    .td-prog-pct{font-size:26px;font-weight:800;color:var(--cb-lime,#b6e44f)}
    .td-prog-bar{height:12px;background:#0f0f0f;border-radius:20px;overflow:hidden;border:1px solid var(--cb-line,#262626)}
    .td-prog-fill{height:100%;background:var(--cb-lime,#b6e44f);border-radius:20px;transition:width .5s ease}
    .td-prog-sub{font-size:12px;color:var(--cb-gray,#7d7d7d);margin-top:10px}

    /* two-column panels */
    .td-cols{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:18px}
    @media(max-width:900px){.td-cols{grid-template-columns:1fr}}

    .td-panel{
        background:#111;
        border:1px solid var(--cb-line,#262626);
        border-radius:18px;padding:20px;
    }
    .td-panel-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px}
    .td-panel-head h3{font-size:14px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--cb-white,#f3f3f3)}
    .td-count-badge{font-size:12px;font-weight:600;color:var(--cb-gray,#7d7d7d);background:#1c1c1c;padding:4px 11px;border-radius:20px}

    .td-list{display:flex;flex-direction:column;gap:10px}
    .td-item{
        display:flex;align-items:center;gap:12px;
        background:#1a1a1a;border:1px solid #242424;border-radius:12px;padding:12px 14px;
    }
    .td-stop{
        min-width:30px;height:30px;border-radius:9px;flex:0 0 auto;
        background:rgba(182,228,79,.15);color:var(--cb-lime,#b6e44f);
        display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12.5px;
    }
    .td-item-main{flex:1;min-width:0}
    .td-item-name{font-size:13.5px;font-weight:600;color:var(--cb-white,#f3f3f3);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .td-item-sub{font-size:11.5px;color:var(--cb-gray,#7d7d7d);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .td-item-right{font-size:11.5px;color:var(--cb-gray,#7d7d7d);white-space:nowrap;flex:0 0 auto;text-align:right}
    .td-proof{color:var(--cb-lime,#b6e44f);font-size:12px;font-weight:600;display:inline-flex;align-items:center;gap:5px}
    .td-proof:hover{text-decoration:underline}

    .td-empty{padding:26px 14px;text-align:center;color:var(--cb-gray,#7d7d7d);font-size:13px}
    .td-empty i{font-size:26px;color:#333;display:block;margin-bottom:10px}

    /* all-time strip */
    .td-strip{
        background:var(--cb-card,#181818);
        border:1px solid var(--cb-line,#262626);
        border-radius:18px;padding:20px 22px;
        display:flex;flex-wrap:wrap;gap:26px;align-items:center;
    }
    .td-strip-title{font-size:12px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--cb-gray,#7d7d7d);margin-right:8px}
    .td-strip-item{display:flex;flex-direction:column}
    .td-strip-num{font-size:22px;font-weight:800;color:var(--cb-white,#f3f3f3);line-height:1}
    .td-strip-lbl{font-size:11px;color:var(--cb-gray,#7d7d7d);margin-top:4px}

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

            {{-- Logout is POST (matches your route) — form-button, not a link --}}
            <form action="{{ route('team.logout') }}" method="POST">
                @csrf
                <button type="submit" class="cb-pill" style="color:#f2726f">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>

            <button class="cb-search" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
        </nav> <div class="cb-profile">
            <div class="cb-pname"><b>{{ session('team_name', $team->name) }}</b><span>Field Crew</span></div>
            <div class="cb-avatar">
                <svg viewBox="0 0 46 46"><circle cx="23" cy="18" r="8" fill="rgba(255,255,255,.35)"/><path d="M9 42c0-8 6.3-13 14-13s14 5 14 13" fill="rgba(255,255,255,.3)"/></svg>
                <span class="cb-badge">{{ $weekPending }}</span>
            </div>
        </div>
    </header>

    <!-- HEADER -->
    <div class="cb-head">
        <h1 class="cb-title">Harrys lawn care</h1>
        <div class="cb-filters">
            <div class="cb-filter">
                <i class="fa-regular fa-calendar-days"></i>&nbsp;
                <b>{{ $weekStart->format('M d') }} – {{ $weekEnd->format('M d') }}</b>
            </div>
        </div>
    </div>

    <!-- LAYOUT (sidebar removed — nav now lives in the top bar) -->
    <div class="cb-layout">

        <!-- MAIN -->
        <main class="td-main"> {{-- KPI CARDS (this week — real counts) --}}
            <div class="td-kpis">
                <div class="td-kpi">
                    <div class="td-kpi-top">
                        <div class="td-kpi-ic td-ic-total"><i class="fa-solid fa-list-check"></i></div>
                    </div>
                    <div class="td-kpi-num">{{ $weekTotal }}</div>
                    <div class="td-kpi-lbl">Jobs This Week</div>
                </div>
                <div class="td-kpi">
                    <div class="td-kpi-top">
                        <div class="td-kpi-ic td-ic-done"><i class="fa-solid fa-circle-check"></i></div>
                    </div>
                    <div class="td-kpi-num">{{ $weekCompleted }}</div>
                    <div class="td-kpi-lbl">Completed</div>
                </div>
                <div class="td-kpi">
                    <div class="td-kpi-top">
                        <div class="td-kpi-ic td-ic-pend"><i class="fa-solid fa-clock"></i></div>
                    </div>
                    <div class="td-kpi-num">{{ $weekPending }}</div>
                    <div class="td-kpi-lbl">Pending</div>
                </div>
                <div class="td-kpi">
                    <div class="td-kpi-top">
                        <div class="td-kpi-ic td-ic-skip"><i class="fa-solid fa-circle-xmark"></i></div>
                    </div>
                    <div class="td-kpi-num">{{ $weekSkipped }}</div>
                    <div class="td-kpi-lbl">Skipped</div>
                </div>
            </div> {{-- COMPLETION PROGRESS (this week) --}}
            <div class="td-prog">
                <div class="td-prog-head">
                    <h3>This Week's Progress</h3>
                    <div class="td-prog-pct">{{ $weekRate }}%</div>
                </div>
                <div class="td-prog-bar">
                    <div class="td-prog-fill" style="width: {{ $weekRate }}%;"></div>
                </div>
                <div class="td-prog-sub">
                    {{ $weekCompleted }} of {{ $weekTotal }} jobs completed
                    @if($weekPending > 0) · {{ $weekPending }} remaining @endif
                </div>
            </div>

            {{-- TWO PANELS: remaining + recent --}}
            <div class="td-cols">

                {{-- REMAINING THIS WEEK --}}
                <div class="td-panel">
                    <div class="td-panel-head">
                        <h3>Remaining This Week</h3>
                        <span class="td-count-badge">{{ $todo->count() }}</span>
                    </div>

                    @if($todo->count())
                        <div class="td-list">
                            @foreach($todo as $stop)
                                @php $q = $stop->assignment?->quote; @endphp
                                <div class="td-item">
                                    <span class="td-stop">{{ $stop->stop_order ?? '—' }}</span>
                                    <div class="td-item-main">
                                        <div class="td-item-name">{{ $q->client_name ?? ('Quote #'.($q->id ?? '?')) }}</div>
                                        <div class="td-item-sub">{{ $q->client_address ?? '—' }}</div>
                                    </div>
                                    <div class="td-item-right">
                                        {{ \Carbon\Carbon::parse($stop->service_date)->format('D, M d') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="td-empty">
                            <i class="fa-solid fa-circle-check"></i>
                            All jobs done for this week.
                        </div>
                    @endif
                </div> {{-- RECENT COMPLETIONS --}}
                <div class="td-panel">
                    <div class="td-panel-head">
                        <h3>Recent Completions</h3>
                        <span class="td-count-badge">{{ $recent->count() }}</span>
                    </div>

                    @if($recent->count())
                        <div class="td-list">
                            @foreach($recent as $stop)
                                @php
                                    $q = $stop->assignment?->quote;
                                    // proof_photo is a JSON array (model $casts => 'array').
                                    // Link the FIRST after photo; show total count if more than one.
                                    $afterPhotos = $stop->proof_photo ?? [];
                                    $firstAfter  = $afterPhotos[0]['path'] ?? null;
                                @endphp
                                <div class="td-item">
                                    <span class="td-stop" style="background:rgba(46,192,106,.15);color:#42cf7c">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                    <div class="td-item-main">
                                        <div class="td-item-name">{{ $q->client_name ?? ('Quote #'.($q->id ?? '?')) }}</div>
                                        <div class="td-item-sub">
                                            {{ $stop->completed_at ? \Carbon\Carbon::parse($stop->completed_at)->format('M d, g:i A') : '—' }}
                                        </div>
                                    </div>
                                    <div class="td-item-right">
                                        @if($firstAfter)
                                            <a href="{{ asset('storage/'.$firstAfter) }}" target="_blank" class="td-proof">
                                                <i class="fa-solid fa-image"></i> Proof{{ count($afterPhotos) > 1 ? ' ('.count($afterPhotos).')' : '' }}
                                            </a>
                                        @else
                                            —
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>  @else
                        <div class="td-empty">
                            <i class="fa-solid fa-inbox"></i>
                            No completed jobs yet.
                        </div>
                    @endif
                </div>

            </div>

            {{-- ALL-TIME STRIP --}}
            <div class="td-strip">
                <span class="td-strip-title">All Time</span>
                <div class="td-strip-item">
                    <span class="td-strip-num">{{ $allTotal }}</span>
                    <span class="td-strip-lbl">Total Jobs</span>
                </div>
                <div class="td-strip-item">
                    <span class="td-strip-num">{{ $allCompleted }}</span>
                    <span class="td-strip-lbl">Completed</span>
                </div>
                <div class="td-strip-item">
                    <span class="td-strip-num">{{ $allRate }}%</span>
                    <span class="td-strip-lbl">Completion Rate</span>
                </div>
                <div class="td-strip-item">
                    <span class="td-strip-num">{{ $activeClients }}</span>
                    <span class="td-strip-lbl">Active Clients</span>
                </div>
            </div>

        </main>
    </div>
</div>
<script>
(function(){
    // Mobile top-bar nav toggle (replaces the old sidebar toggle).
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