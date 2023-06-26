<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PayU</title>
</head>
<body>

<pre>
<?php 

$crm = false;

$dokument = "FV-".date("U");
$extOrderId = $dokument;

if ($crm) {
	$merchantPosId = "";
	$secondMD5 = "";
	//$sygnatura = ""
	echo '<h1>CRM</h1>';
} else {
	$merchantPosId = "";
	$secondMD5 = "";
	//$sygnatura="";
	echo '<h1>INNE</h1>';
}


$data=array();
// $data["currencyCode"]="EUR";
$data["currencyCode"] = "PLN";
$data["merchantPosId"] = $merchantPosId;
$data["continueUrl"] = "http://localhost/koszyk/informacja-o-platnosci/".$extOrderId;
$data["notifyUrl"] = "http://localhost/pay/notify";
$data["customerIp"] = "192.168.1.1";
$data["description"] = "Płatność za FV ".$extOrderId;
$data["totalAmount"] = "2459";
$data["extOrderId"] = $extOrderId;
$data["products[0].name"] = "Płatność za FV ".$extOrderId;
$data["products[0].unitPrice"] = "2459";
$data["products[0].quantity"] = "1";
$data["buyer.language"] = "en";
$data["buyer.email"] = "buyer@gmail.com";
$data["buyer.phone"] = "12313";
$data["buyer.firstName"] = "123123";
$data["buyer.lastName"] = "123123";


//print_r($data);
ksort($data);
echo '<h1>TABLICA DANYCH</h1>';
print_r($data);

$connectionData=array();

foreach ($data as $k => $v){
	$connectionData[] = $k .'='. urlencode($v);
}
$string =implode("&", $connectionData);
$string .="&". $secondMD5;

echo "<br>";
echo '<h1>String do funkcji</h1>';
echo $string;
echo "<br>";
echo "<br>";
$newSignature= hash('sha256', $string);

?>

</pre>
<div style="border:1px solid black; padding:10px;">
	<h3 style="display: inline;">PosID</h3> <?php echo $merchantPosId ?><br />
	<h3 style="display: inline;">Klucz MD5</h3> <?php echo $secondMD5 ?><br />
	<h3 style="display: inline;">Zamówienie</h3> <?php echo $extOrderId; ?><br />
</div>

<h1>SYGNATURA</h1>
<table>
	<tr>
		<td></td>
		<td>Otrzymana</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td style="padding:10px;"><?php echo $newSignature; ?></td>
		<td></td>
	</tr>
</table>

<form method="POST" action="https://secure.payu.com/api/v2_1/orders" id="payu-payment-form" class="">

	<?php foreach ($data as $key => $val){ ?>
		<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $val; ?>" />
	<?php } ?>

	<input type="hidden" name="OpenPayu-Signature" value="sender=<?php echo $merchantPosId; ?>;algorithm=SHA-256;signature=<?php echo $newSignature; ?>" />
	<button type="submit" formtarget="_blank" id="" class="btn btn-primary">Testuj!</button>

</form>
</body>
</html>
