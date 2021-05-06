<?php

// $inc_data = [
//     "a",
//     "b",
//     "c",
//     [
//         "d",
//         "e"
//     ]
// ];

/**
 * Generates table content from $inc_data, does not generate table object iself nor headers
 */

if (isset($inc_data) && (gettype($inc_data)) === "array") {

    for ($i=0; $i < count($inc_data); $i++) { 
        if (gettype($inc_data[$i]) === "array") {
            echo "<tr>";
            for ($j=0; $j < count($inc_data[$i]); $j++) { 
                echo "<td>" . $inc_data[$i][$j] . "</td>";
            }
            echo "</tr>";
        } else {
            echo "<tr><td>" . $inc_data[$i] . "</td></tr>";
        }
    }

}

?>