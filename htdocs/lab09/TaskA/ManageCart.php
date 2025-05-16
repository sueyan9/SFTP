<?php

session_start(); // start a session
ini_set('display_errors', 0);
error_reporting(0);

header('Content-Type: text/xml');


$newitem = $_GET["book"]?? null; // book name
$action = $_GET["action"]?? null; // add or remove?
$ISBN = $_GET["isbn"]?? ""; // book ISBN
$price = $_GET["price"]?? ""; // book price

if (!$newitem || !$action) {
    echo "<error>Missing required parameters.</error>";
    exit;
}
if (array_key_exists("Cart", $_SESSION)) // the “cart” already exists
{
    $myCart = $_SESSION["Cart"]; // assign the session variable to $myCart

    if ($action == "Add") {
        if (!isset($myCart[$newitem])) {
            $myCart[$newitem] = array(
                'isbn' => $ISBN,
                'price' => $price,
                'quantity' => 1
            );
        } else {
            $myCart[$newitem]['quantity']++;
        }
    } else { // Remove
        if (isset($myCart[$newitem])) {
            $myCart[$newitem]["quantity"] -= 1;
            if ($myCart[$newitem]["quantity"] <= 0) {
                unset($myCart[$newitem]);
            }
        }
    }
} else { // first time adding any book
    $myCart = array();
    $myCart[$newitem] = array(
        "isbn" => $ISBN,
        "price" => $price,
        "quantity" => 1
    );
}

// save back to session
$_SESSION["Cart"] = $myCart;
echo (toXml($myCart));
exit;
// function to convert to XML
function toXml($aCart)
{
    $doc = new DomDocument('1.0', 'UTF-8');
    $cart = $doc->createElement('cart');
    $doc->appendChild($cart);
    $total = 0;

    foreach ($aCart as $Item => $ItemInfo)
    {
        $book = $doc->createElement('book');
        $cart->appendChild($book);

        $title = $doc->createElement('title');
        $title->appendChild($doc->createTextNode((string)($Item ?? "")));
        $book->appendChild($title);

        $isbn = $doc->createElement('isbn');
        $isbn->appendChild($doc->createTextNode((string)($ItemInfo["isbn"] ?? "")));
        $book->appendChild($isbn);

        $price = $doc->createElement('price');
        $price->appendChild($doc->createTextNode((string)($ItemInfo["price"] ?? "0")));
        $book->appendChild($price);

        $quantity = $doc->createElement('quantity');
        $quantity->appendChild($doc->createTextNode((string)($ItemInfo["quantity"] ?? 0)));
        $book->appendChild($quantity);

        $total += (float)($ItemInfo["price"] ?? 0) * (int)($ItemInfo["quantity"] ?? 0);
    }

    $totalElement = $doc->createElement('total');
    $totalValue = $doc->createTextNode(number_format($total, 1));
    $totalElement->appendChild($totalValue);
    $cart->appendChild($totalElement);

    return $doc->saveXML();
}

?>
