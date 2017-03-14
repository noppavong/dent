<div class="col-xs-12" >
 <ul class="nav nav-pills">
    <li role="presentation" class="active"  ><a href="<?= base_url() ?>inventory">รายการวัสดุทันตกรรม</a></li>
    <li role="presentation" ><a href="<?= base_url() ?>inventory/deposit">นำเข้าสินค้า</a></li>
    <li role="presentation"   ><a href="<?= base_url() ?>inventory/withdraw">นำออกสินค้า</a></li>
    <li role="presentation"  ><a href="<?= base_url() ?>inventory/product" >สินค้า</a></li>
    <li role="presentation"><a href="<?= base_url() ?>inventory/category">ประเภทสินค้า</a></li>
    <li role="presentation" ><a href="<?= base_url() ?>inventory/log">ประวัติสินค้าเข้าออก</a></li>
</ul>

 <div class="box">
 <?php if(sizeof($exp_prod->result_array()) > 0){ ?>
        <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> มีสินค้าใกล้จะหมดอายุ</h4>
               <?php foreach ($exp_prod->result_array() as $row) { ?>
                      รหัส  <?= $row['code'] ?> :  ชื่อ <?= $row['name'] ?> : จำนวน <?= $row['inventory'] ?>
                      <br/>
               <?php  }  ?>
     </div>


 <?php } ?>
    <div class="box-header with-border">
 	<div class="box-title">
 		รายการวัสดุทันตกรรม
    </div>
    </div>
 	<div class="box-body ">
        <form id="formElem" name="formElem" action="<?= base_url() ?>inventory/" method="post">
            
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-2">
                        <label for="category">หมวดหมู่</label>
                    </div>
                   <div class="col-sm-4">
                         <select class="form-control select2" name="category_id"   >
                            <option value=""> ทั้งหมด </option>
                        <?php foreach ($categorys->result_array() as $row){ ?>
                        <option value="<?= $row['category_id'] ?>" <?php echo set_select('category_id', $row['category_id'], isset($category_id)?$row['category_id']==$category_id:$row['category_id']==""); ?>><?= $row['name']; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา </button>
        </form>
 		 <table id="inventoryTable" class="table display" cellspacing="0" width="100%">
 			<thead>
 				<tr>
 					<th>รหัส</th>
 					<th>รายการ</th>
                    <th>หมวดหมู่</th>
                    <th>วันหมดอายุ</th>
                    <th>ประเภท</th>
                    <th>จำนวน</th>
 				</tr>
 			</thead>
            <tbody>
            <?php foreach ($categorys->result_array() as $row ) { ?>
                <?php if(!empty($products[$row['category_id']])) {  ?>
                <?php foreach ($products[$row['category_id']] as $row2) { ?>
                   <tr  class="products" >
                        <td><?= $row2['code'] ?> </td>
                        <td><?= $row2['name'] ?> </td>
                        <td><?= $map_category[$row['category_id']]?> </td>
                        <td><?= $row2['expire_date'] ?> </td>
                        <td><?= $parents[$row['parent_id']] ?> </td>
                        <td><?= $row2['inventory'] ?> </td>
                   </tr>
                <?php } ?>
                <?php } ?>
           <?php  } ?>
                
            </tbody>
 		</table>
        <form id="formElem" name="formElem" action="<?= base_url() ?>inventory/" method="post">
           
            <a href="<?= base_url() ?>inventory/restock" class="btn btn-primary">แก้ไข stock สินค้า</a> 

        </form>
 	</div>

 </div>
 </div>
 <script type="text/javascript">
     var productTable = $('#inventoryTable').DataTable({
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