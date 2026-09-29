(function () {
    'use strict';
    var gallery = document.querySelector('[data-product-gallery]');
    if (gallery) {
        var mainImage = gallery.querySelector('#product-main-image');
        var zoom = gallery.querySelector('[data-gallery-zoom]');
        var dialog = gallery.querySelector('[data-gallery-dialog]');
        var thumbnails = Array.from(gallery.querySelectorAll('[data-gallery-thumbnail]'));
        thumbnails.forEach(function (thumbnail) {
            thumbnail.addEventListener('click', function (event) {
                if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
                event.preventDefault();
                mainImage.src = thumbnail.href;
                mainImage.alt = thumbnail.dataset.imageAlt;
                zoom.href = thumbnail.href;
                thumbnails.forEach(function (item) {
                    item.classList.toggle('is-active', item === thumbnail);
                    if (item === thumbnail) item.setAttribute('aria-current', 'true');
                    else item.removeAttribute('aria-current');
                });
            });
        });
        if (zoom && dialog && typeof dialog.showModal === 'function') {
            zoom.addEventListener('click', function (event) {
                if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
                event.preventDefault();
                var enlarged = dialog.querySelector('img');
                enlarged.src = mainImage.src;
                enlarged.alt = mainImage.alt;
                dialog.showModal();
            });
            dialog.querySelector('[data-gallery-close]').addEventListener('click', function () { dialog.close(); });
            dialog.addEventListener('click', function (event) { if (event.target === dialog) dialog.close(); });
        }
    }
    var details = document.querySelector('[data-product-tabs]');
    if (!details) return;
    var tabs = Array.from(details.querySelectorAll('[data-product-tab]'));
    var panels = Array.from(details.querySelectorAll('[data-product-panel]'));
    details.querySelector('nav').setAttribute('role', 'tablist');
    function activate(tab) {
        tabs.forEach(function (item) {
            var selected = item === tab;
            item.setAttribute('aria-selected', String(selected));
            item.tabIndex = selected ? 0 : -1;
        });
        panels.forEach(function (panel) { panel.hidden = '#' + panel.id !== tab.hash; });
    }
    tabs.forEach(function (tab, index) {
        tab.setAttribute('role', 'tab');
        tab.setAttribute('aria-controls', tab.hash.slice(1));
        panels[index].setAttribute('role', 'tabpanel');
        panels[index].setAttribute('aria-labelledby', tab.id);
        panels[index].tabIndex = 0;
        tab.addEventListener('click', function (event) { event.preventDefault(); activate(tab); });
        tab.addEventListener('keydown', function (event) {
            var next;
            if (event.key === 'ArrowRight') next = (index + 1) % tabs.length;
            else if (event.key === 'ArrowLeft') next = (index + tabs.length - 1) % tabs.length;
            else if (event.key === 'Home') next = 0;
            else if (event.key === 'End') next = tabs.length - 1;
            else return;
            event.preventDefault();
            activate(tabs[next]);
            tabs[next].focus();
        });
    });
    activate(tabs.find(function (tab) { return tab.hash === window.location.hash; }) || tabs[0]);
    var detailsLink = document.querySelector('.rs-product__details-link');
    if (detailsLink) detailsLink.addEventListener('click', function () { activate(tabs[0]); });
})();
