<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url() ?>assets/js/script.js"></script>
<ul class="nav nav-pills">
    <li role="presentation"><a href="<?= base_url() ?>clients">ค้นหาคนไข้</a></li>
    <li role="presentation"><a href="<?= base_url() ?>client/create">เพิ่มคนไข้</a></li>
    <li role="presentation"><a href="<?= base_url() ?>client/delete">ลบคนไข้</a></li>
    <li role="presentation" class="active"><a href="<?= base_url() ?>client/edit">ข้อมูลคนไข้</a></li>
</ul>
<div class="col-xs-12">

    <script>
        jQuery(document).ready(function() {

            jQuery('#otherdoc').change(function() {
                if ($(this).is(':checked')) {

                    $('textarea[name="otherdoc"]').prop("disabled", false);
                } else {
                    $('textarea[name="otherdoc"]').prop("disabled", true);
                }
            });
            $("#collapse").hide();
            $(".toggle").click(function() {
                $(".toggle").parent().removeClass('active');
                $(this).parent().addClass('active');
                var id = $(this).data('target');
                $('.formtab').hide();
                $('#' + id).show();
            });

        });
    </script>

    <form id="formElem" role="form" action="<?php echo base_url() ?>client/save" method="post" class=" form-horizontal" novalidate>
        <?php if(isset($client_id)){?>
        <input type="hidden" name="client_id" value="<?= set_value('client_id',$client_id) ?>" />
        <?php }?>
        <!-- general form elements -->
        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">ข้อมูลคนไข้</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="col-md-2">
                    <a class="profilePicThumb">
                        <img class="profilePic img" alt="your profile photo" src="https://scontent.fbkk8-1.fna.fbcdn.net/v/t1.0-1/p160x160/14670876_10207965516080655_4798356644505161655_n.jpg?oh=aa9ceee1aa990d06fb8dea439b60b40b&amp;oe=5896B1B5">
                    </a>
                    <div class="fbTimelineProfilePicSelector _23fv">
                        <div class="_156n _23fw" data-ft="{&quot;tn&quot;:&quot;+B&quot;}"><i class="_1din _156q img sp_vSpiFuU7MD8 sx_b27ecf"></i><a class="_156p" href="#" ajaxify="/profile/picture/menu_dialog/?context_id=u_jsonp_2_5&amp;profile_id=1380170434" rel="dialog" role="button" tabindex="0">แก้รูปคนไข้</a></div>
                    </div>
                    <ul class="nav  nav-stacked">
                        <li role="presentation" class="active"><a class="toggle" data-target="normal" data-except="expand" href="#">ข้อมูลทั่วไป</a></li>
                        <li role="presentation"><a class="toggle" data-target="medical" data-except="normal" href="#">ข้อมูลเกี่ยวกับแพทย์</a></li>
                        <li role="presentation"><a class="toggle" data-target="expand" data-except="normal" href="#">ข้อมูลเพิ่มเติม</a></li>
                        <li role="presentation"><a class="toggle" data-target="lab" data-except="normal" href="#">ข้อมูลแล็บ</a></li>

                    </ul>
                </div>
                <div class="col-md-10">
                    <?php if (validation_errors()){ ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php } ?>
                    <div id="normal" class="formtab">
                        <?php $this->load->view('client/client_edit_general'); ?>

                    </div>
                    <div id="medical" style="display:none;" class="formtab">
                        <?php $this->load->view('client/client_edit_medical'); ?>
                    </div>
                    <div id="expand" style="display:none;" class="formtab">
                        <?php $this->load->view('client/client_edit_other'); ?>
                    </div>
                    <div id="lab" style="display:none;" class="formtab">
                        <?php $this->load->view('client/client_edit_lab'); ?>
                        
                    </div>
                   
                </div>
            </div>
            <br class="clear" />
            <button type="submit" class="btn btn-primary ">
   บันทึก
</button>
            <a href="<?=base_url() ?>clients/" class="btn btn-danger">
   ยกเลิก
</a>
        </div>
        <!-- /.box-body -->
        <div class="box">
    <div class="box-header">
                <h3 class="box-title">บันทึกการรักษา</h3>
    </div>
    <div class="box-body">
          <?php $this->load->view('client/client_edit_plan'); ?>
    </div>
</div>
</div>
<!-- /.box -->
</form>



<?php if(isset($client_id)) { ?>
<div class="modal fade modal-warning" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                ลบข้อมูล
            </div>
            <div class="modal-body">
                ยืนยันการลบ
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                <a class="btn btn-danger btn-ok">ตกลง</a>
            </div>
        </div>
    </div>
</div>

<?php } ?>
</div>
<style>
    .datepicker {
        z-index: 1151 !important;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        //   initPlanTable('t_parent','treatmentmasterTable');
        // $('#t_parent').on("select2:selecting", function(e) { 
        //    initPlanTable('t_parent','treatmentmasterTable');
        // });
        $('.percent').inputmask('Regex', { regex: "^[1-9][0-9]?$|^100$" });  

      
       
        $('#price').mask("##0.00", {
            reverse: true
        });
        
        

      

        $('.select2').select2();
        $('form').preventDoubleSubmission();
        //  $('#birth_date').datepicker({
        //      autoclose: true,
        //      format:'yyyy-mm-dd'
        //    });
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });




    });
    $('#datepicker2').datepicker({
        autoclose: true,
        dateFormat: 'dd-mm-yy',
    });
       $('.date2').datepicker({
        autoclose: true,
        dateFormat: 'dd-mm-yy',
    });
    $('#datepicker').datepicker({

            autoclose: true,
            dateFormat: 'dd-mm-yy',
        }).change(dateChanged)
        .on('changeDate', dateChanged);

    function dateChanged(ev) {
        //  $(this).datepicker('hide');
        if ($('#datepicker').val()) {
            var from = $('#datepicker').val().split('-');
            console.log(from);
            var birthday = new Date(from[2], from[1], from[0]);
            var age = _calculateAge(birthday);
            $('#age').val(age);
        }
    }

    function _calculateAge(birthday) { // birthday is a date
        var ageDifMs = Date.now() - birthday.getTime();
        var ageDate = new Date(ageDifMs); // miliseconds from epoch
        return Math.abs(ageDate.getUTCFullYear() - 1970);
    }

</script>