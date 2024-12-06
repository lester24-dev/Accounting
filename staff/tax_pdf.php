<?php
 require_once '../fpdf/fpdf.php';
 require_once '../db/db.php';
 
 $pdf = new FPDF();
 $pdf->addPage();
 $pdf->SetFont('Arial','I',9);
 $pdf->Cell(94,10,'Tax Name',1,0,'C',0);
 $pdf->Cell(94,10,'Tax Percentage',1,0,'C',0);
 $pdf->Ln();
 
 $dbh->query("SELECT * FROM tax WHERE customer_id = '".$_GET['id']."'");
                          
                          // Loop through the items to find the one with the matching name
                          foreach ($stmt->fetchAll(PDO::FETCH_ASSOC)as $item) {

            
        $pdf->Cell(94,10,$item['tax_name'],1,0,'C',0);
        $pdf->Cell(94,10,$item['tax_percentage']."%",1,0,'C',0);
        $pdf->Ln();
        }
 
 
 $pdf->Output('Tax.pdf','D', true);

?>

