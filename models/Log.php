<?php

namespace maddoger\admin\models;

use maddoger\core\models\Log as LogBase;
use Yii;

class Log extends LogBase
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('maddoger/admin', 'ID'),
            'level' => Yii::t('maddoger/admin', 'Level'),
            'category' => Yii::t('maddoger/admin', 'Category'),
            'log_time' => Yii::t('maddoger/admin', 'Log Time'),
            'prefix' => Yii::t('maddoger/admin', 'Prefix'),
            'message' => Yii::t('maddoger/admin', 'Message'),
        ];
    }
}