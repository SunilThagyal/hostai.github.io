jQuery(window).on("load", function () {
    jQuery(".loader").fadeOut("slow");
});

// Jquery custom validations
jQuery.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0}');

jQuery.validator.addMethod('doclength', function (value, element, param) {
    return this.optional(value) || (value.size <= 30)
}, 'Document name can be max 30 characters');


jQuery.validator.addMethod("regex", function (value, element, regexp) {
    if (regexp.constructor != RegExp) {
        regexp = new RegExp(regexp);
    } else if (regexp.global) {
        regexp.lastIndex = 0;
    }

    return this.optional(element) || regexp.test(value);
}, "Enter a valid value");

jQuery.validator.addMethod("docRequired", jQuery.validator.methods.required, "Please enter the document name");
jQuery.validator.addMethod("maxLength", jQuery.validator.methods.doclength, 'Document name can be max 30 characters');
jQuery.validator.addMethod("certificateRequired", jQuery.validator.methods.required, "Please upload the certificate");
jQuery.validator.addMethod("certificateSize", jQuery.validator.methods.filesize, "File should be less than 2 MB ");
jQuery.validator.addMethod("certificateExtension", jQuery.validator.methods.extension, "Invalid file type");
jQuery.validator.addMethod("documentRequired", jQuery.validator.methods.required, "Please upload the document");
jQuery.validator.addMethod("documentSize", jQuery.validator.methods.filesize, "File should  be less than 2MB");
jQuery.validator.addMethod("documentExtension", jQuery.validator.methods.extension, "Invalid file type");

jQuery.validator.addClassRules("document-name", {
    docRequired: true,
    maxlength: 30,
});

jQuery.validator.addClassRules("admin-document-name", {
    docRequired: true,
    maxlength: 30,
});

jQuery.validator.addClassRules("worker-certificate", {
    certificateRequired: true,
    certificateSize: certificateSize,
    certificateExtension: certificateMimes,
});

jQuery.validator.addClassRules("admin-worker-certificate", {
    certificateRequired: true,
    certificateSize: certificateSize,
    certificateExtension: certificateMimes,
});

jQuery.validator.addClassRules("reupload-certificate", {
    certificateRequired: false,
    certificateSize: certificateSize,
    certificateExtension: certificateMimes,
});

jQuery.validator.addClassRules("contractor-documents", {
    documentRequired: true,
    documentSize: certificateSize,
    documentExtension: certificateMimes,
});

function handleValidation(form, rules, messages = {}) {
    console.log( form );
    if( typeof form == "string" )
        form = jQuery('form#' + form);
    console.log( form );
    form.validate({
        errorClass: "invalid-feedback",
        errorElement: 'span',
        ignore: [],
        rules: rules,
        messages: messages,
        highlight: function (element) {
            jQuery(element).siblings("span.invalid-feedback").remove();
            if (jQuery(element).hasClass('selectric')) {
                jQuery(element).parents('.selectric-wrapper').addClass("selectric-is-invalid");
            } else {
                jQuery(element).parent().addClass("is-invalid");
            }
            jQuery(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            if (jQuery(element).hasClass('selectric')) {
                jQuery(element).parents('.selectric-wrapper').removeClass("selectric-is-invalid");
            } else {
                jQuery(element).parent().removeClass("is-invalid");
            }
            jQuery(element).removeClass("is-invalid");
        },
        errorPlacement: function (label, element) {
            if (jQuery(element).hasClass('selectric')) {
                label.removeClass('invalid-feedback').addClass('cstm-selectric-invalid').insertAfter(jQuery(element).parent().siblings('.selectric'))
            } else {
                label.insertAfter(element)
            }
        }
    });
}

jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content'),
    }
});

function ajaxCall(url, method, params, loader = true) {
    if (loader) {
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                url: url,
                method: method,
                data: params,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    jQuery(".loader").fadeIn("slow");
                    // jQuery("body").addClass("loading");
                    // jQuery(".loader").addClass("loading");
                },
                complete: function (resp, status) {
                    // jQuery("body").removeClass("loading");
                    jQuery(".loader").fadeOut("slow");
                },
                success: function (response) {
                    resolve(response)
                },
                error: function (error) {
                    reject(error)
                }
            })
        });
    } else {
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                url: url,
                method: method,
                data: params,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    resolve(response)
                },
                error: function (error) {
                    reject(error)
                }
            })
        });
    }
}

function toggleStatus(element, model, slug) {
    jQuery(element).attr('disabled', true)
    let params = { 'slug': slug, 'model': model };
    let url = APP_URL + "/status";
    let response = ajaxCall(url, 'get', params);
    response.then(function (result) {
        toastr.options.closeButton = true;
        toastr.options.closeMethod = 'fadeOut';
        toastr.options.closeDuration = 10;
        jQuery(element).attr('disabled', false)

        if (result.status == 'success') {
            return toastr.success(result.message);
        }
        else {
            return toastr.error(result.message);
        }
    }).catch(function (error) {
        jQuery(element).attr('disabled', false)

        return toastr.error(error.responseJSON.message);
    })
}


/* Show sites according to contractor */
$(".change-subscontractor").on("change",function(){
    var siteField = $(this).closest("form").find(".subscontractor-sites"),
    showSites = $(this).find(':selected').data("assigned-sites") || [];
    if( siteField.length ){
        siteField.val("");
        siteField.find("option:not([value=''])").hide();
        showSites.forEach(function(value){
            if( siteField.data("preselected") == value )
                siteField.val(siteField.data("preselected"))
            siteField.find(`option[value=${value}]`).show();
        });
    }
}).trigger("change");