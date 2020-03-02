<?php include 'header.php'; ?>
<h1>The Delivery Form</h1>
<p><a href='index.php?action=logout'>Logout</a><br>
    <a href='index.php?action=update_user&user=<?php echo $_SESSION['username']?>'>Update User Profile</a></p>
<p><?php echo $message;?></p>
<?php include 'footer.php'; ?>