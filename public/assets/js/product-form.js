(function () {
    'use strict';

    var form = document.getElementById('product-form');
    if (!form) return;

    var category = document.getElementById('product-category');
    var subcategory = document.getElementById('product-subcategory');
    var options = Array.from(subcategory.querySelectorAll('option[data-category]'));

    function updateSubcategories() {
        var selected = subcategory.value;
        var available = options.filter(function (option) {
            return option.dataset.category === category.value;
        });

        subcategory.replaceChildren(new Option(available.length ? 'Select Subcategory' : 'No subcategories available', ''));
        available.forEach(function (option) {
            subcategory.add(option.cloneNode(true));
        });
        subcategory.value = available.some(function (option) { return option.value === selected; }) ? selected : '';
        subcategory.disabled = available.length === 0;
    }

    category.addEventListener('change', updateSubcategories);
    updateSubcategories();

    var description = document.getElementById('product-description');
    var status = document.getElementById('product-editor-status');

    function showEditorFallback() {
        description.style.display = '';
        status.textContent = 'The formatting tools could not load. You can still enter and save your description below.';
        status.hidden = false;
    }

    if (!window.tinymce) {
        showEditorFallback();
        return;
    }

    // TinyMCE's community plugins provide the menus shown in the product form reference.
    // https://www.tiny.cloud/docs/tinymce/latest/basic-setup/
    tinymce.init({
        selector: '#product-description',
        license_key: 'gpl',
        height: 400,
        min_height: 300,
        menubar: 'file edit view insert format tools table',
        plugins: 'lists link image media table code fullscreen preview searchreplace wordcount',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | outdent indent | link image media | code fullscreen',
        toolbar_mode: 'wrap',
        placeholder: 'Write the product description here...',
        promotion: false,
        branding: false,
        resize: true,
        elementpath: false,
        browser_spellcheck: true,
        convert_urls: false,
        image_caption: true,
        image_uploadtab: false,
        automatic_uploads: false,
        paste_data_images: false,
        content_style: 'body { font-family: Arial, sans-serif; font-size: 16px; color: #172033; margin: 20px; line-height: 1.65; } img, video, iframe { max-width: 100%; } table { border-collapse: collapse; max-width: 100%; } td, th { padding: 8px; }',
        setup: function (editor) {
            editor.on('change input undo redo', function () { editor.save(); });
            editor.on('init', function () {
                editor.getContainer().setAttribute('aria-label', 'Product description editor');
            });
        }
    }).catch(showEditorFallback);

    form.addEventListener('submit', function () {
        tinymce.triggerSave();
    });
})();
