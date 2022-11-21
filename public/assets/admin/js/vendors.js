$(document).ready(function() {
    
    $("#vendor_form").validate(
    {
        errorClass: 'alert-danger',
        errorElement: "code",
        rules: {
            name: {required : true},
            email: {
                required : true, 
                email:true, 
            },
            password: {minlength: 6},
            confirm_password: {equalTo: "#password"},
            
        },
    });
    
    $("#add_vendor_form").validate(
    {
        errorClass: 'alert-danger',
        errorElement: "code",
        rules: {
            name: {required : true},
            email: {
                required : true, 
                email:true, 
                remote: {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: base_url+"admin/vendors/check-vendor-email",
                    type: "post"
                }
            },
            password: {required : true, minlength: 6},
            confirm_password: {required : true, equalTo: "#password"},
            
        },
        messages: {
        email: {
          required: "This field is required",
          email: "Invalid Email Address",
          remote: "Email address already in use. Please use other email."
        }
  }
    });
    
    
    var css_disabled = {'background-color' : '#eee', 'color' : '#999'};
    var css_enabled = {'background-color' : $('#billing_name').css('background-color'), 'color' : $('#billing_name').css('color')};
    

    $('#same_as_billing').on("click", function()
    {
        var shipping_name = $('#billing_name').val();
        var shipping_country = $('#billing_country').val();
        var shipping_zip_code = $('#billing_zip_code').val();
        var shipping_settlement = $('#billing_settlement').val();
        var shipping_address = $('#billing_address').val();
        var shipping_number = $('#billing_number').val();
        
        if($(this).is(':checked'))
        {
            $('#shipping_name').val(shipping_name);
            $('#shipping_country').val(shipping_country);
            $('#shipping_zip_code').val(shipping_zip_code);
            $('#shipping_settlement').val(shipping_settlement);
            $('#shipping_address').val(shipping_address);
            $('#shipping_number').val(shipping_number);
        }
        else
        {
            $('#profile_form input').removeAttr('readonly').css(css_enabled);
        }
    });
});