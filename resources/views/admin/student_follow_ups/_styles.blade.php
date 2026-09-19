<style>
    .sfu-admin { direction: rtl; text-align: right; }
    .sfu-admin .sfu-shell { padding: 1.15rem; }
    .sfu-admin .sfu-intro { display:flex; justify-content:space-between; gap:1rem; align-items:flex-start; margin-bottom:1rem; }
    .sfu-admin .sfu-intro h3 { margin:0 0 .3rem; color:#2f2b3a; font-size:1.2rem; font-weight:800; }
    .sfu-admin .sfu-intro p { margin:0; color:#746f84; line-height:1.75; font-size:.9rem; }
    .sfu-admin .sfu-year { background:#f3f1fa; color:#5b4b8a; border-radius:12px; padding:.65rem .8rem; white-space:nowrap; font-weight:800; }
    .sfu-admin .sfu-summary { display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:.75rem; margin-bottom:1rem; }
    .sfu-admin .sfu-branches { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:1rem; margin:1.1rem 0; }
    .sfu-admin .sfu-branch { border:1px solid #e6e1f1; border-radius:16px; background:linear-gradient(135deg,#fff,#faf9fd); padding:1.15rem; box-shadow:0 8px 22px rgba(36,30,62,.04); }
    .sfu-admin .sfu-branch h4 { margin:0 0 .35rem; font-weight:800; color:#342e41; }.sfu-admin .sfu-branch p{color:#756f84;line-height:1.7;min-height:48px;}.sfu-admin .sfu-attention{margin-top:1rem;}
    .sfu-admin .sfu-stat { border:1px solid #ebe7f5; border-radius:14px; padding:.8rem; background:#fff; }
    .sfu-admin .sfu-stat span { display:block; color:#7b7590; font-size:.78rem; line-height:1.55; }
    .sfu-admin .sfu-stat strong { display:block; margin-top:.25rem; color:#2f2b3a; font-size:1.3rem; }
    .sfu-admin .sfu-filters { display:grid; grid-template-columns:repeat(6,minmax(0,1fr)); gap:.7rem; padding:1rem; border:1px solid #ebe7f5; border-radius:15px; background:#fbfaff; margin-bottom:1rem; }
    .sfu-admin .sfu-field label { display:block; margin-bottom:.3rem; color:#625c73; font-size:.77rem; font-weight:800; }
    .sfu-admin .sfu-field select { width:100%; min-height:39px; border:1px solid #dcd7e9; border-radius:9px; background:#fff; padding:.35rem .55rem; color:#403a50; font-family:inherit; }
    .sfu-admin .sfu-filter-action { display:flex; align-items:end; }
    .sfu-admin .sfu-filter-action .btn { width:100%; min-height:39px; font-weight:800; }
    .sfu-admin .sfu-table-card { border:1px solid #ebe7f5; border-radius:16px; overflow:hidden; background:#fff; }
    .sfu-admin .sfu-table-wrap { overflow-x:auto; }
    .sfu-admin .sfu-table { margin:0; min-width:1000px; }
    .sfu-admin .sfu-table thead th { background:#f7f5fb; color:#514b61; font-size:.77rem; white-space:nowrap; border-bottom:1px solid #ebe7f5; }
    .sfu-admin .sfu-table td { vertical-align:middle; font-size:.86rem; color:#383244; }
    .sfu-admin .sfu-person { font-weight:800; color:#302a3d; }
    .sfu-admin .sfu-meta { display:block; color:#817b90; font-size:.74rem; margin-top:.1rem; }
    .sfu-admin .sfu-badge { display:inline-flex; align-items:center; border-radius:999px; padding:.28rem .58rem; font-size:.72rem; font-weight:800; white-space:nowrap; }
    .sfu-admin .sfu-badge.completed { color:#147a4e; background:#e9f8ef; }
    .sfu-admin .sfu-badge.missing_first, .sfu-admin .sfu-badge.missing_second, .sfu-admin .sfu-badge.incomplete { color:#a35a10; background:#fff4e5; }
    .sfu-admin .sfu-badge.no_follow_up { color:#aa3f4b; background:#fff0f1; }
    .sfu-admin .sfu-badge.not_due, .sfu-admin .sfu-badge.not_applicable, .sfu-admin .sfu-badge.future { color:#686278; background:#f1f0f5; }
    .sfu-admin .sfu-badge.in_progress { color:#236d9f; background:#eaf5ff; }
    .sfu-admin .sfu-actions { display:flex; flex-wrap:wrap; gap:.35rem; }
    .sfu-admin .sfu-section-title { margin:1.25rem 0 .7rem; color:#342e41; font-size:1rem; font-weight:800; }
    .sfu-admin .sfu-card-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:.75rem; }
    .sfu-admin .sfu-nav-card { display:flex; flex-direction:column; gap:.28rem; min-width:0; padding:1rem; border:1px solid #e4dfef; border-radius:14px; background:#fff; color:#4b4558; transition:.18s ease; }
    .sfu-admin .sfu-nav-card:hover,.sfu-admin .sfu-nav-card.is-active { border-color:#7560ad; box-shadow:0 8px 22px rgba(74,55,121,.1); transform:translateY(-1px); text-decoration:none; }
    .sfu-admin .sfu-nav-card.is-active { background:#f6f3fc; }
    .sfu-admin .sfu-nav-card strong { color:#302a3d; font-size:1rem; overflow-wrap:anywhere; }
    .sfu-admin .sfu-nav-card span { color:#756f84; font-size:.8rem; line-height:1.55; overflow-wrap:anywhere; }
    .sfu-admin .sfu-search { display:flex; gap:.55rem; align-items:center; max-width:760px; margin-bottom:1rem; }
    .sfu-admin .sfu-search .form-control { min-height:42px; border:1px solid #d8d2e5; border-radius:10px; }
    .sfu-admin .sfu-result-head { display:flex; justify-content:space-between; align-items:center; margin:1.2rem 0 .65rem; }
    .sfu-admin .sfu-result-head h4 { margin:0; font-weight:800; font-size:1rem; }
    .sfu-admin .sfu-detail-filters { grid-template-columns:2fr 1fr 1fr 1fr; margin-top:1rem; }
    .sfu-modal { direction:rtl; text-align:right; }
    .sfu-modal .modal-content { border:0; border-radius:18px; overflow:hidden; }
    .sfu-modal .modal-header { align-items:flex-start; padding:1.1rem 1.25rem; border-bottom:1px solid #ebe7f5; }
    .sfu-modal .modal-header p { margin:.3rem 0 0; color:#777184; font-size:.82rem; line-height:1.65; }
    .sfu-modal .close { margin:-.3rem auto -.3rem -.3rem; padding:.6rem; }
    .sfu-modal .modal-body { padding:1.2rem; }
    .sfu-modal .modal-footer { justify-content:flex-start; gap:.4rem; border-top:1px solid #ebe7f5; }
    .sfu-context-grid { display:grid; grid-template-columns:1fr 1fr; gap:.6rem; margin-bottom:1rem; }
    .sfu-context-grid > div { border:1px solid #ebe7f5; border-radius:10px; padding:.65rem; min-width:0; }
    .sfu-context-grid .wide { grid-column:1/-1; }
    .sfu-context-grid span { display:block; color:#7a7487; font-size:.72rem; }
    .sfu-context-grid strong { display:block; margin-top:.18rem; overflow-wrap:anywhere; color:#342e41; }
    .sfu-admin .sfu-empty { padding:2.25rem 1rem; text-align:center; color:#756f84; }
    .sfu-admin .sfu-empty h4 { font-weight:800; color:#342e41; margin-bottom:.35rem; }
    .sfu-admin .sfu-observation { border:1px solid #ebe7f5; border-radius:14px; padding:1rem; margin-bottom:.75rem; background:#fff; }
    .sfu-admin .sfu-observation-head { display:flex; align-items:flex-start; justify-content:space-between; gap:.8rem; margin-bottom:.65rem; }
    .sfu-admin .sfu-note { white-space:pre-wrap; overflow-wrap:anywhere; color:#4a4457; line-height:1.85; margin:0; }
    @media (max-width:1100px) { .sfu-admin .sfu-summary{grid-template-columns:repeat(3,minmax(0,1fr));}.sfu-admin .sfu-filters{grid-template-columns:repeat(3,minmax(0,1fr));}.sfu-admin .sfu-card-grid{grid-template-columns:repeat(2,minmax(0,1fr));} }
    @media (max-width:650px) { .sfu-admin .sfu-shell{padding:.8rem;}.sfu-admin .sfu-intro{display:block;}.sfu-admin .sfu-intro>.sfu-actions{margin-top:.75rem}.sfu-admin .sfu-year{display:inline-block;margin-top:.7rem;}.sfu-admin .sfu-summary,.sfu-admin .sfu-filters,.sfu-admin .sfu-branches{grid-template-columns:1fr 1fr;gap:.55rem;}.sfu-admin .sfu-branches,.sfu-admin .sfu-card-grid{grid-template-columns:1fr;}.sfu-admin .sfu-filter-action{grid-column:span 2;}.sfu-admin .sfu-search{flex-wrap:wrap}.sfu-admin .sfu-search .form-control{flex:1 0 100%}.sfu-context-grid{grid-template-columns:1fr}.sfu-context-grid .wide{grid-column:auto}.sfu-modal .modal-dialog{margin:.55rem}.sfu-modal .modal-footer .btn{flex:1}.sfu-admin .sfu-detail-filters{grid-template-columns:1fr 1fr;} }
    @media (max-width:360px) { .sfu-admin .sfu-summary,.sfu-admin .sfu-filters{grid-template-columns:1fr;}.sfu-admin .sfu-filter-action{grid-column:span 1;} }
</style>
