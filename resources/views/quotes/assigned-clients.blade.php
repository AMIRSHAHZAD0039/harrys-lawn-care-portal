<x-layout>
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .acc-wrap{
            display:flex;
            flex-direction:column;
            gap:14px;
            margin-top:10px;
        }

        .acc-item{
            background:#fff;
            border-radius:12px;
          box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
            overflow:hidden;
        }

        .acc-head{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:18px 22px;
            cursor:pointer;
            background:#1B3A2A;
            color:#fff;
            user-select:none;
            transition:.25s;
        }

        .acc-head:hover{
            background:#15301f;
        }

        .acc-head-left{
            display:flex;
            flex-direction:column;
            gap:3px;
        }

        .acc-team{
            font-size:17px;
            font-weight:700;
        }

        .acc-email{
            font-size:13px;
            opacity:.8;
        }

        .acc-head-right{
            display:flex;
            align-items:center;
            gap:16px;
        }

        .acc-count{
            background:rgba(255,255,255,.15);
            padding:5px 14px;
            border-radius:20px;
            font-size:13px;
            font-weight:600;
            white-space:nowrap;
        }

        .acc-arrow{
            font-size:15px;
            width:18px;
            text-align:center;
            transition:transform .35s ease;
        }

        .acc-arrow .acc-up{
            display:none;
        }

        .acc-item.open .acc-arrow .acc-down{
            display:none;
        }

        .acc-item.open .acc-arrow .acc-up{
            display:inline;
        }

        /* JS controls max-height; these are just the easing + closed defaults */
        .acc-body{
            max-height:0;
            overflow:hidden;
            opacity:0;
            transition:max-height .45s cubic-bezier(0.4,0,0.2,1),
                       opacity .35s ease;
        }

        .acc-item.open .acc-body{
            opacity:1;
        }

        .acc-body-inner{
            padding:18px 22px;
            overflow-x:auto;
        }

        .acc-table{
            width:100%;
            min-width:1250px;
            border-collapse:collapse;
        }

        .acc-table th,
        .acc-table td{
            padding:11px 12px;
            text-align:left;
            border-bottom:1px solid #eee;
            font-size:14px;
        }

        .acc-table th{
            background:#f4f6f5;
            color:#1B3A2A;
            font-weight:700;
        }

        .acc-table tr:hover td{
            background:#fafafa;
        }

        .acc-stop{
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

        /* pills */
        .acc-pill{
            display:inline-block;
            padding:4px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
            white-space:nowrap;
        }

        .acc-pill-group{
            background:#e6f4ea;
            color:#1B3A2A;
        }

        .acc-pill-week{
            background:#eef2ff;
            color:#3730a3;
        }

        .acc-pill-empty{
            background:#f1f1f1;
            color:#999;
        }

        .acc-empty{
            padding:14px;
            color:#777;
            font-style:italic;
        }

        .no-teams{
            background:#fff;
            padding:30px;
            border-radius:12px;
            text-align:center;
            color:#777;
            box-shadow:0 8px 22px rgba(0,0,0,.08);
        }

        /* action buttons */
        .acc-actions{
            display:flex;
            gap:8px;
        }

        .acc-actions form{
            margin:0;
        }

        .acc-btn{
            border:none;
            cursor:pointer;
            padding:7px 11px;
            border-radius:8px;
            font-size:13px;
            color:#fff;
            display:inline-flex;
            align-items:center;
            gap:5px;
            transition:.2s;
        }

        .acc-btn-edit{
            background:#2563eb;
        }

        .acc-btn-edit:hover{
            background:#1d4ed8;
        }

        .acc-btn-del{
            background:#dc2626;
        }

        .acc-btn-del:hover{
            background:#b91c1c;
        }

        /* edit modal */
        .assign-modal{
            position:fixed;
            inset:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,.6);
            display:none;
            justify-content:center;
            align-items:center;
            z-index:99999;
            color:#000;
        }

        .assign-modal.active{
            display:flex;
        }

        .assign-modal-content{
            width:460px;
            max-width:92%;
            background:#fff;
            border-radius:12px;
            padding:26px;
            animation:assignPop .25s ease;
        }

        @keyframes assignPop{
            from{transform:scale(.85);opacity:0;}
            to{transform:scale(1);opacity:1;}
        }

        .assign-modal-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:18px;
        }

        .assign-modal-header h2{
            color:#1B3A2A;
            font-size:20px;
        }

        .assign-close{
            font-size:26px;
            cursor:pointer;
            line-height:1;
        }

        .assign-fg{
            margin-bottom:14px;
            display:flex;
            flex-direction:column;
            gap:6px;
        }

        .assign-fg label{
            font-weight:600;
            font-size:14px;
        }

        .assign-fg input,
        .assign-fg select{
            padding:10px;
            border:1px solid #ddd;
            border-radius:8px;
            width:100%;
            outline:none;
        }

        .assign-fg input:disabled{
            background:#f5f5f5;
            color:#888;
        }

        .assign-save{
            width:100%;
            background:#1B3A2A;
            color:#fff;
            border:none;
            padding:12px;
            border-radius:8px;
            cursor:pointer;
            font-weight:600;
            font-size:15px;
            margin-top:4px;
        }

        .assign-save:hover{
            background:#15301f;
        }
    </style>

    <!-- SIDEBAR COMPONENT -->
    <x-sidebar />

    <!-- MAIN -->
    <div class="main" id="mainContent">

        <div class="header">
            <div class="menu-btn" onclick="openSidebar()">☰</div>
            <h1>Assigned Clients</h1>

             {{-- PASTE HERE --}}
        <form action="{{ route('routes.weekly') }}" method="POST">
            @csrf
            <input type="date" name="service_date"
                   style="padding:8px;border:1px solid #ddd;border-radius:8px;">
            <button type="submit" class="btn">Generate This Week's Routes</button>
        </form>
        </div>

        @if(session('success'))
            <div style="background:#d1fae5;color:#065f46;padding:12px;border-radius:8px;margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="acc-wrap">

            @forelse($teams as $team)

                <div class="acc-item">

                    <div class="acc-head" onclick="toggleAcc(this)">

                        <div class="acc-head-left">
                            <span class="acc-team">{{ $team->name }}</span>
                            <span class="acc-email">{{ $team->email ?? '—' }}</span>
                        </div>

                        <div class="acc-head-right">
                            <span class="acc-count">{{ count($team->clients) }} clients</span>
                            <span class="acc-arrow">
                                <i class="fa-solid fa-chevron-down acc-down"></i>
                                <i class="fa-solid fa-chevron-up acc-up"></i>
                            </span>
                        </div>

                    </div>

                    <div class="acc-body">
                        <div class="acc-body-inner">

                            @if(count($team->clients))

                                <table class="acc-table">
                                    <thead>
                                        <tr>
                                            <th>Stop</th>
                                            <th>Client Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Associated Group</th>
                                            <th>Associated Week</th>
                                            <th>Service Type</th>
                                            <th>Frequency</th>
                                            <th>Total</th>
                                            <th>Service Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($team->clients as $client)
                                            <tr>
                                                <td><span class="acc-stop">{{ $client->stop_order }}</span></td>
                                                <td>{{ $client->client_name ?? '—' }}</td>
                                                <td>{{ $client->client_email ?? '—' }}</td>
                                                <td>{{ $client->client_phone ?? '—' }}</td>
                                                <td>{{ $client->client_address ?? '—' }}</td>

                                                <td>
                                                    @if($client->associated_group)
                                                        <span class="acc-pill acc-pill-group">{{ $client->associated_group }}</span>
                                                    @else
                                                        <span class="acc-pill acc-pill-empty">—</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if($client->associated_week)
                                                        <span class="acc-pill acc-pill-week">{{ $client->associated_week }}</span>
                                                    @else
                                                        <span class="acc-pill acc-pill-empty">—</span>
                                                    @endif
                                                </td>

                                                <td>{{ $client->service_type ?? '—' }}</td>
                                                <td>{{ $client->seasonal_frequency ?? '—' }}</td>
                                                <td>{{ $client->total ? '$'.number_format($client->total, 2) : '—' }}</td>
                                                <td>{{ $client->service_date ?? '—' }}</td>

                                                <td>
                                                    <div class="acc-actions">

                                                        <button
                                                            type="button"
                                                            class="acc-btn acc-btn-edit"
                                                            onclick="openAssignModal({{ $client->assignment_id }})">
                                                            <i class="fa-solid fa-pen"></i> Edit
                                                        </button>

                                                        <form
                                                            action="{{ route('assignment.destroy', $client->assignment_id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Remove this assignment?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="acc-btn acc-btn-del">
                                                                <i class="fa-solid fa-trash"></i> Delete
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- EDIT MODALS (kept outside <tbody>; fixed-position so they escape the accordion clip) --}}
                                @foreach($team->clients as $client)
                                    <div id="editAssignModal{{ $client->assignment_id }}" class="assign-modal">
                                        <div class="assign-modal-content">

                                            <div class="assign-modal-header">
                                                <h2>Edit Assignment</h2>
                                                <span class="assign-close" onclick="closeAssignModal({{ $client->assignment_id }})">&times;</span>
                                            </div>

                                            <form action="{{ route('assignment.update', $client->assignment_id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="assign-fg">
                                                    <label>Client</label>
                                                    <input type="text" value="{{ $client->client_name ?? $client->client_address ?? 'Quote #'.$client->id }}" disabled>
                                                </div>

                                                <div class="assign-fg">
                                                    <label>Assign To Team</label>
                                                    <select name="team_id" required>
                                                        @foreach($teams as $t)
                                                            <option value="{{ $t->id }}" {{ $t->id == $team->id ? 'selected' : '' }}>
                                                                {{ $t->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="assign-fg">
                                                    <label>Service Date</label>
                                                    <input
                                                        type="date"
                                                        name="service_date"
                                                        value="{{ $client->service_date ? \Carbon\Carbon::parse($client->service_date)->format('Y-m-d') : '' }}">
                                                </div>

                                                <button type="submit" class="assign-save">Update Assignment</button>
                                            </form>

                                        </div>
                                    </div>
                                @endforeach

                            @else
                                <div class="acc-empty">No clients assigned to this team.</div>
                            @endif

                        </div>
                    </div>

                </div>

            @empty
                <div class="no-teams">No teams found.</div>
            @endforelse

        </div>

    </div>

    <script>
        function openSidebar(){
            document.getElementById("sidebar").classList.add("active");
        }

        function closeSidebar(){
            document.getElementById("sidebar").classList.remove("active");
        }

        document.addEventListener("click", function(e){
            let sidebar = document.getElementById("sidebar");
            let menu = document.querySelector(".menu-btn");

            if(
                sidebar.classList.contains("active") &&
                !sidebar.contains(e.target) &&
                !menu.contains(e.target)
            ){
                sidebar.classList.remove("active");
            }
        });

        function toggleAcc(headEl){

            const item = headEl.parentElement;
            const body = item.querySelector('.acc-body');

            if(item.classList.contains('open')){

                // CLOSING: lock current height, then animate to 0
                body.style.maxHeight = body.scrollHeight + 'px';

                requestAnimationFrame(function(){
                    requestAnimationFrame(function(){
                        body.style.maxHeight = '0px';
                    });
                });

                item.classList.remove('open');

            } else {

                // OPENING: animate to real content height
                item.classList.add('open');
                body.style.maxHeight = body.scrollHeight + 'px';

                body.addEventListener('transitionend', function te(ev){
                    if(ev.propertyName === 'max-height' && item.classList.contains('open')){
                        body.style.maxHeight = 'none';
                    }
                    body.removeEventListener('transitionend', te);
                });
            }
        }

        // ---- edit modal open/close ----
        function openAssignModal(id){
            document.getElementById('editAssignModal'+id).classList.add('active');
        }

        function closeAssignModal(id){
            document.getElementById('editAssignModal'+id).classList.remove('active');
        }

        // close modal when clicking the dark backdrop
        window.addEventListener('click', function(e){
            if(e.target.classList.contains('assign-modal')){
                e.target.classList.remove('active');
            }
        });
    </script>

</x-layout>