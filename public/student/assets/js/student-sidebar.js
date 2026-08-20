(function () {
  'use strict';

  var mobileQuery = window.matchMedia('(max-width: 991.98px)');
  var body = document.body;
  var sidebar = document.getElementById('sidebar');
  var backdrop = document.querySelector('.student-sidebar-backdrop');
  var toggles = document.querySelectorAll('.student-sidebar-toggle[data-toggle="offcanvas"]');

  if (!body || !sidebar || !backdrop || !toggles.length) {
    return;
  }

  function isOpen() {
    return sidebar.classList.contains('active');
  }

  function syncState(open) {
    var shouldOpen = Boolean(open && mobileQuery.matches);

    sidebar.classList.toggle('active', shouldOpen);
    body.classList.toggle('student-sidebar-open', shouldOpen);

    toggles.forEach(function (toggle) {
      toggle.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
      toggle.setAttribute('aria-label', shouldOpen ? 'إغلاق القائمة' : 'فتح القائمة');
    });
  }

  function toggleSidebar(event) {
    event.preventDefault();
    event.stopPropagation();
    syncState(!isOpen());
  }

  toggles.forEach(function (toggle) {
    toggle.addEventListener('click', toggleSidebar, false);
  });

  backdrop.addEventListener('click', function (event) {
    event.preventDefault();
    syncState(false);
  }, false);

  sidebar.addEventListener('click', function (event) {
    var link = event.target.closest('a[href]');

    if (link && link.getAttribute('href') !== '#') {
      syncState(false);
    }
  }, false);

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && isOpen()) {
      syncState(false);
    }
  }, false);

  window.addEventListener('pageshow', function () {
    syncState(false);
  }, false);

  function handleBreakpointChange() {
    if (!mobileQuery.matches) {
      syncState(false);
    }
  }

  if (typeof mobileQuery.addEventListener === 'function') {
    mobileQuery.addEventListener('change', handleBreakpointChange);
  } else {
    mobileQuery.addListener(handleBreakpointChange);
  }

  syncState(false);
})();
