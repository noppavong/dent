<style>
    table.first {
        border:1px solid #000000;
    }
    td,th {
        border: 2px solid #000000;
        background-color: #ffffee;
    }
    .lowercase {
        text-transform: lowercase;
    }
    .uppercase {
        text-transform: uppercase;
    }
    .capitalize {
        text-transform: capitalize;
    }
</style>
<table class="first" cellpadding="4">
<thead>
<tr >
  <th width="100" align="center"  style="font-size:12px"><b><?=$header1; ?></b></th>
  <th width="180" align="center" style="font-size:12px"><b><?=$header2; ?></b></th>
  <th width="100" align="center" style="font-size:12px"> <b><?=$header3; ?></b></th>
  <th width="100" align="center" style="font-size:12px"> <b><?=$header4; ?></b></th>
  <th width="120" align="center" style="font-size:12px"><b><?=$header5; ?></b></th>
  <th width="30" align="center" style="font-size:12px"></th>
  <th width="30" align="center" style="font-size:12px"></th>

  </tr>
</thead>
<tbody>
<?php foreach ($time_table as  $value) { ?>
    
 <tr >
  <td width="100" align="center" style="font-size:10px"><b><?=$value; ?></b></td>
  <td width="180"  style="font-size:10px"><b>
  <?php if(isset($job_table[$value])){?>
    <?=$job_table[$value]['name_thai'].'   '.$job_table[$value]['surname_thai'].'    '.$job_table[$value]['hn'] ?><?php }?>
      
    </b>

    </td>
  <td width="100" align="center" style="font-size:10px"><b>
   <?php if(isset($job_table[$value])){ ?><?= $job_table[$value]['phone_no'] ?><?php }?></b></td>
  <td width="100" align="center" style="font-size:10px"> <b> <?php if(isset($job_table[$value])){ ?><?= $job_table[$value]['job_name'] ?><?php }?></b></td>
  <td width="120" align="center" style="font-size:10px"><b><?php if(isset($job_table[$value])){ ?><?= $job_table[$value]['note'] ?><?php }?></b></td>
  <td width="30">
   <?php if(isset($job_table[$value]) and $job_table[$value]['confirm_first'] == 'Y'){ ?>
        X
    <?php } ?></td>
  <td width="30"><?php if(isset($job_table[$value])  and $job_table[$value]['confirm_second'] == 'Y'){ ?>
        X
    <?php } ?></td>
    
 </tr>
 <?php } ?>
 </tbody>
</table>