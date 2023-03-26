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
      
      <div class="row">
        
        <div class="form-group col-md-2">
           <a href="allmember" class="btn btn-outline-success"><i class="fas fa-align-justify"></i> All Member</a>
        </div>

        <div class="form-group col-md-2">
           <a href="member-list" class="btn btn-outline-success"><i class="fas fa-align-justify"></i> See All List</a>
        </div>
        
      </div>
         </h6>
    </div>
    
 

  <div class="card-body">
    <span id="message_operation"></span>

    <form method="post" id="memListUpdateForm" enctype="multipart/form-data">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-center">Select Member from list <span class="text-danger">*</span></label>

              <div class="col-md-7">
                <div class="input-group">
                <select name="meeting_member_list" id="meeting_member_list" class="form-control meeting_member_list selectpicker" multiple data-live-search="true">

                  
                </select>
                <input type="hidden" name="hidden_meeting_member_list" id="hidden_meeting_member_list" />
                <span id="error_meeting_venue" class="text-danger"></span>
                <input type="hidden" name="memListcategory_id" id="memListcategory_id" />
              </div>
            </div>
            </div>
          </div>


          <div class="form-group">
            <div class="row">
              <label class="col-md-4"></label>

              <div class="col-md-4 text-right">
                <div class="input-group">
               
                <span id="error_meeting_venue" class="text-danger"></span>
                
                

                <input type="submit" name="memListUpdateBtn" id="memListUpdateBtn" class="btn btn-success btn-sm" value="Update" />
              </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
               
               <button type="button" class="btn btn-primary btn-sm" id="addMemberBtn" data-toggle="modal" data-target="#addMember">
          <i class="fas fa-plus"></i> Add New Member/Participant
          </button>
              </div>
            </div>

            </div>
          </div>

</form>
  </div>
</div>
</div>
<!-- /.container-fluid -->


<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css">


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




<div class="container-fluid">
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
      
      <div class="row">
        <div class="form-group col-md-4">
          <button type="button" class="btn btn-primary" id="addMlistTypeBtn" data-toggle="modal" data-target="#addMlistType">
             <i class="fas fa-plus"></i> Create New list 
            </button>
        </div>
          
      </div>
         </h6>
    </div>
    
 

  <div class="card-body">
    <span id="message_operation"></span>
    <div class="table-responsive">
      <table class="table table-bordered" id="allMlistTypeTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th> ID </th>
                <th>Member list Category</th>
                <th>Actions</th>

                
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





<!-- Add/Create New Mem list Catego Type Section-->

<div class="modal fade" id="addMlistTypeModal">
  <div class="modal-dialog">
    <form method="post" id="addMlistTypeForm" enctype="multipart/form-data">
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
              <label class="col-md-4 text-right">Name of the list<span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="memListType_name" id="memListType_name" class="form-control" />
             
                <input type="hidden" name="meeting_code" id="meeting_code"/>
                
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Members' of the List <span class="text-danger">*</span></label>

              <div class="col-md-8">
                <div class="input-group">
                <select name="meeting_member_list" id="meeting_member_list" class="form-control meeting_member_list selectpicker" multiple data-live-search="true">

                  
                </select>
                <span id="error_meeting_venue" class="text-danger"></span>
                <input type="hidden" name="hidden_meeting_member_list" id="hidden_meeting_member_list" />
                <span class="input-group-btn">
                  <a href="member-list.php" id="mem_list_edit_link" target="_blank"><button class="btn btn-default" type="button"><div class="fadr">Add List</div></button></a>
                </span>
              </div>
            </div>
            </div>
          </div>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
<!--           <input type="hidden" name="hidden_teacher_image" id="hidden_teacher_image" value="" />
          <input type="hidden" name="teacher_id" id="teacher_id" /> -->
          <input type="hidden" name="page" value="setup" />
          <input type="hidden" name="memListType_id" id="memListType_id"/>
          <input type="hidden" name="actionAddMlistType" id="actionAddMlistType" value="Add" />
          <input type="submit" name="actionAddMlistTypeBtn" id="actionAddMlistTypeBtn" class="btn btn-success btn-sm" value="Add" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

      </div>
    </form>
  </div>
</div>

<!-- End of Add/Create New Meeting type Section-->



<!-- Delete Meeting type Section-->
<div class="modal" id="deleteMlistTypeModal">
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
        <button type="button" name="memListDelOkBtn" id="memListDelOkBtn" class="btn btn-primary btn-sm">OK</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- Delete Meeting type Section-->





<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>   


<script>

$(document).ready(function(){

var mListCode='';
		var mListCode = "<?php echo $_GET["id"]; ?>";

        //Code for Member Catory Types

 function loadMemListAndCategoty(isSetMemList,memListcategory_id){
          $.ajax({

            url:"member-list-actions.php",
            method:"POST",
            data:{actionForMemlist:'fetch', isSetMemList:isSetMemList, memListcategory_id:memListcategory_id},
            success:function(data)
            {
              if (isSetMemList=='isSetMemListCategory') {

                

                $('#meeting_member_list').html(data);

                $('#meeting_member_list').selectpicker('refresh');

                
              }else{
                $('#memberListCategory').append(data);
              }
           
            
            },
            error:function(data){
            console.log('Error');
            }

          });
        }
        loadMemListAndCategoty('isSetMemListCategory',mListCode);        


        //Code for Member Catory Types

          var allMlistTypeTable = $('#allMlistTypeTable').DataTable({
          "processing":true,
          "serverSide":true,
          "order":[],
          "ajax":{
           url:"member-list-actions.php",
           type:"POST",
           data:{actionAddMlistType:'fetch'}
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

  $('#addMlistTypeBtn').click(function(){
    $('#modal_title').text("Add New list");
    $('#actionAddMlistTypeBtn').val('Add');
    $('#actionAddMlistType').val('Add');
    $('#addMlistTypeModal').modal('show');
    clear_field('addMlistTypeForm');
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




   $('#addMlistTypeForm').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"member-list-actions.php",
      method:"POST",
      data:new FormData(this),
      dataType:"json",
      contentType:false,
      processData:false,
      beforeSend:function()
      {        
        $('#actionAddMlistTypeBtn').val('Submitting...');
        $('#actionAddMlistTypeBtn').attr('disabled', 'disabled');
      },
      success:function(data){
        
        $('#actionAddMlistTypeBtn').attr('disabled', false);
        $('#actionAddMlistTypeBtn').val($('#actionAddMlistType').val());
        if(data.success)
        {

          $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
          clear_field('addMlistTypeForm');
          $('#addMlistTypeModal').modal('hide');
          allMlistTypeTable.ajax.reload();
        }
       
      },
      error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
          }

      
    });
  });    
      var memListcatego_id = '';

      $(document).on('click', '.editMlistType', function(){
      memListType_id = $(this).attr('id');
      clear_field('addMlistTypeForm');
      $.ajax({
        url:"member-list-actions.php",
        method:"POST",
        data:{actionAddMlistType:'fetchForEditMlistType', memListType_id:memListType_id},
        dataType:"json",
        success:function(data)
        {
          $('#memListType_name').val(data.memListType_name);
        
          $('#memListType_id').val(data.memListType_id);
          $('#modal_title').text('Edit List Name');
          $('#actionAddMlistTypeBtn').val('Edit');
          $('#actionAddMlistType').val('Edit');
          //clear_field('addAgendaForm');
          $('#addMlistTypeModal').modal('show');
        },
        error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
          }
      });
    });

  $(document).on('click', '.deleteMlistType', function(){
    memListType_id = $(this).attr('id');
    $('#deleteMlistTypeModal').modal('show');
  });

  $('#memListDelOkBtn').click(function(){
    $.ajax({
      url:"member-list-actions.php",
      method:"POST",
      data:{memListType_id:memListType_id, actionAddMlistType:'deleteMlistType'},
      success:function(data)
      {
        $('#message_operation').html('<div class="alert alert-success">'+data+'</div>');
        $('#deleteMlistTypeModal').modal('hide');
        allMlistTypeTable.ajax.reload();
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


  fill_allMemberDatatable();
  
  function fill_allMemberDatatable(memListCategoryId = '')
  {
   var allMemberDataTable = $('#allMemberTable').DataTable({
    "processing" : true,
    "serverSide" : true,
    "order" : [],
    "ajax" : {
     url:"member-list-actions.php",
     type:"POST",
     data:{actionForMember:'fetch',memListCategoryId:memListCategoryId}


    },
    "columnDefs":[
           {
            "width": "10%", 
            "targets": 2,
            "orderable":false,
           },
          ],

   });

  }

    $('#filterMemList').click(function(){
   var memListCategoryId = $('#memListCategory').val();
  
   if(memListCategoryId != '' )
   {
    $('#allMemberTable').DataTable().destroy();
    fill_allMemberDatatable(memListCategoryId);
   }
   else if(memListCategoryId == '')
   {
    
    $('#allMemberTable').DataTable().destroy();
    fill_allMemberDatatable();
   }
  });

    // var allMemberDataTable = $('#allMemberTable').DataTable({
    //       "processing":true,
    //       "serverSide":true,
    //       "order":[],
    //       "ajax":{
    //        url:"member-list-actions.php",
    //        type:"POST",
    //        data:{actionForMember:'fetch'}
    //       },
    //       "columnDefs":[
    //        {
    //         "width": "10%", 
    //         "targets": 2,
    //         "orderable":false,
    //        },
    //       ],
    //      });






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
$('#meeting_member_list').change(function(){
        $('#hidden_meeting_member_list').val($('#meeting_member_list').val());
        console.log(hidden_meeting_member_list);
        });

    $('#memListUpdateBtn').on('click', function(){
      
      $('#memListcategory_id').val(mListCode);

      if (confirm('Are you sure?')) {

        $('#memListUpdateForm').on('submit', function(event){
        event.preventDefault();
        var memListUpdateData = new FormData(this);

        memListUpdateData.append('actionForMemlist','memListUpdate');

        for(var pair of memListUpdateData.entries()) {
          console.log(pair[0]+ ', '+ pair[1]);
          }


        $.ajax({
          url:"member-list-actions.php",
          method:"POST",
          data:memListUpdateData,
          dataType:"json",
          contentType: false,
          processData: false,
          error: function (error) {
          console.log(error);
          },
          success:function(data)
          {
            $('#message_operation').html('<div class="alert alert-success">'+data+'</div>');
            
            $('#meeting_member_list').selectpicker('refresh');
          },
          error:function(message,err,xtr){
          console.log(JSON.stringify(message)+" "+err+ " " +xtr);
          }
         });

        });
      }

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



});
</script>