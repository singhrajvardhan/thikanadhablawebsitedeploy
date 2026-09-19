/* ============================================================
   UNIVERSAL VISITOR TRACKER — Thikana Dhabla Ghosi + Rajvardhan Singh
   Auto-detects site, page name, and language from URL
   Sends all events to Supabase Edge Function: track-visitor
   ============================================================ */
(function () {
  "use strict";

  // ---------- CONFIG ----------
  const ENDPOINT = "https://fmrmiylqjokyrsztfmgp.supabase.co/functions/v1/track-visitor";
  const DEBUG = false; // set true to see logs in console

  // ---------- SITES CONFIG ----------
  const SITES = [
    { domain: "thikanadhabla.in", label: "Thikana Dhabla Ghosi" },
    { domain: "rajvardhansingh.in", label: "Rajvardhan Singh" },
  ];

  function detectSite() {
    const host = window.location.hostname.toLowerCase();
    const match = SITES.find((s) => host.includes(s.domain));
    return match ? match.label : host;
  }

  // ---------- PAGE + LANGUAGE DETECTION ----------
  function detectPageInfo() {
    const path = window.location.pathname.toLowerCase();
    const href = window.location.href;
    const site = detectSite();

    // Language from URL (/hi/ prefix)
    const lang = /\/hi(\/|$)/.test(path) ? "hi" : "en";

    // Page name — matches both sites
    let pageName = "Home";
    if (path.includes("history") || path.includes("itihas")) pageName = "History";
    else if (path.includes("familytree") || path.includes("vanshavali")) pageName = "Family Tree";
    else if (path.includes("map") || path.includes("sthan")) pageName = "Location & Map";
    else if (path.includes("dist") || path.includes("nirdeshika")) pageName = "Directory";
    else if (path.includes("about") || path.includes("parichay")) pageName = "About";
    else if (path.includes("contactus") || path.includes("contact") || path.includes("sampark")) pageName = "Contact";
    else if (path.includes("privacy")) pageName = "Privacy";
    else if (path.includes("sitemap")) pageName = "Sitemap";
    else if (path.endsWith("/") || path.endsWith("index.html")) pageName = "Home";

    return { pageName, lang, href, site };
  }

  // ---------- PERSISTENT IDS ----------
  function getUserId() {
    let id = localStorage.getItem("_ut_userId");
    if (!id) {
      id = "user_" + Date.now() + "_" + Math.random().toString(36).substring(2, 10);
      localStorage.setItem("_ut_userId", id);
    }
    return id;
  }

  function getSessionId() {
    let sid = sessionStorage.getItem("_ut_sessionId");
    if (!sid) {
      sid = "sess_" + Date.now() + "_" + Math.random().toString(36).substring(2, 10);
      sessionStorage.setItem("_ut_sessionId", sid);
    }
    return sid;
  }

  // ---------- GEO LOOKUP (cached per session) ----------
  async function getGeo() {
    try {
      const cached = sessionStorage.getItem("_ut_geo");
      if (cached) return JSON.parse(cached);

      const res = await fetch("https://ipapi.co/json/");
      const d = await res.json();
      const geo = {
        ip: d.ip || "",
        country: d.country_name || "",
        city: d.city || "",
        region: d.region || "",
        postal: d.postal || "",
        org: d.org || "",
        latitude: d.latitude || "",
        longitude: d.longitude || "",
        vpn: d.security && d.security.vpn ? "Yes" : "No",
      };
      sessionStorage.setItem("_ut_geo", JSON.stringify(geo));
      return geo;
    } catch (e) {
      return {
        ip: "", country: "", city: "", region: "",
        postal: "", org: "", latitude: "", longitude: "", vpn: "No",
      };
    }
  }

  // ---------- CORE SEND ----------
  async function track(eventData) {
    try {
      const info = detectPageInfo();
      const geo = await getGeo();

      const payload = {
        event_type: eventData.event_type || "pageview",
        site: info.site,
        page: info.href,
        page_name: info.pageName,
        page_lang: info.lang,
        referrer: document.referrer || "Direct",
        ip: geo.ip,
        country: geo.country,
        city: geo.city,
        region: geo.region,
        postal: geo.postal,
        org: geo.org,
        latitude: geo.latitude,
        longitude: geo.longitude,
        vpn: geo.vpn,
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

      const res = await fetch(ENDPOINT, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload),
      });

      if (DEBUG) console.log("📤 Tracked:", payload);
      if (!res.ok && DEBUG) console.warn("Tracking failed:", await res.text());
    } catch (e) {
      if (DEBUG) console.warn("Tracking error:", e);
    }
  }

  // ---------- PAGEVIEW ON LOAD ----------
  const startTime = Date.now();

  if (document.readyState === "complete") {
    setTimeout(() => track({ event_type: "pageview" }), 300);
  } else {
    window.addEventListener("load", () => {
      setTimeout(() => track({ event_type: "pageview" }), 300);
    });
  }

  // ---------- CLICK TRACKING ----------
  document.addEventListener("click", function (e) {
    const t = e.target;
    // Skip elements flagged with class "no-track"
    if (t.closest && t.closest(".no-track")) return;

    track({
      event_type: "click",
      element: t.tagName || "",
      element_id: t.id || "",
      element_class: typeof t.className === "string" ? t.className : "",
      click_time: new Date().toISOString(),
    });
  });

  // ---------- SCROLL TRACKING (at 25/50/75/100%) ----------
  let maxScroll = 0;
  let scrollTimer;
  window.addEventListener("scroll", function () {
    clearTimeout(scrollTimer);
    scrollTimer = setTimeout(function () {
      const docH = document.body.scrollHeight - window.innerHeight;
      if (docH <= 0) return;
      const pct = Math.min(100, Math.floor((window.scrollY / docH) * 100));

      // Only log at milestones: 25, 50, 75, 100
      const milestone = Math.floor(pct / 25) * 25;
      if (milestone > maxScroll && milestone > 0) {
        maxScroll = milestone;
        track({
          event_type: "scroll",
          scroll_percent: maxScroll,
          click_percent: maxScroll + "%",
        });
      }
    }, 400);
  });

  // ---------- TIME SPENT ON UNLOAD ----------
  let sent = false;
  function sendTimeSpent() {
    if (sent) return;
    sent = true;

    const seconds = Math.round((Date.now() - startTime) / 1000);
    if (seconds < 3) return; // ignore <3s visits

    const info = detectPageInfo();
    const geo = JSON.parse(sessionStorage.getItem("_ut_geo") || "{}");

    const payload = {
      event_type: "time_spent",
      site: info.site,
      page: info.href,
      page_name: info.pageName,
      page_lang: info.lang,
      ip: geo.ip || "",
      country: geo.country || "",
      city: geo.city || "",
      region: geo.region || "",
      latitude: geo.latitude || "",
      longitude: geo.longitude || "",
      time_spent: seconds,
      total_time: seconds,
      user_id: getUserId(),
      session_id: getSessionId(),
      device: /Mobi|Android/i.test(navigator.userAgent) ? "Mobile" : "Desktop",
      browser: navigator.userAgent,
      screen: screen.width + "x" + screen.height,
      language: navigator.language,
      timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
    };

    // Prefer sendBeacon for reliability on unload
    if (navigator.sendBeacon) {
      navigator.sendBeacon(
        ENDPOINT,
        new Blob([JSON.stringify(payload)], { type: "application/json" })
      );
    } else {
      fetch(ENDPOINT, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload),
        keepalive: true,
      });
    }
  }

  window.addEventListener("beforeunload", sendTimeSpent);
  window.addEventListener("pagehide", sendTimeSpent);

  if (DEBUG) {
    const info = detectPageInfo();
    console.log("📊 Tracker active:", info.site, "→", info.pageName, "(" + info.lang + ")");
  }
})();
