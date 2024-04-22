<?php 
//cálculo tubete de 1.8mg e paciente de 60kg
$mlPorTubete=$porcentagem*10*1.8;
$maxDosePorPeso=$doseMaxima*60;
$quantTubete=floatval(number_format($maxDosePorPeso/$mlPorTubete,2));
$arqArray=array('mlPorTubete'=>$mlPorTubete,
                    'maxDosePorPeso'=>$maxDosePorPeso,
                    'quantTubete'=>$quantTubete);
$calculoJson= json_encode($arqArray);