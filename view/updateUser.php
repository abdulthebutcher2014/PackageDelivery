<?php include 'header.php'; ?>
<?php include 'navigation.php';?>
<h1>The Update user page</h1>
<p><?php echo $message; ?></p>
<p><?php echo "User: " . $_SESSION['username']; ?></p>
<form name="update_user" method="POST">
    <input type="hidden" name="action" value="update_user2">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo $name ?>"><span><?php echo $errors[0]; ?></span><br>
    <label>Log-on ID:</label><br>
    <input type="text" name="logonid" value="<?php echo $logonid ?>" readonly="true"><span><?php echo $errors[1]; ?></span><br>
    <label>Email</label><br>
    <input type="text" name="email" value="<?php echo $email ?>"><span><?php echo $errors[3]; ?></span><br>
    <label>Password:</label><br>
    <input type="password" class="text" name="password" value=""><span><?php echo htmlspecialchars($errors[2]); ?></span><br>
    <label>Re-type Password:</label><br>
    <input type="password" class="text" name="password2" value=""><br><br>
    <?php if ($adminuserpermission === '1'): ?>
        <label>Administrator:</label><br>
        <input type='radio' id='administrator' name='isadmin' value='yes' <?php if ($isAdministrator == 1) {
        echo "checked";
    } ?>>
        <label for='administrator'>Yes</label> 
        <input type='radio' id='notadmin' name='isadmin' value='no' <?php if ($isAdministrator == 0) {
        echo "checked";
    } ?>>
        <label for='notadmin'>No</label><br><br>    
<?php endif; ?>     
    <input type="submit" name='update_user' value="Enter"><br>
</form>

<?php if ($adminuserpermission ==='1'): ?>  
    <table>
        <tr><th>Name</th><th>Logon ID</th><th>Administrator</th><th></th><th></th></tr>
    <?php foreach ($users as $u) : ?>
            <tr>
                <th><?php echo $u->getName(); ?></th>
                <th><?php echo $u->getLogonID(); ?></th>
                <th><?php echo $u->getIsAdministrator(); ?></th>
                <td><a href="index.php?action=update_user3&logonid=<?php echo $u->getLogonID(); ?>">Edit</a></td>
                <td><a href="index.php?action=delete_user&logonid=<?php echo $u->getLogonID(); ?>">Delete</a></td>
            </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>
<?php include 'footer.php'; ?>