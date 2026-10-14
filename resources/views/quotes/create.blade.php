<x-layout>

{{--<div class="print-bar"><button onclick="window.print()">🖨 Print / Save PDF</button></div>--}}
    <link rel="stylesheet" href="{{asset('css/quote-create.css')}}">

    <style>
        /* ===== Pricing tabs (Seasonal / One-Time) ===== */
        .price-tabs{display:flex;border:1px solid var(--bd);border-bottom:none;}
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

        /* ===== Seasonal frequency selector ===== */
        .freq-wrap{
            display:flex;align-items:center;gap:18px;margin:0 0 16px;
            padding:9px 14px;background:var(--alt);border:1px solid var(--bd);border-radius:2px;
        }
        .freq-opt{display:flex;align-items:center;gap:6px;font-size:12px;font-weight:600;color:var(--tx);cursor:pointer;}
        .freq-opt input{accent-color:var(--dk);margin:0;}

        @media print{.add-row-btn{display:none}}
    </style>

<form method="POST" action="{{ route('quote.store') }}">
    @csrf
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
                    <input type="text" name="quote_number" style="width:100%" readonly>

                    <span class="flabel">Date:</span>
                    <input type="date" name="date" style="width:100%" value="{{ $today }}">

                    <span class="flabel">Valid Until:</span>
                    <input type="date" name="valid_until" style="width:100%" value="{{ $validUntil }}">

                    <span class="flabel">Prepared By:</span>
                    <input type="text" name="prepared_by" style="width:100%">

                </div>
            </div>


            <div>
                <div class="stitle">Client Information</div>

                <div class="ci-grid">

                    <span class="flabel">Name:</span>
                    <input type="text" name="client_name" style="width:100%" value="{{ $lead ? $lead->first_name . ' ' . $lead->last_name : '' }}">

                    <span class="flabel">Address:</span>
                    <input type="text" name="client_address" style="width:100%"  value="{{ $lead->address ?? '' }}">

                </div>

                <div class="ci-phone-row" style="margin-top:5px">

                    <span class="flabel">Phone:</span>
                    <input type="tel" name="client_phone" style="width:100%" value="{{ $lead->phone ?? '' }}">

                    <span class="flabel">Email:</span>
                    <input type="email" name="client_email" style="width:100%" value="{{ $lead->email ?? '' }}">

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

                <td>
                    <input type="text" name="lawn_size" placeholder="Enter lawn size">
                </td>

                <td>
                    <input type="text" name="service_area" placeholder="Service area">
                </td>

                <td>
                    <input type="text" name="terrain" placeholder="Terrain">
                </td>

                <td>
                    <input type="text" name="access" placeholder="Access">
                </td>

            </tr>

            </tbody>
        </table>


        <div class="cond-row" style="margin-bottom:16px">

            <span class="flabel">Condition:</span>
            <input type="text" name="condition" style="width:100%">

            <span class="flabel">Notes/Hazards:</span>
            <input type="text" name="hazards" style="width:100%">

        </div>


        <!-- SERVICE TYPE -->

        <div class="stitle">Service Type</div>

        <input type="hidden" id="service_type" name="service_type" value="">


        <div class="svc-row">

            <div class="svc-box on" onclick="svcSel(this)">

                <div class="svc-top"><span class="svc-ck"></span></div>

                <div class="svc-title">Seasonal Program</div>

                <div class="svc-sub">
                   Weekly, Bi-Weekly , Monthly
                </div>

            </div>


            <div class="svc-box" onclick="svcSel(this)">

                <div class="svc-top"><span class="svc-ck"></span></div>

                <div class="svc-title">One-Time Service</div>

                <div class="svc-sub">
                    Single Job • No Long-Term Commitment
                </div>

            </div>

        </div>

        <!-- SEASONAL FREQUENCY (shown only when Seasonal Program selected) -->
        <div class="freq-wrap" id="seasonal-freq-wrap">
            <span class="flabel">Frequency:</span>
            <label class="freq-opt"><input type="radio" name="seasonal_frequency" value="Weekly"> Weekly</label>
            <label class="freq-opt"><input type="radio" name="seasonal_frequency" value="Bi-Weekly" checked> Bi-Weekly</label>
            <label class="freq-opt"><input type="radio" name="seasonal_frequency" value="Monthly"> Monthly</label>
        </div>



        <!-- PRICING BREAKDOWN -->

        <div class="stitle">Pricing Breakdown</div>

        <div class="price-tabs">
            <div class="price-tab active" data-tab="seasonal" onclick="showTab('seasonal')">Seasonal Program</div>
            <div class="price-tab" data-tab="onetime" onclick="showTab('onetime')">One-Time Service</div>
        </div>

        <!-- ===== SEASONAL PANEL ===== -->
        <div class="price-panel active" id="panel-seasonal">

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

                    <tr>
                        <td><input type="text" name="seasonal_description[]"></td>
                        <td><input type="number" name="seasonal_qty[]" class="qty" style="text-align:right"></td>
                        <td><input type="number" name="seasonal_rate[]" class="rate" style="text-align:right"></td>
                        <td><input type="text" name="seasonal_amount[]" class="amount" readonly style="text-align:right"></td>
                        <td style="text-align:center;width:30px">
                            <button type="button" class="remove-row" onclick="removeRow(this)" title="Remove row"
                                style="background:none;border:none;color:#c0392b;font-size:18px;cursor:pointer;line-height:1;padding:0 4px">−</button>
                        </td>
                    </tr>

                    <tr class="sum-row">
                        <td colspan="3" style="text-align:right;font-weight:700">Subtotal</td>
                        <td><input type="text" name="seasonal_subtotal" id="subtotal-seasonal" style="text-align:right"></td>
                    </tr>
                    <tr class="sum-row">
                        <td colspan="3" style="text-align:right;font-weight:700">Discount</td>
                        <td><input type="text" name="seasonal_discount" id="discount-seasonal" style="text-align:right"></td>
                    </tr>
                    <tr class="sum-row">
                        <td colspan="3" style="text-align:right;font-weight:700">GST (5%)</td>
                        <td><input type="text" name="seasonal_gst" id="gst-seasonal" style="text-align:right"></td>
                    </tr>
                    <tr class="total-row" style="background:#1B3A2A !important;">
                        <td colspan="3" style="text-align:right;background:#1B3A2A !important;">TOTAL</td>
                        <td style="background:#1B3A2A !important;"><input type="text" name="seasonal_total" id="total-seasonal"
                               style="text-align:right;background:transparent;border:none;font-weight:700;color:#fff;width:100%"></td>
                    </tr>

                </tbody>

            </table>
        </div>

        <!-- ===== ONE-TIME PANEL ===== -->
        <div class="price-panel" id="panel-onetime">

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

                    <tr>
                        <td><input type="text" name="onetime_description[]"></td>
                        <td><input type="number" name="onetime_qty[]" class="qty" style="text-align:right"></td>
                        <td><input type="number" name="onetime_rate[]" class="rate" style="text-align:right"></td>
                        <td><input type="text" name="onetime_amount[]" class="amount" readonly style="text-align:right"></td>
                        <td style="text-align:center;width:30px">
                            <button type="button" class="remove-row" onclick="removeRow(this)" title="Remove row"
                                style="background:none;border:none;color:#c0392b;font-size:18px;cursor:pointer;line-height:1;padding:0 4px">−</button>
                        </td>
                    </tr>

                    <tr class="sum-row">
                        <td colspan="3" style="text-align:right;font-weight:700">Subtotal</td>
                        <td><input type="text" name="onetime_subtotal" id="subtotal-onetime" style="text-align:right"></td>
                    </tr>
                    <tr class="sum-row">
                        <td colspan="3" style="text-align:right;font-weight:700">Discount</td>
                        <td><input type="text" name="onetime_discount" id="discount-onetime" style="text-align:right"></td>
                    </tr>
                    <tr class="sum-row">
                        <td colspan="3" style="text-align:right;font-weight:700">GST (5%)</td>
                        <td><input type="text" name="onetime_gst" id="gst-onetime" style="text-align:right"></td>
                    </tr>
                    <tr class="total-row" style="background:#1B3A2A !important;">
                        <td colspan="3" style="text-align:right;background:#1B3A2A !important;">TOTAL</td>
                        <td style="background:#1B3A2A !important;"><input type="text" name="onetime_total" id="total-onetime"
                               style="text-align:right;background:transparent;border:none;font-weight:700;color:#fff;width:100%"></td>
                    </tr>

                </tbody>

            </table>
        </div>



        <!-- NOTES -->

        <div class="stitle" style="margin-top:16px">Notes</div>

        <div class="notes-box">
            <textarea name="notes" class="auto-expand" rows="3"></textarea>
        </div>



        <!-- QUOTE ACCEPTANCE -->

        <div class="stitle" style="margin-top:14px">Quote Acceptance</div>

        <div class="accept-text">
            By signing below, the Client accepts this quotation and agrees to the applicable Service Agreement:
        </div>


        <div class="sig-grid">

            <div>

                <div class="sig-label">Client Signature</div>
                <input class="sig-input" name="client_signature" type="text">

                <div style="margin-top:8px">

                    <div class="sig-label">Name (Print):</div>

                    <input type="text" name="client_name_print"
                           style="width:100%;border:none;border-bottom:1px solid var(--bd);">

                </div>

            </div>


            <div>

                <div class="sig-grid" style="grid-template-columns:auto 1fr;gap:6px 8px;align-items:center">

                    <span class="flabel">Date:</span>
                    <input type="date" name="signature_date" style="width:100%">

                    <span class="flabel">Rep:</span>
                    <input type="text" name="representative" style="width:100%">

                </div>

            </div>

        </div>

    </div>

    <div class="page-footer">
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

            CREATE QUOTE

        </button>

    </div>

</form>

</x-layout>

{{-----------------------------------------------calculation--}}
<script>

    window.addEventListener('DOMContentLoaded', () => {
        const defaultBox = document.querySelector('.svc-box.on');
        if (defaultBox) {
            document.getElementById('service_type').value =
                defaultBox.querySelector('.svc-title').innerText;
        }
        toggleFreq();
        bindRowEvents();
        calc('seasonal');
        calc('onetime');
    });

    function svcSel(el){
        document.querySelectorAll('.svc-box').forEach(b=>b.classList.remove('on'));
        el.classList.add('on');
        document.getElementById('service_type').value =
            el.querySelector('.svc-title').innerText;
        toggleFreq();
    }

    /* show frequency only for Seasonal Program */
    function toggleFreq(){
        const sel  = document.querySelector('.svc-box.on .svc-title');
        const wrap = document.getElementById('seasonal-freq-wrap');
        if(!wrap) return;
        if(sel && sel.innerText.trim().toUpperCase() === 'SEASONAL PROGRAM'){
            wrap.style.display = 'flex';
        } else {
            wrap.style.display = 'none';
        }
    }

    /* switch pricing tab */
    function showTab(prefix){
        document.querySelectorAll('.price-tab').forEach(t=>t.classList.toggle('active', t.dataset.tab === prefix));
        document.querySelectorAll('.price-panel').forEach(p=>p.classList.remove('active'));
        document.getElementById('panel-'+prefix).classList.add('active');
    }

    function bindRowEvents(){
        document.querySelectorAll('.qty, .rate').forEach(function(input){
            input.removeEventListener('input', onCalcInput);
            input.addEventListener('input', onCalcInput);
        });
        ['seasonal','onetime'].forEach(function(p){
            const d = document.getElementById('discount-'+p);
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
        const tbody = document.getElementById('rows-'+prefix);
        const firstSumRow = tbody.querySelector('.sum-row');

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="text" name="${prefix}_description[]"></td>
            <td><input type="number" name="${prefix}_qty[]" class="qty" style="text-align:right"></td>
            <td><input type="number" name="${prefix}_rate[]" class="rate" style="text-align:right"></td>
            <td><input type="text" name="${prefix}_amount[]" class="amount" readonly style="text-align:right"></td>
            <td style="text-align:center;width:30px">
                <button type="button" class="remove-row" onclick="removeRow(this)" title="Remove row"
                    style="background:none;border:none;color:#c0392b;font-size:18px;cursor:pointer;line-height:1;padding:0 4px">−</button>
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
        const tbody = document.getElementById('rows-'+prefix);
        if(!tbody) return;

        let subtotal = 0;

        tbody.querySelectorAll('tr').forEach(function(row){
            if(row.classList.contains('sum-row') || row.classList.contains('total-row')) return;

            let qty  = row.querySelector('.qty');
            let rate = row.querySelector('.rate');
            let amountField = row.querySelector('.amount');

            if(qty && rate && amountField){
                let q = parseFloat(qty.value) || 0;
                let r = parseFloat(rate.value) || 0;
                let amount = q * r;
                amountField.value = amount.toFixed(2);
                subtotal += amount;
            }
        });

        document.getElementById('subtotal-'+prefix).value = subtotal.toFixed(2);

        let discount = parseFloat(document.getElementById('discount-'+prefix).value) || 0;
        let afterDiscount = Math.max(subtotal - discount, 0);

        let gst = afterDiscount * 0.05;
        document.getElementById('gst-'+prefix).value = gst.toFixed(2);

        let total = afterDiscount + gst;
        document.getElementById('total-'+prefix).value = total.toFixed(2);
    }

</script>