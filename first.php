<?php

$TestValue = [TRUE, FALSE, 1, 0, -1, "1", "0", "-1", NULL, array(), "php", ""];

echo "<table>";

foreach ($TestValue as $key => $value) {
    echo "<tr>";
    foreach ($TestValue as $key_plus => $value_plus) {
        if ($key === 0) {
            echo "<td>";
            var_export($value_plus);
            echo "</td>";
        } elseif ($key_plus === 0) {
            echo "<td>";
            var_export($value);
            echo "</td>";
        } else {
            echo "<td>";
            var_export($value == $value_plus);
            echo "</td>";
        }
    }
    echo "</tr>";
}

echo "</table>";

//https://sublime.wbond.net/packages/CodeFormatter
