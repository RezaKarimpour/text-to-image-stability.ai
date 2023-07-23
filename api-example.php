<?php

/* 
developer : Reza Karimpour
course playlist : https://www.youtube.com/playlist?list=PL5GIwh73N-unbhExotu7MWtgyeBRVSB0Y
instagram : https://instagram.com/rezakarimpou.pro
*/

function textToImage() {
    $path = "https://api.stability.ai/v1/generation/stable-diffusion-xl-beta-v2-2-2/text-to-image";
    $headers = array(
        "Accept: application/json",
        "Authorization: YOUR-API-KEY ",
        "Content-Type: application/json"
    );

    $body = array(
        "width" => 512,
        "height" => 512,
        "steps" => 50,
        "seed" => 0,
        "cfg_scale" => 7,
        "samples" => 1,
        "style_preset" => " IMAGE-STYLE ",
        "text_prompts" => array(
            array(
                "text" => " YOUT-TEXT ",
                "weight" => 1
            )
        )
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $path);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

    $response = curl_exec($ch);

    if ($response === false) {
        throw new Exception(curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode !== 200) {
        throw new Exception("Non-200 response: ".$response);
    }

    curl_close($ch);

    $responseJSON = json_decode($response, true);

    foreach ($responseJSON['artifacts'] as $index => $image) {
        file_put_contents("./out/txt2img_".$image['seed'].".png", base64_decode($image['base64']));
    }
}

textToImage();
?>
