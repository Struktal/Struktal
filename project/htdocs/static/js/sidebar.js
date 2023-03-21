class Sidebar {
    /**
     * Sidebar Constructor
     * @param sidebarSelector Selector String for the Sidebar Menu
     * @param burgerSelector Selector String for the Burger div
     * @param darkBackgroundSelector Selector String for the dark Background
     */
    constructor(sidebarSelector, burgerSelector, darkBackgroundSelector) {
        // Save the Sidebar Element
        this.sidebarElement = $(sidebarSelector);
        this.burgerElement = $(burgerSelector);
        this.darkBackgroundElement = $(darkBackgroundSelector);
        this.shown = false;

        // Constructor
        this.init();
    }

    /**
     * Initialize the Sidebar
     */
    init() {
        // Bind the Toggle Event
        this.burgerElement.click((event) => {
            this.toggleSidebar();
        });
    }

    /**
     * Toggle the Sidebar and dark Background
     */
    toggleSidebar() {
        // Toggle Navigator
        this.sidebarElement.toggleClass("header-navigator-default");
        this.sidebarElement.toggleClass("header-navigator-active");

        // Toggle dark Background
        this.darkBackgroundElement.toggleClass("header-dark-background-default");
        this.darkBackgroundElement.toggleClass("header-dark-background-active");

        // Change Burger
        this.burgerElement.toggleClass("close");

        // Toggle Scrolling
        if(this.shown) {
            document.body.style.overflow = null;
            document.body.style.position = null;
            document.querySelector('html').style.overflow = null;
            document.querySelector('html').style.position = null;

            this.shown = false;
        } else {
            document.querySelector('html').scrollTop = window.scrollY;
            document.body.style.overflow = 'hidden';
            document.body.style.position = 'relative';
            document.querySelector('html').style.overflow = 'hidden';
            document.querySelector('html').style.position = 'relative';

            this.shown = true;
        }
    }
}