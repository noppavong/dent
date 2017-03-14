    <div class="form-group">
        <label class="control-label col-sm-3" for="namethai">สถานะ</label>
        <div class="col-sm-7">
            <div class="radio col-sm-3">
                <label>
                    <input type="radio"  name="status"  value="P"  <?php  echo set_value('status', (isset($status))?$status:"") == "P" ? "checked" : ""; ?>>
                    คนไข้
                </label>
            </div>
            <div class="radio col-sm-6">
                <label>
                    <input type="radio" name="status"  value="I"  <?php  echo set_value('status', (isset($status))?$status:"") == "I" ? "checked" : ""; ?>>
                    ไม่เคลื่อนไหว
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="namethai">ชื่อ</label>
        <div class="col-sm-7">
            <input type="text" id="name_thai" name="name_thai" class="form-control" placeholder="" value="<?php echo set_value('name_thai',(isset($name_thai))?$name_thai:" "); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="surnamethai">นามสกุล</label>
        <div class="col-sm-7">
            <input type="text" id="surname_thai" name="surname_thai" class="form-control" value="<?=set_value('surname_thai',(isset($surname_thai))?$surname_thai:" "); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="surnamethai">ชื่อเล่น</label>
        <div class="col-sm-7">
            <input type="text" id="nickname" name="nickname" class="form-control" value="<?=set_value('nickname',(isset($nickname))?$nickname:" "); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="phone" class="control-label col-sm-3">เบอร์ติดต่อ</label>
        <div class="col-sm-7">
            <input type="text" name="phone_no" class="form-control" value="<?=set_value('phone_no',(isset($phone_no))?$phone_no:" "); ?>">

        </div>
    </div>
    <div class="form-group ">
        <label for="title" class="control-label col-sm-3">คำนำหน้าชื่อ</label>
        <div class="col-sm-7">
            <select class="form-control select2" name="title">
              <?php foreach ($titles->result_array() as $row){ ?>
              <option value="<?= $row['title_id'] ?>"  <?php echo set_select('title', $row['title_id'], isset($title)?$row['title_id']==$title:$row['title_id']==""); ?>><?= $row['name']; ?></option>
              <?php } ?>
          </select>
      </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3" for="namethai">เพศ</label>
    <div class="col-sm-7">
        <div class="radio col-sm-3">
            <label>
                <input type="radio"  name="sex"  value="M"  <?php  echo set_value('sex', (isset($sex)?$sex:"")) == "M" ? "checked" : ""; ?>>
                ชาย
            </label>
        </div>
        <div class="radio col-sm-3">
            <label>
                <input type="radio" name="sex"  value="F"  <?php  echo set_value('sex',(isset($sex)?$sex:"")) == "F" ? "checked" : ""; ?>>
                หญิง
            </label>
        </div>
    </div>
</div>

<div class="form-group">

    <label for="phone" class="control-label col-sm-3">วันเกิด</label>
    <div class="col-sm-7">
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" name="birth_date" class="form-control pull-right" data-date-format="dd-mm-yyyy" 
            id="datepicker" 
            value="<?=set_value('birth_date',(isset($birth_date))?
            date('d-m-Y',strtotime(date('d-m-Y',strtotime($birth_date)).' +543 years')):""); ?>">
        </div>

    </div>
</div>
<div class="form-group">
    <label for="age" class="control-label col-sm-3"> อายุ </label>
    <div class="col-sm-7">
        <input type="text" id="age" name="age" class="form-control" value="<?=set_value('age',(isset($age))?$age:" "); ?>" />

    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3"> หมอประจำ </label>
    <div class="col-sm-7">

        <?= form_multiselect('doctor[]', $doctors, (isset($cli_doctors)?$cli_doctors:""),array('class'=>'form-control select2','style'=>'width:100%')); ?>

    </div>

</div>