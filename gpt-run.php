<?php

$api_key = "YOUR_OPENAI_API_KEY";

$url = "https://api.openai.com/v1/completions";

$prompt = filter_var($_POST["prompt"], FILTER_SANITIZE_STRING);;

$data = array(
    "model" => "text-davinci-003",  
    "prompt" => $prompt,
    "max_tokens" => 3000,
    "temperature" => 0.5,
);

$data_string = json_encode($data);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Authorization: Bearer $api_key",
    "Content-Length: " . strlen($data_string))
);

$output = curl_exec($ch);
curl_close($ch);

$output_json = json_decode($output, true);
$response = $output_json["choices"][0]["text"];

$response = str_replace("유사한 문제", "<br>유사한 문제", $response);
$response = str_replace("1. ", "<br>1번. ", $response);
$response = str_replace("2. ", "<br>2번. ", $response);
$response = str_replace("3. ", "<br>3번. ", $response);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script type="text/x-mathjax-config">MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});</script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>
    </head>
    <body>
        <p><?php echo $response;?></p>
    </body>
</html>