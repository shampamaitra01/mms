<?php
session_start();
include('includes/header.php'); 
include('includes/navbar.php');

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
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-8">
								<h5>Meeting</h5>
							</div>
							<div class="col-md-4">
								<!-- <p id="1414518" style="font-size:15px;" class="float-right badge badge-secondary" title="Start time countdown"></p>
								<script>countdown("2021-09-07 12:00:00","1414518");</script> -->
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<p  style="margin-bottom:5px"><i class="fa fa-clock" aria-hidden="true"></i> <b>Start Time:</b> 2021-09-07 12:00:00</p>
							</div>
							<div class="col-md-4">
								<p  style="margin-bottom:5px"><i class="fa fa-clock" aria-hidden="true"></i> <b>Expected End Time:</b> 2021-09-07 12:29:59</p>
							</div>
							<!-- <div class="col-md-4">
								<p style="margin-bottom:5px"> <i class="fa fa-clock" aria-hidden="true"></i> <b>Duration: </b> 30 min</p>
							</div> -->
						</div>
						<div class="row">
							<div class="col-md-12">
								<span  ><i class="fa fa-comments" aria-hidden="true"></i> <b>Title:</b> <i></i></span>
								<div class='btn-group'>
									<div class="dropdown">
										<button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">Share <i class="fa fa-share-alt" aria-hidden="true"></i></button>
										<div class="dropdown-menu">
											<button class="copy_btn dropdown-item" data-clipboard-text="https://bdren.zoom.us/j/64630917582" onclick="myFunction()">
											Copy link to clipboard
											</button>
											<a  class="dropdown-item" href="whatsapp://send?text=Topic: meeting %0D%0AJoin URL: https://bdren.zoom.us/j/64630917582 %0D%0ASession ID: 64630917582 %0D%0ASession Start time: 2021-09-07 12:00:00 %0D%0APowered by BdREN" data-action="share/whatsapp/share">Share via WhatsApp</a>
											<a class="dropdown-item" href="mailto:?subject=Session Link&amp;body=Topic: meeting %0D%0AJoin URL: https://bdren.zoom.us/j/64630917582 %0D%0ASession ID: 64630917582 %0D%0ASession Start time: 2021-09-07 12:00:00 %0D%0APowered by BdREN">
												Share via Email
											</a>
										</div>
									</div>
									<div class="dropdown" style="padding-left:10px">
										<button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">Add to <i class="fa fa-calendar" aria-hidden="true"></i></button>
										<div class="dropdown-menu">
											<a href="https://calendar.google.com/calendar/r/eventedit?text=meeting&dates=20210907T060000Z/20210907T062959Z&details=Topic: meeting %0D%0AJoin URL: https://bdren.zoom.us/j/64630917582 %0D%0ASession ID: 64630917582 %0D%0ASession Start time: 2021-09-07 12:00:00 %0D%0APowered by BdREN&sf=true&output=xml" class="dropdown-item" target="_blank">Google Calender</a>
											<a class="dropdown-item" href="#" onclick='download_ics("meeting","Join URL : https://bdren.zoom.us/j/64630917582","09/07/2021 12:00 pm","09/07/2021 12:29 pm")'>Outlook Calender(.ics)</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<p style="margin-bottom:5px"><i class="fa fa-id-card" aria-hidden="true"></i><b> Venue:</b>
									<span></span></p>
								</div>
								
								
							</div>
							<div class="row">
								<div class="col-md-8">
									<i class="fa fa-info-circle" aria-hidden="true"></i><b> N.B. </b>
									<small></small>
								</div>
								<div class="col-md-4">
									<div class='btn-group float-right'>
										<div class="dropdown">
											<button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">
											Action
											</button>
											<div class="dropdown-menu">
												<a  class="dropdown-item" target="_blank" href="https://vsession.bdren.net.bd/faculty/classSchedules/1414518/edit">Edit Schedule</a>
												
												<form method="POST" action="https://vsession.bdren.net.bd/faculty/classSchedules/1414518" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="AP5UMvbI9XeEEEwxueeIsrLc9LC4zGrFSLrMwg6I">
												<button type="button" name="delete_meeting" class="badge badge-danger  delete_meeting" id=""><i class="fas fa-trash-alt"></i> Delete</button>
											</form>
											
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>

<div class="table-responsive">

      <table class="table table-bordered" id="allMettingTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> ID </th>
            
            <th> Agenda </th>

           
            <th>Actions</th>
            <th>MOM</th>
           <!--  <th>DELETE </th> -->
          </tr>
        </thead>
        <tbody>
        
        </tbody>
      </table>

    </div>

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
<?php
include('includes/scripts.php');
include('includes/footer.php');
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

});
</script>
