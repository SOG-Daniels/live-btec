<?php
    // echo "<pre>";
    // print_r($existingReports);
    // echo "</pre>";
 
    // showing message if there is any
    echo (!empty($this->session->flashdata('message'))? $this->session->flashdata('message') : '');

?>
<h1 class="h3 mb-2 text-gray-800">Generate a Report</h1>
<div class="card shadow-lg  ">
    <div class="card-header">
        <h6 class=" font-weight-bold text-primary">Advance Search</h6>
    </div>
    <form action="<?php echo base_url();?>advance-search" method="POST">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="searchVal" aria-label="search box" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>   
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">
                <label class="font-weight-bold d-block" for="searchbyoption">Search By:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="searchBy" id="" value="0" checked>
                    <label class="form-check-label" for="">First or Last Name</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="searchBy" id="" value="1">
                    <label class="form-check-label" for="">Social Security Number</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="searchBy" id="" value="2">
                    <label class="form-check-label" for="">Phone Number</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="searchBy" id="" value="3">
                    <label class="form-check-label" for="">Email</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">
                <label for="District" class="font-weight-bold d-block">Filter By:</label>
                <label for="District">District:</label>
                <select class="form-control" name="district"  onfocus='this.size=6;' onblur='this.size=1;' onchange='this.size=1; this.blur();' >
                    <option>all</option>
                    <option>Corozal</option>
                    <option>Orange Walk</option>
                    <option>Cayo</option>
                    <option>Belize</option>
                    <option>Stann Creek</option>
                    <option>Toledo</option>
                </select>
            </div>
        </div>
    </div>
    </form>
</div>
<br>
<div class="card shadow-lg">
    <div class="card-header">
        <h6 class=" font-weight-bold text-primary">Report Options</h6>
       
    </div>
    <div class="card-body">


    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="client-tab" data-toggle="tab" href="#client" role="tab" aria-controls="client" aria-selected="true">Custom Report</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Created Reports</a>
        </li>
        
    </ul>
    <div class="tab-content" id="myTabContent">

    <!-- Content for client report in a particular program -->
    <div class="tab-pane fade show active" id="client" role="tabpanel" aria-labelledby="client-tab">

        <form action="<?php echo base_url()?>program-summary-report/" method="POST">
            <input type="hidden" name="action" value="createReport">
            <br>
                       <div class="alert alert-secondary" role="alert">
                           <span><i class="fa fa-info-circle"></i><span>
                           Provides a report of each client based on the selected displays and filter options.
                           Setting a name will save the created report in the system.
                           <span class="text-primary">Note:</span> Selected CheckBoxes cannot be unchecked
                           
                       </div>
                <!-- <h6>
                    <small class="font-weight-bold text-primary">
                    Save report (optional)
                    <hr>    
                    </small>        
                </h6>
                <div class="row">
                    <div class="col-12 col-md-4">
                    <label class="font-weight-bold">Report Name (optional):</label>
                    <input class="form-control" type="text" name="reportName" value="">
                    </div>
                </div> -->
                <br>
                <h6>
                    <small class="font-weight-bold text-primary">
                    Choose a program display 
                    <hr>    
                    </small>        
                </h6>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <label class="font-weight-bold">Choose a program:</label>
                        <select class="form-control" name="program"  onfocus='this.size=7;' onblur='this.size=1;' onchange='this.size=1; this.blur();' >
                        <!-- <option  value="1">All Programs</option> -->
                        <option  value="barbering">Introduction to Barbering</option>
                        <option  value="admin_assistant">Administrative Assistant</option>
                        <option  value="bartending">Bartending</option>
                        <option  value="bpo">Business Process Outsourcing</option>
                        <option  value="child_care">Child Care Training</option>
                        <option  value="computer_basics">Computer's For Everyday Use</option>
                        <option  value="event_planning">Event Planning</option>
                        <option  value="front_desk">Front Desk Training</option>
                        <option  value="home_health">Home Health Training</option>
                        <option  value="house_keeping">House Keeping</option>
                        <option  value="landscaping">Landscaping</option>
                        <option  value="life_guard">Life Guard Training</option>
                        <option  value="nail_tech">Nail Tech</option>
                        <option  value="wait_staff">Wait Staff Training</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="font-weight-bold">Program Compeltion Status:</label>
                        <select class="custom-select" name="programStatus" id="programStatus" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                        <option value="Completed">Completed</option>
                        <option value="Dropped">Dropped</option>
                        <option value="Participated">Participated</option>
                        </select>
                    
                    </div>
                </div>
                <br>
                <h6>
                    <small class="font-weight-bold text-primary">
                    Choose a Grade info display 
                    <hr>    
                    </small>        
                </h6>

                <div class="row" id="grade-options">
                    <div class="col-12 col-md-4">
                        <div class="checkbox">
                            <label><input type="checkbox" name="gradeOption[enrolledOn]" value="1" > Year Enrolled</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="gradeOption[graduatedOn]" value="1" > Year of Completion</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="checkbox">
                            <label><input type="checkbox" name="gradeOption[listAssesments]" value="1"> Assesments with Grade</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="gradeOption[finalAvg]" value="1" checked onclick="return false"> Final Average</label>
                        </div>   
                    </div>
                    <div class="col-12 col-md-4">
                        <!-- <div class="checkbox">
                            <label><input type="checkbox" name="gradeOption[topTen]" value="1"> Top 10 Final Avg.</label>
                        </div> -->
                        <div class="checkbox">
                            <label><input type="checkbox" name="gradeOption[notes]" value="1"> Notes</label>
                        </div>   
                    </div>
                </div>
                <br>
                <h6>
                    <small class="font-weight-bold text-primary">
                    Choose a Client info display 
                    <hr>    
                    </small>        
                </h6>

                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="checkbox">
                                <label><input type="checkbox" name="clientInfo[personalInfo]" value="1" checked onclick="return false"> Personal Info</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="clientInfo[address]" value="1" > Address </label>
                        </div>   
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="checkbox">
                            <label><input type="checkbox" name="clientInfo[emergContactInfo]" value="1"> Emergency Contact Info</label>
                        </div>   
                        <div class="checkbox">
                                <label><input type="checkbox" name="clientInfo[references]" value="1"> References</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="checkbox">
                                <label><input type="checkbox" name="clientInfo[eduInfo]" value="1" > Education Info</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="clientInfo[empInfo]" value="1" > Employment Info</label>
                        </div>   
                    </div>

                </div>
                <br>
                <h6>
                    <small class="font-weight-bold text-primary">
                    Filters (optional)
                    <hr>    
                    </small>        
                </h6>

                <div class="row">
                    <div class="col-12 col-md-4">
                        <label class="font-weight-bold">Choose Top Grades</label>
                        <select class="custom-select" name="limit" id="" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                        <option selected value="1">All Grades</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        </select>
                    
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="font-weight-bold">Choose a Year Enrolled (optional):</label>
                        <input type="number" name="yearFilter" placeholder="2010..." class="form-control " >
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="font-weight-bold">Final Average:</label>
                        <select class="custom-select" name="gradeFilter" id="courseStatus" onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                        <option value="1">All Grades</option>
                        <option value="100">100</option>
                        <option value="90">90 - 99</option>
                        <option value="80">80 - 89</option>
                        <option value="70">70 -79</option>
                        <option value="0"> < 70 </option>
                        </select>
                    
                    </div>
                </div>
                <br>
                <button class="btn btn-sm btn-primary float-right"><i class="fa fa-print"></i> Create Report</button>
        </form>
    </div>

    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <form id="removeReportForm" action="<?php echo base_url()?>delete-existing-report" method="POST">
            <input type="hidden" id="deleteAction" name="action" value="deleteReport">
            <input type="hidden" id="reportViewName" name="viewName" value="">
        </form>
        <form action="<?php echo base_url()?>program-summary-report/" method="POST">
        <input type="hidden" name="action" value="generateReport">
        <br>
                      
                <h6>
                    <small class="font-weight-bold text-primary">
                    Generate a Report
                    <hr>    
                    </small>        
                </h6>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <label class="font-weight-bold">Choose a Report:</label>
                        <select class="form-control" id="reportDisplayName" name="reportName"  >
                        <!-- onfocus='this.size=7;' onblur='this.size=1;' onchange='this.size=1; this.blur();' > -->
                        <?php 

                            // looping and displaying records 
                            foreach ($existingReports as $report){
                            
                                echo '
                                    <option value="'.$report['view_name'].'">'.$report['display_name'].'</option>
                                ';
                            }



                        ?>
                    
                        </select>
                    </div>
                    <div class="col-12 col-md-8 ">
                        <br>
                        <span class="float-right pt-2">
                        <a id="deleteReport" href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeReportModal"><i class="fa fa-trash"></i> Delete Report</a>
                        &nbsp;
                        <button class="btn btn-sm btn-primary mt-2 mt-md-0"><i class="fa fa-print"></i> Generate Report</button>
                        <span>
                    
                    
                    </div>
                 
                </div>
                <br>
        </form>
    </div>
    <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> -->
    
    </div>
    
       
    </div>
</div>