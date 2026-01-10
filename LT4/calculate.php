<?php
session_start();

function clean($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function isValidMark($m){
  if ($m === "") return false;
  if (!is_numeric($m)) return false;
  $v = (float)$m;
  return ($v >= 0 && $v <= 100);
}

function gradeFromAvg($avg){
  if ($avg >= 90) return "A";
  if ($avg >= 80) return "B";
  if ($avg >= 70) return "C";
  if ($avg >= 60) return "D";
  return "F";
}

$name = trim($_POST["student_name"] ?? "");
$m1 = trim($_POST["m1"] ?? "");
$m2 = trim($_POST["m2"] ?? "");
$m3 = trim($_POST["m3"] ?? "");
$m4 = trim($_POST["m4"] ?? "");
$m5 = trim($_POST["m5"] ?? "");

$errors = [];

// Validate all fields
if ($name === "") $errors[] = "Student name is required.";

$marks = [$m1,$m2,$m3,$m4,$m5];
for ($i=0; $i<5; $i++){
  if (!isValidMark($marks[$i])) {
    $errors[] = "Subject ".($i+1)." marks must be a number between 0 and 100.";
  }
}

if (count($errors) > 0) {
  // Show errors + navigation
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>Grade Result</title>
    <style>
      body{font-family:Arial;background:#f4f6f8;}
      .box{width:520px;margin:50px auto;background:#fff;padding:20px;border-radius:8px;}
      a{margin-right:10px;text-decoration:none;color:#007bff;}
      .err{background:#f8d7da;color:#721c24;padding:10px;border-radius:6px;margin-top:10px;}
      ul{margin:10px 0 0 18px;}
    </style>
  </head>
  <body>
  <div class="box">
    <h2>Validation Errors</h2>
    <div style="margin-bottom:12px;">
      <a href="index.php">Home</a>
      <a href="results.php">All Results</a>
    </div>

    <div class="err">
      <b>Please fix these issues:</b>
      <ul>
        <?php foreach($errors as $e){ echo "<li>".htmlspecialchars($e)."</li>"; } ?>
      </ul>
    </div>
  </div>
  </body>
  </html>
  <?php
  exit;
}

// Calculate total & average
$total = 0;
foreach($marks as $m){ $total += (float)$m; }
$avg = $total / 5;
$grade = gradeFromAvg($avg);

// Store to session (multiple students)
if (!isset($_SESSION["results"])) {
  $_SESSION["results"] = [];
}

$_SESSION["results"][] = [
  "name" => clean($name),
  "m1" => (float)$m1,
  "m2" => (float)$m2,
  "m3" => (float)$m3,
  "m4" => (float)$m4,
  "m5" => (float)$m5,
  "total" => $total,
  "avg" => $avg,
  "grade" => $grade
];

?>
<!DOCTYPE html>
<html>
<head>
  <title>Grade Result</title>
  <style>
    body{font-family:Arial;background:#f4f6f8;}
    .box{width:680px;margin:50px auto;background:#fff;padding:20px;border-radius:8px;}
    a{margin-right:10px;text-decoration:none;color:#007bff;}
    table{width:100%;border-collapse:collapse;margin-top:12px;}
    th,td{border:1px solid #ddd;padding:10px;text-align:center;}
    th{background:#eef2ff;}
    .ok{background:#d4edda;color:#155724;padding:10px;border-radius:6px;margin-top:10px;}
  </style>
</head>
<body>

<div class="box">
  <h2>Grade Calculation Result</h2>

  <div style="margin-bottom:12px;">
    <a href="index.php">Home</a>
    <a href="results.php">All Results</a>
  </div>

  <div class="ok">
    <b>Saved!</b> This student's result has been stored in session.
  </div>

  <table>
    <tr>
      <th>Student</th>
      <th>Sub1</th><th>Sub2</th><th>Sub3</th><th>Sub4</th><th>Sub5</th>
      <th>Total</th>
      <th>Average</th>
      <th>Grade</th>
    </tr>
    <tr>
      <td><?php echo htmlspecialchars(clean($name)); ?></td>
      <td><?php echo (float)$m1; ?></td>
      <td><?php echo (float)$m2; ?></td>
      <td><?php echo (float)$m3; ?></td>
      <td><?php echo (float)$m4; ?></td>
      <td><?php echo (float)$m5; ?></td>
      <td><?php echo $total; ?></td>
      <td><?php echo number_format($avg, 2); ?></td>
      <td><b><?php echo $grade; ?></b></td>
    </tr>
  </table>
</div>

</body>
</html>
