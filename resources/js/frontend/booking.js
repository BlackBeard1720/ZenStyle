const SEL = {
    page: '#booking-page',
    dayBtn: '[data-booking-day]',
    slotBtn: '[data-booking-slot]',
    guestMinus: '[data-booking-guest-minus]',
    guestPlus: '[data-booking-guest-plus]',
    guestValue: '[data-booking-guest-value]',
    serviceCheckbox: '[data-booking-service-row] input[type="checkbox"]',
    promoBtn: '[data-booking-promo-apply]',
    promoInput: '[data-booking-promo-input]',
    promoHint: '[data-booking-promo-hint]',
    dateInput: '#booking-date',
    stylistRadios: 'input[name="booking_stylist"]',
};

const dayClasses = {
    sel: ['border-[#1677ff]', 'bg-[#e6f4ff]', 'font-medium', 'text-[#1677ff]'],
    idle: ['border-black/15', 'bg-white', 'text-black/65', 'hover:border-[#1677ff]/40'],
    disabled: ['cursor-not-allowed', 'border-black/10', 'bg-black/5', 'text-black/30', 'opacity-60'],
};

const slotClasses = {
    sel: ['border-[#1677ff]', 'bg-[#1677ff]', 'font-medium', 'text-white'],
    idle: ['border-black/15', 'bg-white', 'text-black/65', 'hover:border-[#1677ff]/50'],
    disabled: ['cursor-not-allowed', 'border-black/10', 'bg-black/5', 'text-black/30', 'opacity-60'],
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
    const summaryBranch = root.querySelector('#booking-summary-branch');
    const summaryTimeLine = root.querySelector('#booking-summary-time-line');
    const summaryDateLine = root.querySelector('#booking-summary-date-line');
    const summaryGuests = root.querySelector('#booking-summary-guests');
    const summaryStylist = root.querySelector('#booking-summary-stylist');
    const summaryServicesEl = root.querySelector('#booking-summary-services');
    const summaryTotalEl = root.querySelector('#booking-summary-total');

    const dayButtons = [...root.querySelectorAll(SEL.dayBtn)];
    const slotButtons = [...root.querySelectorAll(SEL.slotBtn)];
    const guestMinus = root.querySelector(SEL.guestMinus);
    const guestPlus = root.querySelector(SEL.guestPlus);
    const guestValue = root.querySelector(SEL.guestValue);
    const dateInput = root.querySelector(SEL.dateInput);
    const promoBtn = root.querySelector(SEL.promoBtn);
    const promoInput = root.querySelector(SEL.promoInput);
    const promoHint = root.querySelector(SEL.promoHint);

    let guestCount = Math.max(1, parseInt(guestValue?.textContent ?? '1', 10) || 1);

    function selectedSlot() {
        return slotButtons.find((b) => b.getAttribute('aria-pressed') === 'true');
    }

    function selectedDay() {
        return dayButtons.find((b) => b.getAttribute('aria-pressed') === 'true');
    }

    function selectedDateIso() {
        return selectedDay()?.dataset.date ?? dateInput?.value ?? '';
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
        if (!dateInput) return localIsoDate();

        const todayIso = localIsoDate();
        dateInput.min = todayIso;

        if (!isValidIsoDate(dateInput.value) || dateInput.value < todayIso) {
            dateInput.value = todayIso;
        }

        return dateInput.value;
    }

    function syncDayAvailability() {
        const todayIso = localIsoDate();
        let hasSelectedDay = false;

        dayButtons.forEach((btn) => {
            const disabled = isPastDate(btn.dataset.date, todayIso);
            if (disabled) btn.setAttribute('aria-pressed', 'false');
            setAvailability(btn, disabled, dayClasses);
            hasSelectedDay ||= btn.getAttribute('aria-pressed') === 'true';
        });

        if (!hasSelectedDay) {
            const matchingDate = dateInput?.value;
            const matchingBtn = dayButtons.find((btn) => btn.dataset.date === matchingDate && !btn.disabled);
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

    function syncStylistSummary() {
        const picked = root.querySelector(`${SEL.stylistRadios}:checked`);
        const labelEl = picked?.closest('label')?.querySelector('[data-stylist-label]');
        if (labelEl && summaryStylist) summaryStylist.textContent = labelEl.textContent?.trim() ?? '—';
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
            p.className = 'text-xs font-normal text-black/45';
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
                sub.className = 'mt-0.5 text-xs font-normal text-black/45';
                sub.textContent = formatVnd(price);
                summaryServicesEl.appendChild(sub);
            });
        }

        summaryTotalEl.textContent = formatVnd(total);
    }

    function syncGuestSummary() {
        if (summaryGuests) summaryGuests.textContent = `${guestCount} người`;
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

    guestMinus?.addEventListener('click', () => {
        guestCount = Math.max(1, guestCount - 1);
        if (guestValue) guestValue.textContent = String(guestCount);
        syncGuestSummary();
    });

    guestPlus?.addEventListener('click', () => {
        guestCount = Math.min(10, guestCount + 1);
        if (guestValue) guestValue.textContent = String(guestCount);
        syncGuestSummary();
    });

    root.querySelectorAll(SEL.serviceCheckbox).forEach((cb) =>
        cb.addEventListener('change', syncServicesAndTotal),
    );

    root.querySelectorAll(SEL.stylistRadios).forEach((radio) =>
        radio.addEventListener('change', syncStylistSummary),
    );

    promoBtn?.addEventListener('click', () => {
        const raw = promoInput?.value.trim() ?? '';
        if (!promoHint || !promoInput) return;
        if (!raw) {
            promoHint.textContent = 'Vui lòng nhập mã.';
            promoHint.hidden = false;
            promoHint.classList.remove('text-green-600');
            promoHint.classList.add('text-black/55');
            return;
        }
        promoHint.hidden = false;
        promoHint.classList.remove('text-black/55');
        promoHint.classList.add('text-green-600');
        promoHint.textContent = `Đã ghi nhận mã “${raw}” (demo, chưa trừ tiền).`;
    });

    ensureDateInputIsFutureSafe();
    syncDayAvailability();
    syncSlotAvailability();
    if (summaryBranch) summaryBranch.textContent = 'ZenStyle FPT Aptech';
    syncStylistSummary();
    syncGuestSummary();
    updateDateTimeSummary();
    syncServicesAndTotal();
}

export function initBookingIfPresent() {
    const root = document.querySelector(SEL.page);
    if (root) initBookingPage(root);
}
