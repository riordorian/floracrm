<div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 white-bg p-sm form-horizontal js-sale-form-wrap" data-sum="<?=$total?>">
	<h1 class="text-danger">
		Сумма заказа - <?=$total?> <i class="fa fa-rub"></i><?
		if( !empty($discount) ){
			?><small class="text-lt m-l-sm text-muted"><?=$sum?> <i class="fa fa-rub"></i></small><?
		}

	?></h1>

	<div class="form-group m-t-lg row">
		<label class="col-md-3 col-sm-2 col-xs-2 control-label text-left">Наличными</label>

		<div class="col-md-8 col-sm-4 col-xs-10 pull-right">
			<div class="input-group m-b">
				<input type="number" placeholder="Наличными" class="form-control input-lg js-cash-field">
				<span class="input-group-addon"><i class="fa fa-rub"></i></span>
			</div>
			<div class="js-change hidden">Сдача <span></span> <i class="fa fa-rub"></i></div>
		</div>
	</div>
	<div class="form-group m-t-lg row">
		<label class="col-md-3 col-sm-2 col-xs-2 control-label text-left">Карточкой</label>

		<div class="col-md-8 col-sm-4 col-xs-10 pull-right">
			<div class="input-group m-b">
				<input type="number" placeholder="Карточкой" class="form-control input-lg">
				<span class="input-group-addon"><i class="fa fa-rub"></i></span>
			</div>
		</div>
	</div>
	<div class="form-group m-t-lg row">
		<label class="col-md-3 col-sm-2 col-xs-2 control-label text-left">Сертификатом</label>

		<div class="col-md-8 col-sm-4 col-xs-10 pull-right">
			<div class="input-group m-b">
				<input type="number" placeholder="Сертификатом" name="SERT" class="form-control input-lg">
				<span class="input-group-addon"><i class="fa fa-rub"></i></span>
			</div>
		</div>
	</div><?
	if( !empty($bonus) ){
		?><div class="form-group m-t-lg row">
			<label class="col-md-3 col-sm-2 col-xs-2 control-label text-left">Бонус</label>

			<div class="col-md-8 col-sm-4 col-xs-10 pull-right">
				<div class="input-group m-b">
					<input type="number" max="" placeholder="Баллами" class="form-control input-lg">
					<span class="input-group-addon"><i class="fa fa-rub"></i></span>
				</div>
			</div>
		</div><?
	}
	?>
</div><?