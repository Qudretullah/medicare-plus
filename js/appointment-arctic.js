
/* ==========================================
   MEDICARE+ ARCTIC CALENDAR & TIME PICKER
========================================== */

(() => {
    const form = document.getElementById("appointmentForm");
    const dateInput = document.getElementById("appointmentDate");
    const timeInput = document.getElementById("appointmentTime");

    if (!form || !dateInput || !timeInput) return;

    const dateTools = document.getElementById("arcticDateTools");
    const timeTools = document.getElementById("arcticTimeTools");

    const popup = document.getElementById("arcticCalendarPopup");
    const trigger = document.getElementById("arcticCalendarTrigger");

    const days = document.getElementById("arcticCalendarDays");
    const monthTitle = document.getElementById("arcticCalendarMonth");

    const prev = document.getElementById("arcticCalendarPrev");
    const next = document.getElementById("arcticCalendarNext");

    const slots = document.getElementById("arcticTimeSlots");

    if (
        !dateTools || !timeTools || !popup ||
        !trigger || !days || !monthTitle ||
        !prev || !next || !slots
    ) return;

    dateTools.hidden = false;
    timeTools.hidden = false;

    function formatDate(d) {
        return [
            d.getFullYear(),
            String(d.getMonth() + 1).padStart(2, "0"),
            String(d.getDate()).padStart(2, "0")
        ].join("-");
    }

    function parseDate(value) {
        const match = /^(\d{4})-(\d{2})-(\d{2})$/.exec(value || "");

        if (!match) return null;

        const date = new Date(
            Number(match[1]),
            Number(match[2]) - 1,
            Number(match[3])
        );

        return formatDate(date) === value ? date : null;
    }

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const inputMin = parseDate(dateInput.min);

    const firstAllowed =
        inputMin && inputMin > today ? inputMin : today;

    const initial = parseDate(dateInput.value) || firstAllowed;

    let displayedMonth = new Date(
        initial.getFullYear(),
        initial.getMonth(),
        1
    );

    function notifyChange(input) {
        input.dispatchEvent(
            new Event("input", { bubbles: true })
        );

        input.dispatchEvent(
            new Event("change", { bubbles: true })
        );
    }

    function closeCalendar() {
        popup.hidden = true;
        trigger.setAttribute("aria-expanded", "false");
    }

    function drawCalendar() {
        days.replaceChildren();

        monthTitle.textContent =
            displayedMonth.toLocaleDateString("en-US", {
                month: "long",
                year: "numeric"
            });

        prev.disabled =
            displayedMonth.getFullYear() === firstAllowed.getFullYear() &&
            displayedMonth.getMonth() <= firstAllowed.getMonth();

        const year = displayedMonth.getFullYear();
        const month = displayedMonth.getMonth();

        const offset =
            (new Date(year, month, 1).getDay() + 6) % 7;

        for (let i = 0; i < offset; i++) {
            days.appendChild(document.createElement("span"));
        }

        const totalDays =
            new Date(year, month + 1, 0).getDate();

        for (let day = 1; day <= totalDays; day++) {
            const date = new Date(year, month, day);
            const value = formatDate(date);

            const button = document.createElement("button");

            button.type = "button";
            button.textContent = day;

            button.setAttribute(
                "aria-label",
                date.toDateString()
            );

            button.setAttribute(
                "aria-pressed",
                String(dateInput.value === value)
            );

            // Disable past dates and Sundays
            button.disabled =
                date < firstAllowed || date.getDay() === 0;

            button.addEventListener("click", () => {
                dateInput.value = value;

                notifyChange(dateInput);
                drawCalendar();
                closeCalendar();
            });

            days.appendChild(button);
        }
    }

    trigger.addEventListener("click", () => {
        if (popup.hidden) {
            drawCalendar();
            popup.hidden = false;

            trigger.setAttribute("aria-expanded", "true");
        } else {
            closeCalendar();
        }
    });

    prev.addEventListener("click", () => {
        displayedMonth = new Date(
            displayedMonth.getFullYear(),
            displayedMonth.getMonth() - 1,
            1
        );

        drawCalendar();
    });

    next.addEventListener("click", () => {
        displayedMonth = new Date(
            displayedMonth.getFullYear(),
            displayedMonth.getMonth() + 1,
            1
        );

        drawCalendar();
    });

    document.addEventListener("click", event => {
        if (
            !popup.hidden &&
            !dateTools.contains(event.target)
        ) {
            closeCalendar();
        }
    });

    document.addEventListener("keydown", event => {
        if (event.key === "Escape") {
            closeCalendar();
        }
    });

    dateInput.addEventListener("change", () => {
        const selected = parseDate(dateInput.value);

        if (selected) {
            displayedMonth = new Date(
                selected.getFullYear(),
                selected.getMonth(),
                1
            );
        }

        drawCalendar();
    });

    /* ======================================
       TIME SLOTS
    ====================================== */

    function formatTime(value) {
        const [hours, minutes] =
            value.split(":").map(Number);

        const hour12 = hours % 12 || 12;
        const ampm = hours < 12 ? "AM" : "PM";

        return `${hour12}:${String(minutes).padStart(2, "0")} ${ampm}`;
    }

    // Preferred slots from 09:00 to 16:30
    for (let hour = 9; hour < 17; hour++) {
        for (const minute of [0, 30]) {
            const value =
                `${String(hour).padStart(2, "0")}:` +
                `${String(minute).padStart(2, "0")}`;

            const button = document.createElement("button");

            button.type = "button";
            button.textContent = formatTime(value);
            button.dataset.time = value;

            button.addEventListener("click", () => {
                timeInput.value = value;

                notifyChange(timeInput);
                syncSlots();
            });

            slots.appendChild(button);
        }
    }

    function syncSlots() {
        slots.querySelectorAll("button").forEach(button => {
            button.setAttribute(
                "aria-pressed",
                String(
                    timeInput.value.slice(0, 5) ===
                    button.dataset.time
                )
            );
        });
    }

    timeInput.addEventListener("change", syncSlots);

    syncSlots();

    // Native inputs remain available as fallback.
    // Existing Laravel validation still decides
    // whether the appointment may be booked.
})();
