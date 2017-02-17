function reload(pgd_id){
  $('#content_tab_custom').html(loading);
  $('#content_tab_custom').load('AdmPengaduan/Tr_uraian_kejadian?pgd_id='+pgd_id);
}
/*validator form*/
$.validator.setDefaults({
  submitHandler: function() { 
    
     url = "AdmPengaduan/Tr_uraian_kejadian/process";

       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form_uraian').serialize(),
            dataType: "JSON",

            success: function(data) {
              greatComplete(data);
              reload(data.pgd_id);
            },
            error: function(xhr, ajaxOptions, thrownError){
              greatComplete({message:'Error code '+xhr.status+' : '+thrownError, gritter:'gritter-error'});
            },

        });

  }

});

/*disabled button after clicking submit button*/
function disabledBtn()
{
  $('#btnSave').disabled = true;
  return true;
}


// jquery validation //
$().ready(function() {

  // validate signup form on keyup and submit
  $("#form_uraian").validate({
    rules: {
      
      pgdu_uraian_kejadian: {
        required: true,
      },
      pgd_id: "required"
    },

    messages: {
      pgdu_uraian_kejadian: {
        required: "Please fill this field!",
      },
      pgd_id: {
        required: "Please fill this field!",
      },  
    }
  });


});

