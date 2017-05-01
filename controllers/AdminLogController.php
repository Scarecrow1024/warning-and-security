<?php

namespace app\controllers;

use Yii;
use app\models\AdminLog;
use app\models\AdminLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use moonland\phpexcel\Excel;

/**
 * AdminLogController implements the CRUD actions for AdminLog model.
 */
class AdminLogController extends BaseController
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
     * Lists all AdminLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query_params = Yii::$app->request->queryParams;
        $searchModel = new AdminLogSearch();
        $model = new AdminLog();
        $data = $model->find();
        /*if(!isset($_GET['page'])){
            $_GET['page'] = Yii::$app->request->queryParams['page'] = 1;
        }
        if(!isset($_GET['per-page'])){
            $_GET['per-page'] = Yii::$app->request->queryParams['per-page'] = 15;
        }*/
        $currentPage = $query_params['page'] ? $query_params['page'] : 1;
        $pageSize = $query_params['per-page'] ? $query_params['per-page'] : 10;
        $pageInfo = $this->_page($data, $currentPage, $pageSize, true);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pages'=>$pageInfo['pages'],
        ]);
    }

    /**
     * Displays a single AdminLog model.
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
     * Creates a new AdminLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   /* public function actionCreate()
    {
        $model = new AdminLog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Updates an existing AdminLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
   /* public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Deletes an existing AdminLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
   /* public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /*public function actionDeleteAll()
    {
       AdminLog::deleteAll();

        return $this->redirect(['index']);
    }*/
    /**
     * Finds the AdminLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminLog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     *日志导出excel
     */
    public  function actionExport()
    {
        $data_model = AdminLog::find()->asArray()->all();
        if (!$data_model)
        {
            $this->_setSuccessFlash('无操作日志记录');
            return $this->redirect(['index']);
        }

        AdminLog::exportLog();

        Excel::export([
           'models' => $data_model,
            'fileName' => "管理员操作日志(".date('Y-m-d H:i:s',time())."导出)",
            'columns' => ['id', 'user', 'type', 'preview', 'times', 'details'],
            'headers' => [
                'id' => '序号',
                'user' => '用户',
                'type' => '日志类型',
                'preview' => '内容预览',
                'times' => '时间',
                'details' => '详情',
            ]
        ]);

        return $this->redirect(['index']);
    }

}
