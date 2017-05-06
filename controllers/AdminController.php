<?php

namespace app\controllers;

use app\models\Clients;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class AdminController extends Controller
{
    public $layout = 'admin.php';

    /**
     * Displays clients list.
     *
     * @return string
     */
    public function actionClients()
    {
        $model = new Clients();
        $dataProvider = new ActiveDataProvider([
            'query' => $model
                ->find()
                ->select([
                    $model->tableAlias() . '.ID',
                    $model->tableAlias() . '.NAME',
                    $model->tableAlias() . '.PHONE',
                    'GROUP_NAME' => 'cg.NAME'
                ])
                ->from($model->tableName() . ' ' . $model->tableAlias())
                ->join('LEFT JOIN', ['clients_clients_groups ccg'], 'ccg.CLIENT_ID = ' . $model->tableAlias() . '.ID' )
                ->join('LEFT JOIN', ['clients_groups cg'], 'ccg.CLIENTS_GROUPS_ID = ' . 'cg.ID' ),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        return $this->render('clients/clients', ['dataProvider' => $dataProvider]);
    }

    /**
     * Display admin homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
