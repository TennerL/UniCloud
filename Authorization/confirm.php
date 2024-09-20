<?php 

session_start();

//Session Parameter speichen! 
$return_uri = $_SESSION['return_uri'];
$urlToken = $_SESSION['id'];

$post = array(
	'data' => array(
    'token' => $urlToken
	)
);

$url = 'https://rela.sdnord.de/rela-rest-ws-test/windydog/ValidateToken/1';
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($post),
        'timeout' => 60,
    ),
);
$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);
$oResponse = json_decode($response, true);

if($oResponse["data"]["isValid"] == TRUE){
    session_regenerate_id(true);
    $_SESSION['loggedin'] = TRUE;
    $_SESSION['id'] = $urlToken;
    $_SESSION['name'] = $oResponse["data"]["user"];
    header('location: '.$return_uri);
} else {
    echo("Zugriff verweigert!");
} 
?>