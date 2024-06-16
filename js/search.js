function searchCards(value , category) {
    $(".product-card").each(function() {
        var card = $(this);
        
        if (!card.hasClass("invisible")) {
            var productName = card.find(".product-name").text().toLowerCase();
            var productCategory = card.find(".product-card-desc").attr("category").toLowerCase();
            
            var productDetails = productName;

            var isSearchMatch;
            
            if (category === 'all') {
                isSearchMatch = productDetails.indexOf(value) > -1;
            } else {
                isSearchMatch = productDetails.indexOf(value) > -1 && productCategory === category;
            }

            card.toggle(isSearchMatch);
            
        }
    });
}

$(document).ready(function() {
    $("#search").on("keyup", function() {
        var search = $(this).val().toLowerCase();
        var category = $(".category-button.selected").text().toLowerCase();
        searchCards(search, category);

        if(search){
            $(".search-empty").addClass("hide");
            $(".search-meron").removeClass("hide");
        } else{
            $(".search-empty").removeClass("hide");
            $(".search-meron").addClass("hide");
        }

    });
});

$(document).ready(function() {
    $(".category-button").on("click", function() {
        var search = $("#search").val().toLowerCase();
        var category = $(this).text().toLowerCase();
        
        searchCards(search, category);
       
        $(".category-button").removeClass("selected");
        
        $(this).addClass("selected");
    
    });
});

$(document).ready(function() {
    $(".search-meron").on("click", function() {
        document.getElementById('search').value = '';
        var search = $("#search").val().toLowerCase();
        var category = $(".selected").text().toLowerCase();
        searchCards(search, category);
        
        $(".search-empty").removeClass("hide");
        $(".search-meron").addClass("hide");
    });
});

