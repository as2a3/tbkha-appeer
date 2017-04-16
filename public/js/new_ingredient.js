$(function(){

  var count = 0;
  $(document).on('click', '.new_ingredient', function() {
      count++;
      $('#add_ingred').append(
        '<input type="text" name="ingredients[]" id="ingred'+count+'" class="form-control col-sm-6" style="margin-bottom:5px;float:left" />'
        +
        '<span class="remove glyphicon glyphicon-remove" style="margin-bottom:15px;float:left" id="'+count+'"></span>'
      );

  });

  $('body').on('click','.remove',function(){
      var id = $(this).attr("id");
      $('#ingred'+id).remove();
      $('#ingredH'+id).remove();
      $(this).remove();
      });



});
