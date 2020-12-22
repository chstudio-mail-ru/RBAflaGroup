<?php

namespace app\controllers;

use app\models\Authors;
use app\models\MagazinesAuthors;
use Yii;
use app\models\Magazines;
use app\models\MagazinesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * MagazinesController implements the CRUD actions for Magazines model.
 */
class MagazinesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Magazines models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MagazinesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Magazines model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Magazines model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Magazines();
        $authorsAR = Authors::getAll();
        $authors = [];
        foreach ($authorsAR as $author) {
            $authors[$author->id] = $author->surname.' '.$author->name;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(Yii::$app->request->isPost) {
                $model->image = UploadedFile::getInstance($model, 'image');
                $model->upload();
                foreach ($model->authors as $authorId) {
                    MagazinesAuthors::addRelation($model->id, $authorId);
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'authors' => $authors,
        ]);
    }

    /**
     * Updates an existing Magazines model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $authorsAR = Authors::getAll();
        $authors = [];
        foreach ($authorsAR as $author) {
            $authors[$author->id] = $author->surname.' '.$author->name;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->image = UploadedFile::getInstance($model, 'image');
            $model->upload();
            MagazinesAuthors::deleteMagazineRelations($id);
            foreach ($model->authors as $authorId) {
                MagazinesAuthors::addRelation($id, $authorId);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'authors' => $authors,
        ]);
    }

    /**
     * Deletes an existing Magazines model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id)
    {
        if ($this->findModel($id)->delete()) {
            MagazinesAuthors::deleteMagazineRelations($id);
            if (file_exists('uploads/'.md5($id).'.jpg')) {
                unlink('uploads/'.md5($id).'.jpg');
            } elseif (file_exists('uploads/'.md5($id).'.png')) {
                unlink('uploads/'.md5($id).'.png');
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Magazines model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Magazines the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Magazines
    {
        if (($model = Magazines::findOne($id)) !== null) {
            if ($model->date_add != '0000-00-00 00:00:00') {
                $model->date_add = date('Y-m-d', strtotime($model->date_add));
            } else {
                $model->date_add = '';
            }
            if (file_exists('uploads/'.md5($id).'.jpg')) {
                $model->image = '/uploads/'.md5($id).'.jpg';
            } elseif (file_exists('uploads/'.md5($id).'.png')) {
                $model->image = '/uploads/'.md5($id).'.png';
            }
            $relationsAuthors = MagazinesAuthors::findByMagazineId($id);
            foreach ($relationsAuthors as $relation) {
                $model->authors[] = $relation->author_id;
            }

            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
