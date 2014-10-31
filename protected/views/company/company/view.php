<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-17
 * Time: 上午11:03
 */
/* @var $this CompanyController */

$this->pageTitle=Yii::app()->name . ' - 公司详情';
$this->breadcrumbs = array('公司详情');
?>
<?php
    $this->widget('zii.widgets.CDetailView',
        array(
            'data' => $company,
            'attributes' => array(
                array(
                    'label' => '公司名称',
                    'value' => $company->name,
                ),
                array(
                    'label' => '公司性质',
                    'value' => Company::getTypeName($company->type),
                ),
                array(
                    'label' => '所属行业',
                    'value' => Industry::getName($company->industry),
                ),
                array(
                    'label' => '公司规模',
                    'value' => Company::getScale($company->scale),
                ),
                array(
                    'label' => '公司主页',
                    'value' => $company->homepage,
                ),
                array(
                    'label' => '公司简介',
                    'value' => CHtml::encode($company->description),
                ),
                array(
                    'label' => '公司地址',
                    'value' => CHtml::encode($company->address),
                ),
                array(
                    'label' => '公司联系人',
                    'value' => CHtml::encode($company->contact),
                ),
                array(
                    'label' => '联系电话',
                    'value' => CHtml::encode($company->phone),
                ),
                array(
                    'label' => '联系人手机',
                    'value' => CHtml::encode($company->phone),
                ),
                array(
                    'label' => '公司接收简历的email',
                    'value' => CHtml::encode($company->email),
                )
            )
        )
    );
?>

<p>
    <?php
    echo CHtml::button("edit",
        array(
            'onclick' => 'location.href="'.Yii::app()->createUrl("company/update", array("id"=>$company->id)).'"',
        ));
    ?>
</p>