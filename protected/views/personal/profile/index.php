<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/29
 * Time: 下午4:12
 */
$this->breadcrumbs = array(
    '我的简历'
);
?>
<div class="content-main">
    <!--主信息块-->
    <div class="content-pannel" style="height:180px">
        <!--    基本信息面板-->

        <?php
        echo $this->renderPartial('user_info', array('user' => $user), true);
        ?>
    </div>

    <div class="content-pannel">
        <!--        基本资料面板-->
        <div class="segment">
            <div class="segment-title">
                <div class="segment-title-icon">
                    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/base.info.icon.png'); ?>
                </div>
                <h1 style="float: left">基本资料</h1>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $("#base_info_modify").click(function () {
                            $("#base_info_show").slideUp();
                            $("#base_info_edit").slideDown();
                            $("#base_info_modify").hide();
                        })
                    })
                </script>

            </div>
            <div class="modify_icon" style="float: right">
                <?php echo CHtml::image(Yii::app()->baseUrl . '/images/modify.icon.png', '修改', array('id' => 'base_info_modify')); ?>
            </div>
            <div class="segment-content" id="base_info_show">
                <?php
                echo $this->renderPartial('base_info_show', array(), true);
                ?>
            </div>
            <div class="segment-content" id="base_info_edit" hidden="true">
                <?php
                echo $this->renderPartial('base_info_edit', array('model' => $baseInfoEdit), true);
                ?>
            </div>
        </div>

        <div class="dash-split-line"></div>
        <!--        求职意向面板-->
        <div class="segment">
            <div class="segment-title">
                <div class="segment-title-icon">
                    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/objective.icon.png'); ?>
                </div>
                <h1 style="float: left">求职意向</h1>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $("#job_objective_modify").click(function () {
                            $("#job_objective_form").slideDown();
                            $("#job_objective_summary").slideUp();
                            $("#job_objective_modify").hide();
                        })
                    })
                </script>
            </div>
            <div class="modify_icon" style="float: right">
                <!--                --><?php //echo CHtml::link('修改','javascript:;', array('id'=>'job_objective_modify'));?>
                <?php echo CHtml::image(Yii::app()->baseUrl . '/images/modify.icon.png', '修改', array('id' => 'job_objective_modify')); ?>
            </div>
            <div class="segment-content" id="job_objective_summary">
                <?php
                echo $this->renderPartial('job_objective', array(), true);
                ?>
            </div>
            <div class="segment-content" id="job_objective_form" hidden="true">
                <?php
                echo $this->renderPartial('job_objective_form', array('model' => $objective), true);
                ?>
            </div>
        </div>

        <div class="dash-split-line"></div>
        <!--                工作经历面板-->
        <div class="segment">
            <div class="segment-title">
                <div class="segment-title-icon">
                    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/work.experience.icon.png'); ?>
                </div>
                <h1 style="float: left">工作经历</h1>
            </div>
            <div class="segment-content">
                <div id="experience_show">
                    <?php echo $this->renderPartial('experience_show', array(), true); ?>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $("#experience_add").click(function () {
                            alert("add exp");
                        })
                    })
                </script>
                <div id="experience_add" class='add_btn' onclick="javascript:;">
                    添加工作经历
                </div>
            </div>
        </div>

        <div class="dash-split-line"></div>

        <!--        教育背景面板-->
        <div class="segment">
            <div class="segment-title">
                <div class="segment-title-icon">
                    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/education.icon.png', '', array('width' => "32")); ?>
                </div>
                <h1 style="float: left">教育背景</h1>
            </div>
            <div class="segment-content">
                <div class="edu_show">
                    <?php echo $this->renderPartial('edu_show', array(), true); ?>
                </div>
                <div id="edu_add" class="add_btn" onclick="javascript:;">
                    添加教育背景
                </div>
            </div>
        </div>

        <div class="dash-split-line"></div>

        <!--        语言能力面板-->
        <div class="segment">
            <div class="segment-title">
                <div class="segment-title-icon">
                    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/language.level.icon.png'); ?>
                </div>
                <h1 style="float: left">语言能力</h1>
            </div>
            <div class="segment-content">
            </div>
        </div>

        <div class="dash-split-line"></div>
        <!--        项目经验面板-->
        <div class="segment">
            <div class="segment-title">
                <div class="segment-title-icon">
                    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/project.experience.icon.png'); ?>
                </div>
                <h1 style="float: left">项目经验</h1>
            </div>
            <div class="segment-content">
            </div>
        </div>
        <div class="dash-split-line"></div>
        <!--        自我评价面板-->
        <div class="segment">
            <div class="segment-title">
                <div class="segment-title-icon">
                    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/self.evaluation.icon.png'); ?>
                </div>
                <h1 style="float: left">自我评价</h1>
            </div>
            <div class="segment-content">
            </div>
        </div>
        <div class="dash-split-line"></div>
        <!--备注信息面板-->
        <div class="segment">
            <div class="segment-title">
                <div class="segment-title-icon">
                    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/remark.icon.png'); ?>
                </div>
                <h1 style="float: left">备注信息</h1>
            </div>
            <div class="segment-content">
            </div>
        </div>
    </div>
</div>

<div class="content-sidebar">
    <!--    侧边信息块-->
    <div class="content-pannel">
        <div class="segment" style="padding: 0;margin: 0;">
            <script type="text/javascript">
                $(function () {
                    $("#profile_name_modify").click(function () {
                        $("#profile_name_show").hide();
                        $("#profile_name_edit").show();
                    });
                    $("#profile_name_save").click(function () {
                        $("#profile_name_show").show();
                        $("#profile_name_edit").hide();
                    });
                    $("#profile_name_cancel").click(function () {
                        $("#profile_name_show").show();
                        $("#profile_name_edit").hide();
                    });
                })
            </script>
            <div class="sidebar-segment-content" id="profile_name_show"
                 style="height:40px;background-color: #666666;color:#FFFFFF;">
                <?php echo CHtml::label("中文简历_20141106", null); ?>
                <div style="float: right">
                    <?php echo CHtml::link('[修改名称]', 'javascript:;',
                        array(
                            'id' => 'profile_name_modify',
                            'style' => 'color:#FFFFFF',
                        ));?>
                </div>
            </div>
            <div class="sidebar-segment-content" id="profile_name_edit" hidden="true"
                 style="background-color: #666666;color:#FFFFFF">
                <?php echo CHtml::textField('profile_name', 'js:$("#profile_name_show").val()', array('style' => 'width:100px')); ?>
                <div style="float: right">
                    <?php echo CHtml::link('[取消]', 'javascript:;',
                        array('id' => 'profile_name_cancel',
                            'style' => 'color:#FFFFFF'
                        ));?>
                    <?php echo CHtml::link('[保存]', 'javascript:;',
                        array('id' => 'profile_name_save',
                            'style' => 'color:#FFFFFF'
                        ));?>
                </div>
            </div>
            <div class="sidebar-segment-content">
                <div style="text-align: center;margin: 5px">
                    <?php echo "简历完成度:" . Profile::model()->getCompletion() . "%"; ?>
                </div>
                <div style="margin: 10px 10px;">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiProgressBar',
                        array(
                            'value' => Profile::model()->getCompletion(),
                            'htmlOptions' => array(
                                'style' => 'height:14px'
                            )
                        )
                    );
                    ?>
                </div>

            </div>
        </div>
    </div>
    <div class="content-pannel">
        简历保护
    </div>
</div>
