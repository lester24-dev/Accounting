<?php
 require_once '../fpdf/fpdf.php';
 require_once '../db/db.php';


 $array_revenue = [];
 $array_expense = [];
 $groupedEntries = [];
 $balance_revenue = 0;
 $balance_expenses = 0;
 $total_balance_revenue = 0;
 $total_balance_expenses  = 0;

 $itemsRef_revenue = $dbh->query("SELECT * FROM `account` WHERE account_type = 'Revenues'");
                      foreach ($itemsRef_revenue->fetchAll(PDO::FETCH_ASSOC) as $value) {
                        
                        $array_revenue[] = $value['account_name'];
                        
                      }

$itemsRef_expenses = $dbh->query("SELECT * FROM `account` WHERE account_type = 'Expenses'");
                      foreach ($itemsRef_expenses->fetchAll(PDO::FETCH_ASSOC) as $value) {
                        
                        $array_expense[] = $value['account_name'];
                        
                      }
 
 $pdf = new FPDF();
 $pdf->AddPage();
 $pdf->SetFont('Arial','I',9);
 $pdf->Cell(95,10,'Revenues',1,0,'C',0);
 $pdf->Cell(95,10,'Total',1,0,'C',0);
 $pdf->Ln();

 
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

 foreach ($RevenuegroupedEntries as $account_name => $account) {
   $filteredArray = array_filter($account);
   if (in_array($account_name, $array_revenue)) {

    $pdf->Cell(95,10,$account_name,1,0,'C',0);

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
    $cleaned_balance_revenue = str_replace($characters, '', $balance_revenue);
    $pdf->Cell(95,10,htmlspecialchars(number_format($cleaned_balance_revenue, 2)),1,0,'C',0);
    $pdf->Ln();

    $total_balance_revenue = '';
    $total_balance_revenue = $cleaned_balance_revenue;;
   
   }
  }

  $pdf->Cell(95,10,'Total Revenues',1,0,'C',0);
  $pdf->Cell(95,10,htmlspecialchars(number_format($total_balance_revenue, 2)),1,0,'C',0);
  $pdf->Ln();
 
  $pdf->Cell(95,10,'Expenses',1,0,'C',0);
  $pdf->Cell(95,10,'',1,0,'C',0);
  $pdf->Ln();


  $ExpensesgroupedEntries = [];
  $expenses_itemsRef = $dbh->query("SELECT * FROM `trial-data`");
  // Array to track unique entries

  foreach ($expenses_itemsRef->fetchAll(PDO::FETCH_ASSOC) as $item) {
    if ($item['transaction_id'] == $_GET['transaction_id']) {
        $account_name = $item['account_name'];
            if (!isset($ExpensesgroupedEntries[$account_name])) {
                $ExpensesgroupedEntries[$account_name][] = [];
                
}
    $ExpensesgroupedEntries[$account_name][] = $item;
}}


  foreach ($ExpensesgroupedEntries as $account_name => $account) {
   $filteredArray = array_filter($account);
   if (in_array($account_name, $array_expense)) {

    $pdf->Cell(95,10,$account_name,1,0,'C',0);

    $amount_debit = 0; $amount_credit = 0;

    foreach ($filteredArray as $item) {
    if ($item['type'] == 'debit') {
        $amount_debit += $item['account_price'];
    }
    elseif ($item['type'] == 'credit') {
        $amount_credit += $item['account_price'];
    }

    }

    $balance_expenses = intval($amount_debit - $amount_credit);
    $characters = array(',', ' ', '-');
    $cleaned_balance_expenses = str_replace($characters, '', $balance_expenses);
    $pdf->Cell(95,10,htmlspecialchars(number_format($cleaned_balance_expenses, 2)),1,0,'C',0);
    $pdf->Ln();
    
    $total_balance_expenses = '';
    $total_balance_expenses = $cleaned_balance_expenses;
  
   }
  }

  $pdf->Cell(95,10,'Total Expenses',1,0,'C',0);
  $pdf->Cell(95,10,htmlspecialchars(number_format($total_balance_expenses, 2)),1,0,'C',0);
  $pdf->Ln();


  $pdf->Cell(95,10,'Net Income',1,0,'C',0);

  $total_net_income = 0;
  $total_net_income = intval($total_balance_revenue - $total_balance_expenses);
  $pdf->Cell(95,10,htmlspecialchars(number_format($total_net_income, 2)),1,0,'C',0);
  $pdf->Ln();

  $pdf->Output('Income_Statement.pdf','D', true);

?>