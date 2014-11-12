<?php

namespace common\models;

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
 * @property User $user
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
            [['type_id', 'client_id', 'inve_id', 'status_id', 'user_id', 'repair_desc', 'date_entry', 'store_id', 'priority'], 'required'],
            [['type_id', 'client_id', 'inve_id', 'user_id', 'store_id', 'priority','status_id'], 'integer'],
            [['repair_desc','obs'], 'string'],
            [['date_entry', 'date_close'], 'safe'],
            [['budget', 'maxBudget', 'total'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_repair' => 'Nº Reparação',
            'type_id' => 'Tipo de reparação',
            'client_id' => 'Cliente',
            'inve_id' => 'Inventário',
            'status_id' => 'Estado',
            'user_id' => 'Utilizador',
            'repair_desc' => 'Problema',
            'date_entry' => 'Entrada',
            'date_close' => 'Fecho',
            'store_id' => 'Loja',
            'priority' => 'Prioridade',
            'budget' => 'Orçamento',
            'maxBudget' => 'Orçamento máximo',
            'total' => 'Total',
            'obs' => 'Observações'
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
    public function getStatus()
    {
        return $this->hasOne(status::className(), ['id_status' => 'status_id']);
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
        return $this->hasOne(User::className(), ['id_users' => 'user_id']);
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

    /**
     * returns current repair status description
     * @return [array] [array with status data]
     */
    public function getStatusDesc(){
        return Status::find()->joinWith("repairs")->where(['status.id_status'=>$this->status_id])->asArray()->one();
    }

    /**
     * returns repair username that created the repair
     * @return [array] [user data]
     */
    public function getUserName(){
        return User::find()->joinWith("repairs")->where(['user.id_users'=>$this->user_id])->asArray()->one();
    }

    public function getStoreDesc(){
        return Stores::find()->joinWith("repairs")->where(['stores.id_store'=>$this->store_id])->asArray()->one();
    }

    /**
     * sets final variables to save, making them default and not from form
     * @param  [array] $elements [array of elements to set as default]
     */
    public function attributeToRepair($elements){
        $arrayKeys = array_keys($elements);

        for ($a=0;$a<sizeof($elements);$a++){
            $this->$arrayKeys[$a] = $elements[$arrayKeys[$a]];
        }

    }

    /**
     * creates new data that will be saved for the new repair
     * @param [array] $model    [model that will be take the data and will be saved]
     * @param [array] $elements [array of elements to save]
     * @return  [id] [id with the last inserted ID in order to save the repair]
     */
    public function addModelData($model,$elements){
        $arrayKeys = array_keys($elements);

        for ($a=0;$a<sizeof($elements);$a++){
            $model->$arrayKeys[$a] = $elements[$arrayKeys[$a]];
        }

        if ($model->save()){
            return Yii::$app->db->getLastInsertID();
        }else{
            return false;
        }
    }

    public function updateModelData($model,$elements){
        $arrayKeys = array_keys($elements);

        for ($a=0;$a<sizeof($elements);$a++){
            $model->$arrayKeys[$a] = $elements[$arrayKeys[$a]];
        }

        if ($model->update(false)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Converts month number to text
     * @param $month
     * @return string
     */
    public function monthConverter($month)
    {
        switch($month){
            case 1:
                return 'Janeiro';
            break;
            case 2:
                return 'Fevereiro';
                break;
            case 3:
                return 'Março';
                break;
            case 4:
                return 'Abril';
                break;
            case 5:
                return 'Maio';
                break;
            case 6:
                return 'Junho';
                break;
            case 7:
                return 'Julho';
                break;
            case 8:
                return 'Agosto';
                break;
            case 9:
                return 'Setembro';
                break;
            case 10:
                return 'Outubro';
                break;
            case 11:
                return 'Novembro';
                break;
            case 12:
                return 'Dezembro';
                break;
        }
    }

    /**
     * Arrange date to beauty present
     * @return [string] [arranged date]
     */
    public function getArrangedDate(){
        $date = strtotime($this->date_entry);
        return date('j', $date).' de '.$this->monthConverter(date('n', $date)).' de '.date('Y', $date).' pelas '.date('H:i:s',$date);
    }

    /**
     * Returns all accessories that a repair has
     * @param  [int] $id [repair identification]
     * @return [array]     [array of accessories ids]
     */
    public function getThisAccess($id){
        $accessories = RepairAccessory::find()->select('accessory_id')->where(['repair_id' => $id])->asArray()->all();

        $returnArray = array();
        foreach ($accessories as $row){
            $returnArray[] = $row['accessory_id'];
        }

        return $returnArray;

    }

    /**
     * Returns the description of other accessories
     * @param  [int] $id [repair identification]
     * @return [string]     [description of other accessories]
     */
    public function getThisOtherDesc($id){
        $desc = RepairAccessory::find()->select('repair_accessory.otherDesc')->innerJoin('accessories','repair_accessory.accessory_id = accessories.id_accessories')->where(['accessories.accessType' => 2,'repair_accessory.repair_id' => $id])->one();
 
        if (!$desc){
            $returnValue=false;
        }else{
            $returnValue = $desc->otherDesc;
        }

        return $returnValue;

    }

    public function getThisParts($id){
        $parts = RepairParts::find()->joinWith('part')->where(['repair_id' => $id])->all();

        $returnArray = array();
        $values = array();
        
        foreach ($parts as $i=>$row){

            $values['id_part'] = $row['part']['id_part'];
            $values['partCode'] = $row['part']['partCode'];
            $values['partDesc'] = $row['part']['partDesc'];
            $values['partQuant'] = $row['partQuant'];
            $values['partPrice'] = $row['part']['partPrice'];

            $returnArray[$i] = new parts();
            $returnArray[$i]->attributes = $values;
        }

        return $returnArray;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                //delete accessories
                $accessories = RepairAccessory::find()->where('repair_id = :id',['id'=>$this->id_repair])->all();
                foreach ($accessories as $accessory) {
                    $accessory->delete();
                } 

                //delete inventory
                Inventory::findOne($this->inve_id)->delete();

                $transaction->commit();
                return true;             
                
            } catch(Exception $e) {
                $transaction->rollback();
                echo $e->getMessage(); exit;
                return false;
            }

            
        } else {
            return false;
        }
    }
}