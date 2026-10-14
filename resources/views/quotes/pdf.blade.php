<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Quote #{{$quote->id}} - Harry's Lawn Care</title>
    <style>
        @page { margin: 0; }   /* reclaim printer default margins; body controls padding */

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;              /* was 12 */
            color: #1a2e22;
            background: #ffffff;
            padding: 0;
            margin: 0;
        }

        /* HEADER */
        .hdr { padding: 14px 28px 10px 28px; background: #ffffff; }   /* was 22 32 16 32 */
        .hdr-outer { width: 100%; border-collapse: collapse; }
        .hdr-outer td { border: none; padding: 0; vertical-align: top; }

        .logo-name {
            font-size: 21px;               /* was 25 */
            font-weight: 700; color: #1b3a2a;
            letter-spacing: 2px; text-transform: uppercase; line-height: 1;
        }

        .logo-divider-table { border-collapse: collapse; margin-top: 4px; }
        .logo-divider-table td { border: none; padding: 0; vertical-align: middle; }
        .div-line { width: 20px; height: 0; border-top: 1.5px solid #1b3a2a; display: block; }
        .div-text { font-size: 8px; font-weight: 700; letter-spacing: 3px; color: #1b3a2a; text-transform: uppercase; padding: 0 4px; }

        .hdr-right-title {
            font-size: 17px;               /* was 20 */
            font-weight: 700; color: #1b3a2a;
            letter-spacing: 4px; text-transform: uppercase; text-align: right; line-height: 1;
        }
        .hdr-right-co { font-size: 11px; font-weight: 700; color: #1a2e22; text-align: right; margin-top: 4px; }
        .hdr-right-ins { font-size: 9px; font-style: italic; color: #4a6b56; text-align: right; margin-top: 2px; }

        /* TOP RULE */
        .top-rule { height: 3px; background: #1b3a2a; margin: 0 28px; }

        /* BODY */
        .body { padding: 12px 28px 14px 28px; }   /* was 18 32 24 32 */

        .stitle {
            font-size: 9px; font-weight: 700; letter-spacing: 3px;
            text-transform: uppercase; color: #1a2e22;
            border-bottom: 2px solid #1b3a2a;
            padding-bottom: 2px; margin-bottom: 6px;   /* was 3 / 10 */
        }

        /* TWO COLUMN */
        .two-col { width: 100%; border-collapse: collapse; margin-bottom: 10px; }  /* was 16 */
        .two-col > tbody > tr > td { width: 50%; vertical-align: top; border: none; padding: 0; }
        .two-col > tbody > tr > td:first-child { padding-right: 16px; }

        /* DATA TABLE */
        .dt { width: 100%; border-collapse: collapse; }
        .dt td { border: none; padding: 2px 0; font-size: 10.5px; vertical-align: bottom; }  /* was 3px / 11 */
        .dt .lbl { font-weight: 700; white-space: nowrap; color: #1a2e22; padding-right: 5px; }
        .dt .val { border-bottom: 1px solid #c2d4c9; color: #1a2e22; padding: 1px 4px; }

        /* PROPERTY TABLE */
        .prop-tbl { width: 100%; border-collapse: collapse; margin-bottom: 8px; }  /* was 10 */
        .prop-tbl th {
            background: #1b3a2a; color: #ffffff; font-size: 8.5px;
            letter-spacing: 2px; text-transform: uppercase; font-weight: 700;
            padding: 4px 10px; text-align: center; border: 1px solid #1b3a2a;   /* was 6px */
        }
        .prop-tbl td { border: 1px solid #c2d4c9; padding: 4px 10px; font-size: 10.5px; color: #1a2e22; text-align: center; }

        /* CONDITION ROW */
        .cond-tbl { width: 100%; border-collapse: collapse; margin-bottom: 10px; }  /* was 14 */
        .cond-tbl td { border: none; padding: 2px 4px; font-size: 10.5px; vertical-align: bottom; }
        .cond-tbl .lbl { font-weight: 700; white-space: nowrap; padding-right: 5px; }
        .cond-tbl .val { border-bottom: 1px solid #c2d4c9; padding: 1px 4px; }

        /* SERVICE TYPE */
        .svc-tbl { width: 100%; border-collapse: collapse; border: 1px solid #c2d4c9; margin-bottom: 10px; }  /* was 14 */
        .svc-tbl td { width: 50%; padding: 8px 10px; text-align: center; vertical-align: middle; border: none; }  /* was 12px */
        .svc-tbl td:first-child { border-right: 1px solid #c2d4c9; }
        .svc-on  { background: #e8f0eb; }
        .svc-off { background: #ffffff; }

        .ck-box {
            display: inline-block; width: 12px; height: 12px;
            border: 1.5px solid #8aab97; background: #ffffff;
            text-align: center; font-size: 8px; font-weight: 900;
            color: #1b3a2a; line-height: 11px; margin-bottom: 3px;
        }

        .svc-ttl { font-size: 11px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; color: #1a2e22; }
        .svc-sub { font-size: 8.5px; color: #4a6b56; margin-top: 2px; }

        /* PRICING TABLE */
        .price-tbl { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        .price-tbl th {
            background: #1b3a2a; color: #ffffff; font-size: 8.5px;
            letter-spacing: 2px; text-transform: uppercase; font-weight: 700;
            padding: 5px 10px; border: 1px solid #1b3a2a;   /* was 7px */
        }
        .price-tbl th.left  { text-align: left; }
        .price-tbl th.right { text-align: right; }
        .price-tbl td { border: 1px solid #c2d4c9; padding: 3.5px 10px; font-size: 10.5px; color: #1a2e22; }  /* was 5px / 11 */
        .price-tbl td.right { text-align: right; }

        .price-tbl .sum-row td { background: #f2f7f4; padding: 3.5px 10px; border: 1px solid #c2d4c9; }
        .price-tbl .sum-row .lbl { text-align: right; font-weight: 700; color: #4a6b56; font-size: 10.5px; }
        .price-tbl .sum-row .val { text-align: right; font-size: 10.5px; }

        .price-tbl .total-row td { background: #1b3a2a; color: #ffffff; font-weight: 700; font-size: 11px; border: 1px solid #1b3a2a; padding: 5px 10px; }
        .price-tbl .total-row .lbl { text-align: right; }
        .price-tbl .total-row .val { text-align: right; }

        /* GROUP HEADER + GROUP SUBTOTAL (dompdf-safe: td background + plain text) */
        .price-tbl .grp-row td {
            background: #1b3a2a; color: #ffffff;
            font-size: 8.5px; font-weight: 700; letter-spacing: 2px;
            text-transform: uppercase; padding: 4px 10px; border: 1px solid #1b3a2a;
        }
        .price-tbl .grp-row .grp-freq {
            font-size: 8px; font-weight: 400; letter-spacing: 1px;
            text-transform: none; color: #cfe0d5;
        }
        .price-tbl .grp-sub-row td {
            background: #eef4f0; font-size: 10.5px; font-weight: 700;
            color: #1a2e22; border: 1px solid #c2d4c9; padding: 3.5px 10px;
        }
        .price-tbl .grp-sub-row .lbl { text-align: right; }
        .price-tbl .grp-sub-row .val { text-align: right; }

        /* NOTES */
        .notes-box { background: #f2f7f4; border: 1px solid #c2d4c9; padding: 6px 10px; font-size: 10.5px; color: #4a6b56; min-height: 26px; }  /* was 8px / 36 */

        /* SIGNATURE */
        .accept-text { font-size: 10.5px; color: #1a2e22; margin-bottom: 8px; }  /* was 11 / 10 */
        .sig-tbl { width: 100%; border-collapse: collapse; }
        .sig-tbl > tbody > tr > td { width: 50%; vertical-align: top; border: none; padding: 0; }
        .sig-tbl > tbody > tr > td:first-child { padding-right: 16px; }
        .sig-lbl { font-size: 8.5px; letter-spacing: 2px; text-transform: uppercase; color: #4a6b56; font-weight: 600; margin-bottom: 2px; }
        .sig-line { border-bottom: 1.5px solid #1b3a2a; height: 30px; width: 100%; display: block; }  /* was 38 */
        .sig-val  { border-bottom: 1px solid #c2d4c9; padding: 1px 4px; font-size: 10.5px; color: #1a2e22; }

        /* FOOTER */
        .page-footer { background: #1b3a2a; color: rgba(255,255,255,0.75); text-align: center; font-size: 9px; letter-spacing: 1px; padding: 7px 16px; }  /* was 10 / 9 */

        .mt8  { margin-top: 6px; }    /* was 8 */
        .mt14 { margin-top: 10px; }   /* was 14 */
        .mt16 { margin-top: 10px; }   /* was 16 */
    </style>
</head>
<body>
<!-- HEADER -->
<div class="hdr">
    <table class="hdr-outer">
        <tr>
            <td>
              <img src="{{ public_path('images/harrys_logo_2.png') }}" style="width:150px;">
            </td>
            <td style="text-align:right; vertical-align:top;">
                <div class="hdr-right-title"><i>SERVICE QUOTATION</i></div>
                <div class="hdr-right-co">Harry's Lawncare Ltd.</div>
                <div class="hdr-right-ins">Fully Insured &mdash; $2,000,000 Commercial Liability</div>
            </td>
        </tr>
    </table>
</div>

<div class="top-rule"></div>

<!-- BODY -->
<div class="body">

    {{-- Quote Details + Client Info --}}
    <table class="two-col">
        <tr>
            <td>
                <div class="stitle">Quote Details</div>
                <table class="dt">
                    <tr>
                        <td class="lbl">Quote #:</td>
                        <td class="val">{{$quote->id}}</td>
                        <td class="lbl" style="padding-left:8px;">Date:</td>
                        <td class="val">{{$quote->date}}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Valid Until:</td>
                        <td class="val">{{$quote->valid_until}}</td>
                        <td class="lbl" style="padding-left:8px;">Prepared By:</td>
                        <td class="val">{{$quote->prepared_by}}</td>
                    </tr>
                </table>
            </td>
            <td>
                <div class="stitle">Client Information</div>
                <table class="dt">
                    <tr>
                        <td class="lbl">Name:</td>
                        <td class="val" colspan="3">{{$quote->client_name}}</td>
                    </tr>
                    <tr> <td class="lbl">Address:</td>
                        <td class="val" colspan="3">{{$quote->client_address}}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Phone:</td>
                        <td class="val">{{$quote->client_phone}}</td>
                        <td class="lbl" style="padding-left:8px;">Email:</td>
                        <td class="val">{{$quote->client_email}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Property Details --}}
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
            <td>{{$quote->lawn_size}}</td>
            <td>{{$quote->service_area}}</td>
            <td>{{$quote->terrain}}</td>
            <td>{{$quote->access}}</td>
        </tr>
        </tbody>
    </table>

    <table class="cond-tbl">
        <tr>
            <td class="lbl">Condition:</td>
            <td class="val" style="width:35%">{{$quote->condition}}</td>
            <td class="lbl" style="padding-left:14px;">Notes/Hazards:</td>
            <td class="val">{{$quote->hazards}}</td>
        </tr>
    </table> {{-- Service Type --}}
    <div class="stitle">Service Type</div>
    @php
        $svcType    = strtoupper(trim($quote->service_type));
        $isSeasonal = $svcType === 'SEASONAL PROGRAM';
        $isOneTime  = $svcType === 'ONE-TIME SERVICE';
    @endphp
    <table class="svc-tbl">
        <tr>
            <td class="{{ $isSeasonal ? 'svc-on' : 'svc-off' }}">
                <div><span class="ck-box">{{ $isSeasonal ? 'X' : '' }}</span></div>
                <div class="svc-ttl">Seasonal Program</div>
                <div class="svc-sub">Bi-Weekly Mowing, Edging, Blowing &bull; Full Season (Apr&ndash;Oct)</div>
            </td>
            <td class="{{ $isOneTime ? 'svc-on' : 'svc-off' }}">
                <div><span class="ck-box">{{ $isOneTime ? 'X' : '' }}</span></div>
                <div class="svc-ttl">One-Time Service</div>
                <div class="svc-sub">Single Job &bull; No Long-Term Commitment</div>
            </td>
        </tr>
    </table>

    {{--
        GROUP LINE ITEMS BY TYPE (seasonal vs onetime)
        - normalize $item->type: lowercase, strip spaces/-/_
        - per-section subtotal = sum of $item->amount in that group
        - quote-level subtotal/discount/gst/total PRESERVED as-is
    --}}
    @php
        $seasonalItems = collect();
        $onetimeItems  = collect();
        $otherItems    = collect();

        foreach ($quote->items as $qi) {
            $t = strtolower(trim((string) $qi->type));
            $t = str_replace([' ', '-', '_'], '', $t);

            if ($t === 'seasonal') {
                $seasonalItems->push($qi);
            } elseif ($t === 'onetime') {
                $onetimeItems->push($qi);
            } else {
                $otherItems->push($qi);
            }
        }

        $seasonalSub = $seasonalItems->sum(fn($i) => (float) $i->amount);
        $onetimeSub  = $onetimeItems->sum(fn($i) => (float) $i->amount);
        $otherSub    = $otherItems->sum(fn($i) => (float) $i->amount);

        $seasonalFreq = optional($seasonalItems->first())->frequency;
    @endphp

    {{-- Pricing Breakdown (grouped: Seasonal / One-Time) --}}
    <div class="stitle">Pricing Breakdown</div>
    <table class="price-tbl">
        <thead>
        <tr>
            <th class="left"  style="width:60%">Service Description</th>
            <th class="right" style="width:10%">Qty</th>
            <th class="right" style="width:15%">Rate / Price</th>
            <th class="right" style="width:15%">Amount</th>
        </tr>
        </thead>
        <tbody>

        {{-- SEASONAL GROUP --}}
        @if($seasonalItems->count())
            <tr class="grp-row">
                <td colspan="4">
                    Seasonal Program
                    @if($seasonalFreq)
                        <span class="grp-freq">&nbsp;&nbsp;{{ ucwords(str_replace(['-','_'],' ', $seasonalFreq)) }} &middot; recurring</span>
                    @else
                        <span class="grp-freq">&nbsp;&nbsp;recurring service</span>
                    @endif
                </td>
            </tr>

            @foreach($seasonalItems as $item)
                <tr>
                    <td>{{$item->description}}</td>
                    <td class="right">{{$item->qty}}</td>
                    <td class="right">{{$item->rate}}</td>
                    <td class="right">{{$item->amount}}</td>
                </tr>
            @endforeach

            <tr class="grp-sub-row">
                <td colspan="3" class="lbl">Seasonal Subtotal</td>
                <td class="val">{{ number_format($seasonalSub, 2) }}</td>
            </tr>
        @endif

        {{-- ONE-TIME GROUP --}}
        @if($onetimeItems->count())
            <tr class="grp-row">
                <td colspan="4">
                    One-Time Service
                    <span class="grp-freq">&nbsp;&nbsp;single job &middot; no commitment</span>
                </td>
            </tr>

            @foreach($onetimeItems as $item)
                <tr>
                    <td>{{$item->description}}</td>
                    <td class="right">{{$item->qty}}</td>
                    <td class="right">{{$item->rate}}</td>
                    <td class="right">{{$item->amount}}</td>
                </tr>
            @endforeach

            <tr class="grp-sub-row">
                <td colspan="3" class="lbl">One-Time Subtotal</td>
                <td class="val">{{ number_format($onetimeSub, 2) }}</td>
            </tr>
        @endif

        {{-- OTHER / UNCLASSIFIED --}}
        @if($otherItems->count())
            <tr class="grp-row">
                <td colspan="4">Additional Items</td>
            </tr>

            @foreach($otherItems as $item)
                <tr>
                    <td>{{$item->description}}</td>
                    <td class="right">{{$item->qty}}</td>
                    <td class="right">{{$item->rate}}</td>
                    <td class="right">{{$item->amount}}</td>
                </tr>
            @endforeach

            <tr class="grp-sub-row">
                <td colspan="3" class="lbl">Additional Subtotal</td>
                <td class="val">{{ number_format($otherSub, 2) }}</td>
            </tr>
        @endif

        {{-- QUOTE-LEVEL TOTALS (authoritative — unchanged) --}}
        <tr class="sum-row">
            <td colspan="3" class="lbl">Subtotal</td>
            <td class="val">{{$quote->subtotal}}</td>
        </tr>
        <tr class="sum-row">
            <td colspan="3" class="lbl">Discount</td>
            <td class="val">{{$quote->discount}}</td>
        </tr>
        <tr class="sum-row">
            <td colspan="3" class="lbl">GST (5%)</td>
            <td class="val">{{$quote->gst}}</td>
        </tr>
        <tr class="total-row">
            <td colspan="3" class="lbl">TOTAL</td>
            <td class="val">{{$quote->total}}</td>
        </tr>
        </tbody>
    </table> {{-- Notes --}}
    <div class="stitle mt16">Notes</div>
    <div class="notes-box">
        {!! nl2br(e($quote->notes)) !!}
    </div>

    {{-- Quote Acceptance --}}
    <div class="stitle mt14">Quote Acceptance</div>
    <div class="accept-text">
        By signing below, the Client accepts this quotation and agrees to the applicable Service Agreement:
    </div>

    <table class="sig-tbl">
        <tr>
            <td>
                <div class="sig-lbl">Client Signature</div>

                @if(Str::startsWith($quote->client_signature, 'data:image'))
                    <img src="{{ $quote->client_signature }}"
                         style="max-height:60px; border-bottom:1px solid #c2d4c9; padding-bottom:4px; display:block; margin-bottom:5px;" alt="Signature">
                @else
                    <span class="sig-line"></span>
                @endif

                <div class="mt8">
                    <div class="sig-lbl">Name (Print):</div>
                    <div class="sig-val">{{ $quote->client_name_print }}</div>
                </div>
            </td>
            <td>
                <table class="dt" style="margin-top:4px;">
                    <tr>
                        <td class="lbl">Date:</td>
                        <td class="val">{{$quote->signature_date}}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Rep:</td>
                        <td class="val">{{$quote->representative}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</div>

<!-- FOOTER -->
<div class="page-footer">
    Harry's Lawncare Ltd. &nbsp;|&nbsp; Serving the Lower Mainland, BC &nbsp;|&nbsp; Fully Insured
</div>

</body>
</html>