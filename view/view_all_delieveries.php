<?php include 'header.php'; ?>
<?php include 'navigation.php'; ?>
<h1>All Deliveries</h1>
<p>User: <?php echo $userid; ?></p>
<h2>All Deliveries</h2>
<table>
    <tr><th>ID</th><th>Name</th><th>City</th><th>State</th><th>Package#</th><th>Status</th><th>Action</th></tr>
    <?php foreach ($all_deliveries as $d) : ?>
        <form action='.' method='post' id='login_form' class='aligned'>
            <tr>
                <th><?php echo $d->getID(); ?></th>
                <th><?php echo $d->getName(); ?></th>
                <th><?php echo $d->getCity(); ?></th>
                <th><?php echo $d->getState(); ?></th>
                <th><?php echo $d->getPackageID(); ?></th>
                <th><?php echo $d->getStatus(); ?></th>
                <th><input type="submit" value="<?php if($d->getStatus()=="Recieved"){echo "Sent";}elseif ($d->getStatus()=="Sent"){echo "Delivered";} else{echo "Thanks";}?>" <?php if($d->getStatus()=="Delivered"){echo "disabled";}?>></th>
                <input type='hidden' name='status' value='<?php echo $d->getStatus(); ?>'>
                <input type='hidden' name='package_id' value='<?php echo $d->getPackageID(); ?>'>
                <input type='hidden' name='action' value='update_package'>
            </tr>
        </form>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>


