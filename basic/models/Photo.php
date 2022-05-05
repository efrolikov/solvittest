<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "photo".
 *
 * @property int $id
 * @property int $album_id
 * @property string|null $title
 * @property string|null $url
 *
 * @property Album $album
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['album_id'], 'required'],
            [['album_id'], 'integer'],
            [['title'], 'string', 'max' => 1000],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => Album::className(), 'targetAttribute' => ['album_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'album_id' => 'Album ID',
            'title' => 'Title',
            'url' => 'Url',
        ];
    }

    /**
     * Gets query for [[Album]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(Album::className(), ['id' => 'album_id']);
    }
	
	public function getUrl()
	{
		$dir = Yii::$app->basePath . '/web/photo';
		$files = scandir($dir);
		unset($files[0]); unset($files[1]); // убираем . и ..
		srand($this->id);
		$photo_id = array_rand($files);
		if ($photo_id) {
			return Yii::$app->request->baseUrl.'/photo/'.$files[$photo_id];
		}
		
		return '';
	}

	public function getData() {
		return [
			'id'=>$this->id,
			'title'=>$this->title,
			'album'=>$this->album->title,
			'url'=>$this->url,
		];
	}
}
