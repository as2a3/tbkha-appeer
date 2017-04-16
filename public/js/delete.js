$(function(){

$(document).on('click', '.delete_ingredient', function() {
  var token  = $('#token').val();
  var id = $(this).attr('id');
  $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': token
  }
  });
  $.ajax({
    url: 'http://localhost:5657/ingredients/delete/'+id,
    type: 'POST',
    data: {},
   success: function(data) {
     console.log(data);
     $("#ingredients"+id).remove();
     },
     error: function (data) {
           console.log('Error:', data);
       }
    });

// end of on click of ingreients
});



$(document).on('click', '.delete_step', function() {
  var token  = $('#token').val();
  var step_id = $(this).attr('id');
  $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': token
  }
  });
  $.ajax({
    url: 'http://localhost:5657/steps/delete/'+step_id,
    type: 'POST',
    data: {},
   success: function(data) {
     console.log(data);
     $("#steps"+step_id).remove();
     },
     error: function (data) {
           console.log('Error:', data);
       }
    });

// end of on click of ingreients
});


// end og onload
});
