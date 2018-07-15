<?php

// # Create Payment using PayPal as payment method
// This sample code demonstrates how you can process a 
// PayPal Account based Payment.
// API used: /v1/payments/payment

//require __DIR__ . '/../bootstrap.php';
require $_SERVER['DOCUMENT_ROOT'] . "/paypaldemo/paypal/rest-api-sdk-php/sample/bootstrap.php";
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;


if (!isset($_POST['submit'])) {
    $items = array(
        'Starter' => 1,
        'Begginer'=>2,
        'Master'=>3);

    


?>
<form method="post" name="zinteo_coupons" id="zinteo_coupons" action="">
    <label>Choose your coupons package</label>
        <select id="" name="price">
            <option value="1">Starter - 1 USD</option>
            <option value="2">Begginer - 2 USD</option>
            <option value="3">Master - 3 USD</option>
        </select>
        <input type="hidden" name="userid" value="223344">
        <input type="submit" name="submit" value="Buy" />
</form>
<?php 
die;
}


$payer = new Payer();
$payer->setPaymentMethod("paypal");

// ### Itemized information
// (Optional) Lets you specify item wise
// information
$item1 = new Item();
$item1->setName('Zinteo Coupons')
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setPrice($_POST['price']);


$itemList = new ItemList();
$itemList->setItems(array($item1));

// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
$details = new Details();
$details->setShipping(1)
    ->setTax(1)
    ->setSubtotal($_POST['price']);

// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
$amount = new Amount();
$amount->setCurrency("USD")
    ->setTotal($_POST['price'] + 2)
    ->setDetails($details);

// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it. 
$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Payment description")
    ->setInvoiceNumber(uniqid());

// ### Redirect urls
// Set the urls that the buyer must be redirected to after 
// payment approval/ cancellation.
$baseUrl = getBaseUrl();
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("$baseUrl/success.php?success=true&userid=".$_POST['userid'])
    ->setCancelUrl("$baseUrl/success.php?success=false");

// ### Payment
// A Payment Resource; create one using
// the above types and intent set to 'sale'
$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));


// For Sample Purposes Only.
$request = clone $payment;

// ### Create Payment
// Create a payment by calling the 'create' method
// passing it a valid apiContext.
// (See bootstrap.php for more on `ApiContext`)
// The return object contains the state and the
// url to which the buyer must be redirected to
// for payment approval
try {
    $payment->create($apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex);
    exit(1);
}

// ### Get redirect url
// The API response provides the url that you must redirect
// the buyer to. Retrieve the url from the $payment->getLinks()
// method
foreach ($payment->getLinks() as $link) {
    if ($link->getRel() == 'approval_url') {
        $approvalUrl = $link->getHref();
        header('Location:'.$approvalUrl);
        break;
    }
}

ResultPrinter::printResult("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment);

return $payment;
