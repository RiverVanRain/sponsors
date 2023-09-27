humhub.module('sponsors', function (module, require, $) {
    var client = require('client');
    var modal = require('ui.modal');
    var additions = require('ui.additions');

   var deletePageLogo = function (evt) {
        evt.finish();

        var options = {
            'header': module.text('confirm.deleteLogo.header'),
            'body': module.text('confirm.deleteLogo.body'),
            'confirmText': module.text('confirm.deleteLogo.confirm')
        };

        modal.confirm(options).then(function ($confirmed) {
            if ($confirmed) {
                _confirmDeletePageLogo(evt);
            }
        });
    };

    var _confirmDeletePageLogo = function (evt) {
        client.post(evt).then(function () {
            $('#deleteLogoImage').fadeOut();
            $('#logo-image').attr('src', '').hide();
            additions.switchButtons($('#img-logo'), $('#text-logo'));
        });
    };

    var changeLogo = function (evt) {
        var input = evt.$trigger[0];
        if (input.files && input.files.length) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#logo-image').attr('src', e.target.result).show();
            };

            reader.readAsDataURL(input.files[0]);
        }
    };


    var init = function () {
        if ($('#logo-file-upload').length) {
            // Forward file to chooser.
            $('#logo-upload-button').on('click', function (evt) {
                evt.preventDefault();
                $('#logo-file-upload').trigger('click');
            });
        }
    };

    module.export({
        init: init,
        initOnPjaxLoad: true,
        deletePageLogo: deletePageLogo,
        changeLogo: changeLogo,
    });
});
