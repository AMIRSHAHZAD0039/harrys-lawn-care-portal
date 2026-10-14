<x-layout>

    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">

    <style>

        /* BACKGROUND */


        /* FILTER */
        .filter-container{
            background: rgba(27,58,42,0.85);
            backdrop-filter: blur(10px);
            padding:20px;
            border-radius:12px;
            margin-bottom:25px;
            border:1px solid rgba(255,255,255,0.1);
        }

        /* CARD (PREMIUM GLASS) */
        .card-hello{
            background: rgba(27,58,42,0.85);
            backdrop-filter: blur(14px);
            border-radius: 20px !important;
            border: 1px solid rgba(255,255,255,0.1);
            padding:2%;
            overflow: hidden;
            animation: fadeUp 0.6s ease;
        }

        /* HEADER */
        .card-header{

            letter-spacing: 1px;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        /* INPUT */
        .form-control,
        .form-select{
            background: rgba(0,0,0,0.6);
            border: 1px solid rgba(255,255,255,0.15);
            color: white;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .form-control::placeholder{
            color: rgba(255,255,255,0.6);
        }

        /* FOCUS EFFECT */
        .form-control:focus,
        .form-select:focus{
            border-color: #00ffae;
            box-shadow: 0 0 12px rgba(0,255,174,0.5);
            background: rgba(0,0,0,0.8);
            color :white !important;
        }

        /* LABEL */
        .form-label{
            font-size: 13px;
            letter-spacing: 0.5px;
            color: #cfcfcf;
        }

        /* BUTTON */
        .button2{
            background: linear-gradient(135deg,#00ffae,#00cfff);
            color: black;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0,255,174,0.3);
        }

        .button2:hover{
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 40px rgba(0,255,174,0.5);
            color:white;
        }

        /* ANIMATION */
        @keyframes fadeUp{
            from{
                opacity:0;
                transform: translateY(30px);
            }
            to{
                opacity:1;
                transform: translateY(0);
            }
        }

        /* MOBILE */
        @media (max-width:768px){

            .card{
                padding:10px;
            }

            .card-header{
                font-size:18px !important;
            }

        }

    </style>

    <!-- SIDEBAR -->
    <x-sidebar/>

    <!-- MAIN -->
    <div class="main" id="mainContent">

        <div class="header">
            <div class="menu-btn" onclick="openSidebar()">☰</div>
        </div>

        <!-- FORM -->
        <div class="container my-5">
            <div class="card-hello border-0 rounded-4">

                <div class="card-header text-center text-white py-4">
                    Add New Lead
                </div>

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger animate__animated animate__shakeX">
                            {{ session('error') }}
                        </div>
                    @endif

                        <form action="{{ route('leads.update', $lead->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">

                                <!-- First Name -->
                                <div class="col-md-6">
                                    <label class="form-label">First Name *</label>
                                    <input type="text" name="first_name" value="{{ $lead->first_name }}" class="form-control form-control-lg" required>
                                </div>

                                <!-- Last Name -->
                                <div class="col-md-6">
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" name="last_name" value="{{ $lead->last_name }}" class="form-control form-control-lg" required>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" value="{{ $lead->email }}" class="form-control form-control-lg" required>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <label class="form-label">Phone *</label>
                                    <input type="text" name="phone" value="{{ $lead->phone }}" class="form-control form-control-lg" required>
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <label class="form-label">Address *</label>
                                    <textarea name="address" class="form-control form-control-lg" required>{{ $lead->address }}</textarea>
                                </div>

                                <!-- Date -->
                                <div class="col-md-6">
                                    <label class="form-label">Date of Lead *</label>
                                    <input type="date" name="date_of_lead" value="{{ $lead->date_of_lead }}" class="form-control form-control-lg" required>
                                </div>

                                <!-- Source -->
                                <div class="col-md-6">
                                    <label class="form-label">Source</label>
                                    <select name="source" class="form-select form-select-lg">
                                        <option value="">Select</option>
                                        @foreach(['Call','Chatway','PPC','Email','SEO','Social Media'] as $s)
                                            <option value="{{ $s }}" {{ $lead->source == $s ? 'selected' : '' }}>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Property -->
                                <div class="col-md-6">
                                    <label class="form-label">Property Type</label>
                                    <select name="property" class="form-select form-select-lg">
                                        <option value="">Select</option>
                                        <option value="Residential" {{ $lead->property_type=='Residential'?'selected':'' }}>Residential</option>
                                        <option value="Commercial" {{ $lead->property_type=='Commercial'?'selected':'' }}>Commercial</option>
                                    </select>
                                </div>

                                <!-- Message -->
                                <div class="col-md-6">
                                    <label class="form-label">Message</label>
                                    <textarea name="message" class="form-control form-control-lg">{{ $lead->message }}</textarea>
                                </div>

                                <!-- Comments -->
                                <div class="col-md-6">
                                    <label class="form-label">Comments</label>
                                    <textarea name="comments" class="form-control form-control-lg">{{ $lead->comments }}</textarea>
                                </div>

                                <!-- Commercial Size -->
                                <div class="col-md-6">
                                    <label class="form-label">Commercial Property Size</label>
                                    <input type="text" name="commercial_property_size" value="{{ $lead->commercial_property_size }}" class="form-control form-control-lg">
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select form-select-lg">
                                        <option value="">Select</option>
                                        @foreach(['New','Contacted','Closed','Void'] as $s)
                                            <option value="{{ $s }}" {{ $lead->status==$s?'selected':'' }}>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Frequency -->
                                <div class="col-md-6">
                                    <label class="form-label">Frequency Selected</label>
                                    <select name="frequency_selected" class="form-select form-select-lg">
                                        <option value="">Select</option>
                                        @foreach(['Weekly','Bi Weekly','Monthly','1 Time'] as $f)
                                            <option value="{{ $f }}" {{ $lead->frequency_selected==$f?'selected':'' }}>{{ $f }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Package -->
                                <div class="col-md-6">
                                    <label class="form-label">Package Selected</label>
                                    <select name="package_selected" class="form-select form-select-lg">
                                        <option value="">Select</option>
                                        @foreach(['Core Maintenance','Enhanced Maintenance','Premium Maintenance'] as $p)
                                            <option value="{{ $p }}" {{ $lead->package_selected==$p?'selected':'' }}>{{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Charges -->
                                <div class="col-md-6">
                                    <label class="form-label">Per Visit Charges</label>
                                    <input type="text" name="per_visit_charges" value="{{ $lead->per_visit_charges }}" class="form-control form-control-lg">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Total Charges</label>
                                    <input type="text" name="total_charges" value="{{ $lead->total_charges }}" class="form-control form-control-lg">
                                </div>

                                <!-- Visit Number -->
                                <div class="col-md-6">
                                    <label class="form-label">Visit Number</label>
                                    <input type="text" name="visit_number" value="{{ $lead->visit_number }}" class="form-control form-control-lg">
                                </div>

                                <!-- Visit Date -->
                                <div class="col-md-6">
                                    <label class="form-label">Visit Date</label>
                                    <input type="date" name="visit_date" value="{{ $lead->visit_date }}" class="form-control form-control-lg">
                                </div>

                                <!-- Visit Time -->
                                <div class="col-md-6">
                                    <label class="form-label">Visit Time</label>
                                    <input type="time" name="visit_time" value="{{ $lead->visit_time }}" class="form-control form-control-lg">
                                </div>

                                <!-- Visit Status -->
                                <div class="col-md-6">
                                    <label class="form-label">Visit Status</label>
                                    <select name="visit_status" class="form-select form-select-lg">
                                        <option value="">Select</option>
                                        <option value="To be Visited" {{ $lead->visit_status=='To be Visited'?'selected':'' }}>To be Visited</option>
                                        <option value="Visit Done" {{ $lead->visit_status=='Visit Done'?'selected':'' }}>Visit Done</option>
                                    </select>
                                </div>

                                <!-- Payment -->
                                <div class="col-md-6">
                                    <label class="form-label">Payment Status</label>
                                    <select name="payment_status" class="form-select form-select-lg">
                                        <option value="">Select</option>
                                        <option value="Paid" {{ $lead->payment_status=='Paid'?'selected':'' }}>Paid</option>
                                        <option value="Unpaid" {{ $lead->payment_status=='Unpaid'?'selected':'' }}>Unpaid</option>
                                    </select>
                                </div>

                                <!-- Client Status -->
                                <div class="col-md-6">
                                    <label class="form-label">Client Status</label>
                                    <select name="client_status" class="form-select form-select-lg">
                                        <option value="">Select</option>
                                        <option value="Open" {{ $lead->client_status=='Open'?'selected':'' }}>Open</option>
                                        <option value="Closed" {{ $lead->client_status=='Closed'?'selected':'' }}>Closed</option>
                                    </select>
                                </div>

                            </div>

                            <!-- Submit -->
                            <div class="text-center mt-4">
                                <button class=" button2 btn btn-success px-5 py-2">
                                    Update Lead
                                </button>
                            </div>
                        </form>
                </div>
            </div>
        </div>

    </div>

    <!-- SCRIPT -->
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
