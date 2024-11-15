

function getPreviousBimester($bimestreReunion) {
    $bimestres = [
        "Enero-Febrero" => "Noviembre-Diciembre",
        "Marzo-Abril" => "Enero-Febrero",
        "Mayo-Junio" => "Marzo-Abril",
        "Julio-Agosto" => "Mayo-Junio",
        "Septiembre-Octubre" => "Julio-Agosto",
        "Noviembre-Diciembre" => "Septiembre-Octubre",
    ];

    return $bimestres[$bimestreReunion] ?? '';
}
