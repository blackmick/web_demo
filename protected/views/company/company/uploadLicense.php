<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/25
 * Time: 上午11:06
 */
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/ajaxfileupload.js");
$this->pageTitle=Yii::app()->name . ' -上传执照';
$this->breadcrumbs=array(
    '上传执照',
);
?>
<script language="JavaScript">
    function uploadFile(){
        $.ajaxFileUpload(
            {
                url:'company?r=util/upload',
                secureuri:false,
                fileElementId:'cert_file',
                dataType:'json',
                success:function(data){
//                    debugger;
//                    alert('上传成功');
                    var pre = $("#preview")[0];
//                    var imgHtml = "<img src='"+ data.url +"'/>";
                    pre.innerHTML = "<img src='"+ data.url +"' width='150'/>";
                    $("#cert_sign").val(data.contsign);
                }
            }
        )
    }
</script>
<?php
$form = $this->beginWidget("CActiveForm",
    array(
        'id' => 'CompanyCreateForm',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        )
    )
);

?>
<div class="form">
    <div>
        <?php echo CHtml::label("上传营业执照扫描件", "cert_file");?>
        <?php echo CHtml::fileField("cert_file", '', array('id'=>'cert_file'));?>
        <?php echo CHtml::button("上传",
            array(
                'id' => 'btnUpload',
                'onclick' => 'uploadFile()',
            ));?>
    </div>
    <div id = 'preview'></div>
    <div class="row">
        <?php echo $form->hiddenField($model, "certification", array('id'=>'cert_sign','value'=>''));?>
        <?php echo $form->error($model, 'certification');?>
        <?php echo CHtml::submitButton("提交");?>
    </div>
</div>

<?php
$this->endWidget();
?>