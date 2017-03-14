<style>

.form-group .row div{
  text-align: right;
  vertical-align: center;
}
.form-group .row label{
  line-height: 34px;
}

</style>
<section class="content-header">
<ul class="nav nav-pills">
    <li role="presentation" ><a href="<?= base_url() ?>labs">ค้นหางานแล็บ</a></li>
    <li role="presentation" class="active" ><a href="<?= base_url() ?>lab/name" >เพิ่มชื่อแล็บ</a></li>
    <li role="presentation"><a href="<?= base_url() ?>lab/servicename">เพิ่มชื่อบริการ</a></li>
    <li role="presentation"  ><a href="<?= base_url() ?>lab/edit">ข้อมูลแล็บ</a></li>
</section>
<div class="col-xs-12">

<div class="box">

  <div class="box-body">
    <div class="col-md-6">
                    <button type="button" data-toggle="modal" class="btn btn-primary" data-target="#addLabModal" > เพิ่มชื่อแล็บ  </button>
       <table id="labTable" class="table display " cellspacing="0" width="100%">
            <thead>
                <tr>
                   <th></th>
                    <th>ชื่อ</th>
                </tr>
            </thead>
        </table>
    </div>
  </div>
     <div id="addLabModal" class="modal fade" >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">เพิ่มข้อมูลแล็บ</h4>
          </div>

            <form id="labform" action="<?php echo base_url() ?>ajax/labmastersave" class="form-horizontal">
          <div class="modal-body">
            <div class="validation-form" id="echoForm"></div>
                <input type="hidden" name="lab_id" value="" />
               <div class="form-group ">

                    <label for="lab"  class="control-label col-sm-2">ชื่อ แล็บ</label>
                    <div class="col-sm-8">
                        <input type="text" name="name" class="form-control" /> 
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ยกเลิก</button>
            <button type="submit" class="btn btn-primary btn-save">บันทึก</button>
          </div>

            </form>
        </div>
      </div>
    </div>
</div>
</div>
<script type="text/javascript" >

  $(document).ready(function(){
     $(document).on('click','.editable',function(evt){
        evt.preventDefault();
        $.get('<?=base_url() ?>ajax/get_masterlab/'+$(this).data('id'),function(data){
             $('input[name="name"]').val(data.name);
              $('input[name="lab_id"]').val(data.lab_id);
            $('#addLabModal').modal('show');

        });
       


     });
     $('#addLabModal').on('hidden.bs.modal', function () {
        // do something…
          $('#labform')[0].reset();
          $('input[name="lab_id"]').val('');
          $('.validation-form').empty();
    });
       $(document).on('click','.deleteable',function(evt){
          evt.preventDefault();
            $.get('<?=base_url() ?>ajax/delete_masterlab/'+$(this).data('id'),function(data){
                recreateTable();

            });

         });
          $('#labform').on('submit', function(e) {
          e.preventDefault(); // prevent native submit
          $(this).ajaxSubmit({
            type:'POST',
            dataType:'json',
              target: '#echoForm',
              success:function(responseText, statusText, xhr, $form)  { 
                  if(responseText.status == '1'){
                       $('#labform')[0].reset();
                      $('input[name="lab_id"]').val('');
                       $('.validation-form').empty();
                   
                      recreateTable();
                      $('#addLabModal').modal('hide');
                  }else{
                    $('.validation-form').append('<div class="alert alert-danger alert-dismissible">'
                      +responseText.message+'</div>');
                  }

                  // datatable.columns.adjust().draw(); // Redraw the DataTable
              }
          })
      });
  });
    var labTable = $('#labTable').DataTable( {
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "ajax": '<?= base_url() ?>ajax/listlab/',
           columns: [  {
                render: function ( data, type, row ) {
                    if ( type === 'display' ) {
                        return '<a  href="#" class="editable" data-id="'+data+'">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="'+data+'">ลบ </a>';
                    }
                    return data;
                },
                className: "dt-body-center"
            },{}
          ]
      } );

 var recreateTable = function(){
    if(labTable){
        labTable.destroy();
    }
     labTable = $('#labTable').DataTable( {
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "ajax": '<?= base_url() ?>ajax/listlab/',
                     columns: [  {
                          render: function ( data, type, row ) {
                              if ( type === 'display' ) {
                                       return '<a  href="#" class="editable" data-id="'+data+'">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="'+data+'">ลบ </a>';
                              }
                              return data;
                          },
                          className: "dt-body-center"
                      },{}
                    ]
         } );
 }


  
</script>
    <!-- /.box-header -->