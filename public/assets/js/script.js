
//    HAMBURGER TOGGLE SCRIPT
const hamburger  = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobile-menu');

hamburger.addEventListener('click', () => {
    const isOpen = mobileMenu.classList.toggle('open');

    // Toggle hamburger icon → X
    hamburger.classList.toggle('open', isOpen);

    // Update ARIA for accessibility
    hamburger.setAttribute('aria-expanded', isOpen);
    hamburger.setAttribute('aria-label', isOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi');
});

// Close menu when a nav link is tapped
mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
        mobileMenu.classList.remove('open');
        hamburger.classList.remove('open');
        hamburger.setAttribute('aria-expanded', 'false');
        hamburger.setAttribute('aria-label', 'Buka menu navigasi');
    });
});

window.addEventListener('scroll', () => {
  const navbar = document.getElementById('navbar');
  if (window.scrollY > 50) {
    navbar.classList.add('bg-white', 'shadow-md');
  } else {
    navbar.classList.remove('bg-white', 'shadow-md');
  }
});

// ── Filter kategori aktif ──
const filterBtns = document.querySelectorAll('[aria-label="Filter Kategori"] button');
filterBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    filterBtns.forEach(b => {
      b.classList.remove('bg-primary');
      b.classList.add('bg-dark');
    });
    btn.classList.remove('bg-dark');
    btn.classList.add('bg-primary');
  });
});

document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filter-btn').forEach(b => {
      b.classList.remove('bg-primary');
      b.classList.add('bg-dark');
    });
    btn.classList.remove('bg-dark');
    btn.classList.add('bg-primary');
  });
});

// ── Modal: buka & tutup ──
function bukaModal() {
  const modal = document.getElementById('modal-gambar');
  modal.classList.remove('hidden');
  document.body.style.overflow = 'hidden'; // cegah scroll background
}

function tutupModal() {
  const modal = document.getElementById('modal-gambar');
  modal.classList.add('hidden');
  document.body.style.overflow = '';

  // Reset preview & input
  document.getElementById('file-input').value = '';
  const container = document.getElementById('preview-container');
  container.innerHTML = `
    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M7.5 8.25h.008v.008H7.5V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15A2.25 2.25 0 002.25 6.75v10.5A2.25 2.25 0 004.5 19.5z" />
    </svg>
  `;
}

// Tutup modal kalau tekan Escape
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') tutupModal();
});

// ── Preview gambar setelah dipilih ──
function tampilkanPreview(event) {
  const file = event.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = (e) => {
    const container = document.getElementById('preview-container');
    container.innerHTML = `
      <img src="${e.target.result}" alt="Preview gambar" class="w-full h-full object-cover" />
    `;
  };
  reader.readAsDataURL(file);
}

// ── Drag & drop ──
const dropZone = document.getElementById('drop-zone');

dropZone.addEventListener('dragover', (e) => {
  e.preventDefault();
  dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', () => {
  dropZone.classList.remove('dragover');
});

dropZone.addEventListener('drop', (e) => {
  e.preventDefault();
  dropZone.classList.remove('dragover');
  const file = e.dataTransfer.files[0];
  if (!file || !file.type.startsWith('image/')) return;

  const reader = new FileReader();
  reader.onload = (ev) => {
    const container = document.getElementById('preview-container');
    container.innerHTML = `
      <img src="${ev.target.result}" alt="Preview gambar" class="w-full h-full object-cover" />
    `;
  };
  reader.readAsDataURL(file);
});