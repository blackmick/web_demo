<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/11/2
 * Time: 上午11:45
 */
?>

<?php
$this->widget('zii.widgets.jui.CJuiTabs',
    array(
        'tabs' => array(
            Yii::t('login', '求职者')=>$this->renderPartial('login_personal',
                array(
                    'model' => $personalModel
                ),
                true),
            Yii::t('login', '企业')=>$this->renderPartial('login_company', array(
                    'model' => $companyModel
                ),
                true)
    )));
?>