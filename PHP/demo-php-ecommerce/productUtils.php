<?php

$products = [
    [
        "name" => "white shoe",
        "picture" =>  "https://i.ibb.co/bQ5t8bR/product-5.jpg",
        "amount" => 10000,
    ],
    [
        "name" => "white shoe",
        "picture" =>  "https://i.ibb.co/bQ5t8bR/product-5.jpg",
        "amount" => 95000,
    ],
    [
        "name" => "white shoe",
        "picture" =>  "https://i.ibb.co/bQ5t8bR/product-5.jpg",
        "amount" => 32000,
    ],
    [
        "name" => "white shoe",
        "picture" =>  "https://i.ibb.co/bQ5t8bR/product-5.jpg",
        "amount" => 5,
    ],
];


function showProduct($product)
{
    $productName = $product["name"];
    $amount = $product["amount"];
    $pictureUrl = $product["picture"];
    $description = $product["description"];

    echo "<div class=\"col-4\">
        <img src=\"$pictureUrl\" alt=\"\" />
        <h4>$productName</h4>
        <div class=\"rating\">
            <i class=\"fas fa-star\"></i>
            <i class=\"fas fa-star\"></i>
            <i class=\"fas fa-star\"></i>
            <i class=\"fas fa-star\"></i>
            <i class=\"far fa-star\"></i>
        </div>
        <p>$amount Fcfa</p>
        <button onclick=\"showCheckout('$productName','$amount','$pictureUrl','$description')\">Payer maintenant</button>
    </div>";
}
