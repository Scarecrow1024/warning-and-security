<?php

namespace app\models;
use app\models\Salt;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $uid;
    public $username;
    public $password;
    public $real_name;
    public $photo;
    public $salt;
    public $mail;
    public $secret;
    public $accessToken;
    public $phone;
    public $updated;
    public $created;
    public $status;
    public $authKey;
    public $google_status;



    /**
     * @inheritdoc
     */
    /*public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }*/
    public static function findIdentity($uid)
    {
        $user = AdminUsers::findOne($uid);
        return isset($user) ? new static($user) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = AdminUsers::find()->where(['authKey' => $token])->one();
        if ($user['accessToken'] === $token) {
            return new static($user);
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = AdminUsers::find()->where(['username' => $username, 'status' => 1])->one();
        if (strcasecmp($user['username'], $username) === 0) {
            return new static($user);
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUserid($id)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['id'], $id) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->uid;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        $password = Salt::verifySalt($password, $this->salt);
        return $this->password === $password;
    }
}
