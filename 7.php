<?php

for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "* ";
    }
    echo "<br>";
}

?>


<?php

for ($i = 3; $i >= 1; $i--) {   // rows: 3, 2, 1
    for ($j = 1; $j <= $i; $j++) {
        echo $j . " ";
    }
    echo "<br>";
}

?>


<?php

$char = 'A'; // start letter

for ($i = 1; $i <= 3; $i++) {    // rows
    for ($j = 1; $j <= $i; $j++) {
        echo $char . " ";
        $char++; // move to next letter
    }
    echo "<br>";
}

?>
