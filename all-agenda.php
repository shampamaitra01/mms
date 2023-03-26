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
              Add Agenda 
            </button>
            <a href="all-meeting" class="btn btn-warning">All Meeting</a>
    </h6>
  </div>

  <div class="card-body">

    <span id="message_operation"></span>

    <div class="table-responsive">

      <table class="table table-bordered" id="allAgendaTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> ID </th>
            <th> Agenda Title </th>
            

            <th>VIEW</th>
            <th>EDIT </th>
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


<!-- Add/Create New Genda Section-->


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
          <input type="hidden" name="action" id="action" value="Add" />
          <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

      </div>
    </form>
  </div>
</div>

<!-- End of Add/Create New Agenda Section-->




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
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
<script type="text/javascript">
  CKEDITOR.replace('editor');
</script> 


<script>

$(document).ready(function(){

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
            
            "orderable":false,
           },
          ],
         });




  function clear_field()
  {
    $('#addAgendaForm')[0].reset();
    $('#error_meeting_agenda').text('');

  }

  $('#addAgendaBtn').click(function(){
    $('#modal_title').text("Add Agenda");
    $('#button_action').val('Add');
    $('#action').val('Add');
    $('#addAgendaModal').modal('show');
    clear_field();
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
          clear_field();
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


});
</script>