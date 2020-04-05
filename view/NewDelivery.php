<?php include 'header.php'; ?>
<?php include 'navigation.php'; ?>
<h1>Request Delivery</h1>

<form name="new_delivery" method="POST">
    <input type="hidden" name="action" value="approve_delivery">
    <label>Delivery From:</label><br>
    <select id="from_location" disabled>
        <option value="<?php echo $deliveries[0]; ?>" selected><?php echo $delivery_from->getLocation(); ?></option>        
    </select><br>
    <input type="hidden" name="from_location" value="<?php echo $delivery_from->getID(); ?>"
    <label>Delivery To:</label><br>
    <select id='to_location' name="to_location" disabled>
        <option value="<?php echo $deliveries[1]; ?>" selected><?php echo $delivery_to->getLocation(); ?></option>
    </select><br>
    <input type="hidden" name="to_location" value="<?php echo $delivery_to->getID(); ?>"
    <label>Distance (Miles):</label><br>
    <input type="text" id="distance" value="<?php echo $distance ?>" name="distance" readonly><br>
    <label>Total ($):</label><br>  
    <input type="text" id="total" value="<?php echo $total ?>" name="total" readonly><br>
    

    <label>Sender:</label><br>
    <select id="to_user" disabled="" name="to_user">
        
        <option value="<?php echo $user_from->getID(); ?>" selected><?php echo $user_from->getName(); ?></option>  
      
    </select><br>
    <input type="hidden" name="from_user" value="<?php echo $user_from->getID(); ?>">
    <label>Receiver:</label><br>
    <select id="from_user" disabled="" name="from_user">        
            <option value="<?php echo $user_from->getID(); ?>" selected><?php echo $user_from->getName(); ?></option>         
    </select><br>
    <input type="hidden" name="to_user" value="<?php echo $user_to->getID(); ?>">
    <a href='index.php?action=request'>Cancel</a>
     <input type="submit" name='new_delivery' value="Approve">    
</form>
<p><?php echo $message; ?></p>
<?php include 'footer.php'; ?>