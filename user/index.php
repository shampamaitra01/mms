<?php
//session_start();
include(dirname(__FILE__).'/header.php'); 
include(dirname(__FILE__).'/navbar.php');

?>


<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    
  </div>

  <!-- Content Row -->
 
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<i class="fa fa-align-justify"></i>
				Upcoming Schedules
			</div>
			<div class="card-body">
				<script src="https://vsession.bdren.net.bd/public/assets/countdown.custom.js" ></script>
				<script src="https://vsession.bdren.net.bd/public/assets/ics_export.js" ></script>
				

<div class="table-responsive">

      <table class="table " id="allMettingTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            
            
            <th class="text-center">Meeting</th>
           <!--  <th>DELETE </th> -->
          </tr>
        </thead>
        <tbody>
        
        </tbody>
      </table>

    </div>

				
				<div class="pull-right mr-3">
                                     
        </div>
        
			</div>
		</div>
	</div>
</div>
<!-- Content Row -->


    
</div>

<!-- Delete Meeting Section-->
<div class="modal" id="jointingNotModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <h3 align="center">Are you sure you'll not joining the meeting?</h3>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" name="joiningNot" id="joiningNot" class="btn btn-primary btn-sm">OK</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- Delete Meeting Section-->


<!-- Add User Comment Section-->

<div class="modal fade" id="userCommentModal">
  <div class="modal-dialog">
    <form method="post" id="userCommentForm" enctype="multipart/form-data">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="commentModalTitle"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Write your comment here <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="user_comment" id="user_comment" class="form-control" />
               <span id="error_meeting_agenda" class="text-danger"></span>
                
                
              </div>
            </div>
          </div>

          
     

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="page" value="agenda" />
          <input type="hidden" name="agendaId" id="agendaId"/>
          <input type="hidden" name="commentAction" id="commentAction" value="addComment" />
          <input type="submit" name="decisionActionBtn" id="decisionActionBtn" class="btn btn-success btn-sm" value="addDecision" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

      </div>
    </form>
  </div>
</div>

<!-- End of User Comment Section-->

<!-- View Agenda Section-->
<div class="modal fade" id="viewAgendaModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Meeting Agenda</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" id="agenda_details">

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- View Agenda Section-->

<?php
include(dirname(__FILE__).'/scripts.php');
include(dirname(__FILE__).'/footer.php');
?>
<script>

$(document).ready(function(){

var dataTable = $('#allMettingTable').DataTable({
          "processing":true,
          "serverSide":true,
          "order":[],
          "ajax":{
           url:"user-actions.php",
           type:"POST",
           data:{action:'fetch'}
          },
          "columnDefs":[
           {
            
            "orderable":false,
           },
          ],
         });

	function clear_field(formName)
        {
          $('#'+formName)[0].reset();
          

        }
        

$(document).on('click', '.addUserCommentBtn', function(){
        agendaId = $(this).attr('id');

         $('#commentModalTitle').text("Add Comment");
          $('#commentAction').val('addComment'); //Action will send through form submit
          $('#decisionActionBtn').val('Add');
          $('#agendaId').val(agendaId)
         $('#userCommentModal').modal('show');
         clear_field('addDecisionForm');
         

    });

var meeting_id = '';
     $(document).on('click', '.view_agenda', function(){
    meeting_id = $(this).attr('id');
    $.ajax({
      url:"user-actions.php",
      method:"POST",
      data:{action:'fetchAgenda', meeting_id:meeting_id},
      success:function(data)
      {
        $('#viewAgendaModal').modal('show');
        $('#agenda_details').html(data);
      },
      error:function(data){
        console.log('Error');
      }
    });
  });






});
</script>
