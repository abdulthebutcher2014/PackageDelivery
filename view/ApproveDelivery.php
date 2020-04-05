<?php include 'header.php'; ?>
<?php include 'navigation.php'; ?>
<h1>Delivery Request Submitted</h1>
<table>
    <tr><th>Package ID:</th><th><?php echo $package_id ?></th></tr>
    <tr><th>From User:</th><th><?php echo $user_from->getName(); ?></th></tr>
    <tr><th>To User:</th><th><?php echo $user_to->getName(); ?></th></tr>
    <tr><th>From Location:</th><th><?php echo $delivery_from->getLocation(); ?></th></tr>
    <tr><th>To Location</th><th><?php echo $delivery_to->getLocation(); ?></th></tr>
    <tr><th>Total</th><th><?php echo "$".$total ?></th></tr>    
</table>
<p><?php echo $message; ?></p>
<?php include 'footer.php'; ?>