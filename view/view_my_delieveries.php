<?php include 'header.php'; ?>
<?php include 'navigation.php'; ?>
<h1>My Deliveries</h1>
<p><?php echo $user;  ?>
<h2>My incoming deliveries</h2>
<table>
    <tr><th>ID</th><th>Name</th><th>City</th><th>State</th><th>Package#</th><th>Status</th></tr>
    <?php foreach ($incoming_deliveries as $d) : ?>
        <tr>
            <th><?php echo $d->getID(); ?></th>
            <th><?php echo $d->getName(); ?></th>
            <th><?php echo $d->getCity(); ?></th>
            <th><?php echo $d->getState(); ?></th>
            <th><?php echo $d->getPackageID(); ?></th>
            <th><?php echo $d->getStatus(); ?></th>

        </tr>
    <?php endforeach; ?>
</table>
<h2>My outgoing deliveries</h2>
<table>
    <tr><th>ID</th><th>Name</th><th>City</th><th>State</th><th>Package#</th><th>Status</th></tr>
    <?php foreach ($outgoing_deliveries as $d) : ?>
        <tr>
            <th><?php echo $d->getID(); ?></th>
            <th><?php echo $d->getName(); ?></th>
            <th><?php echo $d->getCity(); ?></th>
            <th><?php echo $d->getState(); ?></th>
            <th><?php echo $d->getPackageID(); ?></th>
            <th><?php echo $d->getStatus(); ?></th>         
        </tr>

    <?php endforeach; ?>
</table>
<?php include 'footer.php'; ?>


