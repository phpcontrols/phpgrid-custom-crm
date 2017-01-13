<?php
use phpGrid\C_DataGrid;

require_once("../phpGrid/conf.php");      

include_once('../inc/head.php');
?>

<h1>Custom CRM - Sales Pipeline</h1>

<?php
//$_GET['currentPage'] = 'pipeline';
//include_once('../inc/menu.php');
$tableName = (isset($_GET['gn']) && isset($_GET['gn']) !== '') ? $_GET['gn'] : 'users';

switch($tableName){
    case "users":
        $dg = new C_DataGrid("SELECT id, Name_First, Name_Last, Email, Password FROM users", "id", "users");
        $dg->set_query_filter(" user_roles = 1 ");
        $dg->set_col_hidden('id')->set_col_hidden('User_Roles')->set_col_hidden('User_Status')->set_col_hidden('Password');
        $dg->set_caption(' ');   
        break;

    case "notes":
        $dg = new C_DataGrid("SELECT id, Todo_Desc_ID, Todo_Due_Date, Contact, Task_Status, Sales_Rep FROM notes", "id", "notes");
        $dg->set_query_filter(" Todo_Due_Date != '' ");
        $dg->set_col_hidden('id')->set_caption(' ');;
        $dg->set_col_edittype('Todo_Desc_ID', 'select', "select id, description from todo_desc");
        $dg->set_col_edittype('Contact', 'select', "select id, concat(contact_first, ' ', contact_last) from contact");
        $dg->set_col_edittype('Task_Status', 'select', "select id, status from task_status");
        $dg->set_col_edittype('Sales_Rep', 'select', "select id, concat(name_first, ' ', name_last) from users");
        break;

    case "contact":
        $dg = new C_DataGrid("SELECT id, contact_last, contact_title, company, industry, status, budget, sales_rep, rating FROM contact", "id", "contact");
        $dg->set_col_hidden('id')->set_caption(' ');
        $dg->set_col_edittype('sales_rep', 'select', "select id, concat(name_first, ' ', name_last) from users");
        $dg->set_col_currency('budget');
        $dg->enable_global_search(true);

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

        $dg->set_masterdetail($sdg, 'Contact', 'id');
        break;
}

$dg->enable_edit()->set_dimension('1100');
$dg -> display(false);
$grid = $dg -> get_display(false);

$dg -> display_script_includeonce();
?>

<?php
/*
$dg = new C_DataGrid("SELECT id, Name_First, Name_Last, Email, Password FROM users", "id", "users");
$dg->set_query_filter(" user_roles = 1 ");
$dg->set_col_hidden('id')->set_col_hidden('User_Roles')->set_col_hidden('User_Status')->set_col_hidden('Password')->set_caption(' ');
$dg->set_dimension('800px');
$dg->enable_edit();
$dg -> display();

// Tasks
$dg = new C_DataGrid("SELECT id, Todo_Desc_ID, Todo_Due_Date, Contact, Task_Status, Sales_Rep FROM notes", "id", "notes");
$dg->set_query_filter(" Todo_Due_Date != '' ");
$dg->set_col_hidden('id')->set_caption(' ');;

$dg->set_col_edittype('Todo_Desc_ID', 'select', "select id, description from todo_desc");
$dg->set_col_edittype('Contact', 'select', "select id, concat(contact_first, ' ', contact_last) from contact");
$dg->set_col_edittype('Task_Status', 'select', "select id, status from task_status");
$dg->set_col_edittype('Sales_Rep', 'select', "select id, concat(name_first, ' ', name_last) from users");

$dg -> display();

// Contacts
$dg = new C_DataGrid("SELECT id, contact_last, contact_title, company, industry, status, budget, sales_rep, rating FROM contact", "id", "contact");
$dg->set_col_hidden('id')->set_caption(' ');
$dg->set_col_edittype('sales_rep', 'select', "select id, concat(name_first, ' ', name_last) from users");
$dg->set_col_currency('budget');
$dg->enable_global_search(true);
$dg->enable_edit();

$dg -> display();
*/
?>



<script>
  $( function() {
    $( "#tabs" ).tabs({
        beforeLoad: function(event, ui) {
            if(ui.panel.html() == ""){
                ui.panel.html('<div class="loading">Loading...</div>');
                return true;
            } else {
                return false;
            }
        }
    });
  } );
</script>

 
<style>
.loading {
    position: fixed;
    top: 350px;
    left: 50%;
    margin-top: -96px;
    margin-left: -96px;
    opacity: .85;
    border-radius: 25px;
    width: 50px;
    height: 50px;
}

#tabs ul{
    width:1093px;
}

#tabs h1,
.hidetab ul{
    display: none;
}
.ui-tabs-panel.ui-widget-content.ui-corner-bottom{
    padding:0;
}
</style>


<div id="tabs" class="<?php echo (isset($_GET['gn'])) ? 'hidetab' : ''; ?>">
    <ul>
        <li><a href="#tabs-1">My Sales Reps</a></li>
        <li><a href="?gn=notes">Tasks</a></li>
        <li><a href="?gn=contact">Contact</a></li>
    </ul>

    <div id="tabs-1" style="padding:0">
        <?php 
        echo $grid;
        ?>
    </div>
</div>

<script>
$('#tabs').find('li a').one("click", function (e) {
    e.preventDefault();
});
</script>

<?php
include_once('../inc/footer.php');
?>