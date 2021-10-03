<?php

namespace backend\models;

use yii\db\ActiveRecord;

class Tag extends ActiveRecord
{

    public static function tableName()
    {
        return 'tags';
    }

    public function getKitchen() {
        return $this->hasOne(Kitchen::class, ['id' => 'kitchen_id']);
    }
}