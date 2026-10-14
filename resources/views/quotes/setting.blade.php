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

    </style>
    <!-- SIDEBAR COMPONENT -->
    <x-sidebar />

    <!-- MAIN -->

    <div class="main" id="mainContent">

        <div class="header">

            <div class="menu-btn" onclick="openSidebar()">☰</div>

            <h1>Settings</h1>



        </div>
{{--        -------------- settings------}}


        @if(session('success'))
            <div class="success-msg">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.updateProfile') }}" class="settings-form">
            @csrf

            <div class="form-row">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ $admin->name }}" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $admin->email }}" required>
                </div>

            </div>
            <div class="form-row">



                <div class="form-group">
                    <label>Quote Emails(separated by comma)</label>
                    <input type="text" name="quote_emails" value="{{ $admin->quote_emails }}" required>
                </div>

            </div>


            <div class="form-row">

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password" placeholder="Leave blank if unchanged">
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation">
                </div>

            </div>

            <button class="update-btn">
                Update Profile
            </button>

        </form>


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
</x-layout>
