<?php include 'header.php'; ?>
<?php include 'navigation.php'; ?>
<h1>Request Delivery</h1>
<p><a href='index.php?action=logout'>Logout</a><br>
    <a href='index.php?action=update_user&user=<?php echo $_SESSION['username'] ?>'>Update User Profile</a></p>
<form name="new_delivery" method="POST">
    <input type="hidden" name="action" value="new_delivery">
    <label>Delivery From:</label><br>
    <select id="from_location" disabled>
        <option value="20">Lincoln, NE</option>        
    </select><br>
    <label>Delivery To:</label><br>
    <select id="to_location">
        <?php foreach ($location as $l) : ?>
            <option value="<?php echo $l->getID(); ?>"><?php echo $l->getLocation(); ?></option>  
        <?php endforeach; ?>
    </select><br>
    <label>Distance (Miles):</label><br>
    <input type="text" id="distance" readonly><br>
    <label>Total ($):</label><br>  
    <input type="text" id="total" readonly><br>
    <input type="hidden" name='package_id' value="package_id">

    <label>Sender:</label><br>
    <select id="to_user">
        <?php foreach ($user as $u) : ?>
            <option value="<?php echo $u->getID(); ?>"><?php echo $u->getName; ?></option>  
        <?php endforeach; ?>
    </select><br>
    <label>Receiver:</label><br>
    <select id="from_user">
        <?php foreach ($user as $u) : ?>
            <option value="<?php echo $u->getID(); ?>"><?php echo $u->getName; ?></option>  
        <?php endforeach; ?>
    </select><br>
     <input type="submit" name='new_delivery' value="Submit">    
</form>
<p><?php echo $message; ?></p>
<?php include 'footer.php'; ?>