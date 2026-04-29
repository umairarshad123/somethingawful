// Digirisers — interactions

// Sticky nav shadow on scroll
const nav = document.getElementById('nav');
const onScroll = () => {
  if (window.scrollY > 8) nav.classList.add('scrolled');
  else nav.classList.remove('scrolled');
};
window.addEventListener('scroll', onScroll, { passive: true });
onScroll();

// Mobile menu toggle
const navToggle = document.getElementById('navToggle');
navToggle?.addEventListener('click', () => {
  const open = nav.classList.toggle('open');
  navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
});

document.querySelectorAll('.nav-links a').forEach(link => {
  link.addEventListener('click', () => {
    nav.classList.remove('open');
    navToggle?.setAttribute('aria-expanded', 'false');
  });
});

// Year
const yearEl = document.getElementById('year');
if (yearEl) yearEl.textContent = new Date().getFullYear();

// Reveal-on-scroll
const revealTargets = document.querySelectorAll(
  '.service-card, .stat-card, .step, .tcard, .industry, .hero-copy, .hero-visual, .section-head, .contact-card, .footer-cta'
);
revealTargets.forEach(el => el.classList.add('reveal'));

const io = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('in');
      io.unobserve(entry.target);
    }
  });
}, { threshold: 0.12 });

revealTargets.forEach(el => io.observe(el));

// Service-card cursor spotlight
document.querySelectorAll('.service-card').forEach(card => {
  card.addEventListener('mousemove', (e) => {
    const rect = card.getBoundingClientRect();
    const x = ((e.clientX - rect.left) / rect.width) * 100;
    const y = ((e.clientY - rect.top) / rect.height) * 100;
    card.style.setProperty('--mx', x + '%');
    card.style.setProperty('--my', y + '%');
  });
});

// Count-up stats
const counters = document.querySelectorAll('.stat-num[data-count]');
const countIO = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    const el = entry.target;
    const target = parseFloat(el.dataset.count);
    const duration = 1600;
    const start = performance.now();
    const isFloat = !Number.isInteger(target);
    const tick = (now) => {
      const progress = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      const val = target * eased;
      el.textContent = isFloat ? val.toFixed(1) : Math.floor(val);
      if (progress < 1) requestAnimationFrame(tick);
      else el.textContent = isFloat ? target.toFixed(1) : target;
    };
    requestAnimationFrame(tick);
    countIO.unobserve(el);
  });
}, { threshold: 0.4 });
counters.forEach(el => countIO.observe(el));

// Smooth scroll offset for anchor links (accounts for sticky nav)
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', (e) => {
    const id = a.getAttribute('href');
    if (id.length < 2) return;
    const target = document.querySelector(id);
    if (!target) return;
    e.preventDefault();
    const y = target.getBoundingClientRect().top + window.scrollY - 80;
    window.scrollTo({ top: y, behavior: 'smooth' });
  });
});

// Contact form → WhatsApp
const WA_NUMBER = '14019987807'; // +1 (401) 998-7807, digits only

const form = document.getElementById('leadForm');
const formNote = document.getElementById('formNote');

form?.addEventListener('submit', (e) => {
  e.preventDefault();

  const data = new FormData(form);
  const name    = (data.get('name')    || '').toString().trim();
  const email   = (data.get('email')   || '').toString().trim();
  const phone   = (data.get('phone')   || '').toString().trim();
  const service = (data.get('service') || '').toString().trim();
  const message = (data.get('message') || '').toString().trim();
  const consentTx = form.querySelector('#consentTx').checked;
  const consentMk = form.querySelector('#consentMk').checked;

  if (!name || !email || !phone || !service) {
    alert('Please fill in your name, email, phone, and primary interest.');
    return;
  }
  if (!consentTx) {
    alert('Please accept the non-marketing text message consent to continue.');
    form.querySelector('#consentTx').focus();
    return;
  }
  if (!consentMk) {
    alert('Please accept the marketing text message consent to continue.');
    form.querySelector('#consentMk').focus();
    return;
  }

  const lines = [
    '*New inquiry from Digirisers website*',
    '',
    `*Name:* ${name}`,
    `*Email:* ${email}`,
    `*Phone:* ${phone}`,
    `*Primary interest:* ${service}`,
  ];
  if (message) {
    lines.push('', '*Goals / message:*', message);
  }
  lines.push(
    '',
    '— Consents —',
    `Non-marketing texts (EARNWITHDON CORP): ${consentTx ? 'Yes' : 'No'}`,
    `Marketing / promotional texts (EarnWithDon Corp): ${consentMk ? 'Yes' : 'No'}`,
    '',
    `Submitted: ${new Date().toLocaleString()}`
  );

  const text = encodeURIComponent(lines.join('\n'));
  const url  = `https://wa.me/${WA_NUMBER}?text=${text}`;

  const btn = form.querySelector('button[type="submit"]');
  btn.disabled = true;
  const originalHTML = btn.innerHTML;
  btn.innerHTML = 'Opening WhatsApp…';

  // Open WhatsApp in a new tab (falls back to same tab if blocked)
  const win = window.open(url, '_blank');
  if (!win) window.location.href = url;

  formNote.hidden = false;

  setTimeout(() => {
    btn.disabled = false;
    btn.innerHTML = originalHTML;
    form.reset();
    setTimeout(() => { formNote.hidden = true; }, 6000);
  }, 1200);
});
