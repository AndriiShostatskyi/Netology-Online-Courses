var books_data, num_books = 4, cnt, src;

// Function to load books
var add_books = function () {
    $.ajax({
        url: "https://netology-fbb-store-api.herokuapp.com/book", success: function (data) {
            books_data = data, cnt = 0;
            data.forEach( function(i) {
                if(cnt++ < num_books && cnt > num_books - 4)
                    $("#sortable").append('<li class="ui-state col-s-12 col-m-6 col-l-3"><a href="about_book.html#'+i.id+'"><img  src="'+i.cover.small+'"></a> <p class="book">'+i.info+'</p></li>');
            })
            num_books += 4;
        }
    })
}
    
// Load books
$(document).ready(add_books);
$(document).on("click", ".morebooks", add_books);
    
// Search books
$(document).on("click", "#search", function () {
    $(document).on("keyup", "#search", function () {
        src = $("#search").val(); // user search input
        cnt = 0;
        $('#sortable > li').remove(); // remove all books
        books_data.forEach( function(i) { // show books that match
            if(i.title.toLowerCase().search(src.toLowerCase()) != -1 &&  cnt < num_books - 4){
                $("#sortable").append('<li class="ui-state col-s-12 col-m-6 col-l-3"><a href="about_book.html#'+i.id+'"><img  src="'+i.cover.small+'"></a> <p class="book">'+i.info+'</p></li>');
            }
        })
    })
})
    
// For drag + drop + sortable - jquery-ui
$( function() {
$( "#sortable" ).sortable();
$( "#sortable" ).disableSelection();
});


