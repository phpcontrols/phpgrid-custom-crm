<?php
use phpGrid\C_DataGrid;

require_once("../phpGrid/conf.php");      

include_once('../inc/head.php');
?>

<h1>Custom CRM</h1>

<?php
$_GET['currentPage'] = 'tasks';
include_once('../inc/menu.php');
?>

<h2>Welcome to the CRM Dashboard</h1>
<div>
Choose an option from the menu above or view your current tasks below.
</div>

<br />

<h3>My Current Tasks</h2>
<?php
$dg = new C_DataGrid("SELECT ID, `Date`, contact, todo_type_id, todo_desc_id, task_status, Task_Update, sales_rep, Todo_Due_Date FROM notes", "ID", "notes");
$dg->set_query_filter(" sales_rep = 1 && task_status != 2");

$dg->set_col_hidden('ID')->set_col_hidden('sales_rep', false)->set_caption(' ');

$dg->set_col_title('todo_type_id', 'Todo Type');
$dg->set_col_title('todo_desc_id', 'Description');

$dg->set_col_edittype('task_status', 'select', 'SELECT ID, status FROM task_status');
$dg->set_col_edittype('contact', 'select', 'SELECT ID, Contact_Last FROM Contact');
$dg->set_col_edittype('todo_type_id', 'select', 'SELECT ID, Type FROM todo_type');
$dg->set_col_edittype('todo_desc_id', 'select', 'SELECT ID, Description FROM todo_desc');

/*
$col_formatter = <<<COLFORMATTER
function(cellvalue, options, rowObject){
n1 = parseInt(rowObject[0]); 
return n1+n2;     
}
COLFORMATTER;

$dg -> add_column(
        'action', 
        array('name'=>'action', 
            'index'=>'action', 
            'width'=>'360', 
            'formatter'=>$col_formatter),
        'Actions');
*/

$dg->set_scroll(true, 300);
$dg -> display();
?>

<?php
include_once('../inc/footer.php');
?>