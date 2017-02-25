<?php
include_once("../phpGrid_Lite/conf.php");      
include_once('../inc/head.php');
?>

<h1>My Custom CRM</h1>

<?php
$_GET['currentPage'] = 'tasks';
include_once('../inc/menu.php');
?>

<h3><a href="tasks.php">My Current Tasks</a> | My Completed Tasks</h3>

<?php
$dg = new C_DataGrid("SELECT ID, `Date`, Contact, Todo_Type_ID, Todo_Desc_ID, Task_Status, Task_Update, Sales_Rep, Todo_Due_Date FROM notes", "ID", "notes");
$dg->set_query_filter(" Sales_Rep = 1 && Task_Status = 2");

$dg->set_col_hidden('ID')->set_col_hidden('Sales_Rep', false)->set_caption('Completed');

$dg->set_col_title('Todo_Type_ID', 'Type');
$dg->set_col_title('Todo_Desc_ID', 'Description');
$dg->set_col_title('Todo_Due_Date', 'Due Date');

$dg->set_col_edittype('Task_Status', 'select', 'SELECT ID, status FROM task_status');
$dg->set_col_edittype('Contact', 'select', 'SELECT ID, Contact_Last FROM contact');
$dg->set_col_edittype('Todo_Type_ID', 'select', 'SELECT ID, type FROM todo_type');
$dg->set_col_edittype('Todo_Desc_ID', 'select', 'SELECT ID, description FROM todo_desc');

$dg -> display();
?>


<?php
include_once('../inc/footer.php');
?>