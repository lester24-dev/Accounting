<?php
 require_once '../fpdf/fpdfs.php';
 require_once '../db/firebaseDB.php';
 
 $pdf = new FPDF();
 $pdf->addPage('L');
 $pdf->SetFont('Arial','I',9);
 $pdf->Cell(65,10,'Name',1,0,'C',0);
 $pdf->Cell(35,10,'Transaction',1,0,'C',0);
 $pdf->Cell(60,10,'Email',1,0,'C',0);
 $pdf->Cell(80,10,'Address',1,0,'C',0);
 $pdf->Cell(40,10,'Date Created',1,0,'C',0);
 $pdf->Ln();
 
 if (isset($_GET['transaction'])) {
    $itemsRef = $realtimeDatabase->getReference('transaction');

    // Get the current items
    $items = $itemsRef->getValue();
    
        // Loop through the items to find the one with the matching name
        foreach ($items as $itemKey => $item) {
          if ($item['transaction'] == $_GET['transaction']) {
            
            $pdf->Cell(65,10,$item['title'],1,0,'C',0);
            $pdf->Cell(35,10,$item['transaction'],1,0,'C',0);
            $pdf->Cell(60,10,$item['email'],1,0,'C',0);
            $pdf->Cell(80,10,$item['address'],1,0,'C',0);
            $pdf->Cell(40,10,$item['dates'],1,0,'C',0);
            $pdf->Ln();
        }
    }
 }else{
    $fetchdata = $realtimeDatabase->getReference("transaction")->getValue();
    foreach($fetchdata as $item) {
            
        $pdf->Cell(65,10,$item['title'],1,0,'C',0);
        $pdf->Cell(35,10,$item['transaction'],1,0,'C',0);
        $pdf->Cell(60,10,$item['email'],1,0,'C',0);
        $pdf->Cell(80,10,$item['address'],1,0,'C',0);
        $pdf->Cell(40,10,$item['dates'],1,0,'C',0);
        $pdf->Ln();
        }
    
    }
 
 
 $pdf->Output('Transaction.pdf','D', true);

?>

