$(document).ready(function() {
    $(".test-button").on("click", function() {
        var r = document.querySelector(':root');
        r.style.setProperty('--background-color-1', '#ffc4e1');
        r.style.setProperty('--background-color-2', '#ffc4e1');
        r.style.setProperty('--navbar-color-1', '#d6639c');
        r.style.setProperty('--navbar-color-2', '#d6639c');
        r.style.setProperty('--card-color', '#ffedf6');
        r.style.setProperty('--primary-color', '#d6639c');
        r.style.setProperty('--secondary-color', '#d6639c');
        r.style.setProperty('--confirm-color', '#d6639c');
        r.style.setProperty('--cancel-color', '#c9a3b6');
               
    });
});

loadDetails();

function loadDetails() {
    $.get('test.txt', function(data) {
        var r = document.querySelector(':root');
        var cssVars = data.split('\n');
        
        for (var i = 0; i < cssVars.length; i++) {
            if (cssVars[i].trim() !== '') {
                var parts = cssVars[i].trim().split(',');
                var varName = parts[0].trim().replace("r.style.setProperty('", "").trim().replace("'", "");
                var varValue = parts[1].trim().replace("'", "").trim().replace("');", "");
                r.style.setProperty(varName, varValue);
            }
        }
    });
}