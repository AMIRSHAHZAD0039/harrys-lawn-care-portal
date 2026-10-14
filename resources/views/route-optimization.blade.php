<x-layout>

<style>
.page {
    padding:20px;
    color:white;
    background:#0b1220;
    min-height:100vh;
}

.header {
    margin-bottom:20px;
}

.flex {
    display:flex;
    gap:20px;
    flex-wrap:wrap;
}

/* LEFT BIG PANEL (STOPS) */
.main-panel {
    flex:3;
    min-width:350px;
}

/* RIGHT SIDE */
.side-panel {
    flex:1;
    min-width:300px;
}

/* CARD */
.card {
    background:#0f172a;
    border:1px solid rgba(255,255,255,0.08);
    border-radius:14px;
    padding:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.25);
}

/* MAP SMALL */
.map-box {
    height:250px;
    border-radius:12px;
    overflow:hidden;
}

/* FORM */
label {
    font-size:13px;
    opacity:0.8;
}

input, select {
    width:100%;
    padding:10px;
    border-radius:8px;
    margin-top:6px;
    margin-bottom:12px;
    border:none;
    outline:none;
}

/* BUTTON */
button {
    width:100%;
    padding:12px;
    background:#16a34a;
    border:none;
    color:white;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
}

button:hover {
    background:#0ea44a;
}

/* STOP ITEMS BIG */
.stop-item {
    padding:12px;
    margin-bottom:10px;
    border-radius:10px;
    background:#111c33;
    border:1px solid rgba(255,255,255,0.06);
    cursor:grab;
    font-size:14px;
}

/* JOB LIST SMALL */
.job-card {
    padding:10px;
    margin-bottom:8px;
    border-radius:10px;
    background:#111c33;
    border:1px solid rgba(255,255,255,0.06);
}

.small {
    font-size:12px;
    opacity:0.7;
}

.stop-number{
    display:inline-flex;
    width:28px;
    height:28px;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    background:#2563eb;
    color:#fff;
    margin-right:8px;
    font-weight:bold;
}
</style>

<div class="page">

    <div class="header">
        <h2>Route Optimization Dashboard</h2>
        <p class="small">Drag stops → Optimize route → Assign team</p>
    </div>

    <div class="flex">

        <!-- 🔥 MAIN BIG PANEL (DRAG & DROP STOPS) -->
        <div class="card main-panel" style="color:white;">

            <h3>📍 Client Stops (Drag to Reorder)</h3>
            <div id="routeSummary"
     style="margin-bottom:15px;
            padding:12px;
            background:#0b2447;
            border-radius:10px;
            color:white;
            display:none;">
</div>
            <div id="stopList"></div>

            <hr style="margin:15px 0; border-color:#334155;">

            <h3>📋 Selected Jobs</h3>

            @foreach($quotes as $quote)
                <div class="job-card">
                    <b>{{ $quote->client_name }}</b><br>
                    <span class="small">{{ $quote->client_address }}</span>
                </div>
            @endforeach

        </div>

        <!-- 🔥 SIDE PANEL -->
        <div class="side-panel">

            <!-- FORM -->
            <div class="card">

                <form method="POST" action="{{ route('routes.generate') }}">
                    @csrf

                    <input type="hidden" name="quote_ids" value="{{ implode(',', $quoteIds) }}">

                    <label style="color:white;">👷 Select Team</label>
                    <select name="team_id" required>
                        @foreach(\App\Models\Team::where('status', 1)->get() as $team)
                            <option value="{{ $team->id }}">
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>

                    <label style="color:white;">📍Start Location</label>
                    <input type="text"
                           id="teamAddress"
                           name="team_address"
                           placeholder="Enter start location">
                           
                           <input
    type="hidden"
    id="optimizedStops"
    name="optimized_stops">

                    <label style="color:white;">📅 Service Date</label>
                    <input type="date" name="service_date" required>

                   <button type="button" id="optimizeBtn" style="margin-bottom:10px;background:#2563eb;">
    Optimize Route
</button>

<button type="submit">
    Assign Route
</button>
                </form>

            </div>

            <!-- MAP -->
            <div class="card" style="margin-top:15px;">
                <div id="map" class="map-box"></div>
            </div>

        </div>

    </div>
</div>

<!-- SORTABLE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>

document.querySelector('form').addEventListener('submit', function() {

    let currentStops = getStops();

    document.getElementById('optimizedStops').value =
        JSON.stringify(currentStops);

});

</script>
<script>
let addresses = @json($quotes->pluck('client_address'));

let map;
let directionsService;
let directionsRenderer;

/* =========================
   MAP INIT
========================= */
function initMap() {

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: { lat: 31.5204, lng: 74.3587 }
    });

    directionsService = new google.maps.DirectionsService();

    directionsRenderer = new google.maps.DirectionsRenderer({
        suppressMarkers: false
    });

    directionsRenderer.setMap(map);

    renderStops(addresses);

    document
        .getElementById("optimizeBtn")
        .addEventListener("click", buildRoute);
}


/* =========================
   RENDER STOPS
========================= */
function renderStops(list, distances = []) {

    let container = document.getElementById("stopList");

    container.innerHTML = "";

    list.forEach((addr, index) => {

        let div = document.createElement("div");

        div.className = "stop-item";

        div.setAttribute("data-address", addr);

        div.innerHTML = `
            <div>
                <strong class="stop-number">
                    ${index + 1}
                </strong>

                📍 ${addr}

                ${
                    distances[index]
                        ? `
                            <div style="
                                margin-top:5px;
                                font-size:12px;
                                color:#94a3b8;
                            ">
                                🚗 ${distances[index]}
                            </div>
                          `
                        : ""
                }
            </div>
        `;

        container.appendChild(div);
    });

    new Sortable(container, {
        animation: 150,

        onEnd: function () {
            updateNumbers();
        }
    });
}


/* =========================
   UPDATE NUMBERS
========================= */
function updateNumbers() {

    document
        .querySelectorAll(".stop-item")
        .forEach((item, index) => {

            let num = item.querySelector(".stop-number");

            if (num) {
                num.innerText = index + 1;
            }
        });
}


/* =========================
   GET CURRENT ORDER
========================= */
function getStops() {

    let stops = [];

    document
        .querySelectorAll(".stop-item")
        .forEach(el => {

            stops.push(
                el.getAttribute("data-address")
            );
        });

    return stops;
}


/* =========================
   DISTANCE MATRIX
========================= */
function calculateDistanceMatrix(start, stops, callback) {

    let service = new google.maps.DistanceMatrixService();

    service.getDistanceMatrix({
        origins: [start],
        destinations: stops,
        travelMode: google.maps.TravelMode.DRIVING
    }, function(response, status) {

        if (status !== "OK") {

            alert("Distance Matrix failed");

            return;
        }

        let results = response.rows[0].elements;

        let enrichedStops = stops.map((stop, index) => {

            return {
                address: stop,
                distanceValue:
                    results[index].distance.value,
                distanceText:
                    results[index].distance.text
            };
        });

        callback(enrichedStops);
    });
}


/* =========================
   BUILD ROUTE
========================= */
/* =========================
   BUILD ROUTE
========================= */
function buildRoute() {

    let start = document
        .getElementById("teamAddress")
        .value
        .trim();

    if (!start) {

        alert("Please enter team start location.");

        return;
    }

    let stops = getStops();

    if (!stops.length) {

        alert("No stops found");

        return;
    }

    calculateDistanceMatrix(
        start,
        stops,
        function(enrichedStops) {

            // Sort nearest → farthest
            enrichedStops.sort(
                (a, b) =>
                    a.distanceValue -
                    b.distanceValue
            );

            let sortedStops =
                enrichedStops.map(
                    stop => stop.address
                );

            let distances =
                enrichedStops.map(
                    stop => stop.distanceText
                );

            directionsService.route({

                origin: start,

                destination: start,

                waypoints:
                    sortedStops.map(
                        stop => ({
                            location: stop,
                            stopover: true
                        })
                    ),

                // KEEP ORDER SAME
                optimizeWaypoints: false,

                travelMode:
                    google.maps.TravelMode.DRIVING

            }, function(result, status) {

                if (status !== "OK") {

                    alert("Unable to build route.");

                    console.log(status);

                    return;
                }

                directionsRenderer.setDirections(
                    result
                );

                let route =
                    result.routes[0];

                let totalDistance = 0;
                let totalDuration = 0;

                route.legs.forEach(leg => {

                    totalDistance +=
                        leg.distance.value;

                    totalDuration +=
                        leg.duration.value;
                });

                document
                    .getElementById(
                        "routeSummary"
                    )
                    .style.display =
                    "block";

                document
                    .getElementById(
                        "routeSummary"
                    )
                    .innerHTML = `
                        <strong>
                            🚚 Optimized Route
                        </strong>
                        <br>
                        📏 ${(totalDistance / 1000).toFixed(1)} km
                        <br>
                        ⏱ ${Math.round(totalDuration / 60)} mins
                    `;

                // Nearest → Farthest order
                addresses = sortedStops;

                renderStops(
                    sortedStops,
                    distances
                );

                let hidden =
                    document.getElementById(
                        "optimizedStops"
                    );

                if (hidden) {

                    hidden.value =
                        JSON.stringify(
                            sortedStops
                        );
                }
            });
        }
    );
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9EmH-Ur21wYUdJmKJ_oiV5UPru4RuoM0&callback=initMap" async defer></script>

</x-layout>