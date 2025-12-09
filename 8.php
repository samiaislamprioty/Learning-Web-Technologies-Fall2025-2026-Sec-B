<?php
$array = [
    [1, 2, 3, 'A'],
    [1, 2, 'B', 'C'],
    [1, 'D', 'E', 'F']
];
?>

<?php
for($i = 0; $i < 3; $i++){
    for($j = 0; $j < 3 - $i; $j++){
        echo $array[$i][$j] . " ";
    }
    echo "<br>";
}
?>

<?php
$letters = ['A','B','C','D','E','F'];
$index = 0;

for($i = 1; $i <= 3; $i++){
    for($j = 1; $j <= $i; $j++){
        echo $letters[$index] . " ";
        $index++;
    }
    echo "<br>";
}
?>
