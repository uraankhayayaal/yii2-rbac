<?php

namespace ayaalkaplin\rbac\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use ayaalkaplin\rbac\models\PermissionForm;

/**
 * CatalogController implements the CRUD actions for Catalog model.
 */
class PermissionController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['rbac_permissions']
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
        $dataProvider = PermissionForm::all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new PermissionForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Права успешно записаны.');
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
        $model = PermissionForm::getPermit($name);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->update($name)) {
                Yii::$app->session->setFlash('success', 'Права успешно записаны.');
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
        if (PermissionForm::delete($name)) {
            Yii::$app->session->setFlash('success', 'Право успешно удален.');
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error', 'Ошибка!');
        }
                
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
