<?php
 require_once '../vendor/tecnickcom/tcpdf/tcpdf.php';
 require_once '../db/db.php';


 $array_assets = [];
 $array_liabilities = [];
 $array_equity = [];
 $groupedEntries = [];
 $balance_assets = 0;
 $balance_liabilities = 0;
 $balance_equity = 0;
 $total_balance_liabilities = 0;
 $total_balance_equity = 0;
 $assets = 0;
 $cleaned_balance_liabilities = 0;
 $cleaned_balance_equity = 0;

 $itemsRef_assets = $dbh->query("SELECT * FROM `account` WHERE account_type = 'Assets'");
                    foreach ($itemsRef_assets->fetchAll(PDO::FETCH_ASSOC) as $value) {
                      
                      $array_assets[] = $value['account_name'];
                      
                    }

                    $itemsRef_liabilities = $dbh->query("SELECT * FROM `account` WHERE account_type = 'Liabilities'");
                    foreach ($itemsRef_liabilities->fetchAll(PDO::FETCH_ASSOC) as $value) {
                      
                      $array_liabilities[] = $value['account_name'];
                      
                    }

                    $itemsRef_equity =  $dbh->query("SELECT * FROM `account` WHERE account_type = 'Equity'");
                    foreach ($itemsRef_equity->fetchAll(PDO::FETCH_ASSOC) as $value) {
                      
                      $array_equity[] = $value['account_name'];
                      
                    }
 
$pdf = new TCPDF();
$pdf->SetFont('helvetica', '', 12);
$pdf->AddPage(); 
$pdf->Ln(20); // Line break

$userRef = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['id']."'");
$row_dept = $userRef->fetch(PDO::FETCH_ASSOC);

$html = '
 <h4>Balance Sheet</h4>
    <h4>'.$row_dept['name'].'</h4> 
    <table class="table" id="request" cellspacing="0" cellpadding="4">
';


$html .= '
  <thead>
                        <tr style="border: 1px solid black;">
                          <th style="border: 1px solid black;background-color:green;color:white;">Assets</th>
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
                               if (in_array($account_name, $array_assets)) {


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
                                
                                $balance_assets = intval($amount_debit - $amount_credit);
                                $characters = array(',', ' ', '-');
                                $cleaned_number_assets = str_replace($characters, '', $balance_assets); 
                                $html .= '<td style="border: 1px solid black;background-color:#f2f2f2;">'.htmlspecialchars(number_format($cleaned_number_assets, 2)).'</td>';

                                $html .= '</tr>';
                                $total_balance_assets = 0;
                                $total_balance_assets += $balance_assets;
                                $characters = array(',', ' ', '-');
                                $cleaned_number_total_assets = '';
                                $cleaned_number_total_assets = str_replace($characters, '', $total_balance_assets); 
 }}                         

 $html .= '
  <tr>
    <td style="border: 1px solid black;background-color:#f2f2f2;color:black;">Total Assets</td>
    <td style="border: 1px solid black;background-color:#f2f2f2;color:black;">'.htmlspecialchars(number_format($cleaned_number_total_assets, 2)).'</td>
  </tr>  
   </tbody>
 ';

$html .= '</table>';



$html .= '
    <table class="table" id="request" cellspacing="0" cellpadding="4">

  <thead>
                        <tr style="border: 1px solid black;">
                          <th style="border: 1px solid black;background-color:green;color:white;">Liabilities</th>
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
                               if (in_array($account_name, $array_liabilities)) {


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
                                
                                $balance_liabilities = intval($amount_debit - $amount_credit);
                                $characters = array(',', ' ', '-');
                                $cleaned_number_liabilities = str_replace($characters, '', $balance_liabilities); 
                                $html .= '<td style="border: 1px solid black;background-color:#f2f2f2;">'.htmlspecialchars(number_format($cleaned_number_liabilities, 2)).'</td>';

                                $html .= '</tr>';

                                $total_balance_liabilities += $balance_liabilities;
                                $characters = array(',', ' ', '-');
                                $cleaned_number_total_liabilities = str_replace($characters, '', $total_balance_liabilities); 
                                $cleaned_number_total_liabilities = str_replace($characters, '', $total_balance_liabilities);

 }}                         

 $html .= '
  <tr>
    <td style="border: 1px solid black;background-color:#f2f2f2;color:black;">Total Liabilities</td>
    <td style="border: 1px solid black;background-color:#f2f2f2;color:black;">'.htmlspecialchars(number_format($cleaned_number_total_liabilities, 2)).'</td>
  </tr>  
   </tbody>
 ';

$html .= '</table>';


$html .= '
    <table class="table" id="request" cellspacing="0" cellpadding="4">

  <thead>
                        <tr style="border: 1px solid black;">
                          <th style="border: 1px solid black;background-color:green;color:white;">Equity</th>
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
                               if (in_array($account_name, $array_equity)) {


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
                                
                                $balance_equity = intval($amount_debit - $amount_credit);
                                $characters = array(',', ' ', '-');
                                $cleaned_number_equity = str_replace($characters, '', $balance_equity); 
                                $html .= '<td style="border: 1px solid black;background-color:#f2f2f2;">'.htmlspecialchars(number_format($cleaned_number_equity, 2)).'</td>';

                                $html .= '</tr>';

                                $total_balance_equity += $balance_equity;
                                $characters = array(',', ' ', '-');
                                $cleaned_number_total_equity = str_replace($characters, '', $total_balance_equity); 
                                $cleaned_number_total_equity = str_replace($characters, '', $total_balance_equity);

 }}                         

 $html .= '
  <tr>
    <td style="border: 1px solid black;background-color:#f2f2f2;color:black;">Total Equity</td>
    <td style="border: 1px solid black;background-color:#f2f2f2;color:black;">'.htmlspecialchars(number_format($cleaned_number_total_equity, 2)).'</td>
  </tr>  
   </tbody>
 ';

$html .= '</table>';

$assets = $cleaned_number_total_liabilities + $cleaned_number_total_equity ;
$html .= '
    <table class="table" id="request" cellspacing="0" cellpadding="4">
       <thead>
                        <tr>
                          <th style="border: 1px solid black;background-color:green;color:white;">Computation</th>
                          <th style="border: 1px solid black;background-color:green;color:white;">Assets</th>
                        </tr>
                    </thead>

                    <tbody>
      <tr>
    <td style="border: 1px solid black;background-color:#f2f2f2;color:black;">'.$cleaned_number_total_liabilities.' + '.$cleaned_number_total_equity.'</td>
    <td style="border: 1px solid black;background-color:#f2f2f2;color:black;">'.htmlspecialchars(number_format($assets, 2)).'</td>
    </tr>  
    </tbody>
    ';
  $html .= '</table>';

$pdf->setFooterDetails('GCM Accounting Admin', $row_dept['name']);
$pdf->writeHTML($html, true, false, false, false, '');

  $pdf->Output('Balance _Sheet.pdf','I');

?>