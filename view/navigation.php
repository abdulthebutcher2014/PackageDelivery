<nav>
<ul>
<li><a href='index.php?action=request'>Request Package Delivery</a></li>
<li><a href='index.php?action=update_user'>User Profile</a></li>
<?php if($adminuserpermission === '1'):?>
<li><a href='index.php?action=parameters'>Configuration</a></li>
<li><a href='index.php?action=locations'>Locations</a></li>
<li><a href='index.php?action=all_deliveries'>All Deliveries</a></li>
<?php endif; ?>
<li><a href='index.php?action=view_my_deliveries'>My Deliveries</a></li>
<li><a href="index.php?action=logout">Logout</a></li>
</ul>
</nav>
