<?php

namespace ayaalkaplin\rbac\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use ayaalkaplin\rbac\models\RoleForm;

/**
 * CatalogController implements the CRUD actions for Catalog model.
 */
class RoleController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $descriptionfilter = Yii::$app->request->getQueryParam('filterdescription', '');
        $namefilter = Yii::$app->request->getQueryParam('filtername', '');

        $searchModel = ['name' => $namefilter, 'description' => $descriptionfilter];
        $dataProvider = RoleForm::all();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new RoleForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Роль успешно записана.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка!');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($name)
    {
        $model = RoleForm::getPermit($name);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->update($name)) {
                Yii::$app->session->setFlash('success', 'Роль успешно записана.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка!');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($name)
    {
        if (RoleForm::delete($name)) {
            Yii::$app->session->setFlash('success', 'Роль успешно удалена.');
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error', 'Ошибка!');
        }
                
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
