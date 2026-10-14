// Copies each column header into its cells as data-label, so the mobile
// card layout in dashboard.css (table.resp-table) can show "Label: value".
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('table.resp-table').forEach(function (table) {
        var heads = Array.from(table.querySelectorAll('thead th')).map(function (th) {
            return th.textContent.replace(/\s+/g, ' ').trim();
        });

        table.querySelectorAll('tbody > tr').forEach(function (tr) {
            Array.from(tr.children).forEach(function (td, i) {
                if (td.hasAttribute('data-label')) return;
                td.setAttribute('data-label', td.colSpan > 1 ? '' : (heads[i] || ''));
                if (i === heads.length - 1 && /action/i.test(heads[i] || '')) {
                    td.classList.add('resp-actions');
                    return;
                }
                // keep multi-part cells (e.g. "1 times<br>date") together as one value beside the label
                var val = document.createElement('div');
                val.className = 'resp-val';
                while (td.firstChild) val.appendChild(td.firstChild);
                td.appendChild(val);
            });
        });
    });
});
