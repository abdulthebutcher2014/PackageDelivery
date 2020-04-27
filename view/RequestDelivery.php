<?php include 'header.php'; ?>
<?php include 'navigation.php'; ?>
<h1>Request Delivery</h1>

<form name="new_delivery" method="POST">
    <input type="hidden" name="action" value="new_delivery">
    <label>Delivery From:</label><br>
    <select id="from_location" name="from_location">
        <option value="20">Lincoln, NE</option>        
    </select><br>
    <label>Delivery To:</label><br>
    <select id="to_location" name="to_location">
        <?php foreach ($location as $l) : ?>
            <option value="<?php echo $l->getID(); ?>"><?php echo $l->getLocation(); ?></option>  
        <?php endforeach; ?>
    </select><br>
    

    <label>Sender:</label><br>
    <select id="from_user" name="from_user">
        <?php foreach ($users as $u) : ?>
            <option value="<?php echo $u->getID(); ?>"><?php echo $u->getName(); ?></option>  
        <?php endforeach; ?>
    </select><br>
    <label>Receiver:</label><br>
    <select id="to_user" name="to_user">
        <?php foreach ($users as $u) : ?>
            <option value="<?php echo $u->getID(); ?>"><?php echo $u->getName(); ?></option>  
        <?php endforeach; ?>
    </select><br>
     <input type="submit" name='new_delivery' value="Submit">    
</form>
<p><?php echo $message; ?></p>
<?php include 'footer.php'; ?>