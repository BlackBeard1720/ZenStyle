// ============================================================
// Toast notification nhe — hien o goc tren phai, tu dong tat
// ============================================================
let _toastContainer = null;

function getToastContainer() {
    if (_toastContainer) return _toastContainer;
    _toastContainer = document.createElement('div');
    _toastContainer.id = 'booking-toast-container';
    Object.assign(_toastContainer.style, {
        position: 'fixed',
        top: '80px',
        right: '16px',
        zIndex: '9999',
        display: 'flex',
        flexDirection: 'column',
        gap: '10px',
        pointerEvents: 'none',
    });
    document.body.appendChild(_toastContainer);
    return _toastContainer;
}

function showBookingToast(message, type = 'error') {
    const colors = {
        error:   { bg: '#fef2f2', border: '#fca5a5', text: '#991b1b', icon: '✕' },
        warning: { bg: '#fffbeb', border: '#fcd34d', text: '#92400e', icon: '⚠' },
        success: { bg: '#f0fdf4', border: '#86efac', text: '#166534', icon: '✓' },
    };
    const c = colors[type] ?? colors.error;
    const container = getToastContainer();

    const toast = document.createElement('div');
    Object.assign(toast.style, {
        display: 'flex',
        alignItems: 'flex-start',
        gap: '10px',
        background: c.bg,
        border: `1px solid ${c.border}`,
        borderRadius: '10px',
        padding: '12px 16px',
        boxShadow: '0 4px 16px rgba(0,0,0,0.10)',
        maxWidth: '340px',
        minWidth: '240px',
        pointerEvents: 'auto',
        opacity: '0',
        transform: 'translateX(24px)',
        transition: 'opacity 0.22s ease, transform 0.22s ease',
    });

    // Icon
    const icon = document.createElement('span');
    icon.textContent = c.icon;
    Object.assign(icon.style, {
        fontWeight: '700',
        fontSize: '14px',
        color: c.text,
        lineHeight: '1.5',
        flexShrink: '0',
        marginTop: '1px',
    });

    // Text
    const text = document.createElement('span');
    text.textContent = message;
    Object.assign(text.style, {
        fontSize: '13px',
        fontWeight: '500',
        color: c.text,
        lineHeight: '1.5',
        flex: '1',
    });

    // Close button
    const closeBtn = document.createElement('button');
    closeBtn.textContent = '×';
    Object.assign(closeBtn.style, {
        background: 'none',
        border: 'none',
        cursor: 'pointer',
        fontSize: '18px',
        lineHeight: '1',
        color: c.text,
        opacity: '0.6',
        padding: '0',
        flexShrink: '0',
        marginTop: '-1px',
    });

    toast.appendChild(icon);
    toast.appendChild(text);
    toast.appendChild(closeBtn);
    container.appendChild(toast);

    // Animate in
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateX(0)';
        });
    });

    function dismiss() {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(24px)';
        toast.addEventListener('transitionend', () => toast.remove(), { once: true });
    }

    closeBtn.addEventListener('click', dismiss);
    const timer = setTimeout(dismiss, 4000);
    closeBtn.addEventListener('click', () => clearTimeout(timer), { once: true });
}

const SEL = {
    page: '#booking-page',
    form: '#booking-form',
    dayBtn: '[data-booking-day]',
    slotBtn: '[data-booking-slot]',
    serviceCheckbox: '[data-booking-service-row] input[type="checkbox"]',
    dateInput: '#booking-date',
    stylistRadios: 'input[data-booking-stylist-radio]',
    stylistCards: '[data-booking-stylist-card]',
    stylistStatusLabel: '[data-stylist-status-label]',
    staffNameInput: '[data-booking-staff-name-input]',
    timeInput: '[data-booking-time-input]',
    serviceSearchInput: '#service-search',
    serviceSortSelect: '#service-sort',
    serviceTypeFilter: '[data-service-type-filter]',
    serviceRow: '[data-booking-service-row]',
    serviceList: '[data-service-list]',
    serviceFilterEmpty: '[data-service-filter-empty]',
};

const dayClasses = {
    sel: ['border-zen-primary', 'bg-zen-accent-soft', 'font-medium', 'text-zen-primary'],
    idle: ['border-zen-border', 'bg-white', 'text-zen-muted', 'hover:border-zen-primary/40'],
    disabled: ['cursor-not-allowed', 'border-zen-border', 'bg-zen-bg-soft', 'text-zen-muted/60', 'opacity-60'],
};

const slotClasses = {
    sel: ['border-zen-primary', 'bg-zen-accent-soft', 'font-medium', 'text-zen-primary'],
    idle: ['border-zen-border', 'bg-white', 'text-zen-muted', 'hover:border-zen-primary/50'],
    disabled: ['cursor-not-allowed', 'border-zen-border', 'bg-zen-bg-soft', 'text-zen-muted/60', 'opacity-60'],
};

const stylistClasses = {
    available: [
        'cursor-pointer',
        'hover:border-zen-primary/50',
        'hover:bg-zen-accent-soft/30',
        'aria-checked:border-zen-primary',
        'aria-checked:bg-zen-accent-soft',
    ],
    disabled: ['cursor-not-allowed', 'opacity-60', 'grayscale-[.15]'],
};

const stylistStatusClasses = {
    available: ['bg-zen-accent-soft', 'text-zen-primary', 'ring-zen-primary/20'],
    busy: ['bg-zen-warning/10', 'text-zen-warning', 'ring-zen-warning/20'],
};

function formatUsd(n) {
    return `$${Number(n).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    })}`;
}

function formatDateVi(isoDate) {
    if (!isoDate || !/^\d{4}-\d{2}-\d{2}$/.test(isoDate)) return '';
    const [y, m, d] = isoDate.split('-').map(Number);
    const dt = new Date(Date.UTC(y, m - 1, d));
    const days = ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];
    const label = days[dt.getUTCDay()];
    const dd = String(d).padStart(2, '0');
    const mm = String(m).padStart(2, '0');
    return `${label}, ${dd}/${mm}/${y}`;
}

function toggleClasses(el, active, map) {
    const on = active ? map.sel : map.idle;
    const off = active ? map.idle : map.sel;
    off.forEach((c) => el.classList.remove(c));
    on.forEach((c) => el.classList.add(c));
}

function localIsoDate(date = new Date()) {
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, '0');
    const d = String(date.getDate()).padStart(2, '0');

    return `${y}-${m}-${d}`;
}

function addDaysIso(isoDate, days) {
    const [y, m, d] = String(isoDate).split('-').map(Number);
    const date = new Date(y, m - 1, d);
    date.setDate(date.getDate() + days);

    return localIsoDate(date);
}

function currentMinuteOfDay(date = new Date()) {
    return date.getHours() * 60 + date.getMinutes();
}

function minutesFromSlot(slot) {
    const [h, m] = String(slot).split(':').map(Number);
    if (!Number.isFinite(h) || !Number.isFinite(m)) return null;

    return h * 60 + m;
}

function isValidIsoDate(isoDate) {
    return /^\d{4}-\d{2}-\d{2}$/.test(isoDate ?? '');
}

function isPastDate(isoDate, todayIso = localIsoDate()) {
    return isValidIsoDate(isoDate) && isoDate < todayIso;
}

function isPastSlot(isoDate, slot) {
    if (!isValidIsoDate(isoDate)) return true;

    const now = new Date();
    const todayIso = localIsoDate(now);
    if (isoDate < todayIso) return true;
    if (isoDate > todayIso) return false;

    const slotMinutes = minutesFromSlot(slot);
    if (slotMinutes === null) return true;

    return slotMinutes <= currentMinuteOfDay(now);
}

function setAvailability(el, disabled, map) {
    [...map.sel, ...map.idle, ...map.disabled].forEach((c) => el.classList.remove(c));

    if (disabled) {
        el.disabled = true;
        el.setAttribute('aria-disabled', 'true');
        el.setAttribute('aria-pressed', 'false');
        map.disabled.forEach((c) => el.classList.add(c));
        return;
    }

    el.disabled = false;
    el.removeAttribute('aria-disabled');
    toggleClasses(el, el.getAttribute('aria-pressed') === 'true', map);
}

function initBookingPage(root) {
    const form = root.querySelector(SEL.form);
    const summaryBranch = root.querySelector('#booking-summary-branch');
    const summaryTimeLine = root.querySelector('#booking-summary-time-line');
    const summaryDateLine = root.querySelector('#booking-summary-date-line');
    const summaryStylist = root.querySelector('#booking-summary-stylist');
    const summaryServicesEl = root.querySelector('#booking-summary-services');
    const summaryTotalEl = root.querySelector('#booking-summary-total');

    const dayButtons = [...root.querySelectorAll(SEL.dayBtn)];
    const slotButtons = [...root.querySelectorAll(SEL.slotBtn)];
    const dateInput = root.querySelector(SEL.dateInput);
    const staffNameInput = root.querySelector(SEL.staffNameInput);
    const timeInput = root.querySelector(SEL.timeInput);
    const busyStaffUrl = root.dataset.bookingBusyStaffUrl ?? '/booking/busy-staff';
    // Old time tu old() khi store() redirect back (OTP modal dang mo)
    const initialTime = root.dataset.initialTime ?? '';
    let busyStaffRequestId = 0;
    let busyStaffAbortController = null;
    let busyStaffDebounceTimer = null;

    // --- Service filter/sort ---
    const serviceSearchInput = root.querySelector(SEL.serviceSearchInput);
    const serviceSortSelect = root.querySelector(SEL.serviceSortSelect);
    const serviceTypeFilters = [...root.querySelectorAll(SEL.serviceTypeFilter)];
    const serviceRows = [...root.querySelectorAll(SEL.serviceRow)];
    const serviceList = root.querySelector(SEL.serviceList);
    const serviceFilterEmpty = root.querySelector(SEL.serviceFilterEmpty);

    function getSelectedServiceTypes() {
        const allCheckbox = serviceTypeFilters.find((cb) => cb.value === 'all');
        const selectedTypes = serviceTypeFilters
            .filter((cb) => cb.value !== 'all' && cb.checked)
            .map((cb) => cb.value);

        if (allCheckbox?.checked || selectedTypes.length === 0) {
            return ['all'];
        }

        return selectedTypes;
    }

    function applyServiceFilterAndSort() {
        const keyword = serviceSearchInput?.value.trim().toLowerCase() ?? '';
        const selectedTypes = getSelectedServiceTypes();
        const sortValue = serviceSortSelect?.value ?? 'default';
        let visibleCount = 0;

        serviceRows.forEach((row) => {
            const name = (row.dataset.serviceName ?? '').toLowerCase();
            const category = row.dataset.serviceCategory ?? '';

            const matchName = !keyword || name.includes(keyword);
            const matchType = selectedTypes.includes('all') || selectedTypes.includes(category);
            const shouldShow = matchName && matchType;

            row.hidden = !shouldShow;
            if (shouldShow) visibleCount += 1;
        });

        // Sap xep lai DOM theo tieu chi hien tai
        const sortedRows = [...serviceRows].sort((a, b) => {
            const nameA = a.dataset.serviceName ?? '';
            const nameB = b.dataset.serviceName ?? '';
            const priceA = Number(a.dataset.servicePrice ?? 0);
            const priceB = Number(b.dataset.servicePrice ?? 0);
            const orderA = Number(a.dataset.serviceOrder ?? 0);
            const orderB = Number(b.dataset.serviceOrder ?? 0);

            if (sortValue === 'price-asc') return priceA - priceB;
            if (sortValue === 'price-desc') return priceB - priceA;
            if (sortValue === 'name-asc') return nameA.localeCompare(nameB);
            if (sortValue === 'name-desc') return nameB.localeCompare(nameA);

            return orderA - orderB;
        });

        sortedRows.forEach((row) => serviceList?.appendChild(row));

        if (serviceFilterEmpty) {
            serviceFilterEmpty.hidden = visibleCount > 0;
        }
    }

    serviceSearchInput?.addEventListener('input', applyServiceFilterAndSort);
    serviceSortSelect?.addEventListener('change', applyServiceFilterAndSort);

    serviceTypeFilters.forEach((checkbox) => {
        checkbox.addEventListener('change', function () {
            const allCheckbox = serviceTypeFilters.find((item) => item.value === 'all');
            const typeCheckboxes = serviceTypeFilters.filter((item) => item.value !== 'all');

            if (this.value === 'all' && this.checked) {
                typeCheckboxes.forEach((item) => { item.checked = false; });
            }

            if (this.value !== 'all' && this.checked && allCheckbox) {
                allCheckbox.checked = false;
            }

            const hasSelectedType = typeCheckboxes.some((item) => item.checked);
            if (!hasSelectedType && allCheckbox) {
                allCheckbox.checked = true;
            }

            applyServiceFilterAndSort();
        });
    });

    applyServiceFilterAndSort();
    // --- End service filter/sort ---

    function selectedSlot() {
        return slotButtons.find((b) => b.getAttribute('aria-pressed') === 'true');
    }

    function selectedDay() {
        return dayButtons.find((b) => b.getAttribute('aria-pressed') === 'true');
    }

    function selectedDateIso() {
        return selectedDay()?.dataset.date ?? dateInput?.value ?? '';
    }

    function hasBookableSlotOnDate(isoDate) {
        if (!isValidIsoDate(isoDate)) return false;
        if (slotButtons.length === 0) return !isPastDate(isoDate);

        return slotButtons.some((btn) => !isPastSlot(isoDate, btn.dataset.slot));
    }

    function firstBookableDateIso(startIso = localIsoDate()) {
        const todayIso = localIsoDate();
        const safeStart = isValidIsoDate(startIso) && startIso > todayIso ? startIso : todayIso;

        for (let offset = 0; offset < 31; offset += 1) {
            const isoDate = addDaysIso(safeStart, offset);
            if (hasBookableSlotOnDate(isoDate)) return isoDate;
        }

        return safeStart;
    }

    function selectDayButton(btn) {
        dayButtons.forEach((b) => {
            const on = b === btn && !b.disabled;
            b.setAttribute('aria-pressed', on ? 'true' : 'false');
            setAvailability(b, b.disabled, dayClasses);
        });
    }

    function selectSlotButton(btn) {
        slotButtons.forEach((b) => {
            const on = b === btn && !b.disabled;
            b.setAttribute('aria-pressed', on ? 'true' : 'false');
            setAvailability(b, b.disabled, slotClasses);
        });
    }

    function ensureDateInputIsFutureSafe() {
        if (!dateInput) return firstBookableDateIso();

        const firstBookableDate = firstBookableDateIso();
        dateInput.min = firstBookableDate;

        if (
            !isValidIsoDate(dateInput.value) ||
            dateInput.value < firstBookableDate ||
            !hasBookableSlotOnDate(dateInput.value)
        ) {
            dateInput.value = firstBookableDateIso(dateInput.value);
        }

        return dateInput.value;
    }

    function syncDayAvailability() {
        const safeDate = ensureDateInputIsFutureSafe();
        let hasSelectedDay = false;

        dayButtons.forEach((btn) => {
            const disabled = isPastDate(btn.dataset.date) || !hasBookableSlotOnDate(btn.dataset.date);
            if (disabled) btn.setAttribute('aria-pressed', 'false');
            setAvailability(btn, disabled, dayClasses);
            hasSelectedDay ||= btn.getAttribute('aria-pressed') === 'true';
        });

        if (!hasSelectedDay) {
            const matchingBtn = dayButtons.find((btn) => btn.dataset.date === safeDate && !btn.disabled);
            if (matchingBtn) selectDayButton(matchingBtn);
        }
    }

    function syncSlotAvailability() {
        const dateIso = selectedDateIso();
        let hasSelectedSlot = false;

        slotButtons.forEach((btn) => {
            const disabled = isPastSlot(dateIso, btn.dataset.slot);
            if (disabled) btn.setAttribute('aria-pressed', 'false');
            setAvailability(btn, disabled, slotClasses);
            hasSelectedSlot ||= btn.getAttribute('aria-pressed') === 'true';
        });

        if (!hasSelectedSlot) {
            const firstAvailable = slotButtons.find((btn) => !btn.disabled);
            if (firstAvailable) selectSlotButton(firstAvailable);
        }
    }

    function updateDateTimeSummary() {
        const slot = selectedSlot()?.getAttribute('data-slot') ?? '—';
        const dayBtn = selectedDay();

        if (summaryTimeLine) summaryTimeLine.textContent = slot;
        if (timeInput) timeInput.value = slot === '—' ? '' : slot;

        if (summaryDateLine) {
            if (dayBtn?.dataset.summary) {
                summaryDateLine.textContent = dayBtn.dataset.summary;
            } else if (dateInput?.value) {
                summaryDateLine.textContent = formatDateVi(dateInput.value);
            } else {
                summaryDateLine.textContent = '—';
            }
        }
    }

    function isStylistAvailable(radio) {
        return radio?.dataset.stylistAvailable !== 'false' && radio?.disabled !== true;
    }

    function selectedAppointmentTime() {
        return timeInput?.value || selectedSlot()?.dataset.slot || '';
    }

    function setStylistStatusLabel(label, available) {
        if (!label) return;

        [...stylistStatusClasses.available, ...stylistStatusClasses.busy].forEach((className) => {
            label.classList.remove(className);
        });

        const statusClasses = available ? stylistStatusClasses.available : stylistStatusClasses.busy;
        statusClasses.forEach((className) => label.classList.add(className));
        label.textContent = available ? 'Available' : 'Busy';
    }

    function setStylistAvailability(card, available) {
        const radio = card.querySelector(SEL.stylistRadios);
        const statusLabel = card.querySelector(SEL.stylistStatusLabel);

        card.dataset.bookingStylistAvailable = available ? 'true' : 'false';
        card.setAttribute('aria-disabled', available ? 'false' : 'true');

        [...stylistClasses.available, ...stylistClasses.disabled].forEach((className) => {
            card.classList.remove(className);
        });

        const cardClasses = available ? stylistClasses.available : stylistClasses.disabled;
        cardClasses.forEach((className) => card.classList.add(className));

        if (radio) {
            radio.disabled = !available;
            radio.dataset.stylistAvailable = available ? 'true' : 'false';
            if (!available) radio.checked = false;
        }

        setStylistStatusLabel(statusLabel, available);
    }

    function applyBusyStaffAvailability(busyStaffIds = []) {
        const busyStaffIdSet = new Set(busyStaffIds.map((staffId) => String(staffId)));

        root.querySelectorAll(SEL.stylistCards).forEach((card) => {
            const baseAvailable = card.dataset.staffBaseAvailable !== 'false';
            const staffId = card.dataset.staffId ?? card.querySelector(SEL.stylistRadios)?.value ?? '';
            const available = baseAvailable && !busyStaffIdSet.has(String(staffId));

            setStylistAvailability(card, available);
        });

        syncStylistSummary();
    }

    async function refreshBusyStaffAvailability() {
        const appointmentDate = selectedDateIso();
        const appointmentTime = selectedAppointmentTime();

        if (!isValidIsoDate(appointmentDate) || !appointmentTime) {
            applyBusyStaffAvailability([]);
            return;
        }

        const requestId = busyStaffRequestId + 1;
        busyStaffRequestId = requestId;

        busyStaffAbortController?.abort();
        busyStaffAbortController = new AbortController();

        const params = new URLSearchParams({
            appointment_date: appointmentDate,
            appointment_time: appointmentTime,
        });

        try {
            const response = await fetch(`${busyStaffUrl}?${params.toString()}`, {
                headers: { Accept: 'application/json' },
                signal: busyStaffAbortController.signal,
            });

            if (!response.ok) throw new Error(`Busy staff request failed with ${response.status}`);

            const data = await response.json();
            if (requestId !== busyStaffRequestId) return;

            applyBusyStaffAvailability(Array.isArray(data.busy_staff_ids) ? data.busy_staff_ids : []);
        } catch (error) {
            if (error.name === 'AbortError') return;

            console.warn('Could not refresh busy staff availability.', error);
            if (requestId === busyStaffRequestId) applyBusyStaffAvailability([]);
        }
    }

    function scheduleBusyStaffRefresh(delay = 150) {
        window.clearTimeout(busyStaffDebounceTimer);
        busyStaffDebounceTimer = window.setTimeout(refreshBusyStaffAvailability, delay);
    }

    function syncStylistSummary() {
        const radios = [...root.querySelectorAll(SEL.stylistRadios)];
        let picked = radios.find((radio) => radio.checked) ?? null;

        if (picked && !isStylistAvailable(picked)) {
            picked.checked = false;
            picked = null;
        }

        if (!picked) {
            picked = radios.find(isStylistAvailable) ?? null;
            if (picked) picked.checked = true;
        }

        const labelEl = picked?.closest('label')?.querySelector('[data-stylist-label]');
        const stylistName = picked
            ? picked.dataset.stylistName ?? labelEl?.textContent?.trim() ?? '—'
            : 'Any staff member';

        root.dataset.selectedStylistId = picked?.value ?? '';
        root.dataset.selectedStylistName = stylistName;

        root.querySelectorAll(SEL.stylistCards).forEach((card) => {
            const radio = card.querySelector(SEL.stylistRadios);
            const available = isStylistAvailable(radio);
            if (!available && radio) radio.checked = false;

            const checked = available && radio?.checked === true;
            card.setAttribute('aria-checked', checked ? 'true' : 'false');
            card.setAttribute('aria-disabled', available ? 'false' : 'true');
        });

        if (summaryStylist) summaryStylist.textContent = stylistName;
        if (staffNameInput) staffNameInput.value = stylistName;
    }

    function syncServicesAndTotal() {
        if (!summaryServicesEl || !summaryTotalEl) return;

        const lis = [...root.querySelectorAll('[data-booking-service-row]')].filter((row) =>
            row.querySelector('input[type="checkbox"]:checked'),
        );

        summaryServicesEl.innerHTML = '';
        let total = 0;

        if (lis.length === 0) {
            const p = document.createElement('p');
            p.className = 'text-xs font-normal text-zen-muted';
            p.textContent = 'No services selected';
            summaryServicesEl.appendChild(p);
        } else {
            lis.forEach((li) => {
                const name = li.dataset.serviceName ?? '';
                const price = parseFloat(li.dataset.servicePrice ?? '0') || 0;
                total += price;

                const p = document.createElement('p');
                p.textContent = name;
                summaryServicesEl.appendChild(p);

                const sub = document.createElement('p');
                sub.className = 'mt-0.5 text-xs font-normal text-zen-muted';
                sub.textContent = formatUsd(price);
                summaryServicesEl.appendChild(sub);
            });
        }

        summaryTotalEl.textContent = formatUsd(total);
    }

    function syncAllSummaries() {
        syncDayAvailability();
        syncSlotAvailability();
        syncStylistSummary();
        updateDateTimeSummary();
        syncServicesAndTotal();
    }

    dayButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            if (btn.disabled) return;

            selectDayButton(btn);
            if (dateInput?.dataset.dateLinked !== 'false' && btn.dataset.date) {
                dateInput.value = btn.dataset.date;
            }
            syncSlotAvailability();
            updateDateTimeSummary();
            scheduleBusyStaffRefresh();
        });
    });

    slotButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            if (btn.disabled) return;

            selectSlotButton(btn);
            updateDateTimeSummary();
            refreshBusyStaffAvailability();
        });
    });

    dateInput?.addEventListener('input', () => {
        const safeDate = ensureDateInputIsFutureSafe();
        dayButtons.forEach((b) => {
            const on = b.dataset.date === safeDate && !b.disabled;
            b.setAttribute('aria-pressed', on ? 'true' : 'false');
        });
        syncDayAvailability();
        syncSlotAvailability();
        updateDateTimeSummary();
        scheduleBusyStaffRefresh();
    });

    root.querySelectorAll(SEL.serviceCheckbox).forEach((cb) =>
        cb.addEventListener('change', syncServicesAndTotal),
    );

    root.querySelectorAll(SEL.stylistCards).forEach((card) => {
        card.addEventListener('click', (event) => {
            if (isStylistAvailable(card.querySelector(SEL.stylistRadios))) return;

            event.preventDefault();
            syncStylistSummary();
        });
    });

    root.querySelectorAll(SEL.stylistRadios).forEach((radio) =>
        radio.addEventListener('change', () => {
            if (!isStylistAvailable(radio)) radio.checked = false;
            syncStylistSummary();
        }),
    );
    form?.addEventListener('submit', (e) => {
        const errors = [];

        // --- Helper: danh dau input loi ---
        function markFieldError(el) {
            if (!el) return;
            el.style.borderColor = '#f87171';
            el.style.boxShadow = '0 0 0 2px rgba(248,113,113,0.2)';
            function clearError() {
                el.style.borderColor = '';
                el.style.boxShadow = '';
                el.removeEventListener('input', clearError);
                el.removeEventListener('change', clearError);
            }
            el.addEventListener('input', clearError);
            el.addEventListener('change', clearError);
        }

        // 1. Phai chon it nhat 1 dich vu
        const checkedServices = root.querySelectorAll('[data-booking-service-row] input[type="checkbox"]:checked');
        if (checkedServices.length === 0) {
            errors.push({ msg: 'Please select at least one service.', scrollTo: root.querySelector('[data-service-list]') });
        }

        // 2. Phai chon khung gio
        if (!timeInput?.value) {
            errors.push({ msg: 'Please select a time slot.', scrollTo: root.querySelector('[aria-label="Start time"]') });
        }

        // 3. Validate Contact Information
        const fullNameEl = form.querySelector('[data-booking-field="full_name"]');
        const phoneEl    = form.querySelector('[data-booking-field="phone"]');
        const emailEl    = form.querySelector('[data-booking-field="email"]');

        if (!fullNameEl?.value.trim()) {
            errors.push({ msg: 'Full name is required.', scrollTo: fullNameEl });
            markFieldError(fullNameEl);
        }
        if (!phoneEl?.value.trim()) {
            errors.push({ msg: 'Phone number is required.', scrollTo: phoneEl });
            markFieldError(phoneEl);
        }
        if (!emailEl?.value.trim()) {
            errors.push({ msg: 'Email is required.', scrollTo: emailEl });
            markFieldError(emailEl);
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value.trim())) {
            errors.push({ msg: 'Please enter a valid email address.', scrollTo: emailEl });
            markFieldError(emailEl);
        }

        if (errors.length === 0) return; // Pass — cho form submit

        e.preventDefault();

        // Hien toast cho tung loi
        errors.forEach(({ msg }) => showBookingToast(msg, 'error'));

        // Scroll ve loi dau tien
        errors[0].scrollTo?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });

    form?.addEventListener('reset', () => {
        window.setTimeout(() => {
            const resetDate = ensureDateInputIsFutureSafe();
            dayButtons.forEach((btn) => {
                btn.setAttribute('aria-pressed', btn.dataset.date === resetDate ? 'true' : 'false');
            });
            slotButtons.forEach((btn) => {
                btn.setAttribute('aria-pressed', 'false');
            });

            syncAllSummaries();
            scheduleBusyStaffRefresh();
        });
    });

    ensureDateInputIsFutureSafe();
    if (summaryBranch) summaryBranch.textContent = 'ZenStyle FPT Aptech';

    // Pre-select slot tu old input (sau khi store() redirect back voi OTP modal)
    // Blade da restore old date vao date input, chi can pre-select dung slot
    // Phai danh dau aria-pressed truoc khi syncAllSummaries chay
    if (initialTime) {
        const targetSlot = slotButtons.find((btn) => btn.dataset.slot === initialTime);
        if (targetSlot) {
            slotButtons.forEach((b) => b.setAttribute('aria-pressed', 'false'));
            targetSlot.setAttribute('aria-pressed', 'true');
        }
    }

    syncAllSummaries();
    refreshBusyStaffAvailability();

    // Lang nghe event tu pageshow handler khi page restore tu bfcache
    root.addEventListener('booking:refresh-busy-staff', refreshBusyStaffAvailability);
}

export function initBookingIfPresent() {
    const root = document.querySelector(SEL.page);
    if (!root) return;

    initBookingPage(root);

    // Khi browser restore trang tu bfcache (nhan back sau redirect),
    // JS khong chay lai -> goi lai refreshBusyStaffAvailability de cap nhat trang thai busy/available.
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            // Lay lai ham tu closure cua initBookingPage da chay
            // Bang cach dispatch custom event de kich hoat refresh
            root.dispatchEvent(new CustomEvent('booking:refresh-busy-staff'));
        }
    });
}
