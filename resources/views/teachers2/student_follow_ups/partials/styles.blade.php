<style>
    .student-follow-up-module {
        --fu-primary: #2563eb;
        --fu-primary-dark: #1d4ed8;
        --fu-text: #172033;
        --fu-muted: #667085;
        --fu-border: #e3e8f0;
        --fu-surface: #ffffff;
        --fu-soft: #f7f9fc;
        --fu-success: #18794e;
        --fu-success-bg: #eaf8f1;
        --fu-pending: #8a5a12;
        --fu-pending-bg: #fff7e6;
        direction: rtl;
        color: var(--fu-text);
        font-family: 'Cairo', sans-serif;
    }

    .student-follow-up-module *,
    .student-follow-up-module *::before,
    .student-follow-up-module *::after {
        box-sizing: border-box;
    }

    .student-follow-up-module a,
    .student-follow-up-module button,
    .student-follow-up-module input,
    .student-follow-up-module select,
    .student-follow-up-module textarea {
        font-family: inherit;
    }

    .fu-shell {
        width: min(100%, 1440px);
        margin-inline: auto;
        display: grid;
        gap: 18px;
    }

    .fu-surface {
        border: 1px solid var(--fu-border);
        border-radius: 20px;
        background: var(--fu-surface);
        box-shadow: 0 12px 30px rgba(23, 32, 51, .055);
    }

    .fu-page-head {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 22px 24px;
        background: linear-gradient(135deg, #fff 0%, #f6f9ff 100%);
    }

    .fu-page-head::after {
        content: '';
        position: absolute;
        inset-inline-end: -45px;
        top: -70px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(37, 99, 235, .065);
        pointer-events: none;
    }

    .fu-page-head__copy,
    .fu-page-head__aside {
        position: relative;
        z-index: 1;
    }

    .fu-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 7px;
        color: var(--fu-primary-dark);
        font-size: .78rem;
        font-weight: 800;
    }

    .fu-page-title {
        margin: 0;
        color: var(--fu-text);
        font-size: clamp(1.28rem, 2vw, 1.75rem);
        line-height: 1.35;
        font-weight: 800;
    }

    .fu-page-subtitle {
        max-width: 680px;
        margin: 7px 0 0;
        color: var(--fu-muted);
        font-size: .92rem;
        line-height: 1.8;
        font-weight: 600;
    }

    .fu-year-chip,
    .fu-context-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 38px;
        padding: 7px 12px;
        border: 1px solid #dbe5f6;
        border-radius: 12px;
        background: #f4f7fc;
        color: #344054;
        font-size: .82rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .fu-assignment-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(265px, 1fr));
        gap: 14px;
    }

    .fu-assignment-card {
        display: grid;
        gap: 15px;
        min-height: 220px;
        padding: 19px;
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }

    .fu-assignment-card:hover {
        transform: translateY(-2px);
        border-color: #cbd8ee;
        box-shadow: 0 16px 34px rgba(23, 32, 51, .085);
    }

    .fu-assignment-card__icon {
        display: inline-grid;
        place-items: center;
        width: 42px;
        height: 42px;
        border-radius: 13px;
        background: #eef4ff;
        color: var(--fu-primary);
        font-size: 1.25rem;
    }

    .fu-assignment-card__title {
        margin: 8px 0 3px;
        color: var(--fu-text);
        font-size: 1.08rem;
        line-height: 1.45;
        font-weight: 800;
    }

    .fu-assignment-card__context {
        color: var(--fu-muted);
        font-size: .86rem;
        line-height: 1.75;
        font-weight: 600;
    }

    .fu-progress-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        color: var(--fu-muted);
        font-size: .78rem;
        font-weight: 700;
    }

    .fu-progress-row strong {
        color: var(--fu-text);
        font-size: .84rem;
    }

    .fu-progress-track {
        height: 7px;
        overflow: hidden;
        border-radius: 999px;
        background: #edf1f7;
    }

    .fu-progress-track > span {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: var(--fu-primary);
    }

    .fu-assignment-card__footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: auto;
    }

    .fu-need-label {
        color: var(--fu-pending);
        font-size: .77rem;
        font-weight: 800;
    }

    .fu-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 40px;
        padding: 8px 14px;
        border: 1px solid transparent;
        border-radius: 11px;
        font-size: .82rem;
        line-height: 1.3;
        font-weight: 800;
        text-decoration: none !important;
        white-space: nowrap;
        transition: background-color .18s ease, border-color .18s ease, box-shadow .18s ease, transform .18s ease;
    }

    .fu-btn:hover {
        transform: translateY(-1px);
    }

    .fu-btn:focus-visible,
    .student-follow-up-module .form-control:focus,
    .sfu-followup-modal .sfu-note-input:focus,
    .sfu-followup-modal .sfu-level-option input:focus-visible + b {
        outline: 0;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .18) !important;
    }

    .fu-btn--primary {
        background: var(--fu-primary);
        border-color: var(--fu-primary);
        color: #fff !important;
    }

    .fu-btn--primary:hover {
        background: var(--fu-primary-dark);
        border-color: var(--fu-primary-dark);
        color: #fff !important;
    }

    .fu-btn--secondary {
        background: #fff;
        border-color: #cfd8e7;
        color: #344054 !important;
    }

    .fu-btn--secondary:hover {
        background: #f7f9fc;
        border-color: #aebbd0;
        color: var(--fu-text) !important;
    }

    .fu-btn--quiet {
        min-height: 36px;
        padding: 6px 10px;
        background: transparent;
        border-color: transparent;
        color: #475467 !important;
    }

    .fu-btn[disabled] {
        cursor: wait;
        opacity: .68;
        transform: none;
    }

    .fu-empty {
        display: grid;
        place-items: center;
        min-height: 280px;
        padding: 38px 24px;
        text-align: center;
    }

    .fu-empty__icon {
        display: grid;
        place-items: center;
        width: 68px;
        height: 68px;
        margin-bottom: 14px;
        border-radius: 20px;
        background: #eef4ff;
        color: var(--fu-primary);
        font-size: 2rem;
    }

    .fu-empty h3 {
        margin: 0 0 7px;
        color: var(--fu-text);
        font-size: 1.05rem;
        font-weight: 800;
    }

    .fu-empty p {
        max-width: 560px;
        margin: 0;
        color: var(--fu-muted);
        line-height: 1.8;
        font-size: .88rem;
        font-weight: 600;
    }

    .fu-back-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 10px;
        color: #475467 !important;
        font-size: .8rem;
        font-weight: 800;
        text-decoration: none !important;
    }

    .fu-back-link:hover {
        color: var(--fu-primary) !important;
    }

    .fu-context-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 13px;
    }

    .fu-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .fu-summary-card {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
        min-height: 88px;
        padding: 15px 17px;
    }

    .fu-summary-card__icon {
        display: grid;
        place-items: center;
        flex: 0 0 42px;
        width: 42px;
        height: 42px;
        border-radius: 13px;
        background: #eef4ff;
        color: var(--fu-primary);
        font-size: 1.2rem;
    }

    .fu-summary-card--success .fu-summary-card__icon {
        background: var(--fu-success-bg);
        color: var(--fu-success);
    }

    .fu-summary-card--pending .fu-summary-card__icon {
        background: var(--fu-pending-bg);
        color: var(--fu-pending);
    }

    .fu-summary-card__content {
        display: grid;
        align-content: center;
        gap: 4px;
        min-width: 0;
    }

    .fu-summary-card__content strong {
        display: block;
        color: var(--fu-text);
        font-size: 1.3rem;
        line-height: 1;
        font-weight: 800;
        unicode-bidi: isolate;
    }

    .fu-summary-card__content > span {
        display: block;
        color: var(--fu-muted);
        font-size: .76rem;
        line-height: 1.6;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .fu-toolbar {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        padding: 15px;
    }

    .fu-toolbar__field {
        display: grid;
        gap: 6px;
        min-width: 0;
    }

    .fu-toolbar__field--search {
        flex: 1 1 360px;
    }

    .fu-toolbar__field--filter {
        flex: 0 1 245px;
    }

    .fu-toolbar label {
        margin: 0;
        color: #344054;
        font-size: .76rem;
        font-weight: 800;
    }

    .fu-search-wrap {
        position: relative;
    }

    .fu-search-wrap i {
        position: absolute;
        inset-inline-start: 13px;
        top: 50%;
        z-index: 1;
        color: #7b8798;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .fu-search-wrap .form-control {
        padding-inline-start: 40px;
    }

    .student-follow-up-module .form-control {
        min-height: 43px;
        border: 1px solid #cfd8e7;
        border-radius: 11px;
        background: #fff;
        color: var(--fu-text);
        font-size: .84rem;
        font-weight: 600;
        box-shadow: none;
    }

    .student-follow-up-module textarea.form-control {
        min-height: 120px;
        resize: vertical;
        line-height: 1.75;
    }

    .student-follow-up-module .form-control[readonly] {
        background: #f7f9fc;
        color: #475467;
    }

    .fu-roster-surface {
        overflow: hidden;
    }

    .fu-table-wrap {
        overflow-x: auto;
    }

    .fu-roster-table {
        width: 100%;
        min-width: 940px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .fu-roster-table thead th {
        padding: 13px 12px;
        border: 0;
        border-bottom: 1px solid var(--fu-border);
        background: #f7f9fc;
        color: #475467;
        font-size: .74rem;
        font-weight: 800;
        text-align: right;
        white-space: nowrap;
    }

    .fu-roster-table tbody td {
        padding: 15px 12px;
        border: 0;
        border-bottom: 1px solid #edf0f5;
        color: #344054;
        font-size: .82rem;
        vertical-align: middle;
    }

    .fu-roster-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .fu-roster-table tbody tr {
        transition: background-color .16s ease;
    }

    .fu-roster-table tbody tr:hover {
        background: #fafcff;
    }

    .fu-student-name {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 190px;
        color: var(--fu-text);
        font-size: .92rem;
        font-weight: 800;
    }

    .fu-student-avatar {
        display: grid;
        place-items: center;
        flex: 0 0 37px;
        width: 37px;
        height: 37px;
        border-radius: 12px;
        background: #eef4ff;
        color: var(--fu-primary-dark);
        font-size: .78rem;
        font-weight: 800;
    }

    .fu-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 31px;
        padding: 5px 9px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: .72rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .fu-status i {
        font-size: .88rem;
    }

    .fu-status--complete {
        border-color: #c7ead8;
        background: var(--fu-success-bg);
        color: var(--fu-success);
    }

    .fu-status--pending {
        border-color: #f1dfb9;
        background: var(--fu-pending-bg);
        color: var(--fu-pending);
    }

    .fu-month-progress {
        display: grid;
        gap: 4px;
        min-width: 105px;
    }

    .fu-month-progress strong {
        color: var(--fu-text);
        font-size: .82rem;
        font-weight: 800;
    }

    .fu-month-progress small,
    .fu-last-follow-up {
        color: var(--fu-muted);
        font-size: .72rem;
        line-height: 1.55;
        font-weight: 600;
    }

    .fu-actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .fu-actions .fu-btn {
        min-height: 36px;
        padding: 6px 10px;
        font-size: .74rem;
    }

    .fu-flash,
    .fu-errors {
        padding: 13px 15px;
        border-radius: 13px;
        font-size: .84rem;
        font-weight: 700;
        line-height: 1.7;
    }

    .fu-flash {
        border: 1px solid #c7ead8;
        background: var(--fu-success-bg);
        color: var(--fu-success);
    }

    .fu-errors {
        border: 1px solid #f4c9c9;
        background: #fff3f3;
        color: #a33a3a;
    }

    .fu-errors ul {
        margin: 0;
        padding-inline-start: 20px;
    }

    .fu-pagination {
        padding: 14px 16px;
        border-top: 1px solid var(--fu-border);
    }

    .sfu-followup-modal.modal {
        direction: rtl;
        text-align: right;
        overflow-x: hidden;
        overflow-y: hidden;
    }

    .sfu-followup-modal .modal-dialog {
        width: calc(100% - 32px);
        max-width: 780px;
        max-height: calc(100vh - 32px);
        max-height: calc(100dvh - 32px);
        margin: 16px auto;
    }

    .sfu-followup-modal .modal-content {
        overflow: hidden;
        max-height: calc(100vh - 32px);
        max-height: calc(100dvh - 32px);
        border: 0;
        border-radius: 20px;
        box-shadow: 0 26px 70px rgba(15, 23, 42, .22);
    }

    /* Neutralize the legacy `form div*` rules from demo_1 styles at this root. */
    .sfu-followup-modal form div,
    .sfu-followup-modal form div:first-of-type {
        position: static;
        min-height: 0;
        margin-top: 0;
    }

    .sfu-followup-modal form div span {
        position: static;
        z-index: auto;
        display: inline;
        width: auto;
        height: auto;
        padding: 0;
        background: transparent;
        color: inherit;
        font-size: inherit;
        line-height: inherit;
        text-align: inherit;
        transform: none;
    }

    .sfu-followup-modal form div button {
        margin-left: 0;
    }

    .sfu-followup-modal .modal-header {
        flex: 0 0 auto;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 20px 24px;
        border-bottom: 1px solid var(--fu-border);
        background: #fff;
        text-align: start;
    }

    .sfu-modal-heading {
        flex: 1 1 auto;
        min-width: 0;
        padding-inline-end: 4px;
    }

    .sfu-modal-eyebrow {
        margin: 0 0 5px;
        color: var(--fu-primary-dark);
        font-size: .72rem;
        line-height: 1.7;
        font-weight: 800;
    }

    .sfu-followup-modal .modal-title {
        margin: 0;
        color: var(--fu-text);
        font-size: 1.08rem;
        line-height: 1.65;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .sfu-followup-modal .close {
        display: inline-grid;
        place-items: center;
        flex: 0 0 36px;
        width: 36px;
        height: 36px;
        padding: 0;
        margin: 0;
        border-radius: 10px;
        background: #f5f7fa;
        color: #667085;
        font-size: 1.5rem;
        line-height: 1;
        opacity: 1;
    }

    .sfu-followup-modal .modal-body {
        min-height: 0;
        padding: 18px 20px;
        overflow-x: hidden;
        overflow-y: auto;
        overscroll-behavior: contain;
    }

    .sfu-followup-modal .modal-footer {
        flex: 0 0 auto;
        justify-content: flex-start;
        gap: 8px;
        padding: 14px 20px;
        border-top: 1px solid var(--fu-border);
        background: #fafbfd;
    }

    .sfu-context {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 16px;
        padding: 0;
        border: 0;
        border-radius: 14px;
        background: transparent;
    }

    .sfu-context__item {
        display: block;
        min-width: 0;
        margin: 0;
        padding: 11px 13px;
        border: 1px solid var(--fu-border);
        border-radius: 11px;
        background: #f8fafd;
    }

    .sfu-context__item > small {
        position: static;
        display: block;
        margin-bottom: 5px;
        padding: 0;
        background: transparent;
        color: var(--fu-muted);
        font-size: .69rem;
        line-height: 1.65;
        font-weight: 700;
    }

    .sfu-context__item > strong {
        position: static;
        display: block;
        margin: 0;
        padding: 0;
        background: transparent;
        color: var(--fu-text);
        font-size: .81rem;
        line-height: 1.75;
        font-weight: 800;
        text-align: right;
        unicode-bidi: isolate;
        word-break: normal;
        overflow-wrap: anywhere;
    }

    .sfu-field {
        display: grid;
        gap: 8px;
        margin: 0 0 15px;
        min-width: 0;
    }

    .sfu-field__heading {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin: 0;
        padding: 0;
        min-width: 0;
    }

    .sfu-followup-modal .sfu-field__label,
    .sfu-followup-modal label.sfu-field__label {
        position: static;
        display: inline;
        width: auto;
        height: auto;
        margin: 0;
        padding: 0;
        border: 0;
        border-radius: 0;
        background: transparent;
        color: #344054;
        font-size: .8rem;
        line-height: 1.6;
        font-weight: 800;
        transform: none;
    }

    .sfu-field__optional {
        position: static;
        display: inline;
        margin: 0;
        padding: 0;
        border: 0;
        background: transparent;
        color: var(--fu-muted);
        font-size: .69rem;
        line-height: 1.6;
        font-weight: 600;
    }

    .sfu-level-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 8px;
        min-width: 0;
    }

    .sfu-level-option {
        position: relative;
        display: block;
        width: auto;
        height: auto;
        margin: 0;
        padding: 0;
        border: 0;
        background: transparent;
        transform: none;
        cursor: pointer;
    }

    .sfu-level-option input {
        position: absolute;
        width: 1px;
        height: 1px;
        margin: 0;
        clip: rect(0 0 0 0);
        clip-path: inset(50%);
        opacity: 0;
    }

    .sfu-level-option > b {
        position: static;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 7px;
        border: 1px solid #cfd8e7;
        border-radius: 10px;
        background: #fff;
        color: #475467;
        font-size: .78rem;
        font-weight: 800;
        transition: background-color .16s ease, border-color .16s ease, color .16s ease;
    }

    .sfu-level-option input:checked + b {
        border-color: var(--fu-primary);
        background: #eef4ff;
        color: var(--fu-primary-dark);
    }

    .sfu-note-input {
        display: block;
        width: 100%;
        min-width: 0;
        min-height: 96px;
        max-height: 190px;
        margin: 0;
        padding: 11px 13px;
        resize: vertical;
        border: 1px solid #cfd8e7;
        border-radius: 11px;
        background: #fff;
        color: var(--fu-text);
        font: 600 .84rem/1.75 'Cairo', sans-serif;
        box-shadow: none;
    }

    .sfu-field__help,
    .sfu-character-count {
        margin: 0;
        color: var(--fu-muted);
        font-size: .72rem;
        line-height: 1.65;
        font-weight: 600;
    }

    .sfu-character-count {
        position: static;
        display: block;
        width: auto;
        height: auto;
        padding: 0;
        background: transparent;
        color: var(--fu-muted);
        text-align: left;
        direction: ltr;
        unicode-bidi: isolate;
    }

    .sfu-character-count > b {
        font-weight: 700;
    }

    .sfu-notices {
        display: grid;
        gap: 7px;
        margin: 2px 0 0;
    }

    .sfu-notice {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin: 0;
        padding: 9px 11px;
        border-radius: 10px;
        background: #f7f9fc;
        color: #586579;
        font-size: .72rem;
        line-height: 1.7;
        font-weight: 600;
    }

    .sfu-notice i {
        flex: 0 0 auto;
        margin-top: 2px;
        color: var(--fu-primary);
    }

    .sfu-inline-error {
        display: none;
        margin: 0 0 12px;
        padding: 10px 12px;
        border-radius: 10px;
        background: #fff3f3;
        color: #a33a3a;
        font-size: .78rem;
        font-weight: 700;
    }

    .sfu-button {
        position: static;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-width: 120px;
        min-height: 42px;
        margin: 0;
        padding: 8px 16px;
        border: 1px solid transparent;
        border-radius: 11px;
        font: 800 .8rem/1.4 'Cairo', sans-serif;
        white-space: nowrap;
        transform: none;
    }

    .sfu-button__label {
        position: static;
        display: inline;
        width: auto;
        height: auto;
        margin: 0;
        padding: 0;
        background: transparent;
        color: inherit;
        font: inherit;
    }

    .sfu-button--primary {
        border-color: var(--fu-primary);
        background: var(--fu-primary);
        color: #fff;
    }

    .sfu-button--primary:hover,
    .sfu-button--primary:focus {
        border-color: var(--fu-primary-dark);
        background: var(--fu-primary-dark);
        color: #fff;
    }

    .sfu-button--secondary {
        border-color: #cfd8e7;
        background: #fff;
        color: #344054;
    }

    .sfu-button--secondary:hover,
    .sfu-button--secondary:focus {
        border-color: #aebbd0;
        background: #f7f9fc;
        color: var(--fu-text);
    }

    .sfu-button:focus-visible,
    .sfu-clear-level:focus-visible {
        outline: 0;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .18);
    }

    .sfu-button[disabled] {
        cursor: wait;
        opacity: .68;
    }

    .sfu-clear-level {
        justify-self: start;
        min-height: 34px;
        margin: 0;
        padding: 5px 9px;
        border: 0;
        border-radius: 9px;
        background: #f7f9fc;
        color: #475467;
        font: 700 .72rem/1.4 'Cairo', sans-serif;
    }

    .fu-history-head {
        padding: 20px 22px;
    }

    .fu-history-student {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .fu-history-student__avatar {
        display: grid;
        place-items: center;
        flex: 0 0 48px;
        width: 48px;
        height: 48px;
        border-radius: 15px;
        background: #eef4ff;
        color: var(--fu-primary-dark);
        font-size: .9rem;
        font-weight: 800;
    }

    .fu-history-student h2 {
        margin: 0;
        color: var(--fu-text);
        font-size: 1.12rem;
        line-height: 1.45;
        font-weight: 800;
    }

    .fu-history-student p {
        margin: 3px 0 0;
        color: var(--fu-muted);
        font-size: .78rem;
        font-weight: 700;
    }

    .fu-timeline {
        position: relative;
        display: grid;
        gap: 12px;
        padding-inline-start: 25px;
    }

    .fu-timeline::before {
        content: '';
        position: absolute;
        inset-inline-start: 8px;
        top: 16px;
        bottom: 16px;
        width: 2px;
        background: #dde5f0;
    }

    .fu-history-item {
        position: relative;
        padding: 18px;
    }

    .fu-history-item::before {
        content: '';
        position: absolute;
        inset-inline-start: -23px;
        top: 25px;
        width: 10px;
        height: 10px;
        border: 2px solid #fff;
        border-radius: 50%;
        background: var(--fu-primary);
        box-shadow: 0 0 0 3px #dbe7fb;
    }

    .fu-history-item__top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .fu-history-date {
        color: var(--fu-text);
        font-size: .86rem;
        font-weight: 800;
    }

    .fu-history-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 7px;
        margin-top: 6px;
    }

    .fu-level-badge,
    .fu-edited-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 8px;
        border-radius: 8px;
        font-size: .68rem;
        font-weight: 800;
    }

    .fu-level-badge {
        background: #eef4ff;
        color: var(--fu-primary-dark);
    }

    .fu-edited-badge {
        background: #f1f3f7;
        color: #586579;
    }

    .fu-history-note {
        margin: 14px 0 0;
        padding-top: 13px;
        border-top: 1px solid #edf0f5;
        color: #344054;
        font-size: .84rem;
        line-height: 1.9;
        white-space: pre-wrap;
    }

    @media (max-width: 991.98px) {
        .fu-summary-grid {
            grid-template-columns: repeat(3, minmax(150px, 1fr));
            overflow-x: auto;
            padding-bottom: 3px;
        }

        .fu-toolbar {
            align-items: stretch;
            flex-wrap: wrap;
        }

        .fu-toolbar__field--filter {
            flex: 1 1 230px;
        }
    }

    @media (max-width: 767.98px) {
        .student-follow-up-module .content-wrapper {
            padding-inline: 12px !important;
        }

        .fu-page-head {
            align-items: flex-start;
            flex-direction: column;
            padding: 18px;
        }

        .fu-page-head__aside,
        .fu-year-chip {
            width: 100%;
        }

        .fu-year-chip {
            justify-content: center;
        }

        .fu-assignment-grid,
        .fu-summary-grid {
            grid-template-columns: 1fr;
            overflow: visible;
        }

        .fu-toolbar {
            display: grid;
            grid-template-columns: 1fr;
        }

        .fu-toolbar__field,
        .fu-toolbar__field--search,
        .fu-toolbar__field--filter,
        .fu-toolbar .fu-btn {
            width: 100%;
        }

        .fu-table-wrap {
            overflow: visible;
        }

        .fu-roster-table,
        .fu-roster-table tbody,
        .fu-roster-table tr,
        .fu-roster-table td {
            display: block;
            width: 100%;
            min-width: 0;
        }

        .fu-roster-table thead {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0 0 0 0);
        }

        .fu-roster-table tbody {
            display: grid;
            gap: 12px;
            padding: 12px;
        }

        .fu-roster-table tbody tr {
            display: grid;
            gap: 0;
            overflow: hidden;
            border: 1px solid var(--fu-border);
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(23, 32, 51, .045);
        }

        .fu-roster-table tbody td {
            display: grid;
            grid-template-columns: minmax(105px, .8fr) minmax(0, 1.2fr);
            align-items: center;
            gap: 10px;
            padding: 10px 13px;
            border-bottom: 1px solid #edf0f5 !important;
            text-align: left;
        }

        .fu-roster-table tbody td::before {
            content: attr(data-label);
            color: var(--fu-muted);
            font-size: .7rem;
            font-weight: 800;
            text-align: right;
        }

        .fu-roster-table tbody td:first-child {
            display: block;
            padding: 14px;
            background: #f8faff;
        }

        .fu-roster-table tbody td:first-child::before {
            display: none;
        }

        .fu-roster-table tbody td:last-child {
            display: block;
            border-bottom: 0 !important;
        }

        .fu-roster-table tbody td:last-child::before {
            display: none;
        }

        .fu-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .fu-actions .fu-btn {
            width: 100%;
            min-height: 42px;
        }

        .sfu-followup-modal .modal-dialog {
            width: calc(100% - 20px);
            margin: max(10px, env(safe-area-inset-top)) 10px max(10px, env(safe-area-inset-bottom));
            max-height: calc(100vh - 20px);
            max-height: calc(100dvh - 20px);
        }

        .sfu-followup-modal .modal-content {
            max-height: calc(100vh - 20px);
            max-height: calc(100dvh - 20px);
        }

        .sfu-followup-modal .modal-body {
            padding: 16px;
        }

        .sfu-followup-modal .modal-header {
            gap: 14px;
            padding: 16px 18px;
        }

        .sfu-followup-modal .modal-footer {
            padding: 12px 16px;
        }

        .sfu-context {
            grid-template-columns: 1fr;
        }

        .sfu-level-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .sfu-followup-modal .modal-footer {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .sfu-followup-modal .modal-footer .sfu-button {
            width: 100%;
            min-width: 0;
        }

        .fu-history-item__top {
            flex-direction: column;
        }
    }

    @media (max-width: 359.98px) {
        .fu-assignment-card__footer,
        .fu-actions {
            grid-template-columns: 1fr;
            align-items: stretch;
        }

        .fu-assignment-card__footer {
            display: grid;
        }

        .fu-btn {
            width: 100%;
        }

        .sfu-followup-modal .modal-footer {
            grid-template-columns: 1fr;
        }

        .sfu-followup-modal .modal-header {
            padding-inline: 14px;
        }

        .fu-roster-table tbody td {
            grid-template-columns: 1fr;
            align-items: start;
            text-align: right;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .student-follow-up-module *,
        .student-follow-up-module *::before,
        .student-follow-up-module *::after {
            scroll-behavior: auto !important;
            transition-duration: .01ms !important;
            animation-duration: .01ms !important;
        }
    }
</style>
