<?php

// Array of elements
$numbers = array(10, 20, 30, 40, 50, 60);

// Element to search
$search = 40;

$found = false;

echo "Array Elements: ";
foreach ($numbers as $n) {
    echo $n . " ";
}

echo "<br><br>Searching for: $search <br><br>";


for ($i = 0; $i < count($numbers); $i++) {
    if ($numbers[$i] == $search) {
        $found = true;
        break;
    }
}


if ($found) {
    echo "Element $search FOUND in the array!";
} else {
    echo "Element $search NOT FOUND in the array.";
}

?>
