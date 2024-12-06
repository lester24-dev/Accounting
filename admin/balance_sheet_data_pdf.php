<?php
 require_once '../fpdf/fpdf.php';
 require_once '../db/db.php';


 $array_assets = [];
 $array_liabilities = [];
 $array_equity = [];
 $groupedEntries = [];
 $balance_assets = 0;
 $balance_liabilities = 0;
 $balance_equity = 0;

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
 
 $pdf = new FPDF();
 $pdf->AddPage();
 $pdf->SetFont('Arial','I',9);
 $pdf->Cell(95,10,'Assets',1,0,'C',0);
 $pdf->Cell(95,10,'Total',1,0,'C',0);
 $pdf->Ln();

 
 $AssetsgroupedEntries = [];
 $assets_itemsRef = $dbh->query("SELECT * FROM `trial-data`");

 foreach ($assets_itemsRef->fetchAll(PDO::FETCH_ASSOC) as $item) {
     if ($item['transaction_id'] == $_GET['transaction_id']) {
         $account_name = $item['account_name'];
             if (!isset($AssetsgroupedEntries[$account_name])) {
                 $AssetsgroupedEntries[$account_name][] = [];
                 
 }
     $AssetsgroupedEntries[$account_name][] = $item;
 }}

 foreach ($AssetsgroupedEntries as $account_name => $account) {
   $filteredArray = array_filter($account);
   if (in_array($account_name, $array_assets)) {

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
    $balance_assets = 0;
    $balance_assets = intval($amount_debit - $amount_credit);
    $characters = array(',', ' ', '-');
    $cleaned_number_assets = str_replace($characters, '', $balance_assets);
    $pdf->Cell(95,10,htmlspecialchars(number_format($cleaned_number_assets, 2)),1,0,'C',0);
    $pdf->Ln();

    $total_balance_assets = 0;
    $total_balance_assets += $balance_assets;
    $pdf->Cell(95,10,'Total Assets',1,0,'C',0);
    $characters = array(',', ' ', '-');
    $cleaned_number_total_assets = str_replace($characters, '', $total_balance_assets);
    $pdf->Cell(95,10,htmlspecialchars(number_format($cleaned_number_total_assets, 2)),1,0,'C',0);
    $pdf->Ln();
   }
  }
 
  $pdf->Cell(95,10,'Liabilities',1,0,'C',0);
  $pdf->Cell(95,10,'Total',1,0,'C',0);
  $pdf->Ln();


  $LiabilitiesgroupedEntries = [];
  $liabilities_itemsRef = $dbh->query("SELECT * FROM `trial-data`");

  foreach ($liabilities_itemsRef->fetchAll(PDO::FETCH_ASSOC) as $item) {
    if ($item['transaction_id'] == $_GET['transaction_id']) {
        $account_name = $item['account_name'];
            if (!isset($LiabilitiesgroupedEntries[$account_name])) {
                $LiabilitiesgroupedEntries[$account_name][] = [];
                
}
    $LiabilitiesgroupedEntries[$account_name][] = $item;
}}


  foreach ($LiabilitiesgroupedEntries as $account_name => $account) {
   $filteredArray = array_filter($account);
   if (in_array($account_name, $array_liabilities)) {

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

    $balance_liabilities = intval($amount_debit - $amount_credit);
    $characters = array(',', ' ', '-');
    $cleaned_number_liabilities = str_replace($characters, '', $balance_liabilities); 
    $pdf->Cell(95,10,htmlspecialchars(number_format($cleaned_number_liabilities, 2)),1,0,'C',0);
    $pdf->Ln();

    $total_balance_liabilities = 0;
    $total_balance_liabilities += $balance_liabilities;
    $pdf->Cell(95,10,'Total Liabilities',1,0,'C',0);
    $characters = array(',', ' ', '-');
    $cleaned_number_total_liabilities = str_replace($characters, '', $total_balance_liabilities); 
    $pdf->Cell(95,10,htmlspecialchars(number_format($cleaned_number_total_liabilities, 2)),1,0,'C',0);
    $pdf->Ln();

   }
  }

  $pdf->Cell(95,10,'Equity',1,0,'C',0);
  $pdf->Cell(95,10,'Total',1,0,'C',0);

  $EquitygroupedEntries = [];
  $equity_itemsRef = $dbh->query("SELECT * FROM `trial-data`");

  foreach ($equity_itemsRef->fetchAll(PDO::FETCH_ASSOC) as $item) {
    if ($item['transaction_id'] == $_GET['transaction_id']) {
        $account_name = $item['account_name'];
            if (!isset($EquitygroupedEntries[$account_name])) {
                $EquitygroupedEntries[$account_name][] = [];
                
}
    $EquitygroupedEntries[$account_name][] = $item;
}}


  foreach ($EquitygroupedEntries as $account_name => $account) {
    $filteredArray = array_filter($account);
    if (in_array($account_name, $array_equity)) {
  

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
      $balance_equity = 0;
      $balance_equity = intval($amount_debit - $amount_credit);
      $characters = array(',', ' ', '-');
      $cleaned_number_equity = str_replace($characters, '', $balance_equity); 
      $pdf->Cell(95,10,htmlspecialchars(number_format($cleaned_number_equity, 2)),1,0,'C',0);
      $pdf->Ln();
  
      $total_balance_equity = 0;
      $total_balance_equity += $balance_equity;
      $pdf->Cell(95,10,'Total Equity',1,0,'C',0);
      $characters = array(',', ' ', '-');
      $cleaned_number_total_equity = str_replace($characters, '', $total_balance_equity); 
      $pdf->Cell(95,10,htmlspecialchars(number_format($cleaned_number_total_equity, 2)),1,0,'C',0);
      $pdf->Ln();

    }};

  $pdf->Output('Income_Statement.pdf','D', true);

?>