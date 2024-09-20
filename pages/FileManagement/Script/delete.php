<?php
session_start();
    if(isset($_POST['FileName']) && isset($_POST['KeyDir'])){
        $fileName = $_POST['FileName'];
        $keyDir = $_POST['KeyDir'];
        $verzeichnis  = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR; 
        $filePath = $verzeichnis . $keyDir . "\\";
        
        $post = array(
            'Token' => $_SESSION['id'],
            'FileName' => $fileName
        );
        
        $url = 'https://nihonsaba.net/TokenApi/api/Delete';

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

        $files = glob($filePath . '*');
        foreach ($files as $file) {
            if (is_file($file)) { 
            unlink($file);
            }
        }
        
        if (is_dir($filePath)) {
            rmdir($filePath);
        };

        echo "Dateien wurden gelöscht!";
        echo "<meta http-equiv='refresh' content='0'>";

    } else {
        echo "FileName oder KeyDir nicht gesetzt";
    }

?>