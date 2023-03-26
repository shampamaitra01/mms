<?php
include('includes/header.php'); 
include('includes/navbar.php');
include('database/dbconfig.php');  

?>



<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">


  <div class="card-body">

    <span id="message_operation"></span>
<!-- Tab Nav Menu-->
      <nav>
        <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-meetintype-tab" data-toggle="tab" href="#nav-meetintype" role="tab" aria-controls="nav-meetintype" aria-selected="true">Meeting Types</a>
          <a class="nav-item nav-link" id="nav-venues-tab" data-toggle="tab" href="#nav-venues" role="tab" aria-controls="nav-venues" aria-selected="false">Venues</a>
          <a class="nav-item nav-link" id="nav-member-tab" data-toggle="tab" href="#nav-member" role="tab" aria-controls="nav-member" aria-selected="false">Member/Participant</a>
          
        </div>
      </nav>
  <!-- Tab Nav Menu-->
      <div class="tab-content" id="nav-tabContent">
        <!-- Tab content for Add new Meeting type Start-->
        <div class="tab-pane fade show active" id="nav-meetintype" role="tabpanel"aria-labelledby="nav-meetintype-tab">
      
          <button type="button" class="btn btn-primary" id="addMtypeBtn" data-toggle="modal" data-target="#addMtype">
             <i class="fas fa-plus"></i> Add Meeting type 
            </button>
<!--             <select type="button" class="btn btn-success" name="meeting_type_id" id="meeting_type_id"> 
                  <option value="">Select meeting Type</option>
                  <?php

                  echo load_meeting_types($connect);
                  ?>
              </select> --> 

          <div class="table-responsive mt-2">
          <table class="table table-bordered" id="allMTypeTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th> ID </th>
                <th>Metting Type</th>
                <th>Actions</th>

                
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>


        </div>
        <!-- Tab content for Add new Meeting type End-->

        <!-- Tab content for Add new Venue-->

        <div class="tab-pane fade" id="nav-venues" role="tabpanel" aria-labelledby="nav-venues-tab">
            <button type="button" class="btn btn-primary" id="addVenueBtn" data-toggle="modal" data-target="#addvenue">
             <i class="fas fa-plus"></i> Add Venue 
            </button>


          <div class="table-responsive mt-2">
          <table class="table table-bordered" id="allVenueTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>venue</th>
                <th>Actions</th>

                
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
        </div>
        <!-- Tab content for Add new Venue-->

        <!-- Tab content for Participant-->
        <div class="tab-pane fade" id="nav-member" role="tabpanel" aria-labelledby="nav-member-tab">
          <button type="button" class="btn btn-primary" id="addMemberBtn" data-toggle="modal" data-target="#addMember">
             <i class="fas fa-plus"></i> Add Member/Participant 
            </button>


          <div class="table-responsive mt-2">
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


<!-- Add/Create New Meeting Type Section-->

<div class="modal fade" id="addMTypeModal">
  <div class="modal-dialog">
    <form method="post" id="addMTypeForm" enctype="multipart/form-data">
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
              <label class="col-md-4 text-right">Meting Type <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="meeting_type" id="meeting_type" class="form-control" />
             
                <input type="hidden" name="meeting_code" id="meeting_code"/>
                
              </div>
            </div>
          </div>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
<!--           <input type="hidden" name="hidden_teacher_image" id="hidden_teacher_image" value="" />
          <input type="hidden" name="teacher_id" id="teacher_id" /> -->
          <input type="hidden" name="page" value="setup" />
          <input type="hidden" name="mtype_id" id="mtype_id"/>
          <input type="hidden" name="actionAddMtype" id="actionAddMtype" value="Add" />
          <input type="submit" name="btnActionAddMtype" id="btnActionAddMtype" class="btn btn-success btn-sm" value="Add" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

      </div>
    </form>
  </div>
</div>

<!-- End of Add/Create New Meeting type Section-->



<!-- Delete Meeting type Section-->
<div class="modal" id="deleteMtypeModal">
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
        <button type="button" name="mTypeOkBtn" id="mTypeOkBtn" class="btn btn-primary btn-sm">OK</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- Delete Meeting type Section-->



<!-- Add Venue Section-->
<div class="modal fade" id="addVenueModal">
  <div class="modal-dialog">
    <form method="post" id="addVenueForm" enctype="multipart/form-data">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="venuemodal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Venue<span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="venue_name" id="venue_name" class="form-control" />
             
                <input type="hidden" name="meeting_code" id="meeting_code"/>
                
              </div>
            </div>
          </div>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="page" value="setup" />
          <input type="hidden" name="venue_id" id="venue_id"/>
          <input type="hidden" name="actionForVenue" id="actionForVenue" value="Add" />
          <input type="submit" name="btnActionForVenue" id="btnActionForVenue" class="btn btn-success btn-sm" value="Add" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

      </div>
    </form>
  </div>
</div>

<!-- End of Add/Create Venue Section-->

<!-- Delete Venue Section-->
<div class="modal" id="deleteVenueModal">
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
        <button type="button" name="venueOkBtn" id="venueOkBtn" class="btn btn-primary btn-sm">OK</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- Delete Venue Section-->


<!-- Add/Create New Member Section-->

<div class="modal fade" id="addMemModal">
  <div class="modal-dialog">
    <form method="post" id="addMemForm" enctype="multipart/form-data">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="memModalTitle"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Affiliation<span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="participant_affiliation" id="participant_affiliation" class="form-control" required="" />
                <span id="error_meeting_title" class="text-danger"></span>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Email<span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="participant_email" id="participant_email" class="form-control check_email" required="" />
                <span id="error_meeting_title" class="text-danger"></span>
                <span id="availability" class="text-danger"></span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">is Guest ? <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <select name="isGuest" id="isGuest" class="form-control">
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

<!-- Assign Membership Section-->
<div class="modal" id="assignMemshipModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <h3 align="center">Are you sure you want to save this?</h3>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" name="memshipAssignOkBtn" id="memshipAssignOkBtn" class="btn btn-primary btn-sm">OK</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        
      </div>

    </div>
  </div>
</div>
<!-- Assign Membership Section-->



<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
    


<script>

$(document).ready(function(){


        $('#meeting_type_id').change(function(){

        });

        //Code for Meeting Types

          var allMTypeDataTable = $('#allMTypeTable').DataTable({
          "processing":true,
          "serverSide":true,
          "order":[],
          "ajax":{
           url:"setup-actions.php",
           type:"POST",
           data:{actionAddMtype:'fetch'}
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

  $('#addMtypeBtn').click(function(){
    $('#modal_title').text("Add New Meeting type");
    $('#btnActionAddMtype').val('Add');
    $('#actionAddMtype').val('Add');
    $('#addMTypeModal').modal('show');
    clear_field('addMTypeForm');
  });





   $('#addMTypeForm').on('submit', function(event){
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
        $('#btnActionAddMtype').val('Submitting...');
        $('#btnActionAddMtype').attr('disabled', 'disabled');
      },
      success:function(data){
        
        $('#btnActionAddMtype').attr('disabled', false);
        $('#btnActionAddMtype').val($('#actionAddMtype').val());
        if(data.success)
        {

          $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
          clear_field('addMTypeForm');
          $('#addMTypeModal').modal('hide');
          allMTypeDataTable.ajax.reload();
        }
       
      },
      error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
          }

      
    });
  });
      var mtype_id = '';

      $(document).on('click', '.editMtype', function(){
      mtype_id = $(this).attr('id');
      clear_field('addMTypeForm');
      $.ajax({
        url:"setup-actions.php",
        method:"POST",
        data:{actionAddMtype:'fetchForEditMtype', mtype_id:mtype_id},
        dataType:"json",
        success:function(data)
        {
          $('#meeting_type').val(data.meeting_type);
        
          $('#mtype_id').val(data.mtype_id);
          $('#modal_title').text('Edit Meeting Type');
          $('#btnActionAddMtype').val('Edit');
          $('#actionAddMtype').val('Edit');
          //clear_field('addAgendaForm');
          $('#addMTypeModal').modal('show');
        },
        error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
          }
      });
    });

  $(document).on('click', '.deleteMtype', function(){
    mtype_id = $(this).attr('id');
    $('#deleteMtypeModal').modal('show');
  });

  $('#mTypeOkBtn').click(function(){
    $.ajax({
      url:"setup-actions.php",
      method:"POST",
      data:{mtype_id:mtype_id, actionAddMtype:'deleteMtype'},
      success:function(data)
      {
        $('#message_operation').html('<div class="alert alert-success">'+data+'</div>');
        $('#deleteMtypeModal').modal('hide');
        allMTypeDataTable.ajax.reload();
      }
    });
  });

  // End Codes for Meeting types

//For venue 
    var allVenueDataTable = $('#allVenueTable').DataTable({
          "processing":true,
          "serverSide":true,
          "order":[],
          "ajax":{
           url:"setup-actions.php",
           type:"POST",
           data:{actionForVenue:'fetch'}
          },
          "columnDefs":[
           {
            
            "orderable":false,
           },
          ],
         });



  $('#addVenueBtn').click(function(){
    $('#venuemodal_title').text("Add a New venue");
    $('#btnActionForVenue').val('Add');
    $('#actionForVenue').val('Add');
    $('#addVenueModal').modal('show');
    clear_field('addVenueForm');
    
  });



   $('#addVenueForm').on('submit', function(event){
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
        $('#btnActionForVenue').val('Submitting...');
        $('#btnActionForVenue').attr('disabled', 'disabled');
      },
      success:function(data){
        
        $('#btnActionForVenue').attr('disabled', false);
        $('#btnActionForVenue').val($('#actionForVenue').val());
        if(data.success)
        {

          $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
          clear_field('addVenueForm');
          $('#addVenueModal').modal('hide');
          allVenueDataTable.ajax.reload();
        }
       
      },
      error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
          }

      
    });
  });
      var venue_id = '';

      $(document).on('click', '.editVenue', function(){
      venue_id = $(this).attr('id');
      clear_field('addVenueForm');
      $.ajax({
        url:"setup-actions.php",
        method:"POST",
        data:{actionForVenue:'fetchForEditVenue', venue_id:venue_id},
        dataType:"json",
        success:function(data)
        {
          $('#venue_name').val(data.venue_name);
        
          $('#venue_id').val(data.venue_id);
          $('#venuemodal_title').text('Edit Venue');
          $('#btnActionForVenue').val('Edit');
          $('#actionForVenue').val('Edit');
          //clear_field('addAgendaForm');
          $('#addVenueModal').modal('show');
        },
        error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
          }
      });
    });

  $(document).on('click', '.deleteVenue', function(){
    venue_id = $(this).attr('id');
    $('#deleteVenueModal').modal('show');
  });

  $('#venueOkBtn').click(function(){
    $.ajax({
      url:"setup-actions.php",
      method:"POST",
      data:{venue_id:venue_id, actionForVenue:'deleteVenue'},
      success:function(data)
      {
        $('#message_operation').html('<div class="alert alert-success">'+data+'</div>');
        $('#deleteVenueModal').modal('hide');
        allVenueDataTable.ajax.reload();
      }
    });
  });
//Code for Venue End

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


    $('.check_email').blur(function(event){
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
    $('#availability').html('<span class="text-danger">This Member already exist</span>');
    
    // $('#btn_team_details').attr("disabled", true);
    }
    else
    {
    $('#availability').html('<span class="text-success">Name Available</span>');
    
    
    }
    }
    })
}

  });





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
          allMemberDataTable.ajax.reload();
        }
       
      },
      error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
    }

      
    });
  });
      var participant_id = '';

      $(document).on('click', '.editMember', function(){
      participant_id = $(this).attr('id');
      clear_field('addMemForm');
      $.ajax({
        url:"setup-actions.php",
        method:"POST",
        data:{actionForMember:'fetchForEditMem', participant_id:participant_id},
        dataType:"json",
        success:function(data)
        {
          $('#participant_affiliation').val(data.participant_affiliation);
        
          $('#participant_email').val(data.participant_email);
          
          $('#isGuest').val(data.isGuest);
          $('#participant_id').val(data.participant_id);

          $('#memModalTitle').text('Edit Member/Participant');
          $('#btnActionForMember').val('Edit');
          $('#actionForMember').val('Edit');
          //clear_field('addMemForm');
          $('#addMemModal').modal('show');
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

//Membership Assign 

    $(document).on('click', '.assignMemshipBtn', function(){
      participant_id2 = $(this).attr('id');

      if (confirm('Are you sure?')) {

        $(document).on('submit','#assignMemShip_form'+participant_id2, function(event){
        event.preventDefault();
        var assignMemShipformData = new FormData(this);

        assignMemShipformData.append('actionForMember','assignMemberShip');

        for(var pair of assignMemShipformData.entries()) {
          console.log(pair[0]+ ', '+ pair[1]);
          }


        $.ajax({
          url:"setup-actions.php",
          method:"POST",
          data:assignMemShipformData,
          dataType:"json",
          contentType: false,
          processData: false,
          error: function (error) {
          console.log(error);
          },
          success:function(data)
          {
            $('#message_operation').html('<div class="alert alert-success">'+data+'</div>');
            $('#assignMemshipModal').modal('hide');
            allMemberDataTable.ajax.reload();
          },
          error:function(message,err,xtr){
          console.log(JSON.stringify(message)+" "+err+ " " +xtr);
          }
         });

        });
      }

    });

  // $('#memshipAssignOkBtn').click(function(){

  //   $.ajax({
  //     url:"setup-actions.php",
  //     method:"POST",
  //     data:formData,
  //     success:function(data)
  //     {
  //       $('#message_operation').html('<div class="alert alert-success">'+data+'</div>');
  //       $('#assignMemshipModal').modal('hide');
  //       allMemberDataTable.ajax.reload();
  //     }
  //   });
  // });





// $('#memshipAssignOkBtn').click(function(){

// $('#assignMemshipSaveBtn1').trigger('click');

// $(document).on('submit','#assignMemShip_form1', function(event){
// event.preventDefault();

//     $.ajax({
//       url:"setup-actions.php",
//       method:"POST",
//       data:{actionForMember:'assignMemberShip'},
//       success:function(data)
//       {
//         $('#message_operation').html('<div class="alert alert-success">'+data+'</div>');
//         $('#assignMemshipModal').modal('hide');
//         allMemberDataTable.ajax.reload();
//       }
//     });



 
//  });



// });


// $(document).on('submit','#assignMemShip_form1', function(event){
//     event.preventDefault(); 


//     $.ajax({
//       url:"setup-actions.php",
//       method:"POST",
//       data:{actionForMember:'assignMemberShip'},
//       success:function(data)
//       {
//         $('#message_operation').html('<div class="alert alert-success">'+data+'</div>');
//         $('#assignMemshipModal').modal('hide');
//         allMemberDataTable.ajax.reload();
//       }
//     });

//   });

// $('#assignMemShip_form').on('submit', function(event){
//     event.preventDefault();
//     var formData = new FormData(this);
   
//     $.ajax({
//       url:"setup-actions.php",
//       method:"POST",
//       data:formData,
//       dataType:"json",
//       contentType:false,
//       processData:false,
      
//       success:function(data){
        
        
//         if(data.success)
//         {

//           $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
          
//           allMemberDataTable.ajax.reload();
//         }
       
//       },
//       error:function(message,err,xtr){
//             console.log(JSON.stringify(message)+" "+err+ " " +xtr);
//     }

      
//     });
//   });




});
</script>