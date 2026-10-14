<div class="container text-center" style="margin-top:50px;">
    <h2 style="color:red;">This quote has expired</h2>
    <p>Quote #{{ $quote->id }} was valid until <strong>{{ \Carbon\Carbon::parse($quote->valid_until)->format('d M Y') }}</strong>.</p>
    <p>If you have any questions, please contact us at <a href="mailto:care@harryslawncare.ca">care@harryslawncare.ca</a>.</p>
</div>
