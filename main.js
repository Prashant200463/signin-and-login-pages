const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');
const btnPrivacy = document.getElementById('btn-privacy');
const privacyModal = document.getElementById('privacy-policy');
const closeBtn = privacyModal.querySelector('.close-btn');

// Toggle mobile menu
hamburger.addEventListener('click', () => {
  const isOpen = navLinks.classList.toggle('open');
  hamburger.setAttribute('aria-expanded', isOpen);
});
hamburger.addEventListener('keydown', (e) => {
  if (e.key === 'Enter' || e.key === ' ') {
    e.preventDefault();
    hamburger.click();
  }
});

// Show Privacy Policy modal
btnPrivacy.addEventListener('click', () => {
  privacyModal.classList.add('active');
  privacyModal.focus();
});

// Close Privacy Policy modal
closeBtn.addEventListener('click', () => {
  privacyModal.classList.remove('active');
  btnPrivacy.focus();
});

// Close modal on outside click
privacyModal.addEventListener('click', (e) => {
  if (e.target === privacyModal) {
    privacyModal.classList.remove('active');
    btnPrivacy.focus();
  }
});

// Close modal on ESC key
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape' && privacyModal.classList.contains('active')) {
    privacyModal.classList.remove('active');
    btnPrivacy.focus();
  }
});

// Home and Edit button placeholders
document.getElementById('btn-home').addEventListener('click', () => {
  alert('Home button clicked! Navigate or update content as needed.');
});
document.getElementById('btn-edit').addEventListener('click', () => {
  alert('Edit button clicked! Implement your edit functionality.');
});

// CTA button interaction
document.getElementById('cta-button').addEventListener('click', () => {
  alert('Get Started clicked! Integrate your call to action.');
});

// Typing animation for welcome text (continuous loop)
window.addEventListener('DOMContentLoaded', () => {
  const headlineText = "";
  const typingElement = document.getElementById('main-heading');
  let charIndex = 0;
  let typingDelay = 100;
  let pauseDelay = 1500;
  let deleting = false;

  function type() {
    if (!deleting && charIndex <= headlineText.length) {
      typingElement.textContent = headlineText.substring(0, charIndex);
      charIndex++;
      if (charIndex <= headlineText.length) {
        setTimeout(type, typingDelay);
      } else {
        setTimeout(() => {
          deleting = true;
          setTimeout(type, typingDelay);
        }, pauseDelay);
      }
    } else if (deleting && charIndex >= 0) {
      typingElement.textContent = headlineText.substring(0, charIndex);
      charIndex--;
      if (charIndex >= 0) {
        setTimeout(type, typingDelay / 2);
      } else {
        deleting = false;
        setTimeout(type, typingDelay);
      }
    }
  }

  type();
});