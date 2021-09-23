function copykey(str,elm) {		
    var el = document.createElement('textarea');
       // Set value (string to be copied)
       el.value = str;
       // Set non-editable to avoid focus and move outside of view
       el.setAttribute('readonly', '');
       el.style = {position: 'absolute', left: '-9999px'};
       document.body.appendChild(el);
       // Select text inside element
       el.select();
       // Copy text to clipboard
       document.execCommand('copy');
       // Remove temporary element
       document.body.removeChild(el);	
        /* $(elm).after( "<span id='copy' style='color:green;font-size:13px;'>  Copied to clipboard</span>"); */
        $('#copy').show();
        setTimeout(function(){ 
            $('#copy').fadeOut();
        }, 1000);

    }

    function showKey(value,title){
                $('#showkey').html(value);
                $('#title').html(title);
                $('#showKeyModal').modal('show')
    }