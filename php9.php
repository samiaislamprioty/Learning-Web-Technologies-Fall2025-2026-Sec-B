<form method="post">
    <input type="text" name="username">
    <input type="submit">
</form>

<?php
if(isset($_POST['username'])){
    echo $_POST['username'];
}
?>
<?php