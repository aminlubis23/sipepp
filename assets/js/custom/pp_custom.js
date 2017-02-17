jQuery(function($) {
    var grid_selector = "#grid-table";
    var pager_selector = "#grid-pager";
    var pgd_id = $(grid_selector).attr('rel');
    var status = $('#status').val();
    
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
      
      url:'AdmPengaduan/Tr_pp/getData/'+pgd_id, 
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
      colNames:['ID','No Registrasi','Nama Pihak','NIK','No HP', 'Penyelenggara?' ,'Organisasi','Email','Flag','Action'],
      colModel:[
        
        {name:'id',index:'id', width:30, sorttype:"int", align:'center'},
        {name:'pgd_id',index:'pgd_id', width:70, sorttype:"int", align:'center'},
        {name:'ktp_nama_lengkap',index:'ktp_nama_lengkap', width:100},
        {name:'ktp_nik',index:'ktp_nik', width:85, align:"center"},
        {name:'prp_no_hp',index:'prp_no_hp', width:70,align:"center"},
        {name:'prp_penyelenggara',index:'prp_penyelenggara', width:60, align:"center"},
        {name:'prp_organisasi',index:'prp_organisasi', width:70, align:"center"},
        {name:'prp_email',index:'prp_email', width:80},
        {name:'flag',index:'flag', width:50, align:"center"},
        {name:'myid',index:'myid', sorttype:"int", width:70, formatter:formatterAction, align:'center'},

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
          $('#content_tab_custom').load('AdmPengaduan/Tr_pp/processDelete'+params);
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
                url: 'AdmPengaduan/Tr_pp/processDelete'+params,
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
    $('#btn_search_pp').click(function (event) {
       event.preventDefault();
        $(grid_selector).trigger("reloadGrid");
    });

    // BUTTON RESET //
    $('#btn_reset_pp').click(function (event) {
      event.preventDefault();
      $('#form_search_pp')[0].reset();
      $(grid_selector).trigger("reloadGrid");
    });

    // BUTTON ADD //
    $('#btn_add_pp').click(function () {
      $("html, body").animate({ scrollTop: "400px" }, "slow");
      $('#content_tab_custom').html(loading);
      var pgd_id = $('#pgd_id').val();
      var status = $('#status').val();
      var params = '';
      if(status != 1){
        params = '&status='+status+'';
      }
      $('#content_tab_custom').load('AdmPengaduan/Tr_pp/form?pgd_id='+pgd_id+''+params);
    
    });

    // RADIO SELECT YA FOR NEW MEMBER
    $('#new').click(function () { 
      $('#has_registered').hide('fast'); 
      $('#new_member').show('fast'); 
    });

    $('#old').click(function () { 
      $('#has_registered').show('fast'); 
      $('#new_member').hide('fast'); 
    });

    // RADIO SELECT YA FOR PENYELENGGARA
    $('#yes_penyelenggara').click(function () { 
      $('#no_penyelenggara_form').hide('fast'); 
      $('#yes_penyelenggara_form').show('fast'); 
    });

    $('#no_penyelenggara').click(function () { 
      $('#no_penyelenggara_form').show('fast'); 
      $('#yes_penyelenggara_form').hide('fast');  
    });

    // ONCHANGE WHEN ORG PENYELENGGARA PROVINSI OR KAB
    $('#pnylgra_id').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        if(valueSelected==2 || valueSelected==12){
          document.getElementById('divprovince').style.display = 'block'; 
          document.getElementById('divcity').style.display = 'none';     
        }else if(valueSelected==4 || valueSelected==15){
          document.getElementById('divprovince').style.display = 'none';   
          document.getElementById('divcity').style.display = 'block';   
        }else{
          document.getElementById('divprovince').style.display = 'none';  
          document.getElementById('divcity').style.display = 'none';    
        }
    });

    // BUTTON SEARCH PARA PIHAK EXIS //
    $("#btn_search_name_or_id").click(function(){
        var keyword_search = $('#keyword_search').val();
        if($('#keyword_search').val() == ''){
          alert('Masukan Kata Kunci !');
          return false;
        }
        var link = 'AdmPengaduan/Tr_pp/findData';

        $.ajax({
           type: "POST",
           dataType: "html",
           url: link,
           data: {keyword_search: keyword_search},
           success: function(msg){
               
               $('#result_searching').html(loading);
               if(msg == 'NO DATA'){
                      $("#result_searching").html('<span style="color:red"><i>Data tidak ditemukan</i></span>');
               }else{
                      $("#result_searching").html(''+msg+'');       
                      $('#result_searching').show('fast');                                          
               }

               $("#new_member").hide('fast');
                                                   
           }
        });                    
     });

    // FORMATTER ACTION //
    function formatterAction(cellvalue, options, rowObject) {
      var content = '';
      if(status == 1){
        content  += '<a rel="' + cellvalue + '" class="btn btn-sm-action btn-success" onclick="edit('+cellvalue+')" title="Edit"><i class="fa fa-edit"></i></a> ';
        content  += '<a rel="' + cellvalue + '" class="btn btn-sm-action btn-danger" onclick="delete_data('+cellvalue+')" title="Delete"><i class="fa fa-times"></i></a> ';
      }else{
        content  += '<a rel="' + cellvalue + '" class="btn btn-sm-action btn-primary" onclick="selengkapnya('+cellvalue+')" title="Selengkapnya"><i class="fa fa-share-alt"></i> Selengkapnya</a> ';
      }
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
  
  /*Show detil para pihak when click detail btn*/
  function showDetil(nik){

      var url_detil_pp = 'AdmPengaduan/Tr_pp/findDetilFromNik';
      $.ajax({
         type: "POST",
         dataType: "json",
         url: url_detil_pp,
         data: "nik="+nik,
         success: function(msg){
          var obj = msg;
          //alert(obj);
          
             $("#ktp_id").val(obj.ktp_id);
             $("#ktp_nama_lengkap").val(obj.ktp_nama_lengkap);
             $("#ktp_nik").val(obj.ktp_nik);
             $("#ktp_tempat_lahir").val(obj.ktp_tempat_lahir);
             $("#ktp_tanggal_lahir").val(obj.ktp_tanggal_lahir);
             $("#ktp_jk").val(obj.ktp_jk);
             $("#ktp_alamat").val(obj.ktp_alamat);
             $("#ktp_rt").val(obj.ktp_rt);
             $("#ktp_rw").val(obj.ktp_rw);
             $("input[name='ktp_jk'][value='"+obj.ktp_jk+"']").prop("checked",true);
             $("input[name='ktp_kewarganegaraan'][value='"+obj.ktp_kewarganegaraan+"']").prop("checked",true);

             $("#province_id").val(obj.province_id).change();
             $("#city_id").val(obj.city_id).change();
             $("#district_id").val(obj.district_id).change();
             $("#sub_district_id").val(obj.sub_district_id).change();

             $("#ms_id").val(obj.ms_id).change();
             $("#religion_id").val(obj.religion_id).change();
             $("#job_id").val(obj.job_id).change();
             $("#tb_id").val(obj.tb_id).change();

             $("#new_member").show();
             $("#has_registered").hide();
             $('#result_searching').hide();

             /*$('#nikExis').show();
             $('#resultnik').html(obj);*/
                                                 
         }
      });  
    }

  /*back to list*/
  function backlist(pgd_id){
    $("html, body").animate({ scrollTop: "400px" }, "slow");
    $('#content_tab_custom').html(loading);
    $('#content_tab_custom').load('AdmPengaduan/Tr_pp?pgd_id='+pgd_id);
  }

  /*edit row*/
  function edit(id){
    var pgd_id = $("#grid-table").attr('rel');
    $('#content_tab_custom').html(loading);
    $('#content_tab_custom').load('AdmPengaduan/Tr_pp/form/'+id+'?pgd_id='+ pgd_id);
  }

  /*selengkapnya row*/
  function selengkapnya(id){
    var pgd_id = $("#grid-table").attr('rel');
    $('#content_tab_custom').html(loading);
    $('#content_tab_custom').load('AdmPengaduan/Tr_pp/form/'+id+'?pgd_id='+ pgd_id);
  }

  /*delete row*/
  function delete_data(id){
    
    if(confirm('Apakah anda yakin akan menghapus data ini?'))
      {
        // ajax delete data to database
          $.ajax({
            url: 'AdmPengaduan/Tr_pp/processDelete',
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
    
     url = "AdmPengaduan/Tr_pp/process";

       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form_pp').serialize(),
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
  $("#form_pp").validate({
    rules: {
      
      ktp_nama_lengkap: {
        required: true,
      },
      ktp_alamat: {
        required: true,
      },
      active: "required",
      pgd_id: "required",
      prp_no_hp: "required",
      prp_email: "required"
    },

    messages: {
      ktp_nama_lengkap: {
        required: "Please fill this field!",
      },
      ktp_alamat: {
        required: "Please fill this field!",
      }, 
      prp_no_hp: {
        required: "Please fill this field!",
      }, 
      prp_email: {
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
