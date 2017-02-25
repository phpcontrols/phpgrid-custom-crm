<?php
include_once("../phpGrid_Lite/conf.php");      
include_once('../inc/head.php');
?>

<h1>My Custom CRM</h1>

<?php
$_GET['currentPage'] = 'leads';
include_once('../inc/menu.php');
?>

<h3>My Leads</h2>
<?php
$dg = new C_DataGrid("SELECT id, contact_first, contact_last, company, phone, email, website, status, lead_referral_source, sales_rep, lead_referral_source, date_of_initial_contact, title, industry, background_info, rating, project_type, project_description, budget FROM contact", "id", "contact");
$dg->set_query_filter(" status = 1 && sales_rep = 1 ")->set_caption('Contact');
$dg->set_col_hidden('id')->set_col_hidden('Status')->set_col_hidden('sales_rep', false);
$dg->set_col_hidden('lead_referral_source, title, industry, background_info, rating, project_type, project_description, budget');
$dg -> set_col_format("email", "email");
$dg->set_col_edittype('status', 'select', 'SELECT ID, status FROM contact_status');
$dg -> set_col_link("website");
$dg->enable_edit();

$sdg = new C_DataGrid("SELECT * FROM notes", "id", "notes");
$sdg->set_query_filter(" Sales_Rep = 1 ");
$sdg->set_col_hidden('id')->set_col_hidden('Contact', false)->set_col_hidden('Sales_Rep', false);
$sdg->set_col_edittype('Add_Task_or_Meeting', 'select', 'Select id, status From task_status');
$sdg->set_col_edittype('Task_Status', 'select', 'Select id, status From task_status');
$sdg->set_col_edittype('Is_New_Todo', 'select', '0:No;1:Yes');
$sdg->set_col_edittype('Todo_Type_ID', 'select', 'Select id, type From todo_type');
$sdg->set_col_edittype('Todo_Desc_ID', 'select', 'Select id, description From todo_desc');
//$sdg->set_col_default('Contact', ###current####);
$sdg->set_col_default('Sales_Rep', 1); // TODO: obtain from SESSION
$sdg->enable_edit();


$dg->set_subgrid($sdg, 'Contact', 'id');
$dg -> display();
?>

<?php
include_once('../inc/footer.php');
?>