/**
 * Comment
 */
function product_detail_init() {

}

function imgError(image) {
    image.onerror = "";
    image.src = site_url + "public/img/coming_soon.jpg";
    console.log("image replaced");
    return true;
}

/**
 * Products Init
 */
function products_init() {
    $('#btnAddToCart').button('reset');
    $('#btnPayNow').button('reset');
    $("#btnAddToCart").bind('click', function () {
        $("#btnAddToCart").button('loading').text("Please wait...");

        submitAddToCart();
        //track add to cart
        pe_action_data.action = 'add_to_cart';
        Predictry.sendAction(pe_action_data);

        if (is_recommended_product)
        {
            // track recommended item that added to cart
            pe_action_data.action = "recommended_item_added_to_cart";
            pe_action_data.item_properties = {};
            Predictry.sendAction(pe_action_data);
        }

        return false;
    });

    $('#btnCheckout').button('reset');
    $("#btnCheckout").bind('click', function ()
    {
        $("#btnCheckout").button('loading').text("Please wait...");
        var started_checkout_actions = Predictry.clone(complete_purchase_actions);
        started_checkout_actions.action = 'started_checkout';
        Predictry.sendBulkActions(started_checkout_actions);
        alert("started_checkout sent");
        $('#btnCheckout').button('reset');
        return false;

    });

    $('#btnUpdateCart').button('reset');
    $("#btnUpdateCart").bind('click', function (e)
    {
        e.preventDefault();
        $("#btnUpdateCart").button('loading').text("Please wait...");
        updateCart();
        $('#btnUpdateCart').button('reset');
        return false;
    });

    $('#btnPayNow').button('reset');
    $("#btnPayNow").bind('click', function () {
        $("#btnPayNow").button('loading').text("Please wait...");
        var started_payment_actions = Predictry.clone(complete_purchase_actions);
        started_payment_actions.action = 'started_payment';
        Predictry.sendBulkActions(started_payment_actions);
        alert("started_payment sent");
        Predictry.sendBulkActions(complete_purchase_actions);
        alert("complete_purchase sent");
        $('#btnPayNow').button('reset');
        window.location = site_url + 'home/empty_cart';
        return false;
    });
}

/**
 * Submit Add To Cart
 */
function submitAddToCart() {
    var form = $("#frmCart");
    var frmSerialize = form.serializeArray();

    var form_data = {
        cart: frmSerialize,
        is_ajax: 1
    };

    $.ajax({
        url: site_url + 'products/add_to_cart',
        type: 'POST',
        data: form_data,
        dataType: 'json',
        success: function (data)
        {
            $('#btnAddToCart').button('reset');
            alert(data.message);
        },
        error: function () {
            alert('error!');
        }
    });
    return false;
}

function addToCart(product_id)
{
    var form_data = {
        product_id: product_id,
        is_ajax: 1
    };

    $.ajax({
        url: site_url + "products/add_to_cart",
        type: 'POST',
        data: form_data,
        dataType: 'json',
        success: function (data)
        {
            alert(data.message);
        },
        error: function () {
            alert('error!');
        }
    });

    return false;
}

/**
 * Submit Update Cart
 */
function updateCart() {
    var form = $("#frmUpdateCart");
    var frmSerialize = form.serializeArray();

    var item_ids = [];
    var qty = [];

    for (var i = 0; i < frmSerialize.length; i++)
    {
        var obj = frmSerialize[i];
        if (obj.name === 'item_id') {
            item_ids.push(obj.value);
        }
        else if (obj.name === 'qty')
            qty.push(obj.value);
    }

    var form_data = {
        cart: frmSerialize,
        is_ajax: 1
    };

    $.ajax({
        url: site_url + 'products/update_cart',
        type: 'POST',
        data: form_data,
        dataType: 'json',
        success: function (data)
        {
            if (data.status === 'success')
            {
                for (var i = 0; i < item_ids.length; i++) {
                    if (qty[i] === '0')
                        Predictry.removeItemCartSession(item_ids[i]);

                    Predictry.setCartLog(item_ids[i], qty[i], 'updated');
                }
                window.location = site_url + 'home/cart';
            }
        },
        error: function () {
//            alert('error!');
        }
    });
    return false;
}