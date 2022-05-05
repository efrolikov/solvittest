<?php

namespace app\controllers;

use app\models\Album;
use app\models\AlbumSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AlbumController implements the CRUD actions for Album model.
 */
class AlbumController extends Controller
{

    /**
     * Lists all Album models.
     *
     * @return string
     */
    public function actionIndex()
    {
		$albums = new Album;
		$models = $albums->find()->all();
		$res = [];
		foreach($models as $model) {
			$res[] = $model->data;
		}
		return json_encode($res);
    }

    /**
     * Displays a single Album model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		if ($model)
			return $model->jsonDataFull;
		else return json_encode([]);
    }


    /**
     * Finds the Album model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Album the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Album::findOne(['id' => $id])) !== null) {
            return $model;
        }
		return null;
    }
}
