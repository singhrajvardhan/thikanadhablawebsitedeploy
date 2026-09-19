/* Universal Visitor Tracker v3.0 */
(function () {
  "use strict";
  const ENDPOINT = "https://fmrmiylqjkyrsztfmgp.supabase.co/functions/v1/track-visitor";
  const DEBUG = false;

  const SITES = [
    { match: ["thikanadhabla.in", "thikanadhabla.workers.dev", "thikanadhablawebsitedeploy"], label: "Thikana Dhabla Ghosi" },
    { match: ["rajvardhansingh.in", "rajvardhansingh.workers.dev"], label: "Rajvardhan Singh" },
  ];
  function detectSite() {
    const host = window.location.hostname.toLowerCase();
    const found = SITES.find(s => s.match.some(m => host.includes(m)));
    return found ? found.label : host;
  }
  function detectPageInfo() {
    const path = window.location.pathname.toLowerCase();
    const lang = /\/hi(\/|$)/.test(path) ? "hi" : "en";
    let pageName = "Home";
    if (path.includes("history") || path.includes("itihas")) pageName = "History";
    else if (path.includes("familytree") || path.includes("vanshavali")) pageName = "Family Tree";
    else if (path.includes("map") || path.includes("sthan")) pageName = "Location & Map";
    else if (path.includes("dist") || path.includes("nirdeshika") || path.includes("directory")) pageName = "Directory";
    else if (path.includes("about") || path.includes("parichay")) pageName = "About";
    else if (path.includes("contactus") || path.includes("contact") || path.includes("sampark")) pageName = "Contact";
    else if (path.includes("privacy")) pageName = "Privacy";
    else if (path.includes("sitemap")) pageName = "Sitemap";
    else if (path.includes("admin")) pageName = "Admin";
    return { pageName, lang, href: window.location.href, site: detectSite() };
  }
  function getUserId() {
    let id = localStorage.getItem("_ut_userId");
    if (!id) { id = "user_" + Date.now() + "_" + Math.random().toString(36).substring(2, 10); localStorage.setItem("_ut_userId", id); }
    return id;
  }
  function getSessionId() {
    let sid = sessionStorage.getItem("_ut_sessionId");
    if (!sid) { sid = "sess_" + Date.now() + "_" + Math.random().toString(36).substring(2, 10); sessionStorage.setItem("_ut_sessionId", sid); }
    return sid;
  }
  function getLandingPage() {
    let lp = sessionStorage.getItem("_ut_landing");
    if (!lp) { lp = window.location.href; sessionStorage.setItem("_ut_landing", lp); }
    return lp;
  }

  async function track(eventData) {
    try {
      const info = detectPageInfo();
      const payload = {
        event_type: eventData.event_type || "pageview",
        site: info.site,
        page: info.href,
        page_name: info.pageName,
        page_lang: info.lang,
        referrer: document.referrer || "",
        landing_page: getLandingPage(),
        browser: navigator.userAgent,
        os: navigator.platform || "unknown",
        device: /Mobi|Android/i.test(navigator.userAgent) ? "Mobile" : "Desktop",
        screen: screen.width + "x" + screen.height,
        language: navigator.language,
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
        user_id: getUserId(),
        session_id: getSessionId(),
        utm_source: new URLSearchParams(location.search).get("utm_source") || "",
        utm_medium: new URLSearchParams(location.search).get("utm_medium") || "",
        ...eventData,
      };
      await fetch(ENDPOINT, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload),
      });
    } catch (e) { if (DEBUG) console.warn(e); }
  }

  const startTime = Date.now();
  function firePageview() { setTimeout(() => track({ event_type: "pageview" }), 400); }
  if (document.readyState === "complete") firePageview();
  else window.addEventListener("load", firePageview);

  document.addEventListener("click", function (e) {
    const t = e.target;
    if (t.closest && t.closest(".no-track")) return;
    track({
      event_type: "click",
      element: t.tagName || "",
      element_id: t.id || "",
      element_class: typeof t.className === "string" ? t.className : "",
      click_time: new Date().toISOString(),
    });
  });

  let maxScroll = 0, scrollTimer;
  window.addEventListener("scroll", function () {
    clearTimeout(scrollTimer);
    scrollTimer = setTimeout(function () {
      const docH = document.body.scrollHeight - window.innerHeight;
      if (docH <= 0) return;
      const pct = Math.min(100, Math.floor((window.scrollY / docH) * 100));
      const milestone = Math.floor(pct / 25) * 25;
      if (milestone > maxScroll && milestone > 0) {
        maxScroll = milestone;
        track({ event_type: "scroll", scroll_percent: maxScroll, click_percent: maxScroll + "%" });
      }
    }, 400);
  });

  let sent = false;
  function sendTimeSpent() {
    if (sent) return; sent = true;
    const seconds = Math.round((Date.now() - startTime) / 1000);
    if (seconds < 3) return;
    const info = detectPageInfo();
    const payload = {
      event_type: "time_spent", site: info.site, page: info.href,
      page_name: info.pageName, page_lang: info.lang,
      time_spent: seconds, total_time: seconds,
      user_id: getUserId(), session_id: getSessionId(),
      device: /Mobi|Android/i.test(navigator.userAgent) ? "Mobile" : "Desktop",
      browser: navigator.userAgent, screen: screen.width + "x" + screen.height,
      language: navigator.language, timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
    };
    if (navigator.sendBeacon) navigator.sendBeacon(ENDPOINT, new Blob([JSON.stringify(payload)], { type: "application/json" }));
    else fetch(ENDPOINT, { method: "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify(payload), keepalive: true });
  }
  window.addEventListener("beforeunload", sendTimeSpent);
  window.addEventListener("pagehide", sendTimeSpent);
})();
