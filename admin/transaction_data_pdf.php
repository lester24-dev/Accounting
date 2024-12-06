<?php
 require_once '../fpdf/fpdfs.php';
 require_once '../db/firebaseDB.php';
 
 $pdf = new FPDF();
 $pdf->addPage('L');
 $pdf->SetFont('Arial','I',9);
 $pdf->Cell(80,10,'Payors Name',1,0,'C',0);
 $pdf->Cell(35,10,'Tin',1,0,'C',0);
 $pdf->Cell(35,10,'1st Quarter',1,0,'C',0);
 $pdf->Cell(35,10,'2nd Quarter',1,0,'C',0);
 $pdf->Cell(35,10,'3rd Quarter',1,0,'C',0);
 $pdf->Cell(35,10,'4th Quarter',1,0,'C',0);
 $pdf->Cell(30,10,'Total',1,0,'C',0);
 $pdf->Ln();
 
 if (isset($_GET['vat_reg_tin'])) {
    $fetchdata = $realtimeDatabase->getReference("data")->getValue();
    foreach($fetchdata as $itemKey => $item) {
        $characters = array(',', '.', ' ');
        $cleaned_number_first = str_replace($characters, '', $item['first']);
        $cleaned_number_second = str_replace($characters, '', $item['second']);
        $cleaned_number_third = str_replace($characters, '', $item['third']);
        $cleaned_number_fourth = str_replace($characters, '', $item['fourth']);
        $sum =  $cleaned_number_first + $cleaned_number_second + $cleaned_number_third + $cleaned_number_fourth;
        $total =  $sum / 100;
        $first = 0;
        $first += $cleaned_number_first / 100;
        $second = 0;
        $second += $cleaned_number_second / 100;
        $third = 0;
        $third += $cleaned_number_third / 100;
        $fourth = 0;
        $fourth += $cleaned_number_fourth / 100;
        $tftotal = 0;
        $tftotal +=  $sum / 100;

        if ($item['vat_reg_tin'] == $_GET['vat_reg_tin']) {
            $pdf->Cell(80,10, $item['payors_name'],1,0,'C',0);
            $pdf->Cell(35,10, $item['tin'],1,0,'C',0);
            $pdf->Cell(35,10, htmlspecialchars(number_format($item['first'], 2)),1,0,'C',0);
            $pdf->Cell(35,10, htmlspecialchars(number_format($item['second'], 2)),1,0,'C',0);
            $pdf->Cell(35,10, htmlspecialchars(number_format($item['third'], 2)),1,0,'C',0);
            $pdf->Cell(35,10, htmlspecialchars(number_format($item['fourth'], 2)),1,0,'C',0);
            $pdf->Cell(30,10, htmlspecialchars(number_format($total, 2, '.', ',')),1,0,'C',0);
            $pdf->Ln();
            // $pdf->Cell(80,10, "Total",1,0,'C',0);
            // $pdf->Cell(35,10, "",1,0,'C',0);
            // $pdf->Cell(35,10, number_format($first, 2, '.', ','),1,0,'C',0);
            // $pdf->Cell(35,10, number_format($second, 2, '.', ','),1,0,'C',0);
            // $pdf->Cell(35,10, number_format($third, 2, '.', ','),1,0,'C',0);
            // $pdf->Cell(35,10, number_format($fourth, 2, '.', ','),1,0,'C',0);
            // $pdf->Cell(30,10, number_format($tftotal, 2, '.', ','),1,0,'C',0);
            // $pdf->Ln();
            }
        }
 }
 
 
 $pdf->Output('Transaction.pdf','D', true);

?>

