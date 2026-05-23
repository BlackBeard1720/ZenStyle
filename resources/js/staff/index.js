import "jsvectormap/dist/jsvectormap.min.css";
import "flatpickr/dist/flatpickr.min.css";
import "dropzone/dist/dropzone.css";
import "../../css/staff.css";

import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import flatpickr from "flatpickr";
import Dropzone from "dropzone";

import chart01 from "./components/charts/chart-01";
import chart02 from "./components/charts/chart-02";
import chart03 from "./components/charts/chart-03";
import map01 from "./components/map-01";
import "./components/calendar-init.js";
import "./components/image-resize";

Alpine.plugin(persist);
window.Alpine = Alpine;
Alpine.start();

// Init flatpickr
flatpickr(".datepicker", {
    mode: "range",
    static: true,
    monthSelectorType: "dropdown",
    dateFormat: "Y-m-d",
    conjunction: " - ",
    allowInput: true,
    //defaultDate: [new Date().setDate(new Date().getDate() - 6), new Date()],
    prevArrow:
        '<svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.25 6L9 12.25L15.25 18.5" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    nextArrow:
        '<svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.75 19L15 12.75L8.75 6.5" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    onReady: (selectedDates, dateStr, instance) => {
        // eslint-disable-next-line no-param-reassign
        instance.element.value = dateStr.replace("to", "-");
        const customClass = instance.element.getAttribute("data-class");
        instance.calendarContainer.classList.add(customClass);
    },
    onChange: (selectedDates, dateStr, instance) => {
        // eslint-disable-next-line no-param-reassign
        instance.element.value = dateStr.replace("to", "-");
    },
});

flatpickr(".appointment-datepicker", {
    dateFormat: "Y-m-d",
    allowInput: true,
    clickOpens: true,
    static: true,
    monthSelectorType: "static",
    prevArrow:
        '<svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.25 6L9 12.25L15.25 18.5" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    nextArrow:
        '<svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.75 19L15 12.75L8.75 6.5" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
});

flatpickr(".appointment-timepicker", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true,
    allowInput: true,
    clickOpens: true,
    static: true,
});

// Init Dropzone
const dropzoneArea = document.querySelectorAll("#demo-upload");

if (dropzoneArea.length) {
    let myDropzone = new Dropzone("#demo-upload", { url: "/file/post" });
}

// Document Loaded
document.addEventListener("DOMContentLoaded", () => {
    chart01();
    chart02();
    chart03();
    map01();

    // Attach dashboard dynamic fetch handlers
    const dateInput = document.querySelector('.datepicker');
    const groupSelect = document.getElementById('dashboard-group');
    const quick7 = document.getElementById('quick-7');
    const quick30 = document.getElementById('quick-30');
    const quickMonth = document.getElementById('quick-month');
    const quickYear = document.getElementById('quick-year');

    async function fetchDashboardData(from, to, group) {
        const params = new URLSearchParams();
        if (from) params.set('from_date', from);
        if (to) params.set('to_date', to);
        if (group) params.set('group', group);

        const res = await fetch('/staff/dashboard/data?' + params.toString(), {
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });

        if (!res.ok) throw new Error('Failed to fetch dashboard data');

        return res.json();
    }

    function updateCharts(payload) {
        if (!payload) return;
        const revenue = payload.revenue;
        const appointments = payload.appointments;

        // Update global object
        window.revenueChartData = revenue;

        if (window.charts && window.charts.revenueChart) {
            window.charts.revenueChart.updateOptions({ xaxis: { categories: revenue.labels } });
            window.charts.revenueChart.updateSeries([{ data: revenue.values }]);
        }

        if (window.charts && window.charts.appointmentChart) {
            window.charts.appointmentChart.updateOptions({ xaxis: { categories: appointments.labels } });
            window.charts.appointmentChart.updateSeries([{ data: appointments.values }]);
        }
    }

    if (dateInput) {
        dateInput.addEventListener('change', async (e) => {
            const val = e.target.value;
            if (!val) return;
            const parts = val.split(' - ');
            if (parts.length === 2) {
                try {
                    const payload = await fetchDashboardData(parts[0], parts[1], 'day');
                    updateCharts(payload);
                } catch (err) {
                    // eslint-disable-next-line no-console
                    console.error(err);
                }
            }
        });
    }

    if (groupSelect) {
        groupSelect.addEventListener('change', async (e) => {
            const group = e.target.value;
            try {
                const payload = await fetchDashboardData(null, null, group);
                updateCharts(payload);
            } catch (err) {
                // eslint-disable-next-line no-console
                console.error(err);
            }
        });
    }

    const attachQuick = (el, days, group) => {
        if (!el) return;
        el.addEventListener('click', async () => {
            const to = new Date();
            const from = new Date();
            from.setDate(to.getDate() - days + 1);
            const f = from.toISOString().slice(0,10);
            const t = to.toISOString().slice(0,10);
            try {
                const payload = await fetchDashboardData(f, t, group || 'day');
                // update date input value shown
                if (dateInput) dateInput.value = f + ' - ' + t;
                updateCharts(payload);
            } catch (err) {
                // eslint-disable-next-line no-console
                console.error(err);
            }
        });
    };

    attachQuick(quick7, 7, 'day');
    attachQuick(quick30, 30, 'day');
    attachQuick(quickMonth, 30, 'month');
    attachQuick(quickYear, 365, 'year');
});

// Get the current year
const year = document.getElementById("year");
if (year) {
    year.textContent = new Date().getFullYear();
}

// For Copy//
document.addEventListener("DOMContentLoaded", () => {
    const copyInput = document.getElementById("copy-input");
    if (copyInput) {
        // Select the copy button and input field
        const copyButton = document.getElementById("copy-button");
        const copyText = document.getElementById("copy-text");
        const websiteInput = document.getElementById("website-input");

        // Event listener for the copy button
        copyButton.addEventListener("click", () => {
            // Copy the input value to the clipboard
            navigator.clipboard.writeText(websiteInput.value).then(() => {
                // Change the text to "Copied"
                copyText.textContent = "Copied";

                // Reset the text back to "Copy" after 2 seconds
                setTimeout(() => {
                    copyText.textContent = "Copy";
                }, 2000);
            });
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const searchButton = document.getElementById("search-button");

    // Function to focus the search input
    function focusSearchInput() {
        searchInput.focus();
    }

    // Add click event listener to the search button
    searchButton.addEventListener("click", focusSearchInput);

    // Add keyboard event listener for Cmd+K (Mac) or Ctrl+K (Windows/Linux)
    document.addEventListener("keydown", function (event) {
        if ((event.metaKey || event.ctrlKey) && event.key === "k") {
            event.preventDefault(); // Prevent the default browser behavior
            focusSearchInput();
        }
    });

    // Add keyboard event listener for "/" key
    document.addEventListener("keydown", function (event) {
        if (event.key === "/" && document.activeElement !== searchInput) {
            event.preventDefault(); // Prevent the "/" character from being typed
            focusSearchInput();
        }
    });
});
