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

function searchInventory(value, category) {
    var noResultsRow = $(".no-results");
    var hasResults = false;
  
    $(".inventory-row").each(function() {
      var card = $(this);
  
      if (!card.hasClass("invisible")) {
        var productName = card.find(".inventory-name").text().toLowerCase();
        var productCategory = card.find(".inventory-category").text().toLowerCase();
        var productID = card.find(".inventory-id").text().toLowerCase();
  
        var productDetails = productName + " " + productID;
  
        var isSearchMatch;
  
        if (category === 'all') {
          isSearchMatch = productDetails.indexOf(value) > -1;
        } else {
          isSearchMatch = productDetails.indexOf(value) > -1 && productCategory === category;
        }
  
        card.toggle(isSearchMatch);
  
        if (isSearchMatch) {
          hasResults = true;
        }
      }
    });
  
    noResultsRow.toggle(!hasResults);
  }

function searchLogs(value, category) {
    var noResultsRow = $(".no-results");
    var hasResults = false;
  
    $(".log-row").each(function() {
      var card = $(this);
  
      if (!card.hasClass("invisible")) {
        var details = card.find(".log-details").text().toLowerCase();
        var logCategory = card.find(".log-category").text().toLowerCase();
        var logID = card.find(".log-id").text().toLowerCase();
        var logUser = card.find(".log-user").text().toLowerCase();
        var logDateTime = card.find(".log-datetime").text().toLowerCase();
  
        var productDetails = details + " " + logID + " " + logUser + " " + logDateTime;
  
        var isSearchMatch;
  
        if (category === 'all') {
          isSearchMatch = productDetails.indexOf(value) > -1;
        } else {
          isSearchMatch = productDetails.indexOf(value) > -1 && logCategory === category;
        }
  
        card.toggle(isSearchMatch);
  
        if (isSearchMatch) {
          hasResults = true;
        }
      }
    });
  
    noResultsRow.toggleClass("hide", hasResults);
  }


$(document).ready(function() {
    
    $("#search").on("keyup", function() {
        var search = $(this).val().toLowerCase();
        var category = $(".category-button.selected").text().toLowerCase();
        searchCards(search, category);
        searchInventory(search, category);
        searchLogs(search, category);

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
        searchInventory(search, category);
        searchLogs(search, category);
       
        $(".category-button").removeClass("selected");
        
        $(this).addClass("selected");
    
    });
});

$(document).ready(function() {
    $(".search-meron").on("click", function() {
        document.getElementById('search').value = '';
        var search = $("#search").val().toLowerCase();
        var category = $(".category-button.selected").text().toLowerCase();
        searchCards(search, category);
        searchInventory(search, category);
        searchLogs(search, category);
        
        $(".search-empty").removeClass("hide");
        $(".search-meron").addClass("hide");
    });
});

