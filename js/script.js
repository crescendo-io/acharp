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
    var sections = document.querySelectorAll('[data-heritage]');

    if (!sections.length || !('IntersectionObserver' in window)) {
        return;
    }

    Array.prototype.forEach.call(sections, function (section) {
        var steps = section.querySelectorAll('[data-heritage-step]');
        var visuals = section.querySelectorAll('[data-heritage-visual]');
        var current = 0;

        if (steps.length < 2) {
            return;
        }

        function activate(index) {
            if (index === current) {
                return;
            }

            current = index;

            Array.prototype.forEach.call(steps, function (step) {
                step.classList.toggle('is-active', parseInt(step.getAttribute('data-heritage-step'), 10) === index);
            });

            Array.prototype.forEach.call(visuals, function (visual) {
                visual.classList.toggle('is-active', parseInt(visual.getAttribute('data-heritage-visual'), 10) === index);
            });
        }

        // La ligne de bascule est le centre du viewport : l'étape qui la traverse pilote le visuel.
        var observer = new IntersectionObserver(function (entries) {
            Array.prototype.forEach.call(entries, function (entry) {
                if (entry.isIntersecting) {
                    activate(parseInt(entry.target.getAttribute('data-heritage-step'), 10));
                }
            });
        }, { rootMargin: '-50% 0px -50% 0px', threshold: 0 });

        Array.prototype.forEach.call(steps, function (step) {
            observer.observe(step);
        });
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