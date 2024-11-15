<?php
 
function bussiness_days($begin_date, $end_date, $type = 'array') {
	$date_1 = date_create($begin_date);
	$date_2 = date_create($end_date);
	if ($date_1 > $date_2) return FALSE;
	$bussiness_days = array();
	while ($date_1 <= $date_2) {
		$day_week = $date_1->format('w');
		if ($day_week > 0 && $day_week < 6) {
			$bussiness_days[$date_1->format('Y-m')][] = $date_1->format('d');
		}
		date_add($date_1, date_interval_create_from_date_string('1 day'));
	}
	if (strtolower($type) === 'sum') {
	    array_map(function($k) use(&$bussiness_days) {
	        $bussiness_days[$k] = count($bussiness_days[$k]);
	    }, array_keys($bussiness_days));
	}
	return $bussiness_days;
}



public function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);
       
        // Incremento en 1 dia
        $diainc = 24*60*60;
       
        // Arreglo de dias habiles, inicianlizacion
        //$diashabiles = array();
        $diashabiles=0;
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                        if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                               // array_push($diashabiles, date('Y-m-d', $midia));
                        	 $diashabiles++;
                        }
                }
        }
       
	  return $diashabiles;
}


public function getDHpm($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);
       
        // Incremento en 1 dia
        $diainc = 24*60*60;
       $dh=0;
       $diashpm=array();
       $mi=date('m',$fechainicio);
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                        if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                               if($mi==date('m',$midia)){
                                    $dh++;}
                               else{
                               	  $mi=date('m',$midia);
                               	  array_push($diashpm, $dh);
                               	  $dh=0;
                               }

                        }
                }
        }
       
	  return $diashpm;
}


?>