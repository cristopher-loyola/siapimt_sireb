<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generarPDF()
    {
        // Definir el contenido HTML para el PDF
        $html = $this->crearContenidoHTML();

        // Generar el PDF
        $pdf = Pdf::loadHTML($html)
                  ->setPaper('letter', 'portrait')
                  ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);

        // Mostrar el PDF en el navegador
        return $pdf->stream('documento.pdf');
    }

    private function crearContenidoHTML()
    {
        // Contenido HTML del PDF
        $contenido = '';

        // Primera portada
        $contenido .= '
            <div style="text-align:center; height:100vh; display:flex; flex-direction:column; justify-content:center;">
                <img src="' . public_path('ruta/a/tu/imagen.jpg') . '" style="max-height: 150px; margin-bottom:20px;">
                <h1>Título del Documento</h1>
                <h3>Subtítulo del Documento</h3>
                <div style="display: flex; justify-content: space-between;">
                    <p style="width: 48%;">Texto izquierdo</p>
                    <p style="width: 48%;">Texto derecho</p>
                </div>
                <p style="text-align:right; position:absolute; bottom:10px; right:20px;">Fecha: ' . now()->format('d/m/Y') . '</p>
            </div>';

        // Segunda portada
        $contenido .= '
            <div style="text-align:center; height:100vh; display:flex; flex-direction:column; justify-content:center;">
                <h1>Título de la Segunda Portada</h1>
                <p>Texto centrado debajo del título</p>
                <div style="margin-top: 50px;">
                    <p style="text-align:left;">Firma 1:</p>
                    <p style="text-align:right;">Firma 2:</p>
                </div>
            </div>';

        // Tabla de contenido
        $contenido .= '
            <div style="margin-top: 20px;">
                <h2>Tabla de Contenidos</h2>
                <ul>
                    <li>Portada 1 - Página 1</li>
                    <li>Portada 2 - Página 2</li>
                    <li>Contenido - Página 3</li>
                    <li>Referencias - Página 4</li>
                </ul>
            </div>';

        // Hojas de contenido
        $contenido .= $this->crearContenido();

        // Referencias
        $contenido .= '
            <div style="margin-top: 20px;">
                <h2>Referencias</h2>
                <p>Aquí van las referencias.</p>
            </div>';

        return $contenido;
    }

    private function crearContenido()
    {
        // Aquí se generan las páginas de contenido
        $contenido = '';
        for ($i = 0; $i < 5; $i++) {
            $contenido .= '
                <div style="page-break-before:always; padding: 20px;">
                    <div style="text-align:center; border-bottom: 2px solid black;">
                        <h2>Encabezado Página ' . ($i + 3) . '</h2>
                    </div>
                    <p>Aquí va el contenido de la página ' . ($i + 3) . '.</p>
                </div>';
        }
        return $contenido;
    }
}
