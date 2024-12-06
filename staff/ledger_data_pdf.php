<?php
 require_once '../fpdf/fpdfs.php';
 require_once '../db/firebaseDB.php';
 
 $pdf = new FPDF();
 $pdf->addPage('L');
 $pdf->SetFont('Arial','I',9);
 $pdf->Cell(40,10,'Date',1,0,'C',0);
 $pdf->Cell(60,10,'Account Debit',1,0,'C',0);
 $pdf->Cell(40,10,'Debit',1,0,'C',0);
 $pdf->Cell(60,10,'Account Credit',1,0,'C',0);
 $pdf->Cell(40,10,'Credit',1,0,'C',0);
 $pdf->Cell(40,10,'Balance',1,0,'C',0);
 $pdf->Ln();
 
 $fetchdata = $realtimeDatabase->getReference("journal-data")->orderByChild('date')->getValue();
 $groupedEntries  = [];
 foreach ($fetchdata as $item) {
    if ($item['transaction_id'] === $_GET['transaction_id']) {
        $date = $item['date'];
            if (!isset($groupedEntries[$date])) {
                $groupedEntries[$date][] = [];
                
}
    $groupedEntries[$date][] = $item;
}}

    foreach($groupedEntries as $date => $item) {
        $filteredArray = array_filter($item);

        $pdf->Cell(40,10,$date,1,0,'C',0);
        foreach ($filteredArray as $value) {
            $account_debit = '';
            $amount_debit = '';
            $account_credit = '';
            $amount_credit = '';
            $total_balance = '';

            $characters = array(',', '.', ' ', '-');
            $account_debit = $value['account_debit'];
            $amount_debit   = $value['amount_debit'];
            $account_credit = $value['account_credit'];
            $amount_credit   = $value['amount_credit'];
            $total_balance = intval($amount_debit - $amount_credit);
        }
        $pdf->Cell(60,10, $account_debit,1,0,'C',0);
        $pdf->Cell(40,10,$amount_debit,1,0,'C',0);
        $pdf->Cell(60,10, $account_credit ,1,0,'C',0);
        $pdf->Cell(40,10,$amount_credit,1,0,'C',0);
        $pdf->Cell(40,10,htmlspecialchars(number_format(str_replace($characters, '', $total_balance), 2)),1,0,'C',0);

        $pdf->Ln();
       
    }

 
 $pdf->Output('Ledger_data.pdf','D', true);

?>