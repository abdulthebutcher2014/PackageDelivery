<?php include 'header.php'; ?>
<?php include 'navigation.php'; ?>
<h1>Request Delivery</h1>

<form name="new_delivery" method="POST">
    <input type="hidden" name="action" value="approve_delivery">
    <label>Delivery From:</label><br>
    <select id="from_location" disabled>
        <option value="<?php echo $deliveries[0]; ?>"><?php echo $delivery_from->getLocation(); ?></option>        
    </select><br>
    <label>Delivery To:</label><br>
    <select id='to_location' disabled>
        <option value="<?php echo $deliveries[1]; ?>"><?php echo $delivery_to->getLocation(); ?></option>
    </select><br>
    <label>Distance (Miles):</label><br>
    <input type="text" id="distance" value="<?php echo $distance ?>" readonly><br>
    <label>Total ($):</label><br>  
    <input type="text" id="total" value="<?php echo $total ?>" readonly><br>
    <input type="hidden" name='package_id' value="package_id">

    <label>Sender:</label><br>
    <select id="to_user" disabled="">
        
            <option value="<?php echo $user_from->getID(); ?>"><?php echo $user_from->getName(); ?></option>  
      
    </select><br>
    <label>Receiver:</label><br>
    <select id="from_user" disabled="">
        
            <option value="<?php echo $user_from->getID(); ?>"><?php echo $user_from->getName(); ?></option>  
        
    </select><br>
    <a href='index.php?action=request'>Cancel</a>
     <input type="submit" name='new_delivery' value="Approve">    
</form>
<p><?php echo $message; ?></p>
<?php include 'footer.php'; ?>