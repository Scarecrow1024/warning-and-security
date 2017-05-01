<?php

namespace app\controllers;

use Yii;
use app\models\Scan;
use app\models\ScanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Group;

/**
 * ScanController implements the CRUD actions for Scan model.
 */
class ScanController extends BaseController
{
    /**
     * @inheritdoc
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
     * Lists all Scan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScanSearch();
        if(!isset($_GET['page'])){
            $_GET['page'] = Yii::$app->request->queryParams['page'] = 1;
        }
        if(!isset($_GET['per-page'])){
            $_GET['per-page'] = Yii::$app->request->queryParams['per-page'] = 15;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Scan();
        $group = Group::find()->asArray()->all();
        $gs = [];
        foreach($group as $k=>$v){
            $gs[$v['id']] = $v['group_name'];
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'group' => $gs
        ]);
    }

    public function actionScan_dir()
    {
        $searchModel = new ScanSearch();
        if(!isset($_GET['page'])){
            $_GET['page'] = Yii::$app->request->queryParams['page'] = 1;
        }
        if(!isset($_GET['per-page'])){
            $_GET['per-page'] = Yii::$app->request->queryParams['per-page'] = 15;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Scan();
        $group = Group::find()->asArray()->all();
        $gs = [];
        foreach($group as $k=>$v){
            $gs[$v['id']] = $v['group_name'];
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'group' => $gs
        ]);
    }

    /**
     * Displays a single Scan model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Scan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Scan();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->alarm_condition = json_encode(Yii::$app->request->post('Scan')['alarm_condition']);
            $model->time = date('Y-m-d H:i:s', time());
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } 
    }

    /**
     * Updates an existing Scan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Scan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Scan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Scan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Scan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
