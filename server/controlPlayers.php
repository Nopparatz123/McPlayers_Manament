<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');

    // kick
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if(empty($data['command']) || empty($data['target'])){
            echo json_encode(["status" => "error", "message" => "ข้อมูลไม่ครบ"]);
            exit;
        }
            $player = $data['target'];
            $command = $data['command'];

            if ($command === 'kick') {
                $pluginUrl = "http://localhost:8080/action?type=kick&player=" . urlencode($player);
            } elseif ($command === 'kill') {
                $pluginUrl = "http://localhost:8080/action?type=kill&player=" . urlencode($player);
            }elseif ($command === 'rsHeart'){
                $pluginUrl = "http://localhost:8080/action?type=rsHeart&player=" . urlencode($player);
            }else{
                echo json_encode(["status" => "error", "message" => "ไม่มีคำสั่งนี้"]);
                exit;
            }

            $result = file_get_contents($pluginUrl);
            echo json_encode([
                "status" => "ok",
                "message" => "$command $player ok",
                "response" => $result
            ]);
    }else{
        echo json_encode(["status" => "error", "message" => "ไม่อนุญาต"]);
    }
?>