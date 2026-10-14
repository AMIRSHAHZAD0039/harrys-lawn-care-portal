<x-layout>

    {{--<div class="print-bar"><button onclick="window.print()">🖨 Print / Save PDF</button></div>--}}
    <link rel="stylesheet" href="{{asset('css/quote-create.css')}}">

    <style>
        /* ===== Pricing tabs ===== */
        .price-tabs{display:flex;border:1px solid var(--bd);border-bottom:none;margin-top:2px;}
        .price-tab{
            flex:1;text-align:center;padding:9px 14px;cursor:pointer;user-select:none;
            font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
            color:var(--sub);background:var(--alt);border-right:1px solid var(--bd);
            transition:background .15s,color .15s;
        }
        .price-tab:last-child{border-right:none;}
        .price-tab.active{background:var(--dk);color:#fff;}
        .price-panel{display:none;}
        .price-panel.active{display:block;}
        .add-row-btn{
            background:none;border:1px dashed #888;color:#1b3a2a;
            padding:5px 16px;cursor:pointer;font-size:13px;letter-spacing:.5px;margin:8px 0;
        }
        .add-row-btn:hover{background:var(--lt);}

        /* ===== Seasonal frequency ===== */
        .freq-wrap{
            display:flex;align-items:center;gap:18px;margin:0 0 16px;
            padding:9px 14px;background:var(--alt);border:1px solid var(--bd);border-radius:2px;
        }
        .freq-opt{display:flex;align-items:center;gap:6px;font-size:12px;font-weight:600;color:var(--tx);cursor:pointer;}
        .freq-opt input{accent-color:var(--dk);margin:0;}
    </style>    <form method="POST" action="{{ route('quote.update', $quote->id) }}">
        @csrf
        @method('PUT')

        @php
            // One-time bucket = ONLY rows explicitly typed 'onetime'.
            // Seasonal bucket = EVERYTHING ELSE (seasonal + null/blank/unknown type),
            // so items saved without a clean type are never dropped — they land here
            // (seasonal is the default) and stay editable on this edit page.
            $onetimeItems  = $quote->items->filter(fn($i) => strtolower(trim((string)($i->type ?? ''))) === 'onetime');
            $seasonalItems = $quote->items->filter(fn($i) => strtolower(trim((string)($i->type ?? ''))) !== 'onetime');

            // service_type hamesha hoti hai; ?? '' sirf trim(null) fatal (PHP 8.1+) se bachne ke liye.
            $isSeasonal = strtoupper(trim($quote->service_type ?? '')) === 'SEASONAL PROGRAM';

            // Frequency null ho sakti hai. Pricing service_type se chalti hai, frequency se nahi —
            // is liye empty frequency kabhi data hide nahi karti. $freq null hua to koi radio checked nahi.
            $freq = $quote->seasonal_frequency;
        @endphp

        <div class="page">

            <!-- HEADER -->
            <div class="hdr">
                <div class="logo">
                    <!-- <div class="logo-name">HARRY'S <span class="leaf">🌿</span></div>
                    <div class="logo-divider">
                        <hr/><span>LAWN</span><hr/><span>CARE</span><hr/>
                    </div> -->
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
                            <input type="text" name="quote_number" value="{{$quote->id}}"  style="width:100%" readonly>

                            <span class="flabel">Date:</span>
                            <input type="date" name="date" value="{{$quote->date}}" style="width:100%">

                            <span class="flabel">Valid Until:</span>
                            <input type="date" name="valid_until" value="{{$quote->valid_until}}"  style="width:100%">

                            <span class="flabel">Prepared By:</span>
                            <input type="text" name="prepared_by" value="{{$quote->prepared_by}}"  style="width:100%">

                        </div>
                    </div>


                    <div>
                        <div class="stitle">Client Information</div>

                        <div class="ci-grid">

                            <span class="flabel">Name:</span>
                            <input type="text" name="client_name" value="{{$quote->client_name}}"  style="width:100%">

                            <span class="flabel">Address:</span>
                            <input type="text" name="client_address" value="{{$quote->client_address}}"  style="width:100%">

                        </div>

                        <div class="ci-phone-row" style="margin-top:5px">

                            <span class="flabel">Phone:</span>
                            <input type="tel" name="client_phone" value="{{$quote->client_phone}}" style="width:100%">

                            <span class="flabel">Email:</span>
                            <input type="email" name="client_email" value="{{$quote->client_email}}"  style="width:100%">

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
                    </thead>  <tbody>

                    <tr>

                        <td>
                            <input type="text" name="lawn_size" value="{{$quote->lawn_size}}" placeholder="Enter lawn size">
                        </td>

                        <td>
                            <input type="text" name="service_area"  value="{{$quote->service_area}}" placeholder="Service area">
                        </td>

                        <td>
                            <input type="text" name="terrain" value="{{$quote->terrain}}" placeholder="Terrain">
                        </td>

                        <td>
                            <input type="text" name="access" value="{{$quote->access}}"  placeholder="Access">
                        </td>

                    </tr>

                    </tbody>
                </table>

                <div class="cond-row" style="margin-bottom:16px">

                    <span class="flabel">Condition:</span>
                    <input type="text" name="condition" value="{{$quote->condition}}" style="width:100%">

                    <span class="flabel">Notes/Hazards:</span>
                    <input type="text" name="hazards" value="{{$quote->hazards}}"   style="width:100%">

                </div>


                <!-- SERVICE TYPE -->

                <div class="stitle">Service Type</div>

                <input type="hidden" id="service_type" name="service_type" value="{{ $quote->service_type }}">

                <div class="svc-row">

                    <!-- Seasonal -->
                    <div class="svc-box {{ $isSeasonal ? 'on' : '' }}"
                         onclick="svcSel(this, 'Seasonal Program')">

                        <div class="svc-top"><span class="svc-ck"></span></div>

                        <div class="svc-title">Seasonal Program</div>

                        <div class="svc-sub">
                            Bi-Weekly Mowing, Edging, Blowing • Full Season (Apr–Oct)
                        </div>

                    </div>
                    <!-- One-Time -->
                    <div class="svc-box {{ !$isSeasonal && $quote->service_type ? 'on' : '' }}"
                         onclick="svcSel(this, 'One-Time Service')">

                        <div class="svc-top"><span class="svc-ck"></span></div>

                        <div class="svc-title">One-Time Service</div>

                        <div class="svc-sub">
                            Single Job • No Long-Term Commitment
                        </div>

                    </div>

                </div>

                <!-- SEASONAL FREQUENCY -->
                <div class="freq-wrap" id="seasonal-freq-wrap" style="{{ $isSeasonal ? '' : 'display:none' }}">
                    <span class="flabel">Frequency:</span>
                    <label class="freq-opt"><input type="radio" name="seasonal_frequency" value="Weekly" {{ $freq === 'Weekly' ? 'checked' : '' }}> Weekly</label>
                    <label class="freq-opt"><input type="radio" name="seasonal_frequency" value="Bi-Weekly" {{ $freq === 'Bi-Weekly' ? 'checked' : '' }}> Bi-Weekly</label>
                    <label class="freq-opt"><input type="radio" name="seasonal_frequency" value="Monthly" {{ $freq === 'Monthly' ? 'checked' : '' }}> Monthly</label>
                </div>


                <!-- PRICING BREAKDOWN -->

                <div class="stitle">Pricing Breakdown</div>

                <div class="price-tabs">
                    <div class="price-tab {{ $isSeasonal ? 'active' : '' }}" data-tab="seasonal" onclick="showTab('seasonal')">Seasonal Program</div>
                    <div class="price-tab {{ !$isSeasonal ? 'active' : '' }}" data-tab="onetime" onclick="showTab('onetime')">One-Time Service</div>
                </div>
 <!-- ===== SEASONAL PANEL ===== -->
                <div class="price-panel {{ $isSeasonal ? 'active' : '' }}" id="panel-seasonal">

                    <button type="button" class="add-row-btn" onclick="addRow('seasonal')">+ Add Row</button>

                    <table class="price-tbl">
                        <thead>
                        <tr>
                            <th style="width:55%">Service Description</th>
                            <th style="width:10%;text-align:right">Qty</th>
                            <th style="width:15%;text-align:right">Rate / Price</th>
                            <th style="width:15%;text-align:right">Amount</th>
                            <th style="width:30px"></th>
                        </tr>
                        </thead>

                        <tbody id="rows-seasonal">

                        @forelse($seasonalItems as $item)
                            <tr>
                                <td><input type="text" name="seasonal_description[]" value="{{$item->description}}"></td>
                                <td><input type="number" name="seasonal_qty[]" value="{{$item->qty}}" class="qty" style="text-align:right"></td>
                                <td><input type="number" name="seasonal_rate[]" value="{{$item->rate}}" class="rate" style="text-align:right"></td>
                                <td><input type="text" name="seasonal_amount[]" value="{{$item->amount}}" class="amount" readonly style="text-align:right"></td>
                                <td style="text-align:center;width:30px">
                                    <button type="button" onclick="removeRow(this)"
                                        style="background:none;border:none;color:#c0392b;font-size:18px;cursor:pointer">−</button>
                                </td>
                            </tr> @empty
                            <tr>
                                <td><input type="text" name="seasonal_description[]"></td>
                                <td><input type="number" name="seasonal_qty[]" class="qty" style="text-align:right"></td>
                                <td><input type="number" name="seasonal_rate[]" class="rate" style="text-align:right"></td>
                                <td><input type="text" name="seasonal_amount[]" class="amount" readonly style="text-align:right"></td>
                                <td style="text-align:center;width:30px">
                                    <button type="button" onclick="removeRow(this)"
                                        style="background:none;border:none;color:#c0392b;font-size:18px;cursor:pointer">−</button>
                                </td>
                            </tr>
                        @endforelse

                        <tr class="sum-row">
                            <td colspan="3" style="text-align:right;font-weight:700">Subtotal</td>
                            <td><input type="text" name="seasonal_subtotal" value="{{$quote->seasonal_subtotal}}" id="subtotal-seasonal" style="text-align:right" readonly></td>
                        </tr>
                        <tr class="sum-row">
                            <td colspan="3" style="text-align:right;font-weight:700">Discount</td>
                            <td><input type="text" name="seasonal_discount" value="{{$quote->seasonal_discount}}" id="discount-seasonal" style="text-align:right"></td>
                        </tr>
                        <tr class="sum-row">
                            <td colspan="3" style="text-align:right;font-weight:700">GST (5%)</td>
                            <td><input type="text" name="seasonal_gst" value="{{$quote->seasonal_gst}}" id="gst-seasonal" style="text-align:right" readonly></td>
                        </tr>
                        <tr class="total-row" style="background:#1a2e22">
                            <td colspan="3" style="text-align:right;background:#1a2e22">TOTAL</td>
                            <td style="background:#1a2e22"><input type="text" name="seasonal_total" value="{{$quote->seasonal_total}}" id="total-seasonal"
                                   style="text-align:right;background:transparent;border:none;font-weight:700;color:#fff;width:100%" readonly></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
<!-- ===== ONE-TIME PANEL ===== -->
                <div class="price-panel {{ !$isSeasonal ? 'active' : '' }}" id="panel-onetime">

                    <button type="button" class="add-row-btn" onclick="addRow('onetime')">+ Add Row</button>

                    <table class="price-tbl">
                        <thead>
                        <tr>
                            <th style="width:55%">Service Description</th>
                            <th style="width:10%;text-align:right">Qty</th>
                            <th style="width:15%;text-align:right">Rate / Price</th>
                            <th style="width:15%;text-align:right">Amount</th>
                            <th style="width:30px"></th>
                        </tr>
                        </thead>

                        <tbody id="rows-onetime">

                        @forelse($onetimeItems as $item)
                            <tr>
                                <td><input type="text" name="onetime_description[]" value="{{$item->description}}"></td>
                                <td><input type="number" name="onetime_qty[]" value="{{$item->qty}}" class="qty" style="text-align:right"></td>
                                <td><input type="number" name="onetime_rate[]" value="{{$item->rate}}" class="rate" style="text-align:right"></td>
                                <td><input type="text" name="onetime_amount[]" value="{{$item->amount}}" class="amount" readonly style="text-align:right"></td>
                                <td style="text-align:center;width:30px">
                                    <button type="button" onclick="removeRow(this)"
                                        style="background:none;border:none;color:#c0392b;font-size:18px;cursor:pointer">−</button>
                                </td>
                            </tr>  @empty
                            <tr>
                                <td><input type="text" name="onetime_description[]"></td>
                                <td><input type="number" name="onetime_qty[]" class="qty" style="text-align:right"></td>
                                <td><input type="number" name="onetime_rate[]" class="rate" style="text-align:right"></td>
                                <td><input type="text" name="onetime_amount[]" class="amount" readonly style="text-align:right"></td>
                                <td style="text-align:center;width:30px">
                                    <button type="button" onclick="removeRow(this)"
                                        style="background:none;border:none;color:#c0392b;font-size:18px;cursor:pointer">−</button>
                                </td>
                            </tr>
                        @endforelse

                        <tr class="sum-row">
                            <td colspan="3" style="text-align:right;font-weight:700">Subtotal</td>
                            <td><input type="text" name="onetime_subtotal" value="{{$quote->onetime_subtotal}}" id="subtotal-onetime" style="text-align:right" readonly></td>
                        </tr>
                        <tr class="sum-row">
                            <td colspan="3" style="text-align:right;font-weight:700">Discount</td>
                            <td><input type="text" name="onetime_discount" value="{{$quote->onetime_discount}}" id="discount-onetime" style="text-align:right"></td>
                        </tr>
                        <tr class="sum-row">
                            <td colspan="3" style="text-align:right;font-weight:700">GST (5%)</td>
                            <td><input type="text" name="onetime_gst" value="{{$quote->onetime_gst}}" id="gst-onetime" style="text-align:right" readonly></td>
                        </tr>
                        <tr class="total-row" style="background:#1a2e22">
                            <td colspan="3" style="text-align:right;background:#1a2e22">TOTAL</td>
                            <td style="background:#1a2e22"><input type="text" name="onetime_total" value="{{$quote->onetime_total}}" id="total-onetime"
                                   style="text-align:right;background:transparent;border:none;font-weight:700;color:#fff;width:100%" readonly></td>
                        </tr>

                        </tbody>
                    </table>
                </div>

 <!-- NOTES -->

                <div class="stitle" style="margin-top:16px">Notes</div>

                <div class="notes-box">

                    <textarea  name="notes" class="auto-expand" rows="3" >{{$quote->notes}}</textarea>
                </div>



                <!-- QUOTE ACCEPTANCE -->

                <div class="stitle" style="margin-top:14px">Quote Acceptance</div>

                <div class="accept-text">
                    By signing below, the Client accepts this quotation and agrees to the applicable Service Agreement:
                </div>


                <div class="sig-grid mt-3">
                    <div>
                        <div class="sig-label">Client Signature</div>

                        @if(Str::startsWith($quote->client_signature, 'data:image'))
                            <!-- Show Image -->
                            <img src="{{ $quote->client_signature }}"
                                 style="max-height:80px; border-bottom:1px solid var(--bd); padding-bottom:5px;" alt="">
                        @else
                            <!-- Show Text -->
                            <input class="sig-input"
                                   type="text"
                                   value="{{ $quote->client_signature }}"
                                   readonly>
                        @endif <div style="margin-top:8px">
                            <div class="sig-label">Name (Print):</div>
                            <input type="text"
                                   value="{{ $quote->client_name_print }}"
                                   readonly
                                   style="width:100%;border:none;border-bottom:1px solid var(--bd);">
                        </div>
                    </div>

                    <div>
                        <div class="sig-grid" style="grid-template-columns:auto 1fr;gap:6px 8px;align-items:center">

                            <span class="flabel">Date:</span>
                            <input type="date" name="signature_date" value="{{$quote->signature_date}}" readonly style="width:100%">

                            <span class="flabel">Rep:</span>
                            <input type="text" name="representative" value="{{$quote->representative}}"  style="width:100%">
                             <span class="flabel">Payment Method:</span>
                            <input type="text" value="{{$quote->payment_method}}" readonly style="width:100%">
                         </div>
                    </div>

                </div>

            </div><div class="page-footer">
                Harry's Lawncare Ltd. &nbsp;|&nbsp; Serving the Lower Mainland, BC &nbsp;|&nbsp; Fully Insured
            </div>

        </div>
        <div style="text-align:center;margin:30px 0">

            <button type="submit"
                    style="
                    background:#1b3a2a;
                    color:white;
                    padding:12px 40px;
                    border:none;
                    font-weight:bold;
                    cursor:pointer;
                    font-size:14px;
                    letter-spacing:1px;
                    ">

                Update Quote

            </button>

        </div>

    </form>

</x-layout>

{{-----------------------------------------------calculation--}}
<script>
window.addEventListener('DOMContentLoaded', () => {
    toggleFreq();
    bindRowEvents();
    calc('seasonal');
    calc('onetime');
});function svcSel(el, title){
    document.querySelectorAll('.svc-box').forEach(b => b.classList.remove('on'));
    el.classList.add('on');
    document.getElementById('service_type').value = title;
    toggleFreq();
}

/* frequency sirf Seasonal Program ke liye */
function toggleFreq(){
    const sel  = document.querySelector('.svc-box.on .svc-title');
    const wrap = document.getElementById('seasonal-freq-wrap');
    if(!wrap) return;
    wrap.style.display = (sel && sel.innerText.trim().toUpperCase() === 'SEASONAL PROGRAM') ? 'flex' : 'none';
}

function showTab(prefix){
    document.querySelectorAll('.price-tab').forEach(t => t.classList.toggle('active', t.dataset.tab === prefix));
    document.querySelectorAll('.price-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('panel-' + prefix).classList.add('active');
}

function bindRowEvents(){
    document.querySelectorAll('.qty, .rate').forEach(input => {
        input.removeEventListener('input', onCalcInput);
        input.addEventListener('input', onCalcInput);
    });
    ['seasonal','onetime'].forEach(p => {
        const d = document.getElementById('discount-' + p);
        if(d){
            d.removeEventListener('input', onCalcInput);
            d.addEventListener('input', onCalcInput);
        }
    });
}

function onCalcInput(e){
    const panel = e.target.closest('.price-panel');
    if(panel){ calc(panel.id.replace('panel-','')); }
}

function addRow(prefix){
    const tbody = document.getElementById('rows-' + prefix);
    const firstSumRow = tbody.querySelector('.sum-row');

    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input type="text" name="${prefix}_description[]"></td>
        <td><input type="number" name="${prefix}_qty[]" class="qty" style="text-align:right"></td>
        <td><input type="number" name="${prefix}_rate[]" class="rate" style="text-align:right"></td>
        <td><input type="text" name="${prefix}_amount[]" class="amount" readonly style="text-align:right"></td>
        <td style="text-align:center;width:30px">
            <button type="button" onclick="removeRow(this)"
            style="background:none;border:none;color:#c0392b;font-size:18px;cursor:pointer">−</button>
        </td>
    `;
 tbody.insertBefore(tr, firstSumRow);
    bindRowEvents();
    calc(prefix);
}

function removeRow(btn){
    const tbody = btn.closest('tbody');
    const dataRows = tbody.querySelectorAll('tr:not(.sum-row):not(.total-row)');
    if(dataRows.length <= 1){
        alert('At least one row is required!');
        return;
    }
    const prefix = tbody.id.replace('rows-','');
    btn.closest('tr').remove();
    calc(prefix);
}

function calc(prefix){
    const tbody = document.getElementById('rows-' + prefix);
    if(!tbody) return;

    let subtotal = 0;

    tbody.querySelectorAll('tr').forEach(row => {
        if(row.classList.contains('sum-row') || row.classList.contains('total-row')) return;

        let qty = row.querySelector('.qty');
        let rate = row.querySelector('.rate');
        let amount = row.querySelector('.amount');

        if(qty && rate && amount){
            let q = parseFloat(qty.value) || 0;
            let r = parseFloat(rate.value) || 0;
            let t = q * r;
            amount.value = t.toFixed(2);
            subtotal += t;
        }
    });

    document.getElementById('subtotal-' + prefix).value = subtotal.toFixed(2);

    let discount = parseFloat(document.getElementById('discount-' + prefix).value) || 0;
    let afterDiscount = Math.max(subtotal - discount, 0);

    let gst = afterDiscount * 0.05;
    document.getElementById('gst-' + prefix).value = gst.toFixed(2);

    document.getElementById('total-' + prefix).value = (afterDiscount + gst).toFixed(2);
}
</script>