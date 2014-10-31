<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-17
 * Time: 上午11:03
 */
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Detail';
$this->breadcrumbs = array('Company');
?>

<table class="detail-view" style="table-layout:fixed;width: 40%">
    <tr>
        <td width="20%">
            公司名称
        </td>
        <td>
            <?php echo $model->name;?>
        </td>
    </tr>
    <tr>
        <td>
            公司性质
        </td>
        <td>
            <?php echo $model->type;?>
        </td>
    </tr>
    <tr>
        <td>
            所属行业
        </td>
        <td>
            <?php echo $model->industry;?>
        </td>
    </tr>
    <tr>
        <td>
            公司规模
        </td>
        <td>
            <?php echo $model->scale;?>
        </td>
    </tr>
    <tr>
        <td>
            公司主页
        </td>
        <td>
            <?php echo $model->homepage;?>
        </td>
    </tr>
    <tr>
        <td>
            公司简介
        </td>
        <td>
            <?php echo $model->desc;?>
        </td>
    </tr>
    <tr>
        <td>
            公司地址
        </td>
        <td>
            <?php echo $model->address;?>
        </td>
    </tr>
    <tr>
        <td>
            公司联系人
        </td>
        <td>
            <?php echo $model->contact;?>
        </td>
    </tr>
    <tr>
        <td>
            联系电话
        </td>
        <td>
            <?php echo $model->phone;?>
        </td>
    </tr>
    <tr>
        <td>
            联系人手机
        </td>
        <td>
            <?php echo $model->mobile;?>
        </td>
    </tr>
    <tr>
        <td>
            接收简历的email
        </td>
        <td>
            <?php
            if ($model->email){
                $list = explode(',',$model->email);
                foreach($list as $email)
                {
                    echo $email."</br>";
                }
            }
            ?>
        </td>
    </tr>
</table>

<p>
    <?php
    echo CHtml::link("edit", Yii::app()->createUrl('company/edit', array('id'=>$model->id)));
    ?>
</p>