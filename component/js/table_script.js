function table_create(jsondata,targetid,idkey,info){
  // Populate table Header
  var tablehead = "";
  tablehead = $('<thead/>');
  tablehead.append("<tr/>");
  $.each(jsondata, function(index,value){
    if(index==0){
      $.each(this,function(key,value){
        tablehead.find('tr:last').append("<th>" + key + "</th>");
      });
      tablehead.find('tr:last').append("<th>DELETE</th>");
      tablehead.find('tr:last').append("<th>UPDATE</th>");
    }
  });
  $(targetid).append(tablehead);
  // // Populate table Data
  var table = "";
  table = $('<tbody/>');
  $.each(jsondata, function(index,value){
    table.append("<tr/>");
    //table.find('tr:last').attr('id',$(this)[0][idkey]).attr('class','clickable-row');
    // console.log($(this)[0][idkey]); // GET ID KEY
    $.each(this,function(key,value){
      table.find('tr:last').append("<td>" + value + "</td>");
    });
    table.find('tr:last').append("<td></td>");
    table.find('td:last').append('<a>DELETE</a>'); // onclick send delete request to ID#
    table.find('td:last').attr('class',info.namekey).attr('id',$(this)[0][idkey]);
    table.find('tr:last').append("<td>UPDATE</td>"); // On click send put request
  });
  $(targetid).append(table);
  // Delete button
  var curclass= '.'+info.namekey;
  $(curclass).on('click', function() {
    var del_id = this.id;
    var parent = $(this).closest('tr');
    $.ajax({
          method: 'DELETE',
          url: info.url+'/'+del_id,
          success: function (result) {
            parent.fadeOut(300,function(){
              $(this).remove();
            });
          }
      });
  });
}
