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
      
      url:'AdmPengaduan/Tr_peristiwa/getData/'+pgd_id, 
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
      colNames:['ID','No Registrasi','Tanggal Kejadian','Tempat Kejadian','Uraian Perbuatan','Action'],
      colModel:[
        
        {name:'id',index:'id', width:20, sorttype:"int", align:'center'},
        {name:'pgd_id',index:'pgd_id', width:40, sorttype:"int"},
        {name:'pgdpp_tgl_kejadian',index:'pgdpp_tgl_kejadian', width:60},
        {name:'pgdpp_tempat_kejadian',index:'pgdpp_tempat_kejadian', width:100},
        {name:'pgdpp_perbuatan',index:'pgdpp_perbuatan', width:150},
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
                url: 'AdmPengaduan/Tr_peristiwa/processDelete',
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
    $('#btn_search_peristiwa').click(function (event) {
       event.preventDefault();
        $(grid_selector).trigger("reloadGrid");
    });

    // BUTTON RESET //
    $('#btn_reset_peristiwa').click(function (event) {
      event.preventDefault();
      $('#form_search_peristiwa')[0].reset();
      $(grid_selector).trigger("reloadGrid");
    });

    // BUTTON ADD //
    $('#btn_add_peristiwa').click(function () {
      $("html, body").animate({ scrollTop: "400px" }, "slow");
      $('#content_tab_custom').html(loading);
      var pgd_id = $('#pgd_id').val();
      var status = $('#status').val();
      var params = '';
      if(status != 1){
        params = '&status='+status+'';
      }
      $('#content_tab_custom').load('AdmPengaduan/Tr_peristiwa/form?pgd_id='+pgd_id+''+params);
    
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
    $('#content_tab_custom').load('AdmPengaduan/Tr_peristiwa?pgd_id='+pgd_id);
  }

  /*edit row*/
  function edit(id){
    var pgd_id = $("#grid-table").attr('rel');
    $('#content_tab_custom').html(loading);
    $('#content_tab_custom').load('AdmPengaduan/Tr_peristiwa/form/'+id+'?pgd_id='+ pgd_id);
  }

  /*delete row*/
  function delete_data(id){
    
    var status = $('#status').val();
    var pgd_id = $('#pgd_id').val();
    var params = '';
    if(status != 1){
      params = '?pgd_id='+pgd_id+'&status='+status+'';
      $('#content_tab_custom').html(loading);
      $('#content_tab_custom').load('AdmPengaduan/Tr_peristiwa/processDelete'+params);
      return false;
    }

    if(confirm('Apakah anda yakin akan menghapus data ini?'))
      {
        // ajax delete data to database
          $.ajax({
            url: 'AdmPengaduan/Tr_peristiwa/processDelete'+params,
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
    
     url = "AdmPengaduan/Tr_peristiwa/process";

       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form_peristiwa').serialize(),
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
  $("#form_peristiwa").validate({
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


});
