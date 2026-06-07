// ChocoDelight Delivery Panel JavaScript

document.addEventListener('DOMContentLoaded', function () {
    // Mobile menu toggle
    const mobileToggle = document.getElementById('mobileToggle');
    const navMenu = document.getElementById('navMenu');

    if (mobileToggle && navMenu) {
        mobileToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            navMenu.classList.toggle('active');

            // Animate hamburger
            const spans = mobileToggle.querySelectorAll('span');
            if (navMenu.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translateY(8px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translateY(-8px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (e) {
            if (!navMenu.contains(e.target) && !mobileToggle.contains(e.target)) {
                navMenu.classList.remove('active');
                const spans = mobileToggle.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });

        // Close menu when clicking nav links
        navMenu.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                const spans = mobileToggle.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            });
        });
    }

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });

    // Add animation to stat cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.animation = 'slideUp 0.5s ease forwards';
                }, index * 100);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.style.opacity = '0';
        observer.observe(card);
    });

    // Add slideUp animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);

    // Confirm dialogs for important actions
    const confirmButtons = document.querySelectorAll('button[type="submit"]');
    confirmButtons.forEach(button => {
        const form = button.closest('form');
        if (form && form.hasAttribute('onsubmit')) {
            return; // Already has confirmation
        }

        if (button.name === 'mark_delivered' || button.name === 'collect_payment') {
            form.addEventListener('submit', function (e) {
                const action = button.textContent.trim();
                if (!confirm(`Are you sure you want to: ${action}?`)) {
                    e.preventDefault();
                }
            });
        }
    });

    // Table row hover effect
    const tableRows = document.querySelectorAll('.data-table tbody tr');
    tableRows.forEach(row => {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function (e) {
            // Don't trigger if clicking on a button or link
            if (e.target.tagName !== 'BUTTON' && e.target.tagName !== 'A' && !e.target.closest('button') && !e.target.closest('a')) {
                const viewButton = this.querySelector('a[href*="view_order"]');
                if (viewButton) {
                    window.location.href = viewButton.href;
                }
            }
        });
    });

    // Copy order number on click
    const orderNumbers = document.querySelectorAll('.order-id strong, .order-item .order-header strong');
    orderNumbers.forEach(element => {
        element.style.cursor = 'pointer';
        element.title = 'Click to copy order number';
        element.addEventListener('click', function (e) {
            e.stopPropagation();
            const text = this.textContent;

            // Modern clipboard API
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    showToast('Order number copied!', 'success');
                });
            } else {
                // Fallback for older browsers
                const input = document.createElement('input');
                input.value = text;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                showToast('Order number copied!', 'success');
            }
        });
    });

    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type}`;
        toast.style.position = 'fixed';
        toast.style.top = '20px';
        toast.style.right = '20px';
        toast.style.zIndex = '9999';
        toast.style.minWidth = '250px';
        toast.style.animation = 'slideInRight 0.3s ease';
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    // Add toast animations
    const toastStyle = document.createElement('style');
    toastStyle.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(toastStyle);

    // Search functionality
    const searchInput = document.getElementById('searchOrders');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.data-table tbody tr, .order-item');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        }, 300));
    }

    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func.apply(this, args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Print invoice button
    const printButtons = document.querySelectorAll('.print-invoice, [data-action="print"]');
    printButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            window.print();
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading state to form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.dataset.loading) {
                const originalText = submitBtn.innerHTML;
                submitBtn.dataset.originalText = originalText;
                submitBtn.innerHTML = '⏳ Processing...';
                submitBtn.disabled = true;
                submitBtn.dataset.loading = 'true';

                // Re-enable if form validation fails
                setTimeout(() => {
                    if (submitBtn.dataset.loading) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                        delete submitBtn.dataset.loading;
                    }
                }, 100);
            }
        });
    });

    // Initialize tooltips (if any)
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(element => {
        element.addEventListener('mouseenter', function () {
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.textContent = this.dataset.tooltip;
            tooltip.style.position = 'absolute';
            tooltip.style.background = '#333';
            tooltip.style.color = 'white';
            tooltip.style.padding = '8px 12px';
            tooltip.style.borderRadius = '6px';
            tooltip.style.fontSize = '13px';
            tooltip.style.zIndex = '10000';
            tooltip.style.pointerEvents = 'none';

            document.body.appendChild(tooltip);

            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';

            this.tooltipElement = tooltip;
        });

        element.addEventListener('mouseleave', function () {
            if (this.tooltipElement) {
                this.tooltipElement.remove();
                delete this.tooltipElement;
            }
        });
    });

    // Check if hash exists in URL (for direct actions)
    if (window.location.hash) {
        const target = document.querySelector(window.location.hash);
        if (target) {
            setTimeout(() => {
                target.scrollIntoView({ behavior: 'smooth' });
                // Highlight the target briefly
                target.style.animation = 'highlight 2s ease';
            }, 500);
        }
    }

    // Add highlight animation
    const highlightStyle = document.createElement('style');
    highlightStyle.textContent = `
        @keyframes highlight {
            0%, 100% { background: transparent; }
            50% { background: rgba(139, 69, 19, 0.1); }
        }
    `;
    document.head.appendChild(highlightStyle);

    // Auto-refresh order status (every 2 minutes)
    if (window.location.pathname.includes('dashboard') || window.location.pathname.includes('orders')) {
        let refreshInterval = setInterval(() => {
            // You can add AJAX call here to refresh order counts
            console.log('Auto-refresh triggered');
        }, 120000); // 2 minutes

        // Clear interval when leaving page
        window.addEventListener('beforeunload', () => {
            clearInterval(refreshInterval);
        });
    }

    console.log('ChocoDelight Delivery Panel initialized successfully! 🍫');
});