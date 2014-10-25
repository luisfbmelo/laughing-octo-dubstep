<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "repair".
 *
 * @property integer $id_repair
 * @property integer $type_id
 * @property integer $client_id
 * @property integer $inve_id
 * @property string $status
 * @property integer $user_id
 * @property string $repair_desc
 * @property string $date_entry
 * @property string $date_close
 * @property integer $store_id
 * @property integer $priority
 * @property string $budget
 * @property string $maxBudget
 * @property string $total
 *
 * @property Client $client
 * @property Inventory $inve
 * @property RepairType $type
 * @property Stores $store
 * @property Users $user
 * @property RepairAccessory[] $repairAccessories
 * @property Accessories[] $accessories
 * @property RepairParts[] $repairParts
 * @property Parts[] $parts
 */
class Repair extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repair';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'client_id', 'inve_id', 'status', 'user_id', 'repair_desc', 'date_entry', 'store_id', 'priority'], 'required'],
            [['type_id', 'client_id', 'inve_id', 'user_id', 'store_id', 'priority'], 'integer'],
            [['repair_desc'], 'string'],
            [['date_entry', 'date_close'], 'safe'],
            [['budget', 'maxBudget', 'total'], 'number'],
            [['status'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_repair' => 'Id Repair',
            'type_id' => 'Type ID',
            'client_id' => 'Client ID',
            'inve_id' => 'Inve ID',
            'status' => 'Status',
            'user_id' => 'User ID',
            'repair_desc' => 'Repair Desc',
            'date_entry' => 'Date Entry',
            'date_close' => 'Date Close',
            'store_id' => 'Store ID',
            'priority' => 'Priority',
            'budget' => 'Budget',
            'maxBudget' => 'Max Budget',
            'total' => 'Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id_client' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInve()
    {
        return $this->hasOne(Inventory::className(), ['id_inve' => 'inve_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(RepairType::className(), ['id_type' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Stores::className(), ['id_store' => 'store_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id_users' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepairAccessories()
    {
        return $this->hasMany(RepairAccessory::className(), ['repair_id' => 'id_repair']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessories()
    {
        return $this->hasMany(Accessories::className(), ['id_accessories' => 'accessory_id'])->viaTable('repair_accessory', ['repair_id' => 'id_repair']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepairParts()
    {
        return $this->hasMany(RepairParts::className(), ['repair_id' => 'id_repair']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParts()
    {
        return $this->hasMany(Parts::className(), ['id_part' => 'part_id'])->viaTable('repair_parts', ['repair_id' => 'id_repair']);
    }
}
