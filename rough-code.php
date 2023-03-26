   $sub_array[]= '<div class="card">
   <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <span style="margin-bottom:5px"><i class="fa fa-comments" aria-hidden="true"></i> <b>Meeting Title:</b> <i></i>'.$row["meeting_title"].'</span>
                  </div>
                  <div class="col-md-4">
                    
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <p  style="margin-bottom:5px"><i class="fa fa-clock" aria-hidden="true"></i> <b>Start Time:</b>'.$row["meeting_date"].', '.$row["meeting_stime"].'</p>
                  </div>
                  <div class="col-md-6">
                    <p  style="margin-bottom:5px"><i class="fa fa-clock" aria-hidden="true"></i> <b>Expected End Time:</b> '.$row["meeting_date"].', '.$row["meeting_etime"].'</p>
                  </div>
                  
                </div>

              

            <div class="row">
              <div class="col-md-6">
                <p style="margin-bottom:5px"><i class="fa fa-id-card" aria-hidden="true"></i><b> Venue:</b>
                  <span>'.$row["meeting_venue"].'</span></p>
                </div>
            </div>
            <div class="row">
                  <div class="col-md-8">
                    <i class="fa fa-info-circle" aria-hidden="true"></i><b> N.B. </b>
                    <small>'.$row["meeting_description"].'</small>
                  </div>
                  <div class="col-md-4">
                    <div class="btn-group float-right">
                      <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">
                        Action
                        </button>
                        <div class="dropdown-menu">
                          
                          
                          <form method="POST" action="" accept-charset="UTF-8">
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="button" name="delete_meeting" class="dropdown-item delete_meeting" id=""><i class="far fa-calendar-check"></i> Attending</button>
                            <button type="button"  class="dropdown-item addUserCommentBtn" id="'.$row["id"].'" data-toggle="modal" data-target="#createDecision"><i class="far fa-dot-circle"></i> May be</button>
                          </form>
                          
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
            <div class="row">
              <div class="col-md-12">
                
                <button type="button" name="view_agenda" class="btn btn-outline-success btn-sm view_agenda" id="'.$row["id"].'"><i class="fas fa-eye"></i> View Agenda</button>
                
              </div>
            </div>


        </div></div>';

        $output.='<button type="submit" class="btn btn-sm btn-primary assignMemshipBtn" name="assignMemshipBtn" id="'.'assignMemShip_form'.$row["id"].'"'.' value="Save">Save</button>




        
Webslesson
PHP, MySql, Jquery, AngularJS, Ajax, Codeigniter, Laravel Tutorial

    Home
    Tutorial
    Tools
    Demos
    About Us
    Write for Us
    Privacy Policy
    Terms and Condition
    Contact Me

Add Remove Dynamic HTML Fields using JQuery Plugin in PHP
 Webslesson     06:02     add-more-fields-jquery, add-more-fields-jquery-demo, add-more-in-jquery, dynamic-form, dynamically-add-form-fields-jquery, dynamically-add-input-fields-to-form, jquery-dynamically-add-form-fields     12 comments   


In this tutorial, We are going learn How can we generate dynamic html fields by using Jquery plugin and insert dynamic generated html fields data into Mysql table by using PHP with Ajax. Here we have use Jquery repeater plugin for generate dynamic input fields with add more and remove button in HTML form. When we have work on my project then in that we want to require to generate dynamic html of 10 input fields in my form. So, at that time we have write jquery code for generate dynamic html fields, after write number of lines of jquery code we have make to generate 10 dynamic html fields. But after that our website speed has been down. So at that time we have search some jquery plugin which help us to generate dynamic html fields. So we have found this jquery repeater pluging. By using this plugin we can easily add or remove dynamic html fields in our form.

So, here we have share this tutorial for those web developer who has working on forms with multiple input fields. For Insert multiple input fields that we want to dynamically generate input fields by writing many number of lines of jquery code depends on our input fields requirement. But by using this jquery repeater plugin this type of generating dynamic html fields process will become much easier. This JQuery plugin is also very useful for adding multiple form items in PHP because it will generate same name which we have define under data-name attribute. So, in this post we have describe how can we have use this plugin for generating input fields dynamically in a form and submit that dynamically genetated input fields values into database by using Ajax with PHP.


If we want to make functionality like generate dynamic html input fields in our form then by using this plugin we can make this feature by writing very short code. We can add or remove dynamically generated input fields very easily. After this we want to process that multiple fields and insert into mysql table. For this we have use Ajax request, by using ajax request we have submit dynamic generated html input fields data to php script. So, by using ajax we can insert dynamic input fields data into mysql table without refresh of web page and after inserting multiple input fields data into database then form will be clear. So, in this tutorial we have seen how to generate dynamic input fields by using Jquery repeater plugin and insert into mysql by using Ajax with PHP.







View Demo


Source Code

index.php


<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add Remove Dynamic HTML Fields using JQuery Plugin in PHP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
        <script src="repeater.js" type="text/javascript"></script>
    </head>
<body>
    <div class="container">
        <br />
        <h3 align="center">Add Remove Dynamic HTML Fields using JQuery Plugin in PHP</h3>
        <br />
        <div style="width:100%; max-width: 600px; margin:0 auto;">
            <div class="panel panel-default">
                <div class="panel-heading">Add Programming Skill Details</div>
                <div class="panel-body">
                    <span id="success_result"></span>
                    <form method="post" id="repeater_form">
                        <div class="form-group">
                            <label>Enter Programmer Name</label>
                            <input type="text" name="name" id="name" class="form-control" required />
                        </div>
                        <div id="repeater">
                            <div class="repeater-heading" align="right">
                                <button type="button" class="btn btn-primary repeater-add-btn">Add More Skill</button>
                            </div>
                            <div class="clearfix"></div>
                            <div class="items" data-group="programming_languages">
                                <div class="item-content">
                                    <div class="form-group">
          <div class="row">
           <div class="col-md-9">
                                                <label>Select Programming Skill</label>
                                                <select class="form-control" data-skip-name="true" data-name="skill[]" required>
                                                    <option value="">Select</option>
                                                    <option value="PHP">PHP</option>
                                                    <option value="Mysql">Mysql</option>
                                                    <option value="JQuery">JQuery</option>
                                                    <option value="Ajax">Ajax</option>
                                                    <option value="AngularJS">AngularJS</option>
                                                    <option value="Codeigniter">Codeigniter</option>
                                                    <option value="Laravel">Laravel</option>
                                                    <option value="Bootstrap">Bootstrap</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3" style="margin-top:24px;" align="center">
                                                <button id="remove-btn" class="btn btn-danger" onclick="$(this).parents('.items').remove()">Remove</button>
                                            </div>
          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
      
      <div class="clearfix"></div>
                        <div class="form-group" align="center">
       <br /><br />
                            <input type="submit" name="insert" class="btn btn-success" value="insert" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    $(document).ready(function(){

        $("#repeater").createRepeater();

        $('#repeater_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"insert.php",
                method:"POST",
                data:$(this).serialize(),
                success:function(data)
                {
                    $('#repeater_form')[0].reset();
                    $("#repeater").createRepeater();
                    $('#success_result').html(data);
                    /*setInterval(function(){
                        location.reload();
                    }, 3000);*/
                }
            });
        });

    });
        
    </script>
    </body>
</html>



insert.php


<?php

//insert.php

$connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");

if(isset($_POST["name"]))
{
 $skill = implode(", ", $_POST["skill"]);

 $data = array(
  ':programmer_name'  => $_POST["name"],
  ':programmer_skill'  => $skill
 );

 $query = "
 INSERT INTO programmer 
 (programmer_name, programmer_skill) 
 VALUES (:programmer_name, :programmer_skill)
 ";

 $statement = $connect->prepare($query);
 if($statement->execute($data))
 {
  echo '
  <div class="alert alert-success">
   Data Successfully Inserted
  </div>
  ';
 }
}
?>


Database


--
-- Database: `testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `programmer`
--

CREATE TABLE `programmer` (
  `programmer_id` int(11) NOT NULL,
  `programmer_name` varchar(200) NOT NULL,
  `programmer_skill` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `programmer`
--

INSERT INTO `programmer` (`programmer_id`, `programmer_name`, `programmer_skill`) VALUES
(1, 'John Smith', 'PHP, Mysql'),
(2, 'Peter Parker', 'Codeigniter, JQuery, Ajax, AngularJS'),
(3, 'Andrew Lee', 'PHP, Codeigniter, Laravel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `programmer`
--
ALTER TABLE `programmer`
  ADD PRIMARY KEY (`programmer_id`);



Download Source Code


    Share This:  
     Facebook
     Twitter
     Google+
     Stumble
     Digg

Email ThisBlogThis!Share to TwitterShare to Facebook
Related Posts:

    Add Remove Dynamic HTML Fields using JQuery Plugin in PHP In this tutorial, We are going learn How can we generate dynamic html fields by using Jquery plugin and insert dynamic generated html fields data… Read More

Newer Post Older Post Home
12 comments:

    Unknown4 June 2018 at 08:05

    Great Article.
    Now start your blog with a bang. Visit Bloggersutra.com
    Reply
    Faiz7 November 2018 at 05:59

    thanks
    Reply
    Unknown12 November 2018 at 06:26

    Excelent!!!
    Reply
    Unknown12 November 2018 at 16:04

    Very nice!!!
    Reply
    Unknown22 August 2019 at 21:27

    Hey Can WE also Pass the Img with serialize() ? i used that but its not working for me can you make it for img also
    Reply
    VTIT18 February 2020 at 07:36

    Is there any way to make the selects dynamic from a MYSQL database?
    Reply
    Mahdi Iranmanesh21 June 2020 at 08:44

    hello!
    how i can put more then one element in one item?
    Reply
    Unknown3 September 2020 at 02:28

    Hi,
    Is it possible to move the "Add more Skill" button to the bottom of the form? Next to Insert.
    Reply
    Replies
        Viki5 December 2020 at 03:04

        Have you found an answer? Please let me know
        Reply
    Unknown16 October 2020 at 05:08

    please help
    how to edit this field
    Reply
    Viki5 December 2020 at 03:01

    Thankyou. Its working.
    Reply
    Unknown3 June 2021 at 12:29

    thanx
    Reply

Popular Posts

    Library Management System Project in PHP with Source Code
    Online Doctor Appointment System Project in PHP Mysql
    Restaurant Management System in PHP With Source Code
    PHP MySql Based Online Exam System Project
    Build Real time Chat Application in PHP Mysql using WebSocket
    Live Chat System in PHP using Ajax JQuery
    How to Create Review & Rating Page in PHP with Ajax
    How to Display Excel Data in HTML Table using JavaScript
    Simple PHP Mysql Shopping Cart
    Online Student Result Management System in PHP with Mysql

Search for:
Copyright © 2022 Webslesson

