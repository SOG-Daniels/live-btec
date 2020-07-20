// my jquery code for all pages

// defining global variables 
var eList = [];
var clist = [];
var hasView;
var hasEdit;
var inputCount = 2;
var userInfoFormData;
var isSessionSet;

var personalRefCount = 2;

// var cList = [];


// end of definition 


/////////////function definitions starts///////////////////

//function sets the value of the inputCount that is used to enter the number of assesments//
function setInputCount(value){
    inputCount = value;
    console.log('inputCount = '+inputCount);
}
// function for validation if passwords match before submission and checks if requirements for 


//used for changing a password outside of the system
function checkChangePassMatch() {
    console.log('test');
    //$('#submit-button').prop('disabled', true);
    var decimal =  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/;//rules that govern what is required of a password
    var password = $("#newPassword").val();
    var confirmPassword = $("#confirmPassword").val();

    if (password != confirmPassword && confirmPassword != ''){
     
        $('#change-pass-btn').prop('disabled', true);
        $("#divCheckPasswordMatch").html("<span class='text-danger ml-4'>Passwords do not match!</span>");
    
    }else if(password == '' || confirmPassword == ''){

        $("#divCheckPasswordMatch").html(" ");
        $("#passRequirement").html(" ");
        $('#change-pass-btn').prop('disabled', true);
    
    }else{
        
        $("#divCheckPasswordMatch").html("<span class='text-success ml-4'> Passwords match.</span>");
        
        if (password.match(decimal)){

            $("#passRequirement").html(" ");
            $('#change-pass-btn').prop('disabled', false);

        }else{

            $("#passRequirement").html("<span class='text-danger ml-4'>Please meet the requirement stated above!</span>");

        }
    }
}


// new password are met
function checkPasswordMatch() {
    
    //$('#submit-button').prop('disabled', true);
    var decimal =  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/;//rules that govern what is required of a password
    var password = $("#newPass").val();
    var confirmPassword = $("#confirmPass").val();

    if (password != confirmPassword && confirmPassword != ''){
     
        $('#change-pass-btn').prop('disabled', true);
        $("#divCheckPasswordMatch").html("<span class='text-danger ml-4'>Passwords do not match!</span>");
    
    }else if(password == '' || confirmPassword == ''){

        $("#divCheckPasswordMatch").html(" ");
        $("#passRequirement").html(" ");
        $('#change-pass-btn').prop('disabled', true);
    
    }else{
        
        $("#divCheckPasswordMatch").html("<span class='text-success ml-4'> Passwords match.</span>");
        
        if (password.match(decimal)){

            $("#passRequirement").html(" ");
            $('#change-pass-btn').prop('disabled', false);

        }else{

            $("#passRequirement").html("<span class='text-danger ml-4'>Please meet the requirement stated above!</span>");

        }
    }
}
// function creates the enrolled structuring it into an object so that it can be used by the datatable
function createList (jsonData, base_url, hasGradeEdit, hasEdit, hasView){

    //clearing old erolledList
    eList = [];
    // console.log(jsonData);
    if (jsonData.length > 0){

        var eTempList = { "data" : jsonData};
        var i;

        // loops used to get inner array data  
        for (var i in eTempList.data){
            for (var sub in eTempList.data[i]){
                eTempList.data[i][sub].full_name = eTempList.data[i][sub].first_name + ' ' + eTempList.data[i][sub].last_name;
                eTempList.data[i][sub].pActions = ((hasView == 1)? '<a href ="'+base_url+'client-info/'+eTempList.data[i][sub].id+'">View</a>':"")+
                ((hasEdit == 1)? '&nbsp'+'<a href ="'+base_url+'edit-client-info/'+eTempList.data[i][sub].id+'"> Edit</a>' : ""); 
                
                eTempList.data[i][sub].gView =((hasGradeEdit == 1)? '<a href ="'+base_url+'manage-client-grade/'+(eTempList.data[i][sub].programme.replace(/\s/g , "-")).replace(/'/g,"")+'/'+eTempList.data[i][sub].id+'">Edit</a>' : "");

                //enrolled list object
                eList.push(eTempList.data[i][sub]);//we take the arrays that are embeded and list them out into one array 
            }

        }
    
        // console.log(eList); // checking if we have the correct data to display in the datatables
        initializeDatatable(eList);

    }else{
        //No record was returned so set parameter as 0 - false
        initializeDatatable(0);
    }

}
// This function initializes the data table plugin with the object created from the createList function
function initializeDatatable(data){

    $(document).ready(function(){
        if ($.fn.DataTable.isDataTable("#enrolledList")) {
            $('#enrolledList').DataTable().clear().destroy();
        }
        if (data != 0){
            let columns = [
                { "data": "id" , "sortable" : true },
                { "data": "full_name" , "sortable" : true},
                { "data": "programme" , "sortable" : false, "width": "25%"},
                { "data": "enrolled_in", "sortable" : false },
                { "data": "dob", "sortable" : true},
                { "data": "mobile_phone" , "sortable" : false}
            ];
            //we are gonna push the data for the colum if they have the privileges
            (hasGradeEdit == 1)? columns.push({ "data": "gView", "sortable" : false }) : '';
            (hasView == 1 || hasEdit == 1)? columns.push({ "data": "pActions", "sortable" : false }) : '';

            
            // columns.data = pAction;
            // console.log(columns)
            $('#enrolledList').DataTable({
                    "data" : data,
                    "columns" :columns,
                    "order": [[1, 'asc']]

            });    
            console.log('data is not 0');
        }else{
            console.log('empty array for enrolled list');
            $('#enrolledList').DataTable( {
                "language": {
                    "emptyTable":     "No records  were found!"
                }
            } );

        } 
        
    });

}

$(document).ready(function() {
 

  /***********start of custom function declaration **************/

    // function declared inside $(docuemnt).ready because it uses jquery 
    get_UserInfoFormData = function() {
        //saving current userInfoForm for to check if changes were made to it later
        var userInfoForm = $('#userInfoForm');

        // Find disabled inputs, and remove the "disabled" attribute
        var disabled = userInfoForm.find(':input:disabled').removeAttr('disabled');

        // serialize the form
        userInfoForm.data('serialize', userInfoForm.serialize());
        userInfoFormData = $(userInfoForm).data('serialize');// saving the current state of the userInfoForm

        //disabled the set of inputs that you previously enabled
        disabled.attr('disabled','disabled');
        
        //used for testing purposes
        // console.log(userInfoFormData);
        // console.log('userinfo');

    }

    //function gets the image uploaded and displayes it on the profile pic image tag
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.avatar').attr('src', e.target.result);
            }
            
            $('#remove-client-img').show();//displaying remove image button for editing a client
            $('#remove-appli-img').show(); //displaying remove image button for adding a client
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    /**************End of function declaration************/
   
    //javascript input mask
    function doFormat(x, pattern, mask) {
        var strippedValue = x.replace(/[^0-9]/g, "");
        var chars = strippedValue.split('');
        var count = 0;
      
        var formatted = '';
        for (var i=0; i<pattern.length; i++) {
          const c = pattern[i];
          if (chars[count]) {
            if (/\*/.test(c)) {
              formatted += chars[count];
              count++;
            } else {
              formatted += c;
            }
          } else if (mask) {
            if (mask.split('')[i])
              formatted += mask.split('')[i];
          }
        }
        return formatted;
      }
      
      document.querySelectorAll('[data-mask]').forEach(function(e) {
        function format(elem) {
          const val = doFormat(elem.value, elem.getAttribute('data-format'));
          elem.value = doFormat(elem.value, elem.getAttribute('data-format'), elem.getAttribute('data-mask'));
          
          if (elem.createTextRange) {
            var range = elem.createTextRange();
            range.move('character', val.length);
            range.select();
          } else if (elem.selectionStart) {
            elem.focus();
            elem.setSelectionRange(val.length, val.length);
          }
        }
        e.addEventListener('keyup', function() {
          format(e);
        });
        format(e)
      });
    
    $(".certificate-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    
    $('#postComment').click(function (e){

        // prevent button from submitting form
        e.preventDefault();

        var comment = document.getElementById('comment').value;
        $.post(base_url+'session-check',function(data){

            if (data == 1){
                //Cecking if the comment is not empty
                if (comment.trim() !== ""){
                
                    var data = $('#commentForm').serialize();
                    var action = document.getElementById('commentForm').action

                    //sending an ajax request as post to remove profile pic
                    $.post(action, data, function(data){
                        
                        console.log('data is:');
                        console.log(data);

                        //reloading current page from server and not from cache
                        location.reload(true);
                        

                    });
                    
                }

            }else{
                //session not set
                location.reload(true);
            }
        });


    });
    // handle the UI display for editing a comment
    $('.editComment').click(function (e){

        e.preventDefault();

        var commentInput = document.getElementById('comment');
        var spanEdit = document.getElementById('commentEdit');
        var oldComment = document.getElementById(this.value).innerText;
        var rowContent = this.closest(".row");

        //hidden input 
        var commentId = document.getElementById('commentId');

        //buttons 
        var postBtn = document.getElementById('postComment');
        var spanBtns = document.getElementById('editBtn')

        //hiding old comment 
        rowContent.style.display = "none";

        //clearing comment post
        commentInput.value = "";

        //setting comment post value with old post value for edit
        commentInput.value = oldComment;
        spanEdit.style.display = "block";

        //hiding and displaying buttons
        postBtn.style.display = "none";
        spanBtns.style.display = "block";

        //setting comment id to hidden input 
        commentId.value = this.value;

    });
    // triggered when update button is clicked when making an edit to a comment
    $('#updateComment').click(function (e){

        e.preventDefault();
        var commentId = document.getElementById('commentId').value;
        var comVal = document.getElementById('comment').value;

        $.post(base_url+'session-check',function(data){
            
            if (data == 1){
                //session is set so we update 
                $.post(base_url+'update-comment', {id : commentId, comment: comVal.trim()}, function(data){
                    
                    console.log(data);
                    location.reload(true);//reloading current page from server and not from cache
                    

                });


            }else{

                location.reload(true);
            }
           
        });
  

        //console.log(sessionCheck());

    });
    //canecels the update 
    $('#cancelEdit').click(function (e){

        e.preventDefault();
        
        var commentInput = document.getElementById('comment');
        var spanEdit = document.getElementById('commentEdit');

        //hidden input 
        var commentId = document.getElementById('commentId').value;
        
        //oldComment element
        var oldComment = document.getElementById(commentId).closest('.row');

        //buttons 
        var postBtn = document.getElementById('postComment');
        var spanBtns = document.getElementById('editBtn')

        console.log(oldComment);
        //hiding old comment 
        oldComment.style.display = "flex";
    
        //clearing comment post
        commentInput.value = "";

        // removing span from display
        spanEdit.style.display = "none";

        //hiding and displaying buttons
        spanBtns.style.display = "none";
        postBtn.style.display = "block";

        //setting comment id to empty string
        commentId.value = "";
        

    });

    // triggered upon clicking the delete icon on a comment
    $('.deleteComment').click(function (e){

        e.preventDefault();

        var commentId = $('.deleteComment').val();
        
        $.post(base_url+'session-check',function(result){

            if(result == 1){
                //session is set
                $.post(base_url+'remove-comment', {id : commentId}, function(data){
                    
                    console.log(data);
                    //reloading current page from server and not from cache
                    location.reload(true);
                    

                });

            }else{
                //session not set 
                location.reload(true);
            }
        });

    });
  
    //clicking view grade link, submits the form
    $('#viewGrades').click(function (e){
        e.preventDefault();

        //submitting form
        $('#viewGradeForm').submit();

    });
    // triggered in the edit grade page - unenrolling a user
    $('#removeClientFromProgram').click(function (e){
        e.preventDefault();
        //loading modal
        console.log('modal');
        $('#unenrollClientModal').modal('show');

    });
    $('#confirmClientUnenroll').click(function (e){
        e.preventDefault();

        console.log('confirm unenroll');
        $('#removeEnrolledClientForm').submit();

    });
    // triggered upon clicking the remove imag link in edit-client-info page
    $('#remove-img ').on('click', '#remove-client-img', function (e){
        e.preventDefault();

        $('#imgId').val(1);//setting default profile image ID 
        $('#profilePic').attr('src', base_url+'upload/default_profile_img.png');//bass_url is defined in footer.php as a global variable
        $('.client-img-upload').val('');
        $('#remove-client-img').hide();
       

    });

    // triggered when user clicks the remove button
    $('#remove-user-img').click(function (e){
        e.preventDefault();

        var data = $('#upload-img-form').serialize();
        
        //sending an ajax request as post to remove profile pic
        $.post(base_url+'remove-profile-picture', data, function(data){
            
            location.reload(true);//reloading current page from server and not from cache
            
            //hiding the remove button
            $(this).hide();

        });
       

    });
    // triggered when admin tries to change a user image 
    $('#remove-user-img-2').click(function (e){
        e.preventDefault();

        var data = $('#upload-img-form-2').serialize();
        console.log(data);

        //sending an ajax request as post to remove profile pic
        $.post(base_url+'remove-profile-picture', data, function(data){
         
            location.reload(true);//reloading current page from server and not from cache
            
            //hiding the remove button
            $(this).hide();

        });
       

    });

    // // on submitting the program assesmetn form
    // $('#assesNames').on('submit', function (e){


    //     let modifiedFormData = $('#assesNames').serialize();
       
    //     // console.log(assesNameForm);
    //     // console.log('break');
    //     // console.log(modifiedFormData);

    //     // checking to see if the form has changed
    //     //assesNameForm is defined in programSetup
    //     if(modifiedFormData !== assesNameForm){
            
    //         //submitting the form
    //         // $('#assesNames').submit();
    //         console.log('form not the same');

    //     }else{
            
    //         e.preventDefault();
    //         alert('No changes were made!');
    //     }

    // });

    //setting up the summernote plugin by specifying the components it should have
    $('#programNotes').summernote({

        placeholder: 'Enter some notes ...',
        tabsize: 2,
        height: 250,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
          ]
    });
    //summernote for notes when viewing grades
    $('#viewNotes').summernote({
        toolbar: []
    });
    //making summernote readonly
    $('#viewNotes').next().find(".note-editable").attr("contenteditable",false)
    
    //when the activation button is click it will send the activation form to the user.php controller
    //check form action to identify controller method
    $('#activateUser').click(function(e){

        e.preventDefault();//if the button is to submit it will not do it //
        var formData = $("#activationForm").serialize();
        var url = $("#activationForm").attr('action');

        //using jquery post ajax to send the form 
        $.post(url, formData, function(data){
           
            // console.log(data);
            alert(data);
            
            location.reload(false);


        }).fail(function(){
            alert('Something went wrong while trying to complete your request');
        }); 


        

    });
    // submitting saveReportForm
    $('#confirmSaveReport').click(function(e){
        
        // console.log(base_url);
        console.log($('#query').text());
        // $('#saveReportForm').submit();
        

    });
    // submitting form upon confirmation of modal
    $('#confirmProgComp').click(function(e){
        
        $('#gradeForm').submit();
        

    });

    // confirming removal of a report
    $('#confirmReportDelete').click(function(e){
        
       //setting selected report in the delete report form  
        $('#reportViewName').val($('#reportDisplayName').val());
        
        $('#removeReportForm').submit();
        

    });
    //submitting grade changes that were made
    $('#saveGradeChanges').click(function(e){
       
        //checking if the status has been changed
        if ($('#courseStatus').val() != 1){
        
            $('#triggerConfirmModal').click();
            
            // alert('is not enrolled');

        }else{

            $('#gradeForm').submit();
            // alert('is enrolled');

        }


    });
    $('.add-more-asses').click(function(e){
        e.preventDefault();
        let html = '';   
        // alert(inputCount);
        if (inputCount <= 5) {
            
            html = '<div id="asses-input'+inputCount+'" class="row">';
            html += '<div class="col-12 col-md-12">';
            html += '<label class="font-weight-bold">Assesment Name:</label>';
            html += '<div class="input-group">';
            html += '<input type="text" class="form-control" name="assesmentName[]" id="assesment'+inputCount+'" placeholder="Enter a name...." required    >';
            html += '<span class="input-group-append ">';
            html += '<span class="input-group-text bg-danger remove-grade"><i class="fa fa-minus text-white"></i></span>';
            html += '</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            
            $('#assesments').append(html);

            inputCount++;

        }else{
            
            alert('5 assesments are the maximum');
            console.log('5 assesments are the maximum');
        }

    });
    // used for adding more grades
    $('.add-more').click(function(e){
        e.preventDefault();
        let html = '';   
        // alert(inputCount);
        if (inputCount <= 5) {
            
            html = '<div id="asses-input'+inputCount+'" class="row">';
            html += '<div class="col-12 col-md-6">';
            html += '<label >Assesment Name:</label>';
            html += '<input type="text" class="form-control" name="assesName[]" id="assesName1" place="Practical" required>';            
            html += '</div>';
            html += '<div class="col-12 col-md-6">';
            html += '<label >Assesment Grade:</label>';
            html += '<div class="input-group">';
            html += '<input type="number" class="form-control" name="assesment[]" id="assesment'+inputCount+'" placeholder="Enter a grade....">';
            html += '<span class="input-group-append ">';
            html += '<span class="input-group-text bg-danger remove-grade"><i class="fa fa-minus text-white"></i></span>';
            html += '</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            
            $('#assesments').append(html);
            inputCount++;
        }else{
          console.log('5 assesments are the maximum');
        }

    });
    $('#assesments').on('click','.add-grade', function(e){
        e.preventDefault();
        var html = '';
        if (inputCount <= 5){

            //creating an input field
            html = '<div id="asses-input'+inputCount+'" class="row">';
            html += '<div class="col-12 col-md-6">';
            html += '<label >Assesment Name:</label>';
            html += '<input type="text" class="form-control" name="assesName[]" id="assesName1" place="Practical" required>';            
            html += '</div>';
            html += '<div class="col-12 col-md-6">';
            html += '<label >Assesment Grade:</label>';
            html += '<div class="input-group">';
            html += '<input type="number" class="form-control" name="assesment[]" id="assesment'+inputCount+'" placeholder="Enter a grade....">';
            html += '<span class="input-group-append ">';
            html += '<span class="input-group-text bg-danger remove-grade"><i class="fa fa-minus text-white"></i></span>';
            html += '</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            
            $('.add-grade').removeClass('bg-primary');
            $('.add-grade').addClass('bg-danger');
            
            $('.add-grade i').removeClass('fa-plus');
            $('.add-grade i').addClass('fa-minus');

            $('.add-grade').addClass('remove-grade');
            $(this).removeClass('add-grade');

            $('#assesments').append(html);
            
            inputCount++;
        }else{
          console.log('5 assesments are the maximum');
        }
        

    });
    $('#assesments').on('click','.remove-grade', function(){

        $(this).parent().parent().parent().parent().remove();
        inputCount--;

    });
    
    // Function below works for the select all for adding a user
    // selects all the privileges when the checkbox select all is selected and likewise
    // removes the uncheck off all privileges upon unchecking the checkbox

    $('#selectAll').change(function() {
        if($(this).is(':checked')){
            //setting all checkbox indside div to checked
            for (i = 1; i <= PRIVI_SIZE; i++){

                $('#privi'+i).attr("checked", true);
        
            }
        
        }
        if(!$(this).is(':checked')){
            //removing checked from all checkbox inside the div
            for (i = 1; i <= PRIVI_SIZE; i++){

                $('#privi'+i).attr("checked", false);
            }
            
        }
      });

      // triggered when the deleteing a user is click and assignes the modals confirm 
      // delete button the same href as the delete button link that was clicked
    $('#removeUser').click(function(e){
        e.preventDefault();
        let url = $(this).attr('href');
        console.log(url);
        $('#confirmUserDelete').attr('href', url);
    });

    //Used for changing a password in the user profile page.
    //it calls to the checkPasswordMatch() function to validate passwords
    $("#newPass, #confirmPass").keyup(checkPasswordMatch);
    
    //used for the changing of password outside of system
    $("#newPassword, #confirmPassword").keyup(checkChangePassMatch);

    // $("#clientInfoForm :input").attr("readOnly", true);//not used
    
    //Make all inputs in the clientinfoform readonly
    $("#profileForm :input").attr("readOnly", true);
    
    //form for updating a user profile is set to readonly
    $("#userInfoForm :input").attr("readOnly", true);
    
    //used for admin updating user profile pic
    $(".file-upload-2").on('change', function(){
        readURL(this);
        var data = new FormData(document.getElementById("upload-img-form-2"));
        
        console.log('form-2');
        console.log(data);

        //sends a request to the change_profile_pic() function in the user controller
        // to change the users profile pic
        $.ajax({
            url: base_url+'update-profile-picture',  
            type: 'POST',
            data: data,
            success:function(data){
                // location.reload(true);//reloading the current page from server not from cache
                location.reload(true);//reloading current page from server and not from cache
                console.log(data);
                alert(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        
        

    });
   
    $(".file-upload").on('change', function(){
        readURL(this);
        var data = new FormData(document.getElementById("upload-img-form"));
        console.log('form-1');
        console.log(data);
        //sends a request to the change_profile_pic() function in the user controller
        // to change the users profile pic
        $.ajax({
            url: base_url+'update-profile-picture',  
            type: 'POST',
            data: data,
            success:function(data){
                location.reload(true);//reloading the current page from server not from cache
                console.log(data);
                alert(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        
        

    });

    // used for user updating their profile pic
    // When uploading a profile picture this code is triggered
    $('#upload-img').click(function (e){
        //e.preventDefault();
        $('.file-upload').click();

    });

    //used for admin updating user profile pic
    $('#upload-img-2').click(function (e){
        //e.preventDefault();
        $('.file-upload-2').click();

    });

    // Used in the edit my profile page, makes all input fields writable
    $('#editProfile').click(function(e){
        
        e.preventDefault();//if the button is to submit it will not do it //
        
        $("#profileForm :input").attr("readOnly", false);
        $("#editProfile").css("display", "none");
        $("#saveProfileInfo").css("display", "block");

    });

    // Used in the edit my profile page.
    // sends an jquery ajax post to update the users profile 
    // and upon success makes all input fields readonly
    $('#saveProfileInfo').click(function(e){

        e.preventDefault();//if the button is to submit it will not do it //

        
        var formData = $("#profileForm").serialize();
        //send out the input feilds that were modified and update the database 
        
        $.post("update-profile", formData, function(data){
           
            console.log(data);
            alert(data);
            $("#profileForm :input").attr("readOnly", true);
            $("#editProfile").css("display", "block");
            $("#saveProfileInfo").css("display", "none");
        
        });
        
        //send out the input feilds that were modified and update the database 
        

    });
    $('#editUser').click(function(e){
        
        e.preventDefault();//if the button is to submit it will not do it //

        $("#userInfoForm :input").attr("readOnly", false);
        $("#editUser").css("display", "none");//hiding the edit button
        $("#saveUserInfo").css("display", "block");//displaying the save button 
        $("input.action").attr("disabled", false);//finding all input with class called action. 

    });

    $('#saveUserInfo').click(function(e){

        e.preventDefault();//if the button is to submit it will not do it //
        
        var formData = $("#userInfoForm").serialize();
        var base_url = $("#userInfoForm").attr('action');

        $('#userInfoForm').data('serialize',$('#userInfoForm').serialize());


        if(formData != userInfoFormData){
            // Form has changed!!!
            $.post(base_url, formData, function(data){
            
                console.log(data);
               alert(data);
                $("#userInfoForm :input").attr("readOnly", true);
                $("#editUser").css("display", "block");
                $("#saveUserInfo").css("display", "none");
                $("input.action").attr("disabled", true);
                get_UserInfoFormData();
            });

            console.log('Form was modified ');
        }else{
            $("#userInfoForm :input").attr("readOnly", true);
            $("#editUser").css("display", "block");
            $("#saveUserInfo").css("display", "none");
            $("input.action").attr("disabled", true);
            console.log('No changes were made.');
        }



        

    });
   
    $('#enrolledProgram').change(function(e){

        e.preventDefault();//if the button is to submit it will not do it //
        let base_url = $('#trainingList').attr('action');
        let formData = $('#trainingList').serialize();
        // console.log(link);
        $.ajax({
            type: "POST",
            url: base_url + 'enrolled-list',
            data: formData,
            //contentType: "application/json; charset=utf-8",
            dataType: "json",                    
            cache: false,                       
            success: function(response) {                        
                createList(response[0],response['base_url'], response['hasGradeEdit'], response['hasEdit'], response['hasView']);
                console.log(response);   
                console.log('success');
                //console.log(response);
            },
            error: function (e) {
                console.log('failed');
                console.log(e);
            }
        });  



        

    });

    // The functionality is triggered when the select option is changed in the program setting page   
    $('#programs').change(function(e){

        e.preventDefault();//if the button is to submit it will not do it //

        // let url = 'http://localhost/CI_miniproject/program-setup';//we will use the form URL
        // let tableSelected = $('#assesNames').val();//the selected option from the select input
        let formData = $('#assesNames').serialize();

        // sending a jquery ajax post to the url declared
        $.post(base_url+'program-setup', formData, function(data){
        
            let inputs = '';
            inputCount = 1;
            
            //We are clearing all the child elements of the parent element, i.e. the div that holds all the input fields
            $('#assesments').empty();
            
                console.log(data);
            if (data != 0){
                
                // console.log(JSON.parse(data));
                
                //Lopping through the jason object we have recieved 
                //NOTE: using JSON.parse() on returned data to prevent a error trigger
                //JSON.parse convers the data recieved into jason object format so we can then use the $.each()
                $.each(JSON.parse(data), function(key, value) {
                    
                    //Spliting the value to separate the assesment name and grade
                    if ( value !== null && value !== ""){

                        //splitting the value since we have it set in database as assesmentName-gradeValue
                        let asses = value.split(',');

                        // creating an input element
                        let html = '<div id="asses-input'+inputCount+'" class="row">';
                        html += '<div class="col-12 col-md-12">';
                        html += '<label >Assesment Grade:</label>';
                        html += '<div class="input-group">';
                        html += '<input type="text" class="form-control" name="assesmentName[]" id="assesment'+inputCount+'" value="'+asses[0]+'" required>';
                        html += '<span class="input-group-append ">';
                        html += '<span class="input-group-text bg-danger remove-grade"><i class="fa fa-minus text-white"></i></span>';
                        html += '</span>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';

                        inputs += html;
                        inputCount++;

                    }
                });
            }else{
                console.log('no grade names availabe');
            }
              // If there were no grade assesments names then we will print out an empty input field
              if( inputCount == 1){
                let html = '<div id="asses-input'+inputCount+'" class="row">';
                html += '<div class="col-12 col-md-12">';
                html += '<label >Assesment Grade:</label>';
                html += '<div class="input-group">';
                html += '<input type="text" class="form-control" name="assesmentName[]" id="assesment'+inputCount+'" placeholder="Enter a name...." required>';
                html += '<span class="input-group-append ">';
                html += '<span class="input-group-text bg-danger remove-grade"><i class="fa fa-minus text-white"></i></span>';
                html += '</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                inputs += html;
                inputCount++;
              }
              $('#assesments').html(inputs);
     
        });

    });

    // when uploading a profile picture of a client
    $(".client-img-upload").on('change', function(){
        readURL(this);

    });
    // triggered when uploading a clients pic on updating their profile
    $('#upload-client-img').click(function (e){
        //e.preventDefault();
        $('.client-img-upload').click();
        

    });
    //removes image uploaded to addAppliant form
    $('#remove-appli-img').click(function (){

        $('.client-img-upload').val('');
        $('#appli-img').attr('src', base_url+'upload/default_profile_img.png');
        $('#remove-appli-img').hide();

    });
    
    //removing added personal references
    $('#remove-ref').click(function (e){

        e.preventDefault();
        
        // console.log(personalRefCount);
        if (personalRefCount >= 3){
            //removing last element
            personalRefCount--;

            var refDisplay = document.getElementById('ref'+personalRefCount);
            refDisplay.style.display = 'none';

        }

    });

    //dynmic adding of personal reference
    $('#add-more-ref').click(function (e){

        e.preventDefault();

        if (personalRefCount >= 2 && personalRefCount < 4){
            
            //we display input of reference

            var refDisplay = document.getElementById('ref'+personalRefCount);
            refDisplay.style.display = 'block';
            personalRefCount++;
            
        }

    });
    //Prevent dublicate colors from being submitted
    $('#saveEventLabels').click(function(event){
        
        event.preventDefault();
        
        var	stored	=	[];
        var	inputs	=	$('.eventColor');
        var hasError = 0;

        $('#errorMessage').remove();

        console.log(inputs);
        $.each(inputs,function(key,value){
            var getValue	=	$(value).val();
            if(stored.indexOf(getValue) != -1){
                // $(value).fadeOut();
                $('#eventLabels').prepend('<p id="errorMessage">Please remove duplicated colors</p>');
                $('#errorMessage').css('color', 'red');
                $(value).parent().parent().parent().css('border',' solid red');
                hasError = 1;
                //ending each loop
                return false;
            }else{
                stored.push($(value).val());
            }
        });
        if (hasError === 0){
            $('#eventLabelForm').submit();
        }else{
            console.log('Has duplicate event Colors');
        }

    });

    // Adding more event label fields dynamically
    $('.add-new-label').click(function (e){

        e.preventDefault();

        $html = '<div class="row">';
        $html += '<div class="col-12 col-md-12">';
        $html +='<div class="input-group mb-3">';
        $html +='<div class="input-group-prepend">';
        $html +='<span class="input-group-text">';
        $html +='<input class="from-control eventColor" type="color" id="favcolor" name="labels[label'+labelNum+'][color]" value="">';
        $html += '</span>';
        $html += '</div>';
        $html +='<input type="text" class="form-control" aria-label="Event Label" name="labels[label'+labelNum+'][name]" value="" required>';
        $html +='<div class="input-group-append">';
        $html +='<span class="input-group-text bg-danger remove-event-label"><i class="fa fa-minus text-white"></i></span>';
        $html += '</div>';
        $html += '</div>';
        $html += '</div>';
        $html += '</div>';

        $('#eventLabels').append($html);
        labelNum++;
        

    });
    // Removes an event label made
    $('#eventLabels').on('click','.remove-event-label', function(e){
        e.preventDefault();

        $(this).parent().parent().parent().parent().remove();
        labelNum--;
        // inputCount--;

    });

});