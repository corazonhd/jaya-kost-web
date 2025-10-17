document.addEventListener('DOMContentLoaded', () => {

    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    const menuOverlay = document.querySelector('.menu-overlay');
    const navLinkItems = document.querySelectorAll('.nav-links a');

    // Toggle mobile menu
    function toggleMobileMenu() {
        hamburger.classList.toggle('active');
        navLinks.classList.toggle('active');
        menuOverlay.classList.toggle('active');
 
        document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : 'auto';
    }

    function closeMobileMenu() {
        hamburger.classList.remove('active');
        navLinks.classList.remove('active');
        menuOverlay.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    if (hamburger) {
        hamburger.addEventListener('click', toggleMobileMenu);
    }

    if (menuOverlay) {
        menuOverlay.addEventListener('click', closeMobileMenu);
    }

    navLinkItems.forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeMobileMenu();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMobileMenu();
        }
    });

    // Status Kamar
    function loadKamarStatus() {
        fetch('/api/kamar-status')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    data.data.forEach(kamar => {
                        const kamarElement = document.querySelector(`.kamar[data-kamar-id="${kamar.nama_kamar}"]`);
                        if (kamarElement) {
                            const statusSpan = kamarElement.querySelector('.status');
                            kamarElement.classList.remove('booked');
                            if (kamar.status === 'Booked') {
                                kamarElement.classList.add('booked');
                                kamarElement.classList.add('no-interaction');
                            } else {
                                kamarElement.classList.remove('no-interaction');
                            }
                            statusSpan.textContent = kamar.status;
                        }
                    });
                } else {
                    console.error('Failed to retrieve room status from database:', data.message);
                }
            })
            .catch(error => {
                console.error('Error fetching room status:', error);
                alert('Failed to load room availability status. Please try refreshing the page.');
            }
        );
    }

    // Booking
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        loadKamarStatus();
        const selectedRoomDisplay = document.getElementById('selectedRoom');
        const hiddenRoomInput = document.getElementById('kamar_dipilih');
        const hargaPerBulanInput = document.getElementById('harga_per_bulan');
        const durasiSewaInput = document.getElementById('durasi_sewa');
        const dpToggle = document.getElementById('dpToggle');
        const totalHargaDisplay = document.getElementById('totalHarga');
        
        const hargaBlok = {
            'A': 1000000,
            'B': 1200000,
            'C': 1200000
        };

        function hitungTotalHarga() {
            const durasi = parseInt(durasiSewaInput.value) || 0;
            const harga = parseInt(hargaPerBulanInput.value) || 0;
            let total = durasi * harga;

            if (dpToggle.checked) {
                total = total * 0.30;
            }

            totalHargaDisplay.textContent = `Rp. ${total.toLocaleString('id-ID')}`;
        }

        // Memilih kamar
        document.querySelectorAll('.kamar').forEach(kamar => {
            kamar.addEventListener('click', () => {
                if (!kamar.classList.contains('booked')) {
                    document.querySelectorAll('.kamar.selected').forEach(selectedKamar => {
                        selectedKamar.classList.remove('selected');
                    });
                    
                    kamar.classList.add('selected');
                    
                    const selectedRoomName = kamar.getAttribute('data-kamar-id');
                    const blok = selectedRoomName.charAt(0);
                    const harga = hargaBlok[blok];

                    selectedRoomDisplay.textContent = selectedRoomName;
                    hiddenRoomInput.value = selectedRoomName;
                    hargaPerBulanInput.value = harga;
                    
                    hitungTotalHarga();
                }
            });
        });

        durasiSewaInput.addEventListener('input', hitungTotalHarga);
        dpToggle.addEventListener('change', hitungTotalHarga);

        // Form Booking Logic
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const selectedRoom = hiddenRoomInput.value;

            // Validasi harga
            const hargaPerBulan = parseInt(hargaPerBulanInput.value);
            if (!selectedRoom || isNaN(hargaPerBulan) || hargaPerBulan <= 0) {
                alert('Silakan pilih salah satu kamar terlebih dahulu.');
                return;
            }

            const formData = new FormData(this);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            formData.append('_token', csrfToken);
            formData.append('is_dp', dpToggle.checked ? 'true' : 'false');

            fetch(this.action || `${window.location.origin}/api/bookings`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify(Object.fromEntries(formData))
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect_url;
                } else {
                    alert('Pemesanan gagal: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim pemesanan. Detail: ' + error.message);
            });
        });
    }

    // Hero Section Slideshow
    const heroSlides = document.querySelectorAll('.hero-slide');
    if (heroSlides.length > 0) {
        const heroDotsContainer = document.querySelector('.hero-dots');
        let heroCurrentIndex = 0;
        let slideshowInterval;
        let activeFilter = 'blok-A';

        function getFilteredSlides() {
            return document.querySelectorAll(`.hero-slide.${activeFilter}`);
        }

        function updateDots() {
            heroDotsContainer.innerHTML = '';
            const filteredSlides = getFilteredSlides();
            filteredSlides.forEach((_, index) => {
                const dot = document.createElement('div');
                dot.classList.add('hero-dot');
                dot.dataset.index = index;
                dot.addEventListener('click', () => {
                    clearInterval(slideshowInterval);
                    heroCurrentIndex = index;
                    showHeroSlide(heroCurrentIndex);
                    startSlideshow();
                });
                heroDotsContainer.appendChild(dot);
            });
        }

        function showHeroSlide(index) {
            const filteredSlides = getFilteredSlides();
            const heroDots = document.querySelectorAll('.hero-dot');
            document.querySelectorAll('.hero-slide').forEach(slide => slide.classList.remove('active'));
            heroCurrentIndex = (index + filteredSlides.length) % filteredSlides.length;
            filteredSlides[heroCurrentIndex].classList.add('active');
            heroDots.forEach(dot => dot.classList.remove('active'));
            if (heroDots[heroCurrentIndex]) {
                heroDots[heroCurrentIndex].classList.add('active');
            }
        }

        function nextHeroSlide() {
            heroCurrentIndex++;
            showHeroSlide(heroCurrentIndex);
        }

        function startSlideshow() {
            clearInterval(slideshowInterval);
            slideshowInterval = setInterval(nextHeroSlide, 3000);
        }

        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                activeFilter = button.dataset.filter;
                heroCurrentIndex = 0;
                
                updateDots();
                showHeroSlide(heroCurrentIndex);
                startSlideshow();
            });
        });

        updateDots();
        showHeroSlide(heroCurrentIndex);
        startSlideshow();
    }

    // Form Submission
    const pertanyaanForm = document.getElementById('pertanyaanForm');
    if (pertanyaanForm) {
        pertanyaanForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            formData.append('_token', csrfToken);

            fetch('/save-message', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    pertanyaanForm.reset();
                } else {
                    alert('Failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred.');
            });
        });
    }

    // Navbar logic
    let prevScrollPos = window.pageYOffset;
    const navbar = document.querySelector(".navbar");
    window.onscroll = function() {
        let currentScrollPos = window.pageYOffset;
        
        // Hide navbar on scroll
        if (!navLinks.classList.contains('active')) {
            if (prevScrollPos > currentScrollPos) {
                navbar.classList.remove("hide");
            } else {
                navbar.classList.add("hide");
            }
        }
        prevScrollPos = currentScrollPos;
    }
});
