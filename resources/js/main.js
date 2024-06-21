function screenWidth() {
    if (window.innerWidth < 1281) {
        document.getElementById("menuCollapse").style.display = "none";
        document.querySelector(".app-header").classList.add("margin-0");
        document.querySelector(".site-footer").classList.add("margin-0");
        document.querySelector("#content_wrapper").classList.add("margin-0");
        document.querySelector(".sidebarCloseIcon").style.display = "block";
        document.querySelector("#sidebar_type").style.display = "none";
        document.querySelector("#bodyOverlay").classList.add("block");
    } else {
        // document.getElementById("menuCollapse").style.display = "block";
        document.querySelector(".app-header").classList.remove("margin-0");
        document.querySelector(".site-footer").classList.remove("margin-0");
        document.querySelector("#content_wrapper").classList.remove("margin-0");
        document.querySelector(".sidebarCloseIcon").style.display = "none";
        document.querySelector("#sidebar_type").style.display = "block";
        document.querySelector("#bodyOverlay").classList.remove("block");
    }
}

screenWidth();
window.addEventListener("resize", screenWidth);

// sidebar
function sidebarMenu(menu) {
    const subMenuSelector = '.sidebar-submenu';
    menu.addEventListener('click', function (e) {
        const target = e.target;
        const checkElement = target.nextElementSibling;

        if (checkElement.matches(subMenuSelector) && checkElement.style.display === 'block') {
            checkElement.style.display = 'none';
            checkElement.classList.remove('menu-open');
            checkElement.parentElement.classList.remove('active');
        } else if (checkElement.matches(subMenuSelector) && checkElement.style.display !== 'block') {
            const parent = target.closest('ul');
            const visibleMenus = parent.querySelectorAll('ul:not([style="display: none;"])');

            visibleMenus.forEach((ul) => {
                ul.style.display = 'none';
                ul.classList.remove('menu-open');
            });

            const parentLi = target.parentElement;
            checkElement.style.display = 'block';
            checkElement.classList.add('menu-open');
            parent.querySelectorAll('li.active').forEach((li) => li.classList.remove('active'));
            parentLi.classList.add('active');
        }

        if (checkElement.matches(subMenuSelector)) {
            e.preventDefault();
        }
    });
}

const sidebarMenuElement = document.querySelector('.sidebar-menu');
const html = document.querySelector('html');
sidebarMenu(sidebarMenuElement);

// navbar
if (localStorage.navbar === "floating") {
    document.getElementById("nav_floating").checked = true;
    html.classList.remove("nav-sticky", "nav-hidden", "nav-static");
    html.classList.add("nav-floating");
} else if (localStorage.navbar === "sticky") {
    document.getElementById("nav_sticky").checked = true;
    html.classList.remove("nav-floating", "nav-hidden", "nav-static");
    html.classList.add("nav-sticky");
} else if (localStorage.navbar === "hidden") {
    document.getElementById("nav_hidden").checked = true;
    html.classList.remove("nav-floating", "nav-static", "nav-sticky");
    html.classList.add("nav-hidden");
} else {
    document.getElementById("nav_static").checked = true;
    html.classList.remove("nav-floating", "nav-hidden", "nav-sticky");
    html.classList.add("nav-static");
}

// Sidebar Type Local Storage save
const appWrapper = document.querySelector('.app-wrapper');
const menuCheckbox = document.querySelector('#menuCollapse input[type="checkbox"]');

if (localStorage.sideBarType === "extend") {
    appWrapper.classList.add(localStorage.sideBarType);
} else if (localStorage.sideBarType === "collapsed") {
    appWrapper.classList.remove('extend');
    appWrapper.classList.add('collapsed');
    menuCheckbox.checked = true;
}

// Simple Bar
new SimpleBar(document.getElementById('sidebar_menus'));

document.querySelector('.sidebarCloseIcon').addEventListener('click', function () {
    document.querySelector('.sidebar-wrapper').classList.remove('sidebar-open');
    document.querySelector('#bodyOverlay').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
});


const rootEl = document.documentElement;
/*=======================================
  GET RTL/LTR VALUE FROM LOCAL STORAGE
=======================================*/
// Check if the value of the "effect" key in the local storage is "grayScale"
if (localStorage.dir === "rtl") {
    // If it is, add the "grayScale" class to the "html" element
    rootEl.dir = "rtl";
} else {
    // If it's not, remove the "grayScale" class from the "html" element
    rootEl.dir = "ltr";
}

let currentTheme = localStorage.getItem("theme");
const themes = [{
    name: "dark",
    class: "dark",
    checked: false,
},
    {
        name: "semiDark",
        class: "semiDark",
        checked: false,
    },
    {
        name: "light",
        class: "light",
        checked: false,
    },
];

themes.forEach((theme) => {
    const radioBtn = document.querySelector(`#${theme.class}`);
    radioBtn.checked = theme.name === currentTheme;
    radioBtn.addEventListener("change", function () {
        if (this.checked) {
            currentTheme = theme.name;
            localStorage.theme = theme.name;
            location.reload();
        }
    });
});

const themeMode = localStorage.getItem("theme");
const sidebar = document.querySelector(".sidebar-wrapper");
if (themeMode === "dark") {
    rootEl.classList.add("dark");
    rootEl.classList.remove("light");
    rootEl.classList.remove("semiDark");
} else if (themeMode === "semiDark") {
    rootEl.classList.add("semiDark");
    rootEl.classList.add("light");
    rootEl.classList.remove("dark");
} else {
    rootEl.classList.add(themeMode);
    rootEl.classList.remove("dark");
    rootEl.classList.remove("semiDark");
}

document.getElementById('nav_floating').addEventListener('change', function () {
    html.classList.remove("nav-sticky", "nav-hidden", "nav-static");
    html.classList.add("nav-floating");
    localStorage.navbar = "floating";
})

document.getElementById('nav_sticky').addEventListener('change', function () {
    html.classList.remove("nav-floating", "nav-hidden", "nav-static");
    html.classList.add("nav-sticky");
    localStorage.navbar = "sticky";
})

document.getElementById('nav_static').addEventListener('change', function () {
    html.classList.remove("nav-floating", "nav-hidden", "nav-sticky");
    html.classList.add("nav-static");
    localStorage.navbar = "static";
})

document.getElementById('nav_hidden').addEventListener('change', function () {
    html.classList.remove("nav-floating", "nav-static", "nav-sticky");
    html.classList.add("nav-hidden");
    localStorage.navbar = "hidden";
})

// RTL and LTR
// Direction Type Local Storage
let rtlCheckBox = document.querySelector('#rtl_ltr input[type=checkbox]');
if (localStorage.dir === "rtl") {
    rtlCheckBox.setAttribute("checked", 'true');
    document.getElementById('offcanvas').classList.remove('offcanvas-end');
    document.getElementById('offcanvas').classList.add('offcanvas-start');
}

// Change Direction

document.querySelector('#rtl_ltr input[type=checkbox]').addEventListener('click', function () {
    if (rtlCheckBox.checked) {
        html.setAttribute("dir", "rtl");
        localStorage.dir = "rtl";
        // location.reload();
    } else {
        html.setAttribute("dir", "ltr");
        localStorage.dir = "ltr";
        // location.reload();
    }
})

let boxed = document.getElementById('boxed');
let fullWidth = document.getElementById('fullWidth');
if (localStorage.contentLayout === "layout-boxed") {
    boxed.setAttribute("checked", 'true');
} else {
    fullWidth.setAttribute("checked", 'true');
}

// Content layout Changing options
fullWidth.addEventListener('change', function () {
    html.classList.remove("layout-boxed");
    localStorage.contentLayout = "layout-full";
})
boxed.addEventListener('change', function () {
    html.classList.add("layout-boxed");
    localStorage.contentLayout = "layout-boxed";
})

// Menu Layout toggle
let horizontalMenu = document.getElementById('horizontal_menu');
let verticalMenu = document.getElementById('vertical_menu');
if (localStorage.menuLayout === "horizontalMenu") {
    horizontalMenu.setAttribute("checked", 'true');
} else {
    verticalMenu.setAttribute("checked", 'true');
}

// Menu Layout Changing options
verticalMenu.addEventListener("change", function () {
    html.classList.remove("horizontalMenu");
    localStorage.menuLayout = "";
});
horizontalMenu.addEventListener("change", function () {
    html.classList.add("horizontalMenu");
    localStorage.menuLayout = "horizontalMenu";
});

// Footer Area
// Check local storage and set Footer Style
const footer = document.getElementById("footer");
const footerSticky = document.getElementById("footer_sticky");
const footerHidden = document.getElementById("footer_hidden");
const footerStatic = document.getElementById("footer_static");

if (localStorage.footer === "sticky") {
    footer.classList.add(localStorage.footer, "bottom-0");
    footerSticky.setAttribute('checked', 'true');
} else if (localStorage.footer === "hidden") {
    footer.classList.add(localStorage.footer);
    footerHidden.setAttribute('checked', 'true');
} else {
    footer.classList.add("static");
    footerStatic.setAttribute('checked', 'true');
}
// Footer Changing options
footerStatic.addEventListener("change", function () {
    footer.classList.remove("sticky", "bottom-0", "hidden");
    footer.classList.add("static");
    localStorage.footer = "static";
});

footerSticky.addEventListener("change", function () {
    footer.classList.remove("static", "hidden");
    footer.classList.add("sticky", "bottom-0");
    localStorage.footer = "sticky bottom-0";
});

footerHidden.addEventListener("change", function () {
    footer.classList.remove("sticky", "bottom-0", "static");
    footer.classList.add("hidden");
    localStorage.footer = "hidden";
});