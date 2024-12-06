<?php
 require_once '../fpdf/fpdfs.php';
 require_once '../db/db.php';
 
 $pdf = new FPDF();
 $pdf->addPage('L');
 $pdf->SetFont('Arial','I',9);
 $pdf->Cell(90,10,'Account ID',1,0,'C',0);
 $pdf->Cell(95,10,'Account Name',1,0,'C',0);
 $pdf->Cell(95,10,'Account Type',1,0,'C',0);
 $pdf->Ln();
 
 $stmt = $dbh->query("SELECT * FROM account");
                          
                         // Loop through the items to find the one with the matching name
                         foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
            
        $pdf->Cell(90,10,$item['account_id'],1,0,'C',0);
        $pdf->Cell(95,10,$item['account_name'],1,0,'C',0);
        $pdf->Cell(95,10,$item['account_type'],1,0,'C',0);
        $pdf->Ln();
        }
 
 
 $pdf->Output('Account.pdf','D', true);

?>

