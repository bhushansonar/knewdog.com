/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */
var bas_path = 'http://www.knewdog.com/assets';
CKEDITOR.editorConfig = function(config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    config.extraPlugins = 'youtube';
    config.filebrowserBrowseUrl = bas_path + '/browser/browse.php';
    config.filebrowserImageBrowseUrl = bas_path + '/browser/browse.php?type=Images';
    config.filebrowserUploadUrl = bas_path + '/uploader/upload.php';
    config.filebrowserImageUploadUrl = bas_path + '/uploader/upload.php?type=Images';
    config.filebrowserWindowWidth = 900;
    config.filebrowserWindowHeight = 400;
    config.filebrowserBrowseUrl = bas_path + '/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = bas_path + '/ckfinder/ckfinder.html?Type=Images';
    config.filebrowserFlashBrowseUrl = bas_path + '/ckfinder/ckfinder.html?Type=Flash';
    config.filebrowserUploadUrl = bas_path + '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = bas_path + '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = bas_path + '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
    config.allowedContent = {
        $1: {
            // Use the ability to specify elements as an object.
            elements: CKEDITOR.dtd,
            attributes: true,
            styles: true,
            classes: true
        }
    };
    config.disallowedContent = 'script; *[on*]';

};

