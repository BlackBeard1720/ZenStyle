const SEL = {
    page: '#booking-page',
    form: '#booking-form',
    dayBtn: '[data-booking-day]',
    slotBtn: '[data-booking-slot]',
    serviceCheckbox: '[data-booking-service-row] input[type="checkbox"]',
    promoBtn: '[data-booking-promo-apply]',
    promoInput: '[data-booking-promo-input]',
    promoHint: '[data-booking-promo-hint]',
    dateInput: '#booking-date',
    stylistRadios: 'input[data-booking-stylist-radio]',
    staffNameInput: '[data-booking-staff-name-input]',
    timeInput: '[data-booking-time-input]',
};

const dayClasses = {
    sel: ['border-zen-primary', 'bg-zen-accent-soft', 'font-medium', 'text-zen-primary'],
    idle: ['border-zen-border', 'bg-white', 'text-zen-muted', 'hover:border-zen-primary/40'],
    disabled: ['cursor-not-allowed', 'border-zen-border', 'bg-zen-bg-soft', 'text-zen-muted/60', 'opacity-60'],
};

const slotClasses = {
    sel: ['border-zen-primary', 'bg-zen-primary', 'font-medium', 'text-white'],
    idle: ['border-zen-border', 'bg-white', 'text-zen-muted', 'hover:border-zen-primary/50'],
    disabled: ['cursor-not-allowed', 'border-zen-border', 'bg-zen-bg-soft', 'text-zen-muted/60', 'opacity-60'],
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

function createStaffCard(staff, checked = false) {
    const label = document.createElement('label');
    label.dataset.bookingStylistCard = '';
    label.dataset.bookingStylistAvailable = 'true';
    label.setAttribute('role', 'radio');
    label.setAttribute('aria-disabled', 'false');
    label.className =
        'group relative flex min-w-0 cursor-pointer flex-col overflow-hidden rounded-zen-md border-2 border-zen-border bg-white p-4 text-left shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-zen-primary/50 hover:shadow-zen has-[:checked]:border-zen-primary has-[:checked]:bg-zen-accent-soft has-[:checked]:shadow-zen-md has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-zen-primary/40';

    const input = document.createElement('input');
    input.type = 'radio';
    input.name = 'staff_id';
    input.value = String(staff.id);
    input.dataset.bookingStylistRadio = '';
    input.dataset.stylistName = staff.name ?? '';
    input.dataset.stylistAvailable = 'true';
    input.className = 'peer sr-only';
    input.checked = checked;

    const body = document.createElement('span');
    body.className = 'flex min-w-0 items-start gap-3';

    const image = document.createElement('img');
    image.src = staff.image ?? '';
    image.alt = `Anh \u0111\u1ea1i di\u1ec7n ${staff.name ?? ''}`;
    image.className = 'size-14 shrink-0 rounded-full border-2 border-white object-cover shadow-sm ring-1 ring-zen-border';
    image.loading = 'lazy';

    const content = document.createElement('span');
    content.className = 'min-w-0 flex-1';

    const name = document.createElement('span');
    name.dataset.stylistLabel = '';
    name.className = 'block break-words text-sm font-semibold text-zen-text';
    name.textContent = staff.name ?? '';

    const role = document.createElement('span');
    role.className = 'mt-1 block break-words text-xs font-medium text-zen-primary';
    role.textContent = staff.role ?? 'Nh\u00e2n vi\u00ean';

    const status = document.createElement('span');
    status.className = 'mt-2 inline-flex max-w-full rounded-full bg-zen-accent-soft px-2.5 py-1 text-xs font-medium text-zen-primary ring-1 ring-zen-primary/20';
    status.textContent = 'C\u00f3 th\u1ec3 \u0111\u1eb7t l\u1ecbch';

    content.append(name, role, status);
    body.append(image, content);
    label.append(input, body);

    if (staff.experience) {
        const experience = document.createElement('span');
        experience.className = 'mt-4 grid gap-2 text-xs text-zen-muted';

        const row = document.createElement('span');
        row.className = 'grid grid-cols-[minmax(0,1fr)_auto] items-start gap-3';

        const labelText = document.createElement('span');
        labelText.textContent = 'Kinh nghi\u1ec7m';

        const value = document.createElement('span');
        value.className = 'text-right font-semibold text-zen-text';
        value.textContent = staff.experience;

        row.append(labelText, value);
        experience.append(row);
        label.append(experience);
    }

    return label;
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
    const promoBtn = root.querySelector(SEL.promoBtn);
    const promoInput = root.querySelector(SEL.promoInput);
    const promoHint = root.querySelector(SEL.promoHint);
    const staffNameInput = root.querySelector(SEL.staffNameInput);
    const timeInput = root.querySelector(SEL.timeInput);
    const staffEmpty = root.querySelector('[data-booking-staff-empty]');
    const staffList = staffEmpty?.previousElementSibling ?? root.querySelector('[data-booking-stylist-card]')?.parentElement;
    let staffRequestController = null;

    function selectedSlot() {
        return slotButtons.find((b) => b.getAttribute('aria-pressed') === 'true');
    }

    function selectedDay() {
        return dayButtons.find((b) => b.getAttribute('aria-pressed') === 'true');
    }

    function selectedDateIso() {
        return selectedDay()?.dataset.date ?? dateInput?.value ?? '';
    }

    function selectedServiceIds() {
        return [...root.querySelectorAll(SEL.serviceCheckbox)]
            .filter((cb) => cb.checked)
            .map((cb) => cb.value);
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

    function syncStylistSummary() {
        const radios = [...root.querySelectorAll(SEL.stylistRadios)];
        let picked = radios.find((radio) => radio.checked) ?? null;

        if (picked && !isStylistAvailable(picked)) {
            picked.checked = false;
            picked = null;
        }

        const labelEl = picked?.closest('label')?.querySelector('[data-stylist-label]');
        const stylistName = picked
            ? picked.dataset.stylistName ?? labelEl?.textContent?.trim() ?? '—'
            : 'Any staff member';

        root.dataset.selectedStylistId = picked?.value ?? '';
        root.dataset.selectedStylistName = stylistName;

        root.querySelectorAll('[data-booking-stylist-card]').forEach((card) => {
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

    async function reloadAvailableStaff() {
        if (!root.dataset.availableStaffUrl || !staffList) return;

        const selectedStaffId = root.dataset.selectedStylistId ?? '';
        const params = new URLSearchParams();
        const dateIso = selectedDateIso();
        const time = timeInput?.value ?? selectedSlot()?.dataset.slot ?? '';

        if (dateIso) params.set('appointment_date', dateIso);
        if (time) params.set('appointment_time', time);
        selectedServiceIds().forEach((serviceId) => params.append('service_ids[]', serviceId));

        staffRequestController?.abort();
        staffRequestController = new AbortController();

        try {
            const response = await fetch(`${root.dataset.availableStaffUrl}?${params.toString()}`, {
                headers: { Accept: 'application/json' },
                signal: staffRequestController.signal,
            });

            if (!response.ok) return;

            const data = await response.json();
            const staff = Array.isArray(data.staff) ? data.staff : [];

            staffList.innerHTML = '';
            staff.forEach((staffMember) => {
                staffList.appendChild(createStaffCard(staffMember, String(staffMember.id) === selectedStaffId));
            });

            if (staffEmpty) staffEmpty.hidden = staff.length > 0;
            syncStylistSummary();
        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error('Unable to load available staff.', error);
            }
        }
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

    function clearPromoHint() {
        if (!promoHint) return;

        promoHint.hidden = true;
        promoHint.textContent = '';
        promoHint.classList.remove('text-zen-success');
        promoHint.classList.add('text-zen-muted');
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
            reloadAvailableStaff();
        });
    });

    slotButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            if (btn.disabled) return;

            selectSlotButton(btn);
            updateDateTimeSummary();
            reloadAvailableStaff();
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
        reloadAvailableStaff();
    });

    root.querySelectorAll(SEL.serviceCheckbox).forEach((cb) =>
        cb.addEventListener('change', () => {
            syncServicesAndTotal();
            reloadAvailableStaff();
        }),
    );

    staffList?.addEventListener('click', (event) => {
        const target = event.target instanceof Element ? event.target : null;
        const card = target?.closest('[data-booking-stylist-card]');
        if (!card || isStylistAvailable(card.querySelector(SEL.stylistRadios))) return;

        event.preventDefault();
        syncStylistSummary();
    });

    staffList?.addEventListener('change', (event) => {
        const radio = event.target instanceof Element ? event.target : null;
        if (!radio.matches?.(SEL.stylistRadios)) return;

        if (!isStylistAvailable(radio)) radio.checked = false;
        syncStylistSummary();
    });

    promoBtn?.addEventListener('click', () => {
        const raw = promoInput?.value.trim() ?? '';
        if (!promoHint || !promoInput) return;
        if (!raw) {
            promoHint.textContent = 'Please enter a promotion code.';
            promoHint.hidden = false;
            promoHint.classList.remove('text-zen-success');
            promoHint.classList.add('text-zen-muted');
            return;
        }
        promoHint.hidden = false;
        promoHint.classList.remove('text-zen-muted');
        promoHint.classList.add('text-zen-success');
        promoHint.textContent = `Promotion code “${raw}” has been recorded (demo only, no discount applied).`;
    });

    form?.addEventListener('submit', (e) => {
        if (!timeInput?.value) {
            e.preventDefault();
            const slotGroup = root.querySelector('[aria-label="Start time"]');err.textContent = 'Please select a time slot before booking.';
            if (slotGroup && !root.querySelector('#booking-slot-error')) {
                const err = document.createElement('p');
                err.id = 'booking-slot-error';
                err.className = 'mt-2 text-xs font-medium text-red-600';
                err.textContent = 'Please select a time slot before booking.';
                slotGroup.after(err);
            }
            root.querySelector('#booking-slot-error')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
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

            clearPromoHint();
            syncAllSummaries();
            reloadAvailableStaff();
        });
    });

    ensureDateInputIsFutureSafe();
    if (summaryBranch) summaryBranch.textContent = 'ZenStyle FPT Aptech';
    syncAllSummaries();
    reloadAvailableStaff();
}

export function initBookingIfPresent() {
    const root = document.querySelector(SEL.page);
    if (root) initBookingPage(root);
}
