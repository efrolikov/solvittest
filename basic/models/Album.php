<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "album".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $title
 *
 * @property Photo[] $photos
 * @property User $user
 */
class Album extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'album';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Photos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['album_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

	public function getData() {
		return [
			'id'=>$this->id,
			'title'=>$this->title,
			'user'=>$this->user->first_name.' '.$this->user->last_name,
		];
	}

	public function getJsonData() {
		return json_encode($this->data);
	}

	public function getDataFull() {
		$photos_data = [];
		foreach($this->photos as $photo) {
			$photos_data[] = $photo->data;
		}
		return [
			'id'=>$this->id,
			'title'=>$this->title,
			'user'=>$this->user->first_name.' '.$this->user->last_name,
			'photos'=>$photos_data
		];
	}

	public function getJsonDataFull() {
		return json_encode($this->dataFull);
	}
	
}
