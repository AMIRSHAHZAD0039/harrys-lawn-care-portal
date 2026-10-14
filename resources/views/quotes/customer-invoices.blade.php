<x-layout>
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harry's Lawn Care — Invoices</title>
    <link rel="icon" type="image/x-icon" href="{{asset('images/logo.webp')}}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --dk: #1b3a2a; --md: #2d5c3e; --lt: #e8f0eb; --bd: #c2d4c9;
            --tx: #1a2e22; --sub: #4a6b56; --alt: #f2f7f4; --white: #ffffff;
        }

        body {
            background: #dde6e0; font-family: 'Source Sans 3', sans-serif; font-size: 13px;
            color: var(--tx); padding: 30px 16px 60px; overflow: auto !important;
        }

        .page {
            width: 210mm; min-width: 210mm; max-width: 210mm; min-height: 297mm;
            margin: 0 auto; background: var(--white); border: 1px solid #b8cfc3;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px; padding: 0;
        }

        .hdr { display: flex; justify-content: space-between; align-items: flex-start; padding: 22px 32px 18px; background: #fff; }
        .logo { line-height: 1; }
        .hdr-right { text-align: right; }
        .hdr-right h1 {
            font-family: 'EB Garamond', serif; font-size: 28px; font-weight: 700; color: var(--dk);
            letter-spacing: .06em; text-transform: uppercase;
        }
        .hdr-right .co { font-size: 13px; font-weight: 600; color: var(--tx); margin-top: 2px; }

        .top-rule { height: 3px; background: var(--dk); margin: 0 32px; }
        .body { padding: 20px 32px 28px; }

        .stitle {
            font-size: 10.5px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase;
            color: var(--tx); border-bottom: 2px solid var(--dk); padding-bottom: 3px; margin-bottom: 10px;
        }
        .flabel { font-size: 12px; font-weight: 700; white-space: nowrap; color: var(--tx); }

        /* customer summary card */
        .cust-card {
            display:grid; grid-template-columns:1fr 1fr; gap:6px 32px;
            background:var(--alt); border:1px solid var(--bd); border-radius:4px;
            padding:14px 18px; margin-bottom:20px; font-size:13px;
        }
        .cust-card .row-line{ display:flex; gap:8px; }
        .cust-card .row-line .k{ font-weight:700; color:var(--sub); min-width:90px; }
        .cust-card .row-line .v{ color:var(--tx); }

        /* ===== BILLING ===== */
        .btn-add-bill{
            background:var(--dk); color:#fff; border:none; font-size:11px; font-weight:700;
            letter-spacing:.08em; text-transform:uppercase; padding:7px 14px; border-radius:3px; margin-top:8px;
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

        .badge-pay{ display:inline-block; font-size:9.5px; font-weight:700; letter-spacing:.05em; text-transform:uppercase; padding:3px 8px; border-radius:10px; }
        .badge-paid{ background:#dff0e6; color:#1b7a42; }
        .badge-unpaid{ background:#fbe3e3; color:#b13434; }
        .badge-partial{ background:#fdf0d9; color:#9a6a14; }

        .bill-sum{ display:flex; justify-content:flex-end; margin-bottom:10px; }
        .bill-sum-box{ min-width:240px; }
        .bill-sum-row{ display:flex; justify-content:space-between; padding:6px 12px; font-size:12px; border:1px solid var(--bd); border-bottom:none; background:var(--alt); }
        .bill-sum-row:last-child{ border-bottom:1px solid var(--bd); }
        .bill-sum-row.total{ background:var(--dk); color:#fff; font-weight:700; border-color:var(--dk); }
        .bill-sum-row .lbl{ font-weight:700; color:var(--sub); }
        .bill-sum-row.total .lbl{ color:#fff; }

        .modal-bill .modal-content{ border:none; border-radius:6px; overflow:hidden; }
        .modal-bill .modal-header{ background:var(--dk); color:#fff; padding:14px 20px; border:none; }
        .modal-bill .modal-title{ font-size:14px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; }
        .modal-bill .btn-close{ filter:invert(1); opacity:.85; }
        .modal-bill label{ font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:var(--tx); margin-bottom:4px; display:block; }
        .modal-bill .form-control, .modal-bill .form-select{ font-size:13px; border:1px solid var(--bd); border-radius:3px; padding:7px 10px; color:var(--tx); }
        .modal-bill .form-control:focus, .modal-bill .form-select:focus{ border-color:var(--md); box-shadow:0 0 0 .15rem rgba(45,92,62,.15); }
        .modal-bill .modal-footer{ border-top:1px solid var(--bd); padding:12px 20px; }
        .modal-bill .btn-save{ background:var(--dk); border:none; color:#fff; font-weight:700; font-size:12px; text-transform:uppercase; letter-spacing:.06em; padding:8px 18px; }
        .modal-bill .btn-save:hover{ background:var(--md); }

        .bill-tbl th.c, .bill-tbl td.c{ text-align:center; }
        .bill-edit{
            background:transparent; border:1px solid var(--bd); color:var(--md); width:28px; height:26px;
            border-radius:3px; cursor:pointer; font-size:11px; display:inline-flex; align-items:center; justify-content:center; transition:.15s;
        }
        .bill-edit:hover{ background:var(--dk); color:#fff; border-color:var(--dk); }
        .bill-actions{ display:inline-flex; gap:6px; align-items:center; justify-content:center; }
        .bill-del{
            background:transparent; border:1px solid #e3c2c2; color:#b13434; width:28px; height:26px;
            border-radius:3px; cursor:pointer; font-size:11px; display:inline-flex; align-items:center; justify-content:center; transition:.15s;
        }
        .bill-del:hover{ background:#b13434; color:#fff; border-color:#b13434; }

        .pg-wrap{ display:flex; justify-content:center; margin-top:6px; }

        .modal-bill .gst-check{ display:inline-flex; align-items:center; gap:8px; cursor:pointer; margin:0; }
        .modal-bill .gst-check input{ width:16px; height:16px; accent-color:var(--dk); }
        .bill-calc{ border:1px solid var(--bd); border-radius:3px; background:var(--alt); font-size:12.5px; }
        .bill-calc > div{ display:flex; justify-content:space-between; padding:6px 12px; border-bottom:1px solid var(--bd); }
        .bill-calc > div:last-child{ border-bottom:none; }
        .bill-calc .tot{ background:var(--dk); color:#fff; font-weight:700; }
        .modal-bill .form-control[readonly]{ background:#f2f4f3; }

        @media print{
            body{ background:#fff; padding:0; }
            .page{ box-shadow:none; border:none; }
            .btn-add-bill, .modal-bill, .bill-edit, .bill-del, .bill-tbl th.c, .bill-tbl td.c, .back-btn{ display:none !important; }
        }
    </style>
</head>

<body>

    @if(session('success'))
        <div style="background-color:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('customers.all') }}" class="back-btn" title="Back to all customers" style="font-size:20px; color:#1b3a2a;">
        <i class="fa-solid fa-arrow-left"></i> Back to All Customers
    </a>

    <div class="page mt-5">

        <!-- HEADER -->
        <div class="hdr">
            <div class="logo">
                <img src="{{asset('images/harrys_logo_2.png')}}">
            </div>
            <div class="hdr-right">
                <h1>Client Billing Info</h1>
                <div class="co">Harry's Lawncare Ltd.</div>
                <button type="button" class="btn-add-bill" data-bs-toggle="modal" data-bs-target="#billingModal">
                    <i class="fa-solid fa-plus"></i> Add Invoice
                </button>
            </div>
        </div>

        <div class="top-rule"></div>

        <div class="body">

            {{-- CUSTOMER SUMMARY (whose invoices these are) --}}
            <div class="stitle">Customer</div>
            <div class="cust-card">
                <div class="row-line"><span class="k">Name</span><span class="v">{{ $quote->client_name }}</span></div>
                <div class="row-line"><span class="k">Quote #</span><span class="v">#{{ $quote->id }}</span></div>
                <div class="row-line"><span class="k">Email</span><span class="v">{{ $quote->client_email ?? '—' }}</span></div>
                <div class="row-line"><span class="k">Phone</span><span class="v">{{ $quote->client_phone ?? '—' }}</span></div>
                <div class="row-line"><span class="k">Address</span><span class="v">{{ $quote->client_address ?? '—' }}</span></div>
                <div class="row-line"><span class="k">Quote Total</span><span class="v">${{ $quote->total }}</span></div>
            </div>

            <div class="stitle">Billing Records</div>

            <table class="bill-tbl">
                <thead>
                <tr>
                    <th style="width:12%">Date</th>
                    <th style="width:24%">Service Detail</th>
                    <th style="width:11%">Method</th>
                    <th style="width:10%">Status</th>
                    <th class="r" style="width:12%">Total</th>
                    <th class="r" style="width:10%">Paid</th>
                    <th class="r" style="width:10%">Pending</th>
                    <th class="c" style="width:11%">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($quote->billings as $bill)
                    <tr>
                        <td>{{ $bill->paid_date ? \Carbon\Carbon::parse($bill->paid_date)->format('d/m/Y') : '—' }}</td>
                        <td>
                            {{ $bill->service_detail }}
                            @if($bill->notes)
                                <div style="font-size:10.5px;color:var(--sub);margin-top:2px">{{ $bill->notes }}</div>
                            @endif
                        </td>
                        <td>{{ $bill->method }}</td>
                        <td>
                            @php $st = strtolower($bill->status); @endphp
                            <span class="badge-pay {{ $st === 'paid' ? 'badge-paid' : (str_contains($st,'partial') ? 'badge-partial' : 'badge-unpaid') }}">
                                {{ $bill->status }}
                            </span>
                        </td>
                        <td class="r">
                            ${{ number_format($bill->total_amount ?? 0, 2) }}
                            @if($bill->gst_applied)
                                <div style="font-size:10px;color:var(--sub)">incl. GST ${{ number_format($bill->gst_amount, 2) }}</div>
                            @endif
                        </td>
                        <td class="r">${{ number_format($bill->amount_paid ?? 0, 2) }}</td>
                        <td class="r">${{ number_format($bill->pending_amount ?? 0, 2) }}</td>
                        <td class="c">
                            <div class="bill-actions">
                                <button type="button" class="bill-edit"
                                    data-action="{{ route('billing.update', $bill->id) }}"
                                    data-service="{{ $bill->service_detail }}"
                                    data-status="{{ $bill->status }}"
                                    data-method="{{ $bill->method }}"
                                    data-amount="{{ $bill->invoice_amount }}"
                                    data-gst="{{ $bill->gst_applied ? 1 : 0 }}"
                                    data-paid="{{ $bill->amount_paid }}"
                                    data-date="{{ $bill->paid_date ? \Carbon\Carbon::parse($bill->paid_date)->format('Y-m-d') : '' }}"
                                    data-notes="{{ $bill->notes }}"
                                    title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>

                                <form action="{{ route('billing.destroy', $bill->id) }}" method="POST" style="margin:0;"
                                      onsubmit="return confirm('Delete this invoice record? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bill-del" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="bill-empty">No billing records yet. Click "Add Invoice" to create one.</td></tr>
                @endforelse
                </tbody>
            </table>

            <!-- SUMMARY -->
            <div class="bill-sum">
                <div class="bill-sum-box">
                    <div class="bill-sum-row">
                        <span class="lbl">Total Paid</span>
                        <span>${{ number_format($quote->billings->sum('amount_paid'), 2) }}</span>
                    </div>
                    <div class="bill-sum-row total">
                        <span class="lbl">Pending Balance</span>
                        <span>${{ number_format($quote->billings->sum('pending_amount'), 2) }}</span>
                    </div>
                </div>
            </div>

            @if($billings->hasPages())
                <div class="pg-wrap">
                    {{ $billings->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>

    </div>

    <!-- BILLING MODAL (add) -->
    <div class="modal fade modal-bill" id="billingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('billing.store', $quote->id) }}" method="POST" class="bill-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Invoice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label>Service Detail</label>
                                <input type="text" name="service_detail" class="form-control" placeholder="e.g. Bi-weekly mowing — June" required>
                            </div>
                            <div class="col-md-6">
                                <label>Payment Status</label>
                                <select name="status" id="billStatus" class="form-select js-status" required>
                                    <option value="Paid">Paid</option>
                                    <option value="Unpaid">Unpaid</option>
                                    <option value="Partial">Partially Paid</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Payment Method</label>
                                <select name="method" class="form-select">
                                    <option value="Cash">Cash</option>
                                    <option value="E-Transfer">E-Transfer</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Debit">Debit</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Invoice Amount ($)</label>
                                <input type="number" step="0.01" min="0" name="invoice_amount" class="form-control js-amount" value="0.00" required>
                            </div>
                            <div class="col-md-6">
                                <label>Payment Date</label>
                                <input type="date" name="paid_date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-12">
                                <label class="gst-check">
                                    <input type="checkbox" name="gst_applied" value="1" class="js-gst"> Add 5% GST
                                </label>
                            </div>
                            <div class="col-12">
                                <div class="bill-calc">
                                    <div><span>Subtotal</span><span class="js-sub">$0.00</span></div>
                                    <div><span>GST (5%)</span><span class="js-gst-amt">$0.00</span></div>
                                    <div class="tot"><span>Total</span><span class="js-total">$0.00</span></div>
                                </div>
                            </div>
                            <div class="col-md-6 js-paid-wrap">
                                <label>Amount Paid ($)</label>
                                <input type="number" step="0.01" min="0" name="amount_paid" class="form-control js-paid" value="0.00">
                            </div>
                            <div class="col-md-6 js-pending-wrap">
                                <label>Pending ($)</label>
                                <input type="number" step="0.01" class="form-control js-pending" value="0.00" readonly>
                            </div>
                            <div class="col-12">
                                <label>Notes</label>
                                <textarea name="notes" rows="3" class="form-control" placeholder="Reference #, partial payment note, etc."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-save">Save Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Invoice form logic (shared by Add + Edit modals):
        //   Paid    -> only "Amount Paid" shown, locked to the total
        //   Unpaid  -> only "Pending" shown, equal to the total
        //   Partial -> both shown; Pending = Total - Amount Paid
        // The server recomputes all of this on save, so these are display helpers only.
        const GST_RATE = 0.05;
        const money = n => '$' + n.toFixed(2);

        function recalcBill(form){
            const status  = form.querySelector('.js-status').value;
            const sub     = Math.max(parseFloat(form.querySelector('.js-amount').value) || 0, 0);
            const gst     = form.querySelector('.js-gst').checked ? Math.round(sub * GST_RATE * 100) / 100 : 0;
            const total   = Math.round((sub + gst) * 100) / 100;
            const paidIn  = form.querySelector('.js-paid');
            const pendIn  = form.querySelector('.js-pending');

            form.querySelector('.js-sub').textContent     = money(sub);
            form.querySelector('.js-gst-amt').textContent = money(gst);
            form.querySelector('.js-total').textContent   = money(total);

            let paid;
            if (status === 'Paid')        { paid = total; }
            else if (status === 'Unpaid') { paid = 0; }
            else                          { paid = Math.min(Math.max(parseFloat(paidIn.value) || 0, 0), total); }

            if (status !== 'Partial') paidIn.value = paid.toFixed(2);
            paidIn.readOnly = status !== 'Partial';
            pendIn.value = (total - paid).toFixed(2);

            form.querySelector('.js-paid-wrap').style.display    = status === 'Unpaid' ? 'none' : '';
            form.querySelector('.js-pending-wrap').style.display = status === 'Paid'   ? 'none' : '';
        }

        ['input', 'change'].forEach(function(evt){
            document.addEventListener(evt, function(e){
                const form = e.target.closest && e.target.closest('.bill-form');
                if (form) recalcBill(form);
            });
        });
        document.addEventListener('DOMContentLoaded', function(){
            document.querySelectorAll('.bill-form').forEach(recalcBill);
        });

        // EDIT billing — delegated listener
        document.querySelector('.bill-tbl')?.addEventListener('click', function (e) {
            const btn = e.target.closest('.bill-edit');
            if (!btn) return;
            document.getElementById('editBillForm').action = btn.dataset.action;
            document.getElementById('edit_service').value  = btn.dataset.service || '';
            document.getElementById('edit_status').value   = btn.dataset.status  || 'Unpaid';
            document.getElementById('edit_method').value   = btn.dataset.method  || 'Cash';
            document.getElementById('edit_amount').value   = btn.dataset.amount  || '0.00';
            document.getElementById('edit_gst').checked    = btn.dataset.gst === '1';
            document.getElementById('edit_paid').value     = btn.dataset.paid    || '0.00';
            document.getElementById('edit_date').value     = btn.dataset.date    || '';
            document.getElementById('edit_notes').value    = btn.dataset.notes   || '';
            recalcBill(document.getElementById('editBillForm'));
            new bootstrap.Modal(document.getElementById('editBillingModal')).show();
        });
    </script>

    <!-- EDIT BILLING MODAL -->
    <div class="modal fade modal-bill" id="editBillingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editBillForm" action="" method="POST" class="bill-form">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Invoice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label>Service Detail</label>
                                <input type="text" name="service_detail" id="edit_service" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Payment Status</label>
                                <select name="status" id="edit_status" class="form-select js-status" required>
                                    <option value="Paid">Paid</option>
                                    <option value="Unpaid">Unpaid</option>
                                    <option value="Partial">Partially Paid</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Payment Method</label>
                                <select name="method" id="edit_method" class="form-select">
                                    <option value="Cash">Cash</option>
                                    <option value="E-Transfer">E-Transfer</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Debit">Debit</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Invoice Amount ($)</label>
                                <input type="number" step="0.01" min="0" name="invoice_amount" id="edit_amount" class="form-control js-amount" required>
                            </div>
                            <div class="col-md-6">
                                <label>Payment Date</label>
                                <input type="date" name="paid_date" id="edit_date" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="gst-check">
                                    <input type="checkbox" name="gst_applied" value="1" id="edit_gst" class="js-gst"> Add 5% GST
                                </label>
                            </div>
                            <div class="col-12">
                                <div class="bill-calc">
                                    <div><span>Subtotal</span><span class="js-sub">$0.00</span></div>
                                    <div><span>GST (5%)</span><span class="js-gst-amt">$0.00</span></div>
                                    <div class="tot"><span>Total</span><span class="js-total">$0.00</span></div>
                                </div>
                            </div>
                            <div class="col-md-6 js-paid-wrap">
                                <label>Amount Paid ($)</label>
                                <input type="number" step="0.01" min="0" name="amount_paid" id="edit_paid" class="form-control js-paid">
                            </div>
                            <div class="col-md-6 js-pending-wrap">
                                <label>Pending ($)</label>
                                <input type="number" step="0.01" class="form-control js-pending" readonly>
                            </div>
                            <div class="col-12">
                                <label>Notes</label>
                                <textarea name="notes" id="edit_notes" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-save">Update Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>

</x-layout>