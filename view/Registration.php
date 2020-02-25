<?php include 'header.php'; ?>
<h1>The Registration Form</h1>
<form name="new_user" method="POST">
    <input type="hidden" name="action" value="new_user">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo $name ?>"><span><?php echo $errors[0];?></span><br>
    <label>User ID:</label><br>
    <input type="text" name="logonid" value="<?php echo $logonid ?>"><span><?php echo $errors[1];?></span><br>
    <label>Password:</label><br>
    <input type="password" class="text" name="password" value="<?php echo $password ?>"><span><?php echo $errors[2];?></span><br><br>
    <input type="submit" name='new_user' value="Enter">
</form>
<?php include 'footer.php'; ?>
