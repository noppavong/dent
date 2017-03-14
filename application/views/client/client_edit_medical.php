<div class="form-group">
    <label for="allergic" class="control-label col-sm-3">แพ้ยา</label>
    <div class="col-sm-7">
        <textarea class="form-control" name="allergic" rows="5" placeholder="แพ้ยา ..."><?=set_value('allergic',(isset($allergic)?$allergic:"")); ?></textarea>
    </div>
</div>

<div class="form-group">
    <label for="medication" class="control-label col-sm-3">โรคประจำตัว</label>
    <div class="col-sm-7">
        <textarea class="form-control" name="medication" rows="5" placeholder="โรคประจำตัว ..."><?=set_value('medication',(isset($medication)?$medication:"")); ?></textarea>
    </div>
</div>


<div class="form-group">
    <label class="control-label col-sm-3"> เอกสารที่ต้องการ</label>
    <div class="col-sm-7">
        <div class="checkbox">
            <label>
             <input type="checkbox"  name="medcert"  value="Y"  <?php  echo set_value('medcert', (isset($medcert)?$medcert:"")) == "Y" ? "checked" : ""; ?>>
             ใบรับรองแพทย์

         </label>
     </div>
     <div class="checkbox">
        <label>
           <input type="checkbox"  name="social"  value="Y"  <?php  echo set_value('social', (isset($social)?$social:"")) == "Y" ? "checked" : ""; ?>>
           ใบประกันสังคม

       </label>
   </div>
   <div class="checkbox">
    <label>
     <input type="checkbox"  id="otherdoc" <?php if(!empty($otherdoc)){ ?> checked <?php } ?> >
     อื่นๆ ระบุ

     </label>
     </div>
     <textarea class="form-control" name="otherdoc" rows="5" placeholder="เอกสารอื่นๆ ..." <?php if(empty($client_id)||empty($otherdoc)) { ?> disabled<?php } ?> ><?=set_value('otherdoc',(isset($otherdoc)?$otherdoc:"")); ?>

     </textarea>

 </div>

</div>

<div class="form-group">
    <label for="other" class="control-label col-sm-3"> อื่นๆ</label>
    <div class="col-sm-7">
        <textarea class="form-control" name="other" rows="5" placeholder="หมายเหตุ"><?=set_value('other',(isset($other)?$other:"")); ?></textarea>
    </div>
</div>