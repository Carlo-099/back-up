// Theme Manager
document.addEventListener('DOMContentLoaded', function() {
    // Function to apply theme to the userlayout elements only
    function applyTheme() {
        // Get the theme from the HTML element's data-theme attribute
        const theme = document.documentElement.getAttribute('data-theme') || 'light';
        console.log('Current theme:', theme); // Debug log

        // Apply theme to body
        document.body.className = `theme-${theme}`;

        // Apply theme to all menu buttons in the sidebar
        const menuButtons = document.querySelectorAll('.menu-button');
        console.log('Found menu buttons:', menuButtons.length); // Debug log

        menuButtons.forEach(button => {
            if (theme === 'dark') {
                button.style.setProperty('background-color', 'var(--menubutton-bg)', 'important');
                button.style.setProperty('color', 'var(--text-primary)', 'important');

                // Add hover effect
                button.onmouseover = function() {
                    this.style.setProperty('background-color', 'var(--menubuttonhover-bg)', 'important');
                };
                button.onmouseout = function() {
                    this.style.setProperty('background-color', 'var(--menubutton-bg)', 'important');
                };
            } else {
                button.style.setProperty('background-color', 'var(--menubutton-bg)', 'important');
                button.style.setProperty('color', 'var(--text-primary)', 'important');

                // Add hover effect
                button.onmouseover = function() {
                    this.style.setProperty('background-color', 'var(--menubuttonhover-bg)', 'important');
                };
                button.onmouseout = function() {
                    this.style.setProperty('background-color', 'var(--menubutton-bg)', 'important');
                };
            }
        });

        // Apply theme to sidebar
        const sidebar = document.querySelector('.w-64.min-h-screen.shadow-md');
        if (sidebar) {
            sidebar.style.setProperty('background-color', 'var(--sidenavbar-bg)', 'important');
            console.log('Applied theme to sidebar'); // Debug log
        } else {
            console.log('Sidebar not found'); // Debug log
        }

        // Apply theme to top navbar
        const topNavbar = document.querySelector('nav.shadow-md');
        if (topNavbar) {
            topNavbar.style.setProperty('background-color', 'var(--topnavbar-bg)', 'important');
            console.log('Applied theme to top navbar'); // Debug log
        } else {
            console.log('Top navbar not found'); // Debug log
        }

        // Apply theme to main content area background only
        const mainContent = document.querySelector('.flex-1.p-8 .p-6.rounded-lg.shadow-lg');
        if (mainContent) {
            mainContent.style.setProperty('background-color', 'var(--bg-primary)', 'important');
            console.log('Applied theme to main content area'); // Debug log
        } else {
            console.log('Main content area not found'); // Debug log
        }

        // Apply theme to specific text elements in the layout only
        // User name in the sidebar
        const userName = document.querySelector('.w-64.min-h-screen.shadow-md h3');
        if (userName) {
            userName.style.setProperty('color', 'var(--text-primary)', 'important');
        }

        // Menu heading in the sidebar
        const menuHeading = document.querySelector('.w-64.min-h-screen.shadow-md h2');
        if (menuHeading) {
            menuHeading.style.setProperty('color', 'var(--text-primary)', 'important');
        }

        // App title in the top navbar
        const appTitle = document.querySelector('nav.shadow-md .text-xl.font-bold');
        if (appTitle) {
            appTitle.style.setProperty('color', 'var(--text-primary)', 'important');
        }

        // User greeting in the top navbar
        const userGreeting = document.querySelector('nav.shadow-md span');
        if (userGreeting) {
            userGreeting.style.setProperty('color', 'var(--text-primary)', 'important');
        }

        // Notification icon in the top navbar
        const notificationIcon = document.querySelector('nav.shadow-md button');
        if (notificationIcon) {
            notificationIcon.style.setProperty('color', 'var(--text-primary)', 'important');
        }

        // Horizontal rule in the sidebar
        const hr = document.querySelector('.w-64.min-h-screen.shadow-md hr');
        if (hr) {
            hr.style.setProperty('border-color', 'var(--border-color)', 'important');
        }
    }

    // Apply theme on page load
    applyTheme();

    // Apply theme again after a short delay to ensure all elements are loaded
    setTimeout(applyTheme, 500);

    // Observe theme changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'data-theme') {
                console.log('Theme changed to:', document.documentElement.getAttribute('data-theme')); // Debug log
                applyTheme();
            }
        });
    });

    observer.observe(document.documentElement, { attributes: true });

    // We're no longer using localStorage for theme storage
    // The theme is now controlled by the server-side user settings
});
