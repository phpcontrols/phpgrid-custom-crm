<?php
include_once("../phpGrid_Lite/conf.php");      
include_once('../inc/head.php');

$tableName = (isset($_GET['gn']) && $_GET['gn'] !== '') ? $_GET['gn'] : 'users';
?>

<h1>My Custom CRM - Sales Pipeline</h1>

<section id="subtitle">
    <h2>Welcome! Manager</h2>
    <div>
    You can manage your sales team and contacts here.
    </div>
    <br />
</section>

<div id="menu">
    <ul>
        <li><a href="?gn=users" <?php if($tableName == 'users') echo 'class="active"'; ?>>My Sales Reps</a></li>
        <li><a href="?gn=notes" <?php if($tableName  == 'notes') echo 'class="active"'; ?>>Tasks</a></li>
        <li><a href="?gn=contact" <?php if($tableName == 'contact') echo 'class="active"'; ?>>Contact</a></li>
    </ul>
</div>
<br />

<?php
switch($tableName){
    case "users":
        $dg = new C_DataGrid("SELECT id, Name_First, Name_Last, Email, Password FROM users", "id", "users");
        $dg->set_query_filter(" user_roles = 1 ");
        $dg->set_col_hidden('id')->set_col_hidden('User_Roles')->set_col_hidden('User_Status')->set_col_hidden('Password');
        $dg->set_caption('Sales Rep');   

        $sdg = new C_DataGrid("SELECT id, contact_last, contact_title, company, industry, status, budget, sales_rep, rating FROM contact", "id", "contact");
        $sdg->set_col_hidden('id')->set_col_hidden('sales_rep', false);
        $sdg->set_col_edittype('sales_rep', 'select', "select id, concat(name_first, ' ', name_last) from users");
        $sdg->set_col_currency('budget');
        $sdg->set_scroll(true);

        //$sdg->set_col_format('rating', 'rating');

$gridComplete = <<<GRIDCOMPLETE
function ()
{
    rowIds = $("#users").getDataIDs();
    $.each(rowIds, function (index, rowId) {
        $("#users").expandSubGridRow(rowId);
    });
}
GRIDCOMPLETE;

        $dg->add_event("jqGridLoadComplete", $gridComplete);
        $dg->set_subgrid($sdg, 'sales_rep', 'id');
        break;

    case "notes":
        $dg = new C_DataGrid("SELECT id, Todo_Desc_ID, Todo_Due_Date, Contact, Task_Status, Sales_Rep FROM notes", "id", "notes");
        $dg->set_query_filter(" Todo_Due_Date != '' ");
        $dg->set_col_hidden('id')->set_caption('Tasks');
        $dg->set_col_edittype('Todo_Desc_ID', 'select', "select id, description from todo_desc");
        $dg->set_col_edittype('Contact', 'select', "select id, concat(contact_first, ' ', contact_last) from contact");
        $dg->set_col_edittype('Task_Status', 'select', "select id, status from task_status");
        $dg->set_col_edittype('Sales_Rep', 'select', "select id, concat(name_first, ' ', name_last) from users");
        break;

    case "contact":
        $dg = new C_DataGrid("SELECT id, contact_last, contact_title, company, industry, status, budget, sales_rep, rating FROM contact", "id", "contact");
        $dg->set_col_hidden('id');
        $dg->set_col_edittype('sales_rep', 'select', "select id, concat(name_first, ' ', name_last) from users");
        $dg->set_col_currency('budget');
        $dg->enable_search(true);

        $sdg = new C_DataGrid("SELECT * FROM notes", "id", "notes");
        // $sdg->set_query_filter(" Sales_Rep = 1 ");
        $sdg->set_col_hidden('id', false)->set_col_hidden('Contact', false);

        $sdg->set_col_edittype('Add_Task_or_Meeting', 'select', 'Select id, status From task_status');
        $sdg->set_col_edittype('Task_Status', 'select', 'Select id, status From task_status');
        $sdg->set_col_edittype('Is_New_Todo', 'select', '0:No;1:Yes');
        $sdg->set_col_edittype('Todo_Type_ID', 'select', 'Select id, type From todo_type');
        $sdg->set_col_edittype('Todo_Desc_ID', 'select', 'Select id, description From todo_desc');
        $sdg->set_col_edittype('Sales_Rep', 'select', "select id, concat(name_first, ' ', name_last) from users");
        $sdg->enable_edit();

        $dg->set_subgrid($sdg, 'Contact', 'id');
        break;
}

$dg->enable_edit();
$dg -> display();
?>


<?php
include_once('../inc/footer.php');
?>