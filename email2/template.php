<?php include(dirname(__FILE__).'/../config.php'); ?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<link href="style.css" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!--Author      : @arboshiki-->
<div id="invoice">

    <div class="toolbar hidden-print">
        <div class="text-right">
            <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
            <button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
        </div>
        <hr>
    </div>
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <a target="_blank" href="">
                            <img src="https://green.edu.bd/wp-content/uploads/2017/08/Logo.png" data-holder-rendered="true" />
                            </a>
                    </div>
                    <?php 
                    $getPersonalInfo = mysqli_query($conn,"SELECT * FROM applied_form  WHERE student_id = '123013'");
                    if($getPersonalInfo){
                        foreach ($getPersonalInfo as $value) {?>
                                                   
                    <div class="col company-details">
                        <h2 class="name">
                            <a target="_blank" href="">
                            <?php echo $value['student_name']; ?>
                            </a>
                        </h2>
                        <div><?php echo "ID: ".$value['student_id']; ?></div>
                        <div><?php echo "Dept.: ".$value['student_dept'].", Batch: ".$value['batch']; ?></div>
                        <div><?php echo "Mob: ".$value['student_mobile'].", Email: ".$value['student_email']; ?> </div>
                    </div>
                <?php } }?>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div>
                        <h3>Dear Sir, A student applied for </h3>
                    </div>
                    <div class="col invoice-to">   
                        <h3 class="to">Previous Academic Records</h3>
                        
                    </div>
                    
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-left">DEGREE NAME</th>
                            <th class="text-right">PASSING YEAR</th>
                            <th class="text-right">GRADE</th>
                            <th class="text-right">BOARD</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php 
                    $getPreviousResults = mysqli_query($conn,"SELECT * FROM previous_academic_records  WHERE applied_id = '123013'");
                    $sl =01;
                    if($getPreviousResults){
                        foreach ($getPreviousResults as $value) {?>
                        <tr>
                            <td class="no"><?php echo $sl; ?></td>
                            <td class="text-left"><h3>
                                <?php echo $value['degree_name']; ?>
                                </h3>
                            </td>
                            <td class="unit"><?php echo $value['passing_year']; ?></td>
                            <td class="qty"><?php echo $value['grade']; ?></td>
                            <td class="total"><?php echo $value['board']; ?></td>
                        </tr>
                    <?php $sl++; }
                        
                        }
                        ?>
                        <tr>
                            <td class="no">01</td>
                            <td class="text-left"><h3>Website Design</h3>Creating a recognizable design solution based on the company's existing visual identity</td>
                            <td class="unit">$40.00</td>
                            <td class="qty">30</td>
                            <td class="total">$1,200.00</td>
                        </tr>
                        <tr>
                            <td class="no">02</td>
                            <td class="text-left"><h3>Website Development</h3>Developing a Content Management System-based Website</td>
                            <td class="unit">$40.00</td>
                            <td class="qty">80</td>
                            <td class="total">$3,200.00</td>
                        </tr>
                        <tr>
                            <td class="no">03</td>
                            <td class="text-left"><h3>Search Engines Optimization</h3>Optimize the site for search engines (SEO)</td>
                            <td class="unit">$40.00</td>
                            <td class="qty">20</td>
                            <td class="total">$800.00</td>
                        </tr>
                    </tbody>
                   
                </table>               
                <div class="notices">
                    <div class="notice">Please log in <a target="_blank" href="">forms.green.edu.bd/login</a> to give your approval.</div>
                </div>
            </main>
            <footer>
                This is a system generated email, don't send back any reply to this email, should you have any query please contact Mr. Rushad, IT officer.
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>
<script src="custom.js"></script>