<link rel="stylesheet" href="{{ asset('css/theme.css') }}">
<script>
    (function () {
        var theme = localStorage.getItem('sirasi-theme') || 'light';
        if (theme === 'dark') {
            document.documentElement.classList.add('dark-mode');
        } else {
            document.documentElement.classList.remove('dark-mode');
        }

        var responsive = localStorage.getItem('sirasi-responsive');
        if (responsive === 'false') {
            document.documentElement.classList.add('responsive-disabled');
        } else {
            document.documentElement.classList.remove('responsive-disabled');
        }

        document.addEventListener('DOMContentLoaded', function () {
            var currentTheme = localStorage.getItem('sirasi-theme') || 'light';
            document.body.classList.toggle('dark-mode', currentTheme === 'dark');
            document.documentElement.classList.toggle('dark-mode', currentTheme === 'dark');

            var currentResponsive = localStorage.getItem('sirasi-responsive') !== 'false';
            document.body.classList.toggle('responsive-disabled', !currentResponsive);
            document.documentElement.classList.toggle('responsive-disabled', !currentResponsive);
        });
    })();
</script>
