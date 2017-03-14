<div class="col-xs-12">
	<div class="box" >
		<div class="box-header">
			ข้อมูลคนไข้
		</div>
		<div class="box-body" >
			<div class="row">
				<div class="col-xs-3">
					ชื่อ นามสกุล
				</div>
				<div class="col-xs-7">
					<?= $name_thai."  ".$surname_thai ?>   
				</div>
			</div>
			<div class="row">
				<div class="col-xs-3">
					เบอร์ติดต่อ
				</div>
				<div class="col-xs-7">
					<?= $phone_no ?>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-3">
				</div>
				<div class="col-xs-7">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-3">
				</div>
				<div class="col-xs-7">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-3">
				</div>
				<div class="col-xs-7">
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-xs-3">
					<a href="<?= base_url() ?>lab/create/<?=$client_id ?>" class="btn btn-success" > งาน lab </a>
				
					<a href="<?= base_url() ?>client/edit/<?=$client_id ?>" class="btn btn-primary " > แก้ไขข้อมูลคนไข้ </a>
				</div>
			</div>

		</div>

	</div>


</div>