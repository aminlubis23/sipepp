jQuery(function($) {
    var grid_selector = "#grid_table_berita";
    var pager_selector = "#grid_pager_berita";
    
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
    
    jQuery(grid_selector).jqGrid({
      //direction: "rtl",
      
      url:'conf_web/berita/get_data', 
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
      colNames:['ID','Judul Berita', 'Penulis', 'Sumber','Tanggal Berita','Kategori','Jenis Berita','Slider?','Publish?','Aktif?','Action'],
      colModel:[
        
        {name:'id',index:'id', width:30, sorttype:"int",align:"center"},
        {name:'judul_berita',index:'judul_berita', width:150},
        {name:'penulis',index:'penulis', width:60, align:'center'},
        {name:'sumber',index:'sumber', width:100},
        {name:'tanggal_berita',index:'tanggal_berita', width:80},
        {name:'category_name',index:'category_name', width:60, align:'center'},
        {name:'jenis_berita',index:'jenis_berita',width:60, align:'center'},
        {name:'main',index:'main', sorttype:"date", width:43,align:'center', formatter:formatterEnum},
        {name:'publish',index:'publish', sorttype:"date", width:43,align:'center', formatter:formatterEnum},
        {name:'active',index:'active', sorttype:"date", width:43, align:'center', formatter:formatterEnum},
        {name:'myid',index:'myid', sorttype:"int", width:65,align:'center', formatter:formatterAction},

      ], 
  
      viewrecords : true,
      rowNum:10,
      rowList:[5,10,20,30],
      pager : pager_selector,
      
      beforeRequest:function(){
        search_by=$('#search_by_category_berita').val()?$('#search_by_category_berita').val():'';
        keyword=$('#keyword_berita').val()?$('#keyword_berita').val():'';
        $(grid_selector).setGridParam({postData:{'search_by':search_by,'keyword':keyword}})
      },

      altRows: false,
      multiselect: true,
      multiboxonly: true,
      sortorder: 'desc',
      
      loadComplete : function() {
        var table = this;
        setTimeout(function(){
        updatePagerIcons(table);
        }, 0);
      },

      autowidth: true,
      height: '100%',
  
    });

    $(window).triggerHandler('resize.jqGrid');//trigger window resize to make the grid get the correct size
    
    // BUTTON SEARCH //
    $('#btn_search_berita').click(function (event) {
       event.preventDefault();
        $(grid_selector).trigger("reloadGrid");
    });

    // BUTTON RESET //
    $('#btn_reset_berita').click(function (event) {
      event.preventDefault();
      $('#form_search_index_berita')[0].reset();
      $(grid_selector).trigger("reloadGrid");
    });

    // BUTTON ADD //
    $('#btn_add_menu').click(function () {
      $('#page-area-content').html(loading);
      $('#page-area-content').load('conf_web/berita/form/'+ '?_=' + (new Date()).getTime());
    });

    // FORMATTER ACTION //
    function formatterAction(cellvalue, options, rowObject) {
      var content = '';
      content  += '<a rel="' + cellvalue + '" class="btn btn-sm-action btn-success" onclick="detail('+cellvalue+')" title="Edit"><i class="fa fa-eye"></i></a> ';
      content  += '<a rel="' + cellvalue + '" class="btn btn-sm-action btn-primary" onclick="edit('+cellvalue+')" title="Edit"><i class="fa fa-pencil"></i></a> ';
      content  += '<a rel="' + cellvalue + '" class="btn btn-sm-action btn-danger" onclick="delete_data('+cellvalue+')" title="Delete"><i class="fa fa-trash-o"></i></a> ';
      return content;
    }

    // FORMATTER ENUM //
    function formatterEnum(cellvalue, options, rowObject) {
      var content = '';
      if(cellvalue == 'Y'){
        content  += '<i class="fa fa-check-circle green"></i>';
      }else{
        content  += '<i class="fa fa-times-circle red"></i>';
      }
      return content;
    }

    // PAGER BUTTON
    /*jQuery(grid_selector).jqGrid('navGrid',pager_selector,
      {   //navbar options
        edit: false, editicon : 'ace-icon fa fa-pencil blue',
        add: false, addicon : 'ace-icon fa fa-plus-circle purple',
        del: false, delicon : 'ace-icon fa fa-trash-o red',
        search: false, searchicon : 'ace-icon fa fa-search orange',
        refresh: true, refreshicon : 'ace-icon fa fa-refresh green',
        view: false, viewicon : 'ace-icon fa fa-search-plus grey',
      }
    )*/

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
  

  function backlist(){
    $('#page-area-content').html(loading);
    $('#page-area-content').load('berita?_=' + (new Date()).getTime());
  }

  function edit(id){
    $('#page-area-content').html(loading);
    $('#page-area-content').load('conf_web/berita/form/'+ id + '?_=' + (new Date()).getTime());
  }

  function delete_data(id){
    //achtungShowLoader();
    if(confirm('Apakah anda yakin akan menghapus data ini?'))
      {
        // ajax delete data to database
          $.ajax({
            url: 'conf_web/berita/ajax_delete',
            type: "post",
            data: {ID:id},
            dataType: "json",
            success: function(data) {
              greatComplete(data);
              backlist();
            },
            error: function(xhr, ajaxOptions, thrownError){
              greatComplete({message:'Error code '+xhr.status+' : '+thrownError, gritter:'gritter-error'});
            },
          });
         
      }

    
  }


$.validator.setDefaults({
  submitHandler: function() { 
    
     url = "berita/ajax_add";
     var isi_berita = $("#isi_berita").val();
     var formData = new FormData($('#form_berita')[0]);
         formData.append('path_thumbnail', $('input[type=file]')[0].files[0]);
         formData.append('isi_berita', isi_berita);
         $('#btnSave').attr('disabled', true);
         $('#btnSave').html('sedang proses......');

       // ajax adding data to database
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
              backlist();
              $('#btnSave').hide();
              $('#btnReset').hide();
              $('#btnAdd').show();
              //$('input[type="text"],texatrea, select', this).val('');
              //$('#form_berita').resetForm();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {

              greatComplete({message:'Error code '+xhr.status+' : '+thrownError, gritter:'gritter-error'});
         
            }
        });

  }

});

function disabledBtn()
  {
    $('#btnSave').disabled = true;
    return true;
  }


// jquery validation //
$().ready(function() {

  // validate signup form on keyup and submit
  $("#form_berita").validate({
    rules: {
      
      judul_berita: "required",
      penulis: "required",
      tanggal_berita: "required",
      category_id: "required",
      active: "required"
    },

    messages: {
      judul_berita: "Masukan judul berita!",
      category_id: "Masukan kategori berita!",
      penulis: "Masukan judul penulis!",
      tanggal_berita: "Masukan tanggal berita!",
      active: "Pilih status aktif",
    }
  });


});

jQuery(function($) {

  $(".select2").css('width','340px').select2({allowClear:true})
  .on('change', function(){
    $(this).closest('form').validate().element($(this));
  }); 

  $('#path_thumbnail').ace_file_input({
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
  });
});

/*$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
  _title: function(title) {
    var $title = this.options.title || '&nbsp;'
    if( ("title_html" in this.options) && this.options.title_html == true )
      title.html($title);
    else title.text($title);
  }
}));*/

function detail(id){
  $('body,html').animate({ scrollTop: "150" }, 750, 'easeOutExpo' );
  $('#contentDetail').empty();
  $('#contentDetail').load('conf_web/berita/detail/' + id + '?_=' + (new Date()).getTime());
  $( "#contentDetail" ).removeClass('hide').dialog({
    resizable: true,
    width: '1020',
    modal: true,
    title: "<div class='widget-header'><i class='ace-icon fa fa-search red'></i> Detail Berita</div>",
    title_html: true,
    buttons: [
      {
        html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Close",
        "class" : "btn btn-minier",
        click: function() {
          $( this ).dialog( "close" );
        }
      }
    ]
  });

}
