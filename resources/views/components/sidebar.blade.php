<style>
    /* ===== SIDEBAR SCROLL FIX (scoped to #sidebar to win specificity) =====
       This inline block does not define .sidebar/.logo/.nav containers —
       those live in dashboard.css. These #sidebar-scoped rules override
       them so the fix applies regardless of the external file. */

    #sidebar{
        height:100vh;            /* explicit bound for the flex column */
        overflow:hidden;         /* keeps the ::before glow clipped */
    }

    /* Desktop: pin the sidebar so the main content scrolls past it.
       Wrapped in a min-width query so your mobile off-canvas behaviour
       (close-btn / closeSidebar) in dashboard.css stays untouched.
       Change 992px to match your actual desktop breakpoint. */
    @media (min-width:992px){
        #sidebar{
            position:sticky;     /* pins the column while page scrolls */
            top:0;               /* stick to viewport top */
            align-self:flex-start; /* don't stretch to full parent height */
        }
    }

    #sidebar .logo{
        flex:0 0 auto;           /* logo pinned at top, never scrolls */
        margin-bottom:24px;      /* tightened from 40px to reclaim space */
    }

    #sidebar .nav{
        flex:1 1 auto;           /* nav consumes remaining height */
        min-height:0;            /* CRITICAL: enables scroll (Flexbox §4.5) */
        overflow-y:auto;         /* overflowing items scroll instead of clip */
        overflow-x:hidden;
        gap:6px;                 /* tightened from 10px */
        padding-right:4px;       /* room for scrollbar */
    }

    /* thin dark scrollbar */
    #sidebar .nav::-webkit-scrollbar{ width:6px; }
    #sidebar .nav::-webkit-scrollbar-thumb{ background:rgba(255,255,255,0.25); border-radius:10px; }
    #sidebar .nav::-webkit-scrollbar-track{ background:transparent; }

    /* Sidebar Nav links — tightened padding to fit more items */
    .nav a {
        text-decoration:none;
        color:white;
        padding:9px 14px;        /* tightened from 12px 15px */
        border-radius:8px;
        transition:.3s;
        position:relative;
        overflow:hidden;
        flex:0 0 auto;           /* each link keeps natural height in scroll area */
        font-size:14px;
    }

    /* Hover + Active */
    .nav a:hover,
    .nav a.active {
        background:black;
        transform:translateX(5px);
    }

    .nav a:before {
        content:"";
        position:absolute;
        width:5px;
        height:100%;
        left:0;
        top:0;
        background:white;
        transform:scaleY(0);
        transition:.3s;
    }

    .nav a:hover:before,
    .nav a.active:before {
        transform:scaleY(1);
    }

    /* Sidebar Logout Button — padding matched to nav links */
    .logout-link{
        width:100%;
        text-align:left;
        background:none;
        border:none;
        color:white;
        padding:9px 14px;        /* matched to .nav a */
        border-radius:8px;
        cursor:pointer;
        font-size:14px;
        transition:.3s;
        flex:0 0 auto;
    }

    .logout-link:hover{
        background:black;        /* matched to .nav a:hover for consistency */
        transform:translateX(5px);
    }

    /* ===== COLLAPSIBLE NAV GROUP (Job Operations) ===== */
    .nav-group{ flex:0 0 auto; display:flex; flex-direction:column; }

    /* parent toggle row — styled like a nav link but it's a button */
    .nav-group-toggle{
        display:flex; align-items:center; gap:0;
        width:100%; text-align:left; background:none; border:none; color:white;
        padding:9px 14px; border-radius:8px; cursor:pointer; font-size:14px;
        transition:.3s; position:relative; overflow:hidden; font-family:inherit;
    }
    .nav-group-toggle:hover{ background:black; transform:translateX(5px); }
    .nav-group-toggle .ng-label{ display:flex; align-items:center; gap:10px; flex:1 1 auto; }
    .nav-group-toggle .ng-caret{ transition:transform .3s; font-size:12px; opacity:.85; }
    .nav-group.open .nav-group-toggle .ng-caret{ transform:rotate(180deg); }

    /* children container — animated open/close via max-height */
    .nav-group-items{
        display:flex; flex-direction:column; gap:6px;
        max-height:0; overflow:hidden;
        transition:max-height .3s ease, margin .3s ease;
        margin-top:0;
        padding-left:12px;          /* indent to show nesting */
        border-left:2px solid rgba(255,255,255,0.12);
        margin-left:14px;
    }
    .nav-group.open .nav-group-items{
        max-height:400px;           /* enough for the 3 children */
        margin-top:6px;
    }
    /* children slightly smaller to read as sub-items */
    .nav-group-items a{ font-size:13.5px; padding:8px 12px; }
</style>

<div class="sidebar" id="sidebar">

    <div class="close-btn" onclick="closeSidebar()">×</div>

    <div class="logo">
        <img src="{{asset('/images/harry_lawns-logo.png')}}" alt="" style="width:150px;">
    </div>

  <div class="nav">

    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-gauge-high"></i> Dashboard
    </a>

    <a href="/quote-create" target="_blank" class="{{ request()->is('quote-create') ? 'active' : '' }}">
        <i class="fa-solid fa-file-circle-plus"></i> Create Quote
    </a>

    <a href="{{ route('quotes.all') }}" class="{{ request()->routeIs('quotes.all') ? 'active' : '' }}">
        <i class="fa-solid fa-file-lines"></i> All Quotes
    </a>

    <a href="{{ route('customers.all') }}" class="{{ request()->routeIs('customers.all') ? 'active' : '' }}">
        <i class="fa-solid fa-users"></i> All Customers
    </a>

    <a href="/all-leads" class="{{ request()->is('all-leads') ? 'active' : '' }}">
        <i class="fa-solid fa-user-plus"></i> All Leads
    </a>

    {{-- ===== JOB OPERATIONS GROUP (Assigned Clients + Weekly Stops + Job History) ===== --}}
    @php
        // Auto-open the group if the current page is one of its children.
        $jobOpsActive = request()->is('assigned-clients')
                     || request()->is('weekly-routes')
                     || request()->is('job-history');
    @endphp
    <div class="nav-group {{ $jobOpsActive ? 'open' : '' }}" id="jobOpsGroup">
        <button type="button" class="nav-group-toggle" onclick="toggleNavGroup('jobOpsGroup')">
            <span class="ng-label"><i class="fa-solid fa-briefcase"></i> Job Operations</span>
            <i class="fa-solid fa-chevron-down ng-caret"></i>
        </button>
        <div class="nav-group-items">
            <a href="/assigned-clients" class="{{ request()->is('assigned-clients') ? 'active' : '' }}">
                <i class="fa-solid fa-user-check"></i> All Asssigned Clients
            </a>
            <a href="/weekly-routes" class="{{ request()->is('weekly-routes') ? 'active' : '' }}">
                <i class="fa-solid fa-route"></i> current week Stops/visits
            </a>
            <a href="/job-history" class="{{ request()->is('job-history') ? 'active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i> Job history
            </a>
        </div>
    </div>

    <a href="/quotes/create-teams" class="{{ request()->is('quotes/create-teams') ? 'active' : '' }}">
        <i class="fa-solid fa-people-group"></i> Create Team
    </a>

    <a href="/create-group" class="{{ request()->is('create-group') ? 'active' : '' }}">
        <i class="fa-solid fa-layer-group"></i> Create Groups
    </a>

    <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
        <i class="fa-solid fa-gear"></i> Settings
    </a>

    <!-- Logout -->
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="logout-link">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </button>
    </form>

</div>

</div>

<script>
    // Scoped, dependency-free dropdown toggle for sidebar nav groups.
    function toggleNavGroup(id){
        var g = document.getElementById(id);
        if(g){ g.classList.toggle('open'); }
    }
</script>