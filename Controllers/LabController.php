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
                $techData = $decoded['technicians'][0];
                $techName = $techData['name'] ?? ""; 
                $tech = new Technician($techData["id"], $techName, $techData["speciality"], new DateTime($techData["startTime"]), new DateTime($techData["endTime"]), new DateTime());

                $equipData = $decoded['equipment'][0];
                $equipName = $equipData['name'] ?? ""; 
                $equip = new Equipment($equipData["id"], $equipName, $equipData["type"], (bool)$equipData["available"]);
                $samples = [];
                foreach ($decoded["samples"] as $s) {
                    $samples[] = new Sample($s["id"], $s["type"], $s["priority"], (int)$s["analysisTime"], new DateTime($s["arrivalTime"]), $s["patientId"]);
                }

                // $technicians = [];
                // foreach ($decoded["technicians"] as $t) {
                //     $technicians[] = new Technician($t["id"], $t["name"],$t["speciality"], new DateTime($t["startTime"]), new DateTime($t["endTime"]));
                // }

                // $equipment = [];
                // foreach ($decoded["equipment"] as $e) {
                //     $equipment[] = new Equipment($e["id"], $e["name"], $e["type"], (bool)$e["available"]);
                // }
                //trie des samples en fonction du poid
                usort($samples, function($a, $b) {
                    $prio = ["STAT" => 3, "URGENT" => 2, "ROUTINE" => 1];
                    return $prio[$b->priority] <=> $prio[$a->priority];
                });
                $schedule = [];
                $totalAnalyse = 0;
                $startPlanning = null;
                $endPlanning = null;
                // var_dump($samples);
                //détermine l'heure de début de l'analyse
                foreach($samples as $sample) {
                    if ($sample->arrivalTime > $tech->availableFrom) {
                        $startTime = $sample->arrivalTime;
                    } else {
                        $startTime = $tech->availableFrom;
                    }
                    //calcul l'heure de fin
                    $endTime = (clone $startTime)->modify("+{$sample->analysisTime} minutes");
                    //maj de la dispo
                    $tech->availableFrom = $endTime;
                    $equip->available = false;

                    $schedule[] = [
                        "sampleId" => $sample->id,
                        "technicianId" => $tech->id,
                        "equipmentId" => $equip->id,
                        "startTime" => $startTime->format("H:i"),
                        "endTime" => $endTime->format("H:i"),
                        "priority" => $sample->priority
                    ];
                    $totalAnalyse+= $sample->analysisTime;
                    //calcul du temps réel d'analyse en fonction du planing
                    if ($startPlanning === null || $startTime < $startPlanning) {
                        $startPlanning = $startTime;
                    }
                    if ($endPlanning === null || $endTime > $endPlanning) {
                        $endPlanning = $endTime;
                    }
                }
                $totalTime = ($endPlanning->getTimestamp() - $startPlanning->getTimestamp()) / 60;
                $result = [
                    "schedule" => $schedule,
                    "metrics" => [
                        "totalTime" => $totalTime,
                        "efficiency" => round(($totalAnalyse / $totalTime) * 100, 1),
                        "conflicts" => 0
                    ]
                ];
            } else {
                $data["error"] = "JSON invalide : " . json_last_error_msg();
            }
        }

        $this->render("home.html.twig", [
            "result" =>  $result
        ]);
    }
}
