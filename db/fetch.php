<?php 
include('firebaseDB.php');

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
       
    }
    
    echo json_encode($filteredArray);
}

?>