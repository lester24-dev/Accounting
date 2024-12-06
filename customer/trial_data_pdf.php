<?php
 require_once '../fpdf/fpdfs.php';
 require_once '../db/db.php';
 
 $pdf = new FPDF();
 $pdf->addPage('L');
 $pdf->SetFont('Arial','I',9);
 $pdf->Cell(90,10,'Account Name',1,0,'C',0);
 $pdf->Cell(90,10,'Debit',1,0,'C',0);
 $pdf->Cell(90,10,'Credit',1,0,'C',0);
 $pdf->Ln();
 
 $stmt = $dbh->query("SELECT * FROM `trial-data`");
  // Array to track unique entries
 $groupedEntries = [];
 $cleaned_number_amount_credit = 0;
 $cleaned_number_amount_debit = 0;
 $cleaned_number_total_credit = 0;
 $cleaned_number_total_debit = 0;
 $cleaned_number_amount_debittotal = 0;
 $cleaned_number_amount_credittotal = 0;


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
        
        $pdf->Cell(90,10,$account_name,1,0,'C',0);

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

        if ($balance_debit < 0) {
            $pdf->Cell(90,10,htmlspecialchars(number_format(0, 2)),1,0,'C',0);
        } else {
            $characters = array(',', ' ', '-');
            $cleaned_number_amount_debit = str_replace($characters, '', $balance_debit);
            $cleaned_number_amount_debittotal += str_replace($characters, '', $balance_debit);
            $pdf->Cell(90,10,htmlspecialchars(number_format($cleaned_number_amount_debit, 2)),1,0,'C',0);
        }


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

        if ($balance_credit < 0) {
            $characters = array(',', ' ', '-');
            $cleaned_number_amount_credit = str_replace($characters, '', $balance_credit);
            $cleaned_number_amount_credittotal += str_replace($characters, '', $balance_credit);
            $pdf->Cell(90,10,htmlspecialchars(number_format($cleaned_number_amount_credit, 2)),1,0,'C',0);
        } else {
            $characters = array(',', ' ', '-');
            $pdf->Cell(90,10,htmlspecialchars(number_format(0, 2)),1,0,'C',0);
        }
            
        $pdf->Ln();
    }

   


    $pdf->Cell(90,10,'Total Balance',1,0,'C',0);
    $pdf->Cell(90,10,htmlspecialchars(number_format($cleaned_number_amount_debittotal, 2)),1,0,'C',0);
    $pdf->Cell(90,10,htmlspecialchars(number_format($cleaned_number_amount_credittotal, 2)),1,0,'C',0);
 
 $pdf->Output('Trial_data.pdf','D', true);

?>