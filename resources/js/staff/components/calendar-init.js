import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.querySelector("#calendar");

    if (!calendarEl || calendarEl.dataset.attendanceCalendar !== "true") {
        return;
    }

    const modal = document.getElementById("attendanceModal");
    const idInput = document.getElementById("attendance-id");
    const staffSelect = document.getElementById("attendance-staff-id");
    const workDateInput = document.getElementById("attendance-work-date");
    const statusSelect = document.getElementById("attendance-status");
    const checkInInput = document.getElementById("attendance-check-in");
    const checkOutInput = document.getElementById("attendance-check-out");
    const workingHoursInput = document.getElementById("attendance-working-hours");
    const overtimeHoursInput = document.getElementById("attendance-overtime-hours");
    const noteInput = document.getElementById("attendance-note");
    const saveButton = document.getElementById("attendance-save-button");
    const modalTitle = document.getElementById("attendanceModalTitle");
    const errorBox = document.getElementById("attendance-modal-error");

    if (
        !modal ||
        !idInput ||
        !staffSelect ||
        !workDateInput ||
        !statusSelect ||
        !checkInInput ||
        !checkOutInput ||
        !workingHoursInput ||
        !overtimeHoursInput ||
        !noteInput ||
        !saveButton ||
        !modalTitle ||
        !errorBox
    ) {
        return;
    }

    const calendarClassMap = {
        Danger: "danger",
        Success: "success",
        Primary: "primary",
        Warning: "warning",
    };

    const statusCalendarMap = {
        present: "Success",
        late: "Warning",
        absent: "Danger",
        leave: "Primary",
    };

    const eventsUrl = calendarEl.dataset.eventsUrl;
    const storeUrl = calendarEl.dataset.storeUrl;
    const updateUrlTemplate = calendarEl.dataset.updateUrlTemplate;
    const csrfToken = calendarEl.dataset.csrfToken;

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        selectable: true,
        initialView: "dayGridMonth",
        headerToolbar: {
            left: "prev,next addAttendanceButton",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        events(fetchInfo, successCallback, failureCallback) {
            const url = new URL(eventsUrl, window.location.origin);
            url.searchParams.set("start", fetchInfo.startStr.slice(0, 10));
            url.searchParams.set("end", fetchInfo.endStr.slice(0, 10));

            fetch(url, {
                headers: {
                    Accept: "application/json",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Could not load attendance events.");
                    }

                    return response.json();
                })
                .then(successCallback)
                .catch(failureCallback);
        },
        select(info) {
            openCreateModal(info.startStr.slice(0, 10));
        },
        dateClick(info) {
            openCreateModal(info.dateStr);
        },
        eventClick(info) {
            info.jsEvent.preventDefault();
            openEditModal(info.event);
        },
        customButtons: {
            addAttendanceButton: {
                text: "Add Attendance +",
                click() {
                    openCreateModal(formatDate(new Date()));
                },
            },
        },
        eventClassNames({ event }) {
            const calendarValue =
                event.extendedProps.calendar ||
                statusCalendarMap[event.extendedProps.status] ||
                "Primary";
            const colorValue = calendarClassMap[calendarValue] || "primary";

            return ["event-fc-color", `fc-bg-${colorValue}`];
        },
    });

    calendar.render();

    saveButton.addEventListener("click", saveAttendance);
    statusSelect.addEventListener("change", syncTimeFields);

    document.querySelectorAll(".attendance-modal-close").forEach((button) => {
        button.addEventListener("click", closeModal);
    });

    function openCreateModal(dateValue) {
        resetForm();
        modalTitle.textContent = "Add Attendance";
        workDateInput.value = dateValue;
        openModal();
    }

    function openEditModal(event) {
        const props = event.extendedProps;

        resetForm();
        modalTitle.textContent = "Edit Attendance";
        idInput.value = event.id || props.attendance_id || "";
        staffSelect.value = props.staff_id || "";
        workDateInput.value = event.startStr.slice(0, 10);
        statusSelect.value = props.status || "present";
        checkInInput.value = props.check_in || "";
        checkOutInput.value = props.check_out || "";
        workingHoursInput.value = props.working_hours ?? "";
        overtimeHoursInput.value = props.overtime_hours ?? "";
        noteInput.value = props.note || "";
        syncTimeFields();
        openModal();
    }

    function openModal() {
        hideError();
        modal.style.display = "flex";
    }

    function closeModal() {
        modal.style.display = "none";
        resetForm();
    }

    function resetForm() {
        idInput.value = "";
        staffSelect.value = "";
        workDateInput.value = "";
        statusSelect.value = "present";
        checkInInput.value = "";
        checkOutInput.value = "";
        workingHoursInput.value = "";
        overtimeHoursInput.value = "";
        noteInput.value = "";
        saveButton.disabled = false;
        saveButton.textContent = "Save Attendance";
        syncTimeFields();
        hideError();
    }

    function syncTimeFields() {
        const isAbsentLike =
            statusSelect.value === "absent" || statusSelect.value === "leave";
        const timeFields = [
            checkInInput,
            checkOutInput,
            workingHoursInput,
            overtimeHoursInput,
        ];

        timeFields.forEach((field) => {
            field.disabled = isAbsentLike;
            field.classList.toggle("opacity-60", isAbsentLike);
        });

        if (isAbsentLike) {
            checkInInput.value = "";
            checkOutInput.value = "";
            workingHoursInput.value = "0";
            overtimeHoursInput.value = "0";
        }
    }

    async function saveAttendance() {
        hideError();
        saveButton.disabled = true;
        saveButton.textContent = "Saving...";

        const attendanceId = idInput.value;
        const url = attendanceId
            ? updateUrlTemplate.replace("__ID__", encodeURIComponent(attendanceId))
            : storeUrl;

        try {
            const response = await fetch(url, {
                method: attendanceId ? "PATCH" : "POST",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify(formPayload()),
            });

            const body = await response.json().catch(() => ({}));

            if (!response.ok) {
                showError(firstError(body) || body.message || "Could not save attendance.");
                return;
            }

            calendar.refetchEvents();
            closeModal();
        } catch (error) {
            showError("Could not save attendance.");
        } finally {
            saveButton.disabled = false;
            saveButton.textContent = "Save Attendance";
        }
    }

    function formPayload() {
        return {
            staff_id: staffSelect.value || null,
            work_date: workDateInput.value || null,
            status: statusSelect.value,
            check_in: checkInInput.value || null,
            check_out: checkOutInput.value || null,
            working_hours: workingHoursInput.value || null,
            overtime_hours: overtimeHoursInput.value || null,
            note: noteInput.value || null,
        };
    }

    function showError(message) {
        errorBox.textContent = message;
        errorBox.classList.remove("hidden");
    }

    function hideError() {
        errorBox.textContent = "";
        errorBox.classList.add("hidden");
    }

    function firstError(body) {
        if (!body.errors) {
            return null;
        }

        const errors = Object.values(body.errors).flat();

        return errors[0] || null;
    }

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, "0");
        const day = String(date.getDate()).padStart(2, "0");

        return `${year}-${month}-${day}`;
    }
});
