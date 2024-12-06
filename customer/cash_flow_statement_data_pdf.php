<?php
 require_once '../fpdf/fpdfs.php';
 require_once '../db/firebaseDB.php';

 $pdf = new FPDF();
 $pdf->addPage('L');
 $pdf->SetFont('Arial','I',9);
 $pdf->Cell(45,10,'Date',1,0,'C',0);
 $pdf->Cell(50,10,'Operating Activities',1,0,'C',0);
 $pdf->Cell(30,10,'Cost',1,0,'C',0);
 $pdf->Cell(50,10,'Investing Activities',1,0,'C',0);
 $pdf->Cell(30,10,'Cost',1,0,'C',0);
 $pdf->Cell(50,10,'Financing Activities',1,0,'C',0);
 $pdf->Cell(30,10,'Cost',1,0,'C',0);
 $pdf->Ln();

 $itemsRef = $realtimeDatabase->getReference('cash-flow-statement-data')->orderByChild('date');
 // Get the current items
 $itemRefs = $itemsRef->getValue();
 $groupedEntries = [];
 
 foreach ($itemRefs as $item) {
     if ($item['transaction_id'] === $_GET['transaction_id']) {
         $date = $item['date'];
             if (!isset($groupedEntries[$date])) {
                 $groupedEntries[$date][] = [];
                 
 }
     $groupedEntries[$date][] = $item;
 }}

// Loop through the items to find the one with the matching name
foreach ($groupedEntries as $date => $items) {
 $filteredArray = array_filter($items);

 foreach ($filteredArray as $item) {
    $pdf->Cell(45,10,$date,1,0,'C',0);
 }

 foreach ($filteredArray as $item) {
    $pdf->Cell(50,10,$item['operating_activities_name'],1,0,'C',0);
 }

 foreach ($filteredArray as $item) {
    $pdf->Cell(30,10,htmlspecialchars(number_format($item['operating_activities_amount'], 2)),1,0,'C',0);
 }

 foreach ($filteredArray as $item) {
    $pdf->Cell(50,10,$item['investing_activities_name'],1,0,'C',0);
 }

 foreach ($filteredArray as $item) {
    $pdf->Cell(30,10,htmlspecialchars(number_format($item['investing_activities_amount'], 2)),1,0,'C',0);
 }

 foreach ($filteredArray as $item) {
    $pdf->Cell(50,10,$item['financing_activities_name'],1,0,'C',0);
 }

 foreach ($filteredArray as $item) {
    $pdf->Cell(30,10,htmlspecialchars(number_format($item['financing_activities_amount'], 2)),1,0,'C',0);
 }

 $operating_activities_amount = 0;
 $investing_activities_amount = 0;
 $financing_activities_amount = 0;
 $total_cash_flow = 0;

 $operating_activities_amount += $item['operating_activities_amount'];
 $investing_activities_amount +=  $item['investing_activities_amount'];
 $financing_activities_amount +=  $item['financing_activities_amount'];
 $total_cash_flow = $operating_activities_amount + $investing_activities_amount + $financing_activities_amount;

 $pdf->Ln();
 $pdf->Cell(45,10,'Toal Cash Flow: '.htmlspecialchars(number_format($total_cash_flow, 2)),1,0,'C',0);
 $pdf->Cell(50,10,'Total',1,0,'C',0);
 $pdf->Cell(30,10,htmlspecialchars(number_format($operating_activities_amount, 2)),1,0,'C',0);
 $pdf->Cell(50,10,'Total',1,0,'C',0);
 $pdf->Cell(30,10,htmlspecialchars(number_format($investing_activities_amount, 2)),1,0,'C',0);
 $pdf->Cell(50,10,'',1,0,'C',0);
 $pdf->Cell(30,10,htmlspecialchars(number_format($financing_activities_amount, 2)),1,0,'C',0);
 $pdf->Ln();
}


 $pdf->Output('Cash_Flow_Statement_data.pdf','D', true);

?>