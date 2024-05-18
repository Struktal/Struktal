export const Sidebar = {
    elements: {
        sidebar: null,
        burger: null,
        darkBackground: null
    },
    shown: false,

    /**
     * Initialize the sidebar
     */
    init: () => {
        Sidebar.setupListeners();
    },

    /**
     * Set up the event listeners for the sidebar
     */
    setupListeners: () => {
        // Click on burger button
        $("#header-sidebar-open").on("click", () => {
            Sidebar.openSidebar();
        });

        // Click on close button
        $("#header-sidebar-close").on("click", () => {
            Sidebar.closeSidebar();
        });

        // Click on sidebar backgrund
        $(".header-sidebar-background").on("click", () => {
            Sidebar.closeSidebar();
        });
    },

    openSidebar: () => {
        // Show sidebar
        $(".header-sidebar-popup").removeClass("translate-x-full");
        $(".header-sidebar-background").removeClass("hidden");

        // Disable scrolling
        document.querySelector('html').scrollTop = window.scrollY;
        document.body.style.overflow = 'hidden';
        document.body.style.position = 'relative';
        document.querySelector('html').style.overflow = 'hidden';
        document.querySelector('html').style.position = 'relative';
    },

    closeSidebar: () => {
        // Hide sidebar
        $(".header-sidebar-popup").addClass("translate-x-full");
        $(".header-sidebar-background").addClass("hidden");

        // Enable scrolling
        document.body.style.overflow = null;
        document.body.style.position = null;
        document.querySelector('html').style.overflow = null;
        document.querySelector('html').style.position = null;
    },

    /**
     * Toggle the sidebar visibility
     */
    toggleSidebar: () => {
        // Toggle navigator
        Sidebar.elements.sidebar.toggleClass("header-navigator-default");
        Sidebar.elements.sidebar.toggleClass("header-navigator-active");

        //

        // Toggle dark background
        Sidebar.elements.darkBackground.toggleClass("header-dark-background-default");
        Sidebar.elements.darkBackground.toggleClass("header-dark-background-active");

        // Change burger
        Sidebar.elements.burger.toggleClass("close");

        // Toggle scrolling
        if(Sidebar.shown) {
            document.body.style.overflow = null;
            document.body.style.position = null;
            document.querySelector('html').style.overflow = null;
            document.querySelector('html').style.position = null;

            Sidebar.shown = false;
        } else {
            document.querySelector('html').scrollTop = window.scrollY;
            document.body.style.overflow = 'hidden';
            document.body.style.position = 'relative';
            document.querySelector('html').style.overflow = 'hidden';
            document.querySelector('html').style.position = 'relative';

            Sidebar.shown = true;
        }
    }
}

export default Sidebar;
