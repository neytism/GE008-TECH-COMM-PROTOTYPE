
function updateTotalAmount() {
    var totalAmount = 0;
    var totalQuantity = 0;
    var cartItems = document.querySelectorAll('.cart-item-banner');

    cartItems.forEach((cartItem) => {
        var price = cartItem.querySelector('.cart-item-price').textContent.replace('P ', '');
        var quantity = cartItem.querySelector('.cart-item-quantity').textContent.replace('x', '');
        
        var itemAmount = parseFloat(price.replace(/,/g, '')) * parseInt(quantity);
        totalAmount += itemAmount;
        totalQuantity += parseInt(quantity);
    });
    
    //console.log(totalQuantity + ' ' + totalAmount);

    TOTALFINALAMOUNT = totalAmount;
   
    if (totalQuantity > 0) {
        document.querySelector('.total-amount').textContent = 'P ' + totalAmount.toLocaleString();
    } else {
        document.querySelector('.total-amount').textContent = 'No items in cart.';
    }
}

updateTotalAmount();

function addToCart() {
    const productCards = document.querySelectorAll('.product-card:not(.invisible)');
    
    productCards.forEach((card) => {
        const addToCartButton = card.querySelector('.card-add-to-cart');
        addToCartButton.addEventListener('click', () => {
            var itemID = card.getAttribute("itemID");
            var itemName = card.querySelector('.product-name').textContent;
            var itemPrice = card.querySelector('.product-price').textContent;
        
            console.log(itemID + ' ' + itemName + ' ' + itemPrice);
            const cartItems = document.querySelector('.cart-items');
            const cartItem = cartItems.querySelector(`.cart-item-banner[itemID="${itemID}"]`);
            
            var element = document.getElementById("notification");
            element.classList.remove("fadeInOut");
            void element.offsetWidth;
            element.classList.add("fadeInOut");

            if (cartItem) {
                const cartItemQuantity = cartItem.querySelector('.cart-item-quantity');
                const currentQuantity = parseInt(cartItemQuantity.textContent.replace('x', ''));
                cartItemQuantity.textContent = `${currentQuantity + 1}x`;

            } else {
                const cartItemBanner = document.createElement('div');
                cartItemBanner.className = 'cart-item-banner';
                cartItemBanner.classList.add('unselectable');
                cartItemBanner.setAttribute("itemID", itemID);
                
                const cartItemBase = document.createElement('div');
                cartItemBase.className = 'cart-item-banner-base';
                
                const cartItemLeft = document.createElement('div');
                cartItemLeft.className = 'cart-item-banner-base-left';

                const cartCaretRight = document.createElement('i');
                cartCaretRight.className = 'bi bi-caret-right';
                cartCaretRight.style.color = 'rgba(0, 0, 0, 0.39)';
                
                const cartItemQuantity = document.createElement('div');
                cartItemQuantity.className = 'cart-item-quantity';
                cartItemQuantity.textContent = '1x';
                cartItemQuantity.id = 'cart-quantity';
                
                const cartItemName = document.createElement('div');
                cartItemName.className = 'cart-item-name';
                cartItemName.id = 'cart-name';
                cartItemName.textContent = itemName.toLocaleUpperCase();
                
                cartItemLeft.appendChild(cartCaretRight);
                cartItemLeft.appendChild(cartItemQuantity);
                cartItemLeft.appendChild(cartItemName);
                
                
                cartItemBase.appendChild(cartItemLeft);
                
                const cartItemRight = document.createElement('div');
                cartItemRight.className = 'cart-item-banner-base-right';

                const cartX = document.createElement('i');
                cartX.className = 'bi bi-x-circle-fill';
                cartX.style.color = 'rgba(0, 0, 0, 0.39)';
                cartX.onclick = function() { removeItem(itemID); };
                
                const cartItemPrice = document.createElement('div');
                cartItemPrice.className = 'cart-item-price';
                cartItemPrice.id = 'cart-price';
                cartItemPrice.textContent = itemPrice.toLocaleString();
                
                cartItemRight.appendChild(cartItemPrice);
                cartItemRight.appendChild(cartX);
                
                cartItemBase.appendChild(cartItemRight);
                
                cartItemBanner.appendChild(cartItemBase);
                
                const cartItemDrop = document.createElement('div');
                cartItemDrop.className = 'cart-item-banner-drop';
                cartItemDrop.classList.add('hide');
                
                cartItems.appendChild(cartItemBanner);

                
            }

            updateTotalAmount();
        });
    });
}

addToCart();

function removeItem(itemID) {
    const cartItems = document.querySelector('.cart-items');
    const cartItem = cartItems.querySelector(`.cart-item-banner[itemID="${itemID}"]`);
    
    const cartItemQuantity = cartItem.querySelector('.cart-item-quantity');
    const currentQuantity = parseInt(cartItemQuantity.textContent.replace('x', ''));
    cartItemQuantity.textContent = `${currentQuantity - 1}x`;
    
    if(currentQuantity === 1) {
        cartItem.remove();
        console.log(currentQuantity);
    } else {
        cartItemQuantity.textContent = `${currentQuantity - 1}x`;
    }
    
    updateTotalAmount();
}

$(document).ready(function() {
    
    $("#search-user").on("keyup", function() {
        var scanIdElement = $(document.getElementById('scan-id'));
        var searchIdElement = $(document.getElementById('search-id'));
        var searchValue = $(document.getElementById('search-user'));
        
        var search = $(this).val().toLowerCase();
        
        if(search !== ''){
            searchIdElement.toggle(true);
            scanIdElement.toggle(false);
        } else{
            searchIdElement.toggle(false);
            scanIdElement.toggle(true);
        }
    
    });
    
    
});

const searchButton = document.querySelector('#search-id');

searchButton.addEventListener('click', function() {
    
    let student_id = document.getElementById("search-user").value;
    let email_holder = document.getElementById("email-holder");

    let formData = new FormData();

    if (student_id) {
        formData.append('user_to_find', student_id)
    }
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'findUser.php', true);
    xhr.onload = function() {
        if(this.responseText.trim() == "User does not exist."){
            
            alert(this.responseText);
            ChangeText(email_holder, this.responseText);
            
        } else{
            ChangeText(email_holder, this.responseText);
        }
    };
    
    xhr.send(formData);

});

function ChangeText(textHolder, textString) {
    
    textHolder.innerHTML = textString;
}

function ConfirmCheckOut() {
    $searchUser = document.getElementById("search-user").value;
  
    if ($searchUser == '') {
      alert("No Customer");
      return;
    }
  
    $email = document.getElementById("email-holder").textContent;
  
    if ($email == '' || $email == "User does not exist.") {
      alert("Invalid email.");
      return;
    }
  
    $value = document.getElementById("total-amount").textContent;
  
    if ($value == 'No items in cart.') {
      alert("No items in cart.");
      return;
    }
  
    $method = document.getElementById("pMethod").value;
    $items = [];
    
    $(".cart-item-banner").each(function() {
      var cart = $(this);
    
      var quantity = cart.find("#cart-quantity").text();
      var item_id = cart.attr("itemID");
      var name = cart.find("#cart-name").text();
      var price = cart.find("#cart-price").text();
    
      $items.push({
        quantity: quantity,
        item_id: item_id,
        name: name.trim(),
        price: price
      });
    });
    
    $student_id = document.getElementById("search-user").value;
  
    
  
    let formData = new FormData();
    
    formData.append('email', $email)
    formData.append('student_id', $student_id)
    formData.append('items', JSON.stringify($items));
    formData.append('total_amount', $value)
    formData.append('payment_method', $method)
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'emailer.php', true);
    xhr.onload = function() {
        $elem = document.getElementById("receipt-parent");
        $elem.innerHTML = this.responseText;
    };
    
    xhr.send(formData);

  
  }
  
function ClearInput(){
    $elem = document.getElementById("cart-item-holder");
    $elem.innerHTML = "";
    
    $elem = document.getElementById("total-amount");
    $elem.innerHTML = "No items in cart.";

    $elem = document.getElementById("pMethod");
    $elem.value = "Cash";

    $elem = document.getElementById("email-holder");
    $elem.innerHTML = "";
    
    $elem = document.getElementById("search-user");
    $elem.value = "";
    

    $elem = $(document.getElementById('scan-id'));
    $elem.toggle(true);

    $elem = $(document.getElementById('search-id'));
    $elem.toggle(false);
}

function CloseReceipt(){
    ClearInput();
    $receiptDisplay = document.getElementById("receipt-holder");
    $receiptDisplay.remove();
    
}
