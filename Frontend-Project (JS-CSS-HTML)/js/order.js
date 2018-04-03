var book_id = window.location.hash;
var delivery_cost = 0;
var order;
var currFrom;
var currTo;
var priceFrom;
var priceTo;
var delivery_id = "delivery-01";
var payment_id = "payment-01";
var fixed_currency = 0;
var link = "https://netology-fbb-store-api.herokuapp.com";

// Add data about the selected book
$.ajax({
    url: link+"/book/"+book_id.slice(1), success: function (data){
        $('.order_form').parent().prepend('<h2 class="text-center">Оформить заказ на книгу "<a href="about_book.html'+book_id+'">'+data.title+'</a>"</h2>');
        $("#img").append('<img src="'+data.cover.small+'">');
        priceFrom = data.price;
    }
})
    
// Add delivery options
$.ajax({
    url: link+"/order/delivery", success: function (data){
        data.forEach(function (elem) {
            $('#delivery').append('<input type="radio" id="'+elem.id+'" class="deliver"> '+elem.name+' - '+elem.price+' $ <br>');
            $('#delivery > input').last().data('data', elem);
        })
        $('.deliver').first().prop('checked', true);
        delivery_id =  $('.deliver').first().data('data').id;
    }
})
   
// Add payment options
$.ajax({
    url: link+"/order/payment", success: function (data){
        data.forEach(function (elem) {
            $('#payment').append('<input type="radio" class="deliver">'+elem.title+'<br>');
            $('#payment > input').last().data('availableFor', elem.availableFor, 'id', elem.id);
            $('#payment > input').last().data('id', elem.id);
        })
        $('#payment > input').first().prop('checked', true);
}})

// Listen to the payment options 
$(document).on('click', '#payment > input', function () {
    payment_id = $(this).data('id');
})

// Listen to the delivery options and reflect the payment options accordingly
$(document).on('click', '#delivery > .deliver', function () {
    delivery_id = $(this).data('data').id;
    if($(this).prop('checked')){
        $('#delivery > .deliver').not(this).prop('checked', false);
        delivery_cost = $(this).data('data').price;
        checkDeliveryOpt($(this).attr('id'));
    }
    if($(this).prop("id") != "delivery-04" && $(this).prop("id") != "delivery-01")
      $("#address").show();
    else 
        $("#address").hide();
    final_price();
})

// Listen to the payment options to allow checked only one
$(document).on('click', '#payment > .deliver', function () {
    if($(this).prop('checked')){
        $('#payment > .deliver').not(this).prop('checked', false);
    }
})


// Function to disable / enable payment options
var deliveryIsAvail, checkDeliveryOpt = function (id) {
    $('#payment > .deliver').each(function (){
        deliveryIsAvail = $(this).data('availableFor').find(function (i) {
            if(i == id) return true;
        });
        if(!deliveryIsAvail) {
            $(this).prop('disabled', true);
            $(this).prop('checked', false);
        } else {
            $(this).prop('disabled', false);
        }
    })
}

// Add currencies
$.ajax({url: link+"/currency", success: function (data){
  data.forEach( function (elm){
    $("#currency").append($('<option>'+elm.Name+'</option>').data('data', elm));
  })
  $('#currency > option:eq( 9 )').prop('selected', true);
  currFrom = $("#currency > option:selected").data('data');
  currTo = $("#currency > option:selected").data('data');
  final_price();
  if (getCookie("fixed") == 1) set_curr = 1,  $("#currency").hide(), $('#currency').attr('checked', true);
}})


// Calculate the final price 
var final_price = function () {
    if(getCookie("fixed") == 1)   {
        priceTo = (priceFrom + delivery_cost) * getCookie("coef");
        $('#final_price').text('Итого к оплате: '+(priceTo.toFixed(2))+' '+getCookie("name"));
    }
    else  {
        priceTo = (priceFrom + delivery_cost) * (currFrom.Value / currFrom.Nominal) / (currTo.Value / currFrom.Nominal);
        $('#final_price').text('Итого к оплате: '+(priceTo.toFixed(2))+' '+currTo.CharCode);
    }
}

$(document).on('change', "#currency", function(){
    nameCurrency = $("#currency > option:selected").data('data').Name;
    currTo = $("#currency > option:selected").data('data');
    final_price();
})

//Send a book order 
var sendRequest = function () {
    order = { 
        "manager": $('#email').val(),
        "book": book_id.slice(1), 
        "name": $('#name').val(), 
        "phone": $('#tel').val(), 
        "email": $('#email').val(), 
        "comment": $('#comment').val(), 
        "delivery": { 
            "id": delivery_id, 
            "address": $('#addr').val(),
             }, 
        "payment": { 
            "id": payment_id,
            "currency": $("#currency > option:selected").data('data').ID
         } 
       };
   
    // console.log(JSON.stringify(order));
    
    $.ajax ({
        type: "POST",
        url: link+'/order',
        contentType : 'application/json',
        data: JSON.stringify(order),
        dataType: 'json',
        success: function (e) {
            if(e.status == "success"){
                $(".order_form").parent().hide();
                 $(".main").append('<div id="orderMessage"><h3>Заказ на книгу успешно оформлен.</h3><h3>Спасибо, что спасли книгу от сжигания в печи.</h3></div>');
            }
        },
         error: function(data){
              alert("Заказ на книгу не оформлен. Проверьте Ваши данные в форме заказа. Телефон, имя и эл. адрес обязательны для заполнения.");
         }
    })
}

// Check input for tel (if it's number)
function checkInput(inpt){
    wrong_input =  $(inpt).val().match(/[^\d.-]/g, '');
    if(wrong_input) {
        $(inpt).val($(inpt).val().replace(/[^\d.-]/g, '')); 
        $('#error').css('display', 'block').delay( 1500 ).fadeOut( 800 ); 
        return true;
    } else return false; 
}

$(document).on('keyup', "#tel", function () {  checkInput(this); });
               
$(document).on('click', "#buy", function () {
    if($('#name').val() == "Имя" || $('#email').val() == "Эл. адрес" || $('#tel').val() == "Телефон")
        alert("Введите Ваши данные в форме заказа. Телефон, имя и эл. адрес обязательны для заполнения.");
    else sendRequest();
});

// Check if the currency is fixed for the whole website and reflect it in co0kies
$(document).on('click', "#for_all", function () {
    fixed_currency = fixed_currency ? false : true;
    if(fixed_currency) {
        document.cookie = "name="+currTo.CharCode+"";
        document.cookie = "fixed=1";
        document.cookie = "coef="+currFrom.Value / currFrom.Nominal / (currTo.Value / currFrom.Nominal); 
        $("#currency").hide();
    }
    else document.cookie = "fixed=0", $("#currency").show();
});



