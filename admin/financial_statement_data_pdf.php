<?php
 require_once '../tcpdf/tcpdf.php';
 require_once '../db/db.php';
 

 $array_revenue = [];
 $array_expense = [];
 $groupedEntries = [];
 $balance_revenue = 0;
 $balance_expenses = 0;
 $total_balance_revenue = 0;
 $total_balance_expenses  = 0;
 $total_balance_expense = 0;

 $itemsRef_revenue = $dbh->query("SELECT * FROM `account` WHERE account_type = 'Revenues'");
                      foreach ($itemsRef_revenue->fetchAll(PDO::FETCH_ASSOC) as $value) {
                        
                        $array_revenue[] = $value['account_name'];
                        
                      }

$itemsRef_expenses = $dbh->query("SELECT * FROM `account` WHERE account_type = 'Expenses'");
                      foreach ($itemsRef_expenses->fetchAll(PDO::FETCH_ASSOC) as $value) {
                        
                        $array_expense[] = $value['account_name'];
                        
                      }
 
$pdf = new TCPDF();
// Add a page to the PDF
$pdf->SetFont('helvetica', '', 12);
$pdf->AddPage(); 
$pdf->Ln(20); // Line break


$userRef = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['id']."'");
$row_dept = $userRef->fetch(PDO::FETCH_ASSOC);

$RevenuegroupedEntries = [];
$revenue_itemsRef = $dbh->query("SELECT * FROM `trial-data`");
// Array to track unique entries

foreach ($revenue_itemsRef->fetchAll(PDO::FETCH_ASSOC) as $item) {
    if ($item['transaction_id'] == $_GET['transaction_id']) {
        $account_name = $item['account_name'];
            if (!isset($RevenuegroupedEntries[$account_name])) {
                $RevenuegroupedEntries[$account_name][] = [];
                
}
    $RevenuegroupedEntries[$account_name][] = $item;
}}

$html = '
 <h4>Income Statement</h4>
    <h4>'.$row_dept['name'].'</h4> 
    <table class="table" id="request" cellspacing="0" cellpadding="4">
';


$html .= '
  <thead>
                        <tr style="border: 1px solid black;">
                          <th style="border: 1px solid black;background-color:green;color:white;">Revenues</th>
                          <th style="border: 1px solid black;background-color:green;color:white;">Total</th>
                        </tr>
                      </thead>
                      <tbody>
';

$trailgroupedEntries = [];
                             $trial_itemsRef = $dbh->query("SELECT * FROM `trial-data`");
                             // Array to track unique entries
         
                             foreach ($trial_itemsRef->fetchAll(PDO::FETCH_ASSOC) as $item) {
                                 if ($item['transaction_id'] == $_GET['transaction_id']) {
                                     $account_name = $item['account_name'];
                                         if (!isset($trailgroupedEntries[$account_name])) {
                                             $trailgroupedEntries[$account_name][] = [];
                                             
                             }
                                 $trailgroupedEntries[$account_name][] = $item;
                             }}
     
                             foreach ($trailgroupedEntries as $account_name => $account) {
                               $filteredArray = array_filter($account);
                               if (in_array($account_name, $array_revenue)) {


                                $html .= '
                                <tr style="border: 1px solid black;background-color:#f2f2f2;">
                                <td style="border: 1px solid black;background-color:#f2f2f2;">'. $account_name.'</td>
                                ';

                                $amount_debit = 0; $amount_credit = 0;

                                foreach ($filteredArray as $item) {
                                if ($item['type'] == 'debit') {
                                    $amount_debit += $item['account_price'];
                                }
                                elseif ($item['type'] == 'credit') {
                                    $amount_credit += $item['account_price'];
                                }

                                }
                                
                                $balance_revenue = intval($amount_debit - $amount_credit);
                                $characters = array(',', ' ', '-');
                                $cleaned_number_revenue = str_replace($characters, '', $balance_revenue); 
                                $html .= '<td style="border: 1px solid black;background-color:#f2f2f2;">'.htmlspecialchars(number_format($cleaned_number_revenue, 2)).'</td>';

                                $html .= '</tr>';
                                $total_balance_revenue = 0;
                                $total_balance_revenue += $balance_revenue;
                                $characters = array(',', ' ', '-');
                                $cleaned_number_total_revenue = '';
                                $cleaned_number_total_revenue = str_replace($characters, '', $total_balance_revenue); 
 }}                         

 $html .= '
  <tr>
    <td style="border: 1px solid black;background-color:#f2f2f2;color:black;">Total Revenues</td>
    <td style="border: 1px solid black;background-color:#f2f2f2;color:black;">'.htmlspecialchars(number_format($cleaned_number_total_revenue, 2)).'</td>
  </tr>  
   </tbody>
 ';

$html .= '</table>';



$html .= '
    <table class="table" id="request" cellspacing="0" cellpadding="4">

  <thead>
                        <tr style="border: 1px solid black;">
                          <th style="border: 1px solid black;background-color:green;color:white;">Expense</th>
                          <th style="border: 1px solid black;background-color:green;color:white;">Total</th>
                        </tr>
                      </thead>
                      <tbody>
';

$trailgroupedEntries = [];
                             $trial_itemsRef = $dbh->query("SELECT * FROM `trial-data`");
                             // Array to track unique entries
         
                             foreach ($trial_itemsRef->fetchAll(PDO::FETCH_ASSOC) as $item) {
                                 if ($item['transaction_id'] == $_GET['transaction_id']) {
                                     $account_name = $item['account_name'];
                                         if (!isset($trailgroupedEntries[$account_name])) {
                                             $trailgroupedEntries[$account_name][] = [];
                                             
                             }
                                 $trailgroupedEntries[$account_name][] = $item;
                             }}
     
                             foreach ($trailgroupedEntries as $account_name => $account) {
                               $filteredArray = array_filter($account);
                               if (in_array($account_name, $array_expense)) {


                                $html .= '
                                <tr style="border: 1px solid black;background-color:#f2f2f2;">
                                <td style="border: 1px solid black;background-color:#f2f2f2;">'. $account_name.'</td>
                                ';

                                $amount_debit = 0; $amount_credit = 0;

                                foreach ($filteredArray as $item) {
                                if ($item['type'] == 'debit') {
                                    $amount_debit += $item['account_price'];
                                }
                                elseif ($item['type'] == 'credit') {
                                    $amount_credit += $item['account_price'];
                                }

                                }
                                
                                $balance_expense = intval($amount_debit - $amount_credit);
                                $characters = array(',', ' ', '-');
                                $cleaned_number_expense = str_replace($characters, '', $balance_expense); 
                                $html .= '<td style="border: 1px solid black;background-color:#f2f2f2;">'.htmlspecialchars(number_format($cleaned_number_revenue, 2)).'</td>';

                                $html .= '</tr>';

                                $total_balance_expense += $balance_expense;
                                $characters = array(',', ' ', '-');
                                $cleaned_number_total_expense = str_replace($characters, '', $total_balance_expense); 
                                $cleaned_number_total_balance_expense = str_replace($characters, '', $total_balance_expense);

 }}                         

 $html .= '
  <tr>
    <td style="border: 1px solid black;background-color:#f2f2f2;color:black;">Total Expense</td>
    <td style="border: 1px solid black;background-color:#f2f2f2;color:black;">'.htmlspecialchars(number_format($cleaned_number_total_revenue, 2)).'</td>
  </tr>  
   </tbody>
 ';

$html .= '</table>';
$characters = array(',', ' ', '-');
 $cleaned_number_total_expense = str_replace($characters, '', $total_balance_expense); 
 $cleaned_number_total_balance_expense = str_replace($characters, '', $total_balance_expense);
$total_net_income = intval($cleaned_number_total_revenue - $cleaned_number_total_balance_expense);

$html .= '
    <table class="table" id="request" cellspacing="0" cellpadding="4">
     <tbody>
      <tr>
    <td style="border: 1px solid black;background-color:green;color:white;">Net Income</td>
    <td style="border: 1px solid black;background-color:green;color:white;">'.htmlspecialchars(number_format($total_net_income, 2)).'</td>
    </tr>  
    </tbody>
    ';
  $html .= '</table>';

  $pdf->writeHTML($html, true, false, false, false, '');
  $pdf->Output('Income_Statement.pdf','I');

?>