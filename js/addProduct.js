//add product
function checkAddProd(event, phpFile, itemID) {
    event.preventDefault();

    let warningText = document.getElementById("warningText");
    
    let item_name = document.getElementById("inputitem_name").value;
    let itemImage = document.getElementById("inputItemImage").files[0];
    let itemPrice = document.getElementById("inputItemPrice").value;
    let itemStock = document.getElementById("inputItemStock").value;
    let itemCategory = document.getElementById("inputCategory").value;
    
    let formData = new FormData();
    formData.append('item_name', item_name);
    formData.append('itemImage', itemImage);
    formData.append('itemPrice', itemPrice);
    formData.append('itemStock', itemStock);
    formData.append('itemCategory', itemCategory);

    if (itemID) {
        formData.append('itemID', itemID)
    }
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', phpFile, true);
    xhr.onload = function() {
        console.log(this.responseText);
        if(this.responseText.trim() == "success"){
            
            ChangeText(warningText, this.responseText);
            setTimeout(function(){
                document.location.href = 'inventory.php';
           },1000); 
        } else{
            ChangeText(warningText, this.responseText);
        }
    };
    
    xhr.send(formData);
}

function ChangeText(textHolder, textString) {
    
    textHolder.style.display = "block";
    textHolder.innerHTML = textString;
}

document.getElementById('inputItemImage').addEventListener('change', function(event) {
    const input = event.target;
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('displayImage').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});