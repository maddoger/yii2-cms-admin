<?php

/**
 * @var $this yii\web\View
 * @var string $query
 * @var \maddoger\admin\widgets\SearchForm $widget
 */
use maddoger\admin\assets\AutocompleteAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

$actionUrl = Url::to($widget->actionUrl);
echo Html::beginForm($actionUrl, 'get', $widget->options);

$params = [
    'appendTo' => '#'.$widget->options['id'],
    'minChars' => 2,
    'serviceUrl' => "{$actionUrl}",
    'dataType' => 'json',
    'paramName' => "{$widget->queryParam}",
    'triggerSelectOnValidInput' => false,
    'autoSelectFirst' => false,
    'deferRequestBy' => 100,
    'onSelect' => new JsExpression('function (suggestion) {
      window.location = suggestion.data;
  }'),
    'transformResult' => new JsExpression('function(response) {
        return {
          suggestions: $.map(response, function(dataItem) {
              return { value: dataItem.label, data: dataItem.url };
                })
            };
        }'),
];
$jsonParams = Json::encode(ArrayHelper::merge($params, $widget->clientOptions));

AutocompleteAsset::register($this);
$this->registerJs(
    <<<JS
        jQuery('#query-field-{$widget->options['id']}').autocomplete({$jsonParams});
JS
);

?>
<div class="input-group">
    <?php echo Html::textInput($widget->queryParam, $query, [
        'id' => 'query-field-' . $widget->options['id'],
        'class' => 'form-control',
        'placeholder' => Yii::t('maddoger/admin', 'Search...'),
        'autocomplete' => 'off',
    ]) ?>
    <span class="input-group-btn">
        <button type="submit" id="search-btn" class="btn btn-flat"><i
                class="fa fa-search"></i></button>
        </span>
</div>
<?= Html::endForm(); ?>
<!-- /.search form -->