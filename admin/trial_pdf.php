<?php
 require_once '../fpdf/fpdfs.php';
 require_once '../db/db.php';
 
 $pdf = new FPDF();
 $pdf->addPage('L');
 $pdf->SetFont('Arial','I',9);
 $pdf->Cell(70,10,'Name',1,0,'C',0);
 $pdf->Cell(35,10,'Year',1,0,'C',0);
 $pdf->Cell(90,10,'Client',1,0,'C',0);
 $pdf->Cell(80,10,'Date Created',1,0,'C',0);
 $pdf->Ln();
 
 $stmt = $dbh->query("SELECT * FROM journal");
                          
 // Loop through the items to find the one with the matching name
 foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $itemKey => $item) {

    $userRef = $dbh->query("SELECT * FROM users WHERE id = '".$item['department_id']."'");
    $row_depts = $userRef->fetch(PDO::FETCH_ASSOC);
            
        $pdf->Cell(70,10,$item['title'],1,0,'C',0);
        $pdf->Cell(35,10,$item['year'],1,0,'C',0);
        $pdf->Cell(90,10,$row_depts['name'],1,0,'C',0);
        $pdf->Cell(80,10,$item['timestamp'],1,0,'C',0);
        $pdf->Ln();
        }
 
 
 $pdf->Output('Trial.pdf','D', true);

?>

