<?php
/**
 * This view displays the list of employees.
 * @copyright  Copyright (c) 2014-2016 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.1.0
 */
?>

<div class="row-fluid">
    <div class="span12">
        
<h2><?php echo lang('hr_employees_title');?>&nbsp;<?php echo $help;?></h2>

<?php echo $flash_partial_view;?>

<div class="row-fluid">
    <div class="span4">
        <input type="hidden" name="entity" id="entity" />
         <label for="txtEntity"><?php echo lang('hr_employees_field_entity');?>
            <div class="input-append">
                <input type="text" id="txtEntity" name="txtEntity" readonly />
                <a id="cmdSelectEntity" class="btn btn-primary"><?php echo lang('hr_employees_button_select');?></a>
            </div>
         </label>
    </div>
    <div class="span4">
      <input type="checkbox" id="chkIncludeChildren" /> <?php echo lang('hr_employees_field_subdepts');?>
    </div>
    <div class="span4">
      <?php echo lang('hr_employees_description');?>
    </div>
</div>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="users" width="100%">
    <thead>
        <tr>
            <th><?php echo lang('hr_employees_thead_id');?></th>
            <th><?php echo lang('hr_employees_thead_firstname');?></th>
            <th><?php echo lang('hr_employees_thead_lastname');?></th>
            <th><?php echo lang('hr_employees_thead_email');?></th>
            <th><?php echo lang('hr_employees_thead_entity');?></th>
            <th><?php echo lang('hr_employees_thead_contract');?></th>
            <th><?php echo lang('hr_employees_thead_manager');?></th>
            <th><?php echo lang('hr_employees_thead_identifier');?></th>
            <th><?php echo lang('hr_employees_thead_datehired');?></th>
            <th><?php echo lang('hr_employees_thead_position');?></th>
        </tr>
    </thead>
    <tbody class="context" data-toggle="context" data-target="#context-menu">
    </tbody>
</table>

        </div>
</div>
    
<div class="row-fluid">
    <div class="span12">
      <a href="<?php echo base_url();?>users/create" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>&nbsp;<?php echo lang('hr_employees_button_create_user');?></a>
      &nbsp;
      <a href="#" id="cmdExportEmployees" class="btn btn-primary"><i class="fa fa-file-excel-o"></i>&nbsp;<?php echo lang('hr_employees_button_export');?></a>
      &nbsp;
        <div class="btn-group dropup">
            <button id="cmdSelection" class="btn dropdown-toggle btn-primary" data-toggle="dropdown">
              <i class="fa fa-pencil"></i>&nbsp;<?php echo lang('hr_employees_button_selection');?>&nbsp;<span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" id="cmdSelectAll"><i class="fa fa-circle"></i>&nbsp;<?php echo lang('hr_employees_button_select_all');?></a></li>
                <li><a href="#" id="cmdDeselectAll"><i class="fa fa-circle-o"></i>&nbsp;<?php echo lang('hr_employees_button_deselect_all');?></a></li>
                <li class="divider"></li>
                <li><a href="#" id="cmdSelectManager"><i class="fa fa-user"></i>&nbsp;<?php echo lang('hr_employees_button_select_manager');?></a></li>
                <li><a href="#" id="cmdAddEntitlments"><i class="fa fa-pencil-square-o"></i>&nbsp;<?php echo lang('hr_employees_button_entitleddays');?></a></li>
                <li><a href="#" id="cmdSelectContract"><i class="fa fa-file-text-o"></i>&nbsp;<?php echo lang('hr_employees_button_select_contract');?></a></li>
                <li><a href="#" id="cmdChangeEntity"><i class="fa fa-sitemap"></i>&nbsp;<?php echo lang('hr_employees_button_select_entity');?></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="row-fluid"><div class="span12">&nbsp;</div></div>

<div id="frmSelectManager" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmSelectManager').modal('hide');" class="close">&times;</a>
         <h3><?php echo lang('hr_employees_popup_manager_title');?></h3>
    </div>
    <div class="modal-body" id="frmSelectManagerBody">
        <img src="<?php echo base_url();?>assets/images/loading.gif">
    </div>
    <div class="modal-footer">
        <a href="#" onclick="select_manager();" class="btn btn-primary"><?php echo lang('OK');?></a>
        <a href="#" onclick="$('#frmSelectManager').modal('hide');" class="btn btn-danger"><?php echo lang('Cancel');?></a>
    </div>
</div>

<div id="frmSelectEntity" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmSelectEntity').modal('hide');" class="close">&times;</a>
         <h3><?php echo lang('hr_employees_popup_entity_title');?></h3>
    </div>
    <div class="modal-body" id="frmSelectEntityBody">
        <img src="<?php echo base_url();?>assets/images/loading.gif">
    </div>
    <div class="modal-footer">
        <a href="#" onclick="select_entity();" class="btn"><?php echo lang('OK');?></a>
        <a href="#" onclick="$('#frmSelectEntity').modal('hide');" class="btn secondary"><?php echo lang('Cancel');?></a>
    </div>
</div>

<div id="frmSelectContract" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmSelectContract').modal('hide');" class="close">&times;</a>
         <h3><?php echo lang('hr_employees_popup_contract_title');?></h3>
    </div>
    <div class="modal-body">
        <select id="cboContract" class="selectized input-xlarge">
        <?php $index = 0;
             foreach ($contracts as $contract) { ?>
            <option value="<?php echo $contract['id'] ?>" <?php if ($index == 0) echo "selected"; ?>><?php echo $contract['name']; ?></option>
        <?php 
                $index++;
            } ?>
        </select>
    </div>
    <div class="modal-footer">
        <a href="#" onclick="select_contract();" class="btn"><?php echo lang('OK');?></a>
        <a href="#" onclick="$('#frmSelectContract').modal('hide');" class="btn secondary"><?php echo lang('Cancel');?></a>
    </div>
</div>

<div id="frmAddEntitledDays" class="modal hide fade">
        <div class="modal-header">
            <a href="#" class="close" onclick="$('#frmAddEntitledDays').modal('hide');">&times;</a>
            <h3 id="frmAddEntitledDaysTitle"><?php echo lang('entitleddays_contract_popup_title');?></h3>
        </div>
        <div class="modal-body">
            <label for="viz_startentdate"><?php echo lang('entitleddays_user_index_field_start');?></label>
            <input type="text" id="viz_startentdate" name="viz_startentdate" required />
            <br />
            <input type="hidden" name="startentdate" id="startentdate" />
            <label for="viz_endentdate"><?php echo lang('entitleddays_user_index_field_end');?></label>
            <input type="text" id="viz_endentdate" name="viz_endentdate" required /><br />
            <input type="hidden" name="endentdate" id="endentdate" />
            <label for="typeEnt"><?php echo lang('entitleddays_user_index_field_type');?></label>
            <select name="typeEnt" id="typeEnt" required>
            <?php foreach ($types as $types_item): ?>
                <option value="<?php echo $types_item['id'] ?>" <?php if ($types_item['id'] == 1) echo "selected" ?>><?php echo $types_item['name'] ?></option>
            <?php endforeach ?> 
            </select>    
            <label for="daysEnt" required><?php echo lang('entitleddays_user_index_field_days');?></label>
            <input type="text" class="input-mini" name="daysEnt" id="daysEnt" />
            <label for="descriptionEnt"><?php echo lang('entitleddays_user_index_field_description');?></label>
            <input type="text" class="input-xlarge" name="descriptionEnt" id="descriptionEnt" />
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" onclick="add_entitleddays();" ><?php echo lang('OK');?></button>
            <button class="btn btn-danger" onclick="$('#frmAddEntitledDays').modal('hide');"><?php echo lang('entitleddays_user_index_button_cancel');?></button>
        </div>
 </div>

<div id="context-menu">
  <ul class="dropdown-menu" role="menu">
        <li><a tabindex="-1" href="#" data-action="<?php echo base_url();?>hr/leaves/create/{id}"><i class="icon-plus"></i>&nbsp;<?php echo lang('hr_employees_thead_link_create_leave');?></a></li>
        <li><a tabindex="-1" href="#" data-action="<?php echo base_url();?>users/edit/{id}?source=hr%2Femployees"><i class="icon-pencil"></i>&nbsp;<?php echo lang('hr_employees_thead_tip_edit');?></a></li>
        <li><a tabindex="-1" href="#" data-action="<?php echo base_url();?>entitleddays/user/{id}"><i class="icon-edit"></i>&nbsp;<?php echo lang('hr_employees_thead_tip_entitlment');?></a></li>
        <li><a tabindex="-1" href="#" data-action="<?php echo base_url();?>hr/leaves/{id}"><i class="icon-list-alt"></i>&nbsp;<?php echo lang('hr_employees_thead_link_leaves');?></a></li>
        <?php if ($this->config->item('disable_overtime') == FALSE) { ?>
        <li><a tabindex="-1" href="#" data-action="<?php echo base_url();?>hr/overtime/{id}"><i class="icon-list-alt"></i>&nbsp;<?php echo lang('hr_employees_thead_link_extra');?></a></li>
        <?php } ?>
        <li><a tabindex="-1" href="#" data-action="<?php echo base_url();?>hr/counters/employees/{id}"><i class="icon-info-sign"></i>&nbsp;<?php echo lang('hr_employees_thead_link_balance');?></a></li>
        <li><a tabindex="-1" href="#" data-action="<?php echo base_url();?>hr/presence/employees/{id}"><i class="fa fa-pie-chart"></i>&nbsp;<?php echo lang('hr_employees_thead_link_presence');?></a></li>
        <li><a tabindex="-1" href="#" data-action="<?php echo base_url();?>calendar/year/{id}"><i class="icon-calendar"></i>&nbsp;<?php echo lang('hr_employees_thead_link_calendar');?></a></li>
        <li><a tabindex="-1" href="#" data-action="<?php echo base_url();?>requests/delegations/{id}"><i class="icon-share-alt"></i>&nbsp;<?php echo lang('hr_employees_thead_link_delegation');?></a></li>
  </ul>
</div>

<div class="modal hide fade" id="frmContextMenu">
    <div class="modal-body">
        <a class="context-mobile" href="<?php echo base_url();?>hr/leaves/create/{id}"><i class="icon-plus"></i>&nbsp;<?php echo lang('hr_employees_thead_link_create_leave');?></a><br />
        <a class="context-mobile" href="<?php echo base_url();?>users/edit/{id}?source=hr%2Femployees"><i class="icon-pencil"></i>&nbsp;<?php echo lang('hr_employees_thead_tip_edit');?></a><br />
        <a class="context-mobile" href="<?php echo base_url();?>entitleddays/user/{id}"><i class="icon-edit"></i>&nbsp;<?php echo lang('hr_employees_thead_tip_entitlment');?></a><br />
        <a class="context-mobile" href="<?php echo base_url();?>hr/leaves/{id}"><i class="icon-list-alt"></i>&nbsp;<?php echo lang('hr_employees_thead_link_leaves');?></a><br />
        <?php if ($this->config->item('disable_overtime') == FALSE) { ?>
        <a class="context-mobile" href="<?php echo base_url();?>hr/overtime/{id}"><i class="icon-list-alt"></i>&nbsp;<?php echo lang('hr_employees_thead_link_extra');?></a><br />
        <?php } ?>
        <a class="context-mobile" href="<?php echo base_url();?>hr/counters/employees/{id}"><i class="icon-info-sign"></i>&nbsp;<?php echo lang('hr_employees_thead_link_balance');?></a><br />
        <a class="context-mobile" href="<?php echo base_url();?>hr/presence/employees/{id}"><i class="fa fa-pie-chart" style="color:black;"></i>&nbsp;<?php echo lang('hr_employees_thead_link_presence');?></a><br />
        <a class="context-mobile" href="<?php echo base_url();?>calendar/year/{id}"><i class="icon-calendar"></i>&nbsp;<?php echo lang('hr_employees_thead_link_calendar');?></a><br />
        <a class="context-mobile" href="<?php echo base_url();?>requests/delegations/{id}"><i class="icon-share-alt"></i>&nbsp;<?php echo lang('hr_employees_thead_link_delegation');?></a>
  </div>
</div>

<div class="modal hide" id="frmModalAjaxWait" data-backdrop="static" data-keyboard="false">
        <div class="modal-header">
            <h1><?php echo lang('global_msg_wait');?></h1>
        </div>
        <div class="modal-body">
            <img src="<?php echo base_url();?>assets/images/loading.gif"  align="middle">
        </div>
 </div>

<link href="<?php echo base_url();?>assets/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/datatable/buttons/css/buttons.dataTables.min.css" rel="stylesheet"/>
<link href="<?php echo base_url();?>assets/datatable/colreorder/css/colReorder.dataTables.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/datatable/select/css/select.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/flick/jquery-ui.custom.min.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/datatable/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/datatable/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/datatable/buttons/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/datatable/colreorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/datatable/select/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.pers-brow.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/context.menu.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/toe.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui.custom.min.js"></script>
<?php //Prevent HTTP-404 when localization isn't needed
if ($language_code != 'en') { ?>
<script src="<?php echo base_url();?>assets/js/i18n/jquery.ui.datepicker-<?php echo $language_code;?>.js"></script>
<?php } ?>

<script type="text/javascript">
var entity = 0; //Root of the tree by default
var entityName = '';
var includeChildren = true;
var contextObject;
var contextSelectEntity = "select";
var oTable;

//Handle choose of entity with the modal form "select an entity". Update cookie with selected values
function select_entity() {
    entity = $('#organization').jstree('get_selected')[0];
    entityName = $('#organization').jstree().get_text(entity);
    $("#frmSelectEntity").modal('hide');
    if (contextSelectEntity == "select") {
        //"select": Filter the content of datatable for a given entity
        includeChildren = $('#chkIncludeChildren').is(':checked');
        $('#entity').val(entity);
        $('#txtEntity').val(entityName);
        $.cookie('entity', entity);
        $.cookie('entityName', entityName);
        $.cookie('includeChildren', includeChildren);
        //Refresh datatable
        $('#frmModalAjaxWait').modal('show');
        oTable.ajax.url('<?php echo base_url();?>hr/employees/entity/' + entity + '/' + includeChildren)
            .load(function() {
                $("#frmModalAjaxWait").modal('hide');
            }, true);
    } else {
        //"change": Move selected employees to another entity
        var employeeIds = getSelectedEmployees();
        //Call a web service that changes the entity of a list of employees
        $('#frmModalAjaxWait').modal('show');
        $.ajax({
            url: "<?php echo base_url();?>hr/employees/edit/entity",
            type: "POST",
            data: {
                    entity: entity,
                    employees: employeeIds
                }
          }).done(function() {
              oTable.ajax.reload(function ( json ) {
                  $('#frmModalAjaxWait').modal('hide');
              });
        });
    }
}

//Get the list of selected employees into the datatable
//Return a JSON representation of an array of identifiers (integer)
function getSelectedEmployees() {
    var employeeIds = [];
    oTable.rows({selected: true}).every( function () {
        employeeIds.push(this.data().id);
     });
     return JSON.stringify({employeeIds});
}

//Popup select manager: on click OK, find the id of all selected employees and update their manager.
function select_manager() {
    var employees = $('#employees').DataTable();
    if ( employees.rows({ selected: true }).any() ) {
        var manager_id = employees.rows({selected: true}).data()[0][0];
        var employeeIds = getSelectedEmployees();
        //Call a web service that changes the manager of a list of employees
        $('#frmModalAjaxWait').modal('show');
        $.ajax({
            url: "<?php echo base_url();?>hr/employees/edit/manager",
            type: "POST",
            data: {
                    manager: manager_id,
                    employees: employeeIds
                }
          }).done(function() {
              oTable.ajax.reload(function ( json ) {
                  $('#frmModalAjaxWait').modal('hide');
              });
        });
    }
    $("#frmSelectManager").modal('hide');
}

//Popup select contract: on click OK, find the id of all selected employees and update their contract.
function select_contract() {
    var contract_id = $('#cboContract').val();
    var employeeIds = getSelectedEmployees();
    //Call a web service that changes the contract of a list of employees
    $('#frmModalAjaxWait').modal('show');
    $.ajax({
        url: "<?php echo base_url();?>hr/employees/edit/contract",
        type: "POST",
        data: {
                contract: contract_id,
                employees: employeeIds
            }
      }).done(function() {
          oTable.ajax.reload(function ( json ) {
              $('#frmModalAjaxWait').modal('hide');
          });
    });
    $("#frmSelectContract").modal('hide');
}

//Popup add entitled days: on click OK, find the id of all selected employees and update their contract.
function add_entitleddays() {
    var employeeIds = getSelectedEmployees();
    //Validate the form
    var fieldname = "";
    if ($('#startentdate').val() == "") fieldname = "<?php echo lang('entitleddays_user_index_field_start');?>";
    if ($('#endentdate').val() == "") fieldname = "<?php echo lang('entitleddays_user_index_field_end');?>";
    if ($('#typeEnt').val() == "") fieldname = "<?php echo lang('entitleddays_user_index_field_type');?>";
    if ($('#daysEnt').val() == "") fieldname = "<?php echo lang('entitleddays_user_index_field_days');?>";
    if (fieldname != "") {
        bootbox.alert(<?php echo lang('entitleddays_user_mandatory_js_msg');?>);
        $("#frmAddEntitledDays").modal('hide');
        return;
    }
    
    //Call a web service that changes the entitlements of a list of employees
    $('#frmModalAjaxWait').modal('show');
    $.ajax({
        url: "<?php echo base_url();?>hr/employees/edit/entitlements",
        type: "POST",
        data: {
                startdate: $('#startentdate').val(),
                enddate: $('#endentdate').val(),
                days: $('#daysEnt').val(),
                type: $('#typeEnt').val(),
                description: $('#descriptionEnt').val(),
                employees: employeeIds
            }
      }).done(function() {
          oTable.ajax.reload(function ( json ) {
              $('#frmModalAjaxWait').modal('hide');
          });
    });
    $("#frmAddEntitledDays").modal('hide');
}

//Prevent text selection after double click
function clearSelection() {
    if(document.selection && document.selection.empty) {
        document.selection.empty();
    } else if(window.getSelection) {
        var sel = window.getSelection();
        sel.removeAllRanges();
    }
}

$(function () {
<?php if ($this->config->item('csrf_protection') == TRUE) {?>
    $.ajaxSetup({
        data: {
            <?php echo $this->security->get_csrf_token_name();?>: "<?php echo $this->security->get_csrf_hash();?>",
        }
    });
<?php }?>
    
    //Global Ajax error handling mainly used for session expiration
    $( document ).ajaxError(function(event, jqXHR, settings, errorThrown) {
        $('#frmModalAjaxWait').modal('hide');
        if (jqXHR.status == 401) {
            bootbox.alert("<?php echo lang('global_ajax_timeout');?>", function() {
                //After the login page, we'll be redirected to the current page 
               location.reload();
            });
        } else { //Oups
            bootbox.alert("<?php echo lang('global_ajax_error');?>");
        }
      });
    
    //Handle a context menu of the DataTable
    $('.context').contextmenu({
        before: function (e, element, target) {
            e.preventDefault();
            if (oTable.data().any()) {
                contextObject = e.target;
                return true;
            } else {
                return false;
            }
        },
        onItem: function(context,e) {
            var action = null;
            if (e != "a") {
                action = $(e.target).closest("a").data("action");
            } else {
                action = $(e.target).data("action");
            }
            var id = $(contextObject).closest("tr").find('td:eq(0)').text();
            var url = action.replace("{id}", id.trim());
            window.location = url;
        }
      });
        
    //Taphold on mobile, display contextual menu as a popup
    $(document).on('taphold', '.context', function(e){
        id = $(e.target).closest("tr").find('td:eq(0)').text();
        $("#frmContextMenu").modal('show');
        $('.context-mobile').each(function() {
            action =  $(this).attr( 'href');
            var url = action.replace("{id}", id.trim());
            $(this).attr( 'href', url);
        });
      });
      
    //On double click, display contextual menu as a popup
    $(document).on('dblclick', '.context', function (e) {
        clearSelection();
        id = $(e.target).closest("tr").find('td:eq(0)').text();
        $("#frmContextMenu").modal('show');
        $('.context-mobile').each(function() {
            action =  $(this).attr( 'href');
            var url = action.replace("{id}", id.trim());
            $(this).attr( 'href', url);
        });
    });
    
    //On keying ESC, hide context menu
    $("body").on("keyup", function(e){
        if (e.keyCode == 27) {
            if ($('#frmContextMenu').hasClass('in')) {
                $('#frmContextMenu').modal('hide');
            }
        }
    });
    
    //Cookie has value ? take -1 by default
    if($.cookie('entity') != null) {
        entity = $.cookie('entity');
        entityName = $.cookie('entityName');
        includeChildren = $.cookie('includeChildren');
        //Parse boolean value contained into the string
        includeChildren = $.parseJSON(includeChildren.toLowerCase());
        $('#txtEntity').val(entityName);
        $('#chkIncludeChildren').prop('checked', includeChildren);
    } else { //Set default value
        $.cookie('entity', entity);
        $.cookie('entityName', entityName);
        $.cookie('includeChildren', includeChildren);
    }    

    //Transform the HTML table in a fancy datatable:
    // * Column ID cannot be moved or hidden because it is used for contextual actions
    oTable = $('#users').DataTable({
            "ajax": '<?php echo base_url();?>hr/employees/entity/' + entity + '/' + includeChildren,
            columns: [
                { data: "id" },
                { data: "firstname" },
                { data: "lastname" },
                { data: "email" },
                { data: "entity" },
                { data: "contract" },
                { data: "manager_name" },
                { data: "identifier" },
                { data: {
                        _: "datehired.display",
                        sort: "datehired.timestamp"
                    },
                    "orderDataType": "dom-text", "type": "numeric"
                },
                { data: "position" }
            ],
            stateSave: true,
            select: 'multiple',
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'pageLength',
                                text: '<?php echo lang('datatable_pagination');?>'
                            },
                            {
                                extend: 'colvis',
                                columns: ':not(:first-child)',
                                postfixButtons: [
                                    {
                                        extend: 'colvisRestore',
                                        text: '<?php echo lang('datatable_colvisRestore');?>'
                                    }
                                ]
                            }
            ],
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [
                    '<?php echo lang('datatable_10_rows');?>',
                    '<?php echo lang('datatable_25_rows');?>',
                    '<?php echo lang('datatable_50_rows');?>',
                    '<?php echo lang('datatable_all_rows');?>' 
                ]
            ],
            colReorder: {
                fixedColumnsLeft: 1
            },
        language: {
            buttons: {
                colvis: '<?php echo lang('datatable_colvis');?>'
            },
            decimal:            "<?php echo lang('datatable_sInfoThousands');?>",
            processing:       "<?php echo lang('datatable_sProcessing');?>",
            search:              "<?php echo lang('datatable_sSearch');?>",
            lengthMenu:     "<?php echo lang('datatable_sLengthMenu');?>",
            info:                   "<?php echo lang('datatable_sInfo');?>",
            infoEmpty:          "<?php echo lang('datatable_sInfoEmpty');?>",
            infoFiltered:       "<?php echo lang('datatable_sInfoFiltered');?>",
            infoPostFix:        "<?php echo lang('datatable_sInfoPostFix');?>",
            loadingRecords: "<?php echo lang('datatable_sLoadingRecords');?>",
            zeroRecords:    "<?php echo lang('datatable_sZeroRecords');?>",
            emptyTable:     "<?php echo lang('datatable_sEmptyTable');?>",
            paginate: {
                first:          "<?php echo lang('datatable_sFirst');?>",
                previous:   "<?php echo lang('datatable_sPrevious');?>",
                next:           "<?php echo lang('datatable_sNext');?>",
                last:           "<?php echo lang('datatable_sLast');?>"
            },
            aria: {
                sortAscending:  "<?php echo lang('datatable_sSortAscending');?>",
                sortDescending: "<?php echo lang('datatable_sSortDescending');?>"
            }
        },
    });
    
    //Popup select entity
    $("#cmdSelectEntity").click(function() {
        contextSelectEntity = "select";
        $("#frmSelectEntity").modal('show');
        $("#frmSelectEntityBody").load('<?php echo base_url(); ?>organization/select');
    });
    
    //Popup select manager
    $("#cmdSelectManager").click(function() {
        if (oTable.rows({selected: true}).any()) {
            $("#frmSelectManager").modal('show');
            $("#frmSelectManagerBody").load('<?php echo base_url(); ?>users/employees');
        }
        else {
            bootbox.alert("<?php echo lang('hr_employees_multiple_edit_selection_msg');?>");
        }
    });
    
    //Add entitled days to a group of employees
    $("#cmdAddEntitlments").click(function() {
        $("#frmAddEntitledDays").modal('show');
    });
    //Force decimal separator whatever the locale is
    $( "#days" ).keyup(function() {
        var value = $("#days").val();
        value = value.replace(",", ".");
        $("#days").val(value);
    });
    //Link the two dates of the entitled days popup
    $("#viz_startentdate").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: '<?php echo lang('global_date_js_format');?>',
        altFormat: "yy-mm-dd",
        altField: "#startentdate",
        numberOfMonths: 3,
              onClose: function( selectedDate ) {
                $( "#viz_endentdate" ).datepicker( "option", "minDate", selectedDate );
              }
    }, $.datepicker.regional['<?php echo $language_code;?>']);
    $("#viz_endentdate").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: '<?php echo lang('global_date_js_format');?>',
        altFormat: "yy-mm-dd",
        altField: "#endentdate",
        numberOfMonths: 3,
              onClose: function( selectedDate ) {
                $( "#viz_startentdate" ).datepicker( "option", "maxDate", selectedDate );
              }
    }, $.datepicker.regional['<?php echo $language_code;?>']);
    
    
    //Change the contract of a group of employees
    $("#cmdSelectContract").click(function() {
        $("#frmSelectContract").modal('show');
    });
    
    //Move the entity of a group of employees
    $("#cmdChangeEntity").click(function() {
        contextSelectEntity = "change";
        $("#frmSelectEntity").modal('show');
        $("#frmSelectEntityBody").load('<?php echo base_url(); ?>organization/select');
    });
    
    //Select or deselect all rows
    $("#cmdSelectAll").click(function() {
        oTable.rows().select();
        $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
    });
    $("#cmdDeselectAll").click(function() {
        oTable.rows().deselect();
        $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
    });
    
    //If we opt-in the include children box, we'll recursively include the children of the selected entity
    //and the attached employees
    $("#chkIncludeChildren").on('change', function() {
        includeChildren = $('#chkIncludeChildren').is(':checked');
        $.cookie('includeChildren', includeChildren);
        //Refresh datatable
        $('#frmModalAjaxWait').modal('show');
        oTable.ajax.url('<?php echo base_url();?>hr/employees/entity/' + entity + '/' + includeChildren)
            .load(function() {
                $("#frmModalAjaxWait").modal('hide');
            }, true);
    });
    
    //On click button export, call the export to Excel view
    $("#cmdExportEmployees").click(function() {
        window.location = '<?php echo base_url();?>hr/employees/export/' + entity + '/' + includeChildren;
    });
});
</script>
