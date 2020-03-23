<?php include 'header.php'; ?>
<?php include 'navigation.php'; ?>
<h1>Set Delivery Rates</h1>
<p><?php echo $message; ?></p>
<p><?php echo "User: " . $_SESSION['username']; ?></p>
<form name="parameters" method="POST">
    <input type="hidden" name="action" value="parameters2">
    <label>Initial Price for Delivery:</label><br>
    <input type="text" name="baseprice" value="<?php echo $baseprice ?>"<span><?php echo $errors[0];?></span><br>
    <label>Milage Rate for Delivery:</label><br>
    <input type="text" name="milagerate" value="<?php echo $milagerate ?>"<span><?php echo $errors[1];?></span><br>
    <input type="submit" name="parameters" value="Set Parameters">
</form>
<?php include 'footer.php'; ?>
