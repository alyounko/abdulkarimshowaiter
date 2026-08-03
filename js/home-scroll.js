/**
 * home-scroll.js — Homepage scroll effects and hero interactions.
 */
document.addEventListener('DOMContentLoaded', function() {

    // Hero panel close button
    var heroClose = document.getElementById('hero-close');
    var heroPanel = document.getElementById('hero-panel');
    if (heroClose && heroPanel) {
        heroClose.addEventListener('click', function() {
            heroPanel.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            heroPanel.style.opacity = '0';
            heroPanel.style.transform = 'translateY(-20px)';
            setTimeout(function() { heroPanel.style.display = 'none'; }, 400);
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('.smooth-scroll').forEach(function(anchor) {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // === Scroll Progress Bar ===
    var progressBar = document.getElementById('scrollProgress');
    var particlesContainer = document.getElementById('scrollParticles');
    var lastScrollY = 0;
    var particleCount = 0;
    if (progressBar) {
        window.addEventListener('scroll', function() {
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            var docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
            progressBar.style.height = progress + '%';

            // Spawn ink particles on scroll
            if (particlesContainer && Math.abs(scrollTop - lastScrollY) > 30 && particleCount < 20) {
                var particle = document.createElement('div');
                particle.className = 'scroll-particle';
                particle.style.top = progress + '%';
                particle.style.animationDelay = Math.random() * 0.5 + 's';
                particlesContainer.appendChild(particle);
                particleCount++;
                setTimeout(function() {
                    if (particle.parentNode) particle.parentNode.removeChild(particle);
                    particleCount--;
                }, 1500);
            }
            lastScrollY = scrollTop;
        }, { passive: true });
    }

    // === Typing Effect ===
    var typingEl = document.getElementById('heroTyping');
    if (typingEl) {
        var phrases = ['الطبيب', 'الشاعر', 'والفنان التشكيلي'];
        var phraseIndex = 0;
        var charIndex = 0;
        var isDeleting = false;
        var typeSpeed = 100;

        function typeLoop() {
            var current = phrases[phraseIndex];
            if (isDeleting) {
                charIndex--;
                typeSpeed = 50;
            } else {
                charIndex++;
                typeSpeed = 100;
            }

            typingEl.textContent = current.substring(0, charIndex);

            if (!isDeleting && charIndex === current.length) {
                typeSpeed = 2000;
                isDeleting = true;
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                phraseIndex = (phraseIndex + 1) % phrases.length;
                typeSpeed = 400;
            }

            setTimeout(typeLoop, typeSpeed);
        }
        setTimeout(typeLoop, 800);
    }

    // === Animated Stats Counter ===
    var statNumbers = document.querySelectorAll('.stat-number[data-target]');
    if (statNumbers.length > 0) {
        var statsObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(function(el) { statsObserver.observe(el); });
    }

    function animateCounter(el) {
        var target = parseInt(el.getAttribute('data-target'));
        var current = 0;
        var increment = Math.max(1, Math.floor(target / 60));
        var duration = 1500;
        var stepTime = duration / (target / increment);

        var timer = setInterval(function() {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.textContent = current;
        }, stepTime);
    }

    // === Intersection Observer for scroll animations ===
    var observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };

    var scrollObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal-up, .reveal-scale, .reveal-left, .reveal-right').forEach(function(el) {
        scrollObserver.observe(el);
    });

    // === Scroll-Pinned Quote Carousel ===
    var quoteWrapper = document.getElementById('quotePinWrapper');
    var quoteSection = document.getElementById('quoteSection');
    var carousel = document.getElementById('quoteCarousel');
    var dots = document.querySelectorAll('.quote-dot');
    var slides = document.querySelectorAll('.quote-slide');
    var quoteProgressBar = document.getElementById('quoteProgressBar');
    var totalQuotes = slides.length;
    var currentQuote = -1;
    var ticking = false;

    function setActiveQuote(index) {
        if (index === currentQuote || index < 0 || index >= totalQuotes) return;
        currentQuote = index;
        slides.forEach(function(s, i) {
            s.classList.toggle('active', i === index);
        });
        dots.forEach(function(d, i) {
            d.classList.toggle('active', i === index);
        });
        if (quoteProgressBar) {
            var pct = ((index + 1) / totalQuotes) * 100;
            quoteProgressBar.style.setProperty('--progress', pct + '%');
        }
    }

    function onQuoteScroll() {
        if (!quoteWrapper) return;
        var rect = quoteWrapper.getBoundingClientRect();
        var wrapperH = quoteWrapper.offsetHeight;
        var viewH = window.innerHeight;
        var scrollable = wrapperH - viewH;
        if (scrollable <= 0) return;

        var scrolled = -rect.top;
        if (scrolled < 0 || scrolled > scrollable) return;

        var progress = Math.max(0, Math.min(1, scrolled / scrollable));
        var rawIndex = progress * totalQuotes;
        var idx = Math.min(Math.floor(rawIndex), totalQuotes - 1);
        setActiveQuote(idx);
    }

    if (quoteWrapper) {
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    onQuoteScroll();
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });

        onQuoteScroll();
    }
});
