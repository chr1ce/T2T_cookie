<html>
<body>

<form action="cookie_form.php" method="post">

Pickup address: <input type="text" name="p_address"><br>

Dropoff address: <input type="text" name="d_address"><br>

<input type="submit">
</form>

</body>
</html>


<?php

if  (isset($_POST["d_address"]) and isset($_POST["p_address"]) ) {

function base64UrlEncode(string $data): string
{
    $base64Url = strtr(base64_encode($data), '+/', '-_');

    return rtrim($base64Url, '=');
}

function base64UrlDecode(string $base64Url): string
{
    return base64_decode(strtr($base64Url, '-_', '+/'));
}

$header = json_encode([
    'alg' => 'HS256',
    'typ' => 'JWT',
    'dd-ver' => 'DD-JWT-V1'
]);

$payload = json_encode([
    'aud' => 'doordash',
    'iss' => '26089160-f377-4fff-84db-e304aed22864',
    'kid' => '887912e7-59d3-4e7d-8e99-8d2e04e4daa1',
    'exp' => time() + 60,
    'iat' => time()
]);

$base64UrlHeader = base64UrlEncode($header);
$base64UrlPayload = base64UrlEncode($payload);

$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, base64UrlDecode('drqxM82q22CIGKCj5cKKKR7j43ia5MD4iLletVZcBNo'), true);
$base64UrlSignature = base64UrlEncode($signature);

$jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

//Request information
$request_body = json_encode([
  "external_delivery_id" => uniqid(),
  "pickup_address"=> $_POST['p_address'],
  "pickup_business_name"=> "Wells Fargo SF Downtown",
  "pickup_phone_number"=> "+16505555555",
  "pickup_instructions"=> "Enter gate code 1234 on the callbox.",
  "dropoff_address"=> $_POST['d_address'],
  "dropoff_business_name"=> "Wells Fargo SF Downtown",
  "dropoff_phone_number"=> "+16505555555",
  "dropoff_instructions"=> "Enter gate code 1234 on the callbox.",
  "order_value"=> 1999
]);

$headers = array(
  "Content-type: application/json",
  "Authorization: Bearer ".$jwt
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://openapi.doordash.com/drive/v2/deliveries/");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
echo($result);

}

?>
