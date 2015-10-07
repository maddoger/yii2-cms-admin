<?php

/*
 In the configuration view we need:
    - $model with data and validation rules
    - $form ActiveForm object
 */

/** @var $this yii\web\View */
/** @var $model \yii\base\Model */
/** @var $form \yii\widgets\ActiveForm */

echo $form->field($model, 'logoText')
    ->label(Yii::t('maddoger/admin', 'Logo text'))
    ->hint(Yii::t('maddoger/admin', 'This text will be displayed in place of the logo of the admin panel.'))
    ->textInput();

echo $form->field($model, 'logoImageUrl')
    ->label(Yii::t('maddoger/admin', 'Logo image url'))
    ->hint(Yii::t('maddoger/admin', '200x50. This image will be displayed in place of the logo of the admin panel.'))
    ->textInput();

echo $form->field($model, 'sortNumber')
    ->label(Yii::t('maddoger/admin', 'Sort number'))
    ->hint(Yii::t('maddoger/admin', 'The lower the number, the higher the menu item.'))
    ->textInput();

