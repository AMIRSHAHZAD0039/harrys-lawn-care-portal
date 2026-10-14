<x-layout>

    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .filter-container{ background:#1B3A2A; padding:20px; border-radius:12px; margin-bottom:25px; box-shadow:0 10px 25px rgba(0,0,0,0.25); border:1px solid rgba(255,255,255,0.1); }
        .filter-form{ display:flex; gap:12px; flex-wrap:wrap; align-items:center; }
        .filter-input{ padding:10px 12px; border-radius:8px; border:1px solid rgba(255,255,255,0.2); background:black; color:white; outline:none; min-width:160px; transition:0.25s; }
        .filter-input::placeholder{ color:#aaa; }
        .filter-input:focus{ border-color:white; box-shadow:0 0 0 2px rgba(255,255,255,0.15); }
        .filter-btn{ background:white; color:#1B3A2A; border:none; padding:10px 20px; border-radius:8px; cursor:pointer; font-weight:600; transition:0.25s; }
        .filter-btn:hover{ background:black; color:white; transform:translateY(-2px); box-shadow:0 6px 14px rgba(0,0,0,0.25); }
        .reset-btn{ background:black; color:white; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600; transition:0.25s; }
        .reset-btn:hover{ background:white; color:#1B3A2A; transform:translateY(-2px); box-shadow:0 6px 14px rgba(0,0,0,0.25); }

        @media (max-width:768px){
            .filter-form{ flex-direction:column; align-items:stretch; }
            .filter-input{ width:100%; min-width:100%; }
            .filter-btn, .reset-btn{ width:100%; text-align:center; }
        }

        .table-wrapper{ width:100%; overflow-x:auto; }
        .table-wrapper table{ border-collapse:collapse; table-layout:fixed; }
        .table-wrapper::-webkit-scrollbar{ height:8px; }

        /* ===== CUSTOMER TABS ===== */
        .cust-tabs{ display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap; }
        .cust-tab{
            display:inline-flex; align-items:center; gap:8px;
            padding:11px 22px; border-radius:10px; cursor:pointer; user-select:none;
            font-weight:700; font-size:14px; border:1px solid #d0d7d3;
            background:#fff; color:#1B3A2A; transition:.18s;
        }
        .cust-tab .cust-tab-count{ font-size:12px; font-weight:700; padding:2px 9px; border-radius:20px; background:#e6f4ea; color:#16a34a; }
        .cust-tab.active{ background:#1B3A2A; color:#fff; border-color:#1B3A2A; }
        .cust-tab.active .cust-tab-count{ background:rgba(255,255,255,.2); color:#fff; }

        .cust-panel{ display:none; }
        .cust-panel.active{ display:block; }

        /* customer status pill + toggle */
        .cs-badge{ display:inline-block; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:700; }
        .cs-all{ background:#e5e7eb; color:#374151; }
        .cs-active{ background:#dcfce7; color:#16a34a; }
        .cs-toggle{ display:inline-flex; align-items:center; gap:6px; border:none; cursor:pointer; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:600; color:#fff; }
        .cs-toggle.to-active{ background:#16a34a; }
        .cs-toggle.to-all{ background:#6b7280; }

        @media (max-width:768px){
            .cust-tab{ flex:1 1 calc(50% - 10px); justify-content:center; padding:10px 12px; font-size:13px; }
            .table-container h2{ font-size:18px; }
        }
    </style>

    <x-sidebar/>

    <div class="main" id="mainContent">

        <div class="header">
            <div class="menu-btn" onclick="openSidebar()">☰</div>
            <h1>All Customers</h1>
            <a href="/quote-create" target="_blank"><button class="btn">Create Quote</button></a>
        </div>

        @if(session('success'))
            <div style="background-color:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Controller sends only SIGNED quotes (signed==1 & status='accepted').
             $quotes = paginated All tab; $activeCustomers = every active customer (no pagination). --}}
        @php
            $allCustomers = $quotes->getCollection();
        @endphp

        <!-- FILTER -->
        <div class="filter-container">
            <form method="GET" action="{{ route('customers.all') }}" class="filter-form">
                <input type="text" name="client" placeholder="Client" value="{{ request('client') }}" class="filter-input">
                <input type="text" name="email"  placeholder="Email"  value="{{ request('email') }}"  class="filter-input">
                <input type="text" name="phone"  placeholder="Phone"  value="{{ request('phone') }}"  class="filter-input">
                <x-address-filter scope="customers" />
                <button type="submit" class="filter-btn">Filter</button>
                <a href="{{ route('customers.all') }}" class="reset-btn">Reset</a>
                <button type="submit" formaction="{{ route('quotes.export') }}" class="filter-btn">Export CSV</button>
            </form>
        </div>

        <!-- TOP ACTION BUTTONS -->
        <div class="top-actions" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:15px;">
            <button type="button" onclick="goToRouteOptimization()" style="background:#16a34a;color:white;border:none;padding:10px 18px;border-radius:8px;cursor:pointer;">
                Optimize Selected Route
            </button>
            <button type="button" onclick="openAssignGroup()" style="background:#1f3d2b;color:white;border:none;padding:10px 18px;border-radius:8px;cursor:pointer;">
                <i class="fa-solid fa-layer-group"></i> Assign Group/Week
            </button>
            <button type="button" onclick="openEditAssignGroup()" style="background:#f59e0b;color:white;border:none;padding:10px 18px;border-radius:8px;cursor:pointer;">
                <i class="fa-solid fa-pen"></i> Edit Assigned Group/Week
            </button>
        </div>

        <!-- TABS -->
        <div class="cust-tabs">
            <div class="cust-tab active" data-tab="all" onclick="showCustTab('all')">
                <i class="fa-solid fa-users"></i> All Customers
                <span class="cust-tab-count">{{ $quotes->total() }}</span>
            </div>
            <div class="cust-tab" data-tab="active" onclick="showCustTab('active')">
                <i class="fa-solid fa-user-check"></i> Active Customers
                <span class="cust-tab-count">{{ $activeCustomers->count() }}</span>
            </div>
        </div>

        {{-- ============================================================
             ALL CUSTOMERS PANEL
        ============================================================ --}}
        <div class="cust-panel active" id="panel-all">
            <div class="table-container">
                <h2 style="margin-bottom:15px;">All Signed Customers</h2>
                <div class="table-wrapper" style="min-width:400px; overflow-x:auto;">
                    <table class="resp-table" border="1" cellpadding="11" cellspacing="0" style="min-width:1900px; width:100%;">
                        <thead>
                        <tr>
                            <th style="width:70px;">Assign</th>
                            <th style="width:60px;">#</th>
                            <th style="width:90px;">Quote #</th>
                            <th style="width:180px;">Client</th>
                            <th style="width:250px;">Email</th>
                            <th style="width:180px;">Phone</th>
                            <th style="width:280px;">Address</th>
                            <th style="width:180px;">Status</th>
                            <th style="width:170px;">Customer Status</th>
                            <th style="width:180px;">Payment Method</th>
                            <th style="width:100px;">Total</th>
                            <th style="width:130px;">Invoices</th>
                            <th style="width:150px;">Group</th>
                            <th style="width:120px;">Week</th>

                            <th style="width:190px;">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'signed_at','order' => (request('sort') == 'signed_at' && request('order') == 'asc') ? 'desc' : 'asc']) }}" style="color:inherit;text-decoration:none;">
                                    Signed At
                                    @if(request('sort') == 'signed_at')
                                        <i class="fa-solid {{ request('order') == 'asc' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                                    @else
                                        <i class="fa-solid fa-sort" style="opacity:0.4"></i>
                                    @endif
                                </a>
                            </th>
                            <th style="width:420px;">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            // Serial: oldest = 1. List is newest-first (controller latest('signed_at')),
                            // so the serial counts DOWN from the paginator total as rows go top-to-bottom.
                            $allSerial = $quotes->total() - ($quotes->firstItem() ? $quotes->firstItem() - 1 : 0);
                        @endphp
                        @forelse($allCustomers as $quote)
                            <tr>
                                <td>
                                    <input type="checkbox" class="quote-checkbox" value="{{ $quote->id }}"
                                           data-group="{{ $quote->associated_group }}" data-week="{{ $quote->associated_week }}">
                                </td>
                                <td><strong>{{ $allSerial-- }}</strong></td>
                                <td>#{{ $quote->id }}</td>
                                <td>{{ $quote->client_name }}</td>
                                <td>{{ $quote->client_email }}</td>
                                <td>{{ $quote->client_phone }}</td>
                                <td>{{ $quote->client_address }}</td>

                                {{-- status (full logic, verbatim from all-quotes) --}}
                                <td>
                                    @if($quote->status === 'Voided')
                                        <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#dc2626;color:#fff;border-radius:20px;font-size:13px;font-weight:700;"><i class="fa-solid fa-circle-xmark"></i> Voided</span>
                                    @elseif($quote->status === 'declined')
                                        <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#fee2e2;color:#dc2626;border-radius:20px;font-size:13px;font-weight:700;"><i class="fa-solid fa-circle-xmark"></i> Declined</span>
                                    @elseif($quote->signed == 1 && $quote->status === 'accepted')
                                        <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#dcfce7;color:#16a34a;border-radius:20px;font-size:13px;font-weight:700;"><i class="fa-solid fa-circle-check"></i> Signed</span>
                                    @elseif($quote->emailLogs->where('type','quote_sent')->count() > 0)
                                        <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#dbeafe;color:#2563eb;border-radius:20px;font-size:13px;font-weight:700;"><i class="fa-solid fa-arrow-up-right-from-square"></i> Quote Sent</span>
                                    @else
                                        <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#fef3c7;color:#d97706;border-radius:20px;font-size:13px;font-weight:700;"><i class="fa-solid fa-hourglass-half"></i> Pending</span>
                                    @endif
                                </td>

                                {{-- customer status (All / Active) --}}
                                <td>
                                    @if($quote->customer_status === 'active')
                                        <span class="cs-badge cs-active"><i class="fa-solid fa-circle-check"></i> Active</span>
                                    @else
                                        <span class="cs-badge cs-all"><i class="fa-solid fa-user"></i> All</span>
                                    @endif
                                </td>

                                {{-- payment method --}}
                                <td>
                                    @if($quote->payment_method)
                                        <span style="display:inline-block;min-width:130px;text-align:center;padding:6px 14px;background:orange;color:white;border-radius:20px;font-size:13px;font-weight:bold;">{{ $quote->payment_method }}</span>
                                    @else - @endif
                                </td>

                                <td>${{ $quote->total }}</td>

                                {{-- invoices (existing billings) --}}
                                <td><strong>{{ $quote->billings->count() }}</strong> invoice(s)</td>

                                {{-- group --}}
                                <td>
                                    @if($quote->associated_group)
                                        <span style="display:inline-block;padding:5px 12px;background:#dcfce7;color:#16a34a;border-radius:20px;font-size:12px;font-weight:700;">{{ $quote->associated_group }}</span>
                                    @else <span style="color:gray;">—</span> @endif
                                </td>

                                {{-- week --}}
                                <td>
                                    @if($quote->associated_week)
                                        <span style="display:inline-block;padding:5px 12px;background:#dbeafe;color:#2563eb;border-radius:20px;font-size:12px;font-weight:700;">{{ $quote->associated_week }}</span>
                                    @else <span style="color:gray;">—</span> @endif
                                </td>

                                <td>{{ $quote->signed_at ? \Carbon\Carbon::parse($quote->signed_at)->format('d M Y h:i A') : '-' }}</td>

                                {{-- ACTIONS — full set from all-quotes + Add Invoice + status toggle --}}
                                <td>
                                    <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">

                                        <a href="{{ route('quote.view',$quote->id) }}" style="display:flex; align-items:center; gap:7px; padding:9px 20px; background:#16a34a; color:#fff; border-radius:22px; font-size:14px; font-weight:700; text-decoration:none; box-shadow:0 4px 12px rgba(22,163,74,.35); border:1px solid #15a34a;"><i class="fa-regular fa-eye"></i> Preview</a>




                                        {{-- Add Invoice (existing billing modal) --}}
                                        <a href="{{ route('billing.invoices', $quote->id) }}" style="display:flex; align-items:center; gap:6px; padding:6px 14px; background:#0ea5e9; color:#fff; border-radius:20px; font-size:13px; text-decoration:none;"><i class="fa-solid fa-file-invoice-dollar"></i> Invoices ({{ $quote->billings->count() }})</a>

                                        {{-- Void --}}


                                        <a href="{{ route('quote.sendCalendly', $quote->id) }}" style="display:flex; align-items:center; gap:6px; padding:6px 14px; background:#16a34a; color:#fff; border-radius:20px; font-size:13px; text-decoration:none;"><i class="fas fa-book me-1"></i> Book Appointment</a>

                                        {{-- Status toggle: All <-> Active --}}
                                        <form action="{{ route('customers.toggleStatus', $quote->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            @if($quote->customer_status === 'active')
                                                <button type="submit" class="cs-toggle to-all"><i class="fa-solid fa-arrow-down"></i> Move to All</button>
                                            @else
                                                <button type="submit" class="cs-toggle to-active"><i class="fa-solid fa-arrow-up"></i> Make Active</button>
                                            @endif
                                        </form>

                                        {{-- Delete --}}

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="16" style="text-align:center;">No signed customers found.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- pagination applies to the All tab only; Active tab lists everyone --}}
            <div style="margin-top:20px; display:flex; justify-content:end;color:white !important;">
                {{ $quotes->links('pagination::bootstrap-5') }}
            </div>
        </div>

        {{-- ============================================================
             ACTIVE CUSTOMERS PANEL — same columns + actions, active subset
        ============================================================ --}}
        <div class="cust-panel" id="panel-active">
            <div class="table-container">
                <h2 style="margin-bottom:15px;">Active Customers</h2>
                <div class="table-wrapper" style="min-width:400px; overflow-x:auto;">
                    <table class="resp-table" border="1" cellpadding="11" cellspacing="0" style="min-width:1900px; width:100%;">
                        <thead>
                        <tr>
                            <th style="width:70px;">Assign</th>
                            <th style="width:60px;">#</th>
                            <th style="width:90px;">Quote #</th>
                            <th style="width:180px;">Client</th>
                            <th style="width:250px;">Email</th>
                            <th style="width:180px;">Phone</th>
                            <th style="width:280px;">Address</th>
                            <th style="width:180px;">Status</th>
                            <th style="width:170px;">Customer Status</th>
                            <th style="width:180px;">Payment Method</th>
                            <th style="width:100px;">Total</th>
                            <th style="width:130px;">Invoices</th>
                            <th style="width:150px;">Group</th>
                            <th style="width:120px;">Week</th>
                            <th style="width:190px;">Signed At</th>
                            <th style="width:420px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $activeSerial = $activeCustomers->count(); @endphp
                        @forelse($activeCustomers as $quote)
                            <tr>
                                <td>
                                    <input type="checkbox" class="quote-checkbox" value="{{ $quote->id }}"
                                           data-group="{{ $quote->associated_group }}" data-week="{{ $quote->associated_week }}">
                                </td>
                                <td><strong>{{ $activeSerial-- }}</strong></td>
                                <td>#{{ $quote->id }}</td>
                                <td>{{ $quote->client_name }}</td>
                                <td>{{ $quote->client_email }}</td>
                                <td>{{ $quote->client_phone }}</td>
                                <td>{{ $quote->client_address }}</td>

                                <td>
                                    @if($quote->status === 'Voided')
                                        <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#dc2626;color:#fff;border-radius:20px;font-size:13px;font-weight:700;"><i class="fa-solid fa-circle-xmark"></i> Voided</span>
                                    @elseif($quote->status === 'declined')
                                        <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#fee2e2;color:#dc2626;border-radius:20px;font-size:13px;font-weight:700;"><i class="fa-solid fa-circle-xmark"></i> Declined</span>
                                    @elseif($quote->signed == 1 && $quote->status === 'accepted')
                                        <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#dcfce7;color:#16a34a;border-radius:20px;font-size:13px;font-weight:700;"><i class="fa-solid fa-circle-check"></i> Signed</span>
                                    @elseif($quote->emailLogs->where('type','quote_sent')->count() > 0)
                                        <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#dbeafe;color:#2563eb;border-radius:20px;font-size:13px;font-weight:700;"><i class="fa-solid fa-arrow-up-right-from-square"></i> Quote Sent</span>
                                    @else
                                        <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#fef3c7;color:#d97706;border-radius:20px;font-size:13px;font-weight:700;"><i class="fa-solid fa-hourglass-half"></i> Pending</span>
                                    @endif
                                </td>

                                <td><span class="cs-badge cs-active"><i class="fa-solid fa-circle-check"></i> Active</span></td>

                                <td>
                                    @if($quote->payment_method)
                                        <span style="display:inline-block;min-width:130px;text-align:center;padding:6px 14px;background:orange;color:white;border-radius:20px;font-size:13px;font-weight:bold;">{{ $quote->payment_method }}</span>
                                    @else - @endif
                                </td>

                                <td>${{ $quote->total }}</td>
                                <td><strong>{{ $quote->billings->count() }}</strong> invoice(s)</td>

                                <td>
                                    @if($quote->associated_group)
                                        <span style="display:inline-block;padding:5px 12px;background:#dcfce7;color:#16a34a;border-radius:20px;font-size:12px;font-weight:700;">{{ $quote->associated_group }}</span>
                                    @else <span style="color:gray;">—</span> @endif
                                </td>

                                <td>
                                    @if($quote->associated_week)
                                        <span style="display:inline-block;padding:5px 12px;background:#dbeafe;color:#2563eb;border-radius:20px;font-size:12px;font-weight:700;">{{ $quote->associated_week }}</span>
                                    @else <span style="color:gray;">—</span> @endif
                                </td>

                                <td>{{ $quote->signed_at ? \Carbon\Carbon::parse($quote->signed_at)->format('d M Y h:i A') : '-' }}</td>

                                <td>
                                    <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                                        <a href="{{ route('quote.view',$quote->id) }}" style="display:flex; align-items:center; gap:7px; padding:9px 20px; background:#16a34a; color:#fff; border-radius:22px; font-size:14px; font-weight:700; text-decoration:none; box-shadow:0 4px 12px rgba(22,163,74,.35); border:1px solid #15a34a;"><i class="fa-regular fa-eye"></i> Preview</a>

                                        <a href="{{ route('billing.invoices', $quote->id) }}" style="display:flex; align-items:center; gap:6px; padding:6px 14px; background:#0ea5e9; color:#fff; border-radius:20px; font-size:13px; text-decoration:none;"><i class="fa-solid fa-file-invoice-dollar"></i> Invoices ({{ $quote->billings->count() }})</a>


                                        <a href="{{ route('quote.sendCalendly', $quote->id) }}" style="display:flex; align-items:center; gap:6px; padding:6px 14px; background:#16a34a; color:#fff; border-radius:20px; font-size:13px; text-decoration:none;"><i class="fas fa-book me-1"></i> Book Appointment</a>

                                        <form action="{{ route('customers.toggleStatus', $quote->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            <button type="submit" class="cs-toggle to-all"><i class="fa-solid fa-arrow-down"></i> Move to All</button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="16" style="text-align:center;">No active customers yet. Use "Make Active" in the All Customers tab.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    {{-- ASSIGN GROUP MODAL --}}
    <div class="modal fade" id="assignGroupModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="assignGroupForm" method="POST" action="{{ route('quotes.assignGroup') }}">
                    @csrf
                    <div class="modal-header" style="background:#1B3A2A;color:#fff;">
                        <h5 class="modal-title">Assign Group/week</h5>
                        <button type="button" class="btn-close" style="filter:invert(1)" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label style="font-weight:600;margin-bottom:6px;display:block;">Select Group</label>
                        <select name="group_id" class="form-select" required>
                            <option value="">-- Choose Group --</option>
                            @foreach($groups as $g)
                                <option value="{{ $g->id }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                        <small style="color:#666;display:block;margin-top:8px;">This group will be assigned to the selected customers.</small>
                        <label style="font-weight:600;margin-bottom:6px;display:block;margin-top:3%;">Select Week</label>
                        <select name="associated_week" class="form-select">
                            <option value="">-- Choose Week --</option>
                            <option value="Week 1">Week 1</option>
                            <option value="Week 2">Week 2</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn" style="background:#1B3A2A;color:#fff;">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EDIT ASSIGNED GROUP MODAL --}}
    <div class="modal fade" id="editAssignGroupModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editAssignGroupForm" method="POST" action="{{ route('quotes.assignGroup') }}">
                    @csrf
                    <div class="modal-header" style="background:#f59e0b;color:#fff;">
                        <h5 class="modal-title">Edit Assigned Group</h5>
                        <button type="button" class="btn-close" style="filter:invert(1)" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label style="font-weight:600;margin-bottom:6px;display:block;">Change Group</label>
                        <select name="group_id" id="editGroupSelect" class="form-select">
                            <option value="">-- No Group (Unassign) --</option>
                            @foreach($groups as $g)
                                <option value="{{ $g->id }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                        <small style="color:#666;display:block;margin-top:8px;">If selected, group will be updated. Leave as "No Group" to remove it.</small>
                        <label style="font-weight:600;margin-bottom:6px;display:block;margin-top:15px;">Change Week</label>
                        <select name="associated_week" id="editWeekSelect" class="form-select">
                            <option value="">-- No Week (Unassign) --</option>
                            <option value="Week 1">Week 1</option>
                            <option value="Week 2">Week 2</option>
                        </select>
                        <small style="color:#666;display:block;margin-top:8px;">Select a week or choose "No Week" to remove it.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn" style="background:#f59e0b;color:#fff;">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/responsive-table.js') }}"></script>

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

        function showCustTab(tab){
            document.querySelectorAll('.cust-tab').forEach(t => t.classList.toggle('active', t.dataset.tab === tab));
            document.querySelectorAll('.cust-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('panel-' + tab).classList.add('active');
            try { sessionStorage.setItem('custTab', tab); } catch (e) {}
        }

        // reopen the last tab after a reload (e.g. after "Move to All" on the Active tab)
        try { if (sessionStorage.getItem('custTab') === 'active') showCustTab('active'); } catch (e) {}


        function goToRouteOptimization(){
            let selected = [];
            document.querySelectorAll('.quote-checkbox:checked').forEach((cb) => selected.push(cb.value));
            if(selected.length === 0){ alert("Please select at least one customer"); return; }
            window.location.href = "/route-optimization?quote_ids=" + selected.join(',');
        }

        function getCheckedQuoteIds(){ return Array.from(document.querySelectorAll('.quote-checkbox:checked')).map(c => c.value); }
        function fillQuoteIds(formId, ids){
            const form = document.getElementById(formId);
            form.querySelectorAll('input[name="quote_ids[]"]').forEach(el => el.remove());
            ids.forEach(id => { const i = document.createElement('input'); i.type='hidden'; i.name='quote_ids[]'; i.value=id; form.appendChild(i); });
        }
        function openAssignGroup(){
            const ids = getCheckedQuoteIds();
            if(!ids.length){ alert('Please select at least one customer (checkbox).'); return; }
            fillQuoteIds('assignGroupForm', ids);
            new bootstrap.Modal(document.getElementById('assignGroupModal')).show();
        }
        function openEditAssignGroup(){
            const checked = Array.from(document.querySelectorAll('.quote-checkbox:checked'));
            if(!checked.length){ alert('Please select at least one customer (checkbox).'); return; }
            const ids = checked.map(c => c.value);
            fillQuoteIds('editAssignGroupForm', ids);
            const groupSel = document.getElementById('editGroupSelect');
            const weekSel  = document.getElementById('editWeekSelect');
            if(checked.length === 1){
                const curGroup = (checked[0].dataset.group || '').trim();
                const curWeek  = (checked[0].dataset.week  || '').trim();
                let matched = '';
                Array.from(groupSel.options).forEach(opt => { if(opt.text.trim() === curGroup) matched = opt.value; });
                groupSel.value = matched;
                weekSel.value = curWeek;
            } else { groupSel.value=''; weekSel.value=''; }
            new bootstrap.Modal(document.getElementById('editAssignGroupModal')).show();
        }
    </script>

</x-layout>