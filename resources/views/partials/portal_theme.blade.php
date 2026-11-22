<link rel="stylesheet" href="{{ asset('css/modern-ui.css') }}?v=dashboard-toggle-20261115-1">
<link rel="stylesheet" href="{{ asset('css/theme.css') }}?v=portal-whatsapp-footer-20261115-1">
<script>
    (function () {
        var key = 'sirasi-theme';
        var portalKey = 'sirasi-theme-portal';
        var theme = localStorage.getItem(key) || localStorage.getItem(portalKey) || 'light';
        window.sirasiThemeKey = key;
        function applyTheme(value) {
            var dark = value === 'dark';
            document.documentElement.classList.toggle('dark-mode', dark);
            document.documentElement.classList.toggle('dark', dark);
            if (document.body) {
                document.body.classList.toggle('dark-mode', dark);
                document.body.classList.toggle('dark', dark);
            }
        }
        applyTheme(theme);
        document.documentElement.classList.add('sirasi-portal');
        document.addEventListener('DOMContentLoaded', function () {
            document.body.classList.add('sirasi-portal');
            applyTheme(localStorage.getItem(key) || theme);
            var actions = document.querySelector('.nav-actions');
            if (!actions || actions.querySelector('.sirasi-theme-toggle')) return;

            var button = document.createElement('button');
            button.type = 'button';
            button.className = 'sirasi-theme-toggle';
            button.title = 'Ganti tema';
            button.setAttribute('aria-label', 'Beralih ke tampilan gelap');
            button.innerHTML = '<svg class="theme-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.9 13A8.5 8.5 0 0 1 11 3.1 8.5 8.5 0 1 0 20.9 13Z"/></svg><svg class="theme-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l-1.42 1.42m11.3-11.3 1.42-1.42"/></svg>';
            function sync() {
                var dark = document.documentElement.classList.contains('dark-mode');
                button.setAttribute('aria-pressed', String(dark));
                button.setAttribute('aria-label', dark ? 'Beralih ke tampilan terang' : 'Beralih ke tampilan gelap');
                document.body.classList.toggle('dark-mode', dark);
            }
            button.addEventListener('click', function () {
                var dark = !document.documentElement.classList.contains('dark-mode');
                var nextTheme = dark ? 'dark' : 'light';
                localStorage.setItem(key, nextTheme);
                localStorage.setItem(portalKey, nextTheme);
                document.querySelectorAll('body, html').forEach(function (node) {
                    node.classList.toggle('dark-mode', dark);
                    node.classList.toggle('dark', dark);
                });
                sync();
            });
            actions.insertBefore(button, actions.firstChild);
            new MutationObserver(sync).observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
            new MutationObserver(sync).observe(document.body, { attributes: true, attributeFilter: ['class'] });
            sync();
        });
        window.addEventListener('storage', function (event) {
            if (event.key === key || event.key === portalKey) applyTheme(event.newValue || 'light');
        });
    })();
</script>
