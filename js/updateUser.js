function changeValue(select_element, user_id, organization_id){
    
    console.log(select_element.id);
    console.log(select_element.value);
    console.log(user_id);
    console.log(organization_id);
    
    let formData = new FormData();
    
    formData.append('type', select_element.id);
    formData.append('value', select_element.value);
    formData.append('user_id', user_id);
    formData.append('organization_id', organization_id)
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'updateUserOrganization.php', true);
    xhr.onload = function() {
        if(this.responseText.trim() == "success"){
            
        } else{
            console.error(this.responseText);
        }
    };
    
    console.table(formData);
    xhr.send(formData);
}