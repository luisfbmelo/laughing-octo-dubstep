<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property integer $id_client
 * @property string $cliName
 * @property string $cliAdress
 * @property integer $cliPostalCode
 * @property integer $cliPostalSuffix
 * @property integer $cliDoorNum
 * @property integer $cliCC
 * @property integer $cliNIF
 * @property integer $cliConFix
 * @property integer $cliConMov1
 * @property integer $cliConMov2
 * @property string $cliBirthday
 *
 * @property Repair[] $repairs
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cliName', 'cliAdress', 'cliPostalCode', 'cliPostalSuffix', 'cliDoorNum', 'cliConFix', 'cliConMov1'], 'required'],
            [['cliPostalCode', 'cliPostalSuffix', 'cliDoorNum', 'cliCC', 'cliNIF', 'cliConFix', 'cliConMov1', 'cliConMov2'], 'integer'],
            [['cliBirthday'], 'safe'],
            [['cliName', 'cliAdress'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_client' => 'Id Client',
            'cliName' => 'Nome de cliente',
            'cliAdress' => 'Morada',
            'cliPostalCode' => 'Código postal',
            'cliPostalSuffix' => 'CP - Sufixo',
            'cliDoorNum' => 'Nº Porta',
            'cliCC' => 'CC',
            'cliNIF' => 'NIF',
            'cliConFix' => 'Contato fixo',
            'cliConMov1' => 'Móvel 1',
            'cliConMov2' => 'Móvel 2',
            'cliBirthday' => 'Aniversário',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepairs()
    {
        return $this->hasMany(Repair::className(), ['client_id' => 'id_client']);
    }
}
