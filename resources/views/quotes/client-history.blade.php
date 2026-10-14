<x-layout>
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .ch-back{
            display:inline-flex;
            align-items:center;
            gap:6px;
            color:#1B3A2A;
            text-decoration:none;
            font-weight:600;
            font-size:14px;
            margin-bottom:16px;
        }
        .ch-back:hover{ text-decoration:underline; }

        /* client card — accent bar + layout */
        .ch-client-card{
            position:relative;
            background:linear-gradient(135deg,#1B3A2A 0%,#14281d 100%);
            color:#fff;
            border-radius:14px;
            padding:24px 28px;
            margin-bottom:20px;
            overflow:hidden;
        }
        .ch-client-card::before{
            content:"";
            position:absolute;
            left:0;top:0;bottom:0;
            width:5px;
            background:#b6e44f;
        }
        .ch-client-name{ font-size:23px; font-weight:700; margin-bottom:10px; }
        .ch-client-meta{ font-size:14px; opacity:.9; line-height:1.9; }
        .ch-client-meta i{ width:16px; color:#b6e44f; margin-right:4px; }
  /* stats */
        .ch-stats{
            display:flex;
            flex-wrap:wrap;
            gap:14px;
            margin-bottom:20px;
        }
        .ch-stat{
            flex:1;
            min-width:120px;
            background:#fff;
            border-radius:12px;
            padding:16px 18px;
            box-shadow:rgba(0,0,0,0.12) 0px 1px 3px, rgba(0,0,0,0.24) 0px 1px 2px;
        }
        .ch-stat-num{ font-size:24px; font-weight:700; color:#1B3A2A; line-height:1; }
        .ch-stat-label{ font-size:12px; color:#777; margin-top:5px; }

        /* timeline */
        .ch-timeline{
            background:#fff;
            border-radius:12px;
            padding:24px 28px;
            box-shadow:rgba(0,0,0,0.12) 0px 1px 3px, rgba(0,0,0,0.24) 0px 1px 2px;
        }
        .ch-timeline h3{ color:#1B3A2A; margin-bottom:22px; font-size:16px; }

        /* continuous connector line running down the left of the rows */
        .ch-track{
            position:relative;
            padding-left:30px;
        }
        .ch-track::before{
            content:"";
            position:absolute;
            left:5px;top:6px;bottom:6px;
            width:2px;
            background:#e5e7eb;
        }

        .ch-row{
            position:relative;
            display:flex;
            align-items:flex-start;
            gap:16px;
            padding:14px 16px;
            margin-bottom:12px;
            background:#fafafa;
            border:1px solid #eee;
            border-radius:12px;
        }
        .ch-row:last-child{ margin-bottom:0; }

        /* status dot sitting ON the connector line */
        .ch-dot{
            position:absolute;
            left:-30px;
            top:22px;
            width:12px;
            height:12px;
            border-radius:50%;
            border:2px solid #fff;
            box-shadow:0 0 0 2px #e5e7eb;
        } .ch-dot-completed{ background:#16a34a; }
        .ch-dot-pending{ background:#f59e0b; }
        .ch-dot-skipped{ background:#dc2626; }

        .ch-row-main{ flex:1; min-width:0; }
        .ch-row-date{ font-weight:600; color:#1B3A2A; font-size:14px; }
        .ch-row-stop{ color:#777; font-size:12.5px; margin-top:3px; }

        .ch-status{
            display:inline-block;
            padding:4px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
            flex:0 0 auto;
        }
        .ch-status-pending{ background:#fef3c7; color:#92400e; }
        .ch-status-completed{ background:#d1fae5; color:#065f46; }
        .ch-status-skipped{ background:#fee2e2; color:#991b1b; }

        /* ===== BEFORE / AFTER PROOF BLOCK (inside a completed row) ===== */
        .ch-ba{
            display:flex;
            gap:18px;
            flex-wrap:wrap;
            margin-top:12px;
            padding-top:12px;
            border-top:1px dashed #e0e0e0;
        }
        .ch-ba-item{
            display:flex;
            flex-direction:column;
            gap:5px;
            align-items:flex-start;
        }
        .ch-ba-label{
            font-size:10px;
            font-weight:700;
            letter-spacing:.4px;
            text-transform:uppercase;
        }
        .ch-ba-label.before{ color:#b45309; }
        .ch-ba-label.after{ color:#065f46; }
        .ch-ba-thumb{
            width:80px;
            height:80px;
            border-radius:10px;
            object-fit:cover;
            border:1px solid #ddd;
            cursor:pointer;
            transition:.15s;
        } .ch-ba-thumb:hover{
            transform:scale(1.04);
            border-color:#1B3A2A;
        }
        .ch-ba-time{
            font-size:11px;
            color:#065f46;
            font-weight:600;
            line-height:1.4;
        }

        /* ===== GPS LOCATION PROOF (map link + accuracy) ===== */
        .ch-ba-map{
            display:inline-flex;
            align-items:center;
            gap:4px;
            font-size:11px;
            font-weight:600;
            color:#2563eb;
            text-decoration:none;
            white-space:nowrap;
        }
        .ch-ba-map:hover{ text-decoration:underline; }
        .ch-ba-acc{
            font-size:10px;
            color:#6b7280;
            white-space:nowrap;
        }
        .ch-ba-nogps{
            font-size:10px;
            color:#9ca3af;
            font-style:italic;
            white-space:nowrap;
        }
        /* ===== MULTI-PHOTO GALLERY (many before/after per completed visit) ===== */
        .ch-gal{ display:flex; gap:22px; flex-wrap:wrap; margin-top:12px; padding-top:12px; border-top:1px dashed #e0e0e0; }
        .ch-gal-col{ display:flex; flex-direction:column; gap:6px; }
        .ch-gal-head{ font-size:10px; font-weight:700; letter-spacing:.4px; text-transform:uppercase; }
        .ch-gal-head.before{ color:#b45309; }
        .ch-gal-head.after{ color:#065f46; }
        .ch-gal-strip{ display:flex; gap:8px; flex-wrap:wrap; max-width:420px; }
        .ch-gitem{ display:flex; flex-direction:column; gap:3px; align-items:flex-start; width:78px; }
        .ch-gimg{ width:78px; height:78px; object-fit:cover; border-radius:9px; border:1px solid #ddd; cursor:pointer; transition:.15s; }
        .ch-gimg:hover{ transform:scale(1.05); border-color:#1B3A2A; }
        .ch-gmap{ display:inline-flex; align-items:center; gap:3px; font-size:9.5px; font-weight:600; color:#2563eb; text-decoration:none; white-space:nowrap; }
        .ch-gmap:hover{ text-decoration:underline; }
        .ch-gtime{ font-size:9px; color:#6b7280; white-space:nowrap; line-height:1.3; }
        .ch-gnogps{ font-size:9px; color:#9ca3af; font-style:italic; }

        .ch-ba-none{ font-size:12px; color:#9ca3af; font-style:italic; }

        .ch-proof-note-line{
            font-size:11px;
            color:#9ca3af;
            margin-top:8px;
        }

        .ch-empty{ padding:20px; text-align:center; color:#777; font-style:italic; }

        /* lightbox (pure JS, no library) */
        .ch-lightbox{
            position:fixed;
            inset:0;
            background:rgba(0,0,0,.85);
            display:none;
            align-items:center;
            justify-content:center;
            z-index:99999;
            padding:20px;
        }
        .ch-lightbox.active{ display:flex; }
        .ch-lightbox img{
            max-width:92%;
            max-height:88%;
            border-radius:12px;
            box-shadow:0 20px 60px rgba(0,0,0,.5);
        } .ch-lightbox-close{
            position:absolute;
            top:22px;right:28px;
            color:#fff;font-size:34px;
            cursor:pointer;line-height:1;
        }
    </style>

    <x-sidebar />

    <div class="main" id="mainContent">

        <div class="header">
            <div class="menu-btn" onclick="openSidebar()">☰</div>
            <h1>Client History</h1>
        </div>

        <a href="{{ route('jobs.history') }}" class="ch-back">
            <i class="fa-solid fa-arrow-left"></i> Back to Job History
        </a>

        {{-- client card --}}
        <div class="ch-client-card">
            <div class="ch-client-name">
                {{ $assignment->quote->client_name ?? ('Quote #'.($assignment->quote->id ?? '?')) }}
            </div>
            <div class="ch-client-meta">
                <div><i class="fa-solid fa-location-dot"></i> {{ $assignment->quote->client_address ?? '—' }}</div>
                <div><i class="fa-solid fa-users"></i> Team: {{ $assignment->team->name ?? '—' }}</div>
                <div><i class="fa-solid fa-calendar-check"></i> Assigned: {{ $assignment->assigned_at ? \Carbon\Carbon::parse($assignment->assigned_at)->format('M d, Y') : '—' }}</div>
            </div>
        </div> {{-- stats (+ completion rate) --}}
        @php
            // completion rate = completed / total * 100, guarded against divide-by-zero
            $chRate = $counts['total'] > 0
                ? round(($counts['completed'] / $counts['total']) * 100)
                : 0;
        @endphp
        <div class="ch-stats">
            <div class="ch-stat">
                <div class="ch-stat-num">{{ $counts['total'] }}</div>
                <div class="ch-stat-label">Total Visits</div>
            </div>
            <div class="ch-stat">
                <div class="ch-stat-num" style="color:#065f46;">{{ $counts['completed'] }}</div>
                <div class="ch-stat-label">Completed</div>
            </div>
            <div class="ch-stat">
                <div class="ch-stat-num" style="color:#92400e;">{{ $counts['pending'] }}</div>
                <div class="ch-stat-label">Pending</div>
            </div>
            <div class="ch-stat">
                <div class="ch-stat-num" style="color:#991b1b;">{{ $counts['skipped'] }}</div>
                <div class="ch-stat-label">Skipped</div>
            </div>
            <div class="ch-stat">
                <div class="ch-stat-num" style="color:#1B3A2A;">{{ $chRate }}%</div>
                <div class="ch-stat-label">Completion Rate</div>
            </div>
        </div>{{-- timeline --}}
        <div class="ch-timeline">
            <h3>Visit Timeline</h3>

            @if($schedules->count())

                <div class="ch-track">
                    @foreach($schedules as $s)
                        @php
                            // before_photo / proof_photo are JSON arrays (model $casts => 'array').
                            $befores   = $s->before_photo ?? [];
                            $afters    = $s->proof_photo ?? [];
                            $hasBefore = count($befores) > 0;
                            $hasAfter  = count($afters) > 0;
                        @endphp
                        <div class="ch-row">
                            <span class="ch-dot ch-dot-{{ $s->status }}"></span>

                            <div class="ch-row-main">
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <div style="flex:1; min-width:0;">
                                        <div class="ch-row-date">
                                            {{ \Carbon\Carbon::parse($s->service_date)->format('D, M d, Y') }}
                                        </div>
                                        <div class="ch-row-stop">Stop #{{ $s->stop_order ?? '—' }}</div>
                                    </div>
                                    <span class="ch-status ch-status-{{ $s->status }}">{{ ucfirst($s->status) }}</span>
                                </div> {{-- BEFORE / AFTER PROOF: only completed visits carry photos --}}
                                @if($s->status === 'completed')
                                    @if($hasBefore || $hasAfter)
                                        <div class="ch-gal">
                                            {{-- BEFORE column --}}
                                            <div class="ch-gal-col">
                                                <span class="ch-gal-head before"><i class="fa-solid fa-play"></i> Before ({{ count($befores) }})</span>
                                                @if($hasBefore)
                                                    <div class="ch-gal-strip">
                                                        @foreach($befores as $bp)
                                                            <div class="ch-gitem">
                                                                <img src="{{ asset('storage/app/public/'.$bp['path']) }}" class="ch-gimg" alt="Before" onclick="chOpenProof('{{ asset('storage/app/public/'.$bp['path']) }}')">
                                                                @if(!empty($bp['lat']) && !empty($bp['lng']))
                                                                    <a href="https://www.google.com/maps?q={{ $bp['lat'] }},{{ $bp['lng'] }}" target="_blank" rel="noopener" class="ch-gmap" title="{{ $bp['lat'] }}, {{ $bp['lng'] }}">
                                                                        <i class="fa-solid fa-location-dot"></i> {{ isset($bp['accuracy']) ? '±'.round($bp['accuracy']).'m' : 'Map' }}
                                                                    </a>
                                                                @else
                                                                    <span class="ch-gnogps">No GPS</span>
                                                                @endif
                                                                <span class="ch-gtime">{{ !empty($bp['taken_at']) ? \Carbon\Carbon::parse($bp['taken_at'])->format('M d, g:iA') : '' }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="ch-ba-none">—</span>
                                                @endif
                                            </div>

                                            {{-- AFTER column --}}
                                            <div class="ch-gal-col">
                                                <span class="ch-gal-head after"><i class="fa-solid fa-circle-check"></i> After ({{ count($afters) }})</span>
                                                @if($hasAfter)
                                                    <div class="ch-gal-strip">
                                                        @foreach($afters as $ap)
                                                            <div class="ch-gitem">
                                                                <img src="{{ asset('storage/app/public/'.$ap['path']) }}" class="ch-gimg" alt="After" onclick="chOpenProof('{{ asset('storage/app/public/'.$ap['path']) }}')">
                                                                @if(!empty($ap['lat']) && !empty($ap['lng']))
                                                                    <a href="https://www.google.com/maps?q={{ $ap['lat'] }},{{ $ap['lng'] }}" target="_blank" rel="noopener" class="ch-gmap" title="{{ $ap['lat'] }}, {{ $ap['lng'] }}">
                                                                        <i class="fa-solid fa-location-dot"></i> {{ isset($ap['accuracy']) ? '±'.round($ap['accuracy']).'m' : 'Map' }}
                                                                    </a>
                                                                @else
                                                                    <span class="ch-gnogps">No GPS</span>
                                                                @endif
                                                                <span class="ch-gtime">{{ !empty($ap['taken_at']) ? \Carbon\Carbon::parse($ap['taken_at'])->format('M d, g:iA') : '' }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="ch-ba-none">—</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ch-proof-note-line">Server-recorded times (Vancouver) &amp; per-photo GPS proof.</div>
                                    @else
                                        <div class="ch-proof-note-line">Marked complete without photo proof.</div>
                                    @endif
                                @endif   </div>
                        </div>
                    @endforeach
                </div>

            @else
                <div class="ch-empty">No visit history for this client yet.</div>
            @endif

        </div>

    </div>

    {{-- LIGHTBOX (single instance, reused for before + after) --}}
    <div class="ch-lightbox" id="chLightbox" onclick="chCloseProof()">
        <span class="ch-lightbox-close">&times;</span>
        <img id="chLightboxImg" src="" alt="Proof photo full size">
    </div> <script>
        function openSidebar(){ document.getElementById("sidebar").classList.add("active"); }
        function closeSidebar(){ document.getElementById("sidebar").classList.remove("active"); }
        document.addEventListener("click", function(e){
            let sidebar = document.getElementById("sidebar");
            let menu = document.querySelector(".menu-btn");
            if(sidebar.classList.contains("active") && !sidebar.contains(e.target) && !menu.contains(e.target)){
                sidebar.classList.remove("active");
            }
        });

        // Proof lightbox: click any thumbnail -> full-size overlay
        function chOpenProof(src){
            document.getElementById("chLightboxImg").src = src;
            document.getElementById("chLightbox").classList.add("active");
        }
        function chCloseProof(){
            document.getElementById("chLightbox").classList.remove("active");
        }
        document.addEventListener("keydown", function(e){
            if(e.key === "Escape") chCloseProof();
        });
    </script>

</x-layout>