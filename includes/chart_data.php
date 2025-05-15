<?php
session_start();
header('Content-Type: application/json');

$data = [
  "bmi_distribution" => [10, 25, 15, 5],
  "nutrition_intake" => [
    "Protein" => 350,
    "Grains" => 600,
    "Vegetables" => 300,
    "Fruits" => 250
  ],
  "macros" => [
    "protein" => 80,
    "carbs" => 150,
    "fat" => 40
  ],
  "progress" => [
    "dates" => ["2024-01", "2024-02", "2024-03", "2024-04"],
    "weights" => [68, 67, 66, 65]
  ]
];

echo json_encode($data);
