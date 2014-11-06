<?php
/* @var $this SiteController */
/* @var $user User */

$this->pageTitle=Yii::app()->name;
//$user = User::model()->findByPk(Yii::app()->user->getId());
$this->breadcrumbs = array('Home');
?>

<div class="content-main">
    <div class="content-pannel">
        <div class="header-icon" style="clear:both;width: 120px;height: 120px;position: relative;float:left;overflow: hidden">
            <?php
            $head_url=$user->getHeadUrl();
            echo CHtml::image(
                $head_url,
                '',
                array(
                    'width'=>120,
                    'height'=>120,
                ));
            ?>
        </div>
        <div class="name-aria" style="left:200px">
            <h1>
                <?php
                if (is_array($profile) && count($profile)>0){
                    echo $profile[0]->last_name.$profile[0]->first_name;
                }else {
                    echo $user->username;
                }
                ?>
            </h1>
            <p>
                <?php
                    if (is_array($profile) && count($profile)>0){

                    }else{
                        echo "还未创建简历,请";
                        echo CHtml::link('创建简历', array('profile/create'));
                    }
                ?>
            </p>
        </div>
        <div class="user-summary" style="clear:both">
            <span>应聘职位数</span>
            <span>收藏职位数</span>
            <span>订阅职位数</span>
            <span>收到消息</span>
        </div>
    </div>
    <div class="content-pannel">
        <h2>
            我们为你推荐的职位
        </h2>
    </div>
</div>



