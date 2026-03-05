
    function updatefinaltotal(){
        var old = $('#totalamount').val();
        var x = 0;
        if (!isNaN(parseFloat($('#credit_cod').val()))) {
            x = $('#credit_cod').val();
        }
        $('#total_cod').text(numberWithCommas(parseFloat(x) + parseFloat(old.replaceAll(',',''))));
        $('#total_cod2').val(parseFloat(x) + parseFloat(old.replaceAll(',','')));
    }
$(document).ready(function () {

    localStorage.removeItem('data');

    var dd = [];
    check_product = JSON.parse(localStorage.getItem('data'));
    if (check_product !== null) {
        $.ajax({
            url: localStoregProduct,
            method: "GET",
            contenttype: "application/json",
            success: function (data) {
                $.each(data, function (a, b) {
                    dd.push(b);
                });
                var check = JSON.stringify(dd);
                localStorage.setItem('data', check);

                $.ajax({
                    url: localStoregProductChange,
                    method: "GET",
                    contenttype: "application/json",
                    success: function (data) {

                    }
                });

            },
            error: function (xhr) {
                console.log(xhr);
            }
        });

    }

    $('input[name=barcode]').on('change', function () {
        var bar = $('input[name=barcode]');
        var id = bar.val();
        var div = $(this);
        var table = $('.tablexx tbody');
        $('#table_xx').DataTable().clear().destroy();
        var select = "";


        $.ajax({
            url: choseProduct + id,
            method: "GET",
            contenttype: "application/json",
            success: function (data) {

                $.each(data, function (a, b) {

                    select += `<tr>
                        <td>
                            <div class="table-data-feature" style="margin-left: 6px;">

                                <a href="http://katgates.com/kat3/product/${b.id}" style="margin-top: 5%;margin-bottom: 25%;">
                                    <button class="item" data-toggle="tooltip" style="background-color: #6fe0d1;height: 48px;width: 43px;" data-placement="top"
                                        title="More">
                                        <i class="zmdi zmdi-more" style="font-size: 32px;color:#ffffff"></i>
                                    </button>
                                </a>
                                <input type="checkbox" value="${b.id}" data-supplier="${ b.supplire_id}"  data-product=" ${b.id}" class="option-input checkbox inline " style="margin-left: 5%;" />
                            </div>
                        </td>


                        <td class="text-center title" data-title=" ${ b.Parcode}">${ b.Parcode} </td>

                        <td><div class="zoom" style="background-image: url(http://katgates.com/kat3/img/${b.image});"></div></td>`;
                    select += `<td class="text-center desc" data-title="${ b.description}">${ b.description} </td>
                                <td class="text-center bulk sale" data-title="${ (b.bulk * syr).toFixed(4) }">${ (b.bulk * syr).toFixed(4)}</td>
                                <td class="text-center hbulk sale" data-title="${ (b.hbulk * syr).toFixed(4) }">${ (b.hbulk * syr).toFixed(4)}</td>
                                <td class="text-center retail sale" data-title="${ (b.retail * syr).toFixed(4) }">${ (b.retail * syr).toFixed(4)}</td>
                                <td class="text-center new" >${ (b.sale * syr).toFixed(4)}</td>
                                <td class="text-center new " data-title="${ (b.cost * syr).toFixed(4) }">${ (b.cost * syr).toFixed(4) }</td>
                                <td class="text-center cost sale " data-title="${ (b.cost * syr).toFixed(4)}">${(b.cost * syr).toFixed(4)}</td>
                                <td class="text-center cost new " data-title="${ b.name_company}">${ b.name_company} </td>`;
                    select += ` </tr>
                    <hr>`;
                });


                $("#waite").css("display", "inline-block");
                table.append(select);
                $("#waite").css("display", "none");
                var t = $('#table_xx').DataTable({
                    "pageLength": 10
                });
                div.css({
                    "background": "#40e0d0"
                });
            }
        });

    });

    $('.Kat').on('click', function () {
        var x = $(this).data('category');
        $("#waite").css("display", "inline-block");
        // $('#table_xx').DataTable().clear().destroy();

        $.ajax({
            url: category_Product + x,
            method: "GET",
            xhrFields: {
                withCredentials: true
            },
            success: function (data) {
                var ss;
                $.each(data, function (a, c) {
                    // console.log(c.product__c_a_t_e_g_o_r_y.name);
                    $('.table').css('display', 'block');
                    table.append(`<tr>
                              <td>
                                  <div class="table-data-feature" style="margin-left: 6px;">

                                      <a href="http://katgates.com/kat3/product/${c.id}" style="margin-top: 5%;">
                                          <button class="item" data-toggle="tooltip" style="background-color: #6fe0d1;height: 48px;width: 43px;" data-placement="top"
                                              title="More">
                                              <i class="zmdi zmdi-more" style="font-size: 32px;color:#ffffff"></i>
                                          </button>
                                      </a>
                                      <input type="checkbox" value="${c.id}" class="option-input checkbox inline" style="margin-left: 5%;" />

                                  </div>
                              </td>
                              <td class="text-center title" data-title=" ${ c.name}">${ c.name} </td>
                              <td class="text-center title" >${ c.BulkPrice}</td>
                              <td class="text-center title" >${ c.Cost}</td>
                              <td class="text-center title" >${ c.HBulk}</td>
                              <td class="text-center title" >${ c.Retail}</td>
                              <td class="text-center">${ c.name_en} </td>
                          </tr>`);
                });

                // table.append(ss);
                $("#waite").css("display", "none");
                // $('#table_xx').DataTable({
                //     "pageLength": 10
                // });
            }
        });
        //    $('form').submit();

    });

});
//data table

function numberWithCommas(number) {
    var parts = number.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}


function ChangeAny(element) {
    // console.log(element);
    if (element.prop('id') != "product_type" && element.prop('id') != "pack" ) {
        if (element.val() != '') {
            element.val(numberWithCommas( parseFloat(element.val().replaceAll(',',''))));
        }else{
            element.val(0);
        }
    }
    var price = parseFloat(element.parent().parent().find('.price').val().replaceAll(',',''));
    var cost = element.parent().parent().find('.price').data('cost_rate');
    var rrate = $('#currency_sales').find(":selected").data('rate');
    if(rrate == undefined){
        rrate = $('#currancy').find(":selected").data('rate');
    }
    cost = cost * rrate;
    // if (cost > price ) {
    //     element.parent().parent().find('.price').css('background-color',rgb(248, 215, 218));
    // }
    if (price == '')price=0;
    var pack = element.parent().parent().find('#pack').find(":selected").attr('data-count');
    var quentity = element.parent().parent().find('.quentity').val() != '' ? parseFloat(element.parent().parent().find('.quentity').val().replaceAll(',','')) : 0;
    // if (quentity == '')quentity=0;
    var decimal = $('#currancy').find(":selected").data('decimal');
    var quantity_sample = 0;
    if (element.parent().parent().find('.quentity_sample').val() != null) {
        quantity_sample = element.parent().parent().find('.quentity_sample').val();
    } else {
        quantity_sample = 0;
    }
    var total = parseFloat(price) * parseFloat(pack) * (parseFloat(quentity) + parseFloat(quantity_sample)) ;
    var sample = element.parent().parent().find('#product_type').val();
    if (sample == 'sample') {
        total = 0;
    }
    element.parent().parent().find('.total_Price_txt').text(numberWithCommas((total).toFixed(decimal)));
    element.parent().parent().find('.total_Price').val(parseFloat(total).toFixed(decimal));
    var total1 = 0;
    $('.total_Price').each(function(index,element1){
        console.log($(this).val());
        total1 += parseFloat($(this).val());
    });
    element.parent().parent().parent().parent().find('#totalamount').val(total1.toFixed(decimal));
    element.parent().parent().parent().parent().find('#totalamount_txt').text(numberWithCommas(total1.toFixed(decimal)));


    var total_percent = 0;
    var total_amount = 0;
    var total_befor_discount = parseFloat($('#totalamount').val());
    $.each($("input[name='discount_value[]']"), function (key, value) {
        if ($(this).val().includes('%')) {
            total_percent += (parseFloat($(this).val()) / 100) * parseFloat(total_befor_discount);
            $(this).parent().find('#discount_change_total').val((parseFloat($(this).val()) /100) * parseFloat(total_befor_discount));
        } else {
            total_amount += parseFloat($(this).val());
            $(this).parent().find('#discount_change_total').val(parseFloat($(this).val()));
        }
    });
    total_befor_discount -= total_amount;
    total_befor_discount -= total_percent;

        var total_after_discount = parseFloat(total_befor_discount).toFixed(decimal);


    $('#sum_total_after_discount').text(numberWithCommas(total_after_discount));
    $('#sum_total_after_discount_input').val(total_after_discount);
    if($('#sum_total_after_discount_input').val() != null){
        var total_befor_tax = parseFloat($('#sum_total_after_discount_input').val().replaceAll(',',
        ''));
        total_percent = 0;
        total_amount = 0;
        $.each($("input[name='tax_value[]']"), function (key, value) {
            if ($(this).val().includes('%')) {
                total_percent += (parseFloat($(this).val()) / 100) * parseFloat(total_befor_tax);
                $(this).parent().find('#tax_change_total').val((parseFloat($(this).val()) / 100) *
                    parseFloat(total_befor_tax));
            } else {
                total_amount += parseFloat($(this).val());
                $(this).parent().find('#tax_change_total').val(parseFloat($(this).val()));
            }
        });
        total_befor_tax += total_amount;
        total_befor_tax += total_percent;
        var total_after_tax = parseFloat(total_befor_tax).toFixed(decimal);

        $('#sum_total_after_tax').text(numberWithCommas(total_after_tax));
        $('#sum_total_after_tax_input').val(total_after_tax);
    }
}

function ChangeAll() {
    var element = 0;
    var decimal1 = 0;
    $('.price').each(function(index,element1){
        element = $(element1);
    var price = $(element1).parent().parent().find('.price').val() != '' ? parseFloat($(element1).parent().parent().find('.price').val().replaceAll(',','')) : 0;
    if (price == '')price=0;
    var pack = $(element1).parent().parent().find('#pack').find(":selected").attr('data-count');
    var quentity = $(element1).parent().parent().find('.quentity').val() != '' ? parseFloat($(element1).parent().parent().find('.quentity').val().replaceAll(',','')) : 0;
    if (quentity == '')quentity=0;
    decimal1 = $('#currancy').find(":selected").data('decimal');
    var quantity_sample = 0;
    if ($(element1).parent().parent().find('.quentity_sample').val() != null) {
        quantity_sample = $(element1).parent().parent().find('.quentity_sample').val();
    } else {
        quantity_sample = 0;
    }
    var total = parseFloat(price) * parseFloat(pack) * (parseFloat(quentity) + parseFloat(quantity_sample)) ;
    var sample = $(element1).parent().parent().find('#product_type').val();
    if (sample == 'sample') {
        total = 0;
    }
    $(element1).parent().parent().find('.total_Price_txt').text(numberWithCommas((total).toFixed(decimal1)));
    $(element1).parent().parent().find('.total_Price').val((total).toFixed(decimal1));
    });
    var total1 = 0;
    $('.total_Price').each(function(index,element1){
        total1 += parseFloat($(this).val());
    });
    element.parent().parent().parent().parent().find('#totalamount').val(total1.toFixed(decimal1));
    element.parent().parent().parent().parent().find('#totalamount_txt').text(numberWithCommas(total1.toFixed(decimal1)));

    var total_percent = 0;
    var total_amount = 0;
    var total_befor_discount = parseFloat($('#totalamount').val());
    $.each($("input[name='discount_value[]']"), function (key, value) {
        if ($(this).val().includes('%')) {
            total_percent += (parseFloat($(this).val()) / 100) * parseFloat(total_befor_discount);
            $(this).parent().find('#discount_change_total').val((parseFloat($(this).val()) /100) * parseFloat(total_befor_discount));
        } else {
            total_amount += parseFloat($(this).val());
            $(this).parent().find('#discount_change_total').val(parseFloat($(this).val()));
        }
    });
    total_befor_discount -= total_amount;
    total_befor_discount -= total_percent;

    var total_after_discount = parseFloat(total_befor_discount).toFixed(decimal1);

    $('#sum_total_after_discount').text(numberWithCommas(total_after_discount));
    $('#sum_total_after_discount_input').val(total_after_discount);
    if($('#sum_total_after_discount_input').val() != null){
        var total_befor_tax = parseFloat($('#sum_total_after_discount_input').val().replaceAll(',',
        ''));
        total_percent = 0;
        total_amount = 0;
        $.each($("input[name='tax_value[]']"), function (key, value) {
            if ($(this).val().includes('%')) {
                total_percent += (parseFloat($(this).val()) / 100) * parseFloat(total_befor_tax);
                $(this).parent().find('#tax_change_total').val((parseFloat($(this).val()) / 100) *
                    parseFloat(total_befor_tax));
            } else {
                total_amount += parseFloat($(this).val());
                $(this).parent().find('#tax_change_total').val(parseFloat($(this).val()));
            }
        });
        total_befor_tax += total_amount;
        total_befor_tax += total_percent;
            var total_after_tax = parseFloat(total_befor_tax).toFixed(decimal);

        $('#sum_total_after_tax').text(numberWithCommas(total_after_tax));
        $('#sum_total_after_tax_input').val(total_after_tax);
    }
}


$(document).on('change', 'select[id=TPrice]', function () {
    var type = $(this).val();
    $(this).parent().parent().find('.price').val((type));
    ChangeAny($(this));
});

$(document).on('change', '#product_type', function () {
    ChangeAny($(this));
});



$(document).on('change', 'select[name=TypePrice]', function () {
    var type = $(this).val();
    var con = [];
    var quantities = [];
    var price = [];
    var total = [];
    var total_txt = [];

    var bar = [];
    $.each($(this).parent().parent().parent().find(".price_type"), function (key, val) {
        $.each($(this).find("option"),function(){
            if($(this).data("type_price") == type){
              bar.push($(this).val().replace(',', ''));
            }
        })
    });
    $.each($(this).parent().parent().parent().find('.priceing'), function (key, val) {
        $(this).val(numberWithCommas(bar[key]));
        $(this).data('pricepice', bar[key]);
    });
    $.each($(this).parent().parent().parent().find('.total_Price'), function (key, val) {
        total.push($(this));
    });
    $.each($(this).parent().parent().parent().find('.total_Price_txt'), function (key, val) {
        total_txt.push($(this));
    });
    $.each($(this).parent().parent().parent().find('.pack').find(":selected"), function (key, val) {
        con.push($(this).data('count'));
    });
    $.each($(this).parent().parent().parent().find('.quentities'), function (key, val) {
        quantities.push($(this).val());
    });
    $.each($(this).parent().parent().parent().find('.priceing'), function (key, val) {
        price.push($(this).val().replace(',', ''));
    });

    for (i = 0; i < con.length; i++) {
        // if($('#currancy').val() == "8"){
        //     total[i].val(parseFloat((con[i] * quantities[i]) * price[i].replaceAll(',', '')).toFixed(5));
        //     total[i].attr("data-total", parseFloat((con[i] * quantities[i]) * price[i].replaceAll(',', '')).toFixed(5));
        //     total_txt[i].text(parseFloat((con[i] * quantities[i]) * price[i].replaceAll(',', '')).toFixed(5));
        // }else{
            total[i].val(parseFloat((con[i] * quantities[i]) * price[i].replaceAll(',', '')).toFixed(0));
            total[i].attr("data-total", parseFloat((con[i] * quantities[i]) * price[i].replaceAll(',', '')).toFixed(0));
            total_txt[i].text(parseFloat((con[i] * quantities[i]) * price[i].replaceAll(',', '')).toFixed(0));
        // }

    }
    var totalamount = 0;
    $('.total_Price').each(function () {
        totalamount += Number($(this).attr('data-total'));
    });
    // if($('#currancy').val() == "8"){
    //     $(this).parent().parent().parent().parent().parent().find('#totalamount').val(numberWithCommas(totalamount.toFixed(5)));
    //     $(this).parent().parent().parent().parent().parent().find('#totalamount_txt').text(numberWithCommas(totalamount.toFixed(5)));
    // }else{
        $(this).parent().parent().parent().parent().parent().find('#totalamount').val(numberWithCommas(totalamount.toFixed(0)));
        $(this).parent().parent().parent().parent().parent().find('#totalamount_txt').text(numberWithCommas(totalamount.toFixed(0)));
    // }

    var total_percent = 0;
    var total_amount = 0;
    var test;
    var total_befor_discount = parseFloat($('#totalamount').val().replaceAll(',', ''));
    $.each($("input[name='discount_value[]']"), function (key, value) {
        if ($(this).val().includes('%')) {
            total_percent += (parseFloat($(this).val()) / 100) * parseFloat(
                total_befor_discount);
            $(this).parent().find('#discount_change_total').val((parseFloat($(this).val()) /
                    100) *
                parseFloat(total_befor_discount));
        } else {
            total_amount += parseFloat($(this).val());
            $(this).parent().find('#discount_change_total').val(parseFloat($(this).val()))
        }
    })
    total_befor_discount -= total_amount;
    total_befor_discount -= total_percent;
    // if($('#currancy').val() == "8"){
        var total_after_discount = parseFloat(total_befor_discount).toFixed(0);
    // }else{
    //     var total_after_discount = parseFloat(total_befor_discount).toFixed(1);
    // }

    $('#sum_total_after_discount').text(numberWithCommas(total_after_discount));
    $('#sum_total_after_discount_input').val(total_after_discount);
    if($('#sum_total_after_discount_input').val() != null){
        var total_befor_tax = parseFloat($('#sum_total_after_discount_input').val().replaceAll(',',
        ''));
        total_percent = 0;
        total_amount = 0;
        $.each($("input[name='tax_value[]']"), function (key, value) {
            if ($(this).val().includes('%')) {
                total_percent += (parseFloat($(this).val()) / 100) * parseFloat(total_befor_tax);
                $(this).parent().find('#tax_change_total').val((parseFloat($(this).val()) / 100) *
                    parseFloat(total_befor_tax));
            } else {
                total_amount += parseFloat($(this).val());
                $(this).parent().find('#tax_change_total').val(parseFloat($(this).val()))
            }
        })
        total_befor_tax += total_amount;
        total_befor_tax += total_percent;
        // if($('#currancy').val() == "8"){
            var total_after_tax = parseFloat(total_befor_tax).toFixed(0);
        // }else{
        //     var total_after_tax = parseFloat(total_befor_tax).toFixed(1);
        // }

        $('#sum_total_after_tax').text(numberWithCommas(total_after_tax));
        $('#sum_total_after_tax_input').val(total_after_tax);
    }else{
        var total_befor_tax = parseFloat($('#totalamount').val().replaceAll(',',
        ''));
        total_percent = 0;
        total_amount = 0;
        $.each($("input[name='tax_value[]']"), function (key, value) {
            if ($(this).val().includes('%')) {
                total_percent += (parseFloat($(this).val()) / 100) * parseFloat(total_befor_tax);
                $(this).parent().find('#tax_change_total').val((parseFloat($(this).val()) / 100) *
                    parseFloat(total_befor_tax));
            } else {
                total_amount += parseFloat($(this).val());
                $(this).parent().find('#tax_change_total').val(parseFloat($(this).val()))
            }
        })
        total_befor_tax += total_amount;
        total_befor_tax += total_percent;
        // if($('#currancy').val() == "8"){
            var total_after_tax = parseFloat(total_befor_tax).toFixed(0);
        // }else{
        //     var total_after_tax = parseFloat(total_befor_tax).toFixed(1);
        // }

        $('#sum_total_after_tax').text(numberWithCommas(total_after_tax));
        $('#sum_total_after_tax_input').val(total_after_tax);
    }
    updatefinaltotal();
});


$(document).on('click', '.delete', function () {
    var bar = $(this).parent().parent().find('.bar').val();
    $(this).closest('tr').remove();

    $('.inline').each(function () {
        var id = $(this).val();
        console.log(id);
        if (id == bar) {
            $(this).removeAttr("disabled");
            $(this).prop('checked', false);
        }
    });
    var totalamount = 0;
    $('.total_Price').each(function () {
        if($(this).attr('data-total') == ""){
            totalamount += Number($(this).val());
        }else{
            totalamount += Number($(this).attr('data-total'));
        }
    });
    if($('#currancy').val() == "8"){
        $(document).find('#totalamount').val(numberWithCommas(totalamount.toFixed(5)));
        $(document).find('#totalamount_txt').text(numberWithCommas(totalamount.toFixed(5)));
    }else{
        $(document).find('#totalamount').val(numberWithCommas(totalamount.toFixed(1)));
        $(document).find('#totalamount_txt').text(numberWithCommas(totalamount.toFixed(1)));
    }

    var total_percent = 0;
    var total_amount = 0;
    var test;
    var total_befor_discount = parseFloat($('#totalamount').val().replaceAll(',', ''));
    $.each($("input[name='discount_value[]']"), function (key, value) {
        if ($(this).val().includes('%')) {
            total_percent += (parseFloat($(this).val()) / 100) * parseFloat(
                total_befor_discount);
            $(this).parent().find('#discount_change_total').val((parseFloat($(this).val()) /
                    100) *
                parseFloat(total_befor_discount));
        } else {
            total_amount += parseFloat($(this).val());
            $(this).parent().find('#discount_change_total').val(parseFloat($(this).val()))
        }
    })
    total_befor_discount -= total_amount;
    total_befor_discount -= total_percent;
    if($('#currancy').val() == "8"){
        var total_after_discount = parseFloat(total_befor_discount).toFixed(5);
    }else{
        var total_after_discount = parseFloat(total_befor_discount).toFixed(1);
    }

    $('#sum_total_after_discount').text(numberWithCommas(total_after_discount));
    $('#sum_total_after_discount_input').val(total_after_discount);
    var total_befor_tax = parseFloat($('#sum_total_after_discount_input').val().replaceAll(',',
        ''));
    total_percent = 0;
    total_amount = 0;
    $.each($("input[name='tax_value[]']"), function (key, value) {
        if ($(this).val().includes('%')) {
            total_percent += (parseFloat($(this).val()) / 100) * parseFloat(total_befor_tax);
            $(this).parent().find('#tax_change_total').val((parseFloat($(this).val()) / 100) *
                parseFloat(total_befor_tax));
        } else {
            total_amount += parseFloat($(this).val());
            $(this).parent().find('#tax_change_total').val(parseFloat($(this).val()))
        }
    })
    total_befor_tax += total_amount;
    total_befor_tax += total_percent;
    if($('#currancy').val() == "8"){
        var total_after_tax = parseFloat(total_befor_tax).toFixed(5);
    }else{
        var total_after_tax = parseFloat(total_befor_tax).toFixed(1);
    }

    $('#sum_total_after_tax').text(numberWithCommas(total_after_tax));
    $('#sum_total_after_tax_input').val(total_after_tax);
});

$(document).on('click', '.deleteitem', function () {
    var bar = $(this).parent().parent().find('.bar').val();
    $(this).closest('tr').remove();

    $('.inline').each(function () {
        var id = $(this).val();
        console.log(id);
        if (id == bar) {
            $(this).removeAttr("disabled");
            $(this).prop('checked', false);
            $(this).parent().parent().parent().find('.quantity_pos_choose').attr('readonly',false);
            $(this).parent().parent().parent().find('.quantity_pos_choose').val("");
        }
    });
    var totalamount = 0;
    $('.total_Price').each(function () {
        if($(this).attr('data-total') == ""){
            totalamount += Number($(this).val());
        }else{
            totalamount += Number($(this).attr('data-total'));
        }
    });
    if(totalamount == 0){
        $(document).find('#totalamount').val(0);
        $(document).find('#totalamount_txt').text(0);
    }else{
        $(document).find('#totalamount').val(numberWithCommas(totalamount.toFixed(1)));
        $(document).find('#totalamount_txt').text(numberWithCommas(totalamount.toFixed(1)));
    }

    if($('#dtMaterialDesignExample tbody tr').length == 0 && $('#dtMaterialDesignExample').length == 1){
        $('#sendStore').attr('disabled',true);
        // $('#quotation').attr('disabled',true);
    }
    updatefinaltotal();
});
$(document).on("keyup", "input:text.quentity", function () {
    ChangeAny($(this));
});
var alerrt =0;
$(document).on("change", "input:text.price", function () {

    if ($(this).val() != '') {
        $(this).val(numberWithCommas( parseFloat($(this).val().replaceAll(',',''))));
    }else{
        $(this).val(0);
    }
    var price = parseFloat($(this).parent().parent().find('.price').val().replaceAll(',',''));
    var cost = $(this).parent().parent().find('.price').data('cost_rate');
    var rrate = $('#currency_sales').find(":selected").data('rate');
    if(rrate == undefined){
        rrate = $('#currancy').find(":selected").data('rate');
    }
    cost = cost * rrate;
    if (cost > price ) {
        alerrt = 1;
        alert("You cannot set a price lower than the cost");
        $(this).parent().parent().find('.price').css('background-color','rgb(248, 215, 218)');
    }
    ChangeAny($(this));
});

$(document).on("focusout", "input:text.price", function () {
    if ($(this).val() != '') {
        $(this).val(numberWithCommas( parseFloat($(this).val().replaceAll(',',''))));
    }else{
        $(this).val(0);
    }
    var price = parseFloat($(this).parent().parent().find('.price').val().replaceAll(',',''));
    var cost = $(this).parent().parent().find('.price').data('cost_rate');
    var rrate = $('#currency_sales').find(":selected").data('rate');
    if(rrate == undefined){
        rrate = $('#currancy').find(":selected").data('rate');
    }
    cost = cost * rrate;
    if (cost > price ) {
        if (alerrt == 0) {
            alert("You cannot set a price lower than the cost");
        }else{
            alerrt = 0;
        }
        $(this).parent().parent().find('.price').css('background-color','rgb(248, 215, 218)');
    }
});


$(document).on("focusin", "input:text.price", function () {
    $(this).css('background-color','#fff');
});

$(document).on('change', 'select[id=pack]', function () {
    ChangeAny($(this));
});

$(document).on("focusout", "input:text.priceing", function () {
    if ($(this).val() != '') {
        $(this).val(numberWithCommas( parseFloat($(this).val().replaceAll(',',''))));
    }else{
        $(this).val(0)
    }

    var con = $(this).parent().parent().find('#packages').find(":selected").attr('data-count');
    var price = $(this).val();
    if(price == ""){
        price = 1;
    }
    var quantity = $(this).parent().parent().find('.quentities').val();
    var cost = $(this).parent().parent().find('.cost').val()
    var rrate = $('#currency_sales').find(":selected").data('rate');
    if(rrate == undefined){
        rrate = $('#currancy').find(":selected").data('rate');
    }
    if(rrate == undefined){
        rrate = 1;
    }
    cost = cost * rrate;
    console.log(parseFloat(price.replaceAll(',', '')) ,"99", parseFloat(cost),check_admin);
    if (parseFloat(price.replaceAll(',', '')) < parseFloat(cost))  {
        var dec = $('#currency_sales').find(":selected").data('dec');
        if(dec == undefined){
             dec = $('#currancy').find(":selected").data('decimal');
        }
        if(dec == undefined){
            dec = 0;
        }
        console.log(parseFloat(price.replaceAll(',', '')) ,"88", parseFloat(cost),check_admin);
        if(check_admin == "1"){
            // $(this).removeClass('priceing');
            // alert("You cannot set a price lower than the cost");
            $(this).val('');
            // console.log(5035);
            var total = parseFloat(quantity.replaceAll(',', '')) * parseFloat(price.replaceAll(',', ''));
            $(this).data('pricepice',parseFloat(price.replaceAll(',', '')));
            $(this).parent().parent().find('.total_Price').val(numberWithCommas(total * con));

                $(this).parent().parent().find('.total_Price').attr("data-total", (total * con).toFixed(dec));
                $(this).parent().parent().find('.total_Price_txt').text(numberWithCommas(parseFloat(total * con).toFixed(dec)));


            var totalamount = 0;
            if($('#table_qoutation').dataTable().length > 0){
                $('#table_qoutation').dataTable().$('.total_Price').each(function () {
                    totalamount += Number($(this).attr('data-total'));
                });
            }else{
                $('.total_Price').each(function () {
                    if($(this).parent().parent().find('#product_type').val() != "sample"){
                        totalamount += Number($(this).attr('data-total').replaceAll(',', ''));
                    }
                });
            }

            $(this).parent().parent().parent().parent().find('#totalamount').val(numberWithCommas(totalamount.toFixed(dec)));
            $(this).parent().parent().parent().parent().find('#totalamount_txt').text(numberWithCommas(totalamount.toFixed(dec)));


            var total_percent = 0;
            var total_amount = 0;
            var test;
            var total_befor_discount = parseFloat($('#totalamount').val().replaceAll(',', ''));
            $.each($("input[name='discount_value[]']"), function (key, value) {
                if ($(this).val().includes('%')) {
                    total_percent += (parseFloat($(this).val()) / 100) * parseFloat(
                        total_befor_discount);
                    $(this).parent().find('#discount_change_total').val((parseFloat($(this).val()) /
                            100) *
                        parseFloat(total_befor_discount));
                } else {
                    total_amount += parseFloat($(this).val());
                    $(this).parent().find('#discount_change_total').val(parseFloat($(this).val()))
                }
            })
            total_befor_discount -= total_amount;
            total_befor_discount -= total_percent;
            var total_after_discount = parseFloat(total_befor_discount).toFixed(dec);


            $('#sum_total_after_discount').text(numberWithCommas(total_after_discount));
            $('#sum_total_after_discount_input').val(total_after_discount);
            if($('#sum_total_after_discount_input').val() != null){
                var total_befor_tax = parseFloat($('#sum_total_after_discount_input').val().replaceAll(',',
                ''));
                total_percent = 0;
                total_amount = 0;
                $.each($("input[name='tax_value[]']"), function (key, value) {
                    if ($(this).val().includes('%')) {
                        total_percent += (parseFloat($(this).val()) / 100) * parseFloat(total_befor_tax);
                        $(this).parent().find('#tax_change_total').val((parseFloat($(this).val()) / 100) *
                            parseFloat(total_befor_tax));
                    } else {
                        total_amount += parseFloat($(this).val());
                        $(this).parent().find('#tax_change_total').val(parseFloat($(this).val()))
                    }
                })
                total_befor_tax += total_amount;
                total_befor_tax += total_percent;

                    var total_after_tax = parseFloat(total_befor_tax).toFixed(dec);


                $('#sum_total_after_tax').text(numberWithCommas(total_after_tax));
                $('#sum_total_after_tax_input').val(total_after_tax);
            }else{
                var total_befor_tax = parseFloat($('#totalamount').val().replaceAll(',',
                ''));
                total_percent = 0;
                total_amount = 0;
                $.each($("input[name='tax_value[]']"), function (key, value) {
                    if ($(this).val().includes('%')) {
                        total_percent += (parseFloat($(this).val()) / 100) * parseFloat(total_befor_tax);
                        $(this).parent().find('#tax_change_total').val((parseFloat($(this).val()) / 100) *
                            parseFloat(total_befor_tax));
                    } else {
                        total_amount += parseFloat($(this).val());
                        $(this).parent().find('#tax_change_total').val(parseFloat($(this).val()))
                    }
                })
                total_befor_tax += total_amount;
                total_befor_tax += total_percent;
                    var total_after_tax = parseFloat(total_befor_tax).toFixed(dec);


                $('#sum_total_after_tax').text(numberWithCommas(total_after_tax));
                $('#sum_total_after_tax_input').val(total_after_tax);
            }
        }else{
            alert("You cannot set a price lower than the bulk")
            $(this).val("")
            $(this).parent().parent().find('.total_Price').val("");
            $(this).parent().parent().find('.total_Price_txt').text("");
        }
    }
    updatefinaltotal();
});



$(document).on("keyup", "input:text.priceing", function () {
    if ($(this).val() != '') {
        $(this).val(numberWithCommas( parseFloat($(this).val().replaceAll(',',''))));
    }else{
        $(this).val(0)
    }
    var con = $(this).parent().parent().find('#packages').find(":selected").attr('data-count');
    var price = $(this).val();
    if(price == ""){
        price = 1;
    }
    var quantity = $(this).parent().parent().find('.quentities').val();
    var cost = $(this).parent().parent().find('.cost').val()
    var rrate = $('#currency_sales').find(":selected").data('rate');
    if(rrate == undefined){
        rrate = $('#currancy').find(":selected").data('rate');
    }
    if(rrate == undefined){
        rrate = 1;
    }
    cost = cost * rrate;
    if (parseFloat(price.replaceAll(',', '')) >= parseFloat(cost)) {
        var total = parseFloat(quantity.replaceAll(',', '')) * parseFloat(price.replaceAll(',', ''));
        $(this).data('pricepice',parseFloat(price.replaceAll(',', '')));
        $(this).parent().parent().find('.total_Price').val(numberWithCommas(total * con));
        var dec = $('#currency_sales').find(":selected").data('dec');
        if(dec == undefined){
             dec = $('#currancy').find(":selected").data('decimal');
        }        // if($('#currancy').val() == "8"){
            $(this).parent().parent().find('.total_Price').attr("data-total", (total * con).toFixed(dec));
            $(this).parent().parent().find('.total_Price_txt').text(numberWithCommas(parseFloat(total * con).toFixed(dec)));
        // }else{
        //     $(this).parent().parent().find('.total_Price').attr("data-total", (total * con).toFixed(1));
        //     $(this).parent().parent().find('.total_Price_txt').text(numberWithCommas(parseFloat(total * con).toFixed(1)));
        // }

        var totalamount = 0;
        if($('#table_qoutation').dataTable().length > 0){
            $('#table_qoutation').dataTable().$('.total_Price').each(function () {
                totalamount += Number($(this).attr('data-total'));
            });
        }else{
            $('.total_Price').each(function () {
                if($(this).parent().parent().find('#product_type').val() != "sample"){
                    totalamount += Number($(this).attr('data-total').replaceAll(',', ''));
                }
            });
        }
            $(this).parent().parent().parent().parent().find('#totalamount').val(numberWithCommas(totalamount.toFixed(dec)));
            $(this).parent().parent().parent().parent().find('#totalamount_txt').text(numberWithCommas(totalamount.toFixed(dec)));


        var total_percent = 0;
        var total_amount = 0;
        var test;
        var total_befor_discount = parseFloat($('#totalamount').val().replaceAll(',', ''));
        $.each($("input[name='discount_value[]']"), function (key, value) {
            if ($(this).val().includes('%')) {
                total_percent += (parseFloat($(this).val()) / 100) * parseFloat(
                    total_befor_discount);
                $(this).parent().find('#discount_change_total').val((parseFloat($(this).val()) /
                        100) *
                    parseFloat(total_befor_discount));
            } else {
                total_amount += parseFloat($(this).val());
                $(this).parent().find('#discount_change_total').val(parseFloat($(this).val()))
            }
        })
        total_befor_discount -= total_amount;
        total_befor_discount -= total_percent;
            var total_after_discount = parseFloat(total_befor_discount).toFixed(dec);


        $('#sum_total_after_discount').text(numberWithCommas(total_after_discount));
        $('#sum_total_after_discount_input').val(total_after_discount);
        if($('#sum_total_after_discount_input').val() != null){
            var total_befor_tax = parseFloat($('#sum_total_after_discount_input').val().replaceAll(',',
            ''));
            total_percent = 0;
            total_amount = 0;
            $.each($("input[name='tax_value[]']"), function (key, value) {
                if ($(this).val().includes('%')) {
                    total_percent += (parseFloat($(this).val()) / 100) * parseFloat(total_befor_tax);
                    $(this).parent().find('#tax_change_total').val((parseFloat($(this).val()) / 100) *
                        parseFloat(total_befor_tax));
                } else {
                    total_amount += parseFloat($(this).val());
                    $(this).parent().find('#tax_change_total').val(parseFloat($(this).val()))
                }
            })
            total_befor_tax += total_amount;
            total_befor_tax += total_percent;
            // if($('#currancy').val() == "8"){
                var total_after_tax = parseFloat(total_befor_tax).toFixed(dec);
            // }else{
            //     var total_after_tax = parseFloat(total_befor_tax).toFixed(1);
            // }
            $('#sum_total_after_tax').text(numberWithCommas(total_after_tax));
            $('#sum_total_after_tax_input').val(total_after_tax);
        }else{
            var total_befor_tax = parseFloat($('#totalamount').val().replaceAll(',',''));
            total_percent = 0;
            total_amount = 0;
            $.each($("input[name='tax_value[]']"), function (key, value) {
                if ($(this).val().includes('%')) {
                    total_percent += (parseFloat($(this).val()) / 100) * parseFloat(total_befor_tax);
                    $(this).parent().find('#tax_change_total').val((parseFloat($(this).val()) / 100) *
                        parseFloat(total_befor_tax));
                } else {
                    total_amount += parseFloat($(this).val());
                    $(this).parent().find('#tax_change_total').val(parseFloat($(this).val()))
                }
            })
            total_befor_tax += total_amount;
            total_befor_tax += total_percent;
                var total_after_tax = parseFloat(total_befor_tax).toFixed(dec);


            $('#sum_total_after_tax').text(numberWithCommas(total_after_tax));
            $('#sum_total_after_tax_input').val(total_after_tax);
        }
    }

    updatefinaltotal();
});

$(document).on("keyup", "input:text.quentities", function () {
    var dec = $('#currency_sales').find(":selected").data('dec');
    if(dec == undefined){
        var dec = $('#currancy').find(":selected").data('decimal');
    }
    if ($(this).val() != '') {
        $(this).val(numberWithCommas( parseFloat($(this).val().replaceAll(',','').replaceAll('.',''))));
    }else{
        $(this).val(0)
    }
    var con = $(this).parent().parent().find('#packages').find(":selected").attr('data-count');
    if (con == undefined) {
        con = 1;
    }
    var quantity = parseFloat($(this).val().replaceAll(',', ''));
    if(quantity == ""){
        quantity = 1;
    }
    var price = parseFloat($(this).parent().parent().find('.priceing').val().replaceAll(',', ''));
    var total = quantity * price;
    $(this).parent().parent().find('.total_Price').val(numberWithCommas(total * con));

        $(this).parent().parent().find('.total_Price').attr("data-total", (total * con).toFixed(dec));
        $(this).parent().parent().find('.total_Price_txt').text(numberWithCommas(parseFloat(total * con).toFixed(dec)));


    var totalamount = 0;
    if($('#table_qoutation').dataTable().length > 0){
        $('#table_qoutation').dataTable().$('.total_Price').each(function () {
            totalamount += Number($(this).attr('data-total'));
        });
    }else{
        $('.total_Price').each(function () {
            if($(this).parent().parent().find('#product_type').val() != "sample"){
                totalamount += Number($(this).attr('data-total').replaceAll(',', ''));
            }
        });
    }
    // if($('#currancy').val() == "8"){
        $(this).parent().parent().parent().parent().find('#totalamount').val(numberWithCommas(totalamount.toFixed(dec)));
        $(this).parent().parent().parent().parent().find('#totalamount_txt').text(numberWithCommas(totalamount.toFixed(dec)));
    // }else{
    //     $(this).parent().parent().parent().parent().find('#totalamount').val(numberWithCommas(totalamount.toFixed(1)));
    //     $(this).parent().parent().parent().parent().find('#totalamount_txt').text(numberWithCommas(totalamount.toFixed(1)));
    // }
    var total_percent = 0;
        var total_amount = 0;
        var test;
        var total_befor_discount = parseFloat($('#totalamount').val().replaceAll(',', ''));
        $.each($("input[name='discount_value[]']"), function (key, value) {
            if ($(this).val().includes('%')) {
                total_percent += (parseFloat($(this).val()) / 100) * parseFloat(
                    total_befor_discount);
                $(this).parent().find('#discount_change_total').val((parseFloat($(this).val()) /
                        100) *
                    parseFloat(total_befor_discount));
            } else {
                total_amount += parseFloat($(this).val());
                $(this).parent().find('#discount_change_total').val(parseFloat($(this).val()))
            }
        })
        total_befor_discount -= total_amount;
        total_befor_discount -= total_percent;
            var total_after_discount = parseFloat(total_befor_discount).toFixed(dec);


        $('#sum_total_after_discount').text(numberWithCommas(total_after_discount));
        $('#sum_total_after_discount_input').val(total_after_discount);
    updatefinaltotal();
});
$(document).on('change', 'select[id=packages]', function () {
    var con = $('option:selected', this).attr('data-count');
    var quantity = $(this).parent().parent().find('.quentities').val();
    if (quantity == "") {
        quantity = 1;
    }

    var price = $(this).parent().parent().find('.priceing').data('pricepice');

    var total = quantity * price;
    $(this).parent().parent().find('.total_Price').val(numberWithCommas(total * con));
    if($('#currancy').val() == "8"){
        $(this).parent().parent().find('.total_Price').attr("data-total", (total * con).toFixed(5));
        $(this).parent().parent().find('.total_Price_txt').text(numberWithCommas(parseFloat(total * con).toFixed(5)));
    }else{
        $(this).parent().parent().find('.total_Price').attr("data-total", (total * con).toFixed(1));
        $(this).parent().parent().find('.total_Price_txt').text(numberWithCommas(parseFloat(total * con).toFixed(1)));
    }

    var totalamount = 0;
    if($('#table_qoutation').dataTable().length > 0){
        $('#table_qoutation').dataTable().$('.total_Price').each(function () {
            totalamount += Number($(this).attr('data-total'));
        });
    }else{
        $('.total_Price').each(function () {
            totalamount += Number($(this).attr('data-total'));
        });
    }
    if($('#currancy').val() == "8"){
        $(this).parent().parent().parent().parent().find('#totalamount').val(numberWithCommas(totalamount.toFixed(5)));
        $(this).parent().parent().parent().parent().find('#totalamount_txt').text(numberWithCommas(totalamount.toFixed(5)));
    }else{
        $(this).parent().parent().parent().parent().find('#totalamount').val(numberWithCommas(totalamount.toFixed(1)));
        $(this).parent().parent().parent().parent().find('#totalamount_txt').text(numberWithCommas(totalamount.toFixed(1)));
    }
    updatefinaltotal();
});
