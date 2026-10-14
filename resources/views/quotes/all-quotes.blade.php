<x-layout>

    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            .table-container h2{ font-size:18px; }
        }


        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .table-wrapper table {
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* optional: smooth scroll */
        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }


 
    </style>

    <!-- SIDEBAR COMPONENT -->
    <x-sidebar/>

    <!-- MAIN -->

    <div class="main" id="mainContent">

        <div class="header">

            <div class="menu-btn" onclick="openSidebar()">☰</div>

            <h1>All Quotes</h1>

            <a href="/quote-create" target="_blank"><button class="btn">Create Quote</button></a>

        </div>
        @if(session('success'))
            <div style="background-color:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- FILTER -->

        <div class="filter-container">

            <form method="GET" action="{{ route('quotes.all') }}" class="filter-form">

                <!-- <input type="text"
                       name="quote_number"
                       placeholder="Quote #"
                       value="{{ request('quote_number') }}"
                       class="filter-input"> -->

                <input type="text"
                       name="client"
                       placeholder="Client"
                       value="{{ request('client') }}"
                       class="filter-input">

                <input type="text"
                       name="email"
                       placeholder="Email"
                       value="{{ request('email') }}"
                       class="filter-input">

                <input type="text"
                        name="phone"
                        placeholder="Phone"
                        value="{{ request('phone') }}"
                        class="filter-input">

                <x-address-filter />

               <select name="status" class="filter-input">

            <option value="">All Status</option>

            <option value="declined" {{ request('status')=='declined' ? 'selected':'' }}>
                Declined
            </option>

            <option value="signed" {{ request('status')=='signed' ? 'selected':'' }}>
                Signed
            </option>

            <option value="sent" {{ request('status')=='sent' ? 'selected':'' }}>
                Quote Sent
            </option>

            <option value="pending" {{ request('status')=='pending' ? 'selected':'' }}>
                Pending
            </option>

        </select>

                <button type="submit" class="filter-btn">
                    Filter
                </button>
               

                <a href="{{ route('quotes.all') }}" class="reset-btn">
                    Reset
                </a>
                 <button type="submit"
                formaction="{{ route('quotes.export') }}"
                class="filter-btn">
                  Export CSV
              </button>

            </form>


            <!-- -----------------------downlaoding -->

            <!-- -----------------------------downlaoding end-- -->
             

        </div>



 <!-- TOP ACTION BUTTONS -->
    <div class="top-actions" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:15px;">

        <button type="button" onclick="goToRouteOptimization()"
            style="background:#16a34a;color:white;border:none;padding:10px 18px;border-radius:8px;cursor:pointer;">
            Optimize Selected Route
        </button>

        <button type="button" onclick="openAssignGroup()"
            style="background:#1f3d2b;color:white;border:none;padding:10px 18px;border-radius:8px;cursor:pointer;">
            <i class="fa-solid fa-layer-group"></i> Assign Group/Week
        </button>

        <button type="button" onclick="openEditAssignGroup()"
            style="background:#f59e0b;color:white;border:none;padding:10px 18px;border-radius:8px;cursor:pointer;">
            <i class="fa-solid fa-pen"></i> Edit Assigned Group/Week
        </button>
       <button type="button" onclick="openUpdateStatus()"
    style="background:#2563eb;color:white;border:none;padding:10px 18px;border-radius:8px;cursor:pointer;">
    <i class="fa-solid fa-rotate"></i> Update Status
</button>

    </div>

        <div class="table-container">

            <h2 style="margin-bottom:15px;">All Quotes</h2>

            <div class="table-wrapper" style="min-width:400px; overflow-x:auto;">

                <table class="resp-table" border="1" cellpadding="11" cellspacing="0" style="min-width:1700px; width:100%;">
                    <thead>
                    <tr>
                      <th style="width:90px;">Assign</th>
                        <th style="width:90px;">Quote #</th>
                        <th style="width:180px;">Client</th>
                        <th style="width:250px;">Email</th>
                        <th style="width:180px;">Phone</th>
                        <th style="width:280px;">Address</th>
                        <th style="width:180px;">Status</th>
                        <th style="width:180px;">payment method</th>
                        <th style="width:130px;">Date</th>
                        <th style="width:100px;">Total</th>
                        <th style="width:150px;">Group</th>
                        <th style="width:120px;">Week</th>

                        <!-- ✅ Separated Logs -->
                            <th style="width:250px;">
                                <a href="{{ request()->fullUrlWithQuery([
                                    'sort' => 'email_logs',
                                    'order' => (request('sort') == 'email_logs' && request('order') == 'asc') ? 'desc' : 'asc'
                                ]) }}" style="color:inherit;text-decoration:none;">

                                    Email Logs

                                    @if(request('sort') == 'email_logs')
                                        <i class="fa-solid {{ request('order') == 'asc' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                                    @else
                                        <i class="fa-solid fa-sort" style="opacity:0.4"></i>
                                    @endif

                                </a>
                            </th>
                        <th style="width:250px;">Schedule Logs</th>

                        <th style="width:160px;">Opened/Not</th>

                     <th style="width:190px;">
                        <a href="{{ request()->fullUrlWithQuery([
                            'sort' => 'signed_at',
                            'order' => (request('sort') == 'signed_at' && request('order') == 'asc') ? 'desc' : 'asc'
                        ]) }}" style="color:inherit;text-decoration:none;">

                            Signed At

                            @if(request('sort') == 'signed_at')
                                <i class="fa-solid {{ request('order') == 'asc' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            @else
                                <i class="fa-solid fa-sort" style="opacity:0.4"></i>
                            @endif

                        </a>
                    </th>
                      <th style="width:160px;">Signed Reason</th>
                        <th style="width:860px;">Action</th>
                    </tr>
                    </thead>

                    <tbody>

                    @forelse($quotes as $quote)

                        <tr>

                          <td>
                          <input type="checkbox" class="quote-checkbox"
       value="{{ $quote->id }}"
       data-group="{{ $quote->associated_group }}"
       data-week="{{ $quote->associated_week }}"
       data-client-name="{{ $quote->client_name }}">  
                            </td>

                            <td>#{{ $quote->id }}</td>

                            <td>{{ $quote->client_name }}</td>

                            <td>{{ $quote->client_email }}</td>
                            <td>{{ $quote->client_phone }}</td>
                             <td>{{ $quote->client_address }}</td>

                           <td>
                                @if($quote->status === 'Voided')

                                    <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#dc2626;color:#fff;border-radius:20px;font-size:13px;font-weight:700;">
                                        <i class="fa-solid fa-circle-xmark"></i> Voided
                                    </span>

                                @elseif($quote->status === 'declined')

                                    <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#fee2e2;color:#dc2626;border-radius:20px;font-size:13px;font-weight:700;">
                                        <i class="fa-solid fa-circle-xmark"></i> Declined
                                    </span>

                                @elseif($quote->signed == 1 && $quote->status === 'accepted')

                                    <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#dcfce7;color:#16a34a;border-radius:20px;font-size:13px;font-weight:700;">
                                        <i class="fa-solid fa-circle-check"></i> Signed
                                    </span>

                                @elseif($quote->emailLogs->where('type','quote_sent')->count() > 0)

                                    <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#dbeafe;color:#2563eb;border-radius:20px;font-size:13px;font-weight:700;">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Quote Sent
                                    </span>

                                @else

                                    <span style="display:inline-block;width:130px;text-align:center;padding:6px 0;background:#fef3c7;color:#d97706;border-radius:20px;font-size:13px;font-weight:700;">
                                        <i class="fa-solid fa-hourglass-half"></i> Pending
                                    </span>

                                @endif
                            </td>

                              <td>
    @if($quote->payment_method)
        <span style="
            display:inline-block;
            min-width:130px;
            text-align:center;
            padding:6px 14px;
            background:orange;
            color:white;
            border-radius:20px;
            font-size:13px;
            font-weight:bold;
        ">
            {{ $quote->payment_method }}
        </span>
    @else
        -
    @endif
</td>

                            <td>{{ \Carbon\Carbon::parse($quote->date)->format('d M Y') }}</td>

                            <td>${{ $quote->total }}</td>

                            <!-- ✅ Assigned Group -->
                       <td>
                        @if($quote->associated_group)
                            <span style="display:inline-block;padding:5px 12px;background:#dcfce7;color:#16a34a;border-radius:20px;font-size:12px;font-weight:700;">
                                {{ $quote->associated_group }}
                            </span>
                        @else
                            <span style="color:gray;">—</span>
                        @endif
                    </td>

                            <!-- ✅ Assigned Week -->
                       <td>
                        @if($quote->associated_week)
                            <span style="display:inline-block;padding:5px 12px;background:#dbeafe;color:#2563eb;border-radius:20px;font-size:12px;font-weight:700;">
                                {{ $quote->associated_week }}
                            </span>
                        @else
                            <span style="color:gray;">—</span>
                        @endif
                    </td>

                            <!-- ✅ Email Logs -->
                            <td>
                                <strong>{{ $quote->emailLogs->where('type','quote_sent')->count() }} times</strong>

                                <br>

                                @if($quote->emailLogs->where('type','quote_sent')->count() > 0)
                                    <small>
                                        {!! $quote->emailLogs->where('type','quote_sent')->map(function($log){
                                         return \Carbon\Carbon::parse($log->sent_at)->format('d M Y h:i A');
                                     })->implode('<br>') !!}
                                    </small>
                                @else
                                    <span style="color:gray;">No Quote Emails</span>
                                @endif
                            </td>

                            <!-- ✅ Schedule (Calendly) Logs -->
                            <td>
                                <strong>{{ $quote->emailLogs->where('type','calendly_sent')->count() }} times</strong>

                                <br>

                                @if($quote->emailLogs->where('type','calendly_sent')->count() > 0)
                                    <small>
                                        {{ $quote->emailLogs->where('type','calendly_sent')->map(function($log){
                                            return \Carbon\Carbon::parse($log->sent_at)->format('d M Y h:i A');
                                        })->implode(', ') }}
                                    </small>
                                @else
                                    <span style="color:gray;">No Schedule Emails</span>
                                @endif
                            </td>

                            <!-- ✅ Open Status -->
                            <td>
                                <br>

                                @foreach($quote->emailLogs as $log)
                                    <div style="font-size:12px;">
                                        @if($log->opened)
                                            <span style="display:inline-block;width:120px;text-align:center;padding:4px 0;margin-top:5px;background:#dcfce7;color:#16a34a;border-radius:20px;font-size:12px;font-weight:700;"><i class="fa-solid fa-circle-check"></i> (Opened)</span>
                                        @else
                                            <span style="display:inline-block;width:120px;text-align:center;padding:4px 0;margin-top:5px;background:#fee2e2;color:#dc2626;border-radius:20px;font-size:12px;font-weight:700;"><i class="fa-solid fa-circle-xmark"></i> (Not Opened)</span>
                                        @endif
                                    </div>
                                @endforeach
                            </td>

                            <td>
                                {{ $quote->signed_at ? \Carbon\Carbon::parse($quote->signed_at)->format('d M Y h:i A') : '-' }}
                            </td>
                            <td>${{ $quote->sign_reason }}</td>
                            <!-- ✅ Actions -->
                            <td>
                                <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">

                                    <!-- Preview -->
                                    <a href="{{ route('quote.view',$quote->id) }}"
                                       style="display:flex; align-items:center; gap:6px;
                                           padding:6px 14px; background:#1f3d2b; color:#fff;
                                           border-radius:20px; font-size:13px; text-decoration:none;">
                                        👁 Preview
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('quote.edit', $quote->id) }}"
                                       style="display:flex; align-items:center; gap:6px;
                                       padding:6px 14px; background:#f59e0b; color:#fff;
                                       border-radius:20px; font-size:13px; text-decoration:none;">
                                        <i class="fas fa-pen me-1"></i> Edit
                                    </a>

                                    <!-- Create Quote -->
                                    <a href="{{ route('quote.send',$quote->id) }}"
                                       style="display:flex; align-items:center; gap:6px;
                                       padding:6px 14px; background:#16a34a; color:#fff;
                                       border-radius:20px; font-size:13px; text-decoration:none;">
                                        <i class="fas fa-pen me-1"></i> Create Quote
                                                                </a>

                                  {{-- -------send quote--}}
                                    <a href="{{ route('quote.send',$quote->id) }}"
                                       style="display:flex; align-items:center; gap:6px;
                                       padding:6px 14px; background:white; color:black;
                                       border-radius:20px; font-size:13px; text-decoration:none; font-weight:600;">
                                        <i class="fa-regular fa-paper-plane"></i>  Send
                                    </a>

                                    {{-- -------void quote----------------------------------------------------------------------}}
                                    <!-- Void Button -->
                                    <a href="javascript:void(0)"
                                       data-bs-toggle="modal"
                                       data-bs-target="#voidModal{{ $quote->id }}"  style="display:flex; align-items:center; gap:6px;
                                       padding:6px 14px; background:black; color:white;
                                       border-radius:20px; font-size:13px; text-decoration:none; font-weight:600;">
                                        <i class="fa-regular fa-paper-plane"></i> Void Quote
                                    </a>

                                    <!-- Modal (INSIDE LOOP) -->
                                    <div class="modal fade" id="voidModal{{ $quote->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <form method="POST" action="{{ route('quote.void', $quote->id) }}">
                                                    @csrf

                                                    <div class="modal-header">
                                                        <h5 class="modal-title" style="color:black;font-weight:bold;">Reason for void</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <textarea name="reason" class="form-control" placeholder="Write your message " required></textarea>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-danger" type="submit">Void</button>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>



                                    <!-- Book Appointment -->
                                    <a href="{{ route('quote.sendCalendly', $quote->id) }}"
                                       style="display:flex; align-items:center; gap:6px;
                                        padding:6px 14px; background:#16a34a; color:#fff;
                                         border-radius:20px; font-size:13px; text-decoration:none;">

                                        <i class="fas fa-book me-1"></i> Book Appointment
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('quote.delete', $quote->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this quote?');"
                                                style="display:flex; align-items:center; gap:6px;
                                                padding:6px 14px; background:#ef4444; color:#fff;
                                                border:none; border-radius:20px; font-size:13px; cursor:pointer;">
                                            <i class="fas fa-trash me-1"></i>  Delete
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="16" style="text-align:center;">No Quotes Found</td>
                        </tr>

                    @endforelse

                    </tbody>
                </table>


            </div>
            <div style="margin-top:20px; display:flex; justify-content:end;color:white !important;">
                    {{ $quotes->links('pagination::bootstrap-5') }}
            </div>

        </div>

    </div>

{{-------------------------------------------------------------------------------void model--}}


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






<!-- ===============================================================assignemnt model -->
<script>
function goToRouteOptimization() {

    let selected = [];

    document.querySelectorAll('.quote-checkbox:checked').forEach((cb) => {
        selected.push(cb.value);
    });

    if(selected.length === 0){
        alert("Please select at least one quote");
        return;
    }

    let query = selected.join(',');

    window.location.href = "/route-optimization?quote_ids=" + query;
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/responsive-table.js') }}"></script>



    <!-- ==============================================================group assignment -->
     <!-- ASSIGN GROUP MODAL -->
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
                    <small style="color:#666;display:block;margin-top:8px;">This group will be assigned to the selected quotes.</small>
                 
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

<!-- EDIT ASSIGNED GROUP MODAL -->
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

    <!-- Group -->
    <label style="font-weight:600;margin-bottom:6px;display:block;">
        Change Group
    </label>

    <select name="group_id" id="editGroupSelect" class="form-select">
        <option value="">-- No Group (Unassign) --</option>
        @foreach($groups as $g)
            <option value="{{ $g->id }}">{{ $g->name }}</option>
        @endforeach
    </select>

    <small style="color:#666;display:block;margin-top:8px;">
        If selected, group will be updated. Leave as "No Group" to remove it.
    </small>

    <!-- Week -->
    <label style="font-weight:600;margin-bottom:6px;display:block;margin-top:15px;">
        Change Week
    </label>

    <select name="associated_week" id="editWeekSelect" class="form-select">
        <option value="">-- No Week (Unassign) --</option>
        <option value="Week 1">Week 1</option>
        <option value="Week 2">Week 2</option>
    </select>

    <small style="color:#666;display:block;margin-top:8px;">
        Select a week or choose "No Week" to remove it.
    </small>

</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background:#f59e0b;color:#fff;">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function getCheckedQuoteIds(){
        return Array.from(document.querySelectorAll('.quote-checkbox:checked')).map(c => c.value);
    }

    function fillQuoteIds(formId, ids){
        const form = document.getElementById(formId);
        form.querySelectorAll('input[name="quote_ids[]"]').forEach(el => el.remove());
        ids.forEach(id => {
            const i = document.createElement('input');
            i.type = 'hidden';
            i.name = 'quote_ids[]';
            i.value = id;
            form.appendChild(i);
        });
    }

    function openAssignGroup(){
        const ids = getCheckedQuoteIds();
        if(!ids.length){ alert('Please select at least one quote (checkbox).'); return; }
        fillQuoteIds('assignGroupForm', ids);
        new bootstrap.Modal(document.getElementById('assignGroupModal')).show();
    }

    function openEditAssignGroup(){
        const checked = Array.from(document.querySelectorAll('.quote-checkbox:checked'));
        if(!checked.length){ alert('Please select at least one quote (checkbox).'); return; }

        const ids = checked.map(c => c.value);
        fillQuoteIds('editAssignGroupForm', ids);

        const groupSel = document.getElementById('editGroupSelect');
        const weekSel  = document.getElementById('editWeekSelect');

        if(checked.length === 1){
            // single quote -> current group/week prefill
            const curGroup = (checked[0].dataset.group || '').trim();   // ye NAME hai
            const curWeek  = (checked[0].dataset.week  || '').trim();

            // group dropdown me value=id, text=name -> name se match karke select karo
            let matched = '';
            Array.from(groupSel.options).forEach(opt => {
                if(opt.text.trim() === curGroup) matched = opt.value;
            });
            groupSel.value = matched;

            weekSel.value = curWeek;
        } else {
            // multiple -> reset
            groupSel.value = '';
            weekSel.value  = '';
        }

        new bootstrap.Modal(document.getElementById('editAssignGroupModal')).show();
    }
</script>
<!-- ====================================================================status update -->

{{-- ============ PIECE 2 — MODAL (paste in page body, outside the table) ============ --}}
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none;border-radius:8px;overflow:hidden;">

            <form method="POST" action="{{ route('quotes.updateStatus') }}" id="updateStatusForm">
                @csrf

                {{-- which quote (filled by JS from the checked row) --}}
                <input type="hidden" name="quote_id" id="us_quote_id" value="">

                <div class="modal-header" style="background:#1f3d2b;color:#fff;border:none;">
                    <h5 class="modal-title" style="font-weight:700;">
                        Update Quote Status
                        <span id="us_quote_label" style="font-weight:400;opacity:.8;font-size:14px;"></span>
                    </h5>
                    <button type="button" class="btn-close" style="filter:invert(1);" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="padding:20px;">

                    {{-- STATUS --}}
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-weight:700;font-size:13px;margin-bottom:5px;">Status</label>
                        <select name="status_choice" id="us_status" class="form-select" required onchange="usToggleAcceptFields()">
                            <option value="">— Select status —</option>
                            <option value="accepted">Accepted (Signed)</option>
                            <option value="declined">Declined</option>
                            <option value="Voided">Voided</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>

                    {{-- ACCEPTED-ONLY FIELDS (shown only when status = accepted) --}}
                    <div id="us_accept_fields" style="display:none;">

                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-weight:700;font-size:13px;margin-bottom:5px;">Payment Method</label>
                            <input type="text" name="payment_method" id="us_payment_method" class="form-control"
                                   placeholder="e.g. Cash, e-Transfer, Cheque">
                        </div>

                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-weight:700;font-size:13px;margin-bottom:5px;">Signature</label>
                            <input type="text" name="signature" id="us_signature" class="form-control"
                                   placeholder="Client signature">
                        </div>

                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-weight:700;font-size:13px;margin-bottom:5px;">Name (Print)</label>
                            <input type="text" name="client_name_print" id="us_name_print" class="form-control"
                                   placeholder="Printed name (defaults to client name)">
                        </div>

                    </div>

                    {{-- NOTE / REASON (all statuses) --}}
                    <div style="margin-bottom:4px;">
                        <label style="display:block;font-weight:700;font-size:13px;margin-bottom:5px;">Note / Reason</label>
                        <textarea name="sign_reason" id="us_sign_reason" class="form-control" rows="3"
                                  placeholder="Optional note about this status change"></textarea>
                    </div>

                </div>

                <div class="modal-footer" style="border-top:1px solid #e5e7eb;padding:12px 20px;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn"
                            style="background:#1f3d2b;color:#fff;font-weight:700;">
                        Save Status
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


{{-- ============ PIECE 3 — SCRIPT (paste near your other scripts) ============ --}}
<script>
    // Holds the client name of the currently-selected row (for auto-fill).
    var usClientName = '';

    // Open the Update Status modal for the single checked row.
    function openUpdateStatus(){
        var checked = document.querySelectorAll('.quote-checkbox:checked');

        if(checked.length === 0){
            alert('Please select one quote (tick its checkbox) to update its status.');
            return;
        }
        if(checked.length > 1){
            alert('Please select only ONE quote. Status update (with signature) works on a single quote at a time.');
            return;
        }

        var box = checked[0];
        var quoteId = box.value;

        // grab client name off the checkbox (data-client-name)
        usClientName = box.dataset.clientName || '';

        // fill hidden id + label
        document.getElementById('us_quote_id').value = quoteId;
        document.getElementById('us_quote_label').textContent = '#' + quoteId;

        // reset fields
        document.getElementById('us_status').value = '';
        document.getElementById('us_payment_method').value = '';
        document.getElementById('us_signature').value = '';
        document.getElementById('us_name_print').value = '';
        document.getElementById('us_sign_reason').value = '';
        usToggleAcceptFields();

        // open (Bootstrap 5)
        var modalEl = document.getElementById('updateStatusModal');
        var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.show();
    }

    // Show payment/signature fields only when Accepted is chosen,
    // and auto-fill Signature + Name (Print) with the client's name.
    function usToggleAcceptFields(){
        var status = document.getElementById('us_status').value;
        var box = document.getElementById('us_accept_fields');
        var isAccepted = (status === 'accepted');

        box.style.display = isAccepted ? 'block' : 'none';

        if(isAccepted){
            var sig  = document.getElementById('us_signature');
            var name = document.getElementById('us_name_print');

            // Auto-fill with client name — only if the admin hasn't typed something,
            // so we never overwrite a value the admin edited themselves.
            if(!sig.value.trim())  { sig.value  = usClientName; }
            if(!name.value.trim()) { name.value = usClientName; }
        }
    }
</script>

</x-layout>