<?php

/**
 * Implements hook_block_info().
 */
function isisCB_data_to_table_block_info() {
    $blocks['isisCB_data_to_table'] = array(
        'info' => t('IsisCB Data to Table'),
        'cache' => DRUPAL_NO_CACHE,
        );
    return $blocks;
}

/**
 * Implements hook_block_view().
 */
function isisCB_data_to_table_block_view($delta = '') {
    $block = array();
    switch ($delta) {
        case 'isisCB_data_to_table':
           
            $content = isisCB_data_parse();
            
            $block['subject'] = t('Block Title');
            $block['content'] = $content;
            break;
    }
    return $block;
}

/**
 * Calls API and parses date into table
 */
function isisCB_data_parse() {
    
    //I need to pull the Authority record ID from one of the fields and pass it into the http call
    
    $json=file_get_contents("http://data.isiscb.org/rest/authority/CBA000058454/");
    $data =  json_decode($json);
    
    if (count($data->related_citations)) {
        // Open the table
        echo "<table>";
        
        // Cycle through the array, I'm not sure this foreach loop will work with the formatting of the isisCB json
        foreach ($data->related_citations as $idx => $related_citations) {
            
            // Output a row
            echo "<tr>";
            echo "<td>$related_citations->citation</td>";
            echo "</tr>";
        }
        
        // Close the table
        echo "</table>";
    }
}
