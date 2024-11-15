<?php

 $finiciop=strtotime($proyt->fecha_inicio);
 $ffinp=strtotime($proyt->fecha_fin);
 $diasferiados=array("2022-01-01","2022-02-07","2022-03-21","2022-05-01","2022-05-05","2022-09-16","2022-11-02","2022-12-25");
 $diasp= getDiasHabiles($finiciop,$ffin,$diasferiados);
 $apd= 100/$diasp;

 $finita=strtotime($ta->fecha_inicio);

 $ffinta=strtotime($ta->fecha_fin);

 $diashpm=getDHpm($finita,$ffinta,$diasferiados);

for linea 590
.
.......
for ($i=$colinicro, $cdm=1; $i < $fin;$i++, $cdm++)
{
      //calcula la variable $real desde el areglo díashpm 
	$realpd=$diashpm[$cdm] * $apd;
}


//En lo realizado 

?>