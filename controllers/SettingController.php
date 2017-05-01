<?php

namespace app\controllers;

use Yii;
use app\models\Setting;
use app\models\SettingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Available;
use app\models\Asset;
use app\models\XssRule;
use app\models\SqlRule;
use app\models\FileRule;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingController extends BaseController
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

    public function actionIndex(){
        $model2 = new Asset();
        $model = new Setting();
        $ss = $model->find()->asArray()->all();
        //print_r($ss);die;
        $data = [];
        foreach($ss as $v){
            $data[$v['key']] = $v['value'];
        }
        return $this->render('index', ['model'=>$model,'data'=>$data,'model2'=>$model2]);
    }

    public function actionUpload()
    {
        $model = new Setting();
        $available = new Available();
        if (Yii::$app->request->isPost) {
            $available->deleteAll();
            $sql = "alter table available AUTO_INCREMENT=1";
            Yii::$app->db->createCommand($sql)->execute();
            $up = UploadedFile::getInstance($model, 'file');
            $file = fopen($up->tempName, "r");
            while(!feof($file)){
                $available->addr = fgets($file);
                $available->insert();
                //echo fgets($file)."<br>";
            }
            fclose($file);
            $this->_setSuccessFlash('添加成功');
            return $this->redirect(['/setting/index']);
        }
    }

    public function actionUpload2()
    {
        $model1 = new Setting();
        if (Yii::$app->request->isPost) {
            /*$available->deleteAll();
            $sql = "alter table available AUTO_INCREMENT=1";
            Yii::$app->db->createCommand($sql)->execute();*/
            $up = UploadedFile::getInstance($model1, 'file2');
            $file = fopen($up->tempName, "r");
            while(!feof($file)){
                $model = new Asset();
                //判断是否内网ip
                $ip = fgets($file);
                if(in_array(strtok($ip, '.'), array('10', '127', '168', '192'))){
                    $model->ip = $ip;
                    $model->type = 1;
                }else{
                    $model->ip = $ip;
                    $model->type = 2;
                }
                $model->insert();
                //echo fgets($file)."<br>";
            }
            fclose($file);
            $this->_setSuccessFlash('导入成功');
            return $this->redirect(['/asset/index']);
        }
    }

    public function actionUpload3()
    {
        $model = new Setting();
        $xss = new XssRule();
        if (Yii::$app->request->isPost) {
            $up = UploadedFile::getInstance($model, 'file3');
            $file = fopen($up->tempName, "r");
            while(!feof($file)){
                $xss->value = fgets($file);
                $xss->insert();
                //echo fgets($file)."<br>";
            }
            fclose($file);
            $this->_setSuccessFlash('xss规则导入成功');
            return $this->redirect(['/setting/index']);
        }
    }

    public function actionUpload4()
    {
        $model = new Setting();
        $xss = new SqlRule();
        if (Yii::$app->request->isPost) {
            $up = UploadedFile::getInstance($model, 'file4');
            $file = fopen($up->tempName, "r");
            while(!feof($file)){
                $xss->value = fgets($file);
                $xss->insert();
                //echo fgets($file)."<br>";
            }
            fclose($file);
            $this->_setSuccessFlash('sql注入规则导入成功');
            return $this->redirect(['/setting/index']);
        }
    }

    public function actionUpload5()
    {
        $model = new Setting();
        $xss = new FileRule();
        if (Yii::$app->request->isPost) {
            $up = UploadedFile::getInstance($model, 'file5');
            $file = fopen($up->tempName, "r");
            while(!feof($file)){
                $xss->value = fgets($file);
                $xss->insert();
                //echo fgets($file)."<br>";
            }
            fclose($file);
            $this->_setSuccessFlash('文件包含规则导入成功');
            return $this->redirect(['/setting/index']);
        }
    }

    /**
     * Displays a single Setting model.
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
     * Creates a new Setting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Setting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Setting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        if(Yii::$app->request->isPost){
            $delay = Yii::$app->request->post('delay');
            $frequency = Yii::$app->request->post('frequency');
            $number = Yii::$app->request->post('number');
            $group = Yii::$app->request->post('group');
            $model = new Setting();
            $model->deleteAll(['key'=>['delay', 'frequency', 'number', 'group']]);
            foreach(['delay'=>$delay, 'frequency'=>$frequency, 'number'=>$number, 'group'=>$group] as $k=>$v){
                $model = new Setting();
                $model->key = $k;
                $model->value = $v;
                $model->save();
            }
            $this->_setSuccessFlash('更新成功');
            return $this->redirect('/setting/index');
        }
    }

    /**
     * Deletes an existing Setting model.
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
     * Finds the Setting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Setting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Setting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
