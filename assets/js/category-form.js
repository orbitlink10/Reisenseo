// Share the category form implementation with installations using public/index.php.
(function () {
    var script = document.createElement('script');
    script.src = new URL('../../public/assets/js/category-form.js?v=20260929', document.currentScript.src).href;
    document.head.appendChild(script);
})();
