<?php
    require 'vendor/autoload.php';

    use xPaw\MinecraftQuery;
    use xPaw\MinecraftQueryException;

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Content-Type');

    try{
        $Query = new MinecraftQuery();

        $Query->Connect('localhost', 25565, 1);

        echo json_encode([
            'info' => $Query->GetInfo(),
            'players' => $Query->GetPlayers()
        ]);
    }catch(MinecraftQueryException $e){
        echo json_encode(["error" => $e->getMessage()]);
    }
?>