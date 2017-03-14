<script src="<?=base_url() ?>assets/js/hansontable/handsontable.full.js"></script>

<link rel="stylesheet" media="screen" href="<?=base_url() ?>assets/js/hansontable/handsontable.full.css">


<div class="col-xs-12" >
 <ul class="nav nav-pills">
    <li role="presentation"  ><a href="<?= base_url() ?>inventory">รายการวัสดุทันตกรรม</a></li>
    <li role="presentation" class="active" ><a href="<?= base_url() ?>inventory/deposit">นำเข้าสินค้า</a></li>
    <li role="presentation"   ><a href="<?= base_url() ?>inventory/withdraw">นำออกสินค้า</a></li>
    <li role="presentation"  ><a href="<?= base_url() ?>inventory/product" >สินค้า</a></li>
    <li role="presentation"><a href="<?= base_url() ?>inventory/category">ประเภทสินค้า</a></li>
    <li role="presentation" ><a href="<?= base_url() ?>inventory/log">ประวัติสินค้าเข้าออก</a></li>
</ul>

 <div class="box">

    <div class="box-header with-border">
 	<div class="box-title">
 		รายการวัสดุทันตกรรม
    </div>
 	<div class="box-body ">

        <div id="products" style="display: none">
            <?php echo json_encode($product) ?>
        </div>
          <div id="products_exp" style="display: none">
            <?php echo json_encode($product_exp) ?>
        </div>
    <form id="depositform" action="<?php echo base_url() ?>inventory/savedeposit" class="form-horizontal">
         <div class="validation-form" id="echoForm"></div>
        <div class="form-group" >
              <label  class="control-label col-sm-2" for="name">วันที่นำเข้า</label>
              <div class="col-sm-4">
            <input type="text" id="datepicker2" data-date-format="dd-mm-yyyy" name="deposit_date" class="form-control"  placeholder=""/>
          </div>
        </div>
       <div class="form-group" >
            <label  class="control-label col-sm-2" for="name">รายการวัสดุทันตกรรม</label>
      
               <button type="submit" class="btn btn-primary btn-save">บันทึก</button>
         </div>
     
    </form>
       <div class="col-xs-12">
            <div id="stock_in_put" width="100%"></div>

            </div>
        </div>
 </div>
 </div>
<script type="text/javascript">

$('#datepicker2').datepicker({
    autoclose: true,
    dateFormat: 'dd-mm-yy',
});
jQuery(document).ready(function(){


var product = JSON.parse($('#products').html());
var product_exp = JSON.parse($('#products_exp').html());
var container = document.getElementById('stock_in_put');
var hot = new Handsontable(container, {
    data:[],
    minSpareRows: 1,
   dataSchema: {code: null,expire_dt:null, name:null,quantity:null, price: null},
    colHeaders: ["รหัสสินค้า","วันหมดอายุ", "ชื่อสินค้า", "จำนวน", "ราคา"],
    colWidths: [150, 150,300, 150,150],
    rowHeaders: true,
     columns: [
      {
        data:'code',
        type: 'autocomplete',
        source: function (query, process) {
          $.ajax({
            //url: 'php/cars.php', // commented out because our website is hosted as a set of static pages
            url: '<?=base_url()?>ajax/products',
            dataType: 'json',
            data: {
              query: query
            },
            success: function (response) {
              //process(JSON.parse(response.data)); // JSON.parse takes string as a argument
              process(response.data);

            }
          });
        },
        strict: true
      },
      {
        data:'expire_dt',
        type: 'dropdown'
      }, 
      {
        data:'name',
        readOnly: true
      }, // Year is a default text column
      {
        data:'quantity',        
        type: 'numeric'
      },  // Chassis color is a default text column
      {
        data:'price',
        readOnly: true
      },// Bumper color is a default text column
    ],
     afterChange : function(arr, op) {
        if(op=="edit"&&arr.length==1) {
            var value = arr[0][3];
            if(arr[0][1]=='code')
            {
                hot.setDataAtCell(arr[0][0], 4, product[value][0]);
                hot.setDataAtCell(arr[0][0], 2, product[value][1]);
                var dropdownOptions = product_exp[value];
                hot.setCellMeta(arr[0][0], 1, "source", dropdownOptions);   
                if(dropdownOptions){

                    hot.setDataAtCell(arr[0][0], 1, dropdownOptions[0]);
                }
            }
            // for(var i=0;i<ac.length;i++) {
            //     if(ac[i].name == value) {
            //         // container.handsontable("setDataAtCell", arr[0][0], 1, ac[i].price);
            //         // container.handsontable("setDataAtCell", arr[0][0], 2, ac[i].abbrev);
            //         return false;
            //     }
            // }
        }
    }


});


 $('#depositform').on('submit', function(e) {

        e.preventDefault(); // prevent native submit
        //('input[name="data"]').val();
        $(this).ajaxSubmit({
            type: 'POST',
            dataType: 'json',
            target: '#echoForm',
            data:{data:hot.getData()},
            success: function(responseText, statusText, xhr, $form) {
                  if (responseText.status == '1') {
                        window.location.replace('<?=base_url() ?>inventory');
                    } else {
                        $('.validation-form').empty();
                        $('.validation-form').append('<div class="alert alert-danger alert-dismissible">' +
                            responseText.message + '</div>');
                    }

                // datatable.columns.adjust().draw(); // Redraw the DataTable
            }

        });


    });
});

</script>