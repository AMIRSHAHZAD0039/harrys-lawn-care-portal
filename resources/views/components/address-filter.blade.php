@props(['scope' => null])

{{-- Address filter with autocomplete. Suggestions come from route('address.suggest');
     picking one fills the input and submits the surrounding filter form. --}}
<div class="addr-ac" data-url="{{ route('address.suggest', $scope ? ['scope' => $scope] : []) }}">
    <input type="text"
           name="address"
           placeholder="Address"
           value="{{ request('address') }}"
           class="filter-input addr-ac-input"
           autocomplete="off"
           role="combobox"
           aria-autocomplete="list"
           aria-expanded="false">
    <ul class="addr-ac-list" role="listbox"></ul>
</div>

@once
    <style>
        .addr-ac{ position:relative; }
        .addr-ac-list{
            position:absolute; top:calc(100% + 4px); left:0; min-width:100%; width:max-content; max-width:420px;
            margin:0; padding:4px 0; list-style:none; z-index:50; display:none;
            background:#111; border:1px solid rgba(255,255,255,0.2); border-radius:8px;
            box-shadow:0 10px 25px rgba(0,0,0,0.35); max-height:280px; overflow-y:auto;
        }
        .addr-ac-list.open{ display:block; }
        .addr-ac-list li{
            padding:9px 12px; color:#e5e7eb; font-size:13px; cursor:pointer;
            white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
        }
        .addr-ac-list li mark{ background:none; color:#4ade80; font-weight:700; padding:0; }
        .addr-ac-list li.active, .addr-ac-list li:hover{ background:#1B3A2A; color:#fff; }
        .addr-ac-list li.empty{ color:#9ca3af; font-style:italic; cursor:default; background:none; }
        @media (max-width:768px){ .addr-ac, .addr-ac-list{ width:100%; max-width:none; } }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.addr-ac').forEach(function (wrap) {
                const input = wrap.querySelector('.addr-ac-input');
                const list  = wrap.querySelector('.addr-ac-list');
                let items = [], active = -1, timer = null, lastReq = 0;

                const esc = s => s.replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

                function close() {
                    list.classList.remove('open');
                    input.setAttribute('aria-expanded', 'false');
                    active = -1;
                }

                function render(term) {
                    if (!items.length) {
                        list.innerHTML = '<li class="empty">No matching addresses</li>';
                    } else {
                        const re = new RegExp('(' + term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'ig');
                        list.innerHTML = items.map((a, i) =>
                            '<li role="option" data-i="' + i + '" title="' + esc(a) + '">' + esc(a).replace(re, '<mark>$1</mark>') + '</li>'
                        ).join('');
                    }
                    list.classList.add('open');
                    input.setAttribute('aria-expanded', 'true');
                }

                function pick(i) {
                    input.value = items[i];
                    close();
                    input.form && input.form.submit();
                }

                function highlight(i) {
                    const lis = list.querySelectorAll('li[data-i]');
                    if (!lis.length) return;
                    active = (i + lis.length) % lis.length;
                    lis.forEach(li => li.classList.toggle('active', +li.dataset.i === active));
                    lis[active].scrollIntoView({ block: 'nearest' });
                }

                input.addEventListener('input', function () {
                    clearTimeout(timer);
                    const term = input.value.trim();
                    if (term.length < 2) { close(); return; }
                    timer = setTimeout(function () {
                        const reqId = ++lastReq;
                        const url = wrap.dataset.url + (wrap.dataset.url.includes('?') ? '&' : '?') + 'q=' + encodeURIComponent(term);
                        fetch(url, { headers: { 'Accept': 'application/json' } })
                            .then(r => r.ok ? r.json() : [])
                            .then(data => {
                                if (reqId !== lastReq) return; // a newer keystroke won
                                items = data; active = -1; render(term);
                            })
                            .catch(close);
                    }, 250);
                });

                input.addEventListener('keydown', function (e) {
                    if (!list.classList.contains('open')) return;
                    if (e.key === 'ArrowDown')      { e.preventDefault(); highlight(active + 1); }
                    else if (e.key === 'ArrowUp')   { e.preventDefault(); highlight(active - 1); }
                    else if (e.key === 'Escape')    { close(); }
                    else if (e.key === 'Enter' && active >= 0) { e.preventDefault(); pick(active); }
                });

                // mousedown (not click) so it fires before the input's blur closes the list
                list.addEventListener('mousedown', function (e) {
                    const li = e.target.closest('li[data-i]');
                    if (li) { e.preventDefault(); pick(+li.dataset.i); }
                });

                input.addEventListener('blur', close);
            });
        });
    </script>
@endonce
