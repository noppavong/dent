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
 	<div class="box-title">
 		ประวัติรายการนำเข้าสินค้า
    </div>
    </div>
 	<div class="box-body ">
  
 		 <table id="depositTable" class="table display" cellspacing="0" width="100%">
 			<thead>
 				<tr>
 					<th>วันที่</th>
 					<th></th>
 				</tr>
 			</thead>
            <tbody>
            <?php foreach ($deposits->result_array() as $row ) { ?>
              
                        <td><?= $row['deposit_date'] ?> </td>
                        <td><a  class="btn btn-info" href="<?=base_url() ?>inventory/log_deposit/<?= $row['deposit_date'] ?>" >ดูรายละเอียด</a></td>
                   </tr>
           <?php  } ?>
                
            </tbody>
 		</table>
    </div>
</div>
 <div class="box">

    <div class="box-header with-border">
    <div class="box-title">
        ประวัติรายการนำออกสินค้า
    </div>
    </div>
    <div class="box-body ">
        <table id="withdrawTable" class="table display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($withdraws->result_array() as $row ) { ?>
              
                        <td><?= $row['withdraw_date'] ?> </td>
                        <td><a  class="btn btn-info" href="<?=base_url() ?>inventory/log_withdraw/<?= $row['withdraw_date'] ?>" >ดูรายละเอียด</a></td>
                   </tr>
           <?php  } ?>
                
            </tbody>
        </table>
 	</div>

 </div>



 </div>
 <script type="text/javascript">
     var depositTable = $('#depositTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });

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