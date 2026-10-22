<style>
    .complaint-track-shell { max-width: 720px; margin: 42px auto 60px; padding: 0 16px; }
    .complaint-track-card { background: #fff; border: 1px solid #e1e6e6; border-radius: 18px; box-shadow: 0 14px 35px rgba(20, 53, 58, .07); padding: clamp(22px, 5vw, 42px); }
    .complaint-track-card h1 { margin: 0 0 12px; color: #183c45; font-size: clamp(1.65rem, 4vw, 2.25rem); line-height: 1.35; }
    .complaint-track-card p { line-height: 1.8; }
    .complaint-track-lead { color: #546872; margin: 0 0 26px; }
    .complaint-track-reminder { margin: 14px 0 20px; padding: 13px 17px; background: #fff8e8; border-inline-start: 4px solid #bd8741; border-radius: 8px; color: #4b3e2f; font-weight: 700; }
    .complaint-track-reference { display: grid; gap: 12px; padding: 20px; border-radius: 12px; background: #edf6f3; border: 1px solid #cce5dc; margin: 24px 0; }
    .complaint-track-reference strong { color: #215d50; }
    .complaint-track-reference code { display: block; overflow-wrap: anywhere; direction: ltr; unicode-bidi: isolate; font-size: clamp(.95rem, 3vw, 1.2rem); color: #173f47; }
    .complaint-track-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 24px; align-items: center; }
    .complaint-track-actions .btn { min-height: 44px; display: inline-flex; align-items: center; justify-content: center; white-space: normal; }
    .complaint-track-field { margin: 20px 0; }
    .complaint-track-field label { display: block; margin-bottom: 8px; font-weight: 700; color: #183c45; }
    .complaint-track-field input { display: block; width: 100%; min-height: 46px; border: 1px solid #b6c7cb; border-radius: 9px; padding: 10px 13px; background: #fff; color: #183c45; }
    .complaint-track-field input:focus { border-color: #217368; outline: 3px solid rgba(33, 115, 104, .16); }
    .complaint-track-result { border-inline-start: 4px solid #21836f; padding: 12px 18px; margin-top: 28px; background: #f1f8f5; border-radius: 8px; }
    .complaint-track-result dl { display: grid; grid-template-columns: minmax(100px, 1fr) 2fr; gap: 12px; margin: 0; }
    .complaint-track-result dt { color: #567078; }
    .complaint-track-result dd { margin: 0; font-weight: 700; color: #183c45; overflow-wrap: anywhere; }
    .complaint-track-feedback { min-height: 1.5em; margin: 8px 0 0; color: #215d50; }
    .complaint-track-private { color: #60747b; font-size: .93rem; margin-top: 18px; }
    @media (max-width: 480px) { .complaint-track-shell { margin-top: 24px; } .complaint-track-actions .btn { width: 100%; } .complaint-track-result dl { grid-template-columns: 1fr; gap: 4px; } .complaint-track-result dd { margin-bottom: 12px; } }
</style>
