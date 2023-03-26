<?php
include('includes/header.php'); 
include('includes/navbar.php');
include('database/dbconfig.php');  

?>


<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Admin Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">

        <div class="modal-body">

            <div class="form-group">
                <label> Username </label>
                <input type="text" name="username" class="form-control" placeholder="Enter Username">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password">
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password">
            </div>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="registerbtn" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
            <button type="button" class="btn btn-primary" id="createMettingBtn" data-toggle="modal" data-target="#createMetting">
             <i class="fas fa-plus"></i> Add Meeting 
            </button>
    </h6>
  </div>

  <div class="card-body">

    <span id="message_operation"></span>

    <div class="table-responsive">

      <table class="table table-bordered" id="allMettingTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> ID </th>
            <th> Metting Title </th>
            <th> Notice Text</th>
            <th> Agenda </th>

           
            <th>Actions</th>
            <th>MOM</th>
            <th>Email MOM</th>
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

<!-- Add/Create New Meeting Section-->

<link rel="stylesheet" href="vendor/datetimepicker/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css">

<style>
    .datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>

<div class="modal fade" id="createMettingModal">
  <div class="modal-dialog modal-lg">
    <form method="post" id="createMettingForm" enctype="multipart/form-data">
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
              <label class="col-md-4 text-right">Meting Title <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="meeting_title" id="meeting_title" class="form-control" required="" />
                <span id="error_meeting_title" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Meeting Type <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <select name="meeting_type_id" id="meeting_type_id" class="form-control">
                  <option value="">Select Type</option>
                  <?php

                  echo load_meeting_types($connect);
                  ?>
                  
                </select>
                <span id="error_meeting_type_id" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Notice Text <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <textarea name="meeting_description" id="meeting_description" class="form-control"></textarea>
                <span id="error_meeting_description" class="text-danger"></span>
              </div>
            </div>
          </div>
		
				<div class="form-group">
		            <div class="row">
		              <label class="col-md-4 text-right">Mode <span class="text-danger">*</span></label>

		              <div class="col-md-8">
		                
		                <select name="meeting_mode" id="meeting_mode" class="form-control" required="">

		                  <option value="">Select Mode</option>
		                  <option value="online">Online</option>
		                  <option value="in-person">In Person</option>
		                </select>
		                <span id="" class="text-danger"></span>
		                
		              
		            </div>
		            </div>
		          </div>
		
<div class="mode" style="display:none" id="modeonline">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Meeting Link <span class="text-danger">*</span></label>

              <div class="col-md-8">
                
                <input type="text" name="meeting_link" id="meeting_link" class="form-control" required="" />
                <span id="error_meeting_venue" class="text-danger"></span>
                
              
            </div>
            </div>
          </div>
      </div>

<div class="mode" style="display:none" id="modein-person">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Venue <span class="text-danger">*</span></label>

              <div class="col-md-8">
                
                <select name="meeting_venue" id="meeting_venue" class="form-control" required="">

                  <option value="">Select venue</option>
                  
                  <option>Syndicate Room</option>
                </select>
                <span id="error_meeting_venue" class="text-danger"></span>
                
              
            </div>
            </div>
          </div>
      </div>

          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Member list Category <span class="text-danger">*</span></label>

              <div class="col-md-8">
                
                <select name="memberListCategory" id="memberListCategory" class="form-control">

                 <!--  <option value="">Select Venue</option>
                  <option selected>Online</option>
                  <option>Syndicate Room</option> -->

                  <option value="">Select Category</option>

                </select>

                <span id="error_meeting_venue" class="text-danger"></span>
                
              
            </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Member List <span class="text-danger">*</span></label>

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
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Date <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="meeting_date" id="meeting_date" class="form-control" />
                <span id="error_meeting_date" class="text-danger"></span>
              </div>
            </div>
          </div>
<!--           <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Participants <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="meeting_date" id="meeting_date" class="form-control" />
                <span id="error_meeting_date" class="text-danger"></span>
              </div>
            </div>
          </div> -->
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Start Time <span class="text-danger">*</span></label>
              <div class="col-md-2">
                <input type="text" name="meeting_stime" id="meeting_stime" class="form-control" />
                <span id="error_meeting_stime" class="text-danger"></span>
              </div>
              <label class="col-md-4 text-right">End Time <span class="text-danger">*</span></label>
              <div class="col-md-2">
                <input type="text" name="meeting_etime" id="meeting_etime" class="form-control" />
                <span id="error_meeting_etime" class="text-danger"></span>
              </div>
            </div>
          </div>


        <div class="form-group" id="addAgendaDiv">
          <div class="row">
            <label class="col-md-4 text-right">Agenda</label>
            <div class="col-md-4">
              <input type="text" name="meeting_agenda[]" id="meeting_agenda" class="form-control"/>
              <span id="error_meeting_title" class="text-danger"></span>
            </div>
            <div class="form-group col-md-4 d-grid">
              <button type="button" class="btn btn-sm btn-success addMoreAgendaBtn" id="addMemberBtn">
              <i class="fas fa-plus"></i>Add More
              </button>
            </div>
          </div>
        </div>
          

        </div>



        <!-- Modal footer -->
        <div class="modal-footer">
<!--           <input type="hidden" name="hidden_teacher_image" id="hidden_teacher_image" value="" />
          <input type="hidden" name="teacher_id" id="teacher_id" /> -->
          <input type="hidden" name="action" id="action" value="Add" />
          <input type="hidden" name="meeting_id" id="meeting_id"/>
          <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

      </div>
    </form>
  </div>
</div>

<!-- End of Add/Create New Meeting Section-->

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

<!-- Delete Meeting Section-->
<div class="modal" id="deleteMeetingModal">
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
        <button type="button" name="ok_button" id="ok_button" class="btn btn-primary btn-sm">OK</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- Delete Meeting Section-->




<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
    <script type="text/javascript" src="vendor/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
        $(function () {
            $.extend(true, $.fn.datetimepicker.defaults, {
                icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'far fa-calendar-check-o',
                    clear: 'far fa-trash',
                    close: 'far fa-times'
                }
            });
        });
</script>

<script>

$(document).ready(function(){

      $(function () {
      $('#meeting_date').datetimepicker({
                  format: 'YYYY-MM-DD',
                  ignoreReadonly: true
                  
          
          });
        });
        $(function () {
          $('#meeting_stime').datetimepicker({
            format: 'hh:mm a',
            ignoreReadonly: true
            });
        });
        $(function () {
          $('#meeting_etime').datetimepicker({
            format: 'hh:mm a',
            ignoreReadonly: true
            });
        });

        function setRequiredForMeetingMode(val,val2,val3){
                    input1 = document.getElementById(val2).getElementsByTagName(val3);
                

                    for(i = 0; i < input1.length; i++){
                        input1[i].required = val;
                    }
                    
              }

              $('#meeting_mode').on('change', function(){

              	var value;
                        value=$(this).val();
                        console.log(value);
                        if (value=='online') {
                          
                          setRequiredForMeetingMode(true,'modeonline','input');
                          setRequiredForMeetingMode(false,'modein-person','select');
                          
                          

                        }else if(value=='in-person') {
                          
                          setRequiredForMeetingMode(true,'modein-person','select');
                          setRequiredForMeetingMode(false,'modeonline','input');
                          
                          

                        }else {
                          setRequiredForMeetingMode(false,'modeonline','input');
                          setRequiredForMeetingMode(false,'modein-person','select');
                        }
                        $('.mode').hide();

                        
                        $('#mode' + $(this).val()).show();

              });

              


        function loadMemListAndCategoty(isSetMemList,memListcategory_id){
          $.ajax({

            url:"all-metting-actions.php",
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
        loadMemListAndCategoty('','');

        $('#meeting_member_list').change(function(){
        $('#hidden_meeting_member_list').val($('#meeting_member_list').val());
        console.log(hidden_meeting_member_list);
        });


        $('#memberListCategory').on('change', function(){

          var memListCategoryVal= $('#memberListCategory').val();

          if (memListCategoryVal!='') 
            {
              $("#mem_list_edit_link").attr('href', 'edit-member-list.php?id='+memListCategoryVal); 
                $('.fadr').fadeOut( 1000, function() {
                  $('.fadr').html("Edit list");
                  $('.fadr').fadeIn();
              });
            }else{
              $("#mem_list_edit_link").attr('href', 'edit-member-list');
              $('.fadr').fadeOut( 1000, function() {
                $('.fadr').html("Add list");
                $('.fadr').fadeIn();
                });
          }
          

          
          
          // $("#mem_list_edit_link").text($("#memberListCategory option:selected").text());

          // $('#mem_list_edit_link').attr('href', function (index, value) {
          // return /\?listId=/.test(value) ? value.replace(/listId=(\d+)/, 'listId=' + memListCategoryVal) : (value + '?listId=' + memListCategoryVal);
          // });

          

          loadMemListAndCategoty('isSetMemListCategory',memListCategoryVal);

        });

        var i=1;

        $(".addMoreAgendaBtn").click(function(eMoreAgenda){
          eMoreAgenda.preventDefault();
          if(i<6){

          $("#addAgendaDiv").append(`<div class="row">
            <label class="col-md-4 text-right">Agenda</label>
            <div class="col-md-4">
              <input type="text" name="meeting_agenda[]" id="meeting_agenda" class="form-control" required="" />
              <span id="error_meeting_title" class="text-danger"></span>
            </div>
            <div class="form-group col-md-4 d-grid">
              <button type="button" class="btn btn-sm btn-danger removeMoreAgendaBtn" id="addMemberBtn">
              <i class="fas fa-minus"></i> Remove
              </button>
            </div>
          </div>`);
          i++;
        }

        });
        $(document).on('click', '.removeMoreAgendaBtn', function(eRemoveMoreAgenda){
          eRemoveMoreAgenda.preventDefault();
          let agendaRow = $(this).parent().parent();
          $(agendaRow).remove(); i--;
        });



        // function loadMemListAndCategoty(){
        //   $.ajax({

        //     url:"all-metting-actions.php",
        //     method:"POST",
        //     data:{actionForMemlist:'fetch'},
        //     success:function(data)
        //     {
        //       // if (isSetMemList=='isSetMemListCategory') {
        //       //   $('#meeting_member_list').html(data);
        //       // }else{
        //       //   $('membeListCategory').append(data);
        //       // }
        //    $('#membeListCategory').append(data);
            
        //     },
        //     error:function(data){
        //     console.log('Error');
        //     }

        //   });
        // }
        // loadMemListAndCategoty();



          var dataTable = $('#allMettingTable').DataTable({
          "processing":true,
          "serverSide":true,
          "order":[],
          "ajax":{
           url:"all-metting-actions.php",
           type:"POST",
           data:{action:'fetch'}
          },
          "columnDefs":[
           {
            
            "orderable":false,
           },
          ],
         });


    // $('#meeting_date').datepicker({
    //     format: "yyyy-mm-dd",
    //     autoclose: true,
    //     container: '#createMetting modal-body'
    // });


  function clear_field()
  {
    $('#createMettingForm')[0].reset();
    $('#error_meeting_title').text('');
    $('#error_meeting_type_id').text('');
    $('#error_meeting_description').text('');
    $('#error_meeting_venue').text('');
    $('#error_meeting_date').text('');
    $('#error_meeting_stime').text('');
    $('#error_meeting_etime').text('');
    $('#error_meeting_agenda').text('');
  }

  $('#createMettingBtn').click(function(){
    $('#modal_title').text("Create New Meeting");
    $('#button_action').val('Add');
    $('#action').val('Add');
    $('#createMettingModal').modal('show');
    clear_field();
  });

   $('#createMettingForm').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"all-metting-actions.php",
      method:"POST",
      data:new FormData(this),
      dataType:"json",
      contentType:false,
      processData:false,
      beforeSend:function()
      {        
        $('#button_action').val('Submitting...');
        $('#button_action').attr('disabled', 'disabled');
      },
      success:function(data){
        
        $('#button_action').attr('disabled', false);
        $('#button_action').val($('#action').val());
        if(data.success)
        {

          $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
          clear_field();
          $('#createMettingModal').modal('hide');
          dataTable.ajax.reload();
        }
        // if(data.error)
        // { 
        //   if(data.error_meeting_title != '')
        //   {
        //     $('#error_meeting_title').text(data.error_meeting_title);
        //   }
        //   else
        //   {message_operation
        //     $('#error_meeting_title').text('');
        //   }
        //   if(data.error_meeting_type_id != '')
        //   {
        //     $('#error_meeting_type_id').text(data.error_meeting_type_id);
        //   }
        //   else
        //   {
        //     $('#error_meeting_type_id').text('');
        //   }
        //   if(data.error_meeting_description != '')
        //   {
        //     $('#error_meeting_description').text(data.error_meeting_description);
        //   }
        //   else
        //   {
        //     $('#error_meeting_description').text('');
        //   }
        //   if(data.error_meeting_vanue != '')
        //   {
        //     $('#error_meeting_vanue').text(data.error_meeting_vanue);
        //   }
        //   else
        //   {
        //     $('#error_meeting_vanue').text('');
        //   }
        //   if(data.error_meeting_date != '')
        //   {
        //     $('#error_meeting_date').text(data.error_meeting_date);
        //   }
        //   else
        //   {
        //     $('#error_meeting_date').text('');
        //   }
        //   if(data.meetingStartTime != '')
        //   {
        //     $('#meetingStartTime').text(data.meetingStartTime);
        //   }
        //   else
        //   {
        //     $('#meetingStartTime').text('');
        //   }
        //   if(data.meetingEndTime != '')
        //   {
        //     $('#meetingEndTime').text(data.meetingEndTime);
        //   }
        //   else
        //   {
        //     $('#meetingEndTime').text('');
        //   }
        //   if(data.error_meeting_agenda != '')
        //   {
        //     $('#error_meeting_agenda').text(data.error_meeting_agenda);
        //   }
        //   else
        //   {
        //     $('#error_meeting_agenda').text('');
        //   }
        // }
      },
      error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
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


     
      $(document).on('click', '.edit_meeting', function(){
      meeting_id = $(this).attr('id');
      clear_field();
      $.ajax({
        url:"all-metting-actions.php",
        method:"POST",
        data:{action:'fetchForEditMeeting', meeting_id:meeting_id},
        dataType:"json",
        success:function(data)
        {
          $('#meeting_title').val(data.meeting_title);
          $('#meeting_type_id').val(data.meeting_type_id);
          $('#meeting_description').val(data.meeting_description);
          $('#meeting_venue').val(data.meeting_venue);
          $('#meeting_date').val(data.meeting_date);
          $('#meeting_stime').val(data.meeting_stime);
          $('#meeting_etime').val(data.meeting_etime);
          $('#meeting_date').val(data.meeting_date);
          


          $('#meeting_id').val(data.meeting_id);
          $('#modal_title').text('Edit Meeting');
          $('#button_action').val('Edit');
          $('#action').val('Edit');
          //clear_field('addAgendaForm');
          $('#createMettingModal').modal('show');
        },
        error:function(message,err,xtr){
            console.log(JSON.stringify(message)+" "+err+ " " +xtr);
          }
      });
    });

  $(document).on('click', '.delete_meeting', function(){
    meeting_id = $(this).attr('id');
    $('#deleteMeetingModal').modal('show');
  });

  $('#ok_button').click(function(){
    $.ajax({
      url:"all-metting-actions.php",
      method:"POST",
      data:{meeting_id:meeting_id, action:'deleteMeeting'},
      success:function(data)
      {
        $('#message_operation').html('<div class="alert alert-success">'+data+'</div>');
        $('#deleteMeetingModal').modal('hide');
        dataTable.ajax.reload();
      }
    });
  });


});
</script>