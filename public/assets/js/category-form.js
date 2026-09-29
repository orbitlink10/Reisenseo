(function () {
    'use strict';

    var form = document.getElementById('category-form');
    if (!form) return;

    var description = document.getElementById('category-description');
    var status = document.getElementById('category-editor-status');

    function showEditorFallback() {
        description.style.display = '';
        status.textContent = 'The formatting tools could not load. You can still enter and save your description below.';
        status.hidden = false;
    }

    if (!window.tinymce) {
        showEditorFallback();
        return;
    }

    // TinyMCE's community plugins provide the menus shown in the category form reference.
    // https://www.tiny.cloud/docs/tinymce/latest/basic-setup/
    tinymce.init({
        selector: '#category-description',
        license_key: 'gpl',
        height: 400,
        min_height: 300,
        menubar: 'file edit view insert format tools table',
        plugins: 'lists link image media table code fullscreen preview searchreplace wordcount',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | outdent indent | link image media | code fullscreen',
        toolbar_mode: 'wrap',
        placeholder: 'Enter category description',
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
                editor.getContainer().setAttribute('aria-label', 'Category description editor');
            });
        }
    }).catch(showEditorFallback);

    form.addEventListener('submit', function () {
        tinymce.triggerSave();
    });
})();
