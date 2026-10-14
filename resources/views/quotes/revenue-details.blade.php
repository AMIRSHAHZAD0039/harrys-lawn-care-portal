<x-layout>

    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @php
        $titles = [
            'collected' => ['Total Collected', 'Invoices with a paid amount (Paid + Partially Paid)', 'fa-sack-dollar'],
            'pending'   => ['Pending Balance', 'Invoices with money still owed (Unpaid + Partially Paid)', 'fa-hourglass-half'],
            'booked'    => ['Booked Value', 'Signed customers and their quote totals', 'fa-file-signature'],
        ];
        [$title, $subtitle] = $titles[$type];
        $mq = $month ? ['month' => $month] : [];
        $monthLabel = $month ? \Carbon\Carbon::createFromFormat('!Y-m', $month)->format('F Y') : 'All time';
        $invoiceCount = $customers->sum(fn ($c) => $c->billings->count());
    @endphp

    <style>
        .rv-top{ display:flex; justify-content:space-between; align-items:center; gap:14px; flex-wrap:wrap; margin-bottom:18px; }
        .rv-tabs{ display:flex; gap:10px; flex-wrap:wrap; }
        .rv-tab{
            display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:10px;
            font-weight:700; font-size:14px; border:1px solid #d0d7d3; background:#fff; color:#1B3A2A; text-decoration:none; transition:.18s;
        }
        .rv-tab:hover{ border-color:#1B3A2A; }
        .rv-tab.active{ background:#1B3A2A; color:#fff; border-color:#1B3A2A; }
        .rv-tools{ display:flex; gap:10px; flex-wrap:wrap; }
        .rv-tools select, .rv-tools input{
            font-size:13px; padding:9px 12px; border:1px solid #d0d7d3; border-radius:8px; background:#fff; color:#14261c; min-width:170px;
        }

        .rv-summary{
            display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:20px;
        }
        @media(max-width:760px){ .rv-summary{ grid-template-columns:1fr; } }
        .rv-sum{ background:#fff; border:1px solid #e4eae7; border-radius:14px; padding:16px 18px; }
        .rv-sum.main{ background:linear-gradient(135deg,#1B3A2A,#2d5c3e); border:none; color:#fff; }
        .rv-sum .k{ font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:#6b7d73; }
        .rv-sum.main .k{ color:rgba(255,255,255,.7); }
        .rv-sum .v{ font-size:24px; font-weight:800; margin-top:4px; color:#14261c; }
        .rv-sum.main .v{ color:#fff; }

        .rv-cust{ background:#fff; border:1px solid #e4eae7; border-radius:14px; margin-bottom:16px; overflow:hidden; }
        .rv-cust-head{
            display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;
            padding:14px 18px; background:#f6f9f7; border-bottom:1px solid #e4eae7;
        }
        .rv-cust-name{ font-size:15px; font-weight:800; color:#14261c; }
        .rv-cust-meta{ font-size:12px; color:#6b7d73; margin-top:3px; display:flex; gap:14px; flex-wrap:wrap; }
        .rv-cust-right{ display:flex; align-items:center; gap:14px; flex-wrap:wrap; }
        .rv-cust-amt{ text-align:right; }
        .rv-cust-amt .lbl{ font-size:11px; font-weight:700; text-transform:uppercase; color:#8a998f; }
        .rv-cust-amt .num{ font-size:18px; font-weight:800; color:#14261c; }
        .rv-open{
            display:inline-flex; align-items:center; gap:6px; padding:7px 14px; background:#0ea5e9; color:#fff;
            border-radius:20px; font-size:12.5px; font-weight:700; text-decoration:none;
        }

        .rv-tbl-wrap{ overflow-x:auto; }
        .rv-tbl{ width:100%; border-collapse:collapse; min-width:720px; }
        .rv-tbl th{
            text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.4px; color:#8a998f;
            font-weight:700; padding:9px 14px; border-bottom:1px solid #eef2f0; background:transparent;
        }
        .rv-tbl td{ padding:10px 14px; font-size:13px; color:#2a3a30; border-bottom:1px solid #f1f4f2; vertical-align:top; }
        .rv-tbl tr:last-child td{ border-bottom:none; }
        .rv-tbl .r{ text-align:right; }
        .rv-note{ font-size:11px; color:#8a998f; margin-top:2px; }
        .rv-none{ padding:14px 18px; font-size:13px; color:#9aa8a0; font-style:italic; }

        .rv-badge{ display:inline-block; font-size:11px; font-weight:700; padding:3px 10px; border-radius:20px; }
        .rv-paid{ background:#dcfce7; color:#16a34a; }
        .rv-unpaid{ background:#fee2e2; color:#dc2626; }
        .rv-partial{ background:#fef3c7; color:#b45309; }

        .rv-empty{ background:#fff; border:1px dashed #d0d7d3; border-radius:14px; padding:40px; text-align:center; color:#8a998f; }
    </style>

    <x-sidebar/>

    <div class="main" id="mainContent">

        <div class="header">
            <div class="menu-btn" onclick="openSidebar()">☰</div>
            <h1>{{ $title }}</h1>
            <a href="{{ route('admin.dashboard', $mq) }}"><button class="btn"><i class="fa-solid fa-arrow-left"></i> Dashboard</button></a>
        </div>

        <div class="rv-top">
            <div class="rv-tabs">
                @foreach($titles as $key => $t)
                    <a href="{{ route('revenue.details', ['type' => $key] + $mq) }}" class="rv-tab {{ $type === $key ? 'active' : '' }}">
                        <i class="fa-solid {{ $t[2] }}"></i> {{ $t[0] }}
                    </a>
                @endforeach
            </div>
            <div class="rv-tools">
                <input type="search" id="rvSearch" placeholder="Search client, email, phone…" aria-label="Search customers">
                <form method="GET" action="{{ route('revenue.details', $type) }}">
                    <select name="month" onchange="this.form.submit()" aria-label="Filter by month">
                        <option value="">All time</option>
                        @if($month && !isset($availableMonths[$month]))
                            <option value="{{ $month }}" selected>{{ $monthLabel }}</option>
                        @endif
                        @foreach($availableMonths as $ym => $label)
                            <option value="{{ $ym }}" @selected($month === $ym)>{{ $label }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="rv-summary">
            <div class="rv-sum main">
                <div class="k">{{ $title }} · {{ $monthLabel }}</div>
                <div class="v">${{ number_format($grandTotal, 2) }}</div>
            </div>
            <div class="rv-sum">
                <div class="k">Customers</div>
                <div class="v">{{ $customers->count() }}</div>
            </div>
            <div class="rv-sum">
                <div class="k">{{ $type === 'booked' ? 'Invoices on file' : 'Invoices' }}</div>
                <div class="v">{{ $invoiceCount }}</div>
            </div>
        </div>

        <p style="font-size:12.5px;color:#6b7d73;margin:-6px 0 16px;">
            {{ $subtitle }}.
            @if($type === 'booked')
                Month filter uses the date the quote was signed.
            @else
                Month filter uses the invoice's payment date.
            @endif
        </p>

        @forelse($customers as $c)
            @php
                $bills = $c->billings;
                $custAmount = match ($type) {
                    'collected' => $bills->sum('amount_paid'),
                    'pending'   => $bills->sum('pending_amount'),
                    default     => $c->total ?? 0,
                };
            @endphp
            <div class="rv-cust" data-search="{{ strtolower($c->client_name.' '.$c->client_email.' '.$c->client_phone) }}">
                <div class="rv-cust-head">
                    <div>
                        <div class="rv-cust-name">{{ $c->client_name }} <span style="font-weight:600;color:#8a998f;font-size:12.5px;">· Quote #{{ $c->id }}</span></div>
                        <div class="rv-cust-meta">
                            @if($c->client_email)<span><i class="fa-regular fa-envelope"></i> {{ $c->client_email }}</span>@endif
                            @if($c->client_phone)<span><i class="fa-solid fa-phone"></i> {{ $c->client_phone }}</span>@endif
                            @if($type === 'booked' && $c->signed_at)<span><i class="fa-solid fa-signature"></i> Signed {{ \Carbon\Carbon::parse($c->signed_at)->format('d M Y') }}</span>@endif
                        </div>
                    </div>
                    <div class="rv-cust-right">
                        @if($type === 'booked')
                            <div class="rv-cust-amt">
                                <div class="lbl">Collected / Pending</div>
                                <div style="font-size:13px;font-weight:700;">
                                    <span style="color:#16a34a">${{ number_format($bills->sum('amount_paid'), 2) }}</span> /
                                    <span style="color:#b45309">${{ number_format($bills->sum('pending_amount'), 2) }}</span>
                                </div>
                            </div>
                        @endif
                        <div class="rv-cust-amt">
                            <div class="lbl">{{ ['collected' => 'Paid', 'pending' => 'Pending', 'booked' => 'Quote Total'][$type] }}</div>
                            <div class="num">${{ number_format($custAmount, 2) }}</div>
                        </div>
                        <a href="{{ route('billing.invoices', $c->id) }}" class="rv-open"><i class="fa-solid fa-file-invoice-dollar"></i> Invoices</a>
                    </div>
                </div>

                @if($bills->isEmpty())
                    <div class="rv-none">No invoices recorded yet.</div>
                @else
                    <div class="rv-tbl-wrap">
                        <table class="rv-tbl">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Service Detail</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th class="r">Total</th>
                                <th class="r">Paid</th>
                                <th class="r">Pending</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bills as $b)
                                @php $st = strtolower($b->status); @endphp
                                <tr>
                                    <td>{{ $b->paid_date ? \Carbon\Carbon::parse($b->paid_date)->format('d M Y') : $b->created_at->format('d M Y') }}</td>
                                    <td>
                                        {{ $b->service_detail }}
                                        @if($b->notes)<div class="rv-note">{{ $b->notes }}</div>@endif
                                    </td>
                                    <td>{{ $b->method ?? '—' }}</td>
                                    <td>
                                        <span class="rv-badge {{ $st === 'paid' ? 'rv-paid' : (str_contains($st, 'partial') ? 'rv-partial' : 'rv-unpaid') }}">
                                            {{ $st === 'partial' ? 'Partially Paid' : $b->status }}
                                        </span>
                                    </td>
                                    <td class="r">
                                        ${{ number_format($b->total_amount, 2) }}
                                        @if($b->gst_applied)<div class="rv-note">incl. GST ${{ number_format($b->gst_amount, 2) }}</div>@endif
                                    </td>
                                    <td class="r">${{ number_format($b->amount_paid, 2) }}</td>
                                    <td class="r">${{ number_format($b->pending_amount, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @empty
            <div class="rv-empty">
                <i class="fa-regular fa-folder-open" style="font-size:28px;margin-bottom:8px;display:block;"></i>
                Nothing to show for {{ $monthLabel }}.
            </div>
        @endforelse

        <div class="rv-empty" id="rvNoMatch" style="display:none;">No customers match your search.</div>
    </div>

    <script>
        function openSidebar(){ document.getElementById("sidebar").classList.add("active"); }
        function closeSidebar(){ document.getElementById("sidebar").classList.remove("active"); }
        document.addEventListener("click", function(e){
            var sb = document.getElementById("sidebar");
            var mb = document.querySelector(".menu-btn");
            if(sb && sb.classList.contains("active") && !sb.contains(e.target) && mb && !mb.contains(e.target)){
                sb.classList.remove("active");
            }
        });

        // client-side search across customer cards
        document.getElementById('rvSearch').addEventListener('input', function(){
            var q = this.value.trim().toLowerCase(), shown = 0;
            document.querySelectorAll('.rv-cust').forEach(function(card){
                var hit = !q || card.dataset.search.indexOf(q) !== -1;
                card.style.display = hit ? '' : 'none';
                if (hit) shown++;
            });
            document.getElementById('rvNoMatch').style.display = (q && !shown) ? '' : 'none';
        });
    </script>

</x-layout>
