<div id="menu">
    <ul>
        <li><a href="tasks.php" <?php if($_GET['currentPage'] == 'tasks') echo 'class="active"'; ?>>Tasks</a></li>
        <li><a href="leads.php" <?php if($_GET['currentPage'] == 'leads') echo 'class="active"'; ?>>Leads</a></li>
        <li><a href="proposal.php" <?php if($_GET['currentPage'] == 'proposal') echo 'class="active"'; ?>>Proposals</a></li>
        <li><a href="customerwon.php" <?php if($_GET['currentPage'] == 'customerwon') echo 'class="active"'; ?>>Customers/Won</a></li>
    </ul>
</div>