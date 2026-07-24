// Quản lý Chế độ Sáng / Tối (Light / Dark Mode) Tự động theo Thời gian thực
(function() {
    function getTimeBasedTheme() {
        const hour = new Date().getHours();
        return (hour >= 18 || hour < 6) ? 'dark' : 'light';
    }

    function getInitialTheme() {
        const savedTheme = localStorage.getItem('user-theme');
        if (savedTheme === 'dark' || savedTheme === 'light') {
            return savedTheme;
        }
        return getTimeBasedTheme();
    }

    function applyTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            document.documentElement.removeAttribute('data-theme');
        }

        const themeToggleBtn = document.getElementById('theme-toggle-btn');
        const themeIcon = document.getElementById('theme-toggle-icon');

        if (themeIcon) {
            if (theme === 'dark') {
                themeIcon.className = 'bi bi-moon-stars-fill text-warning';
                if (themeToggleBtn) themeToggleBtn.setAttribute('title', 'Đang Chế độ Tối - Bấm chuyển sang Trắng Sáng');
            } else {
                themeIcon.className = 'bi bi-sun-fill text-warning';
                if (themeToggleBtn) themeToggleBtn.setAttribute('title', 'Đang Chế độ Trắng Sáng - Bấm chuyển sang Tối');
            }
        }
    }

    // Áp dụng ngay lập tức khi script load
    const currentTheme = getInitialTheme();
    applyTheme(currentTheme);

    // Gắn listener sau khi DOM sẵn sàng
    document.addEventListener('DOMContentLoaded', () => {
        applyTheme(currentTheme);

        const themeToggleBtn = document.getElementById('theme-toggle-btn');
        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', () => {
                const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                const newTheme = isDark ? 'light' : 'dark';
                
                localStorage.setItem('user-theme', newTheme);
                applyTheme(newTheme);
            });
        }
    });
})();
