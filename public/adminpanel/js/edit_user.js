$(function() {
    var userIdx = $('input[name="userIdx"]').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.validator.addMethod("validateEmail",
        function(value, element) {
            return /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/.test(value);
        },
        "Sorry, I've enabled very strict email validation"
    );
    $("#board_form").validate({
        // define validation rules
        rules: {
            firstname: { required: true },
            lastname: { required: true },
            email: { required: true, validateEmail: true },
            jobTitle: { required: true },
            businessName2: { required: true },
            role2: { required: true },
            role: { required: true },
        },
        //display error alert on form submit  
        invalidHandler: function(event, validator) {
            var alert = $('#m_form_1_msg');
            alert.removeClass('m--hide').show();
            mUtil.scrollTop();
            setTimeout(function() {
                $('#m_form_1_msg').addClass('m--hide').hide();
            }, 5000);
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            $.ajax({
                url: WEBSITE_URL + "/admin/users/update",
                type: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },
                data: $("#board_form").serialize(),
                success: function(result) {
                    if (result == "success") {
                        window.location.href = WEBSITE_URL + "/admin/users";
                    }
                },
                error: function(msg) {
                    console.log('error', msg);
                    $(':input[type="submit"]').prop('disabled', false);
                    window.alert("Oops! An error occurred, please try again later.");
                }
            });
        }
    });

});