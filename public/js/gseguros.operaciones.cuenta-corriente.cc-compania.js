function viewDetalleMovimientoCompania(url){

  
		var tabs_sel = $('#tabs').tabs();
        var idx = tabs_sel.tabs('option', 'selected');
    
        //Trae el tab correspondiente
        var tab = $('#tabs ul li a')[idx]; 
        //console.debug($('#tabs ul li a'));
        var href = $(tab).attr('href') ;
       // var url = $(g).attr('href')
    
            $.ajax({url: url,success:function(result){
                $(href).html(result);
              }});
  
            return false;


}

function onClickAtras(url){

	var tabs_sel = $('#tabs').tabs();
    var idx = tabs_sel.tabs('option', 'selected');

    //Trae el tab correspondiente
    var tab = $('#tabs ul li a')[idx]; 
    //console.debug($('#tabs ul li a'));
    var href = $(tab).attr('href') ;
   // var url = $(g).attr('href')

        $.ajax({url: url,
            success:function(result){
            $(href).html(result);
          }});

        return false;
	
}