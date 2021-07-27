<?php

namespace app\components\toggle;

use app\components\toggle\ToggleColumnAsset;
use yii\base\InvalidConfigException;
use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * EditableColumn adds X-Editable capabilities to a column
 */
class ToggleColumn extends DataColumn
{
	public $url;

	public $type = 'switch';
	public $trClass = 'active-published';
	public $trClassNot = 'not-active-published';

	public $onValue = 0;
	public $pjaxContainer = '';
	/**
	 * @inheritdoc
	 * @throws \yii\base\InvalidConfigException
	 */
	public function init()
	{
		if ($this->url === null) {
			throw new InvalidConfigException("'Url' property must be specified.");
		}

		parent::init();
		$rel = $this->attribute . '_toggle';

		$this->options['pjax'] = '0';
		$this->options['rel'] = $rel;

		$this->registerClientScript();
	}

	protected function renderDataCellContent($model, $key, $index)
	{
		$value = parent::renderDataCellContent($model, $key, $index);

		if($value == $this->onValue){
			$this->options['checked'] = true;
		}else{
			$this->options['checked'] = false;
		}
		$this->options['data-id'] = $key;

		if($this->type == 'flat'){
			$this->options['class'] = 'flat';
		}

		$url = (array)$this->url;
        $url['attribute'] = $this->attribute;
        $url['key'] = ($model instanceof Model)
            ? $model->getPrimaryKey()
            : $key;
        $this->options['url'] = Url::to($url);

		return Html::checkbox($this->attribute.'-'.$index, $value, $this->options);
	}

	/**
	 * Registers required script to the columns work
	 */
	protected function registerClientScript()
	{
		$view = $this->grid->getView();
		ToggleColumnAsset::register($view);

		$rel = $this->options['rel'];
		$selector = "input[rel=\"$rel\"]";
		$grid = "#{$this->grid->id}";

		if($this->pjaxContainer){
			$pjax = "$.pjax.reload({container:'#".$this->pjaxContainer."',timeout: 10000,});";
		}else{
			$pjax = "";
		}
		 $js[] = "jQuery('#w0').yiiGridView('setSelectionColumn', {\"name\":\"selection[]\",\"class\":null,\"multiple\":true,\"checkAll\":\"selection_all\"});";
		if($this->type == 'switch'){
			$js[] = "$.switcher('".$grid." ".$selector."');";
			$js[] = "$('".$grid." ".$selector."').change(function(){
						var active = $(this);
						var url = $(this).attr('url');
						$.ajax({
							type:'POST',
							dataType:'JSON',
							url:url,
							success:function(data){
								if(data.value == 1){
									active.closest('tr').addClass('".$this->trClass."')
									active.closest('tr').removeClass('".$this->trClassNot."')
								}else{
									active.closest('tr').addClass('".$this->trClassNot."')
									active.closest('tr').removeClass('".$this->trClass."')
								}
								active.val(data.value)
								".$pjax."
							}
						});
					  });";
		}else{
			$js[] = "$('".$grid." ".$selector."').on('ifChanged', function () {
			    var active = $(this);
				var url = $(this).attr('url');
				$.ajax({
					type:'POST',
					dataType:'JSON',
					url:url,
					success:function(data){
						if(data.value == 1){
							active.closest('tr').addClass('".$this->trClass."')
							active.closest('tr').removeClass('".$this->trClassNot."')
						}else{
							active.closest('tr').addClass('".$this->trClassNot."')
							active.closest('tr').removeClass('".$this->trClass."')
						}
						active.val(data.value)
						".$pjax."
					}
				});
			});";
		}
		$view->registerJs(implode("\n", $js));
	}
}
