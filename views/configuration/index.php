<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $this yii\web\View */
/** @var $configuration array */

$this->title = Yii::t('maddoger/admin', 'Configuration');
$this->params['breadcrumbs'][] = $this->title;
$form = ActiveForm::begin();

?>
<div class="tabs-left">
    <ul class="nav nav-tabs" role="tablist">
        <?php
        $active = null;
        foreach ($configuration as $key=>$info) {
            if ($active === null) {
                $active = $key;
            }
            echo '<li role="presentation" class="'.($key===$active ? 'active' : '').'">',
            Html::a($info['moduleName'], '#tab-'.$info['moduleId'], [
                'aria-controls' => '#tab-'.$info['moduleId'],
                'role' => 'tab',
                'data-toggle' => 'tab',
            ]),'</li>';
        }
        ?>
    </ul>
    <div class="tab-content">
        <?php
        //Some tests
        foreach ($configuration as $key=>$info) {

            echo
            Html::tag('div',
                '<h3>'. Html::encode($info['moduleName']).'</h3>'.
                $this->renderFile($info['view'], ['model' => $info['model'], 'form' => $form])
                .'<p>'.Html::submitButton(Yii::t('maddoger/admin', 'Save'), ['class' => 'btn btn-primary']).'</p>'
                ,
                [
                    'role' => 'tabpanel',
                    'class' => 'tab-pane fade '.($key==$active ? 'in active' : ''),
                    'id' => 'tab-'.$info['moduleId'],
                ]
            );
        }
        ?>
    </div>
</div>
<?php

ActiveForm::end();
