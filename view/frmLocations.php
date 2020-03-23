<?php include 'header.php'; ?>
<?php include 'navigation.php'; ?>
<h1>Locations</h1>
<p><?php echo $message; ?></p>
<p><?php echo "User: " . $_SESSION['username']; ?></p>

<form name="locations" method="POST">

    <input type="hidden" name="action" value="add_location">
    
    <label>City:</label><br>
    <input type="text" name="city" maxlength="20" value="<?php echo $city ?>"<span><?php echo $errors[0];?></span><br>
    <label>State:</label><br>
    <input type="text" name="state" maxlength="2" value="<?php echo $state ?>"<span><?php echo $errors[1];?></span><br>
    <label>Distance:</label><br>
    <input type="text" name="distance" value="<?php echo $distance ?>"><span><?php echo $errors[2];?></span><br>
    
  
    <input type="submit" name="parameters" value="Update Location">
    
</form>
 
    <table>
        <tr><th>City</th><th>State</th><th>Distance</th><th></th><th></th></tr>
    <?php foreach ($locations as $l) : ?>
            <tr>
                <th><?php echo $l->getCity(); ?></th>
                <th><?php echo $l->getState(); ?></th>
                <th><?php echo $l->getDistance(); ?></th>
                <td><a href="index.php?action=update_location&location_id=<?php echo $l->getID(); ?>">Edit</a></td>
                <td><a href="index.php?action=delete_location&location_id=<?php echo $l->getID(); ?>">Delete</a></td>
            </tr>
    <?php endforeach; ?>
    </table>

<?php include 'footer.php'; ?>
