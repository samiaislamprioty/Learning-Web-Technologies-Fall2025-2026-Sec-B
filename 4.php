<?php

$num1 = 10;
$num2 = 25;
$num3 = 17;

echo "Given Numbers: $num1, $num2, $num3 <br><br>";

if ($num1 >= $num2 && $num1 >= $num3) {
    echo "The largest number is: $num1";
}
else if ($num2 >= $num1 && $num2 >= $num3) {
    echo "The largest number is: $num2";
}
else {
    echo "The largest number is: $num3";
}

?>
