<?php
namespace app\models\form;

use backend\models\Kitchen;
use backend\models\Tag;
use Yii;
use yii\base\Model;

class KitchenForm extends Model
{
    private $_kitchen;
    private $_tags;

    public function rules()
    {
        return [
            [['Kitchen'], 'required'],
            [['Tags'], 'safe'],
        ];
    }


    /**
     * @param $kitchen
     */
    public function setKitchen($kitchen): void
    {
        if ($kitchen instanceof Kitchen) {
            $this->_kitchen = $kitchen;
        } else if (is_array($kitchen)) {
            $this->_kitchen->setAttributes($kitchen);
        }
    }

    /**
     * @return Kitchen
     */
    public function getKitchen(): Kitchen
    {
        return $this->_kitchen;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        if ($this->_tags === null) {
            $this->_tags = $this->kitchen->isNewRecord ? [] : $this->kitchen->tags;
        }
        return $this->_tags;
    }

    /**
     * @param Kitchen $modelKitchen
     * @param array $tags
     * @return bool
     * @throws \yii\db\Exception
     */
    public function saveKitchensWithTags(Kitchen $modelKitchen, array $tags): bool
    {
        if (!$this->validate()) {
            return false;
        }
        $transaction = Yii::$app->db->beginTransaction();
        if (!$modelKitchen->save()) {
            $transaction->rollBack();
            return false;
        }
        if (!$this->saveTags($tags)) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();
        return true;
    }

    /**
     * @param array $tags
     * @return bool
     */
    public function saveTags(array $tags): bool
    {
        $existTags = $this->tags;
        foreach ($existTags as $tag) {
            $tag->delete();
        }
        foreach ($tags as $tag) {
            $modelTag = new Tag();
            $modelTag->value = $tag;
            $modelTag->kitchen_id = $this->getKitchen()->id;
            $modelTag->save();
        }
        return true;
    }
}