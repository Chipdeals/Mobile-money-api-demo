<html lang="en">

<?php
include_once('./productUtils.php');

?>



<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Php E-commerce</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/checkout.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />

</head>

<body>
    <div class="container">
        <div class="navbar">
            <div class="logo">
            </div>
            <nav>
                <ul id="MenuItems">
                </ul>
            </nav>
            <a href="#"><img src="https://i.ibb.co/PNjjx3y/cart.png" alt="" width="30px" height="30px" /></a>
        </div>
    </div>

    <div class="small-container">
        <div class="row row-2">
            <h2>All Products</h2>
        </div>
        <div class="row">

            <?php

            foreach ($products as $key => $product) {
                showProduct($product);
            }

            ?>
        </div>

        <div class="page-btn">
            <span>1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
            <span>&#8594;</span>
        </div>
    </div>

    <div class="checkoutModal" id="checkoutModal" style="display:none">
        <div style="position: fixed; top:0; left:0; width:100%;height:100%" onclick="closeCheckout()"></div>
        <section class="product">
            <div class="product__details">
                <h1 class="product__details-heading" id="productName">DJI Phantom</h1>
                <span class="" id="productDescription">Here can be a </span>

                <div style="display: flex; padding: 30px 0px;">
                    <img class="" id="pictureUrl" style="width:80%; border-radius: 15px; margin:auto" src="https://image.ibb.co/nFfzRK/phantom_3_standard.png" alt="">
                </div>

                <div class="product__details-basket">
                    <div class="product__details-basket-item">
                        <!-- <span class="product__details-basket-heading">Quantity</span>
                        <div class="product__details-basket-quantity-wrapper">
                            <select class="product__details-basket-quantity" name="quantity" id="productQuantity">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div> -->
                    </div>

                    <div class="product__details-basket-item">
                        <span class="product__details-basket-heading product__details-basket-heading--right">Montant</span>
                        <span class="product__details-basket-price" id="productAmount">00</span>
                    </div>
                </div>
            </div>

            <form class="card-details" action="" data-form>
                <fieldset class="card-details__fieldset">
                    <span class="card-details__heading" aria-hidden="true">Téléphone</span>
                    <div class="card-details__holder">
                        <input class="card-details__holder-input" type="text" id="phoneNumberInput" data-input>
                    </div>
                </fieldset>
                <fieldset class="card-details__fieldset">
                    <span class="card-details__heading" aria-hidden="true">Prénom</span>
                    <div class="card-details__holder">
                        <label class="card-details__holder-label" for="firstName">Prénom</label>
                        <input class="card-details__holder-input" type="text" id="firstNameInput" data-input>
                    </div>
                </fieldset>
                <fieldset class="card-details__fieldset">
                    <span class="card-details__heading" aria-hidden="true">Nom</span>
                    <div class="card-details__holder">
                        <input class="card-details__holder-input" type="text" id="lastNameInput" data-input>
                    </div>
                </fieldset>
                <fieldset class="card-details__fieldset">
                    <span class="card-details__heading" aria-hidden="true" id="paymentStatus"></span>
                    
                </fieldset>

                <button class="card-details__submit" type="button" data-submit-button onclick="checkout()">Payer</button>
            </form>
        </section>

    </div>

    <script src="script.js"></script>
</body>

</html>