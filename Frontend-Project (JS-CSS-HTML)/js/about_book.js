var cnt, found_book, book_id = window.location.hash, eye, cur, prc;

if(getCookie("name")) cur = getCookie("name");
 
// Add main contents about the selected book
$.ajax({
    url: "https://netology-fbb-store-api.herokuapp.com/book/"+book_id.slice(1), success: function (data){        
        $('form').prop('action', "order.html"+book_id);
        found_book = data;  
        
        // data left to the book 
        $(".left_to_book").append('<img src="'+found_book.reviews[0].author.pic+'"><h3>"'+found_book.reviews[0].cite+'"</h3><img src="'+found_book.reviews[1].author.pic+'"><h3>"'+found_book.reviews[1].cite+'"</h3>');
        
        // middle - the book itself
        $("#eye").append('<img id="book" src="'+found_book.cover.large+'"><h2>'+found_book.description+'</h2>'); 
        
        // data right to the book
        $(".right_to_book").append('<img src="'+found_book.features[0].pic+'"><h3>'+found_book.features[0].title+'</h3><img src="'+found_book.features[1].pic+'"><h3>'+found_book.features[1].title+'</h3>');
        
        if(getCookie("fixed") == 1 && getCookie("name") != "USD")  {
           prc = found_book.price * getCookie("coef");
           $(".buy").text('Купить за жалкие ' + prc.toFixed(2)  + ' ' + cur);
        }
        else $(".buy").text('Купить за жалкие ' + found_book.price + ' USD');
    }
})
    
// Make the eye blink
var cnt = 100, i = 0;
var blink = function() {
    $("#eye_layer2").attr("ry", cnt);
    if(i++ < 5)  cnt -= 20;
    else  cnt += 20;
    if(i >= 10) i = 0;
}
setInterval(blink, 200);

// Make the eye follow the mouse
$( window).mousemove(function (e) {
    var diff_x = Math.abs($("#eye_layer2").attr("cx") -  165 + e.pageX / 16);
    var diff_y = Math.abs($("#eye_layer2").attr("cy") -  260 + e.pageY / 12);
    
    if(diff_x < 200) $("#eye_layer3").attr("cx",  165 + e.pageX / 16);
    if(diff_y < 200) $("#eye_layer3").attr("cy",  265 + e.pageY / 10);
})