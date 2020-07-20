// Call the dataTables jQuery plugin

$(document).ready(function(){
  // console.log(clist.data);

  // data table for the user list 
  $('#userDataTable').DataTable({
    columnDefs: [ 
      { 
        "orderable" : false, targets: [3,4,5,6,7,8]
    } 
    ],
    "order": [[ 8, "desc" ]]

  });

  //defining the column definition for datatable for client list
  let columns =[
    // setting the more button on the client list table
          {
              "className": 'details-control',
              "orderable": false,
              "data": null,
              "defaultContent": '',
              "render": function () {
                  return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
              },
              width:"15px"
          },
          //the columns that will be on the table
          { "data": "id"},
          { "data": "first_name" },
          { "data": "last_name" },
          { "data": "dob"},
          { "data": "email", "sortable" : false},
          { "data": "mobile_phone", "sortable" : false},
          
      ];
      // setting view and edit if user has the privilege
      if ((hasView == 1 || hasEdit == 1)){
        columns.push(
          { "data": "profile" , "sortable" : false},
        );
      }
  
      // defining the display proporties for the datatable for client list
    var table = $('#dataTable').DataTable({
      // dom: 'lBfrtip',
      // buttons: [
      //   'excel', 'pdf'
      // ],
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
      "data": clist.data,
      select:"single",
      "columns": columns,
      "order": [[1, 'asc']]
  });
 
 // Call the dataTables jQuery plugin
  // $('#dataTableUsers').DataTable();
  
  //initializing report table with the datatable plugin
  var reportTable = $('#reportDataTable').DataTable({
    lengthChange: false,
    buttons: [{
      extend: 'excel',
      title: 'Report Sumary'
    }, 'colvis' ],
    bPaginate: false
 
  });
  // displaying buttons to datatable
  reportTable.buttons().container().appendTo( '#reportDataTable_wrapper .col-md-6:eq(0)' );

  // Add event listener for opening and closing details
  $('#dataTable tbody').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var tdi = tr.find("i.fa");
      var row = table.row(tr);

      if (row.child.isShown()) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
          tdi.first().removeClass('fa-minus-square');
          tdi.first().addClass('fa-plus-square');
      }
      else {
          // Open this row
          row.child(format(row.data())).show();
          tr.addClass('shown');
          tdi.first().removeClass('fa-plus-square');
          tdi.first().addClass('fa-minus-square');
      }
  });

  table.on("user-select", function (e, dt, type, cell, originalEvent) {
      if ($(cell.node()).hasClass("details-control")) {
          e.preventDefault();
      }
  });
});
// formats the UI for the client list table that displays additional information
function format(d){
 
  console.log (d);
  // `d` is the original data object for the row
  return '<table class="table table-responsive" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
           ' <thead class="thead-dark"> '+
            '<tr>'+
                '<th scope="col">Program</th>'+
                '<th scope="col">Status</th>'+
                '<th scope="col">Comments</th>'+
                '<th scope="col">Enrolled In</th>'+
            '</tr>'+
            '</thead>'+
            '<tbody>'+ 
        '<tr>' +
        ((d.bpo === null)? '':
          
          '<td>'+ d.bpo+'</td>' +
          '<td>' + ((d.bpo_status === null)? 'N/A' : d.bpo_status) + '</td>'+
          '<td>' + ((d.bpo_comment === null)? 'N/A' : d.bpo_comment) + '</td>'+
          '<td>' + ((d.bpo_enrolled === null)? 'N/A' : d.bpo_enrolled) + '</td>'

        
        )+
      '</tr>' +
      '<tr>' +
        ((d.bartending === null)? '' 
            :  
            '<td>'+ d.bartending +'</td>' +
            '<td>' + ((d.bar_status === null)? 'N/A' : d.bar_status) + '</td>'+
            '<td>' + ((d.bar_comment === null)? 'N/A' : d.bar_comment) + '</td>'+
            '<td>' + ((d.bar_enrolled === null)? 'N/A' : d.bar_enrolled) + '</td>'
            ) +        
      '</tr>' +
      '<tr>' +
        ((d.barbering === null)? '' 
            :  
            '<td>'+ d.barbering +'</td>' +
            '<td>' + ((d.ba_status === null)? 'N/A' : d.ba_status) + '</td>'+
          '<td>' + ((d.ba_comment === null)? 'N/A' : d.ba_comment) + '</td>'+
            '<td>' + ((d.ba_enrolled === null)? 'N/A' : d.ba_enrolled) + '</td>'
            ) +        
      '</tr>' +
      '<tr>' +
        ((d.child_care === null)? '' 
            :  
            '<td>'+ d.child_care+'</td>' +
            '<td>' + ((d.cc_status === null)? 'N/A' : d.cc_status) + '</td>'+
            '<td>' + ((d.cc_comment === null)? 'N/A' : d.cc_comment) + '</td>'+
            '<td>' + ((d.cc_enrolled === null)? 'N/A' : d.cc_enrolled) + '</td>'
            ) +        
      '</tr>' +
      '<tr>' +
        ((d.computer_basics === null)? '' 
            :  
            '<td>'+ d.computer_basics+'</td>' +
            '<td>' + ((d.cb_status === null)? 'N/A' : d.cb_status) + '</td>'+
            '<td>' + ((d.cb_comment === null)? 'N/A' : d.cb_comment) + '</td>'+
            '<td>' + ((d.cb_enrolled === null)? 'N/A' : d.cb_enrolled) + '</td>'

            ) +        
      '</tr>' +
      '<tr>' +
        ((d.event_planning === null)? '' 
            :  
            '<td>'+ d.event_planning+'</td>' +
            '<td>' + ((d.ep_status === null)? 'N/A' : d.ep_status) + '</td>'+
            '<td>' + ((d.ep_comment === null)? 'N/A' : d.ep_comment) + '</td>'+
            '<td>' + ((d.ep_enrolled === null)? 'N/A' : d.ep_enrolled) + '</td>'

            ) +        
      '</tr>' +
      '<tr>' +
        ((d.front_desk === null)? '' 
            :  
            '<td>'+ d.front_desk+'</td>' +
            '<td>' + ((d.fd_status === null)? 'N/A' : d.fd_status) + '</td>'+
            '<td>' + ((d.fd_comment === null)? 'N/A' : d.fd_comment) + '</td>'+
            '<td>' + ((d.fd_enrolled === null)? 'N/A' : d.fd_enrolled) + '</td>'
            ) +        
      '</tr>' +
      '<tr>' +
        ((d.home_health === null)? '' 
            :  
            '<td">'+ d.home_health+'</td>' +
            '<td>' + ((d.hh_status === null)? 'N/A' : d.hh_status) + '</td>'+
            '<td>' + ((d.hh_comment === null)? 'N/A' : d.hh_comment) + '</td>'+
            '<td>' + ((d.hh_enrolled === null)? 'N/A' : d.hh_enrolled) + '</td>'

            ) +        
      '</tr>' +
      '<tr>' +
        ((d.house_keeping === null)? '' 
            :  
            '<td">'+ d.house_keeping+'</td>' +
            '<td>' + ((d.hk_status === null)? 'N/A' : d.hk_status) + '</td>'+
            '<td>' + ((d.hk_comment === null)? 'N/A' : d.hk_comment) + '</td>'+
            '<td>' + ((d.hk_enrolled === null)? 'N/A' : d.hk_enrolled) + '</td>'

            ) +        
      '</tr>' +
      '<tr>' +
        ((d.landscaping === null)? '' 
            :  
            '<td>'+ d.landscaping+'</td>' +
            '<td>' + ((d.l_status === null)? 'N/A' : d.l_status) + '</td>'+
            '<td>' + ((d.l_comment === null)? 'N/A' : d.l_comment) + '</td>'+
            '<td>' + ((d.l_enrolled === null)? 'N/A' : d.l_enrolled) + '</td>'

            ) +        
      '</tr>' +
      '<tr>' +
        ((d.life_guard === null)? '' 
            :  
            '<td>'+ d.life_guard+'</td>' +
            '<td>' + ((d.lg_status === null)? 'N/A' : d.lg_status) + '</td>'+
            '<td>' + ((d.lg_comment === null)? 'N/A' : d.lg_comment) + '</td>'+
            '<td>' + ((d.lg_enrolled === null)? 'N/A' : d.lg_enrolled) + '</td>'

            ) +        
      '</tr>' +
      '<tr>' +
        ((d.nail_tech === null)? '' 
            :  
            '<td>'+ d.nail_tech+'</td>' +
            '<td>' + ((d.nt_status === null)? 'N/A' : d.nt_status) + '</td>'+
            '<td>' + ((d.nt_comment === null)? 'N/A' : d.nt_comment) + '</td>'+
            '<td>' + ((d.nt_enrolled === null)? 'N/A' : d.nt_enrolled) + '</td>'

            ) +        
      '</tr>' +
      '<tr>' +
        ((d.wait_staff === null)? '' 
            :  
            '<td>'+ d.wait_staff+'</td>' +
            '<td>' + ((d.ws_status === null)? 'N/A' : d.ws_status) + '</td>'+
            '<td>' + ((d.ws_comment === null)? 'N/A' : d.ws_comment) + '</td>'+
            '<td>' + ((d.ws_enrolled === null)? 'N/A' : d.ws_enrolled) + '</td>'

            ) +        
      '</tr>' +
      '<tr>' +
        ((d.admin_assistant === null)? '' 
            :  
            '<td>'+ d.admin_assistant +'</td>' +
            '<td>' + ((d.aa_status === null)? 'N/A' : d.aa_status) + '</td>'+
            '<td>' + ((d.aa_comment === null)? 'N/A' : d.aa_comment) + '</td>'+
            '<td>' + ((d.aa_enrolled === null)? 'N/A' : d.aa_enrolled) + '</td>'

            ) +        
      '</tr>' +
  '</table>'+
  '<table class="table table-responsive table-hover" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
      '<tr>' +
          '<td class="font-weight-bold">Emergency contact name:</td>' +
          '<td>' + ((d.ec_name === null)? 'N/A' : d.ec_name) + '</td>' +
      '</tr>' +
      '<tr>' +
          '<td class="font-weight-bold">Emergency Contact #:</td>' +
          '<td>'+  ((d.ec_number === null)?  'N/A' : d.ec_number) +'</td>' +
      '</tr>' +
      '<tr>' +
          '<td class="font-weight-bold">Emergency Contact Relation:</td>' +
          '<td>' +  ((d.ec_relation === null)? 'N/A' : d.ec_relation) + '</td>' +
      '</tr>' +
      // '<tr>' +
      //     '<td class="font-weight-bold">Specialized Training:</td>' +
      //     '<td>' + ((d.specialized_trainings === null )? 'N/A': d.specialized_trainings )+ '</td>' +
      // '</tr>' +
      '<tr>' +
      '</tr>' +
      

  '</table>';
  
}









































