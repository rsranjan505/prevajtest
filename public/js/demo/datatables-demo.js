// Call the dataTables jQuery plugin
// $(document).ready(function() {
//   var table = $('#dataTable').DataTable();
// });

// var table = $('#dataTable').DataTable({
//   "searching": false,
//   "processing": true,
//   "serverSide": true,
//   "ajax": {
//      "url": "/contact/ajax",
//      "data": function ( d ) {
//        return $.extend( {}, d, {
//          "search_keywords": $("#namesearch").val().toLowerCase()
//        } );
//      }
//    }
// });

$(document).ready(function(){

  $('#namesearch').bind("keyup change", function(){
    $.ajax({  
      url:        '/contact/ajax',  
      type:       'POST',   
      dataType:   'json',  
      data    : {search_keywords :  $("#namesearch").val().toLowerCase()},
      processData:true,
      success: function(response, status) {  
        // $("#itemsData").empty().html(data);
       
        $('#cus_contact').html('');  
       
        var tbbody = '';

         console.log(response);
        // const data = JSON.parse(response);
         $.each(response, function(i, item ) {
          var active = item.is_active == 1 ? 'Yes' : 'No';
            tbbody = `<tr><td>${item.first_name}</td><td>${item.last_name}</td><td>${item.mobile}</td><td>${item.email}</td><td>${item.city}</td><td>${active}</td>
            <td><nav class="navbar navbar-expand">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <button class="btn btn-warning dropdown-toggle" href="#" id="navbarDropdown"
                        role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right"
                        aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/contact-edit/${item.id}">Edit</a>
                        <a class="dropdown-item" href="/contact-delete/${item.id}" onclick="return confirm('Are you sure?')">Delete</a>
                </li>
            </ul></td></tr>`;
            $('#cus_contact').append(tbbody);  
         });
        
         
      },  
      error : function(xhr, textStatus, errorThrown) {  
         alert('Ajax request failed.');  
      }  
   });  

  });

});

// const search = document.querySelector('#namesearch');
 
// // Custom range filtering function
// DataTable.ext.search.push(function (settings, data, dataIndex) {
//     let search = search.value;
 
//     if (
//         isNaN(search)
//     ) {
//         return true;
//     }
 
//     return false;
// });

// const table = new DataTable('#dataTable');
 
// // Changes to the inputs will trigger a redraw to update the table
// search.addEventListener('input', function () {
//     table.draw();
// });
// search.addEventListener('input', function () {
//     table.draw();
// });
 
