<?php

namespace frontend\models\query;

/**
 * This is the ActiveQuery class for [[ChatMessage]].
 *
 * @see ChatMessage
 */
class ChatMessageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ChatMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ChatMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
