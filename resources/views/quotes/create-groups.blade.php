<x-layout>

    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">

    <style>
        .filter-container{
            background:#1B3A2A; padding:20px; border-radius:12px; margin-bottom:25px;
            box-shadow:0 10px 25px rgba(0,0,0,0.25); border:1px solid rgba(255,255,255,0.1);
        }
        .filter-form{ display:flex; gap:12px; flex-wrap:wrap; align-items:center; }
        .filter-input{
            padding:10px 12px; border-radius:8px; border:1px solid rgba(255,255,255,0.2);
            background:black; color:white; outline:none; min-width:160px; transition:0.25s;
        }
        .filter-input::placeholder{ color:#aaa; }
        .filter-input:focus{ border-color:white; box-shadow:0 0 0 2px rgba(255,255,255,0.15); }
        .filter-btn{
            background:white; color:#1B3A2A; border:none; padding:10px 20px;
            border-radius:8px; cursor:pointer; font-weight:600; transition:0.25s;
        }
        .filter-btn:hover{ background:black; color:white; transform:translateY(-2px); }
        .reset-btn{
            background:black; color:white; padding:10px 20px; border-radius:8px;
            text-decoration:none; font-weight:600; transition:0.25s;
        }
        .reset-btn:hover{ background:white; color:#1B3A2A; transform:translateY(-2px); }

        .action-btn{ border-radius:50px; padding:5px 12px; font-size:13px; font-weight:500; transition:all .3s ease; }
        .btn-edit{ background:#f59e0b; color:white; }
        .btn-edit:hover{ background:#d97706; transform:translateY(-2px); }
        .btn-delete{ background:#e3342f; color:white; }
        .btn-delete:hover{ background:#c81e1e; transform:translateY(-2px); }

        .badge-status{ font-size:12px; font-weight:600; padding:5px 12px; border-radius:50px; }
        .badge-active{ background:#dff0e6; color:#1b7a42; }
        .badge-inactive{ background:#fbe3e3; color:#b13434; }

        /* group modal */
        .grp-modal .modal-header{ background:#1B3A2A; color:#fff; }
        .grp-modal .modal-title{ font-weight:700; }
        .grp-modal .btn-close{ filter:invert(1); }
        .grp-modal label{ font-weight:600; font-size:13px; margin-bottom:4px; }
        .grp-modal .btn-save{ background:#1B3A2A; color:#fff; font-weight:600; }
        .grp-modal .btn-save:hover{ background:black; }

        @media (max-width:768px){
            .filter-form{ flex-direction:column; align-items:stretch; }
            .filter-input{ width:100%; min-width:100%; }
            .filter-btn,.reset-btn{ width:100%; text-align:center; }
            td:last-child{ display:flex; flex-wrap:wrap; gap:6px; }
            td:last-child a, td:last-child button{ flex:1 1 48%; text-align:center; font-size:12px; padding:6px; }
            td:last-child form{ flex:1 1 48%; }
        }
    </style>

    <!-- SIDEBAR -->
    <x-sidebar/>

    <!-- MAIN -->
    <div class="main" id="mainContent">

        <div class="header">
            <div class="menu-btn" onclick="openSidebar()">☰</div>
            <h1>Groups</h1>
            <button class="btn" data-bs-toggle="modal" data-bs-target="#addGroupModal">Create Group</button>
        </div>

        @if(session('success'))
            <div style="background-color:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- FILTER -->
        <div class="filter-container">
            <form method="GET" action="{{ route('groups.index') }}" class="filter-form">

                <input type="text" name="name" placeholder="Group Name"
                       value="{{ request('name') }}" class="filter-input">

                <select name="status" class="filter-input">
                    <option value="">All Status</option>
                    <option value="Active" {{ request('status')=='Active' ? 'selected':'' }}>Active</option>
                    <option value="Inactive" {{ request('status')=='Inactive' ? 'selected':'' }}>Inactive</option>
                </select>

                <button type="submit" class="filter-btn">Filter</button>
                <a href="{{ route('groups.index') }}" class="reset-btn">Reset</a>
            </form>
        </div>

        <!---------------------------------------------------------------------------------- TABLE -->
        <div class="table-container">

            <h2 style="margin-bottom:15px;">All Groups</h2>

            <div class="table-wrapper" style="overflow-x:auto;">
                <table border="1" cellpadding="10" cellspacing="0" style="width:100%; min-width:700px;">
                    <thead>
                    <tr>
                        <th>Sr#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @php
                        $sr = $groups->total() - (($groups->currentPage() - 1) * $groups->perPage());
                    @endphp
                    @forelse($groups as $group)
                        <tr>
                            <td>{{ $sr - $loop->index }}</td>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->description ?? '-' }}</td>
                            <td>
                                <span class="badge-status {{ $group->status == 'Active' ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $group->status }}
                                </span>
                            </td>
                            <td>{{ $group->created_at->format('d M Y') }}</td>
                            <td class="text-center">

                                <!-- Edit -->
                                <button type="button"
                                        class="btn btn-sm action-btn btn-edit me-1 grp-edit"
                                        data-action="{{ route('groups.update', $group->id) }}"
                                        data-name="{{ $group->name }}"
                                        data-description="{{ $group->description }}"
                                        data-status="{{ $group->status }}"
                                        title="Edit">
                                    <i class="fas fa-pen me-1"></i> Edit
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('groups.delete', $group->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this group?')"
                                            class="btn btn-sm action-btn btn-delete" title="Delete">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:18px; color:#777;">No groups found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $groups->links('pagination::bootstrap-5') }}
            </div>

        </div>

    </div>

    <!-- -------------------------------------------------------------------------ADD GROUP MODAL -->
    <div class="modal fade grp-modal" id="addGroupModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('groups.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Create Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Group Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-save">Save Group</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!------------------------------------------------------------------------ EDIT GROUP MODAL -->
    <div class="modal fade grp-modal" id="editGroupModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editGroupForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Group Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" id="edit_description" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" id="edit_status" class="form-select" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-save">Update Group</button>
                    </div>
                </form>
            </div>
        </div>
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

        // EDIT — prefill modal
        document.querySelectorAll('.grp-edit').forEach(function(btn){
            btn.addEventListener('click', function(){
                document.getElementById('editGroupForm').action = btn.dataset.action;
                document.getElementById('edit_name').value        = btn.dataset.name || '';
                document.getElementById('edit_description').value  = btn.dataset.description || '';
                document.getElementById('edit_status').value       = btn.dataset.status || 'Active';

                new bootstrap.Modal(document.getElementById('editGroupModal')).show();
            });
        });
    </script>

</x-layout>