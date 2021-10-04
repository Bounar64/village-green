<?php

use Dompdf\Dompdf;

$dompdf = new Dompdf(); // Nouveau fichier PDF
$dompdf->loadHtml('ma facture'); // le coeur du fichier pdf
$dompdf->setPaper('A4', 'portrait'); // le format du fichier pdf
$dompdf->render(); // génère le pdf (en mémoire)
$dompdf->stream(); // envoie le pdf en tant que fichier à télécharger
