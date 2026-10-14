<x-layout>
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .wk-toolbar{
            display:flex;
            flex-wrap:wrap;
            align-items:center;
            gap:14px;
            margin:10px 0 20px;
        }

        .wk-range{
            font-size:14px;
            color:#1B3A2A;
            font-weight:600;
            background:#e6f4ea;
            padding:8px 14px;
            border-radius:8px;
        }

        .wk-toolbar form{
            display:flex;
            gap:10px;
            align-items:center;
            margin:0;
        }

        .wk-toolbar input[type=date]{
            padding:9px;
            border:1px solid #ddd;
            border-radius:8px;
        }

        .wk-go{
            background:#1B3A2A;
            color:#fff;
            border:none;
            padding:9px 16px;
            border-radius:8px;
            cursor:pointer;
            font-weight:600;
        } .wk-go:hover{ background:#15301f; }

        .wk-team{
            background:#fff;
            border-radius:12px;
            margin-bottom:18px;
            box-shadow:rgba(0,0,0,0.12) 0px 1px 3px, rgba(0,0,0,0.24) 0px 1px 2px;
            overflow:hidden;
        }

        .wk-team-head{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:16px 22px;
            background:#1B3A2A;
            color:#fff;
        }

        .wk-team-name{ font-size:17px; font-weight:700; }

        .wk-progress{
            font-size:13px;
            background:rgba(255,255,255,.15);
            padding:5px 14px;
            border-radius:20px;
            font-weight:600;
        }

        .wk-body{ padding:16px 22px; overflow-x:auto; }

        .wk-table{
            width:100%;
            min-width:1320px;
            border-collapse:collapse;
        }

        .wk-table th, .wk-table td{
            padding:11px 12px;
            text-align:left;
            border-bottom:1px solid #eee;
            font-size:14px;
            vertical-align:middle;
        }

        .wk-table th{
            background:#f4f6f5;
            color:#1B3A2A;
            font-weight:700;
        }

        .wk-stop{
            display:inline-block;
            min-width:26px;
            text-align:center;
            background:#1B3A2A;
            color:#fff;
            border-radius:50%;
            padding:4px 0;
            font-size:12px;
            font-weight:700;
        }

        .wk-status{
            display:inline-block;
            padding:4px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
        }  .wk-status-pending{ background:#fef3c7; color:#92400e; }
        .wk-status-completed{ background:#d1fae5; color:#065f46; }
        .wk-status-skipped{ background:#fee2e2; color:#991b1b; }
        .wk-status-progress{ background:#e6f4ea; color:#166534; }   /* NEW: in-progress (before taken, after pending) */

        /* ===== BEFORE / AFTER PROOF COLUMN ===== */
        .wk-ba{
            display:flex;
            gap:14px;
            align-items:flex-start;
        }

        .wk-ba-item{
            display:flex;
            flex-direction:column;
            gap:4px;
            align-items:flex-start;
        }

        .wk-ba-label{
            font-size:10px;
            font-weight:700;
            letter-spacing:.4px;
            text-transform:uppercase;
        }

        .wk-ba-label.before{ color:#b45309; }   /* amber = before */
        .wk-ba-label.after{ color:#065f46; }     /* green = after  */

        .wk-ba-thumb{
            width:46px;
            height:46px;
            border-radius:8px;
            object-fit:cover;
            border:1px solid #ddd;
            cursor:pointer;
            transition:.15s;
            flex:0 0 auto;
        }

        .wk-ba-thumb:hover{
            transform:scale(1.06);
            border-color:#1B3A2A;
        }

        .wk-ba-time{
            font-size:10.5px;
            color:#065f46;
            font-weight:600;
            line-height:1.3;
            white-space:nowrap;
        }

        /* ===== GPS LOCATION PROOF (map link + accuracy) ===== */
        .wk-ba-map{
            display:inline-flex;
            align-items:center;
            gap:4px;
            font-size:10.5px;
            font-weight:600;
            color:#2563eb;
            text-decoration:none;
            white-space:nowrap;
        }

        .wk-ba-map:hover{ text-decoration:underline; }

        .wk-ba-acc{
            font-size:9.5px;
            color:#6b7280;
            white-space:nowrap;
        }

        /* ===== MULTI-PHOTO GALLERY (many before/after per stop) ===== */
        .wk-gal{ display:flex; gap:16px; align-items:flex-start; }
        .wk-gal-col{ display:flex; flex-direction:column; gap:5px; }
        .wk-gal-head{ font-size:10px; font-weight:700; letter-spacing:.4px; text-transform:uppercase; }
        .wk-gal-head.before{ color:#b45309; }
        .wk-gal-head.after{ color:#065f46; }
        .wk-gal-strip{ display:flex; gap:6px; flex-wrap:wrap; max-width:300px; }
        .wk-gitem{ display:flex; flex-direction:column; gap:2px; align-items:flex-start; width:60px; }
        .wk-gimg{ width:60px; height:60px; object-fit:cover; border-radius:8px; border:1px solid #ddd; cursor:pointer; transition:.15s; }
        .wk-gimg:hover{ transform:scale(1.07); border-color:#1B3A2A; }
        .wk-gmap{ display:inline-flex; align-items:center; gap:2px; font-size:9px; font-weight:600; color:#2563eb; text-decoration:none; white-space:nowrap; }
        .wk-gmap:hover{ text-decoration:underline; }
        .wk-gtime{ font-size:8.5px; color:#6b7280; white-space:nowrap; line-height:1.2; }
        .wk-gnogps{ font-size:8.5px; color:#9ca3af; font-style:italic; }

        .wk-ba-nogps{
            font-size:9.5px;
            color:#9ca3af;
            font-style:italic;
            white-space:nowrap;
        }

        .wk-ba-none{
            font-size:12px;
            color:#9ca3af;
            font-style:italic;
        }
 .wk-actions{ display:flex; gap:6px; }
        .wk-actions form{ margin:0; }

        .wk-act{
            border:none;
            cursor:pointer;
            padding:6px 10px;
            border-radius:7px;
            font-size:12px;
            color:#fff;
            display:inline-flex;
            align-items:center;
            gap:4px;
        }

        .wk-act-done{ background:#16a34a; }
        .wk-act-done:hover{ background:#15803d; }
        .wk-act-undo{ background:#6b7280; }
        .wk-act-undo:hover{ background:#4b5563; }
        .wk-act-skip{ background:#dc2626; }
        .wk-act-skip:hover{ background:#b91c1c; }

        .wk-empty{ padding:14px; color:#777; font-style:italic; }

        .no-teams{
            background:#fff;
            padding:30px;
            border-radius:12px;
            text-align:center;
            color:#777;
            box-shadow:0 8px 22px rgba(0,0,0,.08);
        }

        /* ===== LIGHTBOX (pure CSS/JS, no library) ===== */
        .wk-lightbox{
            position:fixed;
            inset:0;
            background:rgba(0,0,0,.85);
            display:none;
            align-items:center;
            justify-content:center;
            z-index:99999;
            padding:20px;
        }
        .wk-lightbox.active{ display:flex; }
        .wk-lightbox img{
            max-width:92%;
            max-height:88%;
            border-radius:12px;
            box-shadow:0 20px 60px rgba(0,0,0,.5);
        }
        .wk-lightbox-close{
            position:absolute;
            top:22px;
            right:28px;
            color:#fff;
            font-size:34px;
            cursor:pointer;
            line-height:1;
        }
    </style> <x-sidebar />

    <div class="main" id="mainContent">

        <div class="header">
            <div class="menu-btn" onclick="openSidebar()">☰</div>
            <h1>Weekly Routes</h1>
        </div>

        @if(session('success'))
            <div style="background:#d1fae5;color:#065f46;padding:12px;border-radius:8px;margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="wk-toolbar">
            <span class="wk-range">
                {{ $weekStart->format('M d') }} — {{ $weekEnd->format('M d, Y') }}
            </span>

            <form action="{{ route('routes.board') }}" method="GET">
                <input type="date" name="date" value="{{ $dateInput }}">
                <button type="submit" class="wk-go">View Week</button>
            </form>
        </div>  @forelse($teams as $team)

            <div class="wk-team">

                <div class="wk-team-head">
                    <span class="wk-team-name">{{ $team->name }}</span>
                    <span class="wk-progress">
                        {{ $team->done_stops }} / {{ $team->total_stops }} completed
                    </span>
                </div>

                <div class="wk-body">

                    @if($team->stops->count())

                        <table class="wk-table">
                            <thead>
                                <tr>
                                    <th>Stop</th>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Before / After Proof</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($team->stops as $stop)
                                    @php
                                        $quote     = $stop->assignment?->quote;
                                        // before_photo / proof_photo are JSON arrays (model $casts => 'array').
                                        $befores   = $stop->before_photo ?? [];
                                        $afters    = $stop->proof_photo ?? [];
                                        $hasBefore = count($befores) > 0;
                                        $hasAfter  = count($afters) > 0;

                                        // Display status (Option B: in-progress inferred from photos, no new DB status)
                                        if ($stop->status === 'completed') {
                                            $dispLabel = 'Completed'; $dispClass = 'completed';
                                        } elseif ($stop->status === 'skipped') {
                                            $dispLabel = 'Skipped';   $dispClass = 'skipped';
                                        } elseif ($hasBefore && !$hasAfter) {
                                            $dispLabel = 'In Progress'; $dispClass = 'progress';
                                        } else {
                                            $dispLabel = 'Pending';   $dispClass = 'pending';
                                        }
                                    @endphp <tr>
                                        <td><span class="wk-stop">{{ $stop->stop_order }}</span></td>
                                        <td>{{ \Carbon\Carbon::parse($stop->service_date)->format('D, M d') }}</td>
                                        <td>{{ $quote->client_name ?? ('Quote #'.($quote->id ?? '?')) }}</td>
                                        <td>{{ $quote->client_address ?? '—' }}</td>

                                        <td>
                                            <span class="wk-status wk-status-{{ $dispClass }}">
                                                {{ $dispLabel }}
                                            </span>
                                        </td>

                                        {{-- BEFORE / AFTER PROOF: multi-photo galleries, each photo with its own GPS + time --}}
                                        <td>
                                            @if($hasBefore || $hasAfter)
                                                <div class="wk-gal">
                                                    {{-- BEFORE column --}}
                                                    <div class="wk-gal-col">
                                                        <span class="wk-gal-head before">Before ({{ count($befores) }})</span>
                                                        @if($hasBefore)
                                                            <div class="wk-gal-strip">
                                                                @foreach($befores as $bp)
                                                                    <div class="wk-gitem">
                                                                        <img src="{{ asset('storage/app/public/'.$bp['path']) }}" class="wk-gimg" alt="Before" onclick="wkOpenProof('{{ asset('storage/app/public/'.$bp['path']) }}')">
                                                                        @if(!empty($bp['lat']) && !empty($bp['lng']))
                                                                            <a href="https://www.google.com/maps?q={{ $bp['lat'] }},{{ $bp['lng'] }}" target="_blank" rel="noopener" class="wk-gmap" title="{{ $bp['lat'] }}, {{ $bp['lng'] }}">
                                                                                <i class="fa-solid fa-location-dot"></i> {{ isset($bp['accuracy']) ? '±'.round($bp['accuracy']).'m' : 'Map' }}
                                                                            </a>
                                                                        @else
                                                                            <span class="wk-gnogps">No GPS</span>
                                                                        @endif
                                                                        <span class="wk-gtime">{{ !empty($bp['taken_at']) ? \Carbon\Carbon::parse($bp['taken_at'])->format('M d g:iA') : '' }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <span class="wk-ba-none">—</span>
                                                        @endif
                                                    </div>

                                                    {{-- AFTER column --}}
                                                    <div class="wk-gal-col">
                                                        <span class="wk-gal-head after">After ({{ count($afters) }})</span>
                                                        @if($hasAfter)
                                                            <div class="wk-gal-strip">
                                                                @foreach($afters as $ap)
                                                                    <div class="wk-gitem">
                                                                        <img src="{{ asset('storage/app/public/'.$ap['path']) }}" class="wk-gimg" alt="After" onclick="wkOpenProof('{{ asset('storage/app/public/'.$ap['path']) }}')">
                                                                        @if(!empty($ap['lat']) && !empty($ap['lng']))
                                                                            <a href="https://www.google.com/maps?q={{ $ap['lat'] }},{{ $ap['lng'] }}" target="_blank" rel="noopener" class="wk-gmap" title="{{ $ap['lat'] }}, {{ $ap['lng'] }}">
                                                                                <i class="fa-solid fa-location-dot"></i> {{ isset($ap['accuracy']) ? '±'.round($ap['accuracy']).'m' : 'Map' }}
                                                                            </a>
                                                                        @else
                                                                            <span class="wk-gnogps">No GPS</span>
                                                                        @endif
                                                                        <span class="wk-gtime">{{ !empty($ap['taken_at']) ? \Carbon\Carbon::parse($ap['taken_at'])->format('M d g:iA') : '' }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <span class="wk-ba-none">—</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="wk-ba-none">No photos</span>
                                            @endif
                                        </td>   <td>
                                            <div class="wk-actions">

                                                @if($stop->status !== 'completed')
                                                    <form action="{{ route('schedule.status', $stop->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="wk-act wk-act-done">
                                                            <i class="fa-solid fa-check"></i> Done
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('schedule.status', $stop->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="pending">
                                                        <button type="submit" class="wk-act wk-act-undo">
                                                            <i class="fa-solid fa-rotate-left"></i> Undo
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($stop->status !== 'skipped')
                                                    <form action="{{ route('schedule.status', $stop->id) }}" method="POST"
                                                          onsubmit="return confirm('Mark this stop as skipped?')">
                                                        @csrf
                                                        <input type="hidden" name="status" value="skipped">
                                                        <button type="submit" class="wk-act wk-act-skip">
                                                            <i class="fa-solid fa-xmark"></i> Skip
                                                        </button>
                                                    </form>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>  @else
                        <div class="wk-empty">No stops scheduled for this team this week.</div>
                    @endif

                </div>

            </div>

        @empty
            <div class="no-teams">No teams found.</div>
        @endforelse

    </div>

    {{-- LIGHTBOX (single instance, reused for before + after thumbnails) --}}
    <div class="wk-lightbox" id="wkLightbox" onclick="wkCloseProof()">
        <span class="wk-lightbox-close">&times;</span>
        <img id="wkLightboxImg" src="" alt="Proof photo full size">
    </div> <script>
        function openSidebar(){
            document.getElementById("sidebar").classList.add("active");
        }
        function closeSidebar(){
            document.getElementById("sidebar").classList.remove("active");
        }
        document.addEventListener("click", function(e){
            let sidebar = document.getElementById("sidebar");
            let menu = document.querySelector(".menu-btn");
            if(sidebar.classList.contains("active") && !sidebar.contains(e.target) && !menu.contains(e.target)){
                sidebar.classList.remove("active");
            }
        });

        // Proof lightbox: click any thumbnail -> full-size overlay
        function wkOpenProof(src){
            var box = document.getElementById("wkLightbox");
            document.getElementById("wkLightboxImg").src = src;
            box.classList.add("active");
        }
        function wkCloseProof(){
            document.getElementById("wkLightbox").classList.remove("active");
        }
        document.addEventListener("keydown", function(e){
            if(e.key === "Escape") wkCloseProof();
        });
    </script>

</x-layout>