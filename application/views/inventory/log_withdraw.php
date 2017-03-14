<div class="col-xs-12" >
 <ul class="nav nav-pills">
    <li role="presentation"><a href="<?= base_url() ?>inventory">รายการวัสดุทันตกรรม</a></li>
    <li role="presentation" ><a href="<?= base_url() ?>inventory/deposit">นำเข้าสินค้า</a></li>
    <li role="presentation"   ><a href="<?= base_url() ?>inventory/withdraw">นำออกสินค้า</a></li>
    <li role="presentation"  ><a href="<?= base_url() ?>inventory/product" >สินค้า</a></li>
    <li role="presentation"><a href="<?= base_url() ?>inventory/category">ประเภทสินค้า</a></li>
    <li role="presentation"  class="active"  ><a href="<?= base_url() ?>inventory/log">ประวัติสินค้าเข้าออก</a></li>
</ul>

 <div class="box">

    <div class="box-header with-border">
    <ol class="breadcrumb">
        <li><a href="<?=base_url() ?>inventory/log" >กลับหน้าหลัก</a></li>
        <li class="active">รายการละเอียดนำเข้าออกสินค้า</li>
      </ol>
 	<div class="box-title">
 		รายการละเอียดนำเข้าออกสินค้า
    </div>
    </div>
 	<div class="box-body ">
         <table id="withdrawTable" class="table display" cellspacing="0" width="100%">
 			<thead>
 				<tr>
 					<th>รหัสสินค้า</th>
                    <th>ผู้เบิก</th>
 					<th>ชื่อสินค้า</th>
                    <th>วันหมดอายุ</th>
                    <th>จำนวน</th>
 				</tr>
 			</thead>
            <tbody>
            <?php foreach ($withdraws->result_array() as $row ) { ?>
              
                        <td><?= $row['code'] ?> </td>
                        <td><?= $row['withdrawer'] ?> </td>
                        <td><?= $row['name'] ?> </td>
                        <td><?= $row['expire_date'] ?> </td>
                        <td><?= $row['quantity'] ?> </td>
                   </tr>
           <?php  } ?>
            </tbody>
 		</table>
    </div>
</div>
 <script type="text/javascript">
     var withdrawTable = $('#withdrawTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });

     jQuery(document).ready(function(){
     $('.select2').select2();
    });
 </script>