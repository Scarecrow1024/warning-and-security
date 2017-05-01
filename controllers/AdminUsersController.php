<?php

namespace app\controllers;

use Yii;
use app\models\Salt;
use app\models\AdminUsers;
use app\models\AdminUsersSearch;
use yii\web\Controller;
use app\models\User;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AdminLog;

/**
 * AdminUsersController implements the CRUD actions for AdminUsers model.
 */
class AdminUsersController extends BaseController
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
     * Lists all AdminUsers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminUsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdminUsers model.
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
     * Creates a new AdminUsers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdminUsers();
        if(Yii::$app->request->isPost){
            $model->username = Yii::$app->request->post('AdminUsers')['username'];
            $salt_hash = Salt::generateSalt(Yii::$app->request->post('AdminUsers')['password']);
            $model->password = $salt_hash['hash'];
            $model->salt = $salt_hash['salt'];
            $model->real_name = Yii::$app->request->post('AdminUsers')['real_name'];
            $model->phone = Yii::$app->request->post('AdminUsers')['phone'];
            $model->mail = Yii::$app->request->post('AdminUsers')['mail'];
            $model->status = Yii::$app->request->post('AdminUsers')['status'];
            $model->google_status = Yii::$app->request->post('AdminUsers')['google_status'];
            $model->created = date('Y-m-d H:i:s', time());
            if($model->save()){
                AdminLog::action_log(Yii::$app->user->identity->username,'管理员操作','添加管理员'.Yii::$app->request->post('AdminUsers')['username']);
                return $this->redirect(['view', 'id' => $model->uid]);
            } else {
                return $this->redirect(Yii::$app->request->getReferrer());
            } 
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    //修改个人资料
    public function actionAuth(){
        if(Yii::$app->request->isPost){
            $uid = Yii::$app->user->identity->uid;
            $model = $this->findModel($uid);
            $model->username = Yii::$app->request->post('username');
            $model->mail = Yii::$app->request->post('mail');
            $model->phone = Yii::$app->request->post('phone');
            $salt_hash = Salt::generateSalt(Yii::$app->request->post('password'));
            $model->password = $salt_hash['hash'];
            $model->salt = $salt_hash['salt'];
            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["photo"]["name"]);
            $extension = end($temp);        // 获取文件后缀名
            if ((($_FILES["photo"]["type"] == "image/gif")||($_FILES["photo"]["type"] == "image/jpeg")|| ($_FILES["photo"]["type"] == "image/jpg")||($_FILES["photo"]["type"] == "image/pjpeg")|| ($_FILES["photo"]["type"] == "image/x-png")|| ($_FILES["photo"]["type"] == "image/png"))&&($_FILES["photo"]["size"] < 2048000) && in_array($extension, $allowedExts)){
                if ($_FILES["photo"]["error"] > 0)
                {
                    $error = "错误：: " . $_FILES["photo"]["error"] . "<br>";
                    $this->_setErrorFlash($error);
                    return $this->redirect(Yii::$app->request->getReferrer());
                } else {
                    $photo = '/upload/' . $_FILES["photo"]["name"];
                    if(move_uploaded_file($_FILES["photo"]["tmp_name"], Yii::$app->basePath.'/web'.$photo)){
                        $model->photo = $photo;
                        if($model->save()){
                            $name = Yii::$app->user->identity->username;
                            AdminLog::action_log($name,'管理员操作','修改个人资料'.$name);
                            $this->_setSuccessFlash('个人资料修改成功');
                            return $this->redirect(Yii::$app->request->getReferrer());
                        }else{
                            $this->_setErrorFlash('修改失败');
                            return $this->redirect(Yii::$app->request->getReferrer());
                        }
                    }
                }
            }else{
                $this->_setErrorFlash('非法的文件格式');
                return $this->redirect(Yii::$app->request->getReferrer());
            }
        }
    }

    /**
     * Updates an existing AdminUsers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $salt_hash = Salt::generateSalt(Yii::$app->request->post('AdminUsers')['password']);
            $model->password = $salt_hash['hash'];
            $model->salt = $salt_hash['salt'];
            if($model->save()){
                $name = Yii::$app->user->identity->username;
                AdminLog::action_log($name,'管理员操作','更新管理员'.$name);
                $this->_setSuccessFlash('个人资料修改成功');
                return $this->redirect(['view', 'id' => $model->uid]);
            } 
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AdminUsers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $name = Yii::$app->user->identity->username;
        $username = AdminUsers::find()->where(['uid'=>$id])->asArray()->one()['username'];
        AdminLog::action_log($name,'管理员操作','删除管理员'.$username);
        $this->_setSuccessFlash('删除成功');
        return $this->redirect(['index']);
    }

    /**
     * Finds the AdminUsers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminUsers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminUsers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionResetTwo(){
        $name = Yii::$app->user->identity->username;
        $uid = Yii::$app->request->get('id');
        $model = $this->findModel($uid);
        //$user = AdminUsers::find()->select('secret,username')->where(['uid'=>$uid])->one();
        $model->secret = null;
        if($model->save()){
            AdminLog::action_log($name,'管理员操作','重置二次验证秘钥'.$name);
            $this->_setSuccessFlash('重置成功');
            return $this->redirect(Yii::$app->request->getReferrer());
        }
    }

    public function actionOpenTwo(){
        $name = Yii::$app->user->identity->username;
        $uid = Yii::$app->request->get('id');
        $model = $this->findModel($uid);
        //$user = AdminUsers::find()->select('secret,username')->where(['uid'=>$uid])->one();
        if($model->google_status == 0){
            $model->google_status = 1;
        }else{
            $model->google_status = 0;
        }
        if($model->save()){
            AdminLog::action_log($name,'管理员操作','开启/关闭二次验证'.$name);
            $this->_setSuccessFlash('操作成功');
            return $this->redirect(Yii::$app->request->getReferrer());
        }
    }

}
