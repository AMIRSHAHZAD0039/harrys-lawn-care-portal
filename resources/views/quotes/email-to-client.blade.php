<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Harry's Lawn Care — Service Quotation</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style type="text/css">
        @page { margin: 0; }

html, body {
    margin: 0;
    padding: 0;
}
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
        body {
            margin: 0 !important;
            padding: 0 !important;
            background-color: #ffffff;
        }
        @media only screen and (max-width: 640px) {
            .email-container { width: 100% !important; }
        }

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

    </style></head>

<body style="margin:0;padding:0;background-color:#ffffff;font-family:Arial,sans-serif;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
       style="background-color:#ffffff;width:100%;">
    <tr>
        <td align="center" style="padding:0;">

            <table class="email-container" role="presentation" cellpadding="0" cellspacing="0" border="0"
                   style="width:100%;max-width:100%;background-color:#ffffff;border:1px solid #b8cfc3;">
   <!-- HEADER -->
                <tr>
                    <td style="padding:14px 24px 12px;background-color:#ffffff;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td valign="top" style="width:50%;">
                                    <img src="{{ public_path('images/harrys_logo_2.png') }}" style="width:150px;">
                                </td>
                                
                                <td valign="top" align="right" style="width:50%;">
                                    <div style="font-family:Georgia,'Times New Roman',serif;font-size:20px;font-weight:700;color:#1b3a2a;letter-spacing:0.05em;text-transform:uppercase;">Service Quotation</div>
                                    <div style="font-size:11px;font-weight:600;color:#1a2e22;margin-top:1px;font-family:Arial,sans-serif;">Harry's Lawncare Ltd.</div>
                                    <div style="font-size:9px;font-style:italic;color:#4a6b56;margin-top:1px;font-family:Arial,sans-serif;">Fully Insured &#8212; $2,000,000 Commercial Liability</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Top rule -->
                <tr>
                    <td style="padding:0 24px;">
                        <div style="height:3px;background-color:#1b3a2a;font-size:1px;line-height:1px;">&nbsp;</div>
                    </td>
                </tr>

                <!-- BODY -->  <tr>
                    <td style="padding:12px 24px 18px;">

                        <!-- QUOTE DETAILS + CLIENT INFO -->
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:10px;">
                            <tr>
                                <td valign="top" width="48%" style="padding-right:12px;">
                                    <div style="font-size:8px;font-weight:700;letter-spacing:0.16em;text-transform:uppercase;color:#1a2e22;border-bottom:2px solid #1b3a2a;padding-bottom:2px;margin-bottom:6px;font-family:Arial,sans-serif;">Quote Details</div>
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td style="font-size:10px;font-weight:700;color:#1a2e22;white-space:nowrap;padding:2px 5px 2px 0;font-family:Arial,sans-serif;">Quote&nbsp;#:</td>
                                            <td style="font-size:10px;color:#1a2e22;border-bottom:1px solid #c2d4c9;padding:2px 3px;font-family:Arial,sans-serif;width:100%;">{{$quote->id}}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:10px;font-weight:700;color:#1a2e22;white-space:nowrap;padding:2px 5px 2px 0;font-family:Arial,sans-serif;">Date:</td>
                                            <td style="font-size:10px;color:#1a2e22;border-bottom:1px solid #c2d4c9;padding:2px 3px;font-family:Arial,sans-serif;">{{$quote->date}}</td>
                                        </tr>
                                        <tr>   <td style="font-size:10px;font-weight:700;color:#1a2e22;white-space:nowrap;padding:2px 5px 2px 0;font-family:Arial,sans-serif;">Valid&nbsp;Until:</td>
                                            <td style="font-size:10px;color:#1a2e22;border-bottom:1px solid #c2d4c9;padding:2px 3px;font-family:Arial,sans-serif;">{{$quote->valid_until}}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:10px;font-weight:700;color:#1a2e22;white-space:nowrap;padding:2px 5px 2px 0;font-family:Arial,sans-serif;">Prepared&nbsp;By:</td>
                                            <td style="font-size:10px;color:#1a2e22;border-bottom:1px solid #c2d4c9;padding:2px 3px;font-family:Arial,sans-serif;">{{$quote->prepared_by}}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="4%">&nbsp;</td>
                                <td valign="top" width="48%">
                                    <div style="font-size:8px;font-weight:700;letter-spacing:0.16em;text-transform:uppercase;color:#1a2e22;border-bottom:2px solid #1b3a2a;padding-bottom:2px;margin-bottom:6px;font-family:Arial,sans-serif;">Client Information</div>
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td style="font-size:10px;font-weight:700;color:#1a2e22;white-space:nowrap;padding:2px 5px 2px 0;font-family:Arial,sans-serif;">Name:</td>
                                            <td style="font-size:10px;color:#1a2e22;border-bottom:1px solid #c2d4c9;padding:2px 3px;font-family:Arial,sans-serif;width:100%;">{{$quote->client_name}}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:10px;font-weight:700;color:#1a2e22;white-space:nowrap;padding:2px 5px 2px 0;font-family:Arial,sans-serif;">Address:</td>
                                            <td style="font-size:10px;color:#1a2e22;border-bottom:1px solid #c2d4c9;padding:2px 3px;font-family:Arial,sans-serif;">{{$quote->client_address}}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:10px;font-weight:700;color:#1a2e22;white-space:nowrap;padding:2px 5px 2px 0;font-family:Arial,sans-serif;">Phone:</td>
                                            <td style="font-size:10px;color:#1a2e22;border-bottom:1px solid #c2d4c9;padding:2px 3px;font-family:Arial,sans-serif;">{{$quote->client_phone}}</td>
                                        </tr>   <tr>
                                            <td style="font-size:10px;font-weight:700;color:#1a2e22;white-space:nowrap;padding:2px 5px 2px 0;font-family:Arial,sans-serif;">Email:</td>
                                            <td style="font-size:10px;color:#1a2e22;border-bottom:1px solid #c2d4c9;padding:2px 3px;font-family:Arial,sans-serif;">{{$quote->client_email}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- PROPERTY DETAILS -->
                        <div style="font-size:8px;font-weight:700;letter-spacing:0.16em;text-transform:uppercase;color:#1a2e22;border-bottom:2px solid #1b3a2a;padding-bottom:2px;margin-bottom:6px;font-family:Arial,sans-serif;">Property Details</div>
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                               style="border-collapse:collapse;margin-bottom:7px;">
                            <thead>
                            <tr>
                                <th style="background-color:#1b3a2a;color:#ffffff;font-size:8px;letter-spacing:0.1em;text-transform:uppercase;font-weight:700;padding:5px 6px;text-align:center;border:1px solid #1b3a2a;font-family:Arial,sans-serif;">Lawn Size</th>
                                <th style="background-color:#1b3a2a;color:#ffffff;font-size:8px;letter-spacing:0.1em;text-transform:uppercase;font-weight:700;padding:5px 6px;text-align:center;border:1px solid #1b3a2a;font-family:Arial,sans-serif;">Service Area</th>
                                <th style="background-color:#1b3a2a;color:#ffffff;font-size:8px;letter-spacing:0.1em;text-transform:uppercase;font-weight:700;padding:5px 6px;text-align:center;border:1px solid #1b3a2a;font-family:Arial,sans-serif;">Terrain</th>
                                <th style="background-color:#1b3a2a;color:#ffffff;font-size:8px;letter-spacing:0.1em;text-transform:uppercase;font-weight:700;padding:5px 6px;text-align:center;border:1px solid #1b3a2a;font-family:Arial,sans-serif;">Access</th>
                            </tr>
                            </thead>
                            <tbody> <tr>
                                <td style="border:1px solid #c2d4c9;padding:5px 6px;font-size:10px;color:#1a2e22;text-align:center;font-family:Arial,sans-serif;">{{$quote->lawn_size}}</td>
                                <td style="border:1px solid #c2d4c9;padding:5px 6px;font-size:10px;color:#1a2e22;text-align:center;font-family:Arial,sans-serif;">{{$quote->service_area}}</td>
                                <td style="border:1px solid #c2d4c9;padding:5px 6px;font-size:10px;color:#1a2e22;text-align:center;font-family:Arial,sans-serif;">{{$quote->terrain}}</td>
                                <td style="border:1px solid #c2d4c9;padding:5px 6px;font-size:10px;color:#1a2e22;text-align:center;font-family:Arial,sans-serif;">{{$quote->access}}</td>
                            </tr>
                            </tbody>
                        </table>

                        <!-- Condition + Hazards -->
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:10px;">
                            <tr>
                                <td style="font-size:10px;font-weight:700;color:#1a2e22;white-space:nowrap;padding-right:5px;font-family:Arial,sans-serif;">Condition:</td>
                                <td style="font-size:10px;color:#1a2e22;border-bottom:1px solid #c2d4c9;padding:2px 4px;font-family:Arial,sans-serif;">{{$quote->condition}}</td>
                                <td style="font-size:10px;font-weight:700;color:#1a2e22;white-space:nowrap;padding:0 5px;font-family:Arial,sans-serif;">Notes/Hazards:</td>
                                <td style="font-size:10px;color:#1a2e22;border-bottom:1px solid #c2d4c9;padding:2px 4px;font-family:Arial,sans-serif;">{{$quote->hazards}}</td>
                            </tr>
                        </table>
  <!-- SERVICE TYPE -->
                        <div style="font-size:8px;font-weight:700;letter-spacing:0.16em;text-transform:uppercase;color:#1a2e22;border-bottom:2px solid #1b3a2a;padding-bottom:2px;margin-bottom:6px;font-family:Arial,sans-serif;">Service Type</div>

                        @php
                            $svcType = strtoupper(trim($quote->service_type));
                        @endphp

                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                               style="border-collapse:collapse;margin-bottom:10px;">
                            <tr>
                                @if($svcType === 'SEASONAL PROGRAM')
                                    <!-- Seasonal Program Only -->
                                    <td width="100%" align="center" valign="middle"
                                        style="padding:8px 10px;border:1px solid #c2d4c9;background-color:#e8f0eb;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center">
                                            <tr>
                                                <td align="center" style="padding-bottom:4px;">
                                                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center">
                                                        <tr>
                                                            <td style="width:13px;height:13px;border:1.5px solid #8aab97;background-color:#ffffff;text-align:center;vertical-align:middle;font-size:10px;font-weight:900;color:#1b3a2a;font-family:Arial,sans-serif;line-height:13px;mso-line-height-rule:exactly;">
                                                                X
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="font-size:11px;font-weight:800;letter-spacing:0.06em;text-transform:uppercase;color:#1a2e22;font-family:Arial,sans-serif;">Seasonal Program</td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="font-size:8px;color:#4a6b56;font-family:Arial,sans-serif;padding-top:2px;">Bi-Weekly Mowing, Edging, Blowing &#8226; Full Season (Apr&#8211;Oct)</td>
                                            </tr>
                                        </table>
                                    </td>  @elseif($svcType === 'ONE-TIME SERVICE')
                                    <!-- One-Time Service Only -->
                                    <td width="100%" align="center" valign="middle"
                                        style="padding:8px 10px;border:1px solid #c2d4c9;background-color:#e8f0eb;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center">
                                            <tr>
                                                <td align="center" style="padding-bottom:4px;">
                                                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center">
                                                        <tr>
                                                            <td style="width:13px;height:13px;border:1.5px solid #8aab97;background-color:#ffffff;text-align:center;vertical-align:middle;font-size:10px;font-weight:900;color:#1b3a2a;font-family:Arial,sans-serif;line-height:13px;mso-line-height-rule:exactly;">
                                                                X
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="font-size:11px;font-weight:800;letter-spacing:0.06em;text-transform:uppercase;color:#1a2e22;font-family:Arial,sans-serif;">One-Time Service</td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="font-size:8px;color:#4a6b56;font-family:Arial,sans-serif;padding-top:2px;">Single Job &#8226; No Long-Term Commitment</td>
                                            </tr>
                                        </table>
                                    </td>    @endif
                            </tr>
                        </table>

                        <!-- PRICING BREAKDOWN -->
                        <div style="font-size:8px;font-weight:700;letter-spacing:0.16em;text-transform:uppercase;color:#1a2e22;border-bottom:2px solid #1b3a2a;padding-bottom:2px;margin-bottom:6px;font-family:Arial,sans-serif;">Pricing Breakdown</div>

       
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

                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                               style="border-collapse:collapse;margin-bottom:0;">
                            <thead>
                            <tr>
                                <th width="60%" style="background-color:#1b3a2a;color:#ffffff;font-size:8px;letter-spacing:0.1em;text-transform:uppercase;font-weight:700;padding:5px 7px;text-align:left;border:1px solid #1b3a2a;font-family:Arial,sans-serif;">Service Description</th>
                                <th width="10%" style="background-color:#1b3a2a;color:#ffffff;font-size:8px;letter-spacing:0.1em;text-transform:uppercase;font-weight:700;padding:5px 7px;text-align:right;border:1px solid #1b3a2a;font-family:Arial,sans-serif;">Qty</th>
                                <th width="15%" style="background-color:#1b3a2a;color:#ffffff;font-size:8px;letter-spacing:0.1em;text-transform:uppercase;font-weight:700;padding:5px 7px;text-align:right;border:1px solid #1b3a2a;font-family:Arial,sans-serif;">Rate / Price</th>
                                <th width="15%" style="background-color:#1b3a2a;color:#ffffff;font-size:8px;letter-spacing:0.1em;text-transform:uppercase;font-weight:700;padding:5px 7px;text-align:right;border:1px solid #1b3a2a;font-family:Arial,sans-serif;">Amount</th>
                            </tr>
                            </thead>
                            <tbody>

                            {{-- ===== SEASONAL GROUP ===== --}}
                            @if($seasonalItems->count())
                                <tr>
                                    <td colspan="4" style="background-color:#1b3a2a;color:#ffffff;font-size:8px;letter-spacing:0.1em;text-transform:uppercase;font-weight:700;padding:4px 7px;border:1px solid #1b3a2a;font-family:Arial,sans-serif;">
                                        Seasonal Program
                                        @if($seasonalFreq)
                                            <span style="font-size:8px;font-weight:400;text-transform:none;color:#cfe0d5;">&nbsp;&nbsp;{{ ucwords(str_replace(['-','_'],' ', $seasonalFreq)) }} &middot; recurring</span>
                                        @else
                                            <span style="font-size:8px;font-weight:400;text-transform:none;color:#cfe0d5;">&nbsp;&nbsp;recurring service</span>
                                        @endif
                                    </td>
                                </tr>

                                @foreach($seasonalItems as $sIndex => $item)
                                    <tr style="{{ $sIndex % 2 == 1 ? 'background-color:#f2f7f4;' : 'background-color:#ffffff;' }}">
                                        <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;font-family:Arial,sans-serif;">{{$item->description}}</td>
                                        <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{$item->qty}}</td>
                                        <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{$item->rate}}</td>
                                        <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{$item->amount}}</td>
                                    </tr>
                                @endforeach

                                <tr style="background-color:#eef4f0;">
                                    <td colspan="3" style="border:1px solid #c2d4c9;padding:4px 8px;text-align:right;font-weight:700;font-size:10px;color:#1a2e22;font-family:Arial,sans-serif;">Seasonal Subtotal</td>
                                    <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;font-weight:700;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{ number_format($seasonalSub, 2) }}</td>
                                </tr>
                            @endif

                            {{-- ===== ONE-TIME GROUP ===== --}}
                            @if($onetimeItems->count())
                                <tr>
                                    <td colspan="4" style="background-color:#1b3a2a;color:#ffffff;font-size:8px;letter-spacing:0.1em;text-transform:uppercase;font-weight:700;padding:4px 7px;border:1px solid #1b3a2a;font-family:Arial,sans-serif;">
                                        One-Time Service
                                        <span style="font-size:8px;font-weight:400;text-transform:none;color:#cfe0d5;">&nbsp;&nbsp;single job &middot; no commitment</span>
                                    </td>
                                </tr>

                                @foreach($onetimeItems as $oIndex => $item)
                                    <tr style="{{ $oIndex % 2 == 1 ? 'background-color:#f2f7f4;' : 'background-color:#ffffff;' }}">
                                        <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;font-family:Arial,sans-serif;">{{$item->description}}</td>
                                        <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{$item->qty}}</td>
                                        <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{$item->rate}}</td>
                                        <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{$item->amount}}</td>
                                    </tr>
                                @endforeach

                                <tr style="background-color:#eef4f0;">
                                    <td colspan="3" style="border:1px solid #c2d4c9;padding:4px 8px;text-align:right;font-weight:700;font-size:10px;color:#1a2e22;font-family:Arial,sans-serif;">One-Time Subtotal</td>
                                    <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;font-weight:700;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{ number_format($onetimeSub, 2) }}</td>
                                </tr>
                            @endif

                            {{-- ===== OTHER / UNCLASSIFIED ===== --}}
                            @if($otherItems->count())
                                <tr>
                                    <td colspan="4" style="background-color:#1b3a2a;color:#ffffff;font-size:8px;letter-spacing:0.1em;text-transform:uppercase;font-weight:700;padding:4px 7px;border:1px solid #1b3a2a;font-family:Arial,sans-serif;">
                                        Additional Items
                                    </td>
                                </tr>

                                @foreach($otherItems as $xIndex => $item)
                                    <tr style="{{ $xIndex % 2 == 1 ? 'background-color:#f2f7f4;' : 'background-color:#ffffff;' }}">
                                        <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;font-family:Arial,sans-serif;">{{$item->description}}</td>
                                        <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{$item->qty}}</td>
                                        <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{$item->rate}}</td>
                                        <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{$item->amount}}</td>
                                    </tr>
                                @endforeach

                                <tr style="background-color:#eef4f0;">
                                    <td colspan="3" style="border:1px solid #c2d4c9;padding:4px 8px;text-align:right;font-weight:700;font-size:10px;color:#1a2e22;font-family:Arial,sans-serif;">Additional Subtotal</td>
                                    <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;font-weight:700;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{ number_format($otherSub, 2) }}</td>
                                </tr>
                            @endif

                            {{-- ===== QUOTE-LEVEL TOTALS (authoritative — unchanged) ===== --}}
                            <tr style="background-color:#f2f7f4;">
                                <td colspan="3" style="border:1px solid #c2d4c9;padding:4px 8px;text-align:right;font-weight:700;font-size:10px;color:#4a6b56;font-family:Arial,sans-serif;">Subtotal</td>
                                <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{$quote->subtotal}}</td>
                            </tr>
                            <tr style="background-color:#f2f7f4;">
                                <td colspan="3" style="border:1px solid #c2d4c9;padding:4px 8px;text-align:right;font-weight:700;font-size:10px;color:#4a6b56;font-family:Arial,sans-serif;">Discount</td>
                                <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{$quote->discount}}</td>
                            </tr>
                            <tr style="background-color:#f2f7f4;">
                                <td colspan="3" style="border:1px solid #c2d4c9;padding:4px 8px;text-align:right;font-weight:700;font-size:10px;color:#4a6b56;font-family:Arial,sans-serif;">GST (5%)</td>
                                <td style="border:1px solid #c2d4c9;padding:4px 7px;font-size:10px;color:#1a2e22;text-align:right;font-family:Arial,sans-serif;">{{$quote->gst}}</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="background-color:#1b3a2a;color:#ffffff;font-weight:700;font-size:12px;border:1px solid #1b3a2a;padding:6px 8px;text-align:right;font-family:Arial,sans-serif;">TOTAL</td>
                                <td style="background-color:#1b3a2a;color:#ffffff;font-weight:700;font-size:12px;border:1px solid #1b3a2a;padding:6px 7px;text-align:right;font-family:Arial,sans-serif;">{{$quote->total}}</td>
                            </tr>
                            </tbody>
                        </table>  <!-- NOTES -->
                        <div style="font-size:8px;font-weight:700;letter-spacing:0.16em;text-transform:uppercase;color:#1a2e22;border-bottom:2px solid #1b3a2a;padding-bottom:2px;margin-top:10px;margin-bottom:5px;font-family:Arial,sans-serif;">
                            Notes
                        </div>
                        <div style="background-color:#f2f7f4;border:1px solid #c2d4c9;padding:6px 8px;font-size:10px;color:#4a6b56;font-family:'DejaVu Sans', Arial, sans-serif;min-height:28px;line-height:1.3;">
                            {!! nl2br($quote->notes) !!}
                        </div>

                         <div style="font-size:8px;font-weight:700;letter-spacing:0.16em;text-transform:uppercase;color:#1a2e22;border-bottom:2px solid #1b3a2a;padding-bottom:2px;margin-top:10px;margin-bottom:5px;font-family:Arial,sans-serif;">
                            Payment method:
                        </div>
                        <div style="font-size:10px;color:#1a2e22;margin-bottom:8px;font-family:Arial,sans-serif;">
                           <strong> {{$quote->payment_method}}</strong>
                         </div>
                        

                        <!-- QUOTE ACCEPTANCE -->
                        <div style="font-size:8px;font-weight:700;letter-spacing:0.16em;text-transform:uppercase;color:#1a2e22;border-bottom:2px solid #1b3a2a;padding-bottom:2px;margin-top:10px;margin-bottom:6px;font-family:Arial,sans-serif;">Quote Acceptance</div>
                        <div style="font-size:10px;color:#1a2e22;margin-bottom:8px;font-family:Arial,sans-serif;">
                            By signing below, the Client accepts this quotation and agrees to the applicable Service Agreement:
                        </div>
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

                            @endif

                        </div>
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td valign="top" width="48%" style="padding-right:12px;">

                                    {{-- Client Signature Section --}}
                                    <div style="margin-bottom:5px;">
                                        <div style="font-size:8px;letter-spacing:0.1em;text-transform:uppercase;color:#4a6b56;margin-bottom:3px;font-weight:600;font-family:Arial,sans-serif;">
                                            Client Signature
                                        </div>

                                        @if(!empty($quote->client_signature))
                                            @if(Str::startsWith($quote->client_signature, 'data:image'))
                                                <!-- Show Image -->
                                                <div style="border-bottom:1.5px solid #1b3a2a; min-height:30px; background-color:#f9fafb; padding:3px 5px;">
                                                    <img src="{{ $quote->client_signature }}"
                                                         style="max-height:30px; display:block;" alt="Client Signature">
                                                </div>
                                            @else
                                                <!-- Show Plain Text -->
                                                <div style="border-bottom:1.5px solid #1b3a2a; min-height:30px; background-color:#f9fafb; padding:3px 5px; font-size:10px; color:#1a2e22; font-family:Arial,sans-serif;">
                                                    {{ $quote->client_signature }}
                                                </div>
                                            @endif   @else
                                            <!-- Empty placeholder -->
                                            <div style="border-bottom:1.5px solid #1b3a2a; min-height:30px; background-color:#f9fafb;"></div>
                                        @endif
                                    </div>

                                    {{-- Name (Print) Section --}}
                                    <div style="margin-top:7px;">
                                        <div style="font-size:8px;letter-spacing:0.1em;text-transform:uppercase;color:#4a6b56;margin-bottom:2px;font-weight:600;font-family:Arial,sans-serif;">
                                            Name (Print):
                                        </div>

                                        @if(!empty($quote->client_name_print))
                                            <div style="border-bottom:1px solid #c2d4c9; padding:2px 4px; font-size:10px; color:#1a2e22; font-family:Arial,sans-serif;">
                                                {{ $quote->client_name_print }}
                                            </div>
                                        @else
                                            <div style="border-bottom:1px solid #c2d4c9; min-height:18px;"></div>
                                        @endif
                                    </div>

                                </td>  <td width="4%">&nbsp;</td>
                                <td valign="top" width="48%">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td style="font-size:10px;font-weight:700;color:#1a2e22;white-space:nowrap;padding:2px 5px 2px 0;font-family:Arial,sans-serif;">Date:</td>
                                            <td style="font-size:10px;color:#1a2e22;border-bottom:1px solid #c2d4c9;padding:2px 3px;font-family:Arial,sans-serif;width:100%;">{{$quote->signature_date}}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:10px;font-weight:700;color:#1a2e22;white-space:nowrap;padding:2px 5px 2px 0;font-family:Arial,sans-serif;">Rep:</td>
                                            <td style="font-size:10px;color:#1a2e22;border-bottom:1px solid #c2d4c9;padding:2px 3px;font-family:Arial,sans-serif;">{{$quote->representative}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
  <!-- FOOTER -->
                <tr>
                    <td style="background-color:#1b3a2a;color:rgba(255,255,255,0.78);text-align:center;font-size:9px;letter-spacing:0.07em;padding:7px 16px;font-family:Arial,sans-serif;">
                        Harry's Lawncare Ltd. &nbsp;|&nbsp; Serving the Lower Mainland, BC &nbsp;|&nbsp; Fully Insured
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>