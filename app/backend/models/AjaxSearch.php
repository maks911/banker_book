<?php

namespace backend\models;

use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AjaxSearch extends Model
{
    public $name;
    public function rules()
    {
        return [
            [
                [
                    'text'
                ],
                'string'
            ]
        ];
    }
}
