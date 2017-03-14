<div class="col-xs-12">
 <ul class="nav nav-pills">
    <li role="presentation"  ><a href="<?= base_url() ?>inventory">รายการวัสดุทันตกรรม</a></li>
    <li role="presentation" ><a href="<?= base_url() ?>inventory/deposit">นำเข้าสินค้า</a></li>
    <li role="presentation"   ><a href="<?= base_url() ?>inventory/withdraw">นำออกสินค้า</a></li>
    <li role="presentation"   ><a href="<?= base_url() ?>inventory/product" >สินค้า</a></li>
    <li role="presentation" class="active" ><a href="<?= base_url() ?>inventory/category">ประเภทสินค้า</a></li>
    <li role="presentation" ><a href="<?= base_url() ?>inventory/log">ประวัติสินค้าเข้าออก</a></li>
</ul>


<div class="box">

  <div class="box-header with-border">

    <div class="box-title">
      ประเภทสินค้า 
    </div>
  </div>
  <div class="box-body ">
    <button type="button" data-toggle="modal" class="btn btn-primary" data-target="#addcategoryModal" > เพิ่มหมวดหมู่</button>
    <br class="clear"/>
    <div class="col-xs-12">
     <table id="categoryTable" class="table display" cellspacing="0" width="100%">
      <thead>
       <tr>
        <th></th>
        <th>ชื่อหมวดหมู่</th>
        <th>หมวดหมู่หลัก</th>
      </tr>
    </thead>
  </table>
</div>
</div>

</div>

<div id="addcategoryModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">ข้อมูลหมวดหมู่ </h4>
        </div>

        <form id="categoryform" action="<?php echo base_url() ?>inventory/savecategory" class="form-horizontal">
          <div class="modal-body">
            <div class="validation-form" id="echoForm"></div>
            <input type="hidden" name="category_id" value="" />
            <div class="form-group" >
              <label  class="control-label col-sm-2" for="name">ชื่อหมวดหมู่</label>
              <div class="col-sm-8">
                <input type="text" id="name" name="name" class="form-control"  placeholder=""/>
              </div>
            </div>
             <div class="form-group" >
            <label class="control-label col-sm-2"> หมวดหมู่หลัก</label>
            <div class="col-sm-8">
              <select class="form-control select2" name="parent_id" style="width:100%" >
                <?php foreach ($categorys->result_array() as $row){ ?>
                <option value="<?= $row['category_id'] ?>"  ><?= $row['name']; ?></option>
                <?php } ?>
              </select>
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
<script type="text/javascript">
    $(document).ready(function() {

        $('#categoryform ').resetForm();
        $(document).on('click', '.editable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>inventory/get_category/' + $(this).data('id'), function(data) {
                $('input[name="name"]').val(data.category.name);
                $('select[name="parent_id"]').val(data.category.parent_id);
                $('input[name="category_id"]').val(data.category.category_id);
                $('#addcategoryModal').modal('show');
                $('select[name="parent_id"]').trigger('change');

            });


        });
        $(document).on('click', '.deleteable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>inventory/delete_category/' + $(this).data('id'), function(data) {
                recreateTable();

            });

        });
        $('#addcategoryModal').on('hidden.bs.modal', function() {
            // do something…
            if ($('input[name="category_id"]').val().length > 0) {
                $('input[name="category_id"]').val('');
            }
            $('#categoryform ').resetForm();
            $('select').trigger('change');
            $('.validation-form').empty();
        });
        $('#price').mask("##0.00", {
            reverse: true
        });
        var categoryTable = $('#categoryTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "ajax": '<?= base_url() ?>inventory/listcategory/',
            columns: [{
                render: function(data, type, row) {
                    if (type === 'display') {
                        return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>';
                    }
                    return data;
                },
                className: "dt-body-center"
            }, {}, {}]
        });

        var recreateTable = function() {
            if (categoryTable) {
                categoryTable.destroy();
            }
            categoryTable = $('#categoryTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "ajax": '<?= base_url() ?>inventory/listcategory/',
                columns: [{
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>';
                        }
                        return data;
                    },
                    className: "dt-body-center"
                }, {}, {}]
            });
        }

        $('#categoryform').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#echoForm',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                        if ($('input[name="category_id"]').val().length > 0) {
                            $('input[name="category_id"]').val('');
                        }

                        $('#categoryform ').resetForm();
                        $('.validation-form').empty();
                        $('select').trigger('change');
                        recreateTable();
                        $('#addcategoryModal').modal('hide');
                    } else {
                        $('.validation-form').empty();
                        $('.validation-form').append('<div class="alert alert-danger alert-dismissible">' +
                            responseText.message + '</div>');
                    }

                    // datatable.columns.adjust().draw(); // Redraw the DataTable
                }
            })
        });

        $('.select2').select2();
        $('form').preventDoubleSubmission();
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    });

    $(function() {
      $('#categoryTable').on('click', '.toggle', function () {
          //Gets all <tr>'s  of greater depth
          //below element in the table
          var findChildren = function (tr) {
              var depth = tr.data('depth');
              return tr.nextUntil($('tr').filter(function () {
                  return $(this).data('depth') <= depth;
              }));
          };

          var el = $(this);
          var tr = el.closest('tr'); //Get <tr> parent of toggle button
          var children = findChildren(tr);

          //Remove already collapsed nodes from children so that we don't
          //make them visible. 
          //(Confused? Remove this code and close Item 2, close Item 1 
          //then open Item 1 again, then you will understand)
          var subnodes = children.filter('.expand');
          subnodes.each(function () {
              var subnode = $(this);
              var subnodeChildren = findChildren(subnode);
              children = children.not(subnodeChildren);
          });

          //Change icon and hide/show children
          if (tr.hasClass('collapse')) {
              tr.removeClass('collapse').addClass('expand');
              children.hide();
          } else {
              tr.removeClass('expand').addClass('collapse');
              children.show();
          }
          return children;
      });
  });
</script>
<style>
    .modal-dialog{
       width: 800px!important;
   }
   .bootstrap-timepicker-widget{
       z-index: 1051!important;
   }
   .bootstrap-timepicker-widget table td input {
    width: 50px;
    margin:0 auto;
}
table.timesetup {
    empty-cells: show;
    border: 1px solid #000;
}
table.timesetup th{
    text-align:center;
}
table.timesetup th,.timesetup td {
    min-width: 2em;
    min-height: 2em;
    border: 1px solid #000!important;

}
.timesetup>tbody>tr>th{

    border-left: 1px solid #000!important;
}

</style>