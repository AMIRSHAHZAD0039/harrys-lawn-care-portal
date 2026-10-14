<x-layout>

    <link rel="stylesheet" href="{{asset('css/quote-create.css')}}">
<style>
    /* jab sirf 1 box ho */
    .svc-row.single{
        display:block;
    }

    .svc-row.single .svc-box{
        width:100%;
    }
    .agreement-box{
        margin: 8px 0 12px;
    }

    .custom-check{
        display:flex;
        align-items:center;
        cursor:pointer;
        font-size:13px;
        color:#000;
    }

    .custom-check input{
        display:none;
    }

    .custom-check .checkmark{
        width:16px;
        height:16px;
        border:1.5px solid #000;
        margin-right:8px;
        position:relative;
    }

    /* X mark */
    .custom-check input:checked + .checkmark::after{
        content: "X";
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%, -55%);
        font-size:12px;
        font-weight:bold;
    }

    /* ===== SEASONAL / ONE-TIME SECTION HEADERS inside pricing table ===== */
    .grp-row td{
        background:#1b3a2a;
        color:#fff;
        font-weight:700;
        font-size:13px;
        letter-spacing:.3px;
        padding:8px 10px !important;
    }
    .grp-row td .grp-badge{
        display:inline-flex;
        align-items:center;
        gap:7px;
    }
    .grp-row td .grp-freq{
        font-weight:500;
        font-size:11.5px;
        opacity:.85;
        margin-left:8px;
    }

    .grp-sub-row td{
        background:#eef4f0;
        font-weight:700;
        font-size:12.5px;
    }
</style>   <div class="page" style=";margin:0 auto;">

        <!-- HEADER -->
        <div class="hdr">
            <div class="logo">
              
            <img src="{{asset('images/harrys_logo_2.png')}}">
                               
            </div>

            <div class="hdr-right">
                <h1>Service Quotation</h1>
                <div class="co">Harry's Lawncare Ltd.</div>
                <div class="ins">Fully Insured — $2,000,000 Commercial Liability</div>
            </div>
        </div>

        <div class="top-rule"></div>
  <div class="body">

            <!-- QUOTE DETAILS + CLIENT INFO -->
            <div class="two-top">

                <div>
                    <div class="stitle">Quote Details</div>
                    <div class="qd-grid">
                        <span class="flabel">Quote #:</span>
                        <input type="text" value="{{$quote->id}}" readonly style="width:100%">
                        <span class="flabel">Date:</span>
                        <input type="date" value="{{$quote->date}}" readonly style="width:100%">
                        <span class="flabel">Valid Until:</span>
                        <input type="date" value="{{$quote->valid_until}}" readonly style="width:100%">
                        <span class="flabel">Prepared By:</span>
                        <input type="text" value="{{$quote->prepared_by}}" readonly style="width:100%">
                    </div>
                </div>
  <div>
                    <div class="stitle">Client Information</div>
                    <div class="ci-grid">
                        <span class="flabel">Name:</span>
                        <input type="text" value="{{$quote->client_name}}" readonly style="width:100%">
                        <span class="flabel">Address:</span>
                        <input type="text" value="{{$quote->client_address}}" readonly style="width:100%">
                    </div>

                    <div class="ci-phone-row" style="margin-top:5px">
                        <span class="flabel">Phone:</span>
                        <input type="tel" value="{{$quote->client_phone}}" readonly style="width:100%">
                        <span class="flabel">Email:</span>
                        <input type="email" value="{{$quote->client_email}}" readonly style="width:100%">
                    </div>
                </div>

            </div>
   <!-- PROPERTY DETAILS -->
            <div class="stitle">Property Details</div>
            <table class="prop-tbl">
                <thead>
                <tr>
                    <th>Lawn Size</th>
                    <th>Service Area</th>
                    <th>Terrain</th>
                    <th>Access</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="text" value="{{$quote->lawn_size}}" readonly></td>
                    <td><input type="text" value="{{$quote->service_area}}" readonly></td>
                    <td><input type="text" value="{{$quote->terrain}}" readonly></td>
                    <td><input type="text" value="{{$quote->access}}" readonly></td>
                </tr>
                </tbody>
            </table>  <div class="cond-row" style="margin-bottom:16px">
                <span class="flabel">Condition:</span>
                <input type="text" value="{{$quote->condition}}" readonly style="width:100%">
                <span class="flabel">Notes/Hazards:</span>
                <input type="text" value="{{$quote->hazards}}" readonly style="width:100%">
            </div>

            {{--
                ============================================================
                GROUP LINE ITEMS BY TYPE (seasonal vs onetime)
                - normalize $item->type defensively: lowercase, strip spaces/-/_
                  so 'One-Time' / 'one_time' / 'ONETIME' all route to 'onetime'
                - per-section subtotal = sum of $item->amount in that group
                - quote-level subtotal/discount/gst/total are PRESERVED as-is
                  (authoritative totals not recomputed here)
                ============================================================
            --}}
            @php
                $seasonalItems = collect();
                $onetimeItems  = collect();
                $otherItems    = collect();

                foreach ($quote->items as $qi) {
                    $t = strtolower(trim((string) $qi->type));
                    $t = str_replace([' ', '-', '_'], '', $t); // seasonal | onetime

                    if ($t === 'seasonal') {
                        $seasonalItems->push($qi);
                    } elseif ($t === 'onetime') {
                        $onetimeItems->push($qi);
                    } else {
                        $otherItems->push($qi);
                    }
                }

                // per-section subtotals (numeric-safe cast)
                $seasonalSub = $seasonalItems->sum(fn($i) => (float) $i->amount);
                $onetimeSub  = $onetimeItems->sum(fn($i) => (float) $i->amount);
                $otherSub    = $otherItems->sum(fn($i) => (float) $i->amount);

                // grab a representative frequency label for the seasonal header
                // (uses the first seasonal item's frequency if present)
                $seasonalFreq = optional($seasonalItems->first())->frequency;
            @endphp

            <!-- SERVICE TYPE -->
            <div class="stitle">Service Type</div>

            <div class="svc-row single">

                @if(strtoupper(trim($quote->service_type)) === 'SEASONAL PROGRAM')

                    <div class="svc-box on">
                        <div class="svc-top"><span class="svc-ck"></span></div>
                        <div class="svc-title">Seasonal Program</div>
                        <div class="svc-sub">
                           Weekly, Bi-weekly,monthly
                        </div>
                    </div> @elseif(strtoupper(trim($quote->service_type)) === 'ONE-TIME SERVICE')

                    <div class="svc-box on">
                        <div class="svc-top"><span class="svc-ck"></span></div>
                        <div class="svc-title">One-Time Service</div>
                        <div class="svc-sub">
                            Single Job • No Long-Term Commitment
                        </div>
                    </div>

                @endif

            </div>

            <!-- PRICING BREAKDOWN (grouped: Seasonal / One-Time) -->
            <div class="stitle">Pricing Breakdown</div>
            <table class="price-tbl">
                <thead>
                <tr>  <th style="width:60%">Service Description</th>
                    <th style="width:10%;text-align:right">Qty</th>
                    <th style="width:15%;text-align:right">Rate / Price</th>
                    <th style="width:15%;text-align:right">Amount</th>
                </tr>
                </thead>
                <tbody>

                {{-- ===== SEASONAL GROUP ===== --}}
                @if($seasonalItems->count())
                    <tr class="grp-row">
                        <td colspan="4">
                            <span class="grp-badge">
                                🌿 Seasonal Program
                                @if($seasonalFreq)
                                    <span class="grp-freq">{{ ucwords(str_replace(['-','_'],' ', $seasonalFreq)) }} · recurring</span>
                                @else
                                    <span class="grp-freq">recurring service</span>
                                @endif
                            </span>
                        </td>
                    </tr>

                    @foreach($seasonalItems as $item)
                        <tr>
                            <td><input type="text" value="{{$item->description}}" readonly></td>
                            <td><input type="text" value="{{$item->qty}}" readonly style="text-align:right"></td>
                            <td><input type="text" value="{{$item->rate}}" readonly style="text-align:right"></td>
                            <td><input type="text" value="{{$item->amount}}" readonly style="text-align:right"></td>
                        </tr>
                    @endforeach

                    <tr class="grp-sub-row">
                        <td colspan="3" style="text-align:right">Seasonal Subtotal</td>
                        <td style="text-align:right">{{ number_format($seasonalSub, 2) }}</td>
                    </tr>
                @endif

                {{-- ===== ONE-TIME GROUP ===== --}}
                @if($onetimeItems->count())
                    <tr class="grp-row" style="background-color:#1B3A2A">
                        <td colspan="4" style="background-color:#1B3A2A">
                            <span class="grp-badge" style="background-color:#1B3A2A">
                                🔧 One-Time Service
                                <span class="grp-freq">single job · no commitment</span>
                            </span>
                        </td>
                    </tr>

                    @foreach($onetimeItems as $item)
                        <tr>
                            <td><input type="text" value="{{$item->description}}" readonly></td>
                            <td><input type="text" value="{{$item->qty}}" readonly style="text-align:right"></td>
                            <td><input type="text" value="{{$item->rate}}" readonly style="text-align:right"></td>
                            <td><input type="text" value="{{$item->amount}}" readonly style="text-align:right"></td>
                        </tr>
                    @endforeach

                    <tr class="grp-sub-row">
                        <td colspan="3" style="text-align:right">One-Time Subtotal</td>
                        <td style="text-align:right">{{ number_format($onetimeSub, 2) }}</td>
                    </tr>
                @endif

                {{-- ===== OTHER / UNCLASSIFIED (only if any item type didn't match) ===== --}}
                @if($otherItems->count())
                    <tr class="grp-row">
                        <td colspan="4">
                            <span class="grp-badge">Additional Items</span>
                        </td>
                    </tr>

                    @foreach($otherItems as $item)
                        <tr>
                            <td><input type="text" value="{{$item->description}}" readonly></td>
                            <td><input type="text" value="{{$item->qty}}" readonly style="text-align:right"></td>
                            <td><input type="text" value="{{$item->rate}}" readonly style="text-align:right"></td>
                            <td><input type="text" value="{{$item->amount}}" readonly style="text-align:right"></td>
                        </tr>
                    @endforeach

                    <tr class="grp-sub-row">
                        <td colspan="3" style="text-align:right">Additional Subtotal</td>
                        <td style="text-align:right">{{ number_format($otherSub, 2) }}</td>
                    </tr>
                @endif

                {{-- ===== QUOTE-LEVEL TOTALS (authoritative — unchanged) ===== --}}
                <tr class="sum-row">
                    <td colspan="3" style="text-align:right;font-weight:700">Subtotal</td>
                    <td><input type="text" value="{{$quote->subtotal}}" readonly style="text-align:right"></td>
                </tr>
                <tr class="sum-row">
                    <td colspan="3" style="text-align:right;font-weight:700">Discount</td>
                    <td><input type="text" value="{{$quote->discount}}" readonly style="text-align:right"></td>
                </tr> <tr class="sum-row">
                    <td colspan="3" style="text-align:right;font-weight:700">GST (5%)</td>
                    <td><input type="text" value="{{$quote->gst}}" readonly style="text-align:right"></td>
                </tr>
                <tr class="total-row" >
                    <td colspan="3" style="text-align:right;background: #1a2e22;">TOTAL</td>
                    <td style="background: #1a2e22;"><input type="text" value="{{$quote->total}}" readonly style="text-align:right;background:transparent;border:none;font-weight:700;color:#fff;width:100%"></td>
                </tr>
                </tbody>
            </table>

            <!-- NOTES -->
            <div class="stitle" style="margin-top:16px">Notes</div>
            <div class="notes-box">
{{--                <textarea readonly>{{$quote->notes}}</textarea>--}}
                <div class="notes-text" style="background: #F2F7F4;">
                    {!! nl2br(e($quote->notes)) !!}
                </div>
            </div>

            <!-- SIGNATURE -->
            <div class="stitle" style="margin-top:14px">Client Signature</div>
            <div class="accept-text">
                By signing below, the Client accepts this quotation and agrees to the applicable Service Agreement:
            </div><form method="POST" action="{{ route('quote.submitSign') }}" id="signForm">
                @csrf

                @php
                    $type = strtoupper(trim($quote->service_type));
                @endphp

                <div class="agreement-box">

                    @if($type === 'SEASONAL PROGRAM')

                        <label class="custom-check">
                            <input type="checkbox" name="agreement" >
                            <span class="checkmark"></span>
                            <strong>Seasonal Service Agreement</strong>
                        </label>

                    @elseif($type === 'ONE-TIME SERVICE')

                        <label class="custom-check">
                            <input type="checkbox" name="agreement" >
                            <span class="checkmark"></span>
                            <strong>One-Time Service Agreement</strong>
                        </label>

                    @endif </div>

                <input type="hidden" name="token" value="{{$quote->token}}">
                <input type="hidden" name="signature" id="signature">

                <!-- Typed signature -->
                <div style="margin-bottom:15px;">
                    <div class="sig-label" > Type your name as signature OR draw below:</div>
                    <input type="text" name="typed_signature" id="typed_signature" placeholder="Your Name" style="width:100%;padding:8px;">
                </div>

                <!-- Canvas signature -->
                <div style="margin-bottom:15px;border:1px solid #ccc;padding:10px;width:100%;">
                    <canvas id="signature-pad" width="400" height="180"></canvas>
                    <div style="margin-top:8px;">
                        <button type="button" onclick="clearPad()">Clear Pad</button>
                    </div>
                </div>
{{--                -----------------------check box--}}

                <div style="margin-top:15px;">
                    <label style="display:flex; align-items:flex-start; gap:10px; cursor:pointer; font-size:14px; line-height:1.4;">

                        <input type="checkbox" id="termsCheck"
                               style="display:none;"
                               onchange="
                   if(this.checked){
                       this.nextElementSibling.style.background='#2e7d32';
                       this.nextElementSibling.style.borderColor='#2e7d32';
                       this.nextElementSibling.innerHTML='✓';
                       this.nextElementSibling.style.color='#fff';
                   } else {
                       this.nextElementSibling.style.background='#fff';
                       this.nextElementSibling.style.borderColor='#2e7d32';
                       this.nextElementSibling.innerHTML='';
                   }
               ">

                        <span id="checkUI" style="
            width:20px;
            height:20px;
            border:2px solid #2e7d32;
            border-radius:4px;
            background:#fff;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            font-size:14px;
            font-weight:bold;
            flex-shrink:0;
        "></span>               <span>
            By checking this box, I agree to the
            <a href="https://harryslawncare.ca/terms-and-conditions/" target="_blank" style="color:#2e7d32; text-decoration:underline;">
                Terms & Conditions
            </a>
            and confirm that I have read and understood them.
        </span>

                    </label>
                </div>

                <script>
                    window.onload = function() {
                        var check = document.getElementById('termsCheck');
                        var box = document.getElementById('checkUI');

                        if(check.checked){
                            box.style.background = '#2e7d32';
                            box.style.borderColor = '#2e7d32';
                            box.innerHTML = '✓';
                            box.style.color = '#fff';
                        }
                    }
                </script>     <!-- Submit -->

                <div style="margin-bottom:15px;margin-top:15px;">
    <label style="display:block;margin-bottom:5px;font-weight:bold;">
        Payment Method <span style="color:red;">*</span>
    </label>

    <select name="payment_method" id="payment_method" required style="width:100%;padding:8px;">
        <option value="" selected disabled>-- Select Payment Method --</option>
        <option value="Cash">Cash</option>
        <option value="Cheque">Cheque</option>
        <option value="E-Transfer">E-Transfer</option>
        <option value="Credit Card">Credit Card</option>
        <option value="PayPal">PayPal</option>
    </select>
</div>
                <div class="mt-3" style="display:flex; gap:10px;">

                    <!-- Accept -->
                    <button type="button"
                            onclick="handleSubmit('accept')"
                            style="background:#1b3a2a;color:#fff;padding:10px 30px;border:none">
                        Submit Signature
                    </button>

                    <!-- Decline -->
                    <button type="button"
                            onclick="handleSubmit('decline')"
                            style="background:#c62828;color:#fff;padding:10px 30px;border:none">
                        Decline Quote
                    </button>

                </div>

                <input type="hidden" name="action_type" id="action_type" value="accept">
            </form>

        </div>

        <div class="page-footer">
            Harry's Lawncare Ltd. &nbsp;|&nbsp; Serving the Lower Mainland, BC &nbsp;|&nbsp; Fully Insured
        </div>

    </div>
 <script src="https://cdn.jsdelivr.net/npm/signature_pad"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function(){

            // ✅ Init signature pad
            var canvas = document.getElementById('signature-pad');
            window.signaturePad = new SignaturePad(canvas);

            // ✅ Clear pad
            window.clearPad = function(){
                signaturePad.clear();
            }

            // ✅ Main handler (ACCEPT + DECLINE)
            window.handleSubmit = function(type){

                const form = document.getElementById('signForm');
                document.getElementById('action_type').value = type;

                // =========================
                // ❌ DECLINE (NO VALIDATION)
                // =========================
                if(type === 'decline'){
                    // Optional confirm
                    if(confirm("Are you sure you want to decline this quote?")){
                        form.submit();
                    }
                    return;
                }

                // =========================
                // ✅ ACCEPT (FULL VALIDATION)
                // =========================
                let agreement = document.querySelector('.agreement-box input[type="checkbox"]');
                let terms = document.getElementById('termsCheck');
                let typed = document.getElementById('typed_signature').value.trim();

                if(typed === "" && signaturePad.isEmpty()){
                    alert("Please provide a signature (type or draw)");
                    return;
                }
  if(agreement && !agreement.checked){
                    alert('Please accept the Service Agreement first.');
                    return;
                }

                if(terms && !terms.checked){
                    alert('Please accept the Terms & Conditions.');
                    return;
                }

                // ✅ Save signature
                if(typed !== ""){
                    document.getElementById('signature').value = typed;
                } else {
                    document.getElementById('signature').value = signaturePad.toDataURL();
                }


                let paymentMethod = document.getElementById('payment_method');

if (paymentMethod.value === "") {
    alert("Please select a payment method.");
    paymentMethod.focus();
    return;
}

                form.submit();
            }

        });
    </script>

</x-layout>