<?php
session_start();

if (isset($_GET["clear"]) && $_GET["clear"] === "1") {
  unset($_SESSION["results"]);
  header("Location: results.php");
  exit;
}

$results = $_SESSION["results"] ?? [];
?>
<!DOCTYPE html>
<html>
<head>
  <title>All Results</title>
  <style>
    body{font-family:Arial;background:#f4f6f8;}
    .box{width:900px;margin:50px auto;background:#fff;padding:20px;border-radius:8px;}
    a{margin-right:10px;text-decoration:none;color:#007bff;}
    table{width:100%;border-collapse:collapse;margin-top:12px;}
    th,td{border:1px solid #ddd;padding:10px;text-align:center;}
    th{background:#eef2ff;}
    .empty{margin-top:12px;color:#555;}
    .btnClear{
      display:inline-block;margin-top:12px;padding:8px 12px;
      background:#dc3545;color:#fff;border-radius:6px;text-decoration:none;
    }
  </style>
</head>
<body>

<div class="box">
  <h2>All Students Results</h2>

  <div style="margin-bottom:12px;">
    <a href="index.php">Home</a>
    <a href="results.php">All Results</a>
  </div>

  <?php if (count($results) === 0): ?>
    <div class="empty">No results stored yet. Please calculate a grade first.</div>
  <?php else: ?>
    <table>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Sub1</th><th>Sub2</th><th>Sub3</th><th>Sub4</th><th>Sub5</th>
        <th>Total</th>
        <th>Average</th>
        <th>Grade</th>
      </tr>

      <?php foreach($results as $i => $r): ?>
        <tr>
          <td><?php echo $i+1; ?></td>
          <td><?php echo htmlspecialchars($r["name"]); ?></td>
          <td><?php echo $r["m1"]; ?></td>
          <td><?php echo $r["m2"]; ?></td>
          <td><?php echo $r["m3"]; ?></td>
          <td><?php echo $r["m4"]; ?></td>
          <td><?php echo $r["m5"]; ?></td>
          <td><?php echo $r["total"]; ?></td>
          <td><?php echo number_format($r["avg"], 2); ?></td>
          <td><b><?php echo $r["grade"]; ?></b></td>
        </tr>
      <?php endforeach; ?>
    </table>

    <a class="btnClear" href="results.php?clear=1">Clear Results</a>
  <?php endif; ?>
</div>

</body>
</html>
