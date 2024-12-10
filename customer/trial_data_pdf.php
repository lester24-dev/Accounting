<?php
 require_once '../tcpdf/tcpdf.php';
 require_once '../db/db.php';
 
 $pdf = new TCPDF();
 // Set font
$pdf->SetFont('helvetica', '', 12);
// Add a page to the PDF
$pdf->AddPage(); 
$pdf->Ln(20); // Line break
 
 $stmt = $dbh->query("SELECT * FROM `trial-data`");
  // Array to track unique entries
 $groupedEntries = [];
 $cleaned_number_amount_credit = 0;
 $cleaned_number_amount_debit = 0;
 $cleaned_number_total_credit = 0;
 $cleaned_number_total_debit = 0;
 $cleaned_number_amount_debittotal = 0;
 $cleaned_number_amount_credittotal = 0;

 $userRef = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['id']."'");
 $row_dept = $userRef->fetch(PDO::FETCH_ASSOC);


$html = '
<style>
</style>
<h4>Trial Balance</h4>
<h4>'.$row_dept['name'].'</h4> 
<table class="table" id="request" cellspacing="0" cellpadding="4">
                <thead>
                  <tr style="border: 1px solid black;">
                    <th style="border: 1px solid black;background-color:green;color:white;">Account Name</th>
                    <th style="border: 1px solid black;background-color:green;color:white;">Debit</th>
                    <th style="border: 1px solid black;background-color:green;color:white;">Credit</th>
                  </tr>
                </thead>
                <tbody>';


 foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
     if ($item['transaction_id'] == $_GET['transaction_id']) {
         $account_name = $item['account_name'];
             if (!isset($groupedEntries[$account_name])) {
                 $groupedEntries[$account_name][] = [];
                 
 }
     $groupedEntries[$account_name][] = $item;
 }}

    foreach($groupedEntries as $account_name => $items) {
        $filteredArray = array_filter($items);


        $html .= '
            <tr style="background-color: #f2f2f2;">
            <td style="border: 1px solid black;">'.$account_name.'</td>';


        $amount_debit_col1 = 0; $amount_credit_col1 = 0;

       foreach ($filteredArray as $item) {
        if ($item['type'] == 'debit') {
            $amount_debit_col1 += $item['account_price'];
        }
        elseif ($item['type'] == 'credit') {
            $amount_credit_col1 += $item['account_price'];
        }
      
        }
        $balance_debit = 0;
        $balance_debit = intval($amount_debit_col1 - $amount_credit_col1);

        $characters = array(',', ' ', '-');
        $cleaned_number_amount_debit = str_replace($characters, '', $balance_debit);
        $cleaned_number_amount_debittotal += str_replace($characters, '', $balance_debit);
        $html .= '<td style="border: 1px solid black;">' . htmlspecialchars(number_format($cleaned_number_amount_debit, 2)) . '</td>';


        $amount_debit = 0; $amount_credit = 0;
        foreach ($filteredArray as $item) {
         if ($item['type'] == 'debit') {
             $amount_debit += $item['account_price'];
         }
         elseif ($item['type'] == 'credit') {
             $amount_credit += $item['account_price'];
         }
       
        }
        $balance_credit = 0;
        $balance_credit = intval($amount_debit - $amount_credit);

        $characters = array(',', ' ', '-');
            $cleaned_number_amount_credit = str_replace($characters, '', $balance_credit);
            $cleaned_number_amount_credittotal += str_replace($characters, '', $balance_credit);
            $html .= '<td style="border: 1px solid black;">' . htmlspecialchars(number_format($cleaned_number_amount_credit, 2)) . '</td>';
        
        $html .= '
        </tr>
       ';
    }

    $html .= '
     <tfoot>
        <tr style="background-color: #f2f2f2;">
        <td style="border: 1px solid black;">Total Balance</td>
        <td style="border: 1px solid black;">'.htmlspecialchars(number_format($cleaned_number_amount_debittotal, 2)).'</td>
        <td style="border: 1px solid black;">'.htmlspecialchars(number_format($cleaned_number_amount_credittotal, 2)).'</td>
        </tr>
        </tfoot>
        </tbody>
     </table>';
 
$pdf->writeHTML($html, true, false, false, false, '');
 $pdf->Output('Trial_data.pdf','I');

?>