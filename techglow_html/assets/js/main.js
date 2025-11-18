/**
 * TechGlow Main JavaScript
 * Handles interactive features and enhancements
 */

(function() {
    'use strict';

    // ==================== DOM Ready ====================
    document.addEventListener('DOMContentLoaded', function() {
        initBackToTop();
        initSmoothScroll();
        initFormValidation();
        initCardAnimations();
        initNavbarScroll();
    });

    // ==================== Back to Top Button ====================
    function initBackToTop() {
        const backToTopBtn = document.getElementById('backToTop');

        if (!backToTopBtn) return;

        // Show/hide button on scroll
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });

        // Scroll to top on click
        backToTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // ==================== Smooth Scroll ====================
    function initSmoothScroll() {
        const links = document.querySelectorAll('a[href^="#"]');

        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');

                if (href === '#' || href === '#!') return;

                const target = document.querySelector(href);

                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    // ==================== Form Validation ====================
    function initFormValidation() {
        const forms = document.querySelectorAll('.needs-validation');

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
    }

    // ==================== Card Animations ====================
    function initCardAnimations() {
        const cards = document.querySelectorAll('.hover-lift');

        // Intersection Observer for fade-in animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        cards.forEach(card => {
            observer.observe(card);
        });
    }

    // ==================== Navbar Scroll Effect ====================
    function initNavbarScroll() {
        const navbar = document.querySelector('.navbar');

        if (!navbar) return;

        let lastScroll = 0;

        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            // Add shadow on scroll
            if (currentScroll > 50) {
                navbar.classList.add('shadow');
            } else {
                navbar.classList.remove('shadow');
            }

            lastScroll = currentScroll;
        });
    }

    // ==================== Search Functionality ====================
    function initSearch() {
        const searchInput = document.querySelector('input[name="search"]');

        if (!searchInput) return;

        // Auto-submit search form on Enter key
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    }

    // ==================== View Counter (AJAX) ====================
    function incrementViewCount(type, id) {
        // This function can be used to increment view counts via AJAX
        // Example implementation for future use
        fetch('includes/increment_view.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                type: type,
                id: id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('View count incremented');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // ==================== Copy to Clipboard ====================
    function copyToClipboard(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                showNotification('Copied to clipboard!', 'success');
            }).catch(err => {
                console.error('Failed to copy:', err);
            });
        } else {
            // Fallback for older browsers
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            showNotification('Copied to clipboard!', 'success');
        }
    }

    // ==================== Show Notification ====================
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(notification);

        // Auto-remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // ==================== Lazy Loading Images ====================
    function initLazyLoading() {
        const images = document.querySelectorAll('img[data-src]');

        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    }

    // ==================== External Links ====================
    function initExternalLinks() {
        const externalLinks = document.querySelectorAll('a[target="_blank"]');

        externalLinks.forEach(link => {
            // Add rel attributes for security
            if (!link.hasAttribute('rel')) {
                link.setAttribute('rel', 'noopener noreferrer');
            }

            // Add external link icon
            if (!link.querySelector('.external-icon')) {
                const icon = document.createElement('i');
                icon.className = 'bi bi-box-arrow-up-right ms-1 external-icon';
                icon.style.fontSize = '0.8em';
                link.appendChild(icon);
            }
        });
    }

    // ==================== Local Storage Helper ====================
    const Storage = {
        set: function(key, value) {
            try {
                localStorage.setItem(key, JSON.stringify(value));
                return true;
            } catch (e) {
                console.error('Storage error:', e);
                return false;
            }
        },
        get: function(key) {
            try {
                const item = localStorage.getItem(key);
                return item ? JSON.parse(item) : null;
            } catch (e) {
                console.error('Storage error:', e);
                return null;
            }
        },
        remove: function(key) {
            try {
                localStorage.removeItem(key);
                return true;
            } catch (e) {
                console.error('Storage error:', e);
                return false;
            }
        }
    };

    // ==================== Theme Switcher (Optional) ====================
    function initThemeSwitcher() {
        const savedTheme = Storage.get('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);

        const themeSwitcher = document.getElementById('themeSwitcher');
        if (themeSwitcher) {
            themeSwitcher.addEventListener('click', function() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';

                document.documentElement.setAttribute('data-theme', newTheme);
                Storage.set('theme', newTheme);
            });
        }
    }

    // ==================== Performance Monitoring ====================
    function logPerformance() {
        if ('performance' in window) {
            window.addEventListener('load', function() {
                const perfData = window.performance.timing;
                const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
                console.log('Page Load Time:', pageLoadTime + 'ms');
            });
        }
    }

    // ==================== Error Handling ====================
    window.addEventListener('error', function(e) {
        console.error('JavaScript Error:', e.message);
        // You can send this to a logging service
    });

    // ==================== Public API ====================
    window.TechGlow = {
        copyToClipboard: copyToClipboard,
        showNotification: showNotification,
        incrementViewCount: incrementViewCount,
        Storage: Storage
    };

    // Optional: Initialize additional features
    // initLazyLoading();
    // initExternalLinks();
    // initThemeSwitcher();
    // logPerformance();

})();
