/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./project/frontend/**/*.php"
    ],
    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            "background": {
                DEFAULT: "#ffffff",
                "header": "#ffffff",
                "footer": "#000000",
            },
            "font": {
                DEFAULT: "#000000",
                "light": "#aaaaaa",
                "invert": "#ffffff",
                "header": "#000000",
                "footer": "#666666"
            },
            "gray": {
                DEFAULT: "#aaaaaa",
                "light": "#dddddd",
                "dark": "#666666"
            },
            "primary": {
                DEFAULT: "#2f7cff",
                "effect": "#275fda",
                "font": "#ffffff"
            },
            "secondary": {
                DEFAULT: "#ff2f7c",
                "effect": "#da275f",
                "font": "#ffffff"
            },
            "infomessage": {
                "none": {
                    "border": "#444444ff",
                    "background": "#44444444"
                },
                "info": {
                    "border": "#275fdaff",
                    "background": "#275fda33"
                },
                "warning": {
                    "border": "#f3c033ff",
                    "background": "#f3c03344"
                },
                "error": {
                    "border": "#f45c4aff",
                    "background": "#f45c4a44"
                },
                "success": {
                    "border": "#4dbb5fff",
                    "background": "#4dbb5f44"
                }
            }
        },
        screens: {
            "sm": "640px",
            "md": "960px",
            "lg": "1440px"
        },
        extend: {
            spacing: {
                "content-padding-sm": "2.5%",
                "content-padding-md": "10%",
                "content-padding-lg": "15%",
                "header-logo-height": "5vh",
                "header-sidebar-width-sm": "90%",
                "header-sidebar-width-md": "55%",
                "header-sidebar-width-lg": "35%",
                "header-sidebar-padding": "2.5%",
            },
            zIndex: {
                "100": "100",
                "200": "200",
                "300": "300",
                "400": "400",
                "500": "500",
                "600": "600",
                "700": "700",
                "800": "800",
                "900": "900"
            }
        }
    },
    plugins: [],
    safelist: [
        {
            pattern: /^(bg|border)-infomessage-(info|warning|error|success)-(border|background)$/
        }
    ]
}

