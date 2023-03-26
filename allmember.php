<?php
include('includes/header.php'); 
include('includes/navbar.php');
include('database/dbconfig.php');  

?>




<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
              <button type="button" class="btn btn-primary" id="addMemberBtn" data-toggle="modal" data-target="#addMember">
             <i class="fas fa-plus"></i> Add New Member/Participant 
            </button>
    </h6>
  </div>

  <div class="card-body">

    <span id="message_operation"></span>

    <div class="table-responsive">

      
          <table class="table table-bordered" id="allMemberTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Affiliation</th>
                <th>Email</th>
                <th>Actions</th>
                <th>Member Of</th>
                
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



<!-- Add/Create New Meeting Section-->

<link rel="stylesheet" href="vendor/datetimepicker/bootstrap-datetimepicker.min.css" />

<style>
    .datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>







<!-- Add/Create New Member Section-->

<div class="modal fade" id="addMemModal">
  <div class="modal-dialog modal-lg">
    <form method="post" id="addMemForm" enctype="multipart/form-data">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="memModalTitle"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group" id="addMemberDiv">
            <div class="row">
              
              <div class="col-md-3">
                <input type="text" name="participant_affiliation[]" id="participant_affiliation" class="form-control" placeholder="Affiliation" required="" />
                <span id="error_meeting_title" class="text-danger"></span>
              </div>

              <div class="col-md-3">
                <input type="text" name="participant_email[]" id="participant_email" class="form-control check_email" placeholder="Email" required="" />
                <span id="error_meeting_title" class="text-danger"></span>
                <span id="availability" class="text-danger resetAvailability"></span>
              </div>
              <label class="col-md-2 text-right">is Guest ? <span class="text-danger">*</span></label>
              <div class="col-md-2">
                <select name="isGuest[]" id="isGuest" class="form-control">
                  <option value="">Select Type</option>
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>
                </select>
                <span id="error_meeting_type_id" class="text-danger"></span>
              </div>
              <div class="form-group col-md-2">
              <button type="button" class="btn btn-sm btn-success addMoreMemberBtn" id="addMemberBtn">
              <i class="fas fa-plus"></i>
              </button>
            </div>


            </div>
          </div>
          


        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
<!--           <input type="hidden" name="hidden_teacher_image" id="hidden_teacher_image" value="" />
          <input type="hidden" name="teacher_id" id="teacher_id" /> -->
          <input type="hidden" name="page" value="setup" />
          <input type="hidden" name="participant_id" id="participant_id"/>
          <input type="hidden" name="actionForMember" id="actionForMember" value="Add" />
          <input type="submit" name="btnActionForMember" id="btnActionForMember" class="btn btn-success btn-sm" value="Add" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

      </div>
    </form>
  </div>
</div>

<!-- End of Add/Create New Member Section-->


<!-- Update Member Section-->

<div class="modal fade" id="updateMemModal">
  <div class="modal-dialog">
    <form method="post" id="updateMemForm" enctype="multipart/form-data">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="updateMemModalTitle"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Affiliation<span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="uparticipant_affiliation" id="uparticipant_affiliation" class="form-control" required="" />
                <span id="error_meeting_title" class="text-danger"></span>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Email<span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="uparticipant_email" id="uparticipant_email" class="form-control check_email" required="" />
                <span id="error_meeting_title" class="text-danger"></span>
                <span id="availability" class="text-danger"></span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">is Guest ? <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <select name="uisGuest" id="uisGuest" class="form-control">
                  <option value="">Select Type</option>
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>
                </select>
                <span id="error_meeting_type_id" class="text-danger"></span>
              </div>
            </div>
          </div>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
<!--           <input type="hidden" name="hidden_teacher_image" id="hidden_teacher_image" value="" />
          <input type="hidden" name="teacher_id" id="teacher_id" /> -->
          <input type="hidden" name="page" value="setup" />
          <input type="hidden" name="uparticipant_id" id="uparticipant_id"/>
          
          <input type="submit" name="btnActionForMember" id="btnActionForMember" class="btn btn-success btn-sm" value="Update" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

      </div>
    </form>
  </div>
</div>

<!-- End of Update Member Section-->



<!-- Delete Particant Section-->
<div class="modal" id="deleteMemModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <h3 align="center">Are you sure you want to remove this?</h3>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" name="memberOkBtn" id="memberOkBtn" class="btn btn-primary btn-sm">OK</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- Delete Particant Section-->




<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
    


<script>

$(document).ready(function(){


        $('#meeting_type_id').change(function(){

        });




  function clear_field(formName)
  {
    $('#'+formName)[0].reset();

  }





//For Participant 
    var allMemberDataTable = $('#allMemberTable').DataTable({
          "processing":true,
          "serverSide":true,
          "order":[],
          "ajax":{
           url:"setup-actions.php",
           type:"POST",
           data:{actionForMember:'fetch'}
          },
          "columnDefs":[
           {
            "width": "10%", 
            "targets": 2,
            "orderable":false,
           },
          ],
         });



  $('#addMemberBtn').click(function(){
    $('#memModalTitle').text("Add a New Member");
    $('#btnActionForMember').val('Add');
    $('#actionForMember').val('Add');
    $('#addMemModal').modal('show');
    clear_field('addMemForm');
    
  });


function checkEmail(emailField,vailabilityId){

    $('#participant_email'+emailField).blur(function(event){
      
    var participant_email=$(this).val();
    if(participant_email!=''){
    $.ajax({
    url:'setup-actions.php',
    method:'POST',
    data:{actionForMember:'checkEmail', participant_email:participant_email},
    success:function(data)
    {
    if(data != '0')
    {
    $('#availability'+vailabilityId).html('<span class="text-danger">This Member already exist</span>');
    
    // $('#btn_team_details').attr("disabled", true);
    }
    else
    {
    $('#availability'+vailabilityId).html('<span class="text-success">Name Available</span>');
    
    
    }
    }
    })
  }

  });

}
checkEmail('','');



   $('#addMemForm').on('submit', function(event){
    event.preventDefault();

    $.ajax({
      url:"setup-actions.php",
      method:"POST",
      data:new FormData(this),
      dataType:"json",
      contentType:false,
      processData:false,
      beforeSend:function()
      {        
        $('#btnActionForMember').val('Submitting...');
        $('#btnActionForMember').attr('disabled', 'disabled');
      },
      success:function(data){
        
        $('#btnActionForMember').attr('disabled', false);
        $('#btnActionForMember').val($('#actionForMember').val());
        if(data.success)
        {

          $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
          clear_field('addMemForm');
          $('#addMemModal').modal('hide');
          allMemberDataTable.ajax.reload();
        }if(data.warning)
        {

          $('#message_operation').html('<div class="alert alert-warning">'+data.warning+'</div>');
          clear_field('addMemForm');
          $('#addMemModal').modal('hide');
          $('.resetAvailability').html('');
          allMemberDataTable.ajax.reload();
        }
       
      },
      error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
    }

      
    });
  });

var i=1;

        $(".addMoreMemberBtn").click(function(eMoreMember){
          eMoreMember.preventDefault();

          if(i<6){

          $("#addMemberDiv").append(`<div class="row">
            <div class="col-md-3">
                <input type="text" name="participant_affiliation[]" id="participant_affiliation" class="form-control" placeholder="Affiliation" required="" />
                <span id="error_meeting_title" class="text-danger"></span>
              </div>

              <div class="col-md-3">
                <input type="text" name="participant_email[]" id="participant_email${i}" class="form-control " placeholder="Email" required="" />
                <span id="error_meeting_title" class="text-danger"></span>
                <span id="availability${i}" class="text-danger resetAvailability"></span>
              </div>
              <label class="col-md-2 text-right">is Guest ? <span class="text-danger">*</span></label>
              <div class="col-md-2">
                <select name="isGuest[]" id="isGuest" class="form-control">
                  <option value="">Select Type</option>
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>
                </select>
                <span id="error_meeting_type_id" class="text-danger"></span>
              </div>
            <div class="form-group col-md-2 d-grid">
              <button type="button" class="btn btn-sm btn-danger removeMoreMemberBtn" id="addMemberBtn">
              <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>`);
          checkEmail(i,i);

          i++;

          

        }

        });
        $(document).on('click', '.removeMoreMemberBtn', function(eRemoveMoreMember){
          eRemoveMoreMember.preventDefault();
          let agendaRow = $(this).parent().parent();
          $(agendaRow).remove(); i--;
        });





      var participant_id = '';

      $(document).on('click', '.editMember', function(){
      participant_id = $(this).attr('id');
      clear_field('addMemForm');
      clear_field('updateMemForm');
      $.ajax({
        url:"setup-actions.php",
        method:"POST",
        data:{actionForMember:'fetchForEditMem', participant_id:participant_id},
        dataType:"json",
        success:function(data)
        {
          $('#uparticipant_affiliation').val(data.participant_affiliation);
        
          $('#uparticipant_email').val(data.participant_email).attr('disabled',true);
          
          $('#uisGuest').val(data.isGuest);
          $('#uparticipant_id').val(data.participant_id);

          $('#updateMemModalTitle').text('Edit Member/Participant');
          
          //clear_field('addMemForm');
          $('#updateMemModal').modal('show');
        },
        error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
          }
      });
    });



  $('#updateMemForm').on('submit', function(event){
    event.preventDefault();
   var updateMemFormdata = new FormData(this);
    updateMemFormdata.append('actionForMember','Edit');

    $.ajax({
      url:"setup-actions.php",
      method:"POST",
      data:updateMemFormdata,
      dataType:"json",
      contentType:false,
      processData:false,
      beforeSend:function()
      {        
        $('#btnActionForMember').val('Submitting...');
        $('#btnActionForMember').attr('disabled', 'disabled');
      },
      success:function(data){
        
        $('#btnActionForMember').attr('disabled', false);
        $('#btnActionForMember').val($('#actionForMember').val());
        if(data.success)
        {

          $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
          clear_field('addMemForm');
          $('#addMemModal').modal('hide');
          allMemberDataTable.ajax.reload();
        }if(data.warning)
        {

          $('#message_operation').html('<div class="alert alert-warning">'+data.warning+'</div>');
          clear_field('addMemForm');
          $('#updateMemModal').modal('hide');
          allMemberDataTable.ajax.reload();
        }
       
      },
      error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
    }

      
    });
  });

  $(document).on('click', '.deleteMember', function(){
    participant_id = $(this).attr('id');
    $('#deleteMemModal').modal('show');
  });

  $('#memberOkBtn').click(function(){

    $.ajax({
      url:"setup-actions.php",
      method:"POST",
      data:{participant_id:participant_id, actionForMember:'deleteMember'},
      success:function(data)
      {
        $('#message_operation').html('<div class="alert alert-success">'+data+'</div>');
        $('#deleteMemModal').modal('hide');
        allMemberDataTable.ajax.reload();
      }
    });
  });
//Code for Participant




});
</script>