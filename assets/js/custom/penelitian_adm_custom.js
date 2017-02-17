jQuery(function($) {
    var grid_selector = "#grid-table";
    var pager_selector = "#grid-pager";
    
    var grid_selector_result = "#grid-table-result";
    var pager_selector_result = "#grid-pager-result";

    //resize to fit page size
    $(window).on('resize.jqGrid', function () {
      $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
      $(grid_selector_result).jqGrid( 'setGridWidth', $(".page-content").width() );
    })

    //resize on sidebar collapse/expand
    var parent_column = $(grid_selector).closest('[class*="col-"]');
    var parent_column_result = $(grid_selector_result).closest('[class*="col-"]');
    $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
      if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
        //setTimeout is for webkit only to give time for DOM changes and then redraw!!!
        setTimeout(function() {
          $(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
        }, 0);

        setTimeout(function() {
          $(grid_selector_result).jqGrid( 'setGridWidth', parent_column_result.width() );
        }, 0);

      }
    })
    
    /*generate grid table*/
    jQuery(grid_selector).jqGrid({
      
      url:'AdmPengaduan/Tr_penelitian_adm/getData', 
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
      colNames:['No Pendaftaran','Tanggal','Tempat Pengaduan','Tipe Pengaduan','Kategori Pemilu','Status Pengaduan','Action'],
      colModel:[
        
        {name:'id',index:'id', width:50, sorttype:"int", align:'left'},
        {name:'pgd_tanggal',index:'pgd_tanggal', width:50, align:'left'},
        {name:'pgd_tempat',index:'pgd_tempat', width:80,},
        {name:'tp_name',index:'tp_name', width:120,},
        {name:'kp_name',index:'kp_name', width:80,},
        {name:'status',index:'status', width:60,align:"center"},
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

      gridComplete: function(){ 
        var rowIds = $(grid_selector).getDataIDs();
          if(search_by=='ktp_nama_lengkap' || search_by=='ktp_nik' || search_by=='ktp_no_hp' || search_by=='prp_no_hp' || search_by=='prp_email'){
            $.each(rowIds, function (index, rowId) {
              $(grid_selector).expandSubGridRow(rowId); 
            });  
          }
      },

      altRows: false,
      multiselect: true,
      multiboxonly: true,

      //subgrid options
      subGrid : true,
      subGridOptions : {
      plusicon : "ace-icon fa fa-plus center bigger-110 blue",
      minusicon  : "ace-icon fa fa-minus center bigger-110 blue",
      openicon : "ace-icon fa fa-chevron-right center orange"
      },
      //for this example we are using local data
      subGridRowExpanded: function (subgridDivId, rowId) {
        var rowval = $(grid_selector).jqGrid('getRowData', rowId);
        var parent_id = rowval.id;

        var subgridTableId = subgridDivId + "_t";
        
        var htm='';
        $.getJSON("AdmPengaduan/Tr_registrasi/RiwayatStatus/" + parent_id, '', function(response) {
            $.each(response, function(i, o) {
                $('<h5 style="padding-top:10px"><i class="fa fa-check green"></i> '+o.ap_name+' <i class="fa fa-clock-o"></i> '+o.created_date+' <i class="fa fa-user"></i> '+o.created_by+' </h5>').appendTo($('#riwayat'+subgridDivId+''));
            });
        });
        htm += '<br><h5><b>Riwayat proses pengaduan</b></h5>';
        htm += '<div id="riwayat'+subgridDivId+'"></div>';

        htm += '<br><h5><b>Daftar para pihak pengaduan No.Registrasi  "<b><i>'+parent_id+'</i></b>"</b></h5>';
        htm += "<table id='" + subgridTableId + "'></table><br>";

        $("#" + subgridDivId).html(htm);
        $("#" + subgridTableId).jqGrid({

          url:'AdmPengaduan/Tr_pp/getData/'+parent_id, 
          rownumbers:true,
          mtype: 'POST',
          datatype: "json", 
          colNames:['ID','No Registrasi','Nama Pihak','NIK','No HP', 'Penyelenggara?' ,'Organisasi','Email','Flag'],
          colModel:[
            
            {name:'id',index:'id', width:50, sorttype:"int", align:'center'},
            {name:'pgd_id',index:'pgd_id', width:100, sorttype:"int", align:'center'},
            {name:'ktp_nama_lengkap',index:'ktp_nama_lengkap', width:200},
            {name:'ktp_nik',index:'ktp_nik', width:150, align:"center"},
            {name:'prp_no_hp',index:'prp_no_hp', width:100,align:"center"},
            {name:'prp_penyelenggara',index:'prp_penyelenggara', width:120, align:"center"},
            {name:'prp_organisasi',index:'prp_organisasi', width:100, align:"center"},
            {name:'prp_email',index:'prp_email', width:150},
            {name:'flag',index:'flag', width:90, align:"center"},
            
          ], 

          beforeRequest:function(){
            search_by=$('#search_by').val()?$('#search_by').val():'';
            keyword=$('#keyword').val()?$('#keyword').val():'';
            $('#'+subgridTableId).setGridParam({postData:{'parent':parent_id,'search_by':search_by,'keyword':keyword}})
          },

        });
      },
      
      loadComplete : function() {
        var table = this;
        setTimeout(function(){
        updatePagerIcons(table);
        }, 0);
      },

      autowidth: true,
      height: '100%',
  
    });

    /*generate grid table*/
    jQuery(grid_selector_result).jqGrid({
      
      url:'AdmPengaduan/Tr_penelitian_adm/getData?type=result', 
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
      colNames:['No Pendaftaran','No Pengaduan','Tanggal Penelitian','Penerima','Verifikator','Kesimpulan','Kelengkapan Form','Pokok Pengaduan','Status Pengaduan','Action'],
      colModel:[
        
        {name:'id',index:'id', width:60, sorttype:"int", align:'left'},
        {name:'pgd_no',index:'pgd_no', width:60, align:'center'},
        {name:'pgdhpa_tanggal_penelitian',index:'pgdhpa_tanggal_penelitian', width:70, align:"left"},
        {name:'penerima_pengaduan',index:'penerima_pengaduan', width:80,},
        {name:'verifikator',index:'verifikator', width:80},
        {name:'pgdhpa_kesimpulan',index:'pgdhpa_kesimpulan', width:80, align:'center'},
        {name:'pgdhpa_kelengkapan_form',index:'pgdhpa_kelengkapan_form', width:70, align:"center"},
        {name:'pgdhpa_pokok_pengaduan',index:'pgdhpa_pokok_pengaduan', hidden:true},
        {name:'status',index:'status', width:65,align:"center"},
        {name:'myid',index:'myid', sorttype:"int", width:60, formatter:formatterActionResult, align:'center'},

      ], 
  
      viewrecords : true,
      rowNum:10,
      rowList:[5,10,20,30],
      pager : pager_selector_result,
      
      beforeRequest:function(){
        search_by=$('#search_by').val()?$('#search_by').val():'';
        keyword=$('#keyword').val()?$('#keyword').val():'';
        $(grid_selector_result).setGridParam({postData:{'search_by':search_by,'keyword':keyword}})
      },

      gridComplete: function(){ 
        var rowIds = $(grid_selector_result).getDataIDs();
          if(search_by=='ktp_nama_lengkap' || search_by=='ktp_nik' || search_by=='ktp_no_hp' || search_by=='prp_no_hp' || search_by=='prp_email'){
            $.each(rowIds, function (index, rowId) {
              $(grid_selector_result).expandSubGridRow(rowId); 
            });  
          }
      },

      altRows: false,
      multiselect: true,
      multiboxonly: true,

      //subgrid options
      subGrid : true,
      subGridOptions : {
      plusicon : "ace-icon fa fa-plus center bigger-110 blue",
      minusicon  : "ace-icon fa fa-minus center bigger-110 blue",
      openicon : "ace-icon fa fa-chevron-right center orange"
      },
      //for this example we are using local data
      subGridRowExpanded: function (subgridDivId, rowId) {
        var rowval = $(grid_selector_result).jqGrid('getRowData', rowId);
        var parent_id = rowval.id;

        var subgridTableId = subgridDivId + "_t";
        
        var htm='';
        htm += '<br><h5><b>Pokok Pengaduan</b></h5>';
        htm += '<p>'+rowval.pgdhpa_pokok_pengaduan+'</p>';

        htm += '<br><h5><b>Daftar para pihak pengaduan No.Registrasi  "<b><i>'+parent_id+'</i></b>"</b></h5>';
        htm += "<table id='" + subgridTableId + "'></table><br>";

        $("#" + subgridDivId).html(htm);
        $("#" + subgridTableId).jqGrid({

          url:'AdmPengaduan/Tr_pp/getData/'+parent_id, 
          rownumbers:true,
          mtype: 'POST',
          datatype: "json", 
          colNames:['ID','No Registrasi','Nama Pihak','NIK','No HP', 'Penyelenggara?' ,'Organisasi','Email','Flag'],
          colModel:[
            
            {name:'id',index:'id', width:50, sorttype:"int", align:'center'},
            {name:'pgd_id',index:'pgd_id', width:100, sorttype:"int", align:'center'},
            {name:'ktp_nama_lengkap',index:'ktp_nama_lengkap', width:200},
            {name:'ktp_nik',index:'ktp_nik', width:150, align:"center"},
            {name:'prp_no_hp',index:'prp_no_hp', width:100,align:"center"},
            {name:'prp_penyelenggara',index:'prp_penyelenggara', width:120, align:"center"},
            {name:'prp_organisasi',index:'prp_organisasi', width:100, align:"center"},
            {name:'prp_email',index:'prp_email', width:150},
            {name:'flag',index:'flag', width:90, align:"center"},
            
          ], 

          beforeRequest:function(){
            search_by=$('#search_by').val()?$('#search_by').val():'';
            keyword=$('#keyword').val()?$('#keyword').val():'';
            $('#'+subgridTableId).setGridParam({postData:{'parent':parent_id,'search_by':search_by,'keyword':keyword}})
          },

        });
      },
      
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
                url: 'AdmPengaduan/Tr_penelitian_adm/processDelete',
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
    $('#btn_search_penelitian_adm').click(function (event) {
       event.preventDefault();
        /*if($('#select [name=search_by]').val() == 'pgd_tahun'){
          var pgd_tahun = $('#keyword').val();
          $('#data_pgd').html('Data Pengaduan Tahun ' +pgd_tahun '');
        }*/
        $(grid_selector).trigger("reloadGrid");
        $(grid_selector_result).trigger("reloadGrid");
    });

    // BUTTON RESET //
    $('#btn_reset_penelitian_adm').click(function (event) {
      event.preventDefault();
      $('#form_search_penelitian_adm')[0].reset();
      $(grid_selector).trigger("reloadGrid");
      $(grid_selector_result).trigger("reloadGrid");
    });

    // BUTTON ADD //
    $('#btn_add_penelitian_adm').click(function () {
      $('#page-area-content').html(loading);
      $('#page-area-content').load('AdmPengaduan/Tr_penelitian_adm/form/'+ '?_=' + (new Date()).getTime());
    });


    // FORMATTER ACTION //
    function formatterAction(cellvalue, options, rowObject) {
      var content = '';
       content  += '<a rel="' + cellvalue + '" class="btn btn-sm-action btn-primary" onclick="verifikasi('+cellvalue+')" title="Verifikasi"><i class="fa fa-toggle-down"></i> Verifikasi </a> ';
      return content;
    }

    function formatterActionResult(cellvalue, options, rowObject) {
      var content = '';
       content  += '<a rel="' + cellvalue + '" class="btn btn-sm-action btn-primary" onclick="verifikasi('+cellvalue+')" title="Verifikasi"><i class="fa fa-share-alt"></i> Selengkapnya </a> ';
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

    jQuery(grid_selector_result).jqGrid('navGrid',pager_selector_result,
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
  
    $('input:radio[name="type_penelitian_adm"]').change(function(){

      if ($(this).is(':checked') && $(this).val() == 'item') {

        /*show item penelitian administrasi*/
        jQuery("#item_penelitian_adm").show();
        $('#grid-table').trigger("reloadGrid");
        /*hide result penelitian administrasi*/
        jQuery("#result_penelitian_adm").hide();

      }else{

      /*show item penelitian administrasi*/
        jQuery("#result_penelitian_adm").show();
        $('#grid-table-result').trigger("reloadGrid");
        /*hide result penelitian administrasi*/
        jQuery("#item_penelitian_adm").hide();

      }

    });

  });
  
  /*back to list*/
  function backlist(){
    $('#page-area-content').html(loading);
    $('#page-area-content').load('AdmPengaduan/Tr_penelitian_adm?_=' + (new Date()).getTime());
  }

  /*edit row*/
  function verifikasi(id){
    $('#page-area-content').html(loading);
    $('#page-area-content').load('AdmPengaduan/Tr_penelitian_adm/form/'+ id + '?_=' + (new Date()).getTime());
  }

  /*delete row*/
  function delete_data(id){
    
    if(confirm('Apakah anda yakin akan menghapus data ini?'))
      {
        // ajax delete data to database
          $.ajax({
            url: 'AdmPengaduan/Tr_penelitian_adm/processDelete',
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
    
     url = "AdmPengaduan/Tr_penelitian_adm/process";

       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form_penelitian_adm').serialize(),
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
  $("#form_penelitian_adm").validate({
    rules: {
      
      pgd_tempat: {
        required: true,
        maxlength: 30
      },
      /*kp_id: {
        required: function () {

                   //if ($(".chosen-result").attr('data-option-array-index') == 0) {
                   if($('#kp_id option[value=0]')){
                       return true;
                   } else {
                       return false;
                   }
               } 
      },*/
      active: "required"

    },

    messages: {
      pgd_tempat: {
        required: "Please fill this field!",
      },
      /*kp_id: {
        required: "Please fill this field!",
      }*/
    }
  });


});

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





 