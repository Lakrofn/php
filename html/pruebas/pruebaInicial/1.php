<?php

$name = "Laura";
$baseSalary = 1450;
$overtimeHours = 8;
$priceOvertimeHours = 18;


function calculateSalary($name, $baseSalary, $overtimeHours, $priceOvertimeHours)
{
    $brute = $baseSalary;

    if ($overtimeHours > 0) {
        for ($i = 1; $i <= $overtimeHours; $i++) {
            if ($i <= 5) {
                $brute += $priceOvertimeHours;
            } else {
                $brute += $priceOvertimeHours * 0.50;
            }
        }
    }

    $retencion = ($brute > 1500) ? $brute * 0.12 : $brute * 0.08;

    $total = $brute - $retencion;

    echo "Trabajador: " . $name . "<br> Salario base: " . $baseSalary . "<br>Horas extra: " . $overtimeHours
        . "<br> Importe Horas extra: " . $priceOvertimeHours . "<br> Salario bruto: " . $brute . "<br> Retención: " . $retencion . "<br> Salario final: " . $total;
}

calculateSalary("Laura", 1450, 8, 18);
echo"<br><br>";
calculateSalary("Luis", 1450, 0, 18);
echo"<br><br>";
calculateSalary("Lola", 1450, 5, 18);
echo"<br><br>";
calculateSalary("Leo", 1200, 8, 18);
?>