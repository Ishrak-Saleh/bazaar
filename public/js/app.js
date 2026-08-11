document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | Registration: Vendor Store Name
    |--------------------------------------------------------------------------
    */

    const roleSelect = document.getElementById('roleSelect');
    const storeNameField = document.getElementById('storeNameField');

    if (roleSelect && storeNameField) {

        const toggleStoreField = () => {
            storeNameField.classList.toggle(
                'hidden',
                roleSelect.value !== 'vendor'
            );
        };

        roleSelect.addEventListener('change', toggleStoreField);

        toggleStoreField();
    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard Sidebar
    |--------------------------------------------------------------------------
    */

    const dashboardLayout =
        document.querySelector('.dashboard-layout');

    const collapseToggle =
        document.getElementById('dashboardCollapseToggle');

    const menuToggle =
        document.getElementById('dashboardMenuToggle');

    const sidebarOverlay =
        document.getElementById('dashboardSidebarOverlay');


    /*
    |--------------------------------------------------------------------------
    | Desktop: Collapse / Expand Sidebar
    |--------------------------------------------------------------------------
    */

    if (dashboardLayout && collapseToggle) {

        collapseToggle.addEventListener('click', () => {

            dashboardLayout.classList.toggle(
                'sidebar-collapsed'
            );

            const collapsed =
                dashboardLayout.classList.contains(
                    'sidebar-collapsed'
                );

            collapseToggle.setAttribute(
                'aria-expanded',
                String(!collapsed)
            );

            collapseToggle.setAttribute(
                'aria-label',
                collapsed
                    ? 'Expand sidebar'
                    : 'Collapse sidebar'
            );
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Mobile: Open / Close Sidebar
    |--------------------------------------------------------------------------
    */

    const closeMobileMenu = () => {

        if (!dashboardLayout) {
            return;
        }

        dashboardLayout.classList.remove(
            'mobile-menu-open'
        );

        if (menuToggle) {
            menuToggle.setAttribute(
                'aria-expanded',
                'false'
            );
        }
    };


    if (dashboardLayout && menuToggle) {

        menuToggle.addEventListener('click', () => {

            const isOpen =
                dashboardLayout.classList.toggle(
                    'mobile-menu-open'
                );

            menuToggle.setAttribute(
                'aria-expanded',
                String(isOpen)
            );
        });
    }


    if (sidebarOverlay) {

        sidebarOverlay.addEventListener(
            'click',
            closeMobileMenu
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Close Mobile Sidebar with Escape
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', (event) => {

        if (event.key === 'Escape') {
            closeMobileMenu();
        }
    });


    /*
    |--------------------------------------------------------------------------
    | Close Mobile Sidebar After Clicking a Link
    |--------------------------------------------------------------------------
    */

    if (dashboardLayout) {

        const sidebarLinks =
            dashboardLayout.querySelectorAll(
                '.sidebar-links a'
            );

        sidebarLinks.forEach((link) => {

            link.addEventListener('click', () => {
                closeMobileMenu();
            });

        });
    }

});