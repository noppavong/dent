<div class="form-group">
    <label class="control-label col-sm-3">ที่อยู่</label>
    <div class="col-sm-7">
        <textarea class="form-control" name="address" rows="5" placeholder="ที่อยู่ ..."><?=set_value('address',(isset($address)?$address:"")); ?></textarea>
    </div>
</div>

<div class="form-group">
    <label for="email" class="control-label col-sm-3">email</label>
    <div class="col-sm-7">

        <div class="input-group">

            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

            <input type="email" name="email" class="form-control" placeholder="Email" value="<?=set_value('email',(isset($email)?$email:" ")); ?>">
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-3">อาชีพ</label>
    <div class="col-sm-7">

        <input type="text" id="occupation" name="occupation" class="form-control" value="<?=set_value('occupation',(isset($occupation)?$occupation:" ")); ?>">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3">ที่ทำงาน</label>
    <div class="col-sm-7">
        <textarea class="form-control" name="work_address" rows="5" placeholder="ที่อยู่ ..."> <?=set_value('work_address',(isset($work_address)?$work_address:"")); ?></textarea>
    </div>
</div>

<div class="form-group">
    <label for="ำ" class="control-label col-sm-3">เลขประจำตัวพนักงาน</label>
    <div class="col-sm-7">

        <input type="text" name="employee_no" class="form-control" placeholder="เลขประจำตัวพนักงาน" value="<?=set_value('employee_no',(isset($employee_no)?$employee_no:" ")); ?>">
    </div>
</div>
<div class="form-group">
    <label for="discount_per" class="control-label col-sm-3">ส่วนลด</label>
    <div class="col-sm-7">

          <select class="form-control select2" name="discount_per" style="width: 100%" >
             <?php for($i = 0; $i <=100; $i++){ ?>
             <option  value="<?= $i; ?>" <?php echo set_select('discount_per', $i, isset($discount_per)?$i==$discount_per:$i==""); ?>><?= $i ?>%</option>
             <?php } ?>
           </select>
    </div>
</div>
<div class="form-group ">
    <label for="lab" class="control-label col-sm-3">บริษัท contact</label>
    <div class="col-sm-7">

       <select class="form-control select2" name="company"  style="width: 100%" >
            <?php foreach ($companies->result_array() as $row){ ?>
            <option value="<?= $row['company_id'] ?>" <?php echo set_select('company', $row['company_id'], isset($company)?$row['company_id']==$company:$row['company_id']==""); ?> ><?= $row['name']; ?></option>
            <?php } ?>
        </select>

    </div>
    <button type="button" data-toggle="modal" data-target="#companymodal" class="btn btn-primary">เพิ่ม</button>
    <button type="button" data-toggle="modal" data-target="#errorCompanymodal" class="btn btn-danger">ลบ</button>
</div>

<div id="companymodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เพิ่มข้อมูล (บริษัทติดต่อ)</h4>
            </div>
            <div class="modal-body">
                <form id="companyform" class="form-horizontal">
                    <div class="form-group ">
                        <label for="service" class="control-label col-sm-3">ชื่อ </label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="job_name" name="job_name" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary btn-save">บันทึก</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="errorCompanymodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ลบข้อมูล บริษัทติดต่อ</h4>
            </div>
            <div class="modal-body">
                กดยืนยันเพื่อลบข้อมูล
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary btn-delete">ยืนยัน</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Button trigger modal -->

<div class="modal modal-primary" id="additionalInfo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">เพิ่มเติม</h4>
            </div>
            <div class="modal-body">
                <div style="width:500px;margin: 0 auto;">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" onclick="clearForm();">ยกเลิก</button>
                <button type="button" class="btn btn-outline" data-dismiss="modal">ตกลง</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
