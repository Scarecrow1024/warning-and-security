<?php
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
?>
<?php $form=ActiveForm::begin([
        'method' => 'post',
    ]);?>
<div class="from-group">
	<?php print_r($data)?>
    <?php foreach($data as $k=>$v){?>
    <div class="checkbox">
    <?php echo $v['name']?>
        <?php foreach($v as $kk=>$vv){?>
        <label>
          <input type="checkbox"><?php print_r($vv)?> 
        </label>
        <?php }?>
    </div>
    <?php }?>
</div>
<?php ActiveForm::end();?>