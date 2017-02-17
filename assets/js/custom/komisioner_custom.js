jQuery(function($) {
    var grid_selector = "#grid-table";
    var pager_selector = "#grid-pager";
    
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
      
      url:'Kepegawaian/Tr_komisioner/getData', 
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
      colNames:['ID','Nama Pegawai','Awal Jabatan','Akhir Jabatan','Active?','Last Update','Action'],
      colModel:[
        
        {name:'id',index:'id', width:30, sorttype:"int", align:'center'},
        {name:'ktp_nama_lengkap',index:'ktp_nama_lengkap', width:200},
        {name:'awal_jabatan',index:'awal_jabatan', width:70},
        {name:'akhir_jabatan',index:'akhir_jabatan', width:70, align:'center'},
        {name:'active',index:'active', width:60, align:'center', formatter:formatterStatus},
        {name:'updated_date',index:'updated_date', sorttype:"date", width:100, align:'center'},
        {name:'myid',index:'myid', sorttype:"int", width:60, formatter:formatterAction, align:'center'},

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
        var selectedrows = $("#grid-table").jqGrid('getGridParam','selarrrow');

        if(selectedrows.length) {

          if(confirm('Apakah anda yakin akan menghapus data ini?')){

            for(var i=0;i<selectedrows.length; i++) {

            var selecteddatais = $("#grid-table").jqGrid('getRowData',selectedrows[i]);
                var rows=JSON.stringify(selecteddatais)
                var postArray = {json:rows};

              $.ajax({
                type: "POST",
                url: 'Kepegawaian/Tr_komisioner/processDelete',
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
    $('#btn_search_komisioner').click(function (event) {
       event.preventDefault();
        $(grid_selector).trigger("reloadGrid");
    });

    // BUTTON RESET //
    $('#btn_reset_komisioner').click(function (event) {
      event.preventDefault();
      $('#form_search_komisioner')[0].reset();
      $(grid_selector).trigger("reloadGrid");
    });

    // BUTTON ADD //
    $('#btn_add_komisioner').click(function () {
      $('#page-area-content').html(loading);
      $('#page-area-content').load('Kepegawaian/Tr_komisioner/form/'+ '?_=' + (new Date()).getTime());
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
  function backlist(){
    $('#page-area-content').html(loading);
    $('#page-area-content').load('Kepegawaian/Tr_komisioner?_=' + (new Date()).getTime());
  }

  /*edit row*/
  function edit(id){
    $('#page-area-content').html(loading);
    $('#page-area-content').load('Kepegawaian/Tr_komisioner/form/'+ id + '?_=' + (new Date()).getTime());
  }

  /*delete row*/
  function delete_data(id){
    
    if(confirm('Apakah anda yakin akan menghapus data ini?'))
      {
        // ajax delete data to database
          $.ajax({
            url: 'Kepegawaian/Tr_komisioner/processDelete',
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
    
     url = "Kepegawaian/Tr_komisioner/process";

       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form_komisioner').serialize(),
            dataType: "JSON",

            success: function(data) {
              greatComplete(data);
              backlist();
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
  $("#form_komisioner").validate({
    rules: {
      
      fullname: "required",
      password: {
        required: true,
        minlength: 5
      },
      confirm_password: {
        required: true,
        minlength: 5,
        equalTo: "#password"
      },
      email: {
        required: true,
      },
      role: {
        required: function () {
                   if ($("#role option[value='0']")) {
                       return true;
                   } else {
                       return false;
                   }
               } 
      },
      active: "required"
    },

    messages: {
      fullname: "Please fill this field!",
      password: {
        required: "Please fill this field!",
        minlength: "Please fill this field 5 characters minimum!"
      },
      confirm_password: {
        required: "Please fill this field!",
        minlength: "Please fill this field 5 characters minimum!",
        equalTo: "Password doesn't match!"
      },
      email: {
        required: "Please fill this field!",
        email: "Please fill valid email!" 
      },
      role: {
        required: "Please choose one of this option!" 
      },
      active: "Please choose one of this option!"
    }
  });


});

// jquery choosen //
jQuery(function($) {
  

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

  $('.date-picker').datepicker({
    autoclose: true,
    todayHighlight: true
  })
  //show datepicker when clicking on the icon
  .next().on(ace.click_event, function(){
    $(this).prev().focus();
  });


});

window.setTimeout( refreshGrid, 180000);

function refreshGrid()
{
   var grid = jQuery("#grid-table");
   grid.trigger("reloadGrid");

   window.setTimeout(refreshGrid, 1800000);

}


