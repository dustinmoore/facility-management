<?php

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $userType;
    public $userEmail;
    public $userFullName;

    private static $users = [
        '99' => [
            'id' => '99',
            'username' => 'nobody',
            'password' => 'Nothing@1',
            'authKey' => 'test99key',
            'accessToken' => '99-token',
            'userType' => 'nothing',
            'userEmail' => 'nobody@gmail.com',
            'userFullName' => 'No Trainer'
        ],
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'Elite@1',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
            'userType' => 'administrator',
            'userEmail' => 'dmoore8883@gmail.com',
            'userFullName' => 'Administrator'
        ],
        '101' => [
            'id' => '101',
            'username' => 'dmoore8883',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
            'userType' => 'administrator',
            'userEmail' => 'dmoore8883@gmail.com',
            'userFullName' => 'Dustin Moore'
        ],
        '102' => [
            'id' => '102',
            'username' => 'coachbump',
            'password' => 'Bearcats',
            'authKey' => 'test102key',
            'accessToken' => '102-token',
            'userType' => 'trainer',
            'userEmail' => 'bumpuselite@gmail.com',
            'userFullName' => 'Michael Bumpus'
        ],
        '103' => [
            'id' => '103',
            'username' => 'legends16',
            'password' => 'Baseball',
            'authKey' => 'test103key',
            'accessToken' => '103-token',
            'userType' => 'client',
            'userEmail' => 'Legends@gmail.com',
            'userFullName' => 'Legends 16U'
        ],
        '104' => [
            'id' => '104',
            'username' => 'legends9u',
            'password' => 'Baseball',
            'authKey' => 'test104key',
            'accessToken' => '104-token',
            'userType' => 'client',
            'userEmail' => 'Legends@gmail.com',
            'userFullName' => 'Legends 9U'
        ],
    ];


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
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
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) != 'trainer') {
                continue;
            }
        }

        return null;
    }

    public static function findAllUsers()
    {
        return self::$users;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
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
        return $this->password === $password;
    }
}
