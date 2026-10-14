<x-layout>

<link rel="stylesheet" href="{{asset('team-portal_assets/leads_assigned.css')}}">
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
    .th-filter{display:flex;flex-wrap:wrap;gap:9px;margin-bottom:20px}
    .th-chip{padding:9px 16px;border-radius:24px;font-size:13px;font-weight:600;text-decoration:none;border:1px solid var(--cb-line,#262626);color:var(--cb-gray,#7d7d7d);background:#141414;transition:.16s}
    .th-chip:hover{color:#cfcfcf;background:#1d1d1d}
    .th-chip.is-active{background:var(--cb-lime,#b6e44f);color:#15240a;border-color:transparent}

    .th-stop{display:inline-flex;min-width:30px;height:30px;align-items:center;justify-content:center;background:rgba(182,228,79,.15);color:var(--cb-lime,#b6e44f);border-radius:9px;font-weight:700;font-size:12.5px}

    .th-dash{color:var(--cb-gray-d,#5a5a5a)}

    /* ===== BEFORE / AFTER PROOF CELL ===== */
    .th-ba{display:flex;gap:12px;align-items:flex-start}
    .th-ba-item{display:flex;flex-direction:column;gap:4px;align-items:flex-start}
    .th-ba-label{font-size:10px;font-weight:700;letter-spacing:.4px;text-transform:uppercase}
    .th-ba-label.before{color:#e0a12f}
    .th-ba-label.after{color:var(--cb-lime,#b6e44f)}
    .th-ba-thumb{
        width:44px;height:44px;border-radius:8px;object-fit:cover;
        border:1px solid var(--cb-line,#262626);cursor:pointer;transition:.15s;
    }
    .th-ba-thumb:hover{transform:scale(1.06);border-color:var(--cb-lime,#b6e44f)}
    .th-ba-time{font-size:10px;color:var(--cb-gray,#7d7d7d);line-height:1.3;white-space:nowrap}
    .th-ba-none{font-size:11px;color:var(--cb-gray-d,#5a5a5a);font-style:italic}

    /* ===== GPS LOCATION PROOF (map link + accuracy) ===== */
    .th-ba-map{
        display:inline-flex;align-items:center;gap:4px;
        font-size:10px;font-weight:600;color:#7fb3ff;
        text-decoration:none;white-space:nowrap;
    }
    .th-ba-map:hover{text-decoration:underline;color:#a9ccff}
    .th-ba-acc{font-size:9.5px;color:var(--cb-gray,#7d7d7d);white-space:nowrap}
    .th-ba-nogps{font-size:9.5px;color:var(--cb-gray-d,#5a5a5a);font-style:italic;white-space:nowrap}

    /* ===== MULTI-PHOTO GALLERY (many before/after per job) ===== */
    .th-gal{display:flex;gap:14px;align-items:flex-start}
    .th-gal-col{display:flex;flex-direction:column;gap:5px}
    .th-gal-head{font-size:10px;font-weight:700;letter-spacing:.4px;text-transform:uppercase}
    .th-gal-head.before{color:#e0a12f}
    .th-gal-head.after{color:var(--cb-lime,#b6e44f)}
    .th-gal-strip{display:flex;gap:6px;flex-wrap:wrap;max-width:280px}
    .th-gitem{display:flex;flex-direction:column;gap:2px;align-items:flex-start;width:58px}
    .th-gimg{width:58px;height:58px;object-fit:cover;border-radius:7px;border:1px solid var(--cb-line,#262626);cursor:pointer;transition:.15s}
    .th-gimg:hover{transform:scale(1.07);border-color:var(--cb-lime,#b6e44f)}
    .th-gmap{display:inline-flex;align-items:center;gap:2px;font-size:8.5px;font-weight:600;color:#7fb3ff;text-decoration:none;white-space:nowrap}
    .th-gmap:hover{text-decoration:underline}
    .th-gtime{font-size:8px;color:var(--cb-gray,#7d7d7d);white-space:nowrap;line-height:1.2}
    .th-gnogps{font-size:8px;color:var(--cb-gray-d,#5a5a5a);font-style:italic}

   /* pagination -> match dark theme */
    .th-pag{margin-top:20px}
    .th-pag nav{display:flex;justify-content:center}
    .th-pag nav p{color:var(--cb-gray,#7d7d7d);font-size:12.5px}
    .th-pag svg{width:18px;height:18px}
    .th-pag [aria-current] span{background:var(--cb-lime,#b6e44f);color:#15240a;border-radius:8px}
    .th-pag a,.th-pag span{color:#dcdcdc;border-color:var(--cb-line,#262626)!important}

    a{text-decoration:none}

    /* ===== LIGHTBOX (pure JS, no library) ===== */
    .th-lightbox{
        position:fixed;inset:0;background:rgba(0,0,0,.85);
        display:none;align-items:center;justify-content:center;
        z-index:99999;padding:20px;
    }
    .th-lightbox.active{display:flex}
    .th-lightbox img{max-width:92%;max-height:88%;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,.5)}
    .th-lightbox-close{position:absolute;top:22px;right:28px;color:#fff;font-size:34px;cursor:pointer;line-height:1}

    /* ===== TOP-BAR NAV + MOBILE TOGGLE ===== */
    .cb-top{ position:relative; }

    .tb-burger{
        display:none;
        width:42px;height:42px;border-radius:12px;
        background:#151515;border:1px solid var(--cb-line,#262626);
        color:#f3f3f3;cursor:pointer;font-size:16px;
        align-items:center;justify-content:center;flex:0 0 auto;
    }

    .cb-nav .cb-pill{ text-decoration:none; }
    .cb-nav form{ margin:0; }  @media(max-width:760px){
        .tb-burger{ display:inline-flex; }

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
</style><div class="cb-app">

    <!-- TOP BAR -->
    <header class="cb-top">
        <div class="cb-logo">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 18.5V6.2c0-.5.6-.8 1-.4l11.6 12.4c.4.4 1 .1 1-.4V5.5" stroke="#f3f3f3" stroke-width="2.1" stroke-linecap="round"/>
            </svg>
        </div> <button class="tb-burger" id="tbBurger" type="button" aria-label="Toggle menu" aria-expanded="false">
            <i class="fa-solid fa-bars"></i>
        </button>

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
 <form action="{{ route('team.logout') }}" method="POST">
                @csrf
                <button type="submit" class="cb-pill" style="color:#f2726f">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>

            <button class="cb-search-top" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
        </nav> <div class="cb-profile">
            <div class="cb-pname"><b>{{ $team->name }}</b><span>Field Crew</span></div>
            <div class="cb-avatar">
                <svg viewBox="0 0 46 46"><circle cx="23" cy="18" r="8" fill="rgba(255,255,255,.35)"/><path d="M9 42c0-8 6.3-13 14-13s14 5 14 13" fill="rgba(255,255,255,.3)"/></svg>
                <span class="cb-badge">{{ $counts['pending'] }}</span>
            </div>
        </div>
    </header>

    <!-- HEADER -->
    <div class="cb-head">
        <div>
            <h1 class="cb-title">Job History</h1>
            <p class="ld-subtitle">{{ $team->name }} — all scheduled visits to date, newest first</p>
        </div>
    </div><!-- LAYOUT -->
    <div class="cb-layout">

        <main class="ld-main">

            <!-- KPI SUMMARY -->
            <div class="ld-kpis">
                <div class="ld-kpi"><div class="ld-kpi-ic ld-ic-total"><i class="fa-solid fa-list-check"></i></div><div><div class="ld-kpi-num">{{ $counts['total'] }}</div><div class="ld-kpi-lbl">Total Jobs</div></div></div>
                <div class="ld-kpi"><div class="ld-kpi-ic ld-ic-green"><i class="fa-solid fa-circle-check"></i></div><div><div class="ld-kpi-num">{{ $counts['completed'] }}</div><div class="ld-kpi-lbl">Completed</div></div></div>
                <div class="ld-kpi"><div class="ld-kpi-ic ld-ic-orange"><i class="fa-solid fa-clock"></i></div><div><div class="ld-kpi-num">{{ $counts['pending'] }}</div><div class="ld-kpi-lbl">Pending</div></div></div>
                <div class="ld-kpi"><div class="ld-kpi-ic ld-ic-red"><i class="fa-solid fa-circle-xmark"></i></div><div><div class="ld-kpi-num">{{ $counts['skipped'] }}</div><div class="ld-kpi-lbl">Skipped</div></div></div>
            </div>
 <!-- FILTER CHIPS -->
            <div class="th-filter">
                <a href="{{ url()->current() }}" class="th-chip {{ !request('status') ? 'is-active' : '' }}">All</a>
                <a href="{{ url()->current() }}?status=completed" class="th-chip {{ request('status') === 'completed' ? 'is-active' : '' }}">Completed</a>
                <a href="{{ url()->current() }}?status=pending" class="th-chip {{ request('status') === 'pending' ? 'is-active' : '' }}">Pending</a>
                <a href="{{ url()->current() }}?status=skipped" class="th-chip {{ request('status') === 'skipped' ? 'is-active' : '' }}">Skipped</a>
            </div>

            <!-- TABLE -->
            <div class="ld-tablewrap">
                <div class="ld-scroll">
                    <table class="ld-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Stop</th>
                                <th>Client</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Before / After Proof</th>
                            </tr>
                        </thead>
                        <tbody>  @forelse($schedules as $s)
                                @php
                                    $quote     = $s->assignment?->quote;
                                    // before_photo / proof_photo are JSON arrays (model $casts => 'array').
                                    $befores = $s->before_photo ?? [];
                                    $afters  = $s->proof_photo ?? [];
                                    $hasBefore = count($befores) > 0;
                                    $hasAfter  = count($afters) > 0;
                                @endphp
                                <tr data-status="{{ $s->status }}">

                                    <td data-label="Date">
                                        <span class="ld-subject">{{ \Carbon\Carbon::parse($s->service_date)->format('M d, Y') }}</span>
                                    </td>

                                    <td data-label="Stop">
                                        <span class="th-stop">{{ $s->stop_order ?? '—' }}</span>
                                    </td> <td data-label="Client">
                                        <span class="ld-name-t">{{ $quote->client_name ?? ('Quote #'.($quote->id ?? '?')) }}</span>
                                    </td>

                                    <td data-label="Address">
                                        <span class="ld-msg" title="{{ $quote->client_address ?? '' }}">{{ $quote->client_address ?? '—' }}</span>
                                    </td>

                                    <td data-label="Status">
                                        @if($s->status === 'completed')
                                            <span class="ld-pill ld-confirmed"><span class="ld-pill-dot"></span>Completed</span>
                                        @elseif($s->status === 'skipped')
                                            <span class="ld-pill ld-cancelled"><span class="ld-pill-dot"></span>Skipped</span>
                                        @elseif($hasBefore && !$hasAfter)
                                            <span class="ld-pill ld-pending"><span class="ld-pill-dot"></span>In Progress</span>
                                        @else
                                            <span class="ld-pill ld-pending"><span class="ld-pill-dot"></span>Pending</span>
                                        @endif
                                    </td>{{-- BEFORE / AFTER PROOF: multi-photo galleries, each photo with its own GPS + time --}}
                                    <td data-label="Before / After Proof">
                                        @if($hasBefore || $hasAfter)
                                            <div class="th-gal">
                                                {{-- BEFORE column --}}
                                                <div class="th-gal-col">
                                                    <span class="th-gal-head before">Before ({{ count($befores) }})</span>
                                                    @if($hasBefore)
                                                        <div class="th-gal-strip">
                                                            @foreach($befores as $bp)
                                                                <div class="th-gitem">
                                                                    <img src="{{ asset('storage/'.$bp['path']) }}" class="th-gimg" alt="Before" onclick="thOpenProof('{{ asset('storage/'.$bp['path']) }}')">
                                                                    @if(!empty($bp['lat']) && !empty($bp['lng']))
                                                                        <a href="https://www.google.com/maps?q={{ $bp['lat'] }},{{ $bp['lng'] }}" target="_blank" rel="noopener" class="th-gmap" title="{{ $bp['lat'] }}, {{ $bp['lng'] }}">
                                                                            <i class="fa-solid fa-location-dot"></i> {{ isset($bp['accuracy']) ? '±'.round($bp['accuracy']).'m' : 'Map' }}
                                                                        </a>
                                                                    @else
                                                                        <span class="th-gnogps">No GPS</span>
                                                                    @endif
                                                                    <span class="th-gtime">{{ !empty($bp['taken_at']) ? \Carbon\Carbon::parse($bp['taken_at'])->format('M d g:iA') : '' }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="th-ba-none">—</span>
                                                    @endif
                                                </div> {{-- AFTER column --}}
                                                <div class="th-gal-col">
                                                    <span class="th-gal-head after">After ({{ count($afters) }})</span>
                                                    @if($hasAfter)
                                                        <div class="th-gal-strip">
                                                            @foreach($afters as $ap)
                                                                <div class="th-gitem">
                                                                    <img src="{{ asset('storage/'.$ap['path']) }}" class="th-gimg" alt="After" onclick="thOpenProof('{{ asset('storage/'.$ap['path']) }}')">
                                                                    @if(!empty($ap['lat']) && !empty($ap['lng']))
                                                                        <a href="https://www.google.com/maps?q={{ $ap['lat'] }},{{ $ap['lng'] }}" target="_blank" rel="noopener" class="th-gmap" title="{{ $ap['lat'] }}, {{ $ap['lng'] }}">
                                                                            <i class="fa-solid fa-location-dot"></i> {{ isset($ap['accuracy']) ? '±'.round($ap['accuracy']).'m' : 'Map' }}
                                                                        </a>
                                                                    @else
                                                                        <span class="th-gnogps">No GPS</span>
                                                                    @endif
                                                                    <span class="th-gtime">{{ !empty($ap['taken_at']) ? \Carbon\Carbon::parse($ap['taken_at'])->format('M d g:iA') : '' }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="th-ba-none">—</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <span class="th-ba-none">No photos</span>
                                        @endif
                                    </td>
                                </tr>  @empty
                                <tr>
                                    <td colspan="6" style="background:transparent;border:none;box-shadow:none;padding:0">
                                        <div class="ld-empty" style="display:block">
                                            <i class="fa-solid fa-inbox"></i>
                                            No job history found{{ request('status') ? ' for this status' : '' }}.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            @if($schedules->hasPages())
                <div class="th-pag">
                    {{ $schedules->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </main>
    </div>
</div>
{{-- LIGHTBOX (single instance, reused for before + after) --}}
<div class="th-lightbox" id="thLightbox" onclick="thCloseProof()">
    <span class="th-lightbox-close">&times;</span>
    <img id="thLightboxImg" src="" alt="Proof photo full size">
</div>

<script>
    // Proof lightbox
    function thOpenProof(src){
        document.getElementById("thLightboxImg").src = src;
        document.getElementById("thLightbox").classList.add("active");
    }
    function thCloseProof(){
        document.getElementById("thLightbox").classList.remove("active");
    }
    document.addEventListener("keydown", function(e){
        if(e.key === "Escape") thCloseProof();
    });

    // Mobile top-bar nav toggle
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