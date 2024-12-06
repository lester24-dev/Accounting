<?php 
include('../db/firebaseDB.php');

if (isset($_GET['transaction_id'])) {
    $itemsRef = $realtimeDatabase->getReference('journal-data');

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
        $html = null;
        $html .= '
        <tr>
        <td>'.$date.'</td>
        <td>
        ';
        foreach ($filteredArray as $item) {
           $html .= ''. $item['account_debit'] . '<br> <br>';
        }
        $html .= '</td>
                <td>';
        foreach ($filteredArray as $item) {
            $html .= '&#8369;'. htmlspecialchars(number_format($item['amount_debit'], 2)) . '<br> <br>';
        }
        $html .= '</td>
                <td>';
        foreach ($filteredArray as $item) {
            $html .= ''. $item['account_credit'] . '<br> <br>';
        }
        $html .= '</td>
                  <td>';
        foreach ($filteredArray as $item) {
            $html .= '&#8369;'. htmlspecialchars(number_format($item['amount_credit'], 2)) . '<br> <br>';
        }
        $html .= '</td>
                  <td>';
        $html .= '

            </tr>
        ';
    }
    
    echo $html;
}

    ?>