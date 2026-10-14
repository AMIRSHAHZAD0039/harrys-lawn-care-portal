<x-layout>
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harry's Lawn Care</title>
    <link rel="icon" type="image/x-icon" href="{{asset('images/logo.webp')}}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --dk: #1b3a2a;
            --md: #2d5c3e;
            --lt: #e8f0eb;
            --bd: #c2d4c9;
            --tx: #1a2e22;
            --sub: #4a6b56;
            --alt: #f2f7f4;
            --white: #ffffff;
        }

        body {
            background: #dde6e0;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 13px;
            color: var(--tx);
            padding: 30px 16px 60px;
            overflow: auto !important;
        }

        .page {
            width: 210mm;
            min-width: 210mm;
            max-width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: var(--white);
            border: 1px solid #b8cfc3;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;
            padding: 0;
        }

        /* HEADER */
        .hdr {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 22px 32px 18px;
            background: #fff;
        }

        .logo {
            line-height: 1;
        }

        .logo-name {
            font-family: 'EB Garamond', serif;
            font-size: 34px;
            font-weight: 700;
            color: var(--dk);
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .logo-name .leaf {
            font-size: 20px;
            vertical-align: middle;
            color: var(--md);
        }

        .logo-divider {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 1px;
        }

        .logo-divider span {
            font-size: 8.5px;
            letter-spacing: .25em;
            font-weight: 700;
            color: var(--dk);
            text-transform: uppercase;
        }

        .logo-divider hr {
            flex: 1;
            border: none;
            border-top: 1.5px solid var(--dk);
            width: 22px;
        }

        .hdr-right {
            text-align: right;
        }

        .hdr-right h1 {
            font-family: 'EB Garamond', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--dk);
            letter-spacing: .06em;
            text-transform: uppercase;
        }  .hdr-right .co {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx);
            margin-top: 2px;
        }

        .hdr-right .ins {
            font-size: 11px;
            font-style: italic;
            color: var(--sub);
            margin-top: 1px;
        }

        /* DIVIDER LINE */
        .top-rule {
            height: 3px;
            background: var(--dk);
            margin: 0 32px;
        }

        /* MAIN BODY */
        .body {
            padding: 20px 32px 28px;
        }

        .two-top {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 32px;
            margin-bottom: 18px;
        }

        .stitle {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--tx);
            border-bottom: 2px solid var(--dk);
            padding-bottom: 3px;
            margin-bottom: 10px;
        }

        .frow {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 7px;
            flex-wrap: wrap;
        }

        .flabel {
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            color: var(--tx);
        }

        input[type=text],
        input[type=date],
        input[type=email],
        input[type=tel] {
            border: none;
            border-bottom: 1px solid var(--bd);
            padding: 2px 5px;
            font-size: 12px;
            font-family: 'Source Sans 3', sans-serif;
            color: var(--tx);
            background: transparent;
            outline: none;
            transition: border-color .15s;
        }

        input:focus {
            border-bottom-color: var(--md);
            background: rgba(45, 92, 62, .04);
        }

        .qd-grid {
            display: grid;
            grid-template-columns: auto 1fr auto 1fr;
            align-items: center;
            gap: 5px 8px;
        }

        .ci-grid {
            display: grid;
            grid-template-columns: auto 1fr;
            align-items: center;
            gap: 5px 8px;
        }
  .ci-phone-row {
            display: grid;
            grid-template-columns: auto 1fr auto 1fr;
            align-items: center;
            gap: 5px 8px;
        }

        /* PROPERTY TABLE */
        .prop-tbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .prop-tbl th {
            background: var(--dk);
            color: #fff;
            font-size: 10px;
            letter-spacing: .1em;
            text-transform: uppercase;
            font-weight: 700;
            padding: 6px 10px;
            text-align: center;
            border: 1px solid var(--dk);
        }

        .prop-tbl td {
            border: 1px solid var(--bd);
            padding: 7px 12px;
            vertical-align: top;
            font-size: 12px;
        }

        .cond-row {
            display: grid;
            grid-template-columns: auto 1fr auto 1fr;
            align-items: center;
            gap: 6px 12px;
            margin-bottom: 16px;
        }

        .svc-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border: 1px solid var(--bd);
            margin-bottom: 14px;
        }

        .svc-box {
            padding: 12px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            user-select: none;
            transition: background .15s;
            position: relative;
        }

        .svc-box:first-child {
            border-right: 1px solid var(--bd);
        }

        .svc-box.on {
            background: var(--lt);
        }

        .svc-ck {
            width: 14px;
            height: 14px;
            border: 1.5px solid #8aab97;
            border-radius: 1px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            font-size: 10px;
            font-weight: 900;
            color: var(--dk);
            flex-shrink: 0;
        }  .svc-box.on .svc-ck::after {
            content: 'X';
            font-weight: bold;
        }

        .svc-title {
            font-size: 13.5px;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--tx);
        }

        .svc-sub {
            font-size: 10px;
            color: var(--sub);
            text-align: center;
        }

        /* PRICING TABLE */
        .price-tbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .price-tbl th {
            background: var(--dk);
            color: #fff;
            font-size: 10px;
            letter-spacing: .1em;
            text-transform: uppercase;
            font-weight: 700;
            padding: 7px 10px;
            border: 1px solid var(--dk);
        }

        .price-tbl th:first-child {
            text-align: left;
        }

        .price-tbl th:not(:first-child) {
            text-align: right;
        }

        .price-tbl td {
            border: 1px solid var(--bd);
            padding: 5px 8px;
            font-size: 12px;
        }



        .price-tbl td input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 12px;
            color: var(--tx);
            padding: 0;
        }

        .price-tbl td input:focus {
            background: rgba(45, 92, 62, .06);
            padding: 0 3px;
            border-radius: 1px;
        }

        .price-tbl .sum-row td {
            border: 1px solid var(--bd);
            padding: 5px 10px;
            background: var(--alt);
        }

        .price-tbl .sum-row td:first-child {
            text-align: right;
            font-weight: 700;
            font-size: 12px;
            color: var(--sub);
        }

        .price-tbl .sum-row td:last-child {
            font-size: 12px;
            text-align: right;
        }

        .price-tbl .total-row td {
            background: var(--dk);
            color: #fff;
            font-weight: 700;
            font-size: 13px;
            border: 1px solid var(--dk);
            padding: 6px 10px;
        }

        .price-tbl .total-row td:first-child {
            text-align: right;
        }

        .price-tbl .total-row td input {
            color: #fff;
            font-weight: 700;
            text-align: right;
            width: 100%;
            border: none;
            background: transparent;
        }

        /* NOTES */
        .notes-box textarea {
            width: 100%;
            border: 1px solid var(--bd);
            border-radius: 2px;
            padding: 6px 8px;
            font-size: 12px;
            font-family: 'Source Sans 3', sans-serif;
            color: var(--sub);
            background: var(--alt);
            resize: vertical;
            min-height: 44px;
            outline: none;
        } .notes-box textarea:focus {
            border-color: var(--md);
        }

        /* ACCEPTANCE */
        .sig-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 28px;
        }

        .sig-label {
            font-size: 10px;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--sub);
            margin-bottom: 4px;
            font-weight: 600;
        }

        .sig-input {
            border: none;
            border-bottom: 1.5px solid var(--dk);
            width: 100%;
            height: 40px;
            background: transparent;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 12px;
            color: var(--tx);
            outline: none;
        }

        /* FOOTER */
        .page-footer {
            background: var(--dk);
            color: rgba(255, 255, 255, .7);
            text-align: center;
            font-size: 10.5px;
            letter-spacing: .07em;
            padding: 8px 16px;
            margin-top: 0;
        }

        /* PRINT */
        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .page {
                box-shadow: none;
                border: none;
            }
        }


        /* ---------------------------------------------billing page */

        /* ===== BILLING (page 2) ===== */
.btn-add-bill{
    background:var(--dk); color:#fff; border:none;
    font-size:11px; font-weight:700; letter-spacing:.08em; text-transform:uppercase;
    padding:7px 14px; border-radius:3px; margin-top:8px;
    display:inline-flex; align-items:center; gap:6px; cursor:pointer; transition:background .15s;
}
.btn-add-bill:hover{ background:var(--md); }

.bill-tbl{ width:100%; border-collapse:collapse; margin-bottom:14px; }
.bill-tbl th{
    background:var(--dk); color:#fff; font-size:10px; letter-spacing:.08em; text-transform:uppercase;
    font-weight:700; padding:7px 10px; border:1px solid var(--dk); text-align:left;
}
.bill-tbl th.r, .bill-tbl td.r{ text-align:right; }
.bill-tbl td{ border:1px solid var(--bd); padding:7px 10px; font-size:12px; vertical-align:top; }
.bill-tbl tbody tr:nth-child(even){ background:var(--alt); }
.bill-empty{ text-align:center; color:var(--sub); font-style:italic; padding:16px; }

.badge-pay{ display:inline-block; font-size:9.5px; font-weight:700; letter-spacing:.05em;
    text-transform:uppercase; padding:3px 8px; border-radius:10px; }
.badge-paid{ background:#dff0e6; color:#1b7a42; }
.badge-unpaid{ background:#fbe3e3; color:#b13434; }
.badge-partial{ background:#fdf0d9; color:#9a6a14; }

.bill-sum{ display:flex; justify-content:flex-end; margin-bottom:10px; }
.bill-sum-box{ min-width:240px; }
.bill-sum-row{ display:flex; justify-content:space-between; padding:6px 12px; font-size:12px;
    border:1px solid var(--bd); border-bottom:none; background:var(--alt); }
.bill-sum-row:last-child{ border-bottom:1px solid var(--bd); }
.bill-sum-row.total{ background:var(--dk); color:#fff; font-weight:700; border-color:var(--dk); }
.bill-sum-row .lbl{ font-weight:700; color:var(--sub); }
.bill-sum-row.total .lbl{ color:#fff; }

/* modal */
.modal-bill .modal-content{ border:none; border-radius:6px; overflow:hidden; }
.modal-bill .modal-header{ background:var(--dk); color:#fff; padding:14px 20px; border:none; }
.modal-bill .modal-title{ font-size:14px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; }
.modal-bill .btn-close{ filter:invert(1); opacity:.85; }
.modal-bill label{ font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.05em;
    color:var(--tx); margin-bottom:4px; display:block; }
.modal-bill .form-control, .modal-bill .form-select{ font-size:13px; border:1px solid var(--bd);
    border-radius:3px; padding:7px 10px; color:var(--tx); }
.modal-bill .form-control:focus, .modal-bill .form-select:focus{ border-color:var(--md);
    box-shadow:0 0 0 .15rem rgba(45,92,62,.15); }
.modal-bill .modal-footer{ border-top:1px solid var(--bd); padding:12px 20px; }
.modal-bill .btn-save{ background:var(--dk); border:none; color:#fff; font-weight:700; font-size:12px;
    text-transform:uppercase; letter-spacing:.06em; padding:8px 18px; }
.modal-bill .btn-save:hover{ background:var(--md); }

@media print{ .btn-add-bill, .modal-bill{ display:none !important; } }


/* ---edit */
.bill-tbl th.c, .bill-tbl td.c{ text-align:center; }
.bill-edit{
    background:transparent; border:1px solid var(--bd); color:var(--md);
    width:28px; height:26px; border-radius:3px; cursor:pointer; font-size:11px;
    display:inline-flex; align-items:center; justify-content:center; transition:.15s;
}.bill-edit:hover{ background:var(--dk); color:#fff; border-color:var(--dk); }
@media print{ .bill-edit, .bill-tbl th.c, .bill-tbl td.c{ display:none !important; } }

/* ===== Pricing tabs (preview) ===== */
.price-tabs{ display:flex; border:1px solid var(--bd); border-bottom:none; margin-top:2px; }
.price-tab{
    flex:1; text-align:center; padding:9px 14px; cursor:pointer; user-select:none;
    font-size:11px; font-weight:700; letter-spacing:.1em; text-transform:uppercase;
    color:var(--sub); background:var(--alt); border-right:1px solid var(--bd);
    transition:background .15s,color .15s;
}
.price-tab:last-child{ border-right:none; }
.price-tab.active{ background:var(--dk); color:#fff; }
.price-panel{ display:none; }
.price-panel.active{ display:block; }

/* frequency display */
.freq-show{
    display:flex; align-items:center; gap:10px; margin:0 0 16px;
    padding:9px 14px; background:var(--alt); border:1px solid var(--bd); border-radius:2px; font-size:12px;
}
.freq-show .flabel{ margin:0; }
.freq-badge{
    background:var(--dk); color:#fff; font-size:11px; font-weight:700;
    letter-spacing:.06em; text-transform:uppercase; padding:3px 12px; border-radius:12px;
}
@media print{
    .price-tab{ display:none; }
    .price-panel{ display:block !important; }
}
    </style>
</head>

<body>

    @if(session('success'))
            <div style="background-color:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

<a href="{{ route('quotes.all') }}" class="back-btn" title="Back to all quotes"  style="font-size:20px; color:#1b3a2a;">
    <i class="fa-solid fa-arrow-left"></i> Back to All quotes
</a> 
<div class="hdr-right">
    
    <div style="display:flex; justify-content:flex-end; align-items:center; gap:10px;">



        <a href="{{ route('quote.download', $quote->id) }}" title="Download PDF"
           style="font-size:20px; color:#1b3a2a;">
            <i class="fa-solid fa-download"></i>
        </a>

    </div>  <h1>Service Quotation</h1>
    <div class="co">Harry's Lawncare Ltd.</div>
    <div class="ins">Fully Insured — $2,000,000 Commercial Liability</div>
</div>

<div class="page">



    <!-- HEADER -->
    <div class="hdr">
        <div class="logo">
            <!-- <div class="logo-name">HARRY'S <span class="leaf">🌿</span></div>
            <div class="logo-divider">
                <hr /><span>LAWN</span><hr /><span>CARE</span><hr />
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
                    <input type="text" value="{{$quote->id}}" readonly style="width:100%">
                    <span class="flabel">Date:</span>
                    <input type="date" value="{{$quote->date}}" readonly style="width:100%">
                    <span class="flabel">Valid Until:</span>
                    <input type="date" value="{{$quote->valid_until}}" readonly style="width:100%">
                    <span class="flabel">Prepared By:</span>
                    <input type="text" value="{{$quote->prepared_by}}" readonly style="width:100%">
                </div>
            </div>

            <div> <div class="stitle">Client Information</div>
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
        </table>

        <div class="cond-row">
            <span class="flabel">Condition:</span>
            <input type="text" value="{{$quote->condition}}" readonly style="width:100%">
            <span class="flabel">Notes/Hazards:</span>
            <input type="text" value="{{$quote->hazards}}" readonly style="width:100%">
        </div>

        <!-- SERVICE TYPE -->
        <div class="stitle">Service Type</div>
        <div class="svc-row">
            <div class="svc-box {{ strtoupper(trim($quote->service_type ?? '')) === 'SEASONAL PROGRAM' ? 'on' : '' }}">
                <div class="svc-top"><span class="svc-ck"></span></div>
                <div class="svc-title">Seasonal Program</div>
                <div class="svc-sub">Bi-Weekly Mowing, Edging, Blowing • Full Season (Apr–Oct)</div>
            </div>
            <div class="svc-box {{ strtoupper(trim($quote->service_type ?? '')) === 'ONE-TIME SERVICE' ? 'on' : '' }}">
                <div class="svc-top"><span class="svc-ck"></span></div>
                <div class="svc-title">One-Time Service</div>
                <div class="svc-sub">Single Job • No Long-Term Commitment</div>
            </div>
        </div>  @if($quote->seasonal_frequency)
        <div class="freq-show">
            <span class="flabel">Service Frequency:</span>
            <span class="freq-badge">{{ $quote->seasonal_frequency }}</span>
        </div>
        @endif

        <!-- PRICING BREAKDOWN -->
        <div class="stitle">Pricing Breakdown</div>

        @php
            // One-time bucket = ONLY rows explicitly typed 'onetime'.
            // Seasonal bucket = EVERYTHING ELSE (seasonal + null/blank/unknown type),
            // so items saved without a clean type are never dropped — they show under
            // seasonal (the default) instead of disappearing.
            $onetimeItems  = $quote->items->filter(fn($i) => strtolower(trim((string)($i->type ?? ''))) === 'onetime');
            $seasonalItems = $quote->items->filter(fn($i) => strtolower(trim((string)($i->type ?? ''))) !== 'onetime');
            $isOneTime     = strtoupper(trim($quote->service_type ?? '')) === 'ONE-TIME SERVICE';

            // ---- Totals computed LIVE from items (same formula as the edit page's calc()):
            //   subtotal = sum of item amounts; afterDiscount = subtotal - discount;
            //   GST = 5% of afterDiscount; total = afterDiscount + GST.
            // Discount is user-entered, so it's read from the quote column (fallback 0).
            // Computed here so the numbers always show even if the quote's summary
            // columns were never saved.
            $seasonalSub  = $seasonalItems->sum(fn($i) => (float)($i->amount ?? 0));
            $seasonalDisc = (float)($quote->seasonal_discount ?? 0);
            $seasonalGst  = max($seasonalSub - $seasonalDisc, 0) * 0.05;
            $seasonalTot  = max($seasonalSub - $seasonalDisc, 0) + $seasonalGst;

            $onetimeSub  = $onetimeItems->sum(fn($i) => (float)($i->amount ?? 0));
            $onetimeDisc = (float)($quote->onetime_discount ?? 0);
            $onetimeGst  = max($onetimeSub - $onetimeDisc, 0) * 0.05;
            $onetimeTot  = max($onetimeSub - $onetimeDisc, 0) + $onetimeGst;
        @endphp

        <div class="price-tabs">
            <div class="price-tab {{ $isOneTime ? '' : 'active' }}" data-tab="seasonal" onclick="showTab('seasonal')">Seasonal Program</div>
            <div class="price-tab {{ $isOneTime ? 'active' : '' }}" data-tab="onetime" onclick="showTab('onetime')">One-Time Service</div>
        </div>

        <!-- SEASONAL PANEL -->
        <div class="price-panel {{ $isOneTime ? '' : 'active' }}" id="panel-seasonal">
            <table class="price-tbl">
                <thead>
                <tr>
                    <th style="width:60%">Service Description</th>
                    <th style="width:10%;text-align:right">Qty</th>
                    <th style="width:15%;text-align:right">Rate / Price</th>
                    <th style="width:15%;text-align:right">Amount</th>
                </tr>
                </thead>
                <tbody>
                @forelse($seasonalItems as $item)
                    <tr>
                        <td><input type="text" value="{{$item->description}}" readonly></td>
                        <td><input type="text" value="{{$item->qty}}" readonly style="text-align:right"></td>
                        <td><input type="text" value="{{$item->rate}}" readonly style="text-align:right"></td>
                        <td><input type="text" value="{{$item->amount}}" readonly style="text-align:right"></td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--sub);font-style:italic">No seasonal items.</td></tr>
                @endforelse

                <tr class="sum-row">
                    <td colspan="3" style="text-align:right;font-weight:700">Subtotal</td>
                    <td><input type="text" value="{{ number_format($seasonalSub, 2) }}" readonly style="text-align:right"></td>
                </tr>
                <tr class="sum-row">
                    <td colspan="3" style="text-align:right;font-weight:700">Discount</td>
                    <td><input type="text" value="{{ number_format($seasonalDisc, 2) }}" readonly style="text-align:right"></td>
                </tr>
                <tr class="sum-row">
                    <td colspan="3" style="text-align:right;font-weight:700">GST (5%)</td>
                    <td><input type="text" value="{{ number_format($seasonalGst, 2) }}" readonly style="text-align:right"></td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" style="text-align:right">TOTAL</td>
                    <td><input type="text" value="{{ number_format($seasonalTot, 2) }}" readonly></td>
                </tr>
                </tbody>
            </table>
        </div>  <!-- ONE-TIME PANEL -->
        <div class="price-panel {{ $isOneTime ? 'active' : '' }}" id="panel-onetime">
            <table class="price-tbl">
                <thead>
                <tr>
                    <th style="width:60%">Service Description</th>
                    <th style="width:10%;text-align:right">Qty</th>
                    <th style="width:15%;text-align:right">Rate / Price</th>
                    <th style="width:15%;text-align:right">Amount</th>
                </tr>
                </thead>
                <tbody>
                @forelse($onetimeItems as $item)
                    <tr>
                        <td><input type="text" value="{{$item->description}}" readonly></td>
                        <td><input type="text" value="{{$item->qty}}" readonly style="text-align:right"></td>
                        <td><input type="text" value="{{$item->rate}}" readonly style="text-align:right"></td>
                        <td><input type="text" value="{{$item->amount}}" readonly style="text-align:right"></td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--sub);font-style:italic">No one-time items.</td></tr>
                @endforelse

                <tr class="sum-row">
                    <td colspan="3" style="text-align:right;font-weight:700">Subtotal</td>
                    <td><input type="text" value="{{ number_format($onetimeSub, 2) }}" readonly style="text-align:right"></td>
                </tr>
                <tr class="sum-row">
                    <td colspan="3" style="text-align:right;font-weight:700">Discount</td>
                    <td><input type="text" value="{{ number_format($onetimeDisc, 2) }}" readonly style="text-align:right"></td>
                </tr>
                <tr class="sum-row">
                    <td colspan="3" style="text-align:right;font-weight:700">GST (5%)</td>
                    <td><input type="text" value="{{ number_format($onetimeGst, 2) }}" readonly style="text-align:right"></td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" style="text-align:right">TOTAL</td>
                    <td><input type="text" value="{{ number_format($onetimeTot, 2) }}" readonly></td>
                </tr>
                </tbody>
            </table>
        </div> <!-- NOTES -->
        <div class="stitle" style="margin-top:16px">Notes</div>
        <div class="notes-box">
{{--            <textarea readonly>{{$quote->notes}}</textarea>--}}
            <div class="notes-text" style="background: #F2F7F4;">
                {!! nl2br(e($quote->notes)) !!}
            </div>
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
                @endif

                <div style="margin-top:8px">
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
                    <input type="date" value="{{$quote->signature_date}}" readonly style="width:100%">
                    <span class="flabel">Rep:</span>
                    <input type="text" value="{{$quote->representative}}" readonly style="width:100%">
                     <span class="flabel">Payment Method:</span>
                    <input type="text" value="{{$quote->payment_method}}" readonly style="width:100%">
                </div>
            </div> </div>

    </div>

    <div class="page-footer">
        Harry's Lawncare Ltd. &nbsp;|&nbsp; Serving the Lower Mainland, BC &nbsp;|&nbsp; Fully Insured
    </div>

</div>

<!-- ===========================================================================================client billing info -->




<!-- ----adding model-- -->


<script>
    // Pricing breakdown tab switch (Seasonal <-> One-Time).
    function showTab(tab){
        document.querySelectorAll('.price-tab').forEach(function(t){
            t.classList.toggle('active', t.dataset.tab === tab);
        });
        document.querySelectorAll('.price-panel').forEach(function(p){
            p.classList.remove('active');
        });
        var panel = document.getElementById('panel-' + tab);
        if(panel){ panel.classList.add('active'); }
    }
</script>

</body>

</html>

</x-layout>