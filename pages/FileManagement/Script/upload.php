<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_FILES["fileInput"]) && $_FILES["fileInput"]["error"] === UPLOAD_ERR_OK) {

        $selectedFolder = $_POST["DdlFolders"];

        function encryptString($string, $key, $iv) {
            $encryptedData = openssl_encrypt($string, 'AES-256-CBC', $key, 0, $iv);
            return base64_encode($encryptedData);
          }
          
          function decryptString($encryptedString, $key, $iv) {
            $decodedData = base64_decode($encryptedString);
            return openssl_decrypt($decodedData, 'AES-256-CBC', $key, 0, $iv);
          }
         
          $fileName = "";
          $plaintext = $fileName;
          $key = 'YourSecretKey12345';
          $iv = random_bytes(16); 
   
          $encryptedText = encryptString($_FILES["fileInput"]["name"], $key, $iv);
 
          $post = array(
            'Token' => $_SESSION['id'],
            'FileName' => $_FILES["fileInput"]["name"],
            'KeyDir' => $encryptedText,
            'FolderID' => $selectedFolder
        );
        
        $url = 'https://nihonsaba.net/TokenApi/api/Upload';
        
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json",
                'method'  => 'POST',
                'content' => json_encode($post),
                'timeout' => 60,
            ),
        );
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $oResponse = json_decode($response, true);

        $file_name = $_FILES["fileInput"]["name"];
        $file_size = $_FILES["fileInput"]["size"];
        $file_tmp = $_FILES["fileInput"]["tmp_name"];
        $file_type = $_FILES["fileInput"]["type"];

        echo "Dateiname: " . $file_name . "<br>";
        echo "Dateigröße: " . $file_size . " Bytes<br>";
        echo "Dateityp: " . $file_type . "<br>";

        $appRoot = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR; // 3 Ebenen nach oben

        $folderName = $encryptedText;
        $finalDir = $appRoot . $folderName . DIRECTORY_SEPARATOR;
        
        if (!is_dir($finalDir)) {
            mkdir($finalDir, 0777, true); // Rekursives Erstellen
        }
        
        $target_path = $finalDir . basename($file_name);
        
        if (move_uploaded_file($file_tmp, $target_path)) {
            echo "Die Datei wurde erfolgreich hochgeladen und gespeichert.";
        } else {
            echo "Es gab einen Fehler beim Hochladen der Datei.";
        }
        
} else {
    echo "Ungültiger Request.";
}}
?>
