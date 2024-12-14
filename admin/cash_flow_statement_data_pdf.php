<?php
 require_once '../tcpdf/tcpdf.php';
 require_once '../db/db.php';


 $pdf = new TCPDF();
// Set font
$pdf->SetFont('helvetica', '', 12);
// Add a page to the PDF
$pdf->AddPage(); 
$pdf->Ln(20); // Line break

$operating_activities_amount = 0;
$investing_activities_amount = 0;
$financing_activities_amount = 0;
$total_cash_flow = 0;

$userRef = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['id']."'");
$row_dept = $userRef->fetch(PDO::FETCH_ASSOC);

$stmt = $dbh->query("SELECT * FROM `cash-flow-statement-data`");
// Get the current items
$groupedEntries = [];

foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
    if ($item['transaction_id'] === $_GET['transaction_id']) {
        $date = $item['date'];
            if (!isset($groupedEntries[$date])) {
                $groupedEntries[$date][] = [];
                
}
    $groupedEntries[$date][] = $item;
}}

$html = '
<h4>Cash Flow Statement</h4>
<h4>'.$row_dept['name'].'</h4> 
<table class="table" id="request" cellspacing="0">
       <thead>
            <tr style="border: 1px solid black;">
               <th style="border: 1px solid black;background-color:green;color:white;">Date</th>
               <th style="border: 1px solid black;background-color:green;color:white;">Operating</th>
               <th style="border: 1px solid black;background-color:green;color:white;">Amount</th>
               <th style="border: 1px solid black;background-color:green;color:white;">Investing</th>
               <th style="border: 1px solid black;background-color:green;color:white;">Amount</th>
               <th style="border: 1px solid black;background-color:green;color:white;">Financing</th>
               <th style="border: 1px solid black;background-color:green;color:white;">Amount</th>
               <th style="border: 1px solid black;background-color:green;color:white;">Total</th>
            </tr>
         </thead>
 <tbody>
';

foreach ($groupedEntries as $date => $items) {
   $filteredArray = array_filter($items);

   $html .= '
   <tr style="background-color: #f2f2f2;">
   <td style="border: 1px solid black;">'.$date.'</td>
   ';
   foreach ($filteredArray as $item) {

    
     
      $operating_activities_amount += $item['operating_activities_amount'];
      $investing_activities_amount +=  $item['investing_activities_amount'];
      $financing_activities_amount +=  $item['financing_activities_amount'];
      $total_cash_flow = $operating_activities_amount + $investing_activities_amount + $financing_activities_amount;


      $html .= '<td style="border: 1px solid black;">'.$item['operating_activities_name'].'</td>';
      $html .= '<td style="border: 1px solid black;">'.htmlspecialchars(number_format($item['operating_activities_amount'], 2)).'</td>';
      $html .= '<td style="border: 1px solid black;">'.$item['investing_activities_name'].'</td>';
      $html .= '<td style="border: 1px solid black;">'.htmlspecialchars(number_format($item['investing_activities_amount'], 2)).'</td>';
      $html .= '<td style="border: 1px solid black;">'.$item['investing_activities_name'].'</td>';
      $html .= '<td style="border: 1px solid black;">'.htmlspecialchars(number_format($item['financing_activities_amount'], 2)).'</td>';
   }

   $html .= '</tr>';
}

$html .= '
<tfoot>
<tr style="background-color: green;color:white;">
<td style="border: 1px solid black;">Total Cash Flow </td>
<td style="border: 1px solid black;"> </td>
<td style="border: 1px solid black;">'.htmlspecialchars(number_format($operating_activities_amount, 2)).'</td>
<td style="border: 1px solid black;"></td>
<td style="border: 1px solid black;">'.htmlspecialchars(number_format($investing_activities_amount, 2)).'</td>
<td style="border: 1px solid black;"></td>
<td style="border: 1px solid black;">'.htmlspecialchars(number_format($financing_activities_amount, 2)).'</td>
<td style="border: 1px solid black;">'.htmlspecialchars(number_format($total_cash_flow, 2)).'</td>
</tr>
</tfoot>';

$html .= ' </tbody> </table>';

$pdf->setFooterDetails('GCM Accounting Admin', $row_dept['name']);
$pdf->writeHTML($html, true, false, false, false, '');
 $pdf->Output('Cash_Flow_Statement_data.pdf','I');

?>