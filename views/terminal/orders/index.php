<div class="terminal__orders-wrap container-fluid">
	<div class="row">
		<div class="terminal__goods col-md-8 col-sm-6 col-xs-12 space-15">
			<form action="">
				<div class="input-group m-b">
					<input type="text" placeholder="Введите название товара" class="form-control input-lg">
					<span class="input-group-addon"><i class="fa fa-search"></i></span>
				</div>
			</form><?
			if( empty($arCategories) ){
			    ?>Заведите категории товаров<?
			}
			else{
				$i = 0;
				foreach($arCategories as $arCategory){
					echo $this->render('_category.php', [
						'arCategory' => $arCategory
					]);
					$i++;

					if( $i % 3 == 0 ){
						?><div class="clearfix"></div> <?
					}
				}
			}
		?></div>

		<div class="terminal__cart col-md-4 col-sm-6 col-xs-12">
			<div class="">333</div>
		</div>
	</div>
</div>