<?php
 require_once '../vendor/tecnickcom/tcpdf/tcpdf.php';
 require_once '../db/db.php';
 
 $pdf = new TCPDF();
//  $pdf->addPage('L');
//  $pdf->SetFont('Arial','I',9);
//  $pdf->Cell(50,10,'Date',1,0,'C',0);
//  $pdf->Cell(55,10,'Account Debit',1,0,'C',0);
//  $pdf->Cell(60,10,'Amount Debit',1,0,'C',0);
//  $pdf->Cell(55,10,'Account Credit',1,0,'C',0);
//  $pdf->Cell(60,10,'Amount Credit',1,0,'C',0);


// Set font
$pdf->SetFont('helvetica', '', 12);
// Add a page to the PDF
$pdf->AddPage(); 
$pdf->Ln(20); // Line break

$userRef = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['id']."'");
$row_dept = $userRef->fetch(PDO::FETCH_ASSOC);

    $html = '
    <style>
    </style>
    <h4>Journal Entries</h4>
    <h4>'.$row_dept['name'].'</h4> 
    <table class="table" id="request" cellspacing="0" cellpadding="4">
                    <thead>
                      <tr style="border: 1px solid black;">
                        <th style="border: 1px solid black;background-color:green;color:white;">Date</th>
                        <th style="border: 1px solid black;background-color:green;color:white;">Account Debit</th>
                        <th style="border: 1px solid black;background-color:green;color:white; ">Amount Debit</th>
                        <th style="border: 1px solid black;background-color:green;color:white;">Account Credit</th>
                        <th style="border: 1px solid black;background-color:green;color:white;">Amount Credit</th>
                      </tr>
                    </thead>
                    <tbody>';
   
                    $stmt = $dbh->query("SELECT * FROM `journal-data`");

                    // Get the current items
                    $groupedEntries = [];
                    
                    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
                        if ($item['transaction_id'] == $_GET['transaction_id']) {
                            $date = $item['date'];
                                if (!isset($groupedEntries[$date])) {
                                    $groupedEntries[$date][] = [];
                                    
                    }
                        $groupedEntries[$date][] = $item;
                    }}
                  foreach($groupedEntries as $date => $items) {
                     $filteredArray = array_filter($items);

                    

                     foreach ($filteredArray as $fetch) {
                        $html .= '
                        <tr style="background-color: #f2f2f2;">
                        <td style="border: 1px solid black;">'.$date.'</td>
                        ';

                           $html .= '
                           <td style="border: 1px solid black;">' . $fetch['account_debit'] . '</td>
                           <td style="border: 1px solid black;">' . htmlspecialchars(number_format($fetch['amount_debit'], 2)) . '</td>
                           <td style="border: 1px solid black;">' . $fetch['account_credit'] . '</td>
                           <td style="border: 1px solid black;">' . htmlspecialchars(number_format($fetch['amount_credit'], 2)) . '</td>
                           ';
                           $html .= '</tr>';

                        }
                      
                     
                     }
                     $html .= '
                     </tbody>
                     </table>';
  
   $pdf->setFooterDetails('GCM Accounting Admin', $row_dept['name']);
   $pdf->writeHTML($html, true, false, false, false, '');

 $pdf->Output('Journal_data.pdf','I');

?>