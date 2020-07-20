    // Google api console clientId, API key and google calendarId (email of the calendar being used)
    var CLIENT_ID = '522162334113-60n3efs89pdi98kl6it907340cl1cg4j.apps.googleusercontent.com';
    var API_KEY = 'AIzaSyCiVnwV8XXg8ic3uBdOmwQAeyNow_JTZs8';
    var CALENDAR_ID = 'btec.calendar@gmail.com';
    var HOLIDAY_CAL_ID = 'en.bz#holiday@group.v.calendar.google.com';

    // enter the scope of current project (this API must be turned on in the Google console)
    var SCOPES = 'https://www.googleapis.com/auth/calendar';

        
    // Array of API discovery doc URLs for APIs used by the quickstart
    // The JavaScript client library uses the information to generate corresponding JavaScript methods that applications can use.
    var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest"];


    var calendarEl = document.getElementById('g-calendar');
    var calendar = null; 
/////// END OF GLOBAL VARIABLES///////

////// START OF EVENT TRIGGERS //////



// triggers on form submit by an Enter keypress
$(document).on('submit','#eventForm',function(e){
    //canceling submition of form
    e.preventDefault();
    //triggering click of form submition
    $('#add-cal-event').click();


 });
// triggered when save event form is submitted
$(document).on('submit','#saveEventForm',function(e){
    //canceling submition of form
    e.preventDefault();
    //triggering click of form submition
    $('#saveEvent').click();


 });
//  Triggered when adding an event to the calendar
$('#add-cal-event').click( function (e){
    // console.log(e);                    
    let title = $.trim($('#eTitle').val());
    if(title){
  

        let formData = $('#eventForm').serialize();

        $.ajax({
            url: base_url+'add-event',
            type:"POST",
            data: formData,
            success:function(data)
            {
                //console logs 0 / 1 represents if failed or a succesful addition to events
                console.log('Return data from adding an event: ' + data);
                $('#calendarModal').modal('hide');
                calendar.refetchEvents();
            }
            });
        
            
            // $('#calendarModal').modal('hide');
            $('#eTitle').val('');
            $('#eDescription').val('');
        }
});

//  Triggered when deleting an event 
$('#deleteEvent').click( function (e){
    // console.log(e);                    
    let eId = $('#eventId').val();
    if(eId){
  
        $.ajax({
            url: base_url+'remove-event',
            type:"POST",
            data: { eventId : eId},
            success:function(data)
            {
                //console logs 0 / 1 represents if failed or successful deletion
                console.log(data);
                calendar.refetchEvents();
                $('#eventDescriptionModal').modal('hide');
            }
            });
        
            
           
        }
});

// triggered when the save button is click on the event info modal
$('#saveEvent').click( function (e){
    // console.log(e);                    
    let formData = $('#saveEventForm').serialize();
    let eId = $('#eventId').val();
    if(eId){
  
        $.ajax({
            url: base_url+'update-event',
            type:"POST",
            data: formData,
            success:function(data)
            {
                if (data == 'logged out'){
                    // session has expired
                    location.reload(base_url+'login');
                }else{
                    //console logs 0 / 1 represents if failed or was a successful update
                    console.log(data);
                    calendar.refetchEvents();
                    $('#eventDescriptionModal').modal('hide');

                }
            }
            });
        
            
           
        }
});

///// END OF EVENT TRIGGERS //////



$(document).ready(function (){
    
        //creating the calendar
        createFullCalendar();
    
});


///// START OF FUNCTION DECLARATION /// 
    /**
       *  Initializes the fullcalendar plugin, and pulls holidays from google calendar
       */
function createFullCalendar(){

    //fullCalendar initialization 
    calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['dayGrid', 'interaction', 'timeGrid', 'googleCalendar', 'bootstrap', 'list'],
        header: {
            right : 'prevYear,prev,next,nextYear today',
            center : 'title',
            left : 'dayGridMonth,timeGridWeek,listMonth,listWeek'
        },
        //cutomizing button names
        // otherwise button will only say "list"
        views: {
            listWeek: { buttonText: 'List Week Events' },
            listMonth: { buttonText: 'List Month Events' }
        },
        eventColor: 'green',//color of the events from google api
        eventLimit: true, // shows popup when there are alot of events on a day
        editable: false, // allows event drag and drop and resizing
        selectable: true,
        selectHelper: true,
        themeSystem: 'bootstrap',//displays bootstrap buttons
        timeZone : 'Central Standard Time', // setting time zone for Belize
       
        eventSources: [{
            //events from our controller
           url : base_url+'get-events'
        },{
            //public calendar definition 
            googleCalendarApiKey: API_KEY,
            className: 'gcal-event', // an option!
            // currentTimezone: 'Central Standard Time - Belize',
            googleCalendarId: HOLIDAY_CAL_ID
            
        }],
        select: function(info) {
            
            // console.log(info);
            // console.log(info.startStr);
                
            $('#info-startDate').text(calendar.formatDate(info.startStr, {
                month : 'short',
                year : 'numeric',
                day : 'numeric',
                // weekday : 'short',
                hour : 'numeric',
                minute : '2-digit',
                meridiem : 'short'
            }));
            $('#info-endDate').text(calendar.formatDate(info.endStr, {
                month : 'short',
                year : 'numeric',
                day : 'numeric',
                // weekday : 'short',
                hour : 'numeric',
                minute : '2-digit',
                meridiem : 'short'
            }));

            //assigning endDate and startDate to eventForm in modal 
            $('#startDate').val(info.startStr);
            $('#endDate').val(info.endStr);
            // console.log(info.start);
            // console.log(info.end);

            //showing the add modal
            $('#calendarModal').modal('show');
  
            calendar.unselect();
        },
        //when an event on the calendar is clicked
        eventClick: function (info){
            // console.log(info);

            info.jsEvent.preventDefault();

            if (info.event.url != "") {
                
                return false;

            }else{
                let createdBy = (info.event.extendedProps.created_by != '')? info.event.extendedProps.created_by : 'N/A';
                let updatedBy = (info.event.extendedProps.updated_by != '' && info.event.extendedProps.updated_by != null)? info.event.extendedProps.updated_by : 'Not Updated';
                let des = info.event.extendedProps.description;
                let colorRadioId = info.event.extendedProps.labelId;
                
                if (document.getElementById(colorRadioId) != null){
                    //selecting the event label
                    document.getElementById(colorRadioId).checked = true;
                }else{
                    //unselecting selected radio
                    var ele = document.getElementsByName("color");
                    for(var i=0; i<ele.length ;i++){
                       ele[i].checked = false;
                    }
                }
                
                $('#eventId').val(info.event.id);
                $('#d-title').val(info.event.title);
                // $('#d-description').text('');
                $('#d-description').val(des);

                $('#d-startDate').text(calendar.formatDate(info.event.start, {
                    month : 'short',
                    year : 'numeric',
                    day : 'numeric',
                    // weekday : 'short',
                    hour : 'numeric',
                    minute : '2-digit',
                    meridiem : 'short'
                }));
                $('#d-endDate').text(calendar.formatDate(info.event.end, {
                    month : 'short',
                    year : 'numeric',
                    day : 'numeric',
                    // weekday : 'short',
                    hour : 'numeric',
                    minute : '2-digit',
                    meridiem : 'short'
                }));
                
                $('#d-createdBy').text(createdBy);
                $('#d-updatedBy').text(updatedBy);
                
                $('#eventDescriptionModal').modal('show');

            }


        }
        // eventResize: function(info) {
        //     alert(info.event.title + " end is now " + info.event.end.toISOString());
        
        //     if (!confirm("is this okay?")) {
        //       info.revert();
        //     }
        // }
        
        //when an event is dropped
        // eventDrop : function (info){
        //     // alert(info.event.title + " Start Date is now " + info.event.start.toISOString() + " and End date is "+ info.event.end.toISOString());
        //     console.log(info);

        //     console.log(info.oldEvent.start.toISOString());
        //     console.log(info.oldEvent.end.toISOString());
            
        //     $.ajax({
        //         url: base_url+'update-event',
        //         type:"POST",
        //         data: {
        //             drop : 1,// 1 meaning true
        //             eventId : info.event.id,
        //             startDate : info.event.start.toISOString(),
        //             endDate : info.event.end.toISOString(),
        //             title : info.event.title,
        //             description : info.event.extendedProps.description
        //             },
        //         success:function(data)
        //         {
        //             //console logs 0 / 1 represents if failed or was a successful update
        //             console.log(data);
        //             calendar.refetchEvents();//gets all events and renders to the calendar
        //         }
        //         });

        // }
        
    });

    //loading the fullCalendar with all defined proporties
    if (calendar != null){
        calendar.render();
    }

}
    

       