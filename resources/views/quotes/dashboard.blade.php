<x-layout>

    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ===== DASHBOARD (db-*) — layered on dashboard.css chrome ===== */
        .db-wrap{ }

        /* KPI STAT CARDS */
        .db-stats{
            display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:22px;
        }
        @media(max-width:1100px){ .db-stats{ grid-template-columns:repeat(2,1fr); } }
        @media(max-width:520px){ .db-stats{ grid-template-columns:1fr; } }

        .db-stat{
            background:#fff; border:1px solid #e4eae7; border-radius:16px; padding:20px;
            display:flex; align-items:center; gap:16px; transition:.25s;
            box-shadow:0 2px 10px rgba(27,58,42,.04);
        }
        .db-stat:hover{ transform:translateY(-4px); box-shadow:0 10px 24px rgba(27,58,42,.10); }
        .db-stat-ic{
            width:52px; height:52px; border-radius:14px; flex:0 0 auto;
            display:flex; align-items:center; justify-content:center; font-size:20px;
        }
        .ic-quotes{ background:#e8f0eb; color:#1B3A2A; }
        .ic-signed{ background:#dcfce7; color:#16a34a; }
        .ic-pending{ background:#fef3c7; color:#d97706; }
        .ic-active{ background:#dbeafe; color:#2563eb; }
        .ic-voided{ background:#fee2e2; color:#dc2626; }
        .ic-declined{ background:#f3e8ff; color:#9333ea; }
        .db-stat-body{ min-width:0; }
        .db-stat-num{ font-size:28px; font-weight:800; line-height:1; color:#14261c; }
        .db-stat-lbl{ font-size:12.5px; color:#6b7d73; margin-top:5px; font-weight:600; }

        /* REVENUE + CHART ROW */
        .db-mid{
            display:grid; grid-template-columns:1.4fr 1fr; gap:18px; margin-bottom:22px;
        }
        @media(max-width:980px){ .db-mid{ grid-template-columns:1fr; } }

        .db-panel{
            background:#fff; border:1px solid #e4eae7; border-radius:16px; padding:22px;
            box-shadow:0 2px 10px rgba(27,58,42,.04);
        }
        .db-panel-head{
            display:flex; align-items:center; justify-content:space-between; margin-bottom:18px;
        }
        .db-panel-head h3{
            font-size:14px; font-weight:700; letter-spacing:.4px; text-transform:uppercase; color:#14261c;
        }
        .db-panel-head .db-sub{ font-size:12px; color:#8a998f; }

        /* revenue mini-cards */
        .db-rev{ display:flex; flex-direction:column; gap:14px; }
        .db-rev-item{
            display:flex; align-items:center; justify-content:space-between;
            padding:16px 18px; border-radius:12px; border:1px solid #eef2f0;
        }
        .db-rev-item.paid{ background:linear-gradient(135deg,#1B3A2A,#2d5c3e); border:none; }
        .db-rev-item.paid .db-rev-lbl, .db-rev-item.paid .db-rev-val{ color:#fff; }
        .db-rev-item.pending{ background:#fff7ed; border-color:#fed7aa; }
        .db-rev-item.booked{ background:#eff6ff; border-color:#bfdbfe; }
        .db-rev-lbl{ font-size:12.5px; font-weight:700; color:#5a6b60; text-transform:uppercase; letter-spacing:.3px; }
        .db-rev-val{ font-size:22px; font-weight:800; color:#14261c; }
        .db-rev-sub{ font-size:11px; color:#9aa8a0; margin-top:2px; }
        a.db-rev-item{ text-decoration:none; transition:transform .18s, box-shadow .18s; }
        a.db-rev-item:hover{ transform:translateY(-2px); box-shadow:0 8px 18px rgba(27,58,42,.12); }
        .db-rev-go{ font-size:12px; opacity:.45; margin-left:6px; }
        .db-month{
            font-size:12.5px; font-weight:600; color:#14261c; padding:6px 10px;
            border:1px solid #d0d7d3; border-radius:8px; background:#fff; cursor:pointer;
        }

        /* conversion ring-ish bar */
        .db-conv{ margin-top:2px; }
        .db-conv-bar{ height:10px; background:#eef2f0; border-radius:20px; overflow:hidden; margin-top:8px; }
        .db-conv-fill{ height:100%; background:linear-gradient(90deg,#16a34a,#22c55e); border-radius:20px; transition:width .6s ease; }

        /* chart canvas box */
        .db-chart-box{ position:relative; height:260px; }

        /* RECENT TABLE */
        .db-recent{ background:#fff; border:1px solid #e4eae7; border-radius:16px; padding:22px; box-shadow:0 2px 10px rgba(27,58,42,.04); }
        .db-tbl-wrap{ overflow-x:auto; }
        .db-tbl{ width:100%; border-collapse:collapse; min-width:640px; }
        .db-tbl th{
            text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.4px;
            color:#8a998f; font-weight:700; padding:10px 12px; border-bottom:2px solid #eef2f0; background:transparent;
        }
        .db-tbl td{ padding:12px; font-size:13px; color:#2a3a30; border-bottom:1px solid #f1f4f2; }
        .db-tbl tr:hover td{ background:#f8faf9; }
        .db-badge{ display:inline-block; padding:4px 11px; border-radius:20px; font-size:11.5px; font-weight:700; }
        .db-b-active{ background:#dcfce7; color:#16a34a; }
        .db-b-all{ background:#e5e7eb; color:#374151; }
        .db-view{
            display:inline-flex; align-items:center; gap:6px; padding:6px 14px; background:#16a34a;
            color:#fff; border-radius:20px; font-size:12.5px; font-weight:700; text-decoration:none;
            box-shadow:0 3px 9px rgba(22,163,74,.3);
        }
        .db-empty{ text-align:center; color:#9aa8a0; padding:26px; font-style:italic; }
    </style>

    <!-- SIDEBAR -->
    <x-sidebar/>

    <!-- MAIN -->
    <div class="main" id="mainContent">

        <div class="header">
            <div class="menu-btn" onclick="openSidebar()">☰</div>
            <h1>Dashboard</h1>
            <a href="/quote-create" target="_blank"><button class="btn">Create Quote</button></a>
        </div>

        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:10px; border-radius:8px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="db-wrap">

            {{-- ===== KPI STAT CARDS ===== --}}
            <div class="db-stats">
                <div class="db-stat">
                    <div class="db-stat-ic ic-quotes"><i class="fa-solid fa-file-lines"></i></div>
                    <div class="db-stat-body">
                        <div class="db-stat-num">{{ $totalQuotes }}</div>
                        <div class="db-stat-lbl">Total Quotes</div>
                    </div>
                </div>
                <div class="db-stat">
                    <div class="db-stat-ic ic-signed"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="db-stat-body">
                        <div class="db-stat-num">{{ $signedCount }}</div>
                        <div class="db-stat-lbl">Signed Customers</div>
                    </div>
                </div>
                <div class="db-stat">
                    <div class="db-stat-ic ic-pending"><i class="fa-solid fa-hourglass-half"></i></div>
                    <div class="db-stat-body">
                        <div class="db-stat-num">{{ $pendingCount }}</div>
                        <div class="db-stat-lbl">Pending Quotes</div>
                    </div>
                </div>
                <div class="db-stat">
                    <div class="db-stat-ic ic-active"><i class="fa-solid fa-user-check"></i></div>
                    <div class="db-stat-body">
                        <div class="db-stat-num">{{ $activeCustomers }}</div>
                        <div class="db-stat-lbl">Active Customers</div>
                    </div>
                </div>
            </div>

            {{-- secondary status row --}}
            <div class="db-stats">
                <div class="db-stat">
                    <div class="db-stat-ic ic-voided"><i class="fa-solid fa-circle-xmark"></i></div>
                    <div class="db-stat-body">
                        <div class="db-stat-num">{{ $voidedCount }}</div>
                        <div class="db-stat-lbl">Voided</div>
                    </div>
                </div>
                <div class="db-stat">
                    <div class="db-stat-ic ic-declined"><i class="fa-solid fa-ban"></i></div>
                    <div class="db-stat-body">
                        <div class="db-stat-num">{{ $declinedCount }}</div>
                        <div class="db-stat-lbl">Declined</div>
                    </div>
                </div>
                <div class="db-stat">
                    <div class="db-stat-ic ic-signed"><i class="fa-solid fa-percent"></i></div>
                    <div class="db-stat-body">
                        <div class="db-stat-num">{{ $conversionRate }}%</div>
                        <div class="db-stat-lbl">Signed Conversion</div>
                    </div>
                </div>
                <div class="db-stat">
                    <div class="db-stat-ic ic-quotes"><i class="fa-solid fa-sack-dollar"></i></div>
                    <div class="db-stat-body">
                        <div class="db-stat-num">${{ number_format($bookedValue, 0) }}</div>
                        <div class="db-stat-lbl">Booked Value</div>
                    </div>
                </div>
            </div>

            {{-- ===== REVENUE + CHART ===== --}}
            <div class="db-mid">

                {{-- chart --}}
                <div class="db-panel">
                    <div class="db-panel-head">
                        <h3>Signed Customers</h3>
                        <span class="db-sub">Last 6 months</span>
                    </div>
                    <div class="db-chart-box">
                        <canvas id="signedChart"></canvas>
                    </div>
                </div>

                {{-- revenue --}}
                <div class="db-panel">
                    <div class="db-panel-head">
                        <h3>Revenue</h3>
                        <form method="GET" action="{{ route('admin.dashboard') }}">
                            <select name="month" class="db-month" onchange="this.form.submit()" aria-label="Filter revenue by month">
                                <option value="">All time</option>
                                @if($month && !isset($availableMonths[$month]))
                                    <option value="{{ $month }}" selected>{{ \Carbon\Carbon::createFromFormat('!Y-m', $month)->format('F Y') }}</option>
                                @endif
                                @foreach($availableMonths as $ym => $label)
                                    <option value="{{ $ym }}" @selected($month === $ym)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    @php $mq = $month ? ['month' => $month] : []; @endphp
                    <div class="db-rev">
                        <a href="{{ route('revenue.details', ['type' => 'collected'] + $mq) }}" class="db-rev-item paid">
                            <div>
                                <div class="db-rev-lbl">Total Collected</div>
                                <div class="db-rev-sub" style="color:rgba(255,255,255,.6)">Sum of paid amounts</div>
                            </div>
                            <div class="db-rev-val">${{ number_format($totalPaid, 2) }} <i class="fa-solid fa-chevron-right db-rev-go"></i></div>
                        </a>
                        <a href="{{ route('revenue.details', ['type' => 'pending'] + $mq) }}" class="db-rev-item pending">
                            <div>
                                <div class="db-rev-lbl">Pending Balance</div>
                                <div class="db-rev-sub">Unpaid + partially paid invoices</div>
                            </div>
                            <div class="db-rev-val">${{ number_format($totalPending, 2) }} <i class="fa-solid fa-chevron-right db-rev-go"></i></div>
                        </a>
                        <a href="{{ route('revenue.details', ['type' => 'booked'] + $mq) }}" class="db-rev-item booked">
                            <div>
                                <div class="db-rev-lbl">Booked Value</div>
                                <div class="db-rev-sub">Signed quote totals</div>
                            </div>
                            <div class="db-rev-val">${{ number_format($bookedValue, 2) }} <i class="fa-solid fa-chevron-right db-rev-go"></i></div>
                        </a>

                        <div class="db-conv">
                            <div style="display:flex;justify-content:space-between;font-size:12.5px;color:#5a6b60;font-weight:700;">
                                <span>Conversion Rate</span>
                                <span>{{ $conversionRate }}%</span>
                            </div>
                            <div class="db-conv-bar"><div class="db-conv-fill" style="width:{{ $conversionRate }}%;"></div></div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ===== RECENT SIGNED CUSTOMERS ===== --}}
            <div class="db-recent">
                <div class="db-panel-head">
                    <h3>Recent Signed Customers</h3>
                    <a href="{{ route('customers.all') }}" class="db-sub" style="text-decoration:none;color:#16a34a;font-weight:700;">View all →</a>
                </div>
                <div class="db-tbl-wrap">
                    <table class="db-tbl">
                        <thead>
                        <tr>
                            <th>Quote #</th>
                            <th>Client</th>
                            <th>Email</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Signed At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentCustomers as $c)
                            <tr>
                                <td>#{{ $c->id }}</td>
                                <td>{{ $c->client_name }}</td>
                                <td>{{ $c->client_email ?? '—' }}</td>
                                <td>${{ number_format($c->total ?? 0, 2) }}</td>
                                <td>
                                    @if(($c->customer_status ?? 'all') === 'active')
                                        <span class="db-badge db-b-active">Active</span>
                                    @else
                                        <span class="db-badge db-b-all">All</span>
                                    @endif
                                </td>
                                <td>{{ $c->signed_at ? \Carbon\Carbon::parse($c->signed_at)->format('d M Y') : '—' }}</td>
                                <td><a href="{{ route('quote.view', $c->id) }}" class="db-view"><i class="fa-regular fa-eye"></i> View</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="db-empty">No signed customers yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- Chart.js (CDN) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        // Sidebar (matches your other admin pages)
        function openSidebar(){ document.getElementById("sidebar").classList.add("active"); }
        function closeSidebar(){ document.getElementById("sidebar").classList.remove("active"); }
        document.addEventListener("click", function(e){
            var sb = document.getElementById("sidebar");
            var mb = document.querySelector(".menu-btn");
            if(sb && sb.classList.contains("active") && !sb.contains(e.target) && mb && !mb.contains(e.target)){
                sb.classList.remove("active");
            }
        });

        // Signed-customers line chart — data injected from controller.
        (function(){
            var el = document.getElementById('signedChart');
            if(!el || typeof Chart === 'undefined') return;

            var labels = @json($chartLabels);
            var data   = @json($chartData);

            var ctx = el.getContext('2d');
            var grad = ctx.createLinearGradient(0, 0, 0, 260);
            grad.addColorStop(0, 'rgba(22,163,74,.35)');
            grad.addColorStop(1, 'rgba(22,163,74,0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Signed',
                        data: data,
                        borderColor: '#16a34a',
                        backgroundColor: grad,
                        borderWidth: 3,
                        fill: true,
                        tension: .35,
                        pointBackgroundColor: '#1B3A2A',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0, color:'#8a998f' }, grid: { color:'#eef2f0' } },
                        x: { ticks: { color:'#8a998f' }, grid: { display:false } }
                    }
                }
            });
        })();
    </script>

</x-layout>