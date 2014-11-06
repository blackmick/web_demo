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
        <div id="head-icon" style="float: left">
            <img src="images/Users.png" width="100px" height="100px"/>
        </div>
        <h1 style="float: left">姓名</h1>
        <div class="modify_icon" style="float:left">
            <?php
            echo CHtml::link('修改','#');
            ?>
        </div>
        <p style="clear:left">头衔|公司</p>
        <p>地址|行业|工作年限</p>
    </div>

    <div class="content-pannel">
        <div class="segment">
            <div class="segment-title-icon">
                <img src="/web_demo/images/base_info_icon.png"/>
            </div>
            <h1 style="float: left">基本资料</h1>
            <div class="modify_icon" style="float: right">
                <?php
                echo CHtml::link('修改','#');
                ?>
            </div>
            <div class="segment-content">
            <table>
                <tr>
                    <td class="td-title">
                        出生年月
                    </td>
                    <td>
                        111111
                    </td>
                    <td class="td-title">
                        婚姻状况
                    </td>
                    <td>
                        已婚
                    </td>
                </tr>
                <tr>
                    <td class="td-title">
                        手机
                    </td>
                    <td>
                        111111
                    </td>
                    <td class="td-title">
                        邮箱
                    </td>
                    <td>
                        11111
                    </td>
                </tr>
                <tr>
                    <td class="td-title">
                        国籍
                    </td>
                    <td>
                        中国
                    </td>
                    <td class="td-title">
                        状态
                    </td>
                    <td>
                        在职:看新的机会
                    </td>
                </tr>
            </table>
            </div>
        </div>

        <div class="dash-split-line"></div>

        <div class="segment">
            <div class="segment-title-icon">
                <img src="/web_demo/images/base_info_icon.png"/>
            </div>
            <h1 style="float: left">求职意向</h1>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#job_objective_modify").click(function(){
                        $("#job_objective_form").show();
                        $("#job_objective_summary").hide();
                    });
                });
            </script>
            <div class="modify_icon" style="float: right">
                <?php
                echo CHtml::link('修改','javascript:;', array('id'=>'job_objective_modify'));
                ?>
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

        <div class="segment">
            <div class="segment-title-icon">
                <img src="/web_demo/images/base_info_icon.png"/>
            </div>
            <h1 style="float: left">工作经历</h1>
            <div class="modify_icon" style="float: right">
                <?php
                echo CHtml::link('修改','#');
                ?>
            </div>
            <div class="segment-content">

            </div>
        </div>

        <div class="dash-split-line"></div>
        <div class="segment">
            <div class="segment-title-icon">
                <img src="/web_demo/images/base_info_icon.png"/>
            </div>
            <h1 style="float: left">教育背景</h1>
            <div class="modify_icon" style="float: right">
                <?php
                echo CHtml::link('修改','#');
                ?>
            </div>
            <div class="segment-content">

            </div>
        </div>

        <div class="dash-split-line"></div>
        <div class="segment">
            基本资料
        </div>
        <div class="dash-split-line"></div>
        <div class="segment">
            基本资料
        </div>
    </div>
</div>

<div class="content-sidebar">
<!--    侧边信息块-->
    <div class="content-pannel">
        简历完成度
    </div>
    <div class="content-pannel">
        简历保护
    </div>
</div>
