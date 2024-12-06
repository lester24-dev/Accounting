<?php
 require_once '../fpdf/fpdf.php';
 require_once '../db/db.php';
 
 $pdf = new FPDF();
 $pdf->AddPage();
 $pdf->SetFont('Arial','I',9);
 $pdf->Cell(65,10,'Name',1,0,'C',0);
 $pdf->Cell(80,10,'Department',1,0,'C',0);
 $pdf->Cell(50,10,'Email',1,0,'C',0);
 $pdf->Ln();
 
 if (isset($_GET['departments'])) {
    $stmt = $dbh->query("SELECT * FROM users");
                          
            // Loop through the items to find the one with the matching name
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $itemKey => $fetch) {
          if ($item['department'] == $_GET['departments']) {
            
            $pdf->Cell(65,10,$item['name'],1,0,'C',0);
            $pdf->Cell(80,10,$item['department'],1,0,'C',0);
            $pdf->Cell(50,10,$item['email'],1,0,'C',0);
            $pdf->Ln();
        }
    }
 }else{
    $stmt = $dbh->query("SELECT * FROM users");
                          
    // Loop through the items to find the one with the matching name
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $itemKey => $fetch)  {
    if ($fetch['department'] != 'Company Admin' ) {
            $pdf->Cell(65,10,$fetch['name'],1,0,'C',0);
            $pdf->Cell(80,10,$fetch['department'],1,0,'C',0);
            $pdf->Cell(50,10,$fetch['email'],1,0,'C',0);
            $pdf->Ln();
     } }
    
    }
 
 
 $pdf->Output('Department.pdf','D', true);

?>

