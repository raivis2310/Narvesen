<?php

$jsonData = file_get_contents('Narvesen_Items.json');
$data = json_decode($jsonData, true);

foreach ($data['narvesen'] as $index => $item) {
    echo "Item number: " . ($index + 1) . "\n";
    echo "Name: " . $item['name'] . "\n";
    echo "Price Tag: " . $item['priceTag'] . "\n";
    echo "\n";
}
$wantOrNot = (string)readline("Do you want add something to your cart? input y or n: ");

if ($wantOrNot !== "y" && $wantOrNot !== "n") {
    echo "ERROR! You can input only y or n: \n";
}

function createCart(int $itemNumber, int $quantity): stdClass
{
    $product = new stdClass();
    $product->itemNumber = $itemNumber;
    $product->quantity = $quantity;
    return $product;
}

$sumOfItems = 0;

$cart = [];
$cart2 = [];
while ($wantOrNot == "y") {

    $selectedItems = (int)readline("Please choose an item. Input Item number: ");

    if ($selectedItems < 1 || $selectedItems > count($data['narvesen'])) {
        echo "ERROR! You can input only valid item numbers: \n";
        continue;
    }

    $howMuch = (int)readline("How much do you want: \n");

    echo "\n";

    $products = [
        createCart($selectedItems, $howMuch),
    ];

    foreach ($data['narvesen'] as $index => $item) {

        if ($selectedItems == $index + 1) {
            $sumOfItems += $item['priceTag'] * $howMuch;
        }
    }

    echo "The total amount of products: " . number_format($sumOfItems / 100, 2) . "\n";

    foreach ($products as $product) {
        $cart[] = $product->itemNumber;
    }
    foreach ($products as $product) {
        $cart2[] = $product->quantity;
    }

    echo "You add to cart this items: " . implode(", ", $cart) . "\n";
    echo "Of this quantity: " . implode(", ", $cart2) . "\n";
    echo "\n";

    $wantOrNot = (string)readline("Do you want add something to your cart? Input y or n: ");

    if ($wantOrNot !== "y" && $wantOrNot !== "n") {
        echo "ERROR! You can input only y or n: ";
    }
}

if ($wantOrNot == "n") {
    $buyersChoice = (string)readline("Do you want buy this items? Input y or n: ");
    echo "\n";
    if ($buyersChoice !== "y" && $buyersChoice !== "n") {
        echo "ERROR! You can input only y or n: ";
    }
    if ($buyersChoice === "n") {
        exit;
    }
    if ($buyersChoice === "y") {
        echo "You buy this items: " . implode(", ", $cart) . "\n";
        echo "Of this quantity: " . implode(", ", $cart2) . "\n";
    }
}

