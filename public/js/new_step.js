$(function(){

  var count = 0;
  $(document).on('click', '.new_step', function() {
      count++;
      $('#add_step').append(
        '<input type="text" class="form-control" id="step'+count+'" name="steps_names[]" style="margin-bottom:5px;" />'
        +
        '<input type="file" name="images[]" id="step_image'+count+'" class="form-control col-sm-6" style="margin-bottom:15px;" />'
        +
        '<span class="remove glyphicon glyphicon-remove" style="margin-bottom:10px;float:left" id="'+count+'"></span>');




  });


  $('body').on('click','.remove',function(){
      var id = $(this).attr("id");
      $('#step'+id).remove();
      $('#step_image'+id).remove();
      $(this).remove();
      });










});
