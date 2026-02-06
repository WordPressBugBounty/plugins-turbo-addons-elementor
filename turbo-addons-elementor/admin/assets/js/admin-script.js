jQuery(document).ready(function($) {
    // Tab switching logic
    $('.trad-tab-link').on('click', function(e) {
        e.preventDefault();

        // Remove active class from all tabs and content
        $('.trad-tab-link').removeClass('active');
        $('.trad-tab-content').removeClass('active');

        // Add active class to the clicked tab and corresponding content
        $(this).addClass('active');
        $('#' + $(this).data('tab')).addClass('active');

        // Set the current tab in the hidden input field
        $('#current_tab').val($(this).data('tab'));
        
    });

    // On page load, set the active tab from the hidden input value (if exists)
    var savedTab = $('#current_tab').val();
    if (savedTab) {
        // Remove active class from all tabs and content
        $('.trad-tab-link').removeClass('active');
        $('.trad-tab-content').removeClass('active');

        // Add active class to the saved tab and corresponding content
        $('.trad-tab-link[data-tab="' + savedTab + '"]').addClass('active');
        $('#' + savedTab).addClass('active');
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("turbo-dashboard-navbar");
    const contentDetails = document.getElementById("turbo-addons-content-details");
    const sidebarMenu = document.getElementById("turbo-addons-sidebar-menu");
    const toggleInput = document.getElementById("turbo-dashboard-navbar-theme-input");
    const storedTheme = localStorage.getItem("dashboardNavbarTheme");

    // Function to set text color based on background color
    function updateTextColor(element, backgroundColor) {
        if (backgroundColor === "dark") {
            element.style.color = "#eeeeee"; // White text for dark background
        } else {
            element.style.color = "#444444"; // Black text for light background
        }
    }

    // Function to update background and text color for all elements
    function updateColors(backgroundColor) {
        const bgColor = backgroundColor === "dark" ? "#333" : "#ffffff"; // Set background color
        navbar.style.backgroundColor = bgColor;
        contentDetails.style.backgroundColor = bgColor;
        const sidebgColor = backgroundColor === "dark" ? "#101112" : "#d7d7d761";
        sidebarMenu.style.backgroundColor = sidebgColor;

        // Update the text color for the navbar and content details
        updateTextColor(navbar, backgroundColor);
        updateTextColor(contentDetails, backgroundColor);

        // Update the text color for all anchor tags in the sidebar menu
        const anchors = sidebarMenu.querySelectorAll("a");
        anchors.forEach(anchor => updateTextColor(anchor, backgroundColor));

        // Update text color for <h1> and <p> tags in content details
        const headings = contentDetails.querySelectorAll("h1, p, a");
        headings.forEach(heading => updateTextColor(heading, backgroundColor));
    }

    // Apply the stored background color and text color on page load
    if (storedTheme) {
        updateColors(storedTheme); // Apply colors based on stored theme
        toggleInput.checked = storedTheme === "dark";
    }

    // Event listener for toggle change
    toggleInput.addEventListener("change", function () {
        if (toggleInput.checked) {
            // Set dark theme
            localStorage.setItem("dashboardNavbarTheme", "dark");
            updateColors("dark"); // Update colors for dark theme
        } else {
            // Set light theme
            localStorage.setItem("dashboardNavbarTheme", "light");
            updateColors("light"); // Update colors for light theme
        }
    });
});

jQuery(document).ready(function($) {
    $('.trad-alert-dismiss-button').on('click', function() {
        $(this).closest('.trad-alert-updated-div').fadeOut();
    });
});

jQuery(document).ready(function ($) {
    $('#adminmenu .toplevel_page_turbo_addons .wp-menu-image img').addClass('trad-turbo-addon-admin-dashboard-icon');
});


// plugin filter tab sections dom//

document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.trad-widget-tabs-list .trad-widget-filter-tab-item');
    const tabContents = document.querySelectorAll('.trad-widget-tabs-content .trad-widget-tab-content');

    // Ensure all tabs are visible by default
    tabContents.forEach(content => {
        content.classList.add('active');
    });

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const targetTab = tab.getAttribute('data-tab');

            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));

            // Add active class to clicked tab
            tab.classList.add('active');

            // Scroll to the corresponding tab content
            const targetContent = document.getElementById(targetTab);
            
            // Calculate offset to stop at the title
            const scrollOffset = targetContent.getBoundingClientRect().top + window.scrollY - 140; // Adjust the `-100` for a comfortable margin
            window.scrollTo({
                top: scrollOffset,
                behavior: 'smooth'
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const selectAllCheckbox = document.getElementById('select-all-widgets');
    const widgetCheckboxes = document.querySelectorAll('.widget-checkbox');

    // Function to update the "Select All" checkbox state
    function updateSelectAllCheckbox() {
        selectAllCheckbox.checked = Array.from(widgetCheckboxes).every(checkbox => checkbox.checked);
    }

    // Function to update individual checkboxes based on "Select All"
    function toggleAllCheckboxes(state) {
        widgetCheckboxes.forEach(checkbox => {
            checkbox.checked = state;
        });
    }

    // Set initial state on page load
    updateSelectAllCheckbox();

    // Add event listener to "Select All" checkbox
    selectAllCheckbox.addEventListener('change', function () {
        toggleAllCheckboxes(selectAllCheckbox.checked);
    });

    // Add event listener to each individual checkbox
    widgetCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectAllCheckbox);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const selectAllExtensions = document.getElementById('select-all-extensions');
    const extensionCheckboxes = document.querySelectorAll('.extension-checkbox');

    // ✅ If extension tab exists
    if (selectAllExtensions && extensionCheckboxes.length > 0) {

        // Update "Select All" when individual checkbox changes
        function updateSelectAllExtension() {
            selectAllExtensions.checked = Array.from(extensionCheckboxes).every(chk => chk.checked);
        }

        // Toggle all extensions
        function toggleAllExtensions(state) {
            extensionCheckboxes.forEach(chk => { chk.checked = state; });
        }

        // ✅ Initial state (page load)
        updateSelectAllExtension();

        // ✅ "Select All" checkbox behavior
        selectAllExtensions.addEventListener('change', function () {
            toggleAllExtensions(selectAllExtensions.checked);
        });

        // ✅ Individual checkbox behavior
        extensionCheckboxes.forEach(chk => {
            chk.addEventListener('change', updateSelectAllExtension);
        });
    }
});

/*****************************************************************************************/








