function updateTotalAmount() {
    var cartItems = document.querySelectorAll('.cart-item-banner');
    var totalAmount = 0;
    var totalQuantity = 0;
    
    cartItems.forEach((cartItem) => {
        var price = cartItem.querySelector('.cart-item-price').textContent.replace('P ', '');
        var quantity = cartItem.querySelector('.cart-item-quantity').textContent.replace('x', '');
        
        var itemAmount = parseFloat(price.replace(/,/g, '')) * parseInt(quantity);
        totalAmount += itemAmount;
        totalQuantity += parseInt(quantity);
    });
    
    //console.log(totalQuantity + ' ' + totalAmount);
   
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
                
                const cartItemName = document.createElement('div');
                cartItemName.className = 'cart-item-name';
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