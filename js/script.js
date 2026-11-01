$(window).on('load',function(){
    $('.burger-menu').click(function(){
       $('.main-menu').slideToggle(100);
    });

    $('.arrow-sub').click(function(){
        var el = $(this);

        el.parent().find('.submenu').slideToggle(100);
    })

    $('.filter-buttons-toggle').click(function(){
       $('.filters-form').slideToggle();
    });

    $('.filters-form').on('change', function(){
        $('.filters-form').submit();
    });

    $('.loader svg').addClass('active');
    setTimeout(function(){
        $('.loader').fadeOut();
    },1200);

});


$('.popin-contact .close').click(function(){
    $('.popin-contact').slideUp();
});

$(function () {
    var $nav = $('.ancres');

    if (!$nav.length) {
        return;
    }

    var $links = $nav.find('[data-ancre]');
    var ids = $links.map(function () {
        return this.getAttribute('data-ancre');
    }).get();
    var sections = ids.map(function (id) {
        return document.getElementById(id);
    }).filter(Boolean);

    function offset() {
        return $nav.outerHeight() || 0;
    }

    function setActive(id) {
        $links.each(function () {
            $(this).toggleClass('is-active', this.getAttribute('data-ancre') === id);
        });
    }

    $nav.on('click', '[data-ancre]', function (event) {
        var target = document.getElementById(this.getAttribute('data-ancre'));

        if (!target) {
            return;
        }

        event.preventDefault();
        window.scrollTo({
            top: target.getBoundingClientRect().top + window.pageYOffset - offset() + 1,
            behavior: 'smooth'
        });
        history.replaceState(null, '', '#' + target.id);
        setActive(target.id);
    });

    if (!('IntersectionObserver' in window) || !sections.length) {
        return;
    }

    var observer = new IntersectionObserver(function (entries) {
        var visible = entries
            .filter(function (entry) { return entry.isIntersecting; })
            .sort(function (a, b) { return a.boundingClientRect.top - b.boundingClientRect.top; });

        if (visible.length) {
            setActive(visible[0].target.id);
        }
    }, {
        rootMargin: '-' + Math.max(offset(), 1) + 'px 0px -55% 0px',
        threshold: 0
    });

    sections.forEach(function (section) {
        observer.observe(section);
    });
});

$(document).on('click', '.site-header__burger', function () {
    var isOpen = $(this).closest('.site-header').toggleClass('is-nav-open').hasClass('is-nav-open');

    $(this).attr('aria-expanded', isOpen).attr('aria-label', isOpen ? 'Fermer le menu' : 'Ouvrir le menu');
});

$(document).on('click', '.push-actu__close', function () {
    $(this).closest('.push-actu').addClass('is-hidden');
});

$(function () {
    var reducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    $('.campus__slider').each(function () {
        var $slider = $(this);
        var $track = $slider.find('.campus__track');
        var total = $track.children().length;

        if (total < 2) {
            $slider.find('.campus__nav').hide();
            return;
        }

        var delay = parseInt($slider.data('autoplay'), 10) || 5000;
        var current = 0;
        var timer = null;

        function goTo(index) {
            current = (index + total) % total;
            $track.css('transform', 'translateX(-' + (current * 100) + '%)');
        }

        function stop() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        function play() {
            if (reducedMotion) {
                return;
            }

            stop();
            timer = setInterval(function () {
                goTo(current + 1);
            }, delay);
        }

        $slider.on('click', '.campus__arrow--next', function () {
            goTo(current + 1);
            play();
        });

        $slider.on('click', '.campus__arrow--prev', function () {
            goTo(current - 1);
            play();
        });

        $slider.on('mouseenter focusin', stop).on('mouseleave focusout', play);

        play();
    });
});

$(function () {
    var marks = document.querySelectorAll('[data-mot-parallax]');
    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!marks.length || reducedMotion) {
        return;
    }

    var ticking = false;

    function tick() {
        var viewMid = window.innerHeight * 0.5;

        Array.prototype.forEach.call(marks, function (node) {
            var speed = parseFloat(node.getAttribute('data-parallax-speed') || '0.12');
            var rect = node.getBoundingClientRect();
            var center = rect.top + rect.height * 0.5;
            var shift = Math.max(-42, Math.min(42, (viewMid - center) * speed));
            node.style.transform = 'translate3d(0, ' + shift + 'px, 0)';
        });
    }

    function onScroll() {
        if (ticking) {
            return;
        }

        ticking = true;
        window.requestAnimationFrame(function () {
            tick();
            ticking = false;
        });
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll);
    onScroll();
});

$(function () {
    var sections = document.querySelectorAll('[data-heritage]');
    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!sections.length) {
        return;
    }

    Array.prototype.forEach.call(sections, function (section) {
        var steps = section.querySelectorAll('[data-heritage-step]');
        var parallaxNodes = section.querySelectorAll('[data-heritage-parallax]');
        var progress = section.querySelector('[data-heritage-progress]');
        var flow = section.querySelector('.heritage__frieze');
        var ticking = false;

        function setProgress() {
            if (!progress || !flow) {
                return;
            }

            var flowRect = flow.getBoundingClientRect();
            var viewport = window.innerHeight;
            var total = flow.offsetHeight - viewport * 0.35;
            var scrolled = viewport * 0.35 - flowRect.top;

            if (total <= 0) {
                return;
            }

            var ratio = Math.max(0, Math.min(1, scrolled / total));
            progress.style.setProperty('--heritage-progress', String(ratio * 100));
        }

        function parallaxTick() {
            setProgress();

            if (reducedMotion) {
                return;
            }

            var viewMid = window.innerHeight * 0.45;
            var drifts = section.querySelectorAll('[data-heritage-drift]');

            Array.prototype.forEach.call(parallaxNodes, function (node) {
                var speed = parseFloat(node.getAttribute('data-parallax-speed') || '0.06');
                var rect = node.getBoundingClientRect();
                var center = rect.top + rect.height * 0.5;
                var shift = Math.max(-28, Math.min(28, (viewMid - center) * speed));
                var img = node.querySelector('img');

                if (img) {
                    img.style.transform = 'translate3d(0, calc(-10% + ' + shift + 'px), 0)';
                }
            });

            Array.prototype.forEach.call(drifts, function (node) {
                var speed = parseFloat(node.getAttribute('data-parallax-speed') || '0.16');
                var rect = node.getBoundingClientRect();
                var center = rect.top + rect.height * 0.5;
                var shift = Math.max(-56, Math.min(56, (viewMid - center) * speed));
                node.style.transform = 'translate3d(0, ' + shift + 'px, 0)';
            });
        }

        function onScroll() {
            if (ticking) {
                return;
            }

            ticking = true;
            window.requestAnimationFrame(function () {
                parallaxTick();
                ticking = false;
            });
        }

        if ('IntersectionObserver' in window && steps.length) {
            var observer = new IntersectionObserver(function (entries) {
                Array.prototype.forEach.call(entries, function (entry) {
                    entry.target.classList.toggle('is-active', entry.isIntersecting);
                });
            }, { rootMargin: '-35% 0px -35% 0px', threshold: 0 });

            Array.prototype.forEach.call(steps, function (step) {
                observer.observe(step);
            });
        }

        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll);
        onScroll();
    });
});

$(function () {
    // Survoler une entrée du méga-menu bascule le visuel de gauche.
    $('[data-submenu]').each(function () {
        var $item = $(this);
        var $links = $item.find('[data-submenu-target]');
        var $visuals = $item.find('[data-submenu-visual]');
        var $trigger = $item.children('.site-header__link');

        function activate(index) {
            $links.each(function () {
                $(this).toggleClass('is-active', $(this).data('submenu-target') === index);
            });

            $visuals.each(function () {
                $(this).toggleClass('is-active', $(this).data('submenu-visual') === index);
            });
        }

        $links.on('mouseenter focus', function () {
            activate($(this).data('submenu-target'));
        });

        $item.on('mouseenter focusin', function () {
            $item.addClass('is-open');
            $trigger.attr('aria-expanded', 'true');
        });

        $item.on('mouseleave focusout', function () {
            if ($item.has(document.activeElement).length) {
                return;
            }

            $item.removeClass('is-open');
            $trigger.attr('aria-expanded', 'false');
            activate(0);
        });

        $item.on('keydown', function (event) {
            if (event.key === 'Escape') {
                $item.removeClass('is-open');
                $trigger.attr('aria-expanded', 'false').focus();
            }
        });
    });
});

$(function () {
    // Les cartes de gauche et les onglets de droite pilotent le même panneau d'année.
    $('[data-programme]').each(function () {
        var $section = $(this);

        $section.on('click', '[data-programme-target]', function () {
            var target = $(this).data('programme-target');

            $section.find('.programme__year').each(function () {
                $(this).toggleClass('is-active', $(this).data('programme-target') === target);
            });

            $section.find('.programme__tab').each(function () {
                var isActive = $(this).data('programme-target') === target;

                $(this).toggleClass('is-active', isActive).attr('aria-selected', isActive);
            });

            $section.find('[data-programme-panel]').each(function () {
                var isActive = $(this).data('programme-panel') === target;

                $(this).toggleClass('is-active', isActive).prop('hidden', !isActive);
            });
        });
    });
});

$('a').click(function(event){
   var el = $(this);

   if(el.attr('href') == "#devis"){
       event.preventDefault();
       $('.popin-contact').slideDown();
   }
});


(function () {
    var root = document.getElementById('realisation-popin');

    if (!root) {
        return;
    }

    var dialog = root.querySelector('.realisation-popin__dialog');
    var image = root.querySelector('.realisation-popin__img');
    var title = root.querySelector('.realisation-popin__title');
    var author = root.querySelector('.realisation-popin__author');
    var person = root.querySelector('.realisation-popin__person');
    var linkedin = root.querySelector('.realisation-popin__linkedin');
    var graduate = root.querySelector('.realisation-popin__graduate');
    var prevButton = root.querySelector('[data-realisation-prev]');
    var nextButton = root.querySelector('[data-realisation-next]');
    var figure = root.querySelector('.realisation-popin__figure');
    var items = [];
    var index = 0;
    var lastFocus = null;
    var closeTimer = null;
    var slideTimer = null;
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function setText(node, value) {
        node.textContent = value || '';
        node.classList.toggle('is-visible', !!value);
    }

    function showItem(item) {
        var src = item.getAttribute('data-full');

        if (!src) {
            return;
        }

        var personName = item.getAttribute('data-person') || '';
        var linkedinUrl = item.getAttribute('data-linkedin') || '';

        image.src = src;
        image.alt = item.getAttribute('data-alt') || '';
        setText(title, item.getAttribute('data-title') || '');
        setText(person, personName);
        setText(graduate, item.getAttribute('data-graduate') || '');

        if (linkedinUrl) {
            linkedin.href = linkedinUrl;
            linkedin.setAttribute('aria-label', personName ? 'Profil LinkedIn de ' + personName : 'Profil LinkedIn');
            linkedin.classList.add('is-visible');
        } else {
            linkedin.removeAttribute('href');
            linkedin.classList.remove('is-visible');
        }

        author.classList.toggle('is-visible', !!(personName || linkedinUrl));
        dialog.setAttribute('aria-label', item.getAttribute('data-title') || personName || 'Réalisation');
    }

    function updateNav() {
        var single = items.length < 2;

        if (prevButton) {
            prevButton.hidden = single;
        }

        if (nextButton) {
            nextButton.hidden = single;
        }
    }

    function step(delta) {
        if (items.length < 2) {
            return;
        }

        index = (index + delta + items.length) % items.length;

        if (reduceMotion || !figure) {
            showItem(items[index]);
            return;
        }

        if (slideTimer) {
            window.clearTimeout(slideTimer);
        }

        var outClass = delta > 0 ? 'is-out-next' : 'is-out-prev';
        var inClass = delta > 0 ? 'is-in-next' : 'is-in-prev';

        figure.classList.remove('is-out-next', 'is-out-prev', 'is-in-next', 'is-in-prev');
        figure.classList.add(outClass);

        slideTimer = window.setTimeout(function () {
            showItem(items[index]);
            figure.classList.remove(outClass);
            figure.classList.add(inClass);
            figure.getBoundingClientRect();
            window.requestAnimationFrame(function () {
                figure.classList.remove(inClass);
            });
            slideTimer = null;
        }, 180);
    }

    function openPopin(item) {
        if (closeTimer) {
            window.clearTimeout(closeTimer);
            closeTimer = null;
        }

        items = Array.prototype.slice.call(document.querySelectorAll('#realisations .realisations__item[data-full]'));
        index = Math.max(0, items.indexOf(item));
        showItem(item);
        updateNav();
        lastFocus = document.activeElement;
        root.hidden = false;
        document.body.classList.add('has-realisation-popin');
        window.requestAnimationFrame(function () {
            window.requestAnimationFrame(function () {
                root.classList.add('is-open');
            });
        });
        root.querySelector('.realisation-popin__close').focus();
    }

    function finishClose() {
        root.hidden = true;
        root.classList.remove('is-open');
        document.body.classList.remove('has-realisation-popin');
        image.removeAttribute('src');
        closeTimer = null;

        if (lastFocus && typeof lastFocus.focus === 'function') {
            lastFocus.focus();
        }
    }

    function closePopin() {
        if (root.hidden || closeTimer) {
            return;
        }

        root.classList.remove('is-open');

        if (reduceMotion) {
            finishClose();
            return;
        }

        closeTimer = window.setTimeout(finishClose, 320);
    }

    document.addEventListener('click', function (event) {
        if (event.target.closest('.realisations__linkedin')) {
            return;
        }

        var item = event.target.closest('.realisations__item[data-full]');

        if (!item || !event.target.closest('#realisations')) {
            return;
        }

        event.preventDefault();
        openPopin(item);
    });

    root.querySelectorAll('[data-realisation-close]').forEach(function (node) {
        node.addEventListener('click', closePopin);
    });

    if (prevButton) {
        prevButton.addEventListener('click', function () {
            step(-1);
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', function () {
            step(1);
        });
    }

    document.addEventListener('keydown', function (event) {
        if (root.hidden) {
            return;
        }

        if (event.key === 'Escape') {
            event.preventDefault();
            closePopin();
            return;
        }

        if (event.key === 'ArrowLeft') {
            event.preventDefault();
            step(-1);
            return;
        }

        if (event.key === 'ArrowRight') {
            event.preventDefault();
            step(1);
            return;
        }

        if (event.key !== 'Tab' || !dialog) {
            return;
        }

        var focusable = dialog.querySelectorAll('a[href], button:not([disabled])');
        var list = Array.prototype.filter.call(focusable, function (el) {
            if (el.hidden) {
                return false;
            }

            return el.classList.contains('is-visible') || el.classList.contains('realisation-popin__close') || el.classList.contains('realisation-popin__nav');
        });

        if (!list.length) {
            return;
        }

        var first = list[0];
        var last = list[list.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    });
})();

$('.beforeAfter').beforeAfter({
    movable: true,
    clickMove: true,
    position: 50,
    separatorColor: '#fafafa',
    bulletColor: '#fafafa',
    onMoveStart: function(e) {
        console.log(event.target);
    },
    onMoving: function() {
        console.log(event.target);
    },
    onMoveEnd: function() {
        console.log(event.target);
    },
});