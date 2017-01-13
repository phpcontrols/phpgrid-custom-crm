<div id="menu">
    <ul>
        <li><a href="dashboard.php" <?php if($_GET['currentPage'] == 'dashboard') echo 'class="active"'; ?>>Dashboard</a></li>
        <li><a href="leads.php" <?php if($_GET['currentPage'] == 'leads') echo 'class="active"'; ?>>Leads</a></li>
        <li><a href="proposal.php" <?php if($_GET['currentPage'] == 'proposal') echo 'class="active"'; ?>>Proposals</a></li>
        <li><a href="customerwon.php" <?php if($_GET['currentPage'] == 'customerwon') echo 'class="active"'; ?>>Customers/Won</a></li>
    </ul>
</div>