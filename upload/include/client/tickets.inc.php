<?php
if(!defined('OSTCLIENTINC') || !is_object($thisclient) || !$thisclient->isValid()) die('Access Denied');

$settings = &$_SESSION['client:Q'];

// Unpack search, filter, and sort requests
if (isset($_REQUEST['clear']))
    $settings = array();
if (isset($_REQUEST['keywords'])) {
    $settings['keywords'] = $_REQUEST['keywords'];
}
if (isset($_REQUEST['topic_id'])) {
    $settings['topic_id'] = $_REQUEST['topic_id'];
}
if (isset($_REQUEST['category_id'])) {
    $settings['category_id'] = $_REQUEST['category_id'];
}
if (isset($_REQUEST['status'])) {
    $settings['status'] = $_REQUEST['status'];
}

$org_tickets = $thisclient->canSeeOrgTickets();
if ($settings['keywords']) {
    // Don't show stat counts for searches
    $openTickets = $closedTickets = -1;
}
elseif ($settings['topic_id']) {
    $openTickets = $thisclient->getNumTopicTicketsInState($settings['topic_id'],
        'open', $org_tickets);
    $closedTickets = $thisclient->getNumTopicTicketsInState($settings['topic_id'],
        'closed', $org_tickets);
}
else {
    $openTickets = $thisclient->getNumOpenTickets($org_tickets);
    $closedTickets = $thisclient->getNumClosedTickets($org_tickets);
}

$tickets = Ticket::objects();



$qs = array();
$status=null;

$sortOptions=array('id'=>'number', 'subject'=>'cdata__subject',
                    'status'=>'status__name', 'dept'=>'dept__name','date'=>'created');
$orderWays=array('DESC'=>'-','ASC'=>'');
//Sorting options...
$order_by=$order=null;
$sort=($_REQUEST['sort'] && $sortOptions[strtolower($_REQUEST['sort'])])?strtolower($_REQUEST['sort']):'date';
if($sort && $sortOptions[$sort])
    $order_by =$sortOptions[$sort];

$order_by=$order_by ?: $sortOptions['date'];
if ($_REQUEST['order'] && $orderWays[strtoupper($_REQUEST['order'])])
    $order = $orderWays[strtoupper($_REQUEST['order'])];
else
    $order = $orderWays['DESC'];

$x=$sort.'_sort';
$$x=' class="'.strtolower($_REQUEST['order'] ?: 'desc').'" ';

$basic_filter = Ticket::objects();
if ($settings['topic_id']) {
    $basic_filter = $basic_filter->filter(array('topic_id' => $settings['topic_id']));
}
if ($settings['category_id']) {
    $basic_filter = $basic_filter->filter(array('category_id' => $settings['category_id']));
}


if ($settings['status'])
    $status = strtolower($settings['status']);
    switch ($status) {
    default:
        $status = 'open';
        // print 'open';
        // exit;
    case 'open':
    case 'closed':
		$results_type = ($status == 'closed') ? __('Closed Tickets') : __('Open Tickets');
        $basic_filter->filter(array('status__state' => $status));
        break;
}
        $status = null;
        $results_type = ($status == 'closed') ? __('Closed Tickets') : __('Open Tickets');
        $basic_filter->filter(array('status__state__in' => array('open','closed','resolved')));

// Add visibility constraints — use a union query to use multiple indexes,
// use UNION without "ALL" (false as second parameter to union()) to imply
// unique values
$visibility = $basic_filter->copy()
    ->values_flat('ticket_id')
    ->filter(array('user_id' => $thisclient->getId()))
    ->union($basic_filter->copy()
        ->values_flat('ticket_id')
        ->filter(array('thread__collaborators__user_id' => $thisclient->getId()))
    , false);


if ($thisclient->canSeeOrgTickets()) {
    $visibility = $visibility->union(
        $basic_filter->copy()->values_flat('ticket_id')
            ->filter(array('user__org_id' => $thisclient->getOrgId()))
    , false);
}

// Perform basic search
if ($settings['keywords']) {
    $q = trim($settings['keywords']);
    if (is_numeric($q)) {
        $tickets->filter(array('number__startswith'=>$q));
    } elseif (strlen($q) > 2) { //Deep search!
        // Use the search engine to perform the search
        //$tickets = $ost->searcher->find($q, $tickets);
        $tickets = $tickets->filter(array('cdata__subject__contains' => $settings['keywords']));
    }
}

$tickets->distinct('ticket_id');

TicketForm::ensureDynamicDataView();

$total=$visibility->count();

$page=($_GET['p'] && is_numeric($_GET['p']))?$_GET['p']:1;
$pageNav=new Pagenate($total, $page, PAGE_LIMIT);
$qstr = '&amp;'. Http::build_query($qs);
$qs += array('sort' => $_REQUEST['sort'], 'order' => $_REQUEST['order']);
$pageNav->setURL('tickets.php', $qs);
$tickets->filter(array('ticket_id__in' => $visibility));


$pageNav->paginate($tickets);

$showing =$total ? $pageNav->showing() : "";
if(!$results_type)
{
	$results_type=ucfirst($status).' '.__('Tickets');
}
$showing.=($status)?(' '.$results_type):' '.__('All Tickets');
if($search)
    $showing=__('Search Results').": $showing";

$negorder=$order=='-'?'ASC':'DESC'; //Negate the sorting

$tickets->order_by($order.$order_by);
$tickets->values(
    'ticket_id', 'number', 'created', 'isanswered', 'source', 'status_id',
    'status__state', 'status__name', 'cdata__subject', 'dept_id',
    'dept__name', 'dept__ispublic', 'user__default_email__address'
);

?>

<main>
        <div class="bases-conocimiento">
            <div class="margen">

                <div class="formulario-titulo">
                    Mis Solicitudes
                </div>
                <div class="linea-buscador">
                    <form action="tickets.php" method="get" id="ticketSearchForm">
                        <div class="input-search-ticket">
                            <input type="hidden" name="a"  value="search">
                            <input placeholder="Buscar solicitudes" type="text" name="keywords" id="in-buscador" value="<?php echo Format::htmlchars($settings['keywords']); ?>">
                            <button type="submit" class="search"><img class="search2" src="/assets/img/search.svg" alt=""></button>

                        </div>

                        <div class="list-producs">
                            <div class="list-producs-detail">
                                <label>Producto</label>
                                <label for="ch-buscador" class="la-buscador">
                                    <ul class="listado-solicitudes">
                                        <li>
                                        <input type="checkbox" name="" id="ch-buscador">
                                        <input type="hidden" name="category_id" id="category_id">
                                        <span id="sp-buscador">
                                                <img id="sp-buscador-img" class="sp-buscador-img" src="/assets/img/Gestión.svg"><span class="sp-buscador-prin" id="sp-buscador-span">Gestión</span>
                                        </span> 
                                        <img class="arrow-drop-down" id="flecha-buscador-cabecera" src="/assets/img/arrow-drop-down-copy-2.svg" alt="" style="float: right;
    margin-top: 16px;
    margin-right: 10px;">
                                        <ul class="submenu-buscador">
                                        <?php $cats = Category::getFeatured();?>
                                        <?php $cats->all(); ?>
                                            <?php foreach ($cats as $topic){ ?>
                                            <li>
                                                <span id="sp-buscador" class="buscador-elmento">
                                                    <img src="/assets/img/<?php echo $topic->name; ?>.svg"><span id="<?php echo $topic->getId(); ?>"><?php echo $topic->name; ?></span>
                                                </span>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                        </li>
                                    </ul>
                                </label>
                                <!-- <select name="topic_id" class="nowarn" onchange="javascript: this.form.submit(); ">
                                    <option value="">&mdash; <?php echo __('All Help Topics');?> &mdash;</option>
                                    <?php
                                    foreach (Topic::getHelpTopics(true) as $id=>$name) {
                                            $count = $thisclient->getNumTopicTickets($id, $org_tickets);
                                            if ($count == 0)
                                                continue;
                                    ?>
                                            <option value="<?php echo $id; ?>"i
                                                <?php if ($settings['topic_id'] == $id) echo 'selected="selected"'; ?>
                                                ><?php echo sprintf('%s (%d)', Format::htmlchars($name),
                                                    $thisclient->getNumTopicTickets($id)); ?></option>
                                    <?php } ?>
                                </select> -->
                            </div>    
                        </div>

                        

                    </form>
                </div>
                <div class="linea-buscador-table">
                    <div class="fila">
                        <label class="asunto">Asunto</label>
                        <label class="id">ID</label>
                        <label class="creacion">Creación</label>
                        <label class="actividad">Última actividad</label>
                        <label class="estado">Estado</label>
                    </div>
                </div>

                
                        <?php
                        $subject_field = TicketForm::objects()->one()->getField('subject');
                        $defaultDept=Dept::getDefaultDeptName(); //Default public dept.
                        if ($tickets->exists(true)) {
                            foreach ($tickets as $T) {
                                $ticket2=Ticket::lookup($T['ticket_id']);
                                

                                $dept = $T['dept__ispublic']
                                    ? Dept::getLocalById($T['dept_id'], 'name', $T['dept__name'])
                                    : $defaultDept;
                                $subject = $subject_field->display(
                                    $subject_field->to_php($T['cdata__subject']) ?: $T['cdata__subject']
                                );
                                $status = TicketStatus::getLocalById($T['status_id'], 'value', $T['status__name']);

                                switch ($status) {
                                    case "Abierto":
                                        $statusw = "open";
                                        break;
                                    case "Resuelto":
                                        $statusw = "resolved";
                                        break;
                                    case "Closed":
                                        $statusw = "closed";
                                        break;
                                    case "En espera":
                                        $statusw = "wait";
                                        break;
                                }
                                
                                if (false) // XXX: Reimplement attachment count support
                                    $subject.='  &nbsp;&nbsp;<span class="Icon file"></span>';

                                $ticketNumber=$T['number'];
                                if($T['isanswered'] && !strcasecmp($T['status__state'], 'open')) {
                                    $subject="<b>$subject</b>";
                                    $ticketNumber="<b>$ticketNumber</b>";
                                }
                                ?>
                                <div class="linea-buscador-table2">
                                    <div class="fila2">
                                        <label class="asunto">
                                            <span>Asunto</span>
                                            <a style="text-decoration:none;color: #29aae2;" href="tickets.php?id=<?php echo $T['ticket_id']; ?>">    <?php echo $subject; ?></a>
                                        </label>
                                        
                                        <label class="id">
                                            <span>ID</span>
                                            #<?php echo $ticketNumber; ?>
                                        </label>
                                        <label class="actividad">
                                            <span>Última actividad</span>
                                            <?php echo Format::datetime($ticket2->getLastMsgDate()); ?>
                                        </label>
                                        <label class="creacion">
                                            <span>Creación</span>
                                            <?php echo Format::date($T['created']); ?>
                                        </label>
                                        <label class="estado">
                                            <span>Estado</span>
                                            <button class="<?php echo $statusw; ?>"><?php echo $status; ?></button>
                                        </label>
                                    </div>
                                </div>
                                
                            <?php
                            }

                        } else {
                            ?>
                           <div class="linea-buscador-table">
                                <div class="fila2">
                                    No hay datos
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="linea-buscador-paginador">
                        <?php
                        if ($total) {
                            echo '<div>'.$pageNav->getPageLinks().'</div>';
                        }
                        ?>
                        </div>
            </div>
        </div>
</main>
<script>
$(".buscador-elmento").click(function(){
    var button=$(this);
    var texto = $(this).find('span');
    console.log('============================================');
    console.log(texto[0].id);
    console.log('============================================');

    $('#category_id').val(texto[0].id);
    $('#ticketSearchForm').submit();

});
</script>
