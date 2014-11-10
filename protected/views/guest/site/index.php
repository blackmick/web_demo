<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/11/2
 * Time: 上午11:45
 */
?>

<?php
$login_personal = $this->renderPartial('login_personal', array('model' => $personalModel), true);
$register_personal = $this->renderPartial('register_personal', array('model'=>$personalModel), true);

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
        ),
        'htmlOptions' => array(
            'style' => "filter:alpha(opacity=80);-moz-opacity: 0.8;opacity: 0.8;background: url(/myjober/css/images/background.png);",
        ),
        'options' => array(
            'heightStyle' => 'content',
        )
    ));
?>