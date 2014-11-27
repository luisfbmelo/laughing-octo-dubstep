<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "groups".
 *
 * @property integer $id_group
 * @property string $groupType
 *
 * @property User[] $users
 */
class Groups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_group', 'groupType','type'], 'required'],
            [['type'],'integer'],
            [['groupType'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_group' => 'Permissão',
            'groupType' => 'Group Type',
            'type' => 'Id Type'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['group_id' => 'id_group']);
    }

    /**
     * Returns all groups
     * @return [array] [groups data]
     */
    public function getAllGroups(){
        return $this->find()->asArray()->orderBy('type ASC')->all();  
    }
}
