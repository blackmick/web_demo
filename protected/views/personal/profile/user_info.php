<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/11/7
 * Time: 下午12:07
 */
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/fileupload/vendor/jquery.ui.widget.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/fileupload/jquery.iframe-transport.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/fileupload/jquery.fileupload.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/fileupload/jquery.fileupload.css');
?>
<script type="text/javascript">
    $(function () {
        $("#upload_head").fileupload({
            url:'/myjober/pindex.php?r=profile/uploadhead',
            dataType:'json',
            acceptFileTypes:/(\.|\/)(gif|jpe?g|png)$/i,
            done:function(e,data) {
                if (data.result.status==0){
                    $("#head_image").attr("src", data.result.url);
                }else{
                    alert('upload fail,pls try again.');
                }
            }
        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput?undefined:'disabled');
    });
</script>
<div style="float:left;display: table;margin: 20px 30px 20px 30px">
    <div id="head-icon">
        <?php
        echo CHtml::image($user->getHeadUrl(), '', array('style' => 'height:100px','id'=>'head_image'));
        ?>
    </div>
    <div style="text-align: center;margin: 5px 0px">
        <?php
        if (empty($user->head)) {
            $head_text = CHtml::encode("上传头像");
        } else {
            $head_text = CHtml::encode("修改头像");
        }
        ?>
        <span class="btn btn-success fileinput-button">
            <span><?php echo $head_text; ?></span>
            <input id="upload_head" type="file" name="image_file" style="width: 80px;font-size:0">
        </span>
    </div>
</div>

<div id="name" style="background-color: #f6f6f6;width: 100%;height: 80px">
    <h1 style="float:left;margin-top:40px">
        <?php
        if (isset($user->profile[Profile::LANG_CN])) {
            $profile_cn = $user->profile[Profile::LANG_CN];
            if (is_array($profile_cn->work_exp) && count($profile_cn->work_exp) > 0) {
                $title = $profile_cn->work_exp[0]->title;
                $company = $profile_cn->work_exp[0]->company;
                $location = $profile_cn->work_exp[0]->location;
                $location = $profile_cn->total_work_year;
            } else {
                echo CHtml::encode($user->username);
            }
        } else {
            echo CHtml::encode($user->username);
        }
        ?>
    </h1>

    <div class="modify_icon" style="float:right;">
        <?php
        echo CHtml::link('修改', '#');
        ?>
    </div>
</div>
<div style="margin: 20px">
    <?php
    if (isset($user->profile[Profile::LANG_CN])) {
        $profile_cn = $user->profile[Profile::LANG_CN];
        if (is_array($profile_cn->work_exp) && count($profile_cn->work_exp) > 0) {
            $title = $profile_cn->work_exp[0]->title;
            $company = $profile_cn->work_exp[0]->company;
            $location = $profile_cn->work_exp[0]->location;
            $location = $profile_cn->total_work_year;
        } else {
            echo CHtml::encode("您还没有创建简历信息，请完善");
        }
    } else {
        echo CHtml::encode("您还没有创建简历信息，请完善");
    }
    ?>
</div>