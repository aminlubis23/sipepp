jQuery(function($) {
    var grid_selector = "#grid-table";
    var pager_selector = "#grid-pager";
    var pgd_id = $(grid_selector).attr('rel');
    
    //resize to fit page size
    $(window).on('resize.jqGrid', function () {
      $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
    })

    //resize on sidebar collapse/expand
    var parent_column = $(grid_selector).closest('[class*="col-"]');
    $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
      if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
        //setTimeout is for webkit only to give time for DOM changes and then redraw!!!
        setTimeout(function() {
          $(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
        }, 0);
      }
    })
    
    /*generate grid table*/
    jQuery(grid_selector).jqGrid({
      
      url:'AdmPengaduan/Tr_bukti/getData/'+pgd_id, 
      mtype: 'POST',
      emptyrecords: 'Tidak ada data',
      datatype: "json",
      jsonReader: {
            page: "page",
            total: "totalPages",
            records: "records",
            root: "rows",
            cell: "",
            id: "0"
        },

      height: 'auto',
      colNames:['ID','No Registrasi','Keterangan Bukti','File lampiran(gambar,file,dll)','Action'],
      colModel:[
        
        {name:'id',index:'id', width:20, sorttype:"int", align:'center'},
        {name:'pgd_id',index:'pgd_id', width:40, sorttype:"int"},
        {name:'pgdb_keterangan',index:'pgdb_keterangan', width:120},
        {name:'pgdb_nama_file',index:'pgdb_nama_file', width:120},
        {name:'myid',index:'myid', sorttype:"int", width:50, formatter:formatterAction, align:'center'},

      ], 
  
      viewrecords : true,
      rowNum:10,
      rowList:[5,10,20,30],
      pager : pager_selector,
      
      beforeRequest:function(){
        search_by=$('#search_by').val()?$('#search_by').val():'';
        keyword=$('#keyword').val()?$('#keyword').val():'';
        $(grid_selector).setGridParam({postData:{'search_by':search_by,'keyword':keyword}})
      },

      altRows: false,
      multiselect: true,
      multiboxonly: true,

      loadComplete : function() {
        var table = this;
        setTimeout(function(){
        updatePagerIcons(table);
        }, 0);
      },

      autowidth: true,
      height: '100%',
  
    });

    //trigger window resize to make the grid get the correct size
    $(window).triggerHandler('resize.jqGrid');
    
    /*delete multiple row*/
    jQuery("#button_delete_multiple").click( function(){

        var pgd_id = $('#pgd_id').val();
        var status = $('#status').val();
        var params = '';

        if(status != 1){
          params = '?pgd_id='+pgd_id+'&status='+status+'';
          $('#content_tab_custom').html(loading);
          $('#content_tab_custom').load('AdmPengaduan/Tr_peristiwa/processDelete'+params);
          return false;
        }

        var selectedrows = $("#grid-table").jqGrid('getGridParam','selarrrow');

        if(selectedrows.length) {

          if(confirm('Apakah anda yakin akan menghapus data ini?')){

            for(var i=0;i<selectedrows.length; i++) {

            var selecteddatais = $("#grid-table").jqGrid('getRowData',selectedrows[i]);
                var rows=JSON.stringify(selecteddatais)
                var postArray = {json:rows};

              $.ajax({
                type: "POST",
                url: 'AdmPengaduan/Tr_bukti/processDelete',
                data: postArray,       
                dataType: "json",
                success: function(data) {
                  greatComplete(data);
                  $(grid_selector).trigger("reloadGrid");
                },
                error: function(xhr, ajaxOptions, thrownError){
                  greatComplete({message:'Error code '+xhr.status+' : '+thrownError, gritter:'gritter-error'});
                },

              }); 
            } 

          }
          
        }else{

          alert('No data selected, please select data!');

        } 

      });


    // BUTTON SEARCH //
    $('#btn_search_bukti').click(function (event) {
       event.preventDefault();
        $(grid_selector).trigger("reloadGrid");
    });

    // BUTTON RESET //
    $('#btn_reset_bukti').click(function (event) {
      event.preventDefault();
      $('#form_search_bukti')[0].reset();
      $(grid_selector).trigger("reloadGrid");
    });

    // BUTTON ADD //
     $('#btn_add_bukti').click(function () {
      $("html, body").animate({ scrollTop: "400px" }, "slow");
      $('#content_tab_custom').html(loading);
      var pgd_id = $('#pgd_id').val();
      var status = $('#status').val();
      var params = '';
      if(status != 1){
        params = '&status='+status+'';
      }
      $('#content_tab_custom').load('AdmPengaduan/Tr_bukti/form?pgd_id='+pgd_id+''+params);
    
    });

    $('#btnSave').click(function () {
      
      url = "AdmPengaduan/Tr_bukti/process";
      lampiran = new Array();
      var formData = new FormData($('#form_bukti')[0]);
      i=0;
      $("input#file").each(function(){
          lampiran[i] = $('input[type=file]')[i].files[i];
          i++;
      })

      formData.append('file', lampiran);

        $.ajax({
            url : url,
            type: "POST",
            data: formData,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function(data, textStatus, jqXHR, responseText)
            { 
              greatComplete(data);
              backlist(data.pgd_id);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              greatComplete({message:'Error code '+xhr.status+' : '+thrownError, gritter:'gritter-error'});
            }
        });
    });

    // FORMATTER ACTION //
    function formatterAction(cellvalue, options, rowObject) {
      var content = '';
      content  += '<a rel="' + cellvalue + '" class="btn btn-sm-action btn-success" onclick="edit('+cellvalue+')" title="Edit"><i class="fa fa-edit"></i></a> ';
      content  += '<a rel="' + cellvalue + '" class="btn btn-sm-action btn-danger" onclick="delete_data('+cellvalue+')" title="Delete"><i class="fa fa-times"></i></a> ';
      return content;
    }
    // FORMATTER STATUS //
    function formatterStatus(cellvalue, options, rowObject) {
      var content = '';
      if(cellvalue == 'Y'){
        content  += '<i class="fa fa-check green"></i> ';
      }else{
        content  += '<i class="fa fa-times red"></i> ';
      }
      return content;
    }

    // PAGER BUTTON
    jQuery(grid_selector).jqGrid('navGrid',pager_selector,
      {   //navbar options
        edit: false, editicon : 'ace-icon fa fa-pencil blue',
        add: false, addicon : 'ace-icon fa fa-plus-circle purple',
        del: false, delicon : 'ace-icon fa fa-trash-o red',
        search: false, searchicon : 'ace-icon fa fa-search orange',
        refresh: true, refreshicon : 'ace-icon fa fa-refresh green',
        view: false, viewicon : 'ace-icon fa fa-search-plus grey',
      }
    )

    //replace icons with FontAwesome icons like above
    function updatePagerIcons(table) {
      var replacement = 
      {
        'ui-icon-seek-first' : 'fa fa-angle-double-left bigger-140',
        'ui-icon-seek-prev' : 'fa fa-angle-left bigger-140',
        'ui-icon-seek-next' : 'fa fa-angle-right bigger-140',
        'ui-icon-seek-end' : 'fa fa-angle-double-right bigger-140'
      };
      $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
        var icon = $(this);
        var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
        
        if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
      })
    }
  
    
  });
  
  /*back to list*/
  function backlist(pgd_id){
    $("html, body").animate({ scrollTop: "400px" }, "slow");
    $('#content_tab_custom').html(loading);
    $('#content_tab_custom').load('AdmPengaduan/Tr_bukti?pgd_id='+pgd_id+'?_=' + (new Date()).getTime());
  }

  /*edit row*/
  function edit(id){
    var pgd_id = $('#pgd_id').val();
    $('#content_tab_custom').html(loading);
    $('#content_tab_custom').load('AdmPengaduan/Tr_bukti/form/'+ id + '?pgd_id='+pgd_id);
  }

  /*delete row*/
  function delete_data(id){
    
    var status = $('#status').val();
    var pgd_id = $('#pgd_id').val();
    var params = '';
    if(status != 1){
      params = '?pgd_id='+pgd_id+'&status='+status+'';
      $('#content_tab_custom').html(loading);
      $('#content_tab_custom').load('AdmPengaduan/Tr_bukti/processDelete'+params);
      return false;
    }
    
    if(confirm('Apakah anda yakin akan menghapus data ini?'))
      {
        // ajax delete data to database
          $.ajax({
            url: 'AdmPengaduan/Tr_bukti/processDelete',
            type: "post",
            data: {ID:id},
            dataType: "json",
            success: function(data) {
              greatComplete(data);
              $('#grid-table').trigger("reloadGrid");
            },
            error: function(xhr, ajaxOptions, thrownError){
              greatComplete({message:'Error code '+xhr.status+' : '+thrownError, gritter:'gritter-error'});
            },
          });
         
      }
    
  }

/*validator form*/
$.validator.setDefaults({
  submitHandler: function() { 
    
     url = "AdmPengaduan/Tr_bukti/process";
     lampiran = new Array();
      var formData = new FormData($('#form_bukti')[0]);
          //formData.append('file', $('input[type=file]')[0].files[0]);
      i = 0;
      $("input#file").each(function(){
          lampiran[i] = $('input[type=file]')[i].files[i];
          i++;
      })

      formData.append('file', lampiran);

       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: formData,
            contentType: false,
            dataType: "JSON",

            success: function(data) {
              greatComplete(data);
              backlist(data.pgd_id);
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
  $("#form_bukti").validate({
    rules: {
      
      pgdpp_tempat_kejadian: {
        required: true,
      },
      pgdpp_perbuatan: {
        required: true,
      },
      pgd_id: "required",
      pgdpp_tgl_kejadian: "required"
    },

    messages: {
      pgdpp_tempat_kejadian: {
        required: "Please fill this field!",
      },
      pgdpp_perbuatan: {
        required: "Please fill this field!",
      }, 
      pgdpp_tgl_kejadian: {
        required: "Please fill this field!",
      }, 
      pgd_id: {
        required: "Please fill this field!",
      },  
    }
  });


});


// jquery choosen //
jQuery(function($) {
  
  $('.date-picker').datepicker({
    autoclose: true,
    todayHighlight: true
  })
  //show datepicker when clicking on the icon
  .next().on(ace.click_event, function(){
    $(this).prev().focus();
  });

  if(!ace.vars['touch']) {
    $('.chosen-select').chosen({allow_single_deselect:true}); 
    //resize the chosen on window resize

    $(window)
    .off('resize.chosen')
    .on('resize.chosen', function() {
      $('.chosen-select').each(function() {
         var $this = $(this);
         $this.next().css({'width': $this.parent().width()});
      })
    }).trigger('resize.chosen');
    //resize chosen on sidebar collapse/expand
    $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
      if(event_name != 'sidebar_collapsed') return;
      $('.chosen-select').each(function() {
         var $this = $(this);
         $this.next().css({'width': $this.parent().width()});
      })
    });

  }

  /*$('#file').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false //| true | large
            //whitelist:'gif|png|jpg|jpeg'
            //blacklist:'exe|php'
            //onchange:''
            //
  });*/


});

//================== UPLOAD FILE ======================\\

  jQuery(function($) {
    var $form = $('#form_bukti');
    //you can have multiple files, or a file input with "multiple" attribute
    var file_input = $form.find('input[type=file]');
    var upload_in_progress = false;

    file_input.ace_file_input({
      style : 'well',
      btn_choose : 'Select or drop files here',
      btn_change: null,
      droppable: true,
      thumbnail: 'large',
      
      //maxSize: 999999999,//bytes
      //allowExt: ["jpeg", "jpg", "png", "gif"],
      //allowMime: ["image/jpg", "image/jpeg", "image/png", "image/gif"],

      before_remove: function() {
        if(upload_in_progress)
          return false;//if we are in the middle of uploading a file, don't allow resetting file input
        return true;
      },

      preview_error: function(filename , code) {
        //code = 1 means file load error
        //code = 2 image load error (possibly file is not an image)
        //code = 3 preview failed
      }
    })
    file_input.on('file.error.ace', function(ev, info) {
      //if(info.error_count['ext'] || info.error_count['mime']) alert('Invalid file type! Please select an image!');
      //if(info.error_count['size']) alert('Invalid file size! Maximum 100KB');
      
      //you can reset previous selection on error
      //ev.preventDefault();
      //file_input.ace_file_input('reset_input');
    });
    
    
    var ie_timeout = null;//a time for old browsers uploading via iframe
    
    $form.on('submit', function(e) {
      e.preventDefault();
    
      var files = file_input.data('ace_input_files');
      if( !files || files.length == 0 ) return false;//no files selected
                
      var deferred ;
      if( "FormData" in window ) {
        //for modern browsers that support FormData and uploading files via ajax
        //we can do >>> var formData_object = new FormData($form[0]);
        //but IE10 has a problem with that and throws an exception
        //and also browser adds and uploads all selected files, not the filtered ones.
        //and drag&dropped files won't be uploaded as well
        
        //so we change it to the following to upload only our filtered files
        //and to bypass IE10's error
        //and to include drag&dropped files as well
        formData_object = new FormData();//create empty FormData object
        
        //serialize our form (which excludes file inputs)
        $.each($form.serializeArray(), function(i, item) {
          //add them one by one to our FormData 
          formData_object.append(item.name, item.value);              
        });
        //and then add files
        $form.find('input[type=file]').each(function(){
          var field_name = $(this).attr('name');
          //for fields with "multiple" file support, field name should be something like `myfile[]`

          var files = $(this).data('ace_input_files');
          if(files && files.length > 0) {
            for(var f = 0; f < files.length; f++) {
              formData_object.append(field_name, files[f]);
            }
          }
        });


        upload_in_progress = true;
        file_input.ace_file_input('loading', true);
        
        deferred = $.ajax({
                  url: $form.attr('action'),
                 type: $form.attr('method'),
          processData: false,//important
          contentType: false,//important
             dataType: 'json',
                 data: formData_object
          
        })

      }
      else {
        //for older browsers that don't support FormData and uploading files via ajax
        //we use an iframe to upload the form(file) without leaving the page

        deferred = new $.Deferred //create a custom deferred object
        
        var temporary_iframe_id = 'temporary-iframe-'+(new Date()).getTime()+'-'+(parseInt(Math.random()*1000));
        var temp_iframe = 
            $('<iframe id="'+temporary_iframe_id+'" name="'+temporary_iframe_id+'" \
            frameborder="0" width="0" height="0" src="about:blank"\
            style="position:absolute; z-index:-1; visibility: hidden;"></iframe>')
            .insertAfter($form)

        $form.append('<input type="hidden" name="temporary-iframe-id" value="'+temporary_iframe_id+'" />');
        
        temp_iframe.data('deferrer' , deferred);
        //we save the deferred object to the iframe and in our server side response
        //we use "temporary-iframe-id" to access iframe and its deferred object
        
        $form.attr({
                method: 'POST',
               enctype: 'multipart/form-data',
                target: temporary_iframe_id //important
              });

        upload_in_progress = true;
        file_input.ace_file_input('loading', true);//display an overlay with loading icon
        $form.get(0).submit();
        
        
        //if we don't receive a response after 30 seconds, let's declare it as failed!
        ie_timeout = setTimeout(function(){
          ie_timeout = null;
          temp_iframe.attr('src', 'about:blank').remove();
          deferred.reject({'status':'fail', 'message':'Timeout!'});
        } , 30000);
      }


      ////////////////////////////
      //deferred callbacks, triggered by both ajax and iframe solution
      deferred
      .done(function(result) {//success
        //format of `result` is optional and sent by server
        //in this example, it's an array of multiple results for multiple uploaded files
        var message = '';
        for(var i = 0; i < result.length; i++) {
          if(result[i].status == 'OK') {
            //message += "File successfully saved. Thumbnail is: " + result[i].url;
            greatComplete(data);
            backlist(data.pgd_id);
          }
          else {
            message += "File not saved. " + result.message;
          }
          message += "\n";
        }
        alert(message);
      })
      .fail(function(result) {//failure
        alert("There was an error");
      })
      .always(function() {//called on both success and failure
        if(ie_timeout) clearTimeout(ie_timeout)
        ie_timeout = null;
        upload_in_progress = false;
        file_input.ace_file_input('loading', false);
      });

      deferred.promise();
    });


    //when "reset" button of form is hit, file field will be reset, but the custom UI won't
    //so you should reset the ui on your own
    $form.on('reset', function() {
      $(this).find('input[type=file]').ace_file_input('reset_input_ui');
    });


    if(location.protocol == 'file:') alert("For uploading to server, you should access this page using 'http' protocal, i.e. via a webserver.");

  });
