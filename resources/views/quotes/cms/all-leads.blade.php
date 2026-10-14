<x-layout>

    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">

    <style>
        /* FILTER */

        .filter-container{
            background:#1B3A2A;
            padding:20px;
            border-radius:12px;
            margin-bottom:25px;
            box-shadow:0 10px 25px rgba(0,0,0,0.25);
            border:1px solid rgba(255,255,255,0.1);
        }

        .filter-form{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
            align-items:center;
        }

        /* INPUT */

        .filter-input{
            padding:10px 12px;
            border-radius:8px;
            border:1px solid rgba(255,255,255,0.2);
            background:black;
            color:white;
            outline:none;
            min-width:160px;
            transition:0.25s;
        }

        .filter-input::placeholder{
            color:#aaa;
        }

        .filter-input:focus{
            border-color:white;
            box-shadow:0 0 0 2px rgba(255,255,255,0.15);
        }

        /* FILTER BUTTON */

        .filter-btn{
            background:white;
            color:#1B3A2A;
            border:none;
            padding:10px 20px;
            border-radius:8px;
            cursor:pointer;
            font-weight:600;
            transition:0.25s;
        }

        .filter-btn:hover{
            background:black;
            color:white;
            transform:translateY(-2px);
            box-shadow:0 6px 14px rgba(0,0,0,0.25);
        }

        /* RESET BUTTON */

        .reset-btn{
            background:black;
            color:white;
            padding:10px 20px;
            border-radius:8px;
            text-decoration:none;
            font-weight:600;
            transition:0.25s;
        }

        .reset-btn:hover{
            background:white;
            color:#1B3A2A;
            transform:translateY(-2px);
            box-shadow:0 6px 14px rgba(0,0,0,0.25);
        }

        /* MOBILE */

        @media (max-width:768px){

            .filter-form{
                flex-direction:column;
                align-items:stretch;
            }

            .filter-input{
                width:100%;
                min-width:100%;
            }

            .filter-btn,
            .reset-btn{
                width:100%;
                text-align:center;
            }

        }



        @media (max-width: 768px) {

            td:last-child {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
            }

            td:last-child a,
            td:last-child button {
                flex: 1 1 48%;
                text-align: center;
                font-size: 12px;
                padding: 6px;
            }

            td:last-child form {
                flex: 1 1 48%;
            }
        }




         .action-btn {
             border-radius: 50px;
             padding: 5px 12px;
             font-size: 13px;
             font-weight: 500;
             transition: all 0.3s ease;
         }

        /* Preview */
        .btn-preview {
            background: #1B3A2A;
            color: white;
        }
        .btn-preview:hover {
            background: black;
            transform: translateY(-2px);
        }

        /* Edit */
        .btn-edit {
            background: #f59e0b;
            color: white;
        }
        .btn-edit:hover {
            background: #d97706;
            transform: translateY(-2px);
        }

        /* success */
        .btn-success {
            background: green;
            color: white;
        }
        .btn-success:hover {
            background: #0f5c0f;
            transform: translateY(-2px);
        }

        /* Delete */
        .btn-delete {
            background: #e3342f;
            color: white;
        }
        .btn-delete:hover {
            background: #c81e1e;
            transform: translateY(-2px);
        }
        @media(max-width:768px){
            .btn-delete {
               width:100%;
            }
        }



    </style>

    <!-- SIDEBAR COMPONENT -->
    <x-sidebar/>

    <!-- MAIN -->

    <div class="main" id="mainContent">

        <div class="header">

            <div class="menu-btn" onclick="openSidebar()">☰</div>

            <h1>All Leads</h1>

            <a href="/create-leads"><button class="btn">Create Leads</button></a>

        </div>
        @if(session('success'))
            <div style="background-color:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- FILTER -->

        <div class="filter-container">

            <form method="GET" action="{{ route('leads.index') }}" class="filter-form">



                <input type="text"
                       name="client"
                       placeholder="Client Name"
                       value="{{ request('client') }}"
                       class="filter-input">

                <input type="text"
                       name="email"
                       placeholder="Email"
                       value="{{ request('email') }}"
                       class="filter-input">

                <select name="status" class="filter-input">
                    <option value="">All Status</option>
                    <option value="New" {{ request('status')=='New' ? 'selected':'' }}>New</option>
                    <option value="Contacted" {{ request('status')=='Contacted' ? 'selected':'' }}>Contacted</option>
                    <option value="Closed" {{ request('status')=='Closed' ? 'selected':'' }}>Closed</option>
                </select>

                <select name="payment_status" class="filter-input">
                    <option value="">Payment</option>
                    <option value="Paid" {{ request('payment_status')=='Paid' ? 'selected':'' }}>Paid</option>
                    <option value="Unpaid" {{ request('payment_status')=='Unpaid' ? 'selected':'' }}>Unpaid</option>
                </select>

                <input type="date"
                       name="date"
                       value="{{ request('date') }}"
                       class="filter-input text-white">

                <button type="submit" class="filter-btn">Filter</button>

                <a href="{{ route('leads.index') }}" class="reset-btn">Reset</a>

            </form>

        </div>



        <!-- TABLE -->

        <div class="table-container">

            <h2 style="margin-bottom:15px;">All Quotes</h2>

            <div class="table-wrapper" style="min-width:400px; overflow-x:auto;">

                <table border="1" cellpadding="10" cellspacing="0" style="min-width:2100px; width:100%;">
                    <thead >
                    <tr>
                        <th>ID</th>
                        <th>Sr#</th>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @php
                        // Descending serial across pagination
                        $total = $leads->total() - (($leads->currentPage() - 1) * $leads->perPage());
                    @endphp
                    @foreach($leads as $lead)
                        <tr>
                            <td>#{{ $lead->id }}</td>
                            <td>{{ $total - $loop->index }}</td>
                            <td>{{ $lead->first_name }} {{ $lead->last_name }}</td>
                            <td>{{ $lead->email }}</td>
                            <td>{{ $lead->phone }}</td>
                            <td>{{ $lead->address }}</td>
                            <td>
                        <span class="fw-bold
                            {{ $lead->status == 'Closed' ? 'text-success' : ($lead->status == 'Contacted' ? 'text-warning' : 'text-primary') }}">
                            {{ $lead->status ?? 'N/A' }}
                        </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($lead->date_of_lead)->format('d M Y') }}</td>
                            <td>{{ $lead->total_charges ?? '-' }}</td>
                            <td class="text-center">

                                <!-- Preview -->
                                <button onclick="previewLead({{ $lead->id }})"
                                        class="btn btn-sm action-btn btn-preview me-1" title="Preview">
                                    <i class="fas fa-eye me-1"></i> Preview
                                </button>

                                <!-- Edit -->
                                <a href="{{ route('leads.edit', $lead->id) }}"
                                   class="btn btn-sm action-btn btn-edit me-1" title="Edit">
                                    <i class="fas fa-pen me-1"></i> Edit
                                </a>
                                <!-- Edit -->
                                <a href="{{ url('/quote-create?lead_id=' . $lead->id) }}"
                                   class="btn btn-sm action-btn btn-success me-1" target="_blank">
                                    <i class="fas fa-pen me-1"></i> Create Quote
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('leads.delete', $lead->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this lead?')"
                                            class="btn btn-sm action-btn btn-delete " title="Delete" >
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

             <!-- Pagination Links -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $leads->links('pagination::bootstrap-5') }}
                </div>

        </div>

    </div>


    <script>

        function openSidebar(){
            document.getElementById("sidebar").classList.add("active");
        }

        function closeSidebar(){
            document.getElementById("sidebar").classList.remove("active");
        }

        document.addEventListener("click",function(e){

            let sidebar=document.getElementById("sidebar");
            let menu=document.querySelector(".menu-btn");

            if(
                sidebar.classList.contains("active") &&
                !sidebar.contains(e.target) &&
                !menu.contains(e.target)
            ){
                sidebar.classList.remove("active");
            }

        });

    </script>


    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background:#1B3A2A;color:white;">
                    <h5 class="modal-title">Lead Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="previewContent">
                    <!-- Data will come here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewLead(id) {
            fetch('/leads/' + id)
                .then(res => res.json())
                .then(data => {

                    let html = `
            <div class="container-fluid">

                <!-- BASIC INFO -->
                <h6 class="mb-3  fw-bold" style="background-color:black;color:white;padding:9px 6px;text-align:center;">Basic Information</h6>
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Name:</strong> ${data.first_name} ${data.last_name}</div>
                    <div class="col-md-6"><strong>Email:</strong> ${data.email}</div>
                    <div class="col-md-6"><strong>Phone:</strong> ${data.phone}</div>
                    <div class="col-md-6"><strong>Address:</strong> ${data.address}</div>
                </div>

                <!-- LEAD DETAILS -->
                <h6 class="mb-3  fw-bold" style="background-color:black;color:white;padding:9px 6px;text-align:center;">Lead Details</h6>
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Date of Lead:</strong> ${data.date_of_lead ?? '-'}</div>
                    <div class="col-md-6"><strong>Source:</strong> ${data.source ?? '-'}</div>
                    <div class="col-md-6"><strong>Property Type:</strong> ${data.property_type ?? '-'}</div>
                    <div class="col-md-6"><strong>Commercial Size:</strong> ${data.commercial_property_size ?? '-'}</div>
                     <div class="col-md-6"><strong>Services:</strong> ${data.service ?? '-'}</div>
                      <div class="col-md-6"><strong>Sub Services:</strong> ${data.sub_services ?? '-'}</div>
                </div>

                <!-- STATUS -->
                <h6 class="mb-3  fw-bold" style="background-color:black;color:white;padding:9px 6px;text-align:center;">Status Info</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <span class="badge bg-primary">${data.status ?? '-'}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Client Status:</strong>
                        <span class="badge bg-dark">${data.client_status ?? '-'}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Payment:</strong>
                        <span class="badge ${data.payment_status == 'Paid' ? 'bg-success' : 'bg-danger'}">
                            ${data.payment_status ?? '-'}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Visit Status:</strong>
                        <span class="badge bg-warning text-dark">${data.visit_status ?? '-'}</span>
                    </div>
                </div>

                <!-- PACKAGE -->
                <h6 class="mb-3  fw-bold" style="background-color:black;color:white;padding:9px 6px;text-align:center;">Package Details</h6>
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Frequency:</strong> ${data.frequency_selected ?? '-'}</div>
                    <div class="col-md-6"><strong>Package:</strong> ${data.package_selected ?? '-'}</div>
                    <div class="col-md-6"><strong>Per Visit:</strong> ${data.per_visit_charges ?? '-'}</div>
                    <div class="col-md-6"><strong>Total Charges:</strong> ${data.total_charges ?? '-'}</div>
                </div>

                <!-- VISIT -->
                <h6 class="mb-3  fw-bold" style="background-color:black;color:white;padding:9px 6px;text-align:center;">Visit Info</h6>
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Visit Number:</strong> ${data.visit_number ?? '-'}</div>
                    <div class="col-md-6"><strong>Visit Date:</strong> ${data.visit_date ?? '-'}</div>
                    <div class="col-md-6"><strong>Visit Time:</strong> ${data.visit_time ?? '-'}</div>
                </div>

                <!-- MESSAGE -->
                <h6 class="mb-3  fw-bold" style="background-color:black;color:white;padding:9px 6px;text-align:center;">Message & Notes</h6>
                <div class="mb-3">
                    <strong>Message:</strong>
                    <div class="border rounded p-2 bg-light text-dark">${data.message ?? '-'}</div>
                </div>

                <div class="mb-3">
                    <strong>Comments:</strong>
                    <div class="border rounded p-2 bg-light text-dark">${data.comments ?? '-'}</div>
                </div>

            </div>
            `;

                    document.getElementById('previewContent').innerHTML = html;

                    let modal = new bootstrap.Modal(document.getElementById('previewModal'));
                    modal.show();
                });
        }
    </script>

</x-layout>
