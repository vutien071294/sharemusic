<?php

namespace backend\modules\categorys\controllers;

use yii\web\Controller;

/**
 * Default controller for the `categorys` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
