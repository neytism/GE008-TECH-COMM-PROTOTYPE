<?php
header("Content-type: text/css");

require '../config.php';

if (isset($_SESSION['user_id'])) { //if logged in
        
    $sql = "SELECT active_organization, use_template FROM users WHERE id = '$_SESSION[user_id]'";

    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        
        $organization_id = $row["active_organization"];
        $use_template = $row["use_template"];
    }

    if ($use_template == "true"){
        $sql = "SELECT val FROM settings WHERE id = '0' AND organization_id = '$organization_id'";
    }else{
        $sql = "SELECT val FROM settings WHERE id = '$_SESSION[user_id]'";
    }

    if ($organization_id == 1){
        if($use_template == "true") {
            $sql = "SELECT val FROM settings WHERE id = '-1'";
        }else{
            $sql = "SELECT val FROM settings WHERE id = '$_SESSION[user_id]'";
        }
    }


} else{
    $sql = "SELECT val FROM settings WHERE id = '-1'"; //if page like login loads
}

$result = $conn->query($sql);
    
if ($result->num_rows > 0) { // if there is no settings, load default
    
    $row = $result->fetch_assoc();
    $values = explode('|', $row['val']);
    
    $settings = array();
    foreach ($values as $pair) {
        list($key, $value) = explode(':', $pair, 2);
        $settings[trim($key)] = trim($value);
    }
} else{
    
    $sql = "SELECT val FROM settings WHERE id = '-1'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $values = explode('|', $row['val']);
    
    $settings = array();
    foreach ($values as $pair) {
        list($key, $value) = explode(':', $pair, 2);
        $settings[trim($key)] = trim($value);
    }
}



//echo $settings['--navbar-color-1'];

?>
:root {
    --navbar-hor-padding: 15px;
    --navbar-vert-padding: 10px;
    --navbar-height: 53px;
    --product-card-height: 300px;
    --panel-spacing: 15px;
    
    
    --navbar-color-1: <?php echo $settings['--navbar-color-1'];?>;
    --navbar-color-2: <?php echo $settings['--navbar-color-2'];?>;
    --navbar-text-color: <?php echo $settings['--navbar-text-color'];?>;
    
    --background-color-1: <?php echo $settings['--background-color-1'];?>;
    --background-color-2: <?php echo $settings['--background-color-2'];?>;
    --background-image: url("../assets/images/ciit-wallpaper.jpg");
    --background-angle: 0deg;
    
    --primary-color: <?php echo $settings['--primary-color'];?>;
    --button-accent-color: <?php echo $settings['--button-accent-color'];?>;
    
    --card-color: <?php echo $settings['--card-color'];?>;
    --card-text-color: <?php echo $settings['--card-text-color'];?>;
    --card-color-darker: color-mix(in srgb, var(--card-color) 95%, var(--background-color-1) 5% );
    
    --cancel-color: <?php echo $settings['--cancel-color'];?>;
    --confirm-color: <?php echo $settings['--confirm-color'];?>;
    
    --right-panel-display: flex;
    --center-panel-display: inline;
    --search-bar-display: inline;
}

@import url('https://unpkg.com/css.gg@2.0.0/icons/css/home.css');

@font-face {
    font-family: Loew-Bold;
    src: url("../assets/fonts/Loew-Bold.otf") format(opentype);
}

@font-face {
    font-family: Loew-ExtraBold;
    src: url("../assets/fonts/Loew-ExtraBold.otf") format(opentype);
}

@font-face {
    font-family: Loew-Medium;
    src: url("../assets/fonts/Loew-Medium.otf") format(opentype);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;

}



.invisible {
    visibility: hidden;
}

.hide {
    display: none !important;
}

.unselectable {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.shadow{
    box-shadow: 0px 0px 18px rgba(0, 0, 0, 0.082);
}

html {
    scroll-behavior: smooth;
  }

body {
    font-family: Loew-Bold ;
    background:linear-gradient(var(--background-angle), var(--background-color-1), var(--background-color-2)), var(--background-image) ;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    background-color: var(--background-color);
    overflow: hidden;
}

a {
    text-decoration: none !important;
}

.test-button{
    position: absolute;
    z-index: 10;
    bottom: 0;
    height: 50px;
    width: 100px;
    margin: 20px;
}

a:visited,
a:link {
    color: inherit;
}

li {
    list-style: none;
}

/* NAVBAR STYLING STARTS */
.navbar {
    letter-spacing: 2px;
    display: flex;
    align-items: center;
    justify-content: space-between ;
    height: var(--navbar-height);
    padding: var(--navbar-vert-padding) var(--navbar-hor-padding);
    background: linear-gradient(to right, var(--navbar-color-1) , var(--navbar-color-2));
    color: var(--navbar-text-color);
    position: fixed ;
    top: 0;
    z-index: 3;
    width: 100%;
}

.nav-right{
    display: flex;
    flex-direction: column;
    width: 50%;
}

.nav-left{
    display: flex;
    flex-direction: column;
    width: 50%;
    justify-content: space-between;
}

.nav-left > .menu{
    display: flex;
    justify-content: flex-start;

}

.nav-right > .menu{
    text-align: right;
    justify-content: flex-end;
}

.logo{
    display: flex; 
    align-items: center; 
    margin-bottom: 2px; 
    width: fit-content;
    white-space: nowrap;
    max-width: 50%;
}


.search-bar{
    width: 60%;
    position: relative;
}

.search-bar input{
    width: 100%;
    background-color:  color-mix(in srgb, white 8%, transparent);
    border: none;
    border-radius: 10px;
    height: 35px;
    font-family: Loew-Medium !important;
    letter-spacing: 0.3px;
    padding: 0 40px 0 15px;
    color: var(--navbar-text-color);
}

.search-bar i {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    margin-left: -30px;
}

.search-empty{
    color: var(--navbar-text-color);
}

.search-bar input::placeholder {
    color: color-mix(in srgb, var(--navbar-text-color) 50%, transparent);;
}

.menu {
    display: flex;
    gap: 1em;
    font-size: 18px;
}

<!-- .menu li:hover {
    background-color: rgb(0, 0, 0, 0.1);
    border-radius: 5px;
    transition: 0.3s ease;
} -->

.menu li {
    padding: 5px 14px;
    transition: 0.3s ease;
}

.seller{
    font-family: Loew-Medium ;
}

.main-interface{
    display: flex; 
    flex-direction: row; 
    height: 100svh;
}

.with-navbar{
    padding-top: var(--navbar-height);
}

.left-panel{
    width: 175px; 
    min-width: 175px;
    padding: calc(var(--panel-spacing)*2) var(--panel-spacing) calc(var(--panel-spacing)*2) calc(var(--panel-spacing)*2);
    justify-content: flex-start;
}

.left-panel-content{
    color: var(--card-text-color);
    display: flex;
    flex-direction: column; 
    align-items: center;
    justify-content: flex-start;
    background-color: var(--card-color)  ; 
    border-radius: 10px;
    height: 100%;
    gap: 15px;
}

.left-nav-upper{
    height: 100%;
    display: flex;
    flex-direction: column; 
    align-items: center;
    justify-content: flex-start;
    gap: 15px;
}

.left-nav-upper:first-child{
    margin-top: 20px;
}


.left-nav-lower{
    display: flex;
    flex-direction: column; 
    align-items: center;
    justify-content: flex-end;
    height: 100%;
}

.left-nav-lower:last-child{
    margin-bottom: 20px;
}

.left-nav-icon{
    font-family: Loew-Medium !important;
    font-size: 10px;
    width: 90px;
    height: 90px;
    border-radius: 10px;
    background-color: color-mix(in srgb, var(--button-accent-color) 10%, transparent);
    text-align: center;
    line-height:  2em;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

.left-nav-icon i{
    font-size: 40px;
}

.mobile-nav{
    color: var(--card-text-color);
    position: fixed;
    overflow-x: auto;
    width: 90%;
    background-color: var(--card-color)  ; 
    margin-top: var(--panel-spacing);
    margin-bottom: var(--panel-spacing);
    height: 100px;
    border-radius: 10px;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    gap: 15px;
    padding-left: 15px;
    padding-right: 15px;
    bottom: 0;
    z-index: 10;
    left: 50%;
    transform: translateX(-50%); 
}


.cart-icon{
    display: none;
}

.center-panel{
    min-width: 10%;
    justify-content: center;
    padding: calc(var(--panel-spacing)*2) var(--panel-spacing) 0px var(--panel-spacing);
}

.center-panel-content{
    display: flex;
    flex-direction: column; 
    height: 100%;
}

.category-panel{
    overflow-x: auto;
    width: 100%;
    background-color: var(--card-color)  ; 
    margin-bottom: calc(var(--panel-spacing)*2);
    height: 65px;
    border-radius: 10px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    gap: 30px;
    padding-left: 15px;
    color: var(--card-text-color);
   
}

.category-button:hover{
    color: var(--button-accent-color);
    transition: 0.3s ease;
}

.category-button{
    height: 50%;
    padding: 3px 15px;
    border-radius: 7.5px;
    white-space: nowrap;
    transition: 0.3s ease;
    cursor: pointer;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
}

.selected{
    background-color: color-mix(in srgb, var(--button-accent-color) 25%, transparent); 
    border-width: 1.5px;
    border-color: var(--button-accent-color);
    border-style: solid;
}

.button:hover{
    border-width: 1.5px;
    border-color: var(--button-accent-color);
    border-style: solid;
}

.products-panel{
    overflow-y: auto;
    height: 100%;
    display: flex;
    gap: calc(var(--panel-spacing)*2);
    flex-wrap: wrap;
    flex-direction: row;
    align-content: flex-start;
    justify-content: flex-start;
}

.products-panel::-webkit-scrollbar ,.category-panel::-webkit-scrollbar, .mobile-nav::-webkit-scrollbar, .login-panel::-webkit-scrollbar {
    display: none;

}

.product-card{
    position: relative; 
    height: var(--product-card-height);
    width: calc(var(--product-card-height) * 0.65);
    background-color: var(--card-color);
    border-radius: 10px;
    flex-grow: 1;
    padding: 15px;
    display: flex;
    flex-direction: column;
    transition: 0.3s ease;
    color: var(--card-text-color);
    box-shadow: 0 0 0 0 var(--button-accent-color) inset;
}

.product-card:hover{
    box-shadow: 0 0 0 2px var(--button-accent-color) inset;
    transition: 0.3s ease;
}

.product-card .product-icon {
    height: 75%;
    border-radius: 10px 10px 0 0;
    justify-content: flex-start;
    align-items: center;
}

.product-icon img{
    width: 100%;
    object-fit: contain;
    height: 100%;
}

.product-card .product-name {
    font-family: Loew-Medium !important;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height:  1.1em;
    
}

.product-card-desc{
    flex-grow: 1;
    justify-content: flex-end;
    display: flex;
    flex-direction: column; 

}

.product-card .product-price {
    font-family: Loew-ExtraBold !important;
    margin-top: 7px;
    font-size: 1.1em;
}

.card-add-to-cart{
    position: absolute; 
    color: var(--card-text-color);
    font-size: 1.5em;
    top: 5px; 
    left: 10px; 
    cursor: pointer;
    opacity: 0.5;
}

.settings-panel-back{
    overflow-x: auto;
    width: 100%;
    background-color: var(--card-color)  ; 
    margin-bottom: calc(var(--panel-spacing)*2);
    height: 100%;
    border-radius: 10px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    gap: 30px;
    padding-left: 15px;
   
}

.settings-panel{
    overflow-y: auto;
    width: 100%;
    height: 100%;
    display: flex;
    gap: calc(var(--panel-spacing)*2);
    flex-wrap: wrap;
    flex-direction: row;
    align-content: flex-start;
    justify-content: flex-start;
    padding-bottom: 150px;
}

.settings-panel::-webkit-scrollbar{
    display: none;
}

.right-panel{
    padding: 0px calc(var(--panel-spacing)*2) 0px var(--panel-spacing);
    width: 30%; 
    max-width: 30%;
    min-width: 500px;
    display: flex;
    justify-content: flex-end;
    align-items: flex-end;
}


.right-panel-content{
    display: flex;
    flex-direction: column; 
    height: 100%;
    width: 100%;
}

.cart-panel{
    background-color: var(--card-color)  ; 
    margin-bottom: 15px;
    border-radius: 0px 0px 20px 20px;
    display: flex;
    flex-direction: column; 
    align-items: center;
    justify-content: flex-start;
    height: 70%;
    width: 100%;
    padding: 0 15px;
}

.cart-header{
    height: 100px;
    width: 100%;
    display: flex;
    flex-direction: row;
    align-content: stretch;
    padding-top: 30px;
    gap: 15px;
}

.customer-name-input {
    text-transform: uppercase;
    background-color: color-mix(in srgb, var(--button-accent-color) 10%, transparent);
    color: var(--card-text-color);
    border: none;
    border-radius: 10px;
    height: 45px;
    font-family: Loew-Medium !important;
    letter-spacing: 0.3px;
    padding: 0 40px 0 15px;
    width: 75%;
}

.customer-name-input::placeholder {
    text-transform: uppercase;
    color: color-mix(in srgb, var(--card-text-color) 50%, transparent);
}

.scan-id{
    font-family: Loew-Medium !important;
    font-size: 13px;
    height: 45px;
    border-radius: 10px;
    color: white;
    text-align: center;
    line-height:  2em;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 25%;
}

.cart-items{
    color: var(--card-text-color);
    width: 100%;
    flex-direction: column; 
    justify-content: flex-start;
    overflow-y: auto;
    gap: 15px;
}

.cart-item-banner{
    background-color: color-mix(in srgb, var(--button-accent-color) 10%, transparent);
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 15px;
}

.cart-item-banner:first-child{
    color: var(--card-text-color);
    margin-top: 20px;
}

.cart-item-banner-base{
    width: 100%;
    display: flex;
    flex-direction: row;
    align-content: stretch;
    gap: 10px;
}

.cart-item-banner-base-left{
    font-family: Loew-Medium !important;
    width: 100%;
    display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: flex-start;
    gap: 15px;
}

.cart-item-name{
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.cart-item-banner-base-right{
    font-family: Loew-ExtraBold !important;
    width: 50%;
    display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: flex-end;
    gap: 15px;
}



.details-panel{
    color: var(--card-text-color);
    background-color: var(--card-color)  ; 
    margin-top: 15px;
    height: 30%;
    border-radius: 20px 20px 0px 0px;
    display: flex;
    flex-direction: column; 
    align-items: center;
    justify-content: flex-start;
    padding: 15px;
}

.details-panel-upper{
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column; 
    align-items: center;
    justify-content: flex-start;
    gap: 15px;
}

.details-panel-lower{
    width: 100%;
    display: flex;
    flex-direction: column; 
    align-items: center;
    justify-content: flex-end;
    height: 100%;
}

.confirm-group{
    width: 100%;
    display: flex;
    flex-direction: row;
    align-content: stretch;
    gap: 15px;
}

.confirm-button{
    font-family: Loew-Medium !important;
    font-size: 13px;
    padding: 11.5px 0;
    border-radius: 10px;
    color: white;
    text-align: center;
    line-height:  2em;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    flex-grow: 1;
}

.confirm{
    background-color: var(--confirm-color);
}

.cancel{
    background-color: var(--cancel-color);
}

.danger{
    background-color: color-mix(in srgb, var(--cancel-color) 50%, var(--confirm-color) 50%);;
    
}

.transaction-details-banner{
    width: 100%;
    padding: 8px 10px;
    
}

.transaction-details-banner-base{
    width: 100%;
    display: flex;
    flex-direction: row;
    align-content: stretch;
}

.transaction-details-banner-base-left{
    font-family: Loew-Medium !important;
    width: 100%;
    display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: flex-start;
    gap: 15px;
}

.transaction-details-name{
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.transaction-details-banner-base-right{
    font-family: Loew-ExtraBold !important;
    width: 100%;
    display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: flex-end;
    gap: 15px;
}


.login-panel{
    overflow-x: auto;
    width: 100%;
    max-width: 30%;
    background-color: var(--card-color); 
    max-height: 95vh;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 15px;
    
    
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.login-panel input, .login-panel select, .settings select{
    color: var(--card-text-color)
}


.notification{
    background-color: var(--confirm-color); 
    border-radius: 10px;
    color: white; 
    position: fixed; 
    bottom: 3%; 
    left: 50%; 
    transform: translateX(-50%); 
    z-index: 100; 
    opacity: 0;
    pointer-events: none;
}

.fadeInOut{
    animation-name: notification;
    animation-duration: 1s;
    animation-timing-function: ease-in-out;
}

.color-picker-container {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  
#picker {
    display: flex;
    justify-content: center;
    align-items: center;
  }

.pickr button{
    outline-style:solid;
    outline-color: var(--button-accent-color);
    outline-width: thin;
}

.text-outline{
    <!-- filter: drop-shadow(white 0 0 5px); -->
}

.add-new-product{
    margin: 25px; 
    border-radius: 35px; 
    text-align: center; 
    position: fixed; 
    bottom: 0; 
    right: 0; 
    font-size: 2rem; 
    color: white; 
    background-color: var(--confirm-color); 
    height: 70px; 
    width: 70px; 
    cursor: pointer;
}
  


@keyframes notification {
    0%{
        opacity: 0;
    }

    10% {
        opacity: 1;
    }

    90% {
        opacity: 1;
    }

    100% {
        opacity: 0;
    }
}


@media (min-width: 825px) {

    .center-panel{
        display: inline !important;
    }
    
    .search-bar{
        display: inline !important;
    }

    .right-panel {
        display: flex !important;
    }
    
    .mobile-nav{
        display: none;
    }
}


/* MEDIA QUERIES */
@media (max-width: 824px) {
    
    .right-panel {
        display: none;
        width: 100% ; 
        max-width: 100%;
        min-width: 0%;
        padding: 0px calc(var(--panel-spacing)*2) 115px calc(var(--panel-spacing)*2);
    }
    
    .center-panel{
        padding: calc(var(--panel-spacing)*2) calc(var(--panel-spacing)*2) 0px calc(var(--panel-spacing)*2);
    }

    .details-panel{
        max-height: 210px;
        min-height: 210px;
        padding-bottom: 150px;
    }
    
    .seller {
        display: none;
    }

    .search-bar input {
        width: 100%;
    }
    
    .nav-right{
        flex-direction: column;
        width: 0%;
    }
    
    .nav-left{
        flex-direction: column;
        width: 100%;
    }
    
    .cart-panel{
        max-height: 65%
    }

    .details-panel-upper{
        gap: 0px;
    }
        
    .search-bar{
        width: 100%;
    }
    
    .left-panel{
       display: none;
    }
    
    .mobile-nav{
        display: flex;
    }

    .left-nav-icon{
        font-family: Loew-Medium !important;
        font-size: 10px;
        width: 60px;
        height: 60px;
        min-width: 60px;
        min-height: 60px;
        font-size: 0px;
    }

    .left-nav-upper:first-child{
        margin-top: 15px;
    }
    
    .left-nav-lower:last-child{
        margin-bottom: 15px;
    }
    
    .left-nav-icon i{
        font-size: 30px;
    }
    
    .cart-icon{
        display: flex;
    }
    
    .cart-item-banner, .details-panel{
        font-size: smaller;
    }

    .login-panel{
        max-width: 90%;
       
    }

    .add-new-product{
    margin: 130px 25px;
    }

    

  
    
}


