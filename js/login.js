//for Login
function checkLogin(event) {
    event.preventDefault();
  
    let warningText = document.getElementById("warningTextLogIn");
    
    let uname = document.getElementById("inputUserName").value;
    let pword = document.getElementById("inputPassword").value;
  
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'loginAction.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        
        if(this.responseText == "success"){

            ChangeText(warningText, "Redirecting you to home page...", "rgba(37, 255, 37, 0.13)");
            setTimeout(function(){
                document.location.href = '../index.php';
           }, 1000); 
        
        } else{
            ChangeText(warningText, this.responseText);
        }
    };

    xhr.send('uname=' + uname + '&pword=' + pword);
  
  };

  function ChangeText(textHolder, textString) {
    
    textHolder.style.display = "block";
    textHolder.innerHTML = textString;
}