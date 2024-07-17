function masterAddUser() {
    var overlay = '<div style="position:fixed; background-color: rgba(0, 0, 0, 0.5); height: 100vh; width: 100vw; z-index: 100; cursor: pointer;" id="masterAddUserHolder" onclick="masterCloseAddUser()">';
    overlay += '<div class="shadow" style="background-color: #f2f2f2; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 15px; width: 500px;">';
    overlay += '<form style="color:black !important; ">';
    overlay += '<label for="master_student_number">Student Number:</label><br>';
    overlay += '<input style="width: 100%;" type="number" id="master_student_number" name="master_student_number" require><br>';
    overlay += '<label for="master_name">Name:</label><br>';
    overlay += '<input style="width: 100%;" type="text" id="master_name" name="master_name" require><br>';
    overlay += '<label for="master_email">Email:</label><br>';
    overlay += '<input style="width: 100%;" type="email" id="master_email" name="master_email" require><br><br>';
    overlay += '<input style="width: 100%; color: green;" type="button" value="Submit" onclick="masterAddUserChecker()"><br>';
    overlay += '<label style="color: red;" id="masterWarningText"></label>';
    overlay += '</form>'; 
    overlay += '</div>';
    overlay += '</div>';
    
    const holder = document.querySelector('#masterAddUserHolderParent');
    holder.innerHTML = overlay;

    var inputFields = document.querySelectorAll('#masterAddUserHolder form');
    for (var i = 0; i < inputFields.length; i++) {
        inputFields[i].addEventListener('click', function(event) {
            event.stopPropagation();
        });
    }
    
}

function masterCloseAddUser(){
    const holder = document.querySelector('#masterAddUserHolderParent');
    holder.innerHTML = "";
}

function masterAddUserChecker(){

    let warningText = document.getElementById("masterWarningText");
    
    let master_student_number = document.getElementById("master_student_number").value;
    let master_name = document.getElementById("master_name").value;
    let master_email = document.getElementById("master_email").value;

    let formData = new FormData();
    formData.append('master_student_number', master_student_number);
    formData.append('master_name', master_name);
    formData.append('master_email', master_email);
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'masterAddUser.php', true);
    xhr.onload = function() {
        console.log(this.responseText);
        if(this.responseText.trim() == "success"){
            location.reload();
        } else{
            ChangeText(warningText, this.responseText);
        }
    };
    
    xhr.send(formData);
}

function ChangeText(textHolder, textString) {
    
    textHolder.innerHTML = textString;
}
    

