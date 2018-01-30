<div class="col-md-3 col-sm-4 col-xs-6">
	<div class="ibox js-good-item" data-good-id="<?=$arGood['ID']?>">
		<div class="ibox-content product-box">

			<div class="product-imitation">
				<img class="product-image" src="<?=$arGood['IMAGE']?>" >
			</div>
			<div class="product-desc">
										<span class="product-price">
											<?=$arGood['RETAIL_PRICE']?> <i class="fa fa-rub"></i>
										</span>
				<small class="text-muted"><?=$arGood['catalogSection']['NAME']?></small>
				<a href="#" class="product-name"> <?=$arGood['NAME']?></a>



				<div class="text-righ">
					<span class="link">Остаток: <span class="js-good-amount"><?=$arGood['AMOUNT']?></span></span>
				</div>
			</div>
		</div>
	</div>
</div>