<?php include 'header.php'; ?>
<p><?php echo $message;?></p>
<p><a href='index.php?action=update_user&id=<?php echo $_SESSION['user']?>'>Edit User profile</a></p>
<h1>The Delivery Form</h1>
<?php include 'footer.php'; ?>