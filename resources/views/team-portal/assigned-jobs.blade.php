<x-layout>

    <link rel="stylesheet" href="{{asset('team-portal_assets/leads_assigned.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root{
            --aj-card:#0C0C0C;
            --aj-card2:#B6E44F;
            --aj-border:rgba(255,255,255,0.08);
            --aj-muted:#94a3b8;
            --aj-badge:#2563eb;
            --aj-green:#16a34a;
            --aj-amber:#f59e0b;
            --aj-red:#dc2626;
        }

        .aj-zone{ font-family:'Poppins',sans-serif; color:black !important; padding:18px; margin:0 auto; }

        .aj-head{ background:#B6E44F; border:1px solid var(--aj-border); border-radius:14px; padding:20px 22px; margin-bottom:16px; }
        .aj-head h1{ font-size:20px;font-weight:bold; margin:0 0 4px; color:black; }
        .aj-head .aj-sub{ font-size:13px; color:black; }

        .aj-progress-bar{ margin-top:14px; height:10px; background:black; border-radius:20px; overflow:hidden; }
        .aj-progress-fill{ height:100%; background:red; border-radius:20px; transition:width .4s ease; }
        .aj-progress-txt{ font-size:12px; margin-top:6px; color:black; }

        .aj-kpis{ display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:16px; }
        .aj-kpi{ background:var(--aj-card); border:1px solid var(--aj-border); border-radius:12px; padding:14px; display:flex; align-items:center; gap:12px; }
        .aj-kpi-ic{ width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; color:#fff; flex-shrink:0; }
        .aj-ic-total{ background:#2563eb; }
        .aj-ic-done{ background:var(--aj-green); }
        .aj-ic-pend{ background:var(--aj-amber); }
        .aj-ic-skip{ background:var(--aj-red); }
        .aj-kpi-num{ font-size:20px; font-weight:700; line-height:1; color:#fff; }
        .aj-kpi-lbl{ font-size:11px; color:var(--aj-muted); margin-top:3px; }
        @media(max-width:560px){ .aj-kpis{ grid-template-columns:repeat(2,1fr); } }

        .aj-week{ display:flex; gap:8px; margin-bottom:16px; }
        .aj-week input[type=date]{ flex:1; padding:10px; border:1px solid var(--aj-border); border-radius:10px; font-family:inherit; background:var(--aj-card2); color:black !important; }
        .aj-week button{ background:#B6E44F; color:black; border:none; padding:10px 16px; border-radius:10px; font-weight:600; cursor:pointer; }

        .aj-flash{ background:rgba(22,163,74,.15); color:#4ade80; border:1px solid rgba(22,163,74,.3); padding:12px 14px; border-radius:10px; margin-bottom:14px; font-size:14px; }
        .aj-err{ background:rgba(220,38,38,.15); color:#f87171; border:1px solid rgba(220,38,38,.3); padding:12px 14px; border-radius:10px; margin-bottom:14px; font-size:14px; }

        .aj-card{ background:var(--aj-card); border:1px solid var(--aj-border); border-left:5px solid var(--aj-amber); border-radius:14px; margin-bottom:14px; overflow:hidden; }
        .aj-card.is-done{ border-left-color:var(--aj-green); }
        .aj-card.is-progress{ border-left-color:var(--aj-card2); }

        .aj-card-top{ display:flex; justify-content:space-between; align-items:flex-start; gap:12px; padding:16px 18px 10px; }
        .aj-stopno{ background:var(--aj-badge); color:#fff; min-width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; flex-shrink:0; }
        .aj-client{ font-size:16px; font-weight:600; color:#fff; line-height:1.3; }
        .aj-addr{ font-size:13px; color:var(--aj-muted); margin-top:3px; }
        .aj-date{ font-size:12px; color:var(--aj-muted); margin-top:4px; }

        .aj-status{ font-size:11px; font-weight:600; padding:4px 11px; border-radius:20px; white-space:nowrap; flex-shrink:0; }
        .aj-status-pending{ background:rgba(245,158,11,.15); color:#fbbf24; }
        .aj-status-completed{ background:rgba(22,163,74,.15); color:#4ade80; }
        .aj-status-skipped{ background:rgba(220,38,38,.15); color:#f87171; }
        .aj-status-progress{ background:rgba(182,228,79,.18); color:#b6e44f; }

        .aj-card-body{ padding:6px 18px 18px; }

        .aj-cam-btn{ display:flex; align-items:center; justify-content:center; gap:8px; width:100%; padding:14px; background:rgba(37,99,235,.12); color:#93c5fd; border:2px dashed #3b5680; border-radius:12px; font-weight:600; cursor:pointer; font-size:15px; }
        .aj-cam-btn:active{ background:rgba(37,99,235,.2); }
        .aj-pick-row{ display:flex; gap:10px; }
        .aj-pick-row .aj-cam-btn{ flex:1 1 0; min-width:0; }
        .aj-gal-btn{ background:rgba(16,185,129,.12); color:#6ee7b7; border-color:#2f6b57; }
        .aj-gal-btn:active{ background:rgba(16,185,129,.2); }

        .aj-preview{ width:100%; max-height:260px; object-fit:cover; border-radius:12px; margin-top:12px; display:block; }

        /* add-photo submit (lime) */
        .aj-add-btn{ width:100%; margin-top:12px; padding:13px; background:var(--aj-card2); color:#15240a; border:none; border-radius:12px; font-weight:700; font-size:15px; cursor:pointer; }
        .aj-add-btn:disabled{ background:#374151; color:#9ca3af; cursor:not-allowed; }
        .aj-add-btn:not(:disabled):active{ filter:brightness(1.06); }

        /* complete job button (green, separate action) */
        .aj-complete-btn{ width:100%; margin-top:14px; padding:15px; background:var(--aj-green); color:#fff; border:none; border-radius:12px; font-weight:700; font-size:15px; cursor:pointer; }
        .aj-complete-btn:active{ background:#15803d; }

        .aj-section-lbl{ font-size:12px; font-weight:700; letter-spacing:.5px; text-transform:uppercase; color:var(--aj-muted); margin:16px 0 8px; }

        /* GEOLOCATION STATUS BANNER */
        .aj-geo{ display:flex; align-items:center; gap:7px; font-size:12px; font-weight:600; margin-top:10px; padding:9px 11px; border-radius:10px; }
        .aj-geo-wait{ background:rgba(245,158,11,.14); color:#fbbf24; }
        .aj-geo-ok{ background:rgba(22,163,74,.14); color:#4ade80; }
        .aj-geo-err{ background:rgba(220,38,38,.14); color:#f87171; }
        .aj-geo-retry{ margin-left:auto; background:transparent; border:1px solid currentColor; color:inherit; font:inherit; font-size:11px; padding:3px 9px; border-radius:7px; cursor:pointer; }

        /* MULTI-PHOTO GALLERY */
        .aj-gallery{ display:flex; gap:8px; flex-wrap:wrap; margin-top:6px; }
        .aj-gitem{ display:flex; flex-direction:column; gap:3px; align-items:flex-start; width:92px; }
        .aj-gimg{ width:92px; height:92px; object-fit:cover; border-radius:10px; border:1px solid var(--aj-border); cursor:pointer; transition:.15s; }
        .aj-gimg:hover{ transform:scale(1.04); border-color:var(--aj-card2); }
        .aj-gmap{ display:inline-flex; align-items:center; gap:3px; font-size:9.5px; font-weight:600; color:#7fb3ff; text-decoration:none; white-space:nowrap; }
        .aj-gmap:hover{ text-decoration:underline; }
        .aj-gtime{ font-size:9px; color:var(--aj-muted); white-space:nowrap; }
        .aj-gnogps{ font-size:9px; color:#64748b; font-style:italic; }
        .aj-gcount{ font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; margin:4px 0 2px; }
        .aj-gcount.before{ color:#fbbf24; }
        .aj-gcount.after{ color:#4ade80; }
        .aj-gdel{ margin-top:2px; }
        .aj-gdel button{ background:transparent; border:none; color:#f87171; font-size:10px; cursor:pointer; padding:0; }
        .aj-gdel button:hover{ text-decoration:underline; }

        .aj-undo{ margin-top:16px; width:100%; padding:10px; background:transparent; color:var(--aj-muted); border:1px solid var(--aj-border); border-radius:10px; font-weight:600; cursor:pointer; font-size:13px; }
        .aj-undo:active{ background:rgba(255,255,255,.04); }

        .aj-skip-note{ font-size:13px; color:#f87171; font-weight:600; display:flex; align-items:center; gap:8px; padding:12px 0; }

        .aj-empty{ background:var(--aj-card); border:1px solid var(--aj-border); border-radius:14px; padding:40px 20px; text-align:center; color:var(--aj-muted); }
        .aj-empty i{ font-size:34px; color:#334155; margin-bottom:12px; display:block; }

        .aj-server-note{ font-size:11px; color:var(--aj-muted); margin-top:10px; }
        .aj-gate-note{ font-size:11px; color:var(--aj-muted); margin-top:8px; font-style:italic; }

        a{ text-decoration:none; }

        .cb-top{ position:relative; }
        .tb-burger{ display:none; width:42px;height:42px;border-radius:12px; background:#151515;border:1px solid var(--aj-border); color:#f3f3f3;cursor:pointer;font-size:16px; align-items:center;justify-content:center;flex:0 0 auto; }
        .cb-nav .cb-pill{ text-decoration:none; }
        .cb-nav form{ margin:0; }
        @media(max-width:760px){
            .tb-burger{ display:inline-flex; }
            .cb-nav{ display:none !important; position:absolute; top:calc(100% + 8px); left:0;right:0; flex-direction:column; align-items:stretch; gap:6px; background:#121212; border:1px solid var(--aj-border); border-radius:16px; padding:10px; z-index:300; box-shadow:0 20px 50px rgba(0,0,0,.55); }
            .cb-nav.tb-open{ display:flex !important; }
            .cb-nav .cb-pill{ width:100%; justify-content:flex-start; }
            .cb-nav form{ width:100%; }
            .cb-nav form .cb-pill{ width:100%; }
            .cb-nav .cb-search-top{ display:none; }
        }
    </style>

    <div class="cb-app">

        <header class="cb-top">
            <div class="cb-logo">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 18.5V6.2c0-.5.6-.8 1-.4l11.6 12.4c.4.4 1 .1 1-.4V5.5" stroke="#f3f3f3" stroke-width="2.1" stroke-linecap="round"/>
                </svg>
            </div>

            <button class="tb-burger" id="tbBurger" type="button" aria-label="Toggle menu" aria-expanded="false">
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
            </nav>

            <div class="cb-profile">
                <div class="cb-pname"><b>{{ $team->name }}</b><span>Field Crew</span></div>
                <div class="cb-avatar">
                    <svg viewBox="0 0 46 46"><circle cx="23" cy="18" r="8" fill="rgba(255,255,255,.35)"/><path d="M9 42c0-8 6.3-13 14-13s14 5 14 13" fill="rgba(255,255,255,.3)"/></svg>
                    <span class="cb-badge">{{ $pending }}</span>
                </div>
            </div>
        </header>

        <div class="cb-layout">

            <main class="ld-main">

                <div class="aj-zone">

                    {{-- HEADER --}}
                    <div class="aj-head">
                        <h1>{{ $team->name }} — My Jobs</h1>
                        <div class="aj-sub">{{ $weekStart->format('M d') }} – {{ $weekEnd->format('M d, Y') }}</div>
                        <div class="aj-progress-bar">
                            <div class="aj-progress-fill" style="width: {{ $total ? round(($done / $total) * 100) : 0 }}%;"></div>
                        </div>
                        <div class="aj-progress-txt">{{ $done }} of {{ $total }} jobs completed</div>
                    </div>

                    {{-- KPI ROW --}}
                    <div class="aj-kpis">
                        <div class="aj-kpi"><div class="aj-kpi-ic aj-ic-total"><i class="fa-solid fa-list-check"></i></div><div><div class="aj-kpi-num">{{ $total }}</div><div class="aj-kpi-lbl">Total</div></div></div>
                        <div class="aj-kpi"><div class="aj-kpi-ic aj-ic-done"><i class="fa-solid fa-circle-check"></i></div><div><div class="aj-kpi-num">{{ $done }}</div><div class="aj-kpi-lbl">Completed</div></div></div>
                        <div class="aj-kpi"><div class="aj-kpi-ic aj-ic-pend"><i class="fa-solid fa-clock"></i></div><div><div class="aj-kpi-num">{{ $pending }}</div><div class="aj-kpi-lbl">Pending</div></div></div>
                        <div class="aj-kpi"><div class="aj-kpi-ic aj-ic-skip"><i class="fa-solid fa-circle-xmark"></i></div><div><div class="aj-kpi-num">{{ $skipped }}</div><div class="aj-kpi-lbl">Skipped</div></div></div>
                    </div>

                    {{-- WEEK PICKER --}}
                    <form class="aj-week" action="{{ url()->current() }}" method="GET">
                        <input type="date" name="date" value="{{ $dateInput }}">
                        <button type="submit">View Week</button>
                    </form>

                    @if(session('success'))
                        <div class="aj-flash">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="aj-err">{{ $errors->first() }}</div>
                    @endif

                    {{-- JOB CARDS --}}
                    @forelse($stops as $stop)
                        @php
                            $befores = $stop->before_photo ?? [];
                            $afters  = $stop->proof_photo ?? [];
                            $hasBefore = count($befores) > 0;
                            $hasAfter  = count($afters) > 0;

                            if ($stop->status === 'completed') {
                                $dispLabel = 'Completed'; $dispClass = 'completed'; $borderClass = 'is-done';
                            } elseif ($stop->status === 'skipped') {
                                $dispLabel = 'Skipped';   $dispClass = 'skipped';   $borderClass = '';
                            } elseif ($hasBefore) {
                                $dispLabel = 'In Progress'; $dispClass = 'progress'; $borderClass = 'is-progress';
                            } else {
                                $dispLabel = 'Pending';   $dispClass = 'pending';   $borderClass = '';
                            }
                        @endphp

                        <div class="aj-card {{ $borderClass }}">

                            <div class="aj-card-top">
                                <div style="display:flex; gap:12px;">
                                    <span class="aj-stopno">{{ $stop->stop_order ?? '—' }}</span>
                                    <div>
                                        <div class="aj-client">{{ $stop->assignment?->quote->client_name ?? ('Quote #'.($stop->assignment?->quote->id ?? '?')) }}</div>
                                        <div class="aj-addr"><i class="fa-solid fa-location-dot"></i> {{ $stop->assignment?->quote->client_address ?? '—' }}</div>
                                        <div class="aj-date"><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($stop->service_date)->format('D, M d') }}</div>
                                    </div>
                                </div>
                                <span class="aj-status aj-status-{{ $dispClass }}">{{ $dispLabel }}</span>
                            </div>

                            <div class="aj-card-body">

                                {{-- ============ SKIPPED ============ --}}
                                @if($stop->status === 'skipped')

                                    <div class="aj-skip-note"><i class="fa-solid fa-circle-xmark"></i> This stop was skipped.</div>

                                {{-- ============ COMPLETED — read-only galleries ============ --}}
                                @elseif($stop->status === 'completed')

                                    <div class="aj-gcount before">Before — {{ count($befores) }} photo(s)</div>
                                    <div class="aj-gallery">
                                        @forelse($befores as $bp)
                                            <div class="aj-gitem">
                                                <img src="{{ asset('storage/'.$bp['path']) }}" class="aj-gimg" alt="Before" onclick="ajOpen('{{ asset('storage/'.$bp['path']) }}')">
                                                @if(!empty($bp['lat']) && !empty($bp['lng']))
                                                    <a href="https://www.google.com/maps?q={{ $bp['lat'] }},{{ $bp['lng'] }}" target="_blank" rel="noopener" class="aj-gmap">
                                                        <i class="fa-solid fa-location-dot"></i> {{ isset($bp['accuracy']) ? '±'.round($bp['accuracy']).'m' : 'Map' }}
                                                    </a>
                                                @else
                                                    <span class="aj-gnogps">No GPS</span>
                                                @endif
                                                <span class="aj-gtime">{{ !empty($bp['taken_at']) ? \Carbon\Carbon::parse($bp['taken_at'])->format('M d, g:i A') : '' }}</span>
                                            </div>
                                        @empty
                                            <span class="aj-gnogps">No before photos</span>
                                        @endforelse
                                    </div>

                                    <div class="aj-gcount after">After — {{ count($afters) }} photo(s)</div>
                                    <div class="aj-gallery">
                                        @forelse($afters as $ap)
                                            <div class="aj-gitem">
                                                <img src="{{ asset('storage/'.$ap['path']) }}" class="aj-gimg" alt="After" onclick="ajOpen('{{ asset('storage/'.$ap['path']) }}')">
                                                @if(!empty($ap['lat']) && !empty($ap['lng']))
                                                    <a href="https://www.google.com/maps?q={{ $ap['lat'] }},{{ $ap['lng'] }}" target="_blank" rel="noopener" class="aj-gmap">
                                                        <i class="fa-solid fa-location-dot"></i> {{ isset($ap['accuracy']) ? '±'.round($ap['accuracy']).'m' : 'Map' }}
                                                    </a>
                                                @else
                                                    <span class="aj-gnogps">No GPS</span>
                                                @endif
                                                <span class="aj-gtime">{{ !empty($ap['taken_at']) ? \Carbon\Carbon::parse($ap['taken_at'])->format('M d, g:i A') : '' }}</span>
                                            </div>
                                        @empty
                                            <span class="aj-gnogps">No after photos</span>
                                        @endforelse
                                    </div>

                                    <div class="aj-server-note">Server-recorded times (Vancouver) + per-photo GPS proof.</div>

                                    <form action="{{ route('team.jobs.undo', $stop->id) }}" method="POST"
                                          onsubmit="return confirm('Reset this job to pending? ALL photos and locations will be deleted.')">
                                        @csrf
                                        <button type="submit" class="aj-undo"><i class="fa-solid fa-rotate-left"></i> Undo / Redo Job</button>
                                    </form>

                                {{-- ============ PENDING or IN-PROGRESS — accumulate BOTH before and after ============ --}}
                                @else

                                    {{-- Added BEFORE photos --}}
                                    @if($hasBefore)
                                        <div class="aj-gcount before">Before — {{ count($befores) }} added</div>
                                        <div class="aj-gallery">
                                            @foreach($befores as $bp)
                                                <div class="aj-gitem">
                                                    <img src="{{ asset('storage/app/public/'.$bp['path']) }}" class="aj-gimg" alt="Before" onclick="ajOpen('{{ asset('storage/app/public/'.$bp['path']) }}')">
                                                    @if(!empty($bp['lat']) && !empty($bp['lng']))
                                                        <a href="https://www.google.com/maps?q={{ $bp['lat'] }},{{ $bp['lng'] }}" target="_blank" rel="noopener" class="aj-gmap">
                                                            <i class="fa-solid fa-location-dot"></i> {{ isset($bp['accuracy']) ? '±'.round($bp['accuracy']).'m' : 'Map' }}
                                                        </a>
                                                    @else
                                                        <span class="aj-gnogps">No GPS</span>
                                                    @endif
                                                    <span class="aj-gtime">{{ !empty($bp['taken_at']) ? \Carbon\Carbon::parse($bp['taken_at'])->format('g:i A') : '' }}</span>
                                                    <div class="aj-gdel">
                                                        <form action="{{ route('team.jobs.deletePhoto', $stop->id) }}" method="POST" onsubmit="return confirm('Delete this before photo?')">
                                                            @csrf
                                                            <input type="hidden" name="type" value="before">
                                                            <input type="hidden" name="path" value="{{ $bp['path'] }}">
                                                            <button type="submit"><i class="fa-solid fa-xmark"></i> Remove</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- ADD BEFORE PHOTO (one per submit; repeatable) --}}
                                    <div class="aj-section-lbl">{{ $hasBefore ? 'Add another before photo' : 'Step 1 — Before photo' }}</div>
                                    <form action="{{ route('team.jobs.start', $stop->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="before_lat"      id="latbefore{{ $stop->id }}">
                                        <input type="hidden" name="before_lng"      id="lngbefore{{ $stop->id }}">
                                        <input type="hidden" name="before_accuracy" id="accbefore{{ $stop->id }}">

                                        <input type="file" accept="image/*" name="before_photo"
                                               id="filebefore{{ $stop->id }}"
                                               onchange="ajCapture('before{{ $stop->id }}', this)" hidden required>
                                        <div class="aj-pick-row">
                                            <button type="button" class="aj-cam-btn" onclick="ajPick('filebefore{{ $stop->id }}', true)">
                                                <i class="fa-solid fa-camera"></i> Camera
                                            </button>
                                            <button type="button" class="aj-cam-btn aj-gal-btn" onclick="ajPick('filebefore{{ $stop->id }}', false)">
                                                <i class="fa-solid fa-images"></i> Gallery
                                            </button>
                                        </div>
                                        <img id="prevbefore{{ $stop->id }}" class="aj-preview" hidden alt="">
                                        <div id="geobefore{{ $stop->id }}" class="aj-geo" hidden></div>
                                        <button type="submit" id="submitbefore{{ $stop->id }}" class="aj-add-btn" disabled>
                                            <i class="fa-solid fa-plus"></i> Save Before Photo
                                        </button>
                                    </form>

                                    {{-- Added AFTER photos --}}
                                    @if($hasAfter)
                                        <div class="aj-gcount after">After — {{ count($afters) }} added</div>
                                        <div class="aj-gallery">
                                            @foreach($afters as $ap)
                                                <div class="aj-gitem">
                                                    <img src="{{ asset('storage/app/public/'.$ap['path']) }}" class="aj-gimg" alt="After" onclick="ajOpen('{{ asset('storage/app/public/'.$ap['path']) }}')">
                                                    @if(!empty($ap['lat']) && !empty($ap['lng']))
                                                        <a href="https://www.google.com/maps?q={{ $ap['lat'] }},{{ $ap['lng'] }}" target="_blank" rel="noopener" class="aj-gmap">
                                                            <i class="fa-solid fa-location-dot"></i> {{ isset($ap['accuracy']) ? '±'.round($ap['accuracy']).'m' : 'Map' }}
                                                        </a>
                                                    @else
                                                        <span class="aj-gnogps">No GPS</span>
                                                    @endif
                                                    <span class="aj-gtime">{{ !empty($ap['taken_at']) ? \Carbon\Carbon::parse($ap['taken_at'])->format('g:i A') : '' }}</span>
                                                    <div class="aj-gdel">
                                                        <form action="{{ route('team.jobs.deletePhoto', $stop->id) }}" method="POST" onsubmit="return confirm('Delete this after photo?')">
                                                            @csrf
                                                            <input type="hidden" name="type" value="after">
                                                            <input type="hidden" name="path" value="{{ $ap['path'] }}">
                                                            <button type="submit"><i class="fa-solid fa-xmark"></i> Remove</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- ADD AFTER PHOTO — repeatable, only once a before exists. Posts to team.jobs.after (accumulates, does NOT complete). --}}
                                    @if($hasBefore)
                                        <div class="aj-section-lbl">{{ $hasAfter ? 'Add another after photo' : 'Step 2 — After photo' }}</div>
                                        <form action="{{ route('team.jobs.after', $stop->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="after_lat"      id="latafter{{ $stop->id }}">
                                            <input type="hidden" name="after_lng"      id="lngafter{{ $stop->id }}">
                                            <input type="hidden" name="after_accuracy" id="accafter{{ $stop->id }}">

                                            <input type="file" accept="image/*" name="proof_photo"
                                                   id="fileafter{{ $stop->id }}"
                                                   onchange="ajCapture('after{{ $stop->id }}', this)" hidden required>
                                            <div class="aj-pick-row">
                                                <button type="button" class="aj-cam-btn" onclick="ajPick('fileafter{{ $stop->id }}', true)">
                                                    <i class="fa-solid fa-camera"></i> Camera
                                                </button>
                                                <button type="button" class="aj-cam-btn aj-gal-btn" onclick="ajPick('fileafter{{ $stop->id }}', false)">
                                                    <i class="fa-solid fa-images"></i> Gallery
                                                </button>
                                            </div>
                                            <img id="prevafter{{ $stop->id }}" class="aj-preview" hidden alt="">
                                            <div id="geoafter{{ $stop->id }}" class="aj-geo" hidden></div>
                                            <button type="submit" id="submitafter{{ $stop->id }}" class="aj-add-btn" disabled>
                                                <i class="fa-solid fa-plus"></i> Save After Photo
                                            </button>
                                        </form>
                                    @endif

                                    {{-- COMPLETE JOB — separate explicit action. Only when >=1 before AND >=1 after exist. --}}
                                    @if($hasBefore && $hasAfter)
                                        <form action="{{ route('team.jobs.complete', $stop->id) }}" method="POST"
                                              onsubmit="return confirm('Mark this job complete? You can still Undo it afterwards.')">
                                            @csrf
                                            <button type="submit" class="aj-complete-btn">
                                                <i class="fa-solid fa-check"></i> Complete Job ({{ count($befores) }} before, {{ count($afters) }} after)
                                            </button>
                                        </form>
                                    @elseif($hasBefore)
                                        <div class="aj-gate-note">Add at least one after photo to complete this job.</div>
                                    @endif

                                @endif

                            </div>
                        </div>

                    @empty
                        <div class="aj-empty"><i class="fa-solid fa-clipboard-check"></i> No jobs scheduled for this week.</div>
                    @endforelse

                </div>

            </main>
        </div>
    </div>

    {{-- LIGHTBOX --}}
    <div id="ajLightbox" onclick="ajClose()" style="position:fixed;inset:0;background:rgba(0,0,0,.85);display:none;align-items:center;justify-content:center;z-index:99999;padding:20px;">
        <span style="position:absolute;top:22px;right:28px;color:#fff;font-size:34px;cursor:pointer;line-height:1;">&times;</span>
        <img id="ajLightboxImg" src="" alt="Proof full size" style="max-width:92%;max-height:88%;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,.5);">
    </div>

    <script>
        /*
          One photo per submit. Each capture requests its OWN fresh GPS fix, so every
          stored photo carries the coordinates where THAT photo was taken.
          prefix = 'before123' / 'after123'; ids are role+prefix (prev/submit/geo/lat/lng/acc).
        */
        // Camera = open the back camera directly; Gallery = normal file picker (browse existing photos).
        // Same input either way, so the form/upload logic is unchanged.
        function ajPick(inputId, useCamera){
            var input = document.getElementById(inputId);
            if(useCamera) input.setAttribute('capture', 'environment');
            else          input.removeAttribute('capture');
            input.click();
        }

        function ajCapture(prefix, input){
            var file = input.files && input.files[0];
            if(!file) return;

            var img = document.getElementById('prev' + prefix);
            var reader = new FileReader();
            reader.onload = function(e){ img.src = e.target.result; img.hidden = false; };
            reader.readAsDataURL(file);

            ajGeo(prefix);
        }

        function ajGeo(prefix){
            var box = document.getElementById('geo' + prefix);
            var btn = document.getElementById('submit' + prefix);
            box.hidden = false;
            btn.disabled = true;

            if(!navigator.geolocation){
                ajGeoMsg(box, 'err', '<i class="fa-solid fa-triangle-exclamation"></i> Location not supported on this device.', prefix);
                return;
            }

            ajGeoMsg(box, 'wait', '<i class="fa-solid fa-location-crosshairs fa-spin"></i> Getting location…', null);

            navigator.geolocation.getCurrentPosition(
                function(pos){
                    document.getElementById('lat' + prefix).value = pos.coords.latitude;
                    document.getElementById('lng' + prefix).value = pos.coords.longitude;
                    document.getElementById('acc' + prefix).value = pos.coords.accuracy;
                    ajGeoMsg(box, 'ok', '<i class="fa-solid fa-location-dot"></i> Location captured (&plusmn;' + Math.round(pos.coords.accuracy) + ' m)', null);
                    btn.disabled = false;
                },
                function(err){
                    var msg = 'Location failed.';
                    if(err.code === 1)      msg = 'Location permission denied — allow it to submit.';
                    else if(err.code === 2) msg = 'Location unavailable. Move outdoors, then retry.';
                    else if(err.code === 3) msg = 'Location timed out. Retry.';
                    ajGeoMsg(box, 'err', '<i class="fa-solid fa-triangle-exclamation"></i> ' + msg, prefix);
                    btn.disabled = true;
                },
                { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
            );
        }

        function ajGeoMsg(box, state, html, retryPrefix){
            box.className = 'aj-geo aj-geo-' + state;
            box.innerHTML = html;
            if(retryPrefix){
                box.innerHTML += '<button type="button" class="aj-geo-retry" onclick="ajGeo(\'' + retryPrefix + '\')">Retry</button>';
            }
        }

        function ajOpen(src){ document.getElementById('ajLightboxImg').src = src; document.getElementById('ajLightbox').style.display = 'flex'; }
        function ajClose(){ document.getElementById('ajLightbox').style.display = 'none'; }
        document.addEventListener('keydown', function(e){ if(e.key === 'Escape') ajClose(); });
    </script>

    <script>
        (function(){
            const burger = document.getElementById('tbBurger');
            const nav    = document.getElementById('tbNav');
            if(!burger || !nav) return;
            function close(){ nav.classList.remove('tb-open'); burger.setAttribute('aria-expanded','false'); burger.querySelector('i').className = 'fa-solid fa-bars'; }
            burger.addEventListener('click', function(e){ e.stopPropagation(); const open = nav.classList.toggle('tb-open'); burger.setAttribute('aria-expanded', open ? 'true' : 'false'); burger.querySelector('i').className = open ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'; });
            document.addEventListener('click', function(e){ if(nav.classList.contains('tb-open') && !nav.contains(e.target) && !burger.contains(e.target)){ close(); } });
            document.addEventListener('keydown', function(e){ if(e.key === 'Escape' && nav.classList.contains('tb-open')) close(); });
        })();
    </script>

</x-layout>