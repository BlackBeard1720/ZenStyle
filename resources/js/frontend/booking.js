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

function formatVnd(n) {
    return `${Number(n).toLocaleString('vi-VN')}đ`;
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
    const promoBtn = root.querySelector(SEL.promoBtn);
    const promoInput = root.querySelector(SEL.promoInput);
    const promoHint = root.querySelector(SEL.promoHint);
    const staffNameInput = root.querySelector(SEL.staffNameInput);
    const timeInput = root.querySelector(SEL.timeInput);

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
            : 'Bất kỳ nhân viên';

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
            p.textContent = 'Chưa chọn dịch vụ';
            summaryServicesEl.appendChild(p);
        } else {
            lis.forEach((li) => {
                const name = li.dataset.serviceName ?? '';
                const price = parseInt(li.dataset.servicePrice ?? '0', 10) || 0;
                total += price;

                const p = document.createElement('p');
                p.textContent = name;
                summaryServicesEl.appendChild(p);

                const sub = document.createElement('p');
                sub.className = 'mt-0.5 text-xs font-normal text-zen-muted';
                sub.textContent = formatVnd(price);
                summaryServicesEl.appendChild(sub);
            });
        }

        summaryTotalEl.textContent = formatVnd(total);
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
        });
    });

    slotButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            if (btn.disabled) return;

            selectSlotButton(btn);
            updateDateTimeSummary();
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
    });

    root.querySelectorAll(SEL.serviceCheckbox).forEach((cb) =>
        cb.addEventListener('change', syncServicesAndTotal),
    );

    root.querySelectorAll('[data-booking-stylist-card]').forEach((card) => {
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

    promoBtn?.addEventListener('click', () => {
        const raw = promoInput?.value.trim() ?? '';
        if (!promoHint || !promoInput) return;
        if (!raw) {
            promoHint.textContent = 'Vui lòng nhập mã.';
            promoHint.hidden = false;
            promoHint.classList.remove('text-zen-success');
            promoHint.classList.add('text-zen-muted');
            return;
        }
        promoHint.hidden = false;
        promoHint.classList.remove('text-zen-muted');
        promoHint.classList.add('text-zen-success');
        promoHint.textContent = `Đã ghi nhận mã “${raw}” (demo, chưa trừ tiền).`;
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
        });
    });

    ensureDateInputIsFutureSafe();
    if (summaryBranch) summaryBranch.textContent = 'ZenStyle FPT Aptech';
    syncAllSummaries();
}

export function initBookingIfPresent() {
    const root = document.querySelector(SEL.page);
    if (root) initBookingPage(root);
}
