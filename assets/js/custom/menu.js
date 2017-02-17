    var save_method; //for save method string
    var table;
      $(document).ready(function() {
        table = $('#dynamic-table').DataTable({ 
          
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          
          // Load data for the table's content from an Ajax source
          "ajax": {
              "url": "pengaturan/menu/ajax_list",
              "type": "POST"
          },

          //Set column definition initialisation properties.
          "columnDefs": [
          { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
          },
          ],

        });
      });

      // greating //
      function greatSuccess() {

        $.gritter.add({
               title: 'SUKSES!',
               text: 'Data berhasil diproses.',
               sticky: false,
               time: '1500',
               class_name: 'gritter-success'
        })

      }

    function greatError() {
        $.gritter.add({
             title: 'PERINGATAN!',
             text: 'Anda tidak memiliki hak akses atau terjadi kesalahan dalam proses.',
             sticky: false,
             time: '1500',
             class_name: 'gritter-error'
        })

    }
    function edit(id)
    {
    
      $('#page-area-content').html(loading);
      $('#page-area-content').load('pengaturan/menu/form/' + id + '?_=' + (new Date()).getTime());

    }

    function backlist()
    {
    
      $('#page-area-content').html(loading);
      $('#page-area-content').load('menu'+ '?_=' + (new Date()).getTime());

    }

    function add()
    {
      $('#page-area-content').html(loading);
      $('#page-area-content').load('pengaturan/menu/form/'+ '?_=' + (new Date()).getTime());

    }

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function delete_menu(id)
    {

      if(confirm('Apakah anda yakin akan menghapus data ini?'))
      {
        // ajax delete data to database
          $.ajax({
            url : "pengaturan/menu/ajax_delete/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               //if success reload ajax table
               greatSuccess();
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                greatError();
            }
        });
         
      }

    }


$.validator.setDefaults({
  submitHandler: function() { 
    
     url = "pengaturan/menu/ajax_add";

       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form_menu').serialize(),
            dataType: "JSON",
            success: function(data)
            { 

              greatSuccess();
              $('#btnSave').hide();
              $('#btnReset').hide();
              $('#btnAdd').show();
              //$('input[type="text"],texatrea, select', this).val('');
              //$('#form_menu').resetForm();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {

              greatError();

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
  $("#form_menu").validate({
    rules: {
      
      name: {
        required: true,
        maxlength: 30
      },
      link: {
        required: true
      },
      counter: {
        required: true,
        number: true
      },
      active: "required"

    },

    messages: {
      name: {
        required: "Masukan nama menu!",
        manlength: "Nama menu harus diisi maksimal 30 karaketer"
      },
      link: {
        required: "Masukan link!"
      },
      counter: {
        required: "Masukan counter!",
        number: "Counter harus diisi dengan angka!"
      },
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
    
    
    });
