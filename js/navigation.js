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
    
    if (right != null) right.style.display = 'flex';
    if (center != null) center.style.display = 'none';
    if (searchbar != null) searchbar.style.display = 'none';
}

function homeButton() {
    var center = document.querySelector('.center-panel');
    var right = document.querySelector('.right-panel');
    var searchbar = document.querySelector('.search-bar');
    
    if (right != null) right.style.display = 'none';
    if (center != null) center.style.display = 'inline';
    if (searchbar != null) searchbar.style.display = 'inline';
}

function goToPage(page) {
    window.location.href=page;
}