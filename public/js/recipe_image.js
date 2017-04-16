$(function(){

  $("#upload").on("change",function(e) {
    e.preventDefault();
    var image_src = $(this).val().split('\\').pop();
    var file = $(this.files[0]);
    var form = $(this).parents("form:first");
    var data = new FormData();
    data.append("image",file);
    console.log(form[0].image);
    console.log(file);
    console.log(data);
    var token  = $('#token').val();
    $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': token
    }
  });
     $.ajax({
       url: './upload-image',
       type: 'POST',
       enctype:'multipart/form-data',
       processData: false,
       data: data,
       contentType: false,
      success: function(data) {
        console.log(data);
        // $("#img_div").html(data);
        // $('#img_div').append(
          // '<img src="'+$(this).val().split('\\').pop()+'" heigh=150 width=130 />');

        },
        error: function (data) {
              console.log('Error:', data);
          }
       });



 });




/// end of onload function
 });
