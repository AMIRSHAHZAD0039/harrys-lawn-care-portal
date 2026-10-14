<x-layout>
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .jh-stats{
            display:flex;
            flex-wrap:wrap;
            gap:14px;
            margin:10px 0 20px;
        }

        .jh-stat{
            flex:1;
            min-width:150px;
            background:#fff;
            border-radius:12px;
            padding:18px 20px;
            box-shadow:rgba(0,0,0,0.12) 0px 1px 3px, rgba(0,0,0,0.24) 0px 1px 2px;
        }

        .jh-stat-num{ font-size:26px; font-weight:700; color:#1B3A2A; }
        .jh-stat-label{ font-size:13px; color:#777; margin-top:3px; }

        .jh-filters{
            background:#fff;
            border-radius:12px;
            padding:18px 20px;
            margin-bottom:20px;
            box-shadow:rgba(0,0,0,0.12) 0px 1px 3px, rgba(0,0,0,0.24) 0px 1px 2px;
        }
        .jh-filters form{
            display:flex;
            flex-wrap:wrap;
            gap:14px;
            align-items:flex-end;
            margin:0;
        }

        .jh-fg{ display:flex; flex-direction:column; gap:5px; }
        .jh-fg label{ font-size:13px; font-weight:600; color:#1B3A2A; }

        .jh-fg select, .jh-fg input{
            padding:9px;
            border:1px solid #ddd;
            border-radius:8px;
            outline:none;
            min-width:150px;
        }

        .jh-go{
            background:#1B3A2A;
            color:#fff;
            border:none;
            padding:10px 18px;
            border-radius:8px;
            cursor:pointer;
            font-weight:600;
        }

        .jh-go:hover{ background:#15301f; }

        .jh-clear{
            background:#6b7280;
            color:#fff;
            border:none;
            padding:10px 18px;
            border-radius:8px;
            cursor:pointer;
            font-weight:600;
            text-decoration:none;
            display:inline-block;
        }

        .jh-clear:hover{ background:#4b5563; }

        .jh-table-wrap{
            background:#fff;
            border-radius:12px;
            padding:16px 20px;
            box-shadow:rgba(0,0,0,0.12) 0px 1px 3px, rgba(0,0,0,0.24) 0px 1px 2px;
            overflow-x:auto;
        }

        .jh-table{ width:100%; min-width:1420px; border-collapse:collapse; }

        .jh-table th, .jh-table td{
            padding:11px 12px;
            text-align:left;
            border-bottom:1px solid #eee;
            font-size:14px;
            vertical-align:middle;
        }.jh-table th{ background:#f4f6f5; color:#1B3A2A; font-weight:700; }
        .jh-table tr:hover td{ background:#fafafa; }

        .jh-status{
            display:inline-block;
            padding:4px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
        }

        .jh-status-pending{ background:#fef3c7; color:#92400e; }
        .jh-status-completed{ background:#d1fae5; color:#065f46; }
        .jh-status-skipped{ background:#fee2e2; color:#991b1b; }
        .jh-status-progress{ background:#e6f4ea; color:#166534; }   /* in-progress: before taken, after pending */

        /* ===== BEFORE / AFTER PROOF COLUMN ===== */
        .jh-ba{
            display:flex;
            gap:14px;
            align-items:flex-start;
        }

        .jh-ba-item{
            display:flex;
            flex-direction:column;
            gap:4px;
            align-items:flex-start;
        }

        .jh-ba-label{
            font-size:10px;
            font-weight:700;
            letter-spacing:.4px;
            text-transform:uppercase;
        }

        .jh-ba-label.before{ color:#b45309; }
        .jh-ba-label.after{ color:#065f46; }

        .jh-ba-thumb{
            width:46px;
            height:46px;
            border-radius:8px;
            object-fit:cover;
            border:1px solid #ddd;
            cursor:pointer;
            transition:.15s;
            flex:0 0 auto;
        }

        .jh-ba-thumb:hover{
            transform:scale(1.06);
            border-color:#1B3A2A;
        }

        .jh-ba-time{
            font-size:10.5px;
            color:#065f46;
            font-weight:600;
            line-height:1.3;
            white-space:nowrap;
        }

        /* ===== GPS LOCATION PROOF (map link + accuracy) ===== */
        .jh-ba-map{
            display:inline-flex;
            align-items:center;
            gap:4px;
            font-size:10.5px;
            font-weight:600;
            color:#2563eb;
            text-decoration:none;
            white-space:nowrap;
        }

        .jh-ba-map:hover{ text-decoration:underline; }

        .jh-ba-acc{
            font-size:9.5px;
            color:#6b7280;
            white-space:nowrap;
        }

        /* ===== MULTI-PHOTO GALLERY (many before/after per row) ===== */
        .jh-gal{ display:flex; gap:16px; align-items:flex-start; }
        .jh-gal-col{ display:flex; flex-direction:column; gap:5px; }
        .jh-gal-head{ font-size:10px; font-weight:700; letter-spacing:.4px; text-transform:uppercase; }
        .jh-gal-head.before{ color:#b45309; }
        .jh-gal-head.after{ color:#065f46; }
        .jh-gal-strip{ display:flex; gap:6px; flex-wrap:wrap; max-width:300px; }
        .jh-gitem{ display:flex; flex-direction:column; gap:2px; align-items:flex-start; width:60px; }
        .jh-gimg{ width:60px; height:60px; object-fit:cover; border-radius:8px; border:1px solid #ddd; cursor:pointer; transition:.15s; }
        .jh-gimg:hover{ transform:scale(1.07); border-color:#1B3A2A; }
        .jh-gmap{ display:inline-flex; align-items:center; gap:2px; font-size:9px; font-weight:600; color:#2563eb; text-decoration:none; white-space:nowrap; }
        .jh-gmap:hover{ text-decoration:underline; }
        .jh-gtime{ font-size:8.5px; color:#6b7280; white-space:nowrap; line-height:1.2; }
        .jh-gnogps{ font-size:8.5px; color:#9ca3af; font-style:italic; }

        .jh-ba-nogps{
            font-size:9.5px;
            color:#9ca3af;
            font-style:italic;
            white-space:nowrap;
        }

        .jh-ba-none{
            font-size:12px;
            color:#9ca3af;
            font-style:italic;
        }

        .jh-view{
            color:#2563eb;
            text-decoration:none;
            font-size:13px;
            font-weight:600;
        } .jh-view:hover{ text-decoration:underline; }

        .jh-empty{ padding:30px; text-align:center; color:#777; font-style:italic; }

        .jh-pagination{ margin-top:18px; }
        .jh-pagination nav > div{ flex-wrap:wrap; gap:10px; }
        .jh-pagination .pagination{ margin:0; flex-wrap:wrap; }
        .jh-pagination .page-link{ color:#1B3A2A; }
        .jh-pagination .page-link:focus{ box-shadow:0 0 0 .2rem rgba(27,58,42,.2); }
        .jh-pagination .page-item.active .page-link{ background:#1B3A2A; border-color:#1B3A2A; color:#fff; }
        .jh-pagination p.small{ margin:0; color:#5a6b60; }

        /* ===== LIGHTBOX (pure JS, no library) ===== */
        .jh-lightbox{
            position:fixed;
            inset:0;
            background:rgba(0,0,0,.85);
            display:none;
            align-items:center;
            justify-content:center;
            z-index:99999;
            padding:20px;
        }
        .jh-lightbox.active{ display:flex; }
        .jh-lightbox img{
            max-width:92%;
            max-height:88%;
            border-radius:12px;
            box-shadow:0 20px 60px rgba(0,0,0,.5);
        }
        .jh-lightbox-close{
            position:absolute;
            top:22px;
            right:28px;
            color:#fff;
            font-size:34px;
            cursor:pointer;
            line-height:1;
        }
    </style>

    <x-sidebar />
<div class="main" id="mainContent">

        <div class="header">
            <div class="menu-btn" onclick="openSidebar()">☰</div>
            <h1>Job History</h1>
        </div>

        {{-- summary cards --}}
        <div class="jh-stats">
            <div class="jh-stat">
                <div class="jh-stat-num">{{ $counts['total'] }}</div>
                <div class="jh-stat-label">Total Jobs</div>
            </div>
            <div class="jh-stat">
                <div class="jh-stat-num" style="color:#065f46;">{{ $counts['completed'] }}</div>
                <div class="jh-stat-label">Completed</div>
            </div>
            <div class="jh-stat">
                <div class="jh-stat-num" style="color:#92400e;">{{ $counts['pending'] }}</div>
                <div class="jh-stat-label">Pending</div>
            </div>
            <div class="jh-stat">
                <div class="jh-stat-num" style="color:#991b1b;">{{ $counts['skipped'] }}</div>
                <div class="jh-stat-label">Skipped</div>
            </div>
        </div>

        {{-- filters --}}
        <div class="jh-filters">
            <form action="{{ route('jobs.history') }}" method="GET">

                <div class="jh-fg">
                    <label>Status</label>
                    <select name="status">
                        <option value="">All</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="skipped" {{ request('status') == 'skipped' ? 'selected' : '' }}>Skipped</option>
                    </select>
                </div> <div class="jh-fg">
                    <label>Team</label>
                    <select name="team_id">
                        <option value="">All Teams</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="jh-fg">
                    <label>From</label>
                    <input type="date" name="from" value="{{ request('from') }}">
                </div>

                <div class="jh-fg">
                    <label>To</label>
                    <input type="date" name="to" value="{{ request('to') }}">
                </div>

                <button type="submit" class="jh-go">Filter</button>
                <a href="{{ route('jobs.history') }}" class="jh-clear">Clear</a>

            </form>
        </div>

        {{-- table --}}
        <div class="jh-table-wrap">

            @if($schedules->count())<table class="jh-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Stop</th>
                            <th>Client</th>
                            <th>Address</th>
                            <th>Team</th>
                            <th>Status</th>
                            <th>Before / After Proof</th>
                            <th>History</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $s)
                            @php
                                $quote = $s->assignment?->quote;
                                $team  = $s->assignment?->team;

                                // before_photo / proof_photo are JSON arrays (model $casts => 'array').
                                $befores   = $s->before_photo ?? [];
                                $afters    = $s->proof_photo ?? [];
                                $hasBefore = count($befores) > 0;
                                $hasAfter  = count($afters) > 0;

                                // Display status (Option B: in-progress inferred from photos, no new DB status)
                                if ($s->status === 'completed') {
                                    $dispLabel = 'Completed'; $dispClass = 'completed';
                                } elseif ($s->status === 'skipped') {
                                    $dispLabel = 'Skipped';   $dispClass = 'skipped';
                                } elseif ($hasBefore && !$hasAfter) {
                                    $dispLabel = 'In Progress'; $dispClass = 'progress';
                                } else {
                                    $dispLabel = 'Pending';   $dispClass = 'pending';
                                }
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($s->service_date)->format('M d, Y') }}</td>
                                <td>{{ $s->stop_order ?? '—' }}</td>
                                <td>{{ $quote->client_name ?? ('Quote #'.($quote->id ?? '?')) }}</td>
                                <td>{{ $quote->client_address ?? '—' }}</td>
                                <td>{{ $team->name ?? '—' }}</td>
                                <td>
                                    <span class="jh-status jh-status-{{ $dispClass }}">
                                        {{ $dispLabel }}
                                    </span>
                                </td>  {{-- BEFORE / AFTER PROOF: thumbnail + server time + GPS location proof --}}
                                <td>
                                    @if($hasBefore || $hasAfter)
                                        <div class="jh-gal">
                                            {{-- BEFORE column --}}
                                            <div class="jh-gal-col">
                                                <span class="jh-gal-head before">Before ({{ count($befores) }})</span>
                                                @if($hasBefore)
                                                    <div class="jh-gal-strip">
                                                        @foreach($befores as $bp)
                                                            <div class="jh-gitem">
                                                                <img src="{{ asset('storage/app/public/'.$bp['path']) }}" class="jh-gimg" alt="Before" onclick="jhOpenProof('{{ asset('storage/app/public/'.$bp['path']) }}')">
                                                                @if(!empty($bp['lat']) && !empty($bp['lng']))
                                                                    <a href="https://www.google.com/maps?q={{ $bp['lat'] }},{{ $bp['lng'] }}" target="_blank" rel="noopener" class="jh-gmap" title="{{ $bp['lat'] }}, {{ $bp['lng'] }}">
                                                                        <i class="fa-solid fa-location-dot"></i> {{ isset($bp['accuracy']) ? '±'.round($bp['accuracy']).'m' : 'Map' }}
                                                                    </a>
                                                                @else
                                                                    <span class="jh-gnogps">No GPS</span>
                                                                @endif
                                                                <span class="jh-gtime">{{ !empty($bp['taken_at']) ? \Carbon\Carbon::parse($bp['taken_at'])->format('M d g:iA') : '' }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="jh-ba-none">—</span>
                                                @endif
                                            </div>

                                            {{-- AFTER column --}}
                                            <div class="jh-gal-col">
                                                <span class="jh-gal-head after">After ({{ count($afters) }})</span>
                                                @if($hasAfter)
                                                    <div class="jh-gal-strip">
                                                        @foreach($afters as $ap)
                                                            <div class="jh-gitem">
                                                                <img src="{{ asset('storage/app/public/'.$ap['path']) }}" class="jh-gimg" alt="After" onclick="jhOpenProof('{{ asset('storage/app/public/'.$ap['path']) }}')">
                                                                @if(!empty($ap['lat']) && !empty($ap['lng']))
                                                                    <a href="https://www.google.com/maps?q={{ $ap['lat'] }},{{ $ap['lng'] }}" target="_blank" rel="noopener" class="jh-gmap" title="{{ $ap['lat'] }}, {{ $ap['lng'] }}">
                                                                        <i class="fa-solid fa-location-dot"></i> {{ isset($ap['accuracy']) ? '±'.round($ap['accuracy']).'m' : 'Map' }}
                                                                    </a>
                                                                @else
                                                                    <span class="jh-gnogps">No GPS</span>
                                                                @endif
                                                                <span class="jh-gtime">{{ !empty($ap['taken_at']) ? \Carbon\Carbon::parse($ap['taken_at'])->format('M d g:iA') : '' }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="jh-ba-none">—</span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="jh-ba-none">No photos</span>
                                    @endif
                                </td> <td>
                                    @if($s->assignment)
                                        <a href="{{ route('client.history', $s->assignment->id) }}" class="jh-view">
                                            <i class="fa-solid fa-clock-rotate-left"></i> View
                                        </a>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="jh-pagination">
                    {{ $schedules->links('pagination::bootstrap-5') }}
                </div>

            @else
                <div class="jh-empty">No jobs found for the selected filters.</div>
            @endif

        </div>

    </div> {{-- LIGHTBOX (single instance, reused for before + after thumbnails) --}}
    <div class="jh-lightbox" id="jhLightbox" onclick="jhCloseProof()">
        <span class="jh-lightbox-close">&times;</span>
        <img id="jhLightboxImg" src="" alt="Proof photo full size">
    </div>

    <script>
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
        function jhOpenProof(src){
            document.getElementById("jhLightboxImg").src = src;
            document.getElementById("jhLightbox").classList.add("active");
        }
        function jhCloseProof(){
            document.getElementById("jhLightbox").classList.remove("active");
        }
        document.addEventListener("keydown", function(e){
            if(e.key === "Escape") jhCloseProof();
        });
    </script>

</x-layout>