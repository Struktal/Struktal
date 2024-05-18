export const Sidebar = {
    elements: {
        sidebar: null,
        burger: null,
        darkBackground: null
    },
    shown: false,

    /**
     * Initialize the sidebar
     * @param sidebarSelector Selector string for the sidebar menu
     * @param burgerSelector Selector string for the burger div
     * @param darkBackgroundSelector Selector string for the dark background
     */
    init: (sidebarSelector, burgerSelector, darkBackgroundSelector) => {
        // Save the sidebar elements
        Sidebar.elements.sidebar = $(sidebarSelector);
        Sidebar.elements.burger = $(burgerSelector);
        Sidebar.elements.darkBackground = $(darkBackgroundSelector);
        Sidebar.shown = false;

        Sidebar.setupListeners();
    },

    /**
     * Set up the event listeners for the sidebar
     */
    setupListeners: () => {
        Sidebar.elements.burger.click((event) => {
            Sidebar.toggleSidebar();
        });
    },

    /**
     * Toggle the sidebar visibility
     */
    toggleSidebar: () => {
        // Toggle navigator
        Sidebar.elements.sidebar.toggleClass("header-navigator-default");
        Sidebar.elements.sidebar.toggleClass("header-navigator-active");

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
