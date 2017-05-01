<?php

namespace app\controllers;

use Yii;
use app\models\Group;
use app\models\GroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AdminUsers;
use QL\QueryList;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends BaseController
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
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $data = Group::find()->asArray()->all();
        $users = AdminUsers::find()->select('uid,username')->asArray()->all();
        return $this->render('index',['data'=>$data,'users'=>$users]);
    }

    /**
     * Displays a single Group model.
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
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Group();
        if(Yii::$app->request->isPost){
            $model->group_name = Yii::$app->request->post('group_name');
            $model->users = json_encode(Yii::$app->request->post('users'));
            if($model->save()){
                $this->_setSuccessFlash('添加成功');
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost){
            $model->group_name = Yii::$app->request->post('group_name');
            $model->users = json_encode(Yii::$app->request->post('users'));
            if($model->save()){
                $this->_setSuccessFlash('修改成功');
                return $this->redirect(Yii::$app->request->getReferrer());
            }else{
                $this->_setSuccessFlash('修改失败');
                return $this->redirect(Yii::$app->request->getReferrer());
            }
        } else {
            $data = Group::find()->where(['id'=>$id])->asArray()->one();
            $users = AdminUsers::find()->select('uid,username')->asArray()->all();
            return $this->render('update', [
                'model' => $model,
                'data' => $data,
                'users' => $users
            ]);
        }
    }

    /**
     * Deletes an existing Group model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()){
            return 1;
        }
    }

    /**
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDemo(){
        //第一层遍历，去重
        $data = $this->getLink('http://www.baidu.con');
        //print_r($data);die;
        $data1 = array_unique($data);
        $data2 = [];
        foreach($data1 as $v1){
            if($v1==''){
                print_r('null');
            }else{
                print_r(array_unique($this->getLink($v1)));
            }
        }
        print_r($data1);
    }

    public function getLink($url){
        $html = file_get_contents($url);
        if(empty($html)){
            $html = "<html></html>";
        }
        $baseUrl = $url;
        $rules = array(
            'link' => array('a','href',''),
        );
        $data = QueryList::Query($html,$rules)->getData(function($item) use($baseUrl){
            if(strstr($item['link'],'javascript') || strstr($item['link'],'@')){
                unset($item);
            }
            if(strstr($item['link'], 'http') && strpos($item['link'], $baseUrl)==false){
                unset($item);
            }
            if(substr($item['link'], -1)=='/'){
                $item['link'] = substr($item['link'], 0,-1);
            }
            if($item['link']==''||$item['link']=='#'){
                unset($item);
            }
            return $baseUrl.$item['link'] == $baseUrl ? '':$baseUrl.$item['link']; 
            //return $baseUrl.$item['link'];
        });
        return $data;
    }

    public function getLinks($url){
        $baseUrl = $url;
        QueryList::run('Multi',[
            //待采集链接集合
            'list' => [
                $url,
            ],
            'curl' => [
                'opt' => array(
                            //这里根据自身需求设置curl参数
                            CURLOPT_SSL_VERIFYPEER => false,
                            CURLOPT_SSL_VERIFYHOST => false,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_AUTOREFERER => true,
                        ),
                //设置线程数
                'maxThread' => 100,
                //设置最大尝试数
                'maxTry' => 3 
            ],
            'success' => function($a){
                //采集规则
                $reg = array(
                    'link' => array('a','href',''),
                    );
                $ql = QueryList::Query($a['content'],$reg);
                $data = $ql->getData(function($item) use($baseUrl){
                    if($item['link']=='javascript:;'||strstr($item['link'],'@')){
                        unset($item);
                    }
                    if(strstr($item['link'], 'http') && strpos($item['link'], $baseUrl)==false){
                        unset($item);
                    }
                    if(substr($item['link'], -1)=='/'){
                        $item['link'] = substr($item['link'], 0,-1);
                    }
                    return $item['link'];
                    
                });
                //打印结果，实际操作中这里应该做入数据库操作
                print_r(array_unique($data));
            }
        ]);
    }
}
