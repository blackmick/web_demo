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
    <div class="content-pannel">
        <!--    基本信息面板-->
        <div id="head-icon" style="float: left;border-radius: 50px;overflow: hidden;text-align: center;margin: 20px 30px 20px 100px">
            <img src="images/Users.png"  height="100px" />
        </div>
        <div id="name" style="background-color: #f6f6f6;width: 100%;height: 40px">
            <span>姓名</span>
            <div class="modify_icon" style="float:right">
                <?php
                echo CHtml::link('修改','#');
                ?>
            </div>
        </div>
        <div>
            <p>头衔|公司</p>
            <p>地址|行业|工作年限</p>
        </div>
    </div>

    <div class="content-pannel">
        <!--        基本资料面板-->
        <div class="segment">
            <div class="segment-title-icon">
                <img src="/web_demo/images/base_info_icon.png"/>
            </div>
            <h1 style="float: left">基本资料</h1>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#base_info_modify").click(function(){
                        $("#base_info_show").slideUp();
                        $("#base_info_edit").slideDown();
                        $("#base_info_modify").hide();
                    })
                })
            </script>
            <div class="modify_icon" style="float: right">
                <?php
                echo CHtml::link('修改','javascript:;', array('id'=>'base_info_modify'));
                ?>
            </div>
            <div class="segment-content" id="base_info_show">
                <?php
                echo $this->renderPartial('base_info_show', array(), true);
                ?>
            </div>
            <div class="segment-content" id="base_info_edit" hidden="true">
                <?php
                echo $this->renderPartial('base_info_edit', array('model'=>$baseInfoEdit), true);
                ?>
            </div>
        </div>

        <div class="dash-split-line"></div>
        <!--        求职意向面板-->
        <div class="segment">
            <div class="segment-title-icon">
                <img src="/web_demo/images/base_info_icon.png"/>
            </div>
            <h1 style="float: left">求职意向</h1>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#job_objective_modify").click(function(){
                        $("#job_objective_form").slideDown();
                        $("#job_objective_summary").slideUp();
                        $("#job_objective_modify").hide();
                    })
                })
            </script>
            <div class="modify_icon" style="float: right">
                <?php echo CHtml::link('修改','javascript:;', array('id'=>'job_objective_modify'));?>
            </div>
            <div class="segment-content" id="job_objective_summary">
                <?php
                echo $this->renderPartial('job_objective',array(), true);
                ?>
            </div>
            <div class="segment-content" id="job_objective_form" hidden="true">
                <?php
                echo $this->renderPartial('job_objective_form', array('model'=>$objective),true);
                ?>
            </div>
        </div>

        <div class="dash-split-line"></div>
        <!--                工作经历面板-->
        <div class="segment">
            <div class="segment-title-icon">
                <img src="/web_demo/images/base_info_icon.png"/>
            </div>
            <h1 style="float: left">工作经历</h1>
            <div class="segment-content">
                <div id="experience_show">
                    <?php echo $this->renderPartial('experience_show',array(),true);?>
                </div>
                <script type="text/javascript">
                    $(function(){
                        $("#experience_add").click(function(){
                            alert("add exp");
                        })
                    })
                </script>
                <div id="experience_add" style="padding-left: 20px;padding-right: 20px;border:1px dashed;background-color: #FCEEEE;height: 40px" onclick="javascript:;">
                    添加工作经历
                </div>
            </div>
        </div>

        <div class="dash-split-line"></div>

        <!--        教育背景面板-->
        <div class="segment">
            <div class="segment-title-icon">
                <img src="/web_demo/images/base_info_icon.png"/>
            </div>
            <h1 style="float: left">教育背景</h1>
            <div class="segment-content">
                <div class="edu_show">
                    <?php echo $this->renderPartial('edu_show',array(),true);?>
                </div>
                <div id="edu_add" style="padding-left: 20px;padding-right: 20px;border:1px dashed;background-color: #FCEEEE;height: 40px" onclick="javascript:;">
                    添加教育背景
                </div>
            </div>
        </div>

        <div class="dash-split-line"></div>

        <!--        语言能力面板-->
        <div class="segment">
            <div class="segment-title-icon">
                <img src="/web_demo/images/base_info_icon.png"/>
            </div>
            <h1 style="float: left">语言能力</h1>
            <div class="segment-content">
            </div>
        </div>

        <div class="dash-split-line"></div>
        <!--        项目经验面板-->
        <div class="segment">
            <div class="segment-title-icon">
                <img src="/web_demo/images/base_info_icon.png"/>
            </div>
            <h1 style="float: left">项目经验</h1>
            <div class="segment-content">
            </div>
        </div>
        <div class="dash-split-line"></div>
        <!--        自我评价面板-->
        <div class="segment">
            <div class="segment-title-icon">
                <img src="/web_demo/images/base_info_icon.png"/>
            </div>
            <h1 style="float: left">自我评价</h1>
            <div class="segment-content">
            </div>
        </div>
        <div class="dash-split-line"></div>
        <!--备注信息面板-->
        <div class="segment">
            <div class="segment-title-icon">
                <img src="/web_demo/images/base_info_icon.png"/>
            </div>
            <h1 style="float: left">备注信息</h1>
            <div class="segment-content">
            </div>
        </div>
    </div>
</div>

<div class="content-sidebar">
    <!--    侧边信息块-->
    <div class="content-pannel">
        <div class="segment">
            <script type="text/javascript">
                $(function(){
                    $("#profile_name_modify").click(function(){
                        $("#profile_name_show").hide();
                        $("#profile_name_edit").show();
                    });
                    $("#profile_name_save").click(function(){
                        $("#profile_name_show").show();
                        $("#profile_name_edit").hide();
                    });
                    $("#profile_name_cancel").click(function(){
                        $("#profile_name_show").show();
                        $("#profile_name_edit").hide();
                    });
                })
            </script>
            <div class="sidebar-segment-content" id="profile_name_show" style="background-color: #2a292b;color:#FFFFFF">
                <?php echo "中文简历_20141106";?>
                <div style="float: right">
                    <?php echo CHtml::link('modify', 'javascript:;', array('id'=>'profile_name_modify'));?>
                </div>
            </div>
            <div class="sidebar-segment-content" id="profile_name_edit" hidden="true" style="background-color: #2a292b;color:#FFFFFF">
                <?php echo CHtml::textField('profile_name','js:$("#profile_name_show").val()', array('style'=>'width:100px'));?>
                <div style="float: right">
                <?php echo CHtml::link('cancel', 'javascript:;', array('id'=>'profile_name_cancel'));?>
                <?php echo CHtml::link('save','javascript:;', array('id'=>'profile_name_save'));?>
                </div>
            </div>
            <div class="sidebar-segment-content">
                <?php echo "简历完成度:".Profile::model()->getCompletion()."%";?>
                <?php
                $this->widget('zii.widgets.jui.CJuiProgressBar',
                    array(
                        'value'=>Profile::model()->getCompletion(),
                        'htmlOptions'=>array(
                            'style'=>'height:14px'
                        )
                    )
                    );
                ?>
            </div>
        </div>
    </div>
    <div class="content-pannel">
        简历保护
    </div>
</div>
