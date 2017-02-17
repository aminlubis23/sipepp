var loading = "<center><img src='"+window.location.origin+"/koperasi/app.v2/assets/images/loading.gif' style='width:150px;padding-top:200px;cursor:auto;z-index:15;'/></center>";

function getMenu(link)
{
	$('#nav nav-list li a').click(function(e) {
        //e.preventDefault();
        $('#nav nav-list li a').removeClass('active open');
        $(this).addClass('active open');
    });

    $('#page-area-content').html(loading);
    $('#page-area-content').load(link +'?_=' + (new Date()).getTime());

}

function getMainMenu(menuId)
{
	$('#nav nav-list li a').click(function(e) {
        //e.preventDefault();
        $('#nav nav-list li a').removeClass('active open');
        $(this).addClass('active open');
    });
    
    $('#page-area-content').html(loading);
    $('#page-area-content').load('pengaturan/menu/load_sub_menu/' + menuId +'?_=' + (new Date()).getTime());

}

function delete_file_lampiran(id){
    
    if(confirm('Apakah anda yakin akan menghapus data ini?'))
      {
        // ajax delete data to database
          $.ajax({
            url: 'SipeppMaster/Tr_attachment/processDelete',
            type: "post",
            data: {ID:id},
            dataType: "json",
            success: function(data) {
              greatComplete(data);
              $('#'+id+'').hide('fast');
            },
            error: function(xhr, ajaxOptions, thrownError){
              greatComplete({message:'Error code '+xhr.status+' : '+thrownError, gritter:'gritter-error'});
            },
          });
         
      }
    
  }

/*function delete_file_lampiran(id){
    url = "form_wks/form_1/processDeleteFile/"+id;
    $.ajax({
        url : url,
        type: "POST",
        dataType: "JSON",
        processData: false,
        success: function(data, textStatus, jqXHR, responseText)
        { 
           $(this).addClass('deleted_file');
           greatComplete(data);
        }
    });
}*/

