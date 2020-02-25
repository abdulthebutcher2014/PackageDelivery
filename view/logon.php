<?php include 'header.php'; ?>

<p><a href='index.php?action=register'>Register Here</a></p>
<p><?php echo $error_message ?></p>
<form action='.' method='post' id='login_form' class='aligned'>
    <input type='hidden' name='action' value='login'>
    <label> UserID: </label>
    <input type="text" name ="userid" 
           value="<?php htmlspecialchars("userid") ?>">

    <br> 
    <label>Password: </label>
    <input type="password" class="text" name="password">
    <br>

    <label>&nbsp;</label>

    <input type="submit" value="Login">
    <input type ="hidden" name="login">
</form>
<?php include 'footer.php'; ?>


