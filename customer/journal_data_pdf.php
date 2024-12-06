<?php
 require_once '../fpdf/fpdfs.php';
 require_once '../db/db.php';
 
 $pdf = new FPDF();
 $pdf->addPage('L');
 $pdf->SetFont('Arial','I',9);
 $pdf->Cell(50,10,'Date',1,0,'C',0);
 $pdf->Cell(55,10,'Account Debit',1,0,'C',0);
 $pdf->Cell(60,10,'Amount Debit',1,0,'C',0);
 $pdf->Cell(55,10,'Account Credit',1,0,'C',0);
 $pdf->Cell(60,10,'Amount Credit',1,0,'C',0);

 $pdf->Ln();
 
 $stmt = $dbh->query("SELECT * FROM `journal-data`");
 $groupedEntries = [];
 
 foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $entry) {
        if ($entry['transaction_id'] == $_GET['transaction_id']) {
            $date = $entry['date'];
            if (!isset($groupedEntries[$date])) {
                    $groupedEntries[$date][] = [];
                                    
             }
            $groupedEntries[$date][] = $entry;
    }}
    foreach($groupedEntries as $date => $items) {
      $filteredArray = array_filter($items);

        $pdf->Cell(50,10,$date,1,0,'C',0);

        foreach ($filteredArray as $fetch) {
            $pdf->Cell(55,10,$fetch['account_debit'],1,0,'C',0);
         }
         foreach ($filteredArray as $item) {
            $pdf->Cell(60,10,htmlspecialchars(number_format($item['amount_debit'], 2)),1,0,'C',0);
         }

         foreach ($filteredArray as $item) {
            $pdf->Cell(55,10,$item['account_credit'],1,0,'C',0);
         }
         foreach ($filteredArray as $item) {
            $pdf->Cell(60,10,htmlspecialchars(number_format($item['amount_credit'], 2)),1,0,'C',0);
         }

        $pdf->Ln();
        }
    
 
 $pdf->Output('Journal_data.pdf','D', true);

?>