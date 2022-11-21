$(document).ready(function(){

    //Enable tooltips everywhere
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    $(document.body).on("click","#accept", function(e){
        e.preventDefault();
        setCookie('policy_cookie','accepted',365)
        $("#cookiePol").slideToggle();
    });

    $('#gotoTop').hide();
    $(window).scroll(function()
    {
        if ($(this).scrollTop()>200)
            $('#gotoTop').slideDown();
        else
            $('#gotoTop').slideUp();
    });

    $('#gotoTop').click(function (e)
    {
        e.preventDefault();
        $('body,html').animate({scrollTop: 0}, 500);
    });

    // AJAX search.
    $("input#search-input").on('input',function(){
        if($(this).val().length > 2)
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url + current_locale + '/ajax-search',
                dataType: 'html',
                method: 'GET',
                data: {'term':$(this).val()},
            }).done(function( msg ) {
                if(msg != 'false'){
                    $("#search-result").html(msg);
                    $("#search-result ul").show();
                }
            });
        }
        else
        {
            $("#search-result").html('');
            $("#search-result ul").hide();
        }
    });

    //Menu (mobile)
    $('.catalog_btn').on('click', function () {
        if ($('#category_menu').hasClass('catalog_show')) {
            $('#category_menu').removeClass('catalog_show');
        } else {
            $('#category_menu').addClass('catalog_show');
        }
        return false;
    });

    $('#category_menu .bi, #pages_menu .bi').on('click', function () {
        if ($(this).next('ul').hasClass('opened')) {
            $(this).next('ul').removeClass('opened');
            $(this).removeClass('bi-chevron-up').addClass('bi-chevron-down');
            $(this).next('ul').slideToggle('slow');
        } else {
            $(this).removeClass('bi-chevron-down').addClass('bi-chevron-up');
            $(this).next('ul').addClass('opened');
            $(this).next('ul').slideDown('slow');
        }
        return false;
    });

    $('.pages_btn').on('click', function () {
        if ($('#pages_menu').hasClass('pages_show')) {
            $('#pages_menu').removeClass('pages_show');
        } else {
            $('#pages_menu').addClass('pages_show');
        }
        return false;
    });

    //sidebar menu
    $('#sidebar_menu .bi').on('click', function () 
    {
        if ($(this).hasClass('bi-dash-square')){
            $(this).next('ul').slideUp('slow');
            $(this).next('ul').removeClass('opened');
            $(this).removeClass('bi-dash-square').addClass('bi-plus-square');
            
        } else {
            $(this).next('ul').slideDown('slow');
            //$(this).next('ul').addClass('opened');
            $(this).removeClass('bi-plus-square').addClass('bi-dash-square');
        }
        return false;
    });

    $('.sidebar_menu ul').each(function()
    {
        var segments = location.pathname.split('/');
        var url_segment = segments[segments.length - 1];
        if($.isNumeric(url_segment))
            var url_segment = segments[segments.length - 2];
        $(this).find("a[data-url='" + url_segment + "']").parent('li').addClass('active').end();
        $(this).find("a[data-url='" + url_segment + "']").addClass('active').end();
        $(this).find("li.active").parents('ul').removeClass('closed').addClass('opened').end();
        //$(this).find("li.active").removeClass('closed').addClass('opened').end();
        $(this).find("li.active").parents('li').addClass('active').end();
        $(this).find("li.active > i").removeClass('bi-plus-square').addClass('bi-dash-square');
    });

    $("#cart").on("click", function(e) {
        e.preventDefault();
        $(".shopping-cart").slideToggle();
    });

    $(document).on('change','.shopping_method',function () {
        var shipping_cost = $(this).val();
        var shipping_id = $(this).attr('data-id');
        var shipping_name = $(this).attr('data-name');

        $('input[name="payment_value"]').prop('checked', false);
        $('.payment_methods').addClass('loading');
        $('.order_summary').addClass('loading');
        $('.payments_loading').show();
        $('.summary_loading').show();
        var possible_payments = $(this).attr('data-possible_payments').split('|');

        $('.payment_method input').prop('checked', false);

        setTimeout(function ()
        {
            $('.payment_method').hide();
            $('#order_summary_table').html('');
            if(possible_payments.length == 1)
            {
                $('.payment_methods #payment_'+possible_payments[0]).show();
            }
            else
            {
                $.each( possible_payments, function( index, value ) {
                    $('.payment_methods #payment_'+value).show();
                });
            }
            /*$.ajax({
                url: base_url + 'cart/update_shipping/'+shipping_cost+'/'+shipping_id,
                success: function(data) {
                    if(data != "false")
                    {
                        $('#order_summary_table').html(data);
                        $('#shipping_cost_row .transp_type').html('('+shipping_name+')');
                        $('#shipping_cost_val span').html(shipping_cost);
                        location.reload(true);
                    }
                    else
                    {
                        alert('Nincs változás');
                        //location.reload(true);
                    }
                }
            });*/

            $('.payment_methods').removeClass('loading');
            $('.order_summary').removeClass('loading');
            $('.payments_loading').hide();
            $('.summary_loading').hide();
            //location.reload(true);
            //window.location.replace(base_url+"cart?v="+Date.now());
        }, 500);

    });

    /*$(document).on('change','.payment_method',function () {
        var payment_id = $(this).attr('data-payment_id');
        $('.order_summary').addClass('loading');
        $('.summary_loading').show();
        setTimeout(function ()
        {
            $.ajax({
                url: base_url + 'cart/update_payment/'+payment_id,
                success: function(data) {
                    if(data != "")
                    {

                    }
                    else
                        alert('Nincs változás');
                }
            });
            $('.order_summary').removeClass('loading');
            $('.summary_loading').hide();
        }, 500);
    });*/

    $(document).on('click','#coupon_btn',function () {
        var coupon_code = $("#coupon_code").val();
        $('.order_summary').addClass('loading');
        $('.summary_loading').show();
        setTimeout(function ()
        {
            $.ajax({
                url: base_url + 'cart/add_coupon/'+coupon_code,
                dataType: 'json',
                html: 'html',
                success: function(data) {
                    if(data.error != "")
                    {
                        $('.coupon_error').html(data.error);
                        $('.coupon_error').show();
                    }
                    else
                    {
                        $('#order_summary_table').html('');
                        $('#order_summary_table').html(data.result);
                        $('.coupon_valid').html(data.msg);
                        $('.coupon_valid').show();
                        $('.coupon_form').addClass('hidden');
                    }
                }
            });
            $('.order_summary').removeClass('loading');
            $('.summary_loading').hide();
        }, 500);
    });

    if($().select2)
    {
        $(".select2").select2({
            theme: 'bootstrap4'
        });
    }
    if($().selectpicker)
    {
        $(function () {
            $('.selectpicker').selectpicker();
        });
    }

    $('#country-dd').on('change', function () {
        var idCountry = this.value;
        $("#state-dd").html('');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: base_url+current_locale+'/fetch-states',
            type: "POST",
            data: {country: idCountry},
            dataType: 'json',
            success: function (result) {
                $.each(result.states, function (key, value) {
                    $("#state-dd").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });
    
    $('#state-dd').on('change', function () {
        var idState = this.value;
        $("#city-dd").html('');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: base_url+current_locale+'/fetch-cities',
            type: "POST",
            data: {state: idState},
            dataType: 'json',
            success: function (res) {
                $.each(res.cities, function (key, value) {
                    $("#city-dd").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });

    $("#same-address").click(function(){
		if ($(this).is(':checked'))
        {
            $(".same_as_billing input").val('');
			$(".same_as_billing input").removeAttr('required');
        }
		else
			$(".same_as_billing input").attr('required',true);

		$(".same_as_billing").slideToggle("slow");
	});

    if($().inputmask)
    {
        $("#phone").inputmask();
    }
});

if(typeof lightGallery !== 'undefined')
{
    lightGallery(document.getElementById('lightgallery'),{
        selector: 'a',
        plugins: [lgZoom, lgThumbnail,lgFullscreen],
        licenseKey: 'your_license_key',
        speed: 500,
    });
}


function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
