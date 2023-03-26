<?php
include('includes/header.php'); 
include('includes/navbar.php');
include('database/dbconfig.php');  

?>
<script src="editor/ckeditor.js"></script>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
            <button type="button" class="btn btn-primary" id="addAgendaBtn" data-toggle="modal" data-target="#createAgenda">
             <i class="fas fa-plus"></i> Add Agenda 
            </button>
            
            <a href="all-meeting" class="btn btn-outline-success"><i class="fas fa-align-justify"></i> All Meeting</a>
    </h6>
  </div>

  <div class="card-body">

    <span id="message_operation"></span>
     <span id="message_operation2"></span>
     <span id="message_meetingTitle"></span>

    <div class="table-responsive">

      <table class="table table-bordered" id="allAgendaTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> ID </th>
            <th> Agenda Title </th>
            <th>Actions</th>
            <th>Discussion</th>
            <th>Decision</th>
            <th>Responsible Person</th>
            <th>Actions</th>

            
            

            
           <!--  <th>DELETE </th> -->
          </tr>
        </thead>
        <tbody>
        
        </tbody>
      </table>

    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->


<!-- Add/Create New Agenda Section-->

<div class="modal fade" id="addAgendaModal">
  <div class="modal-dialog">
    <form method="post" id="addAgendaForm" enctype="multipart/form-data">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Meting Agenda <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="meeting_agenda" id="meeting_agenda" class="form-control" />
             
                <input type="hidden" name="meeting_code" id="meeting_code"/>
                
              </div>
            </div>
          </div>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
<!--           <input type="hidden" name="hidden_teacher_image" id="hidden_teacher_image" value="" />
          <input type="hidden" name="teacher_id" id="teacher_id" /> -->
          <input type="hidden" name="page" value="agenda" />
          <input type="hidden" name="agenda_id" id="agenda_id"/>
          <input type="hidden" name="action" id="action" value="Add" />
          <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

      </div>
    </form>
  </div>
</div>

<!-- End of Add/Create New Agenda Section-->


<!-- Delete Agenda Section-->
<div class="modal" id="deleteAgendaModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <h4 align="center">Are you sure you want to remove this?</h4>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" name="ok_button" id="ok_button" class="btn btn-primary btn-sm">OK</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- Delete Agenda Section End-->


<!-- View Meeting Section-->
<div class="modal fade" id="viewMeetingModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Meeting Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" id="meeting_details">

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- View Meeting Section-->

<!-- Add/Create Decision Section-->

<div class="modal fade" id="addDecisionModal">
  <div class="modal-dialog modal-lg">
    <form method="post" id="addDecisionForm" enctype="multipart/form-data">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="decisionModalTitle"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-3">Discussion <span class="text-danger">*</span></label>
              <div class="col-md-9">
                <textarea type="text" name="agenda_discussion" id="agenda_discussion" class="form-control"></textarea>
                <!-- <input type="text" name="agenda_discussion" id="agenda_discussion" class="form-control" /> -->
               <span id="error_meeting_agenda" class="text-danger"></span>
                
                
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <label class="col-md-3">Decision<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <textarea type="text" name="agenda_decision" id="agenda_decision" class="form-control"></textarea>
                <input type="hidden" name="decision_id" id="decision_id" class="form-control" />
                <span id="error_meeting_agenda" class="text-danger"></span>
                
                
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-3">Responsible Person<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <input type="text" name="responsible_person" id="responsible_person" class="form-control" />
                
                <span id="error_meeting_agenda" class="text-danger"></span>
                
                
              </div>
            </div>
          </div>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
<!--           <input type="hidden" name="hidden_teacher_image" id="hidden_teacher_image" value="" />
          <input type="hidden" name="teacher_id" id="teacher_id" /> -->
          <input type="hidden" name="page" value="agenda" />
          <input type="hidden" name="agendaId" id="agendaId"/>
          <input type="hidden" name="decisionAction" id="decisionAction" value="addDecision" />
          <input type="submit" name="decisionActionBtn" id="decisionActionBtn" class="btn btn-success btn-sm" value="addDecision" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

      </div>
    </form>
  </div>
</div>

<!-- End of Add/Create New Decision Section-->


<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
 
<script type="text/javascript">
  CKEDITOR.replace('agenda_decision');

  CKEDITOR.replace('agenda_discussion');

</script>

<script>

$(document).ready(function(){
    var code = "<?php echo $_GET["code"]; ?>";
    var meetingTitle = "<?php echo $_GET["title"]; ?>";
    $('#message_meetingTitle').html('<div class="alert alert-primary">'+meetingTitle+'</div>');
          var dataTable = $('#allAgendaTable').DataTable({
          "processing":true,
          "serverSide":true,
          "order":[],
          "ajax":{
           url:"all-agenda-actions.php",
           type:"POST",
           data:{action:'fetch', code:code}
          },
          "columnDefs":[
           {
            "targets": '_all',
            "defaultContent": "",
            "orderable":false,
           },
          ],
         });



        //For Agenda Part
        function clear_field(formName)
        {
          $('#'+formName)[0].reset();
          

        }
        


        $('#addAgendaBtn').click(function(){
          $('#modal_title').text("Add Agenda");
          $('#button_action').val('Add');
          $('#action').val('Add');
          $('#meeting_code').val(code);
          $('#addAgendaModal').modal('show');
          clear_field('addAgendaForm');
        });

       $('#addAgendaForm').on('submit', function(event){
        event.preventDefault();
        $.ajax({
          url:"all-agenda-actions.php",
          method:"POST",
          data:new FormData(this),
          dataType:"json",
          contentType:false,
          processData:false,
          beforeSend:function()
          {        
            $('#button_action').val('Validate...');
            $('#button_action').attr('disabled', 'disabled');
          },
          success:function(data){
            
            $('#button_action').attr('disabled', false);
            $('#button_action').val($('#action').val());
            if(data.success)
            {

              $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
              clear_field('addAgendaForm');
              $('#addAgendaModal').modal('hide');
              
              dataTable.ajax.reload();
            
              
            }

          },
          error:function(){
            console.log('Error');

          }
        });
      });

      var meeting_id = '';
       $(document).on('click', '.view_meeting', function(){
      meeting_id = $(this).attr('id');
      $.ajax({
        url:"all-metting-actions.php",
        method:"POST",
        data:{action:'single_fetch', meeting_id:meeting_id},
        success:function(data)
        {
          $('#viewMeetingModal').modal('show');
          $('#meeting_details').html(data);
        },
        error:function(data){
          console.log('Error');
        }
      });
    });

      var agenda_id='';
      $(document).on('click', '.edit_agenda', function(){
      agenda_id = $(this).attr('id');
      clear_field('addAgendaForm');
      $.ajax({
        url:"all-agenda-actions.php",
        method:"POST",
        data:{action:'fetchForEditAgenda', agenda_id:agenda_id},
        dataType:"json",
        success:function(data)
        {
          $('#meeting_agenda').val(data.agenda_title);

          $('#agenda_id').val(data.agenda_id);
          $('#modal_title').text('Edit Agenda');
          $('#button_action').val('Edit');
          $('#action').val('Edit');
          //clear_field('addAgendaForm');
          $('#addAgendaModal').modal('show');
        },
        error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
          }
      });
    });


  $(document).on('click', '.delete_agenda', function(){
    agenda_id = $(this).attr('id');
    $('#deleteAgendaModal').modal('show');
  });

  $('#ok_button').click(function(){
    $.ajax({
      url:"all-agenda-actions.php",
      method:"POST",
      data:{agenda_id:agenda_id, action:'deleteAgenda'},
      success:function(data)
      {
        
        $('#message_operation').html('<div class="alert alert-success">'+data+'</div>');
        $('#deleteAgendaModal').modal('hide');
        dataTable.ajax.reload();
      },
        error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
        }
    });

  });

    // End of the Agenda part.

    //For Decision Part
    var agendaId='';
      $(document).on('click', '.addDecisionBtn', function(){
        agendaId = $(this).attr('id');

         $('#decisionModalTitle').text("Add Discussion");
          $('#decisionAction').val('addDecision'); //Action will send through form submit
          $('#decisionActionBtn').val('Add');
          $('#agendaId').val(agendaId)
         $('#addDecisionModal').modal('show');
         clear_field('addDecisionForm');
          

    });

    $('#addDecisionForm').on('submit', function(event){
        event.preventDefault();
        CKEDITOR.instances['agenda_discussion'].updateElement();
        CKEDITOR.instances['agenda_decision'].updateElement();
        
        $.ajax({
          url:"all-agenda-actions.php",
          method:"POST",
          data:new FormData(this),
          dataType:"json",
          contentType:false,
          processData:false,
          beforeSend:function()
          {        
            $('#decisionActionBtn').val('Validate...');
            $('#decisionActionBtn').attr('disabled', 'disabled');
          },
          success:function(data){
            
            $('#decisionActionBtn').attr('disabled', false);
            $('#decisionActionBtn').val($('#decisionAction').val());
            if(data.success)
            {
              console.log(data.success);
              $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
              clear_field('addDecisionForm');
              $('#addDecisionModal').modal('hide');
              dataTable.ajax.reload();
            }

          },
          error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
          }
        });
      });


      var decision_id='';
      $(document).on('click', '.edit_decision', function(){

      decision_id = $(this).attr('id');
      clear_field('addDecisionForm');


      $.ajax({
        url:"all-agenda-actions.php",
        method:"POST",
        data:{decisionAction:'fetchForEditDecision', decision_id:decision_id}, //Action will send by initializing here
        dataType:"json",
        success:function(data)
        {
          
          CKEDITOR.instances['agenda_decision'].setData(data.decisions);
          // $('#agenda_decision').val(data.decisions);
          
          CKEDITOR.instances['agenda_discussion'].setData(data.discussion);
         //$('#agenda_discussion').val(data.discussion);

          $('#decision_id').val(data.decision_id);
          $('#decisionModalTitle').text('Edit Decision');
          $('#decisionActionBtn').val('Edit');
          $('#decisionAction').val('editDecision');
          
          $('#addDecisionModal').modal('show');
        },
        error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
          }
      });
    });


});
</script>