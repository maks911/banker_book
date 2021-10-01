<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * ContactForm is the model behind the contact form.
 */
class Kitchen extends ActiveRecord
{

    public static function tableName() { return 'kitchens'; }


    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [

        ];
    }

    public function add($email)
    {

    }

    public function get($email)
    {

    }

    /**
     * @param $searchParam
     * @return array
     */
    public function search($searchParam): array
    {
        return [];
    }
}
