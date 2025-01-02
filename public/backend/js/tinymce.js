$(function() {
  'use strict';

  // Tinymce editor
  if ($("#tinymceExample").length) {
    tinymce.init({
      selector: 'textarea',
      language: typeof tinymceLanguage !== 'undefined' ? tinymceLanguage : 'en', // Default to 'en' if no language set
      min_height: 350,
      default_text_color: 'red',
      plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor image",
      ],
      toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      templates: [
        {
          title: 'Test template 1',
          content: 'Test 1'
        },
        {
          title: 'Test template 2',
          content: 'Test 2'
        }
      ],
      content_css: [],

      // Enable image title and upload functionality
      image_title: true,
      automatic_uploads: true,
      file_picker_types: 'image',
      file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.onchange = function() {
          var file = this.files[0];
          var reader = new FileReader();
          reader.onload = function() {
            var id = 'blobid' + (new Date()).getTime();
            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
            var base64 = reader.result.split(',')[1];
            var blobInfo = blobCache.create(id, file, base64);
            blobCache.add(blobInfo);

            // Call the callback and populate the Title field with the file name
            cb(blobInfo.blobUri(), { title: file.name });
          };
          reader.readAsDataURL(file);
        };

        input.click();
      },

      // Add alignment options for images in the toolbar
      image_advtab: true,
      // toolbar2: 'alignleft aligncenter alignright | imageoptions',

      // Add alignment to the context menu
      contextmenu: 'image align | link',

      // Custom content style for image alignment
      content_style: `
        body { font-family:Helvetica,Arial,sans-serif; font-size:14px }
        img { display: block; margin-left: auto; margin-right: auto; }
      `,

      // Customize the image dialog to include alignment
      setup: function(editor) {
        editor.ui.registry.addContextToolbar('imagealign', {
          predicate: function(node) {
            return node.nodeName.toLowerCase() === 'img';
          },
          items: 'alignleft aligncenter alignright',
          position: 'node',
          scope: 'node'
        });
      }
    });
  }
});
