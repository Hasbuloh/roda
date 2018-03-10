<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once("../vendor/dompdf/dompdf/autoload.inc.php");
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfgenerator {

  public function generate($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
  {
    $options = new Options();
    $options->set('enable_html5_parser', true);
    $dompdf = new DOMPDF($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf", array("Attachment" => 0));
    } else {
        return $dompdf->output();
    }
  }
}
