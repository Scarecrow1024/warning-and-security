<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;

class BaseController extends Controller
{
    public function init()
    {
        $controller_id = $this->id;
        // 登录不进行权限验证
        if ($controller_id == 'login/login') return true;

        if (!$this->verifyAuth()) {
                //echo "权限不足或未登陆！";
                $this->_setErrorFlash('权限不足或未登陆！');
                return $this->redirect('/login/login');
                exit;
        } else {
            return true;
        }
    }

    public function verifyAuth()
    {
        $uid = Yii::$app->user->identity->uid;
        $controller_id = $this->id;
        return $uid;
        // 超级管理员不验证权限
        //if ($uid == 1) return true;

        // 修改自己密码资源不验证
        if ($controller_id == 'ajax/auth' && $action_id == 'update_password') return true;
        if ($controller_id == 'ajax/index' && $action_id == 'error') return true;

        /*$res_auth_list = AdminUsers::find()
            ->asArray()
            ->where(['uid' => $uid,'status'=>1])
            ->one();
        $data = Previlege::find()->select('controller')->where(['id'=>json_decode($res_auth_list['previlege'],true)])->asArray()->all();
        $privileges = [];
        foreach($data as $v){
            $privileges[] = $v['controller'];
        }

        if(in_array($controller_id,$privileges)){
            return true;
        }else{
            return false;
        }*/
    }

	public function _setSuccessFlash($msg)
	{
	    return Yii::$app->session['success_flash'] = $msg;
	}

	public function _setErrorFlash($msg)
	{
	    return Yii::$app->session['error_flash'] = $msg;
	}

	public function _popErrorFlash()
	{
	    $result = '';
	    if (Yii::$app->session['error_flash']) {
	        $flash = Yii::$app->session['error_flash'];
	        $result = is_array($flash) ? implode('<br>', $flash) : $flash;
	        unset(Yii::$app->session['error_flash']);
	    }
	    return $result;
	}

	public function _popSuccessFlash()
	{
	    $result = '';
	    if (Yii::$app->session['success_flash']) {
	        $flash = Yii::$app->session['success_flash'];
	        $result = is_array($flash) ? implode('<br>', $flash) : $flash;
	        unset(Yii::$app->session['success_flash']);
	    }
	    return $result;
	}

	/**
     * _pageList 数组数据分页函数
     * @param  array $data 要分页的数组数据
     * @param  integer $currentPage 当前页面
     * @param  integer $pageSize 每页显示数据条数
     * @return  array
     */
    public function _pageList($data = array(), $currentPage = 1, $pageSize = 10)
    {
        $pages = new Pagination(['totalCount' => count($data), 'pageSize' => $pageSize, 'page' => $currentPage - 1]);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
        $data = $dataProvider->getModels();

        return [
            'data' => $data,
            'pages' => $pages,
        ];
    }

    /**
     * _page 对象进行分页
     * @param  object $object ActiveQuery Object
     * @param  integer $currentPage 当前页面
     * @param  integer $pageSize 每页显示数据条数
     * @param  boolean $type 返回数据类型，true返回对象集合数据，false返回数组集合
     * @return  array
     * @usage:
     *     $object = ClientGame::find()->where();
     *     $this->_page($object, $currentPage, $pageSize, $type);
     */
    public function _page($object, $currentPage = 1, $pageSize = 10, $type = true)
    {
        $pages = new Pagination(['totalCount' => $object->count(), 'pageSize' => $pageSize, 'page' => $currentPage - 1]);
        if ($type) {
            $data = $object->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        } else {
            $data = $object->offset($pages->offset)
                ->limit($pages->limit)
                ->asArray()
                ->all();
        }
        return [
            'data' => $data,
            'pages' => $pages,
        ];
    }
}