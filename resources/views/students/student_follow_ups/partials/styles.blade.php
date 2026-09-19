<style>
    .student-followup-view .sfu-student-page { max-width: 1180px; margin: 0 auto; padding: 18px 0 34px; color: #172b4d; }
    .student-followup-view .sfu-student-header { display: flex; align-items: flex-end; justify-content: space-between; gap: 22px; padding: 24px; border: 1px solid #e2eaf3; border-radius: 22px; background: linear-gradient(135deg, #ffffff, #f3f8fb); box-shadow: 0 12px 30px rgba(27, 54, 93, .08); }
    .student-followup-view .sfu-student-header__copy { min-width: 0; }
    .student-followup-view .sfu-student-eyebrow { display: block; margin-bottom: 7px; color: #3b7890; font-size: .72rem; font-weight: 800; letter-spacing: .04em; }
    .student-followup-view .sfu-student-header h1, .student-followup-view .sfu-student-month h2 { margin: 0; color: #172b4d; font-weight: 900; }
    .student-followup-view .sfu-student-header h1 { font-size: clamp(1.35rem, 2.4vw, 2rem); }
    .student-followup-view .sfu-student-header p { max-width: 680px; margin: 8px 0 0; color: #64748b; line-height: 1.8; }
    .student-followup-view .sfu-student-year { min-width: 165px; padding: 13px 16px; border-radius: 16px; background: #e3f3f1; color: #236f6e; text-align: center; }
    .student-followup-view .sfu-student-year span, .student-followup-view .sfu-student-year strong { display: block; }
    .student-followup-view .sfu-student-year span { font-size: .72rem; font-weight: 700; }
    .student-followup-view .sfu-student-year strong { margin-top: 4px; font-size: 1.05rem; }
    .student-followup-view .sfu-student-toolbar { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) auto; align-items: end; gap: 12px; margin-top: 18px; padding: 16px; border: 1px solid #e2eaf3; border-radius: 18px; background: #fff; box-shadow: 0 8px 22px rgba(27, 54, 93, .05); }
    .student-followup-view .sfu-student-field { min-width: 0; }
    .student-followup-view .sfu-student-field label { display: block; margin: 0 0 6px; color: #38516e; font-size: .78rem; font-weight: 800; }
    .student-followup-view .sfu-student-field select, .student-followup-view .sfu-student-filter { width: 100%; min-height: 44px; border: 1px solid #cbd9e7; border-radius: 11px; background: #fff; color: #172b4d; font: inherit; }
    .student-followup-view .sfu-student-field select { padding: 8px 11px; }
    .student-followup-view .sfu-student-field select:focus, .student-followup-view .sfu-student-filter:focus { outline: 3px solid rgba(54, 133, 151, .18); border-color: #368597; }
    .student-followup-view .sfu-student-filter { width: auto; min-width: 110px; padding: 8px 18px; border-color: #236f6e; background: #236f6e; color: #fff; cursor: pointer; font-weight: 800; }
    .student-followup-view .sfu-student-month { margin-top: 20px; }
    .student-followup-view .sfu-student-month__heading { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 12px; }
    .student-followup-view .sfu-student-month h2 { font-size: 1.3rem; }
    .student-followup-view .sfu-student-count { display: grid; min-width: 38px; min-height: 38px; place-items: center; border-radius: 999px; background: #e3f3f1; color: #236f6e; font-weight: 900; }
    .student-followup-view .sfu-student-subject-list { display: grid; gap: 16px; }
    .student-followup-view .sfu-student-subject { overflow: hidden; border: 1px solid #e2eaf3; border-radius: 18px; background: #fff; box-shadow: 0 8px 22px rgba(27, 54, 93, .05); }
    .student-followup-view .sfu-student-subject__heading { display: flex; align-items: center; gap: 9px; padding: 14px 17px; border-bottom: 1px solid #e8eef5; background: #f7fbfc; }
    .student-followup-view .sfu-student-subject__heading i { color: #236f6e; font-size: 1.2rem; }
    .student-followup-view .sfu-student-subject__heading h3 { min-width: 0; margin: 0; color: #172b4d; font-size: 1rem; font-weight: 900; overflow-wrap: anywhere; }
    .student-followup-view .sfu-student-entry-list { display: grid; }
    .student-followup-view .sfu-student-entry { padding: 17px; border-bottom: 1px solid #edf2f7; }
    .student-followup-view .sfu-student-entry:last-child { border-bottom: 0; }
    .student-followup-view .sfu-student-entry__meta { display: flex; align-items: flex-start; justify-content: space-between; gap: 14px; }
    .student-followup-view .sfu-student-entry__teacher span, .student-followup-view .sfu-student-level span, .student-followup-view .sfu-student-note > span { display: block; color: #718096; font-size: .72rem; font-weight: 700; }
    .student-followup-view .sfu-student-entry__teacher strong { display: block; margin-top: 3px; color: #203b5c; font-size: .9rem; overflow-wrap: anywhere; }
    .student-followup-view .sfu-student-level { flex: 0 0 auto; min-width: 86px; padding: 7px 10px; border: 1px solid #c9e4df; border-radius: 11px; background: #f1faf8; text-align: center; }
    .student-followup-view .sfu-student-level strong { display: block; margin-top: 2px; color: #236f6e; font-size: .8rem; }
    .student-followup-view .sfu-student-entry__context { display: flex; flex-wrap: wrap; gap: 6px 14px; margin-top: 13px; color: #64748b; font-size: .76rem; }
    .student-followup-view .sfu-student-entry__context span, .student-followup-view .sfu-student-entry__context time { min-width: 0; overflow-wrap: anywhere; }
    .student-followup-view .sfu-student-edited { color: #8a641b; font-weight: 800; }
    .student-followup-view .sfu-student-note { margin-top: 14px; padding-top: 12px; border-top: 1px dashed #dbe5ee; }
    .student-followup-view .sfu-student-note p { margin: 5px 0 0; color: #2f435b; line-height: 1.85; white-space: pre-wrap; overflow-wrap: anywhere; word-break: normal; }
    .student-followup-view .sfu-student-empty { display: grid; justify-items: center; margin-top: 20px; padding: 44px 20px; border: 1px dashed #cbd9e7; border-radius: 20px; background: #fff; text-align: center; }
    .student-followup-view .sfu-student-empty i { color: #368597; font-size: 2.4rem; }
    .student-followup-view .sfu-student-empty h2 { margin: 12px 0 6px; color: #203b5c; font-size: 1.1rem; font-weight: 900; }
    .student-followup-view .sfu-student-empty p { max-width: 520px; margin: 0; color: #718096; line-height: 1.8; }
    .student-followup-view .sfu-student-pagination { margin-top: 18px; overflow-x: auto; }
    .student-followup-view .sfu-student-pagination .pagination { justify-content: center; margin: 0; }
    .student-followup-view .sfu-student-pagination a, .student-followup-view .sfu-student-pagination span { display: inline-flex; min-width: 40px; min-height: 40px; align-items: center; justify-content: center; }
    @media (max-width: 767px) {
        .student-followup-view .sfu-student-page { padding: 10px 0 24px; }
        .student-followup-view .sfu-student-header { align-items: stretch; flex-direction: column; padding: 18px; border-radius: 17px; }
        .student-followup-view .sfu-student-year { width: 100%; }
        .student-followup-view .sfu-student-toolbar { grid-template-columns: 1fr; padding: 13px; }
        .student-followup-view .sfu-student-filter { width: 100%; }
        .student-followup-view .sfu-student-entry { padding: 15px 13px; }
        .student-followup-view .sfu-student-entry__meta { flex-direction: column; }
        .student-followup-view .sfu-student-level { align-self: flex-start; }
    }
    @media (max-width: 359px) {
        .student-followup-view .sfu-student-header h1 { font-size: 1.25rem; }
        .student-followup-view .sfu-student-entry__context { display: grid; gap: 7px; }
    }
</style>
