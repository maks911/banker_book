<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * ContactForm is the model behind the contact form.
 */
class Kitchen extends ActiveRecord
{

    public function rules()
    {
        return [
            [['kitchen_name'], 'required'],
        ];
    }

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

    public function getTags() {
        return $this->hasMany(Tag::class, ['kitchen_id' => 'id']);
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
