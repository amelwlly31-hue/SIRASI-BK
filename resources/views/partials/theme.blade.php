<link rel="stylesheet" href="{{ asset('css/theme.css') }}?v=global-theme-20261117-3">
<link rel="stylesheet" href="{{ asset('css/modern-ui.css') }}?v=sidebar-banner-blue-20261117-3">
@if(auth()->check() && (auth()->user()->isGuruBK() || auth()->user()->peran === 'guru_bk'))
<link rel="stylesheet" href="{{ asset('css/sirasi-guru-bk.css') }}?v=glass-cards-gurubk-20261117-4">
@endif
@include('partials.typography')
<script>
    (function () {
        var scopedThemeKey = @json(auth()->check() ? 'sirasi-theme-user-' . auth()->id() : 'sirasi-theme');
        var themeKey = 'sirasi-theme';
        window.sirasiThemeKey = themeKey;
        var theme = localStorage.getItem(themeKey)
            || localStorage.getItem(scopedThemeKey)
            || localStorage.getItem('sirasi-theme-portal')
            || 'light';

        function applyTheme(value) {
            var dark = value === 'dark';
            document.documentElement.classList.toggle('dark-mode', dark);
            document.documentElement.classList.toggle('dark', dark);
            if (document.body) {
                document.body.classList.toggle('dark-mode', dark);
                document.body.classList.toggle('dark', dark);
            }
        }
        window.sirasiSetTheme = function (value) {
            var normalized = value === 'dark' ? 'dark' : 'light';
            localStorage.setItem(themeKey, normalized);
            localStorage.setItem(scopedThemeKey, normalized);
            localStorage.setItem('sirasi-theme-portal', normalized);
            applyTheme(normalized);
            window.dispatchEvent(new CustomEvent('sirasi-theme-change', { detail: normalized }));
        };
        applyTheme(theme);

        var responsive = localStorage.getItem('sirasi-responsive');
        if (responsive === 'false') {
            document.documentElement.classList.add('responsive-disabled');
        } else {
            document.documentElement.classList.remove('responsive-disabled');
        }

        document.addEventListener('DOMContentLoaded', function () {
            var currentTheme = localStorage.getItem(themeKey) || theme;
            applyTheme(currentTheme);

            var currentResponsive = localStorage.getItem('sirasi-responsive') !== 'false';
            document.body.classList.toggle('responsive-disabled', !currentResponsive);
            document.documentElement.classList.toggle('responsive-disabled', !currentResponsive);
        });
        window.addEventListener('storage', function (event) {
            if (event.key === themeKey || event.key === scopedThemeKey || event.key === 'sirasi-theme-portal') {
                applyTheme(event.newValue || 'light');
            }
        });
    })();
</script>
