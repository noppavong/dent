<div class="col-xs-12">
 <ul class="nav nav-pills">
    <li role="presentation"  ><a href="<?= base_url() ?>inventory">รายการวัสดุทันตกรรม</a></li>
    <li role="presentation" ><a href="<?= base_url() ?>inventory/deposit">นำเข้าสินค้า</a></li>
    <li role="presentation"   ><a href="<?= base_url() ?>inventory/withdraw">นำออกสินค้า</a></li>
    <li role="presentation"  class="active"  ><a href="<?= base_url() ?>inventory/product" >สินค้า</a></li>
    <li role="presentation"><a href="<?= base_url() ?>inventory/category">ประเภทสินค้า</a></li>
    <li role="presentation" ><a href="<?= base_url() ?>inventory/log">ประวัติสินค้าเข้าออก</a></li>
</ul>


<div class="box">

  <div class="box-header with-border">

    <div class="box-title">
      จัดการสินค้า 
    </div>
  </div>
  <div class="box-body ">
    <button type="button" data-toggle="modal" class="btn btn-primary" data-target="#addproductModal" > เพิ่มสินค้า</button>
    <br class="clear"/>
    <div class="col-xs-12">
     <table id="productTable" class="table display" cellspacing="0" width="100%">
      <thead>
       <tr>
        <th></th>
        <th>รหัสสินค้า</th>
        <th>ชื่อสินค้า</th>
        <th>ราคา</th>
        <th>หมวดหมู่</th>
        <th>วันหมดอายุ</th>
      </tr>
    </thead>
  </table>
</div>
</div>

</div>

<div id="addproductModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">ข้อมูลสินค้า </h4>
        </div>

        <form id="productform" action="<?php echo base_url() ?>inventory/saveproduct" class="form-horizontal">
          <div class="modal-body">
            <div class="validation-form" id="echoForm"></div>
            <input type="hidden" name="product_id" value="" />
            <div class="form-group" >
              <label  class="control-label col-sm-2" for="name">รหัสสินค้า</label>
              <div class="col-sm-4">
                <input type="text" id="code" name="code" class="form-control"  placeholder=""/>
              </div>
            </div>
             <div class="form-group" >
              
                <label  class="control-label col-sm-2" for="name">ชื่อสินค้า</label>
              <div class="col-sm-8">
                <input type="text" id="name" name="name" class="form-control"  placeholder=""/>
              </div>
            </div>
             <div class="form-group" >
              <label class="control-label col-sm-2"> ราคา</label>
            <div class="col-sm-4">
             <input type="text" id="price" name="price" class="form-control"  placeholder=""/>
            </div>
            <label class="control-label col-sm-2"> หมวดหมู่</label>
            <div class="col-sm-4">
              <select class="form-control select2" name="category_id" style="width:100%" >
                <?php foreach ($categorys->result_array() as $row){ ?>
                <option value="<?= $row['category_id'] ?>"  ><?= $row['name']; ?></option>
                <?php } ?>
              </select>
            </div>
            </div>
			 <div class="form-group" >
              <label  class="control-label col-sm-2" for="name">วันหมดอายุ</label>
              <div class="col-sm-4">
                <input type="text" id="datepicker2" data-date-format="dd-mm-yyyy" name="expire_date" class="form-control"  placeholder=""/>
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

        $('#productform ').resetForm();
        $(document).on('click', '.editable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>inventory/get_product/' + $(this).data('id'), function(data) {
            	console.log(data);
                $('input[name="name"]').val(data.product.name);
                    $('input[name="product_id"]').val(data.product.product_id);
                $('input[name="price"]').val(data.product.price);
                if(data.product.expire_date){
	                $('input[name="expire_date"]').val(data.product.expire_date);
                }
                $('input[name="code"]').val(data.product.code);
                $('select[name="category_id"]').val(data.product.category_id);
                $('select[name="type"]').val(data.product.type);
                $('#addproductModal').modal('show');
                $('select[name="category_id"]').trigger('change');

            });


        });
        $(document).on('click', '.deleteable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>inventory/delete_product/' + $(this).data('id'), function(data) {
                recreateTable();

            });

        });
        $('#addproductModal').on('hidden.bs.modal', function() {
            // do something…
            if ($('input[name="product_id"]').val().length > 0) {
                $('input[name="product_id"]').val('');
            }
            $('#productform ').resetForm();
            $('select').trigger('change');
            $('.validation-form').empty();
        });
        $('#price').mask("##0.00", {
            reverse: true
        });
        var productTable = $('#productTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "ajax": '<?= base_url() ?>inventory/listproduct/',
            columns: [{
                render: function(data, type, row) {
                    if (type === 'display') {
                        return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>';
                    }
                    return data;
                },
                className: "dt-body-center"
            }, {}, {}, {}, {}, {}]
        });

        var recreateTable = function() {
            if (productTable) {
                productTable.destroy();
            }
            productTable = $('#productTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "ajax": '<?= base_url() ?>inventory/listproduct/',
                columns: [{
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>';
                        }
                        return data;
                    },
                    className: "dt-body-center"
                }, {}, {}, {}, {}, {}]
            });
        }

        $('#productform').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#echoForm',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                        if ($('input[name="product_id"]').val().length > 0) {
                            $('input[name="product_id"]').val('');
                        }

                        $('#productform ').resetForm();
                        $('.validation-form').empty();
                        $('select').trigger('change');
                        recreateTable();
                        $('#addproductModal').modal('hide');
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
	
    $('#datepicker2').datepicker({
        autoclose: true,
        dateFormat: 'dd-mm-yy',
    });
    $(function() {
      $('#productTable').on('click', '.toggle', function () {
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