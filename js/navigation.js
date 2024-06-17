$(document).ready(function() {
    $(".left-nav-icon").on("click", function() {
       
        $(".left-nav-icon").removeClass("selected");
        
        $(this).addClass("selected");
    
    });
});

function cartButton() {
    var center = document.querySelector('.center-panel');
    var right = document.querySelector('.right-panel');
    var searchbar = document.querySelector('.search-bar');
    
    right.style.display = 'flex';
    center.style.display = 'none';
    searchbar.style.display = 'none';
}

function homeButton() {
    var center = document.querySelector('.center-panel');
    var right = document.querySelector('.right-panel');
    var searchbar = document.querySelector('.search-bar');
    
    right.style.display = 'none';
    center.style.display = 'inline';
    searchbar.style.display = 'inline';
}

