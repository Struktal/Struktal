let elements = {
    sidebar: null,
    burger: null,
    darkBackground: null
}
let shown = false;

/**
 * Initialize the sidebar
 */
export const init = () => {
    updateClasses();

    document.querySelectorAll(".sidebar-toggle").forEach((element) => {
        element.addEventListener("click", () => {
            toggle();
        });
    });
}

export const updateClasses = (element) => {
    const sidebar = document.querySelector("[data-sidebar-active]");
    const isActive = sidebar.hasAttribute("data-sidebar-active") && sidebar.getAttribute("data-sidebar-active") === "true";

    document.querySelectorAll("[data-sidebar-active-classes]").forEach((element) => {
        element.getAttribute("data-sidebar-active-classes").split(" ").forEach((cls) => {
            if(isActive) {
                element.classList.add(cls);
            } else {
                element.classList.remove(cls);
            }
        });
    });
    document.querySelectorAll("[data-sidebar-inactive-classes]").forEach((element) => {
        element.getAttribute("data-sidebar-inactive-classes").split(" ").forEach((cls) => {
            if(isActive) {
                element.classList.remove(cls);
            } else {
                element.classList.add(cls);
            }
        });
    });
}

export const toggle = () => {
    const sidebar = document.querySelector("[data-sidebar-active]");
    const isActive = sidebar.hasAttribute("data-sidebar-active") && sidebar.getAttribute("data-sidebar-active") === "true";

    if(isActive) {
        sidebar.setAttribute("data-sidebar-active", "false");
    } else {
        sidebar.setAttribute("data-sidebar-active", "true");
    }

    updateClasses();
}

/**
 * Open the sidebar
 */
export const open = () => {
    // Show sidebar
    document.querySelector(".header-sidebar-popup").classList.remove("translate-x-full", "hidden");
    document.querySelector(".header-sidebar-background").classList.remove("hidden");

    // Disable scrolling
    document.querySelector("html").scrollTop = window.scrollY;
    document.body.style.overflow = "hidden";
    document.body.style.position = "relative";
    document.querySelector("html").style.overflow = "hidden";
    document.querySelector("html").style.position = "relative";
}

/**
 * Close the sidebar
 */
export const close = () => {
    // Hide sidebar
    document.querySelector(".header-sidebar-popup").classList.add("translate-x-full");
    setTimeout(() => {
        document.querySelector(".header-sidebar-popup").classList.add("hidden");
    }, 500);
    document.querySelector(".header-sidebar-background").classList.add("hidden");

    // Enable scrolling
    document.body.style.overflow = null;
    document.body.style.position = null;
    document.querySelector("html").style.overflow = null;
    document.querySelector("html").style.position = null;
}

export default { init, open, close };
