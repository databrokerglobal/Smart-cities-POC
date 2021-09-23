/**
 * 
 * Function to validate images
 * @param {fileFieldID} string 
 * @param {file} file 
 * @param {allowedFileSize} int() in Megabyte
 * @param {minwidth} int() 
 * @param {minheight} int() 
 */
function ValidateImage(fileFieldID, file, allowedFileSize, minheight, minwidth) {
    var allowedFileSize = allowedFileSize || 5;
    var minheight = minheight || 500;
    var minwidth = minwidth || 500;
    var FileSize = file.files[0].size / 1024 / 1024; // in MB
    if (FileSize > allowedFileSize) {
        alert('File size exceeds ' + allowedFileSize + ' MB ');
        $('#' + fileFieldID).val('');
    }

    var _URL = window.URL || window.webkitURL;
    var upfile = file.files[0];

    img = new Image();
    var imgwidth = 0;
    var imgheight = 0;

    img.src = _URL.createObjectURL(upfile);
    img.onload = function() {
        imgwidth = this.width;
        imgheight = this.height;

        if (imgwidth <= minwidth && imgheight <= minheight) {
            alert('Image resolution should be greater than ' + minwidth + 'px * ' + minheight + 'px')
            $('#' + fileFieldID).val('');
        }
    }
}

/**
 * 
 * Function to validate Fixed size images
 * @param {fileFieldID} string 
 * @param {file} file 
 * @param {allowedFileSize} int() in Megabyte
 * @param {minwidth} int() 
 * @param {minheight} int() 
 */
function ValidateImageWithFixedSize(fileFieldID, file, allowedFileSize, minheight, minwidth) {
    var allowedFileSize = allowedFileSize || 5;
    var minheight = minheight || 500;
    var minwidth = minwidth || 500;
    var FileSize = file.files[0].size / 1024 / 1024; // in MB
    if (FileSize > allowedFileSize) {
        alert('File size exceeds ' + allowedFileSize + ' MB ');
        $('#' + fileFieldID).val('');
    }

    var _URL = window.URL || window.webkitURL;
    var upfile = file.files[0];

    img = new Image();
    var imgwidth = 0;
    var imgheight = 0;

    img.src = _URL.createObjectURL(upfile);
    img.onload = function() {
        imgwidth = this.width;
        imgheight = this.height;

        if (imgwidth != minwidth && imgheight <= minheight) {
            alert('Image width should be  ' + minwidth + 'px and height should be greater than ' + minheight + 'px')
            $('#' + fileFieldID).val('');
        }
    }
}
/**
 * display character count
 */
$(".character-count").keyup(function() {
    var text = $(this).val();

    $(this).parent().find('.char-counter span').eq(0).text(text.length);
    var text_length = $(this).attr('maxlength');
    $(this).parent().find('.char-counter span').eq(1).text(parseInt(text_length) - text.length);
});

// Auto Hide Success and Error custom messages
$(".jq-auto-hide").fadeTo(5000, 500).slideUp(500, function() {
    $(".jq-auto-hide").slideUp(5000);
});


// function to remove special character from string
function convertString(fieldID, newFiledID) {
    var inputString = document.getElementById(fieldID).value;
    // var newstring = inputString.replace(/[^a-zA-Z ]/g, "-");
    var outputString = inputString.replace(/([~!@#$%^&*()_+"=`{}\[\]\|\\:;'<>,.\/? ])+/g, '-').replace(/^(-)+|(-)+$/g, '');
    outputString = outputString.toLowerCase();
    document.getElementById(newFiledID).value = outputString;
}

function blockSpecialChar(e) {
    var k = e.keyCode;
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || (k >= 48 && k <= 57));
}


$(function() {
    $(".character-count").each(function(i) {
        var text = $(this).val();
        $(this).parent().find('.char-counter span').eq(0).text(text.length);
        var text_length = $(this).attr('maxlength');
        $(this).parent().find('.char-counter span').eq(1).text(parseInt(text_length) - text.length);
    });

    /**
     * Override required medthod of validator
     */
    $.validator.addMethod("required", function(value, element, param) {
        // Check if dependency is met
        if (!this.depend(param, element)) {
            return "dependency-mismatch";
        }
        if (element.nodeName.toLowerCase() === "select") {

            // Could be an array for select-multiple or a string, both are fine this way
            var val = $(element).val();
            return val && val.length > 0;
        }
        if (this.checkable(element)) {
            return this.getLength(value, element) > 0;
        }
        //Check for ckeditor textarea
        if (element.nodeName.toLowerCase() === "textarea" && element.id.toLowerCase() === "editor") {
            return value !== undefined && value !== null && value.replace(/(<([^>]+)>)/ig, "").trim().length > 0;
        }
        return value !== undefined && value !== null && value.trim().length > 0;
    }, "This field is required.");

    /**
     * Override minlength medthod of validator
     */
    $.validator.addMethod("minlength", function(value, element, param) {
        var length = Array.isArray(value) ? value.length : this.getLength(value, element);
        //Check for ckeditor textarea
        if (element.nodeName.toLowerCase() === "textarea" && element.id.toLowerCase() === "editor") {
            var length = Array.isArray(value) ? value.replace(/(<([^>]+)>)/ig, "").length : this.getLength(value.replace(/(<([^>]+)>)/ig, ""), element);
        }
        return this.optional(element) || length >= param;
    });
});