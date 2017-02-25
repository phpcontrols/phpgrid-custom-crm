<?php
include_once("../phpGrid_Lite/conf.php");      
include_once('../inc/head.php');
?>

<h1>My Custom CRM</h1>

<?php
$_GET['currentPage'] = 'tasks';
include_once('../inc/menu.php');
?>

<h3>My Current Tasks | <a href="tasks-completed.php">My Completed Tasks</a></h3>

<?php
$dg = new C_DataGrid("SELECT ID, `Date`, contact, todo_type_id, todo_desc_id, task_status, Task_Update, sales_rep, todo_due_date FROM notes", "ID", "notes");
$dg->set_query_filter(" sales_rep = 1 && task_status != 2");

$dg->set_col_hidden('ID')->set_col_hidden('sales_rep', false)->set_caption('Current');

$dg->set_col_title('todo_type_id', 'Type');
$dg->set_col_title('todo_desc_id', 'Description');
$dg->set_col_title('todo_due_date', 'Due Date');

$dg->set_col_edittype('task_status', 'select', 'SELECT ID, status FROM task_status');
$dg->set_col_edittype('contact', 'select', 'SELECT ID, Contact_Last FROM contact');
$dg->set_col_edittype('todo_type_id', 'select', 'SELECT ID, Type FROM todo_type');
$dg->set_col_edittype('todo_desc_id', 'select', 'SELECT ID, Description FROM todo_desc');

$dg->add_column("actions", array('name'=>'actions',
    'index'=>'actions',
    'width'=>'70',
    'formatter'=>'actions',
    'formatoptions'=>array('keys'=>true, 'editbutton'=>true, 'delbutton'=>false)),'Actions');

$dg->set_col_readonly('Date, contact, todo_type_id, todo_desc_id, sales_rep, todo_due_date');

$dg->enable_edit('INLINE');
$dg -> display();
?>


<?php
include_once('../inc/footer.php');
?>