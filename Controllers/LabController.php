<?php

class LabController extends AbstractController
{
    public function planifyLab()
    {
        $inputJson = $_POST['inputJson'] ?? null;
        $data = [
            "inputJson" => $inputJson
        ];

        if ($inputJson) {
            $decoded = json_decode($inputJson, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                
            } else {
                $data["error"] = "JSON invalide : " . json_last_error_msg();
            }
        }

        $result = $data;
        $this->render("home.html.twig", [
            "result" => $result
        ]);
    }
}
