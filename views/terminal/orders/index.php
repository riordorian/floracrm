<?
use yii\widgets\Breadcrumbs;

$this->title = 'Все товары';
$this->params['breadcrumbs'][] = $this->title;

?><div class="terminal__orders-wrap container-fluid">
	<div class="row">
		<div class="terminal__goods col-md-8 col-sm-8 col-xs-12 space-15">
			<div class="row">
				<form class="col-md-12">
					<div class="input-group m-b">
						<input type="text" placeholder="Введите название товара" class="form-control input-lg js-find-goods">
						<span class="input-group-addon"><i class="fa fa-search"></i></span>
					</div>
				</form>


				<div class="col-md-12 m-b-lg"><?
					echo Breadcrumbs::widget([
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
					]);
				?></div>

				<div class="terminal__goods-box js-goods-wrap"><?
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
	
							if( $i % 4 == 0 ){
								?><div class="clearfix"></div> <?
							}
						}
					}
				?></div>
			</div>
		</div>

		<div class="terminal__cart col-md-4 col-sm-4 col-xs-12 js-cart">
			<div class="input-group m-b-md">
				<input type="text" name="CLIENT" class="js-autocomplete-user form-control" placeholder="9998887755 или ФИО">
				<span class="input-group-btn">
					<a href="/terminal/client-add/" class="btn btn-primary js-ajax-link" data-open-type="popup">+</a>
				</span>
			</div>

			<form action="/terminal/orders/sale/">
				<div class="terminal__cart-goods js-terminal__cart-goods hidden m-b-md">
					<h3>Товары</h3>
				</div>
	
				<h3>Флорист</h3>
				<select class="js-widget chosen" name="OPERATORS[]" multiple data-placeholder="Выберите флориста"><?
					foreach($arOperators as $arOperator){
						?><option value="<?=$arOperator['id']?>" <?=$arOperator['id'] == Yii::$app->user->id ? 'selected' : ''?>><?=$arOperator['username']?></option><?
					}
				?></select>
				
				<div class="js-cart-good-template m-b-xs row hidden cart-good js-cart-good">
					<div class="col-md-2 col-sm-3 col-xs-2">
						<img src="" class="img-responsive">
					</div>
					<div class="col-md-5 col-sm-3 col-xs-7">
						<p>#NAME#</p>
						<p>#PRICE# <i class="fa fa-rub"></i></p>
					</div>
					<div class="col-md-3 col-sm-4 col-xs-2">
						<input type="text" class="form-control" value="1">
	
					</div>
					<div class="col-md-2 js-remove-good text-right">
						<i class="fa fa-close"></i>
					</div>
				</div>
	
				<div class="terminal__order-info">
					
					<div class="prices col-md-12">
						<p>
							<span>Подытог</span>
							<span class="pull-right"><span>0</span> <i class="fa fa-rub"></i></span>
							<input type="hidden" class="js-sum" name="SUM" value="0">
						</p>
						<p>
							<span>Скидка</span>
							<span class="pull-right"><span>0</span> <i class="fa fa-rub"></i></span>
							<input type="hidden" class="js-discount" name="DISCOUNT" value="0">
						</p>
						<p>
							<span>Баллы</span>
							<span class="pull-right"><span>0</span> </span>
							<input type="hidden" class="js-bonus-limit" name="BONUS" value="0">
						</p>
						<p>
							<span>Баллов за покупку</span>
							<span class="pull-right"><span>0</span> </span>
							<input type="hidden" class="js-bonus" name="BONUS" value="0">
						</p>
						<p>
							<span>Предоплата</span>
							<span class="pull-right"><span>0</span> <i class="fa fa-rub"></i></span>
							<input type="hidden" class="js-prepayment" name="PREPAYMENT" value="0">
						</p>

						<input type="hidden" name="CLIENT_ID" class="js-client-id-field">
					</div>
					<div class="clearfix"></div>
					<div class="total js-sale-link disabled" data-open-type="popup"">
						<div class="col-md-6"><b>ОПЛАТА</b></div>
						<div class="col-md-6 text-right">
							<b>
								<span>0</span> <i class="fa fa-rub"></i>
							</b>
							<input type="hidden" class="js-final-sum" name="TOTAL" value="">
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</form>
		</div>

		<div class="clearfix"></div>
	</div>
</div>