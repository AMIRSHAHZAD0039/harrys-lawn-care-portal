<x-layout>
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <style>
        .settings-wrapper{
            display:flex;
            justify-content:center;
            margin-top:40px;
        }

        .settings-card{
            width:650px;
            background:white;
            padding:35px;
            border-radius:12px;
            box-shadow:0 15px 35px rgba(0,0,0,0.1);
        }

        .settings-card h2{
            margin-bottom:20px;
            color:#1B3A2A;
        }

        .settings-form{
            display:flex;
            flex-direction:column;
            gap:20px;
        }

        .form-row{
            display:flex;
            gap:20px;
        }

        .form-group{
            flex:1;
            display:flex;
            flex-direction:column;
            gap:6px;
        }

        .form-group label{
            font-weight:600;
        }

        .form-group input{
            padding:11px;
            border-radius:8px;
            border:1px solid #ddd;
            outline:none;
            transition:0.3s;
        }

        .form-group input:focus{
            border-color:#1B3A2A;
            box-shadow:0 0 0 2px rgba(27,58,42,0.15);
        }

        .update-btn{
            margin-top:10px;
            background:#1B3A2A;
            color:white;
            padding:12px;
            border:none;
            border-radius:8px;
            font-weight:600;
            cursor:pointer;
            transition:.3s;
        }

        .update-btn:hover{
            background:black;
            transform:translateY(-2px);
        }

        .success-msg{
            background:#d1fae5;
            color:#065f46;
            padding:10px;
            border-radius:6px;
            margin-bottom:15px;
        }

        @media(max-width:768px){

            .form-row{
                flex-direction:column;
            }

            .settings-card{
                width:100%;
            }

        }


        /* ------------------ MODAL ------------------ */
        .team-modal{
            position:fixed;
            inset:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,.6);
            display:none;
            z-index:99999;
            color:#1f2937;
            padding:20px;
            overflow-y:auto;                 /* overlay scrolls if needed */
            overscroll-behavior:contain;
            -webkit-overflow-scrolling:touch;
        }

        .team-modal.active{
            display:flex;
        }

        .team-modal-content{
            width:500px;
            max-width:100%;
            margin:auto;                     /* centers + allows scroll when tall */
            max-height:calc(100vh - 40px);   /* never exceeds the viewport */
            background:#fff;
            border-radius:14px;
            box-shadow:0 25px 60px rgba(0,0,0,.35);
            animation:popup .25s ease;
            display:flex;
            flex-direction:column;
            overflow:hidden;                 /* keeps rounded corners + inner scroll clean */
        }

        @keyframes popup{
            from{
                transform:scale(.92);
                opacity:0;
            }
            to{
                transform:scale(1);
                opacity:1;
            }
        }

        .modal-header{
            flex-shrink:0;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:18px 24px;
            border-bottom:1px solid #eef0ee;
        }

        .modal-header h2{
            margin:0;
            font-size:20px;
            color:#1B3A2A;
        }

        .close-modal{
            font-size:28px;
            line-height:1;
            cursor:pointer;
            color:#888;
            transition:.2s;
        }

        .close-modal:hover{
            color:#1B3A2A;
        }

        /* form is the flex column so body scrolls and footer stays pinned */
        .team-modal-content form{
            display:flex;
            flex-direction:column;
            flex:1 1 auto;
            min-height:0;                    /* critical so .modal-body can scroll */
            overflow:hidden;
        }

        .modal-body{
            flex:1 1 auto;
            min-height:0;
            overflow-y:auto;                 /* ONLY the fields scroll */
            padding:22px 24px;
        }

        .modal-footer{
            flex-shrink:0;
            padding:16px 24px;
            border-top:1px solid #eef0ee;
            background:#fff;
        }

        .team-modal .form-group{
            margin-bottom:15px;
        }

        .team-modal .form-group:last-child{
            margin-bottom:0;
        }

        .team-modal .form-group label{
            display:block;
            margin-bottom:6px;
            font-weight:600;
        }

        .team-modal .form-group input,
        .team-modal select{
            width:100%;
            padding:10px;
            border:1px solid #ddd;
            border-radius:8px;
            outline:none;
            transition:.2s;
        }

        .team-modal .form-group input:focus,
        .team-modal select:focus{
            border-color:#1B3A2A;
            box-shadow:0 0 0 2px rgba(27,58,42,.15);
        }

        .save-team-btn{
            width:100%;
            background:#1B3A2A;
            color:white;
            border:none;
            padding:12px;
            border-radius:8px;
            cursor:pointer;
            font-size:15px;
            font-weight:600;
            transition:.2s;
        }

        .save-team-btn:hover{
            background:black;
        }

        @media(max-width:768px){

            .team-modal{
                padding:14px;
            }

            .team-modal-content{
                max-height:calc(100vh - 28px);
            }

        }
    </style>
    <!-- SIDEBAR COMPONENT -->
    <x-sidebar />

    <!-- MAIN -->

    <div class="main" id="mainContent">

        <div class="header">

            <div class="menu-btn" onclick="openSidebar()">☰</div>

            <h1>Creating the Teams</h1>
            <button class="btn" onclick="openTeamModal()">
                Create Team
            </button>

        </div>

        <!-- ----------------------------------------teams table start - -->



@if(session('success'))
    <div style="
        background:#d1fae5;
        color:#065f46;
        padding:12px;
        border-radius:8px;
        margin-bottom:15px;
    ">
        {{ session('success') }}
    </div>
@endif
        <div class="table-container">

            <h2 style="margin-bottom:15px;">Teams</h2>

            <div class="table-wrapper" style="min-width:400px; overflow-x:auto;">

<table border="1" cellpadding="10" cellspacing="0" style="min-width:1600px;width:100%;">
<thead>
<tr>
    <th>ID</th>
    <th>Team Name</th>
    <th>Team Lead</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
</thead>

  <tbody>

@forelse($teams as $team)

<tr>

    <td>{{ $team->id }}</td>
    <td>{{ $team->name }}</td>
    <td>{{ $team->team_lead }}</td>
    <td>{{ $team->email }}</td>
    <td>{{ $team->phone }}</td>

    <td>
        @if($team->status)
            <span style="background:#16a34a;color:white;padding:5px 12px;border-radius:20px;">
                Active
            </span>
        @else
            <span style="background:#dc2626;color:white;padding:5px 12px;border-radius:20px;">
                Inactive
            </span>
        @endif
    </td>

    <td>

        <div style="display:flex;gap:10px;">

            <button
                type="button"
                onclick="openEditModal({{ $team->id }})"
                style="padding:6px 12px;background:#2563eb;color:white;border:none;border-radius:20px;cursor:pointer;">

                Edit

            </button>

            <form
                action="{{ route('teams.destroy',$team->id) }}"
                method="POST"
                onsubmit="return confirm('Delete Team?')">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    style="padding:6px 12px;background:#dc2626;color:white;border:none;border-radius:20px;cursor:pointer;">

                    Delete

                </button>

            </form>

        </div>

    </td>

</tr>

{{-- EDIT MODAL --}}
<div id="editTeamModal{{ $team->id }}" class="team-modal">

    <div class="team-modal-content">

        <div class="modal-header">

            <h2>Edit Team</h2>

            <span
                class="close-modal"
                onclick="closeEditModal({{ $team->id }})">

                &times;

            </span>

        </div>

        <form
            action="{{ route('teams.update',$team->id) }}"
            method="POST">

            @csrf
            @method('PUT')

            <div class="modal-body">

                <div class="form-group">
                    <label>Team Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ $team->name }}"
                        required>
                </div>

                <div class="form-group">
                    <label>Team Lead</label>
                    <input
                        type="text"
                        name="team_lead"
                        value="{{ $team->team_lead }}">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ $team->email }}">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input
                        type="text"
                        name="phone"
                        value="{{ $team->phone }}">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="1" {{ $team->status ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="0" {{ !$team->status ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Leave blank to keep current password">
                </div>

            </div>

            <div class="modal-footer">
                <button
                    type="submit"
                    class="save-team-btn">
                    Update Team
                </button>
            </div>

        </form>

    </div>

</div>

@empty

<tr>
    <td colspan="7" style="text-align:center;">
        No Teams Found
    </td>
</tr>

@endforelse

</tbody>

</table>
                

            </div>
            <div style="margin-top:20px; display:flex; justify-content:end;color:white !important;">
    

        </div>


                <!-- ----------------------------------------teams table end - -->






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

    <!-- ------------------------------------CREATING THE model code---------- -->
<!-- TEAM MODAL -->

<div id="teamModal" class="team-modal">

    <div class="team-modal-content">

        <div class="modal-header">
            <h2>Create Team</h2>

            <span class="close-modal" onclick="closeTeamModal()">
                &times;
            </span>
        </div>

        <form action="{{ route('teams.store') }}" method="POST">

            @csrf

            <div class="modal-body">

                <div class="form-group">
                    <label>Team Name *</label>
                    <input type="text"
                           name="name"
                           required>
                </div>

                <div class="form-group">
                    <label>Team Lead</label>
                    <input type="text"
                           name="team_lead">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email"
                           name="email">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text"
                           name="phone">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password"
                           name="password"
                           required>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="save-team-btn">
                    Save Team
                </button>
            </div>

        </form>

    </div>

</div>

<script>

function openTeamModal()
{
    document
        .getElementById('teamModal')
        .classList
        .add('active');
}

function closeTeamModal()
{
    document
        .getElementById('teamModal')
        .classList
        .remove('active');
}

window.onclick = function(event)
{
    let modal = document.getElementById('teamModal');

    if(event.target == modal)
    {
        modal.classList.remove('active');
    }
}

</script>

<script>

function openEditModal(id)
{
    document
        .getElementById('editTeamModal'+id)
        .classList
        .add('active');
}

function closeEditModal(id)
{
    document
        .getElementById('editTeamModal'+id)
        .classList
        .remove('active');
}

</script>
</x-layout>