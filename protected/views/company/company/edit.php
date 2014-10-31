<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-17
 * Time: 下午1:31
 */
$this->pageTitle=Yii::app()->name . ' - 编辑';
$this->breadcrumbs=array(
    '企业信息' => Yii::app()->user->returnUrl,
    '编辑',
);
?>
<script>
//    $(document).ready(function(){
//        $("#email_add").click(function(){
//
//        });
//
//        $("#email_del").click(function()){
//
//        }
//    });

    function checkInList(list, item_val){
        var count = list.options.length;
        for (var i = 0; i < count; i++){
            if (list.options[i].value == item_val){
                return true;
            }
        }

        return false;
    }

    function checkEmail(email){
        return email.match(/^\w+@\w+\.(com|net|cn|org)$/);
    }

    function addEmail(emailList, email,err){
        if (checkEmail(email)){
            if (!checkInList(emailList, email)){
                emailList.append("<option value='"+email+"'>"+email+"</option>");
            }else{
                err.innerHTML = "email地址已存在列表中";
            }
        }else{
            err.innerHTML = "不合法的email地址";
        }
    }

    function delEmail(emailList){
        var count = emailList.options.length;
        for(var i = count -1; i >= 0; i--){
            if (emailList.options[i].selected == true){
                emailList.options[i]=null;
                break;
            }
        }
    }
</script>
<?php
$form = $this->beginWidget("CActiveForm",
    array(
        'id' => 'CompanyEditForm',
    )
);
?>
<div class = "form">
    <?php echo $form->hiddenField($model, "id", array("value"=> $model->id));?>
    <div class = "row">
        <?php echo $form->labelEx($model, "公司名称");?>
        <?php echo $form->textField($model, "name",
            array(
                'value' => $model->name,
                'readonly' => 'true'
            ));?>
    </div>
    <div class = "row">
        <?php echo $form->labelEx($model, "城市");?>
        <?php echo $form->dropDownList($model, "province", Location::getProvice(),
            array(
                'id' => 'province',
                'empty' => '--选择省份--',
                'select' => $model->province,
                'ajax' => array(
                    'type' => 'POST',
                    'url' => Yii::app()->createUrl('location/citylist'),
                    'update' => '#city',
                    'data' => array('id' => 'js:this.value'),
                )
            ));?>
        <?php echo $form->dropDownList($model, "city", Location::getCityList($model->province),
            array(
                'id' => 'city',
                'empty' => '--选择城市--',
                'select' => $model->city,
            ));?>
    </div>
    <div class = "row">
        <?php echo $form->labelEx($model, "公司性质");?>
        <?php echo $form->dropDownList($model, "type",Company::getTypeList(),
            array(
                'empty' => '--请选择--',
                'select' => $model->type,
            )
        );?>
    </div>
    <div class = "row">
        <?php echo $form->labelEx($model, "所属行业");?>
        <?php echo $form->dropDownList($model, "industry", Industry::getList(),
            array(
                'id'=>'industry',
                'empty'=>'--请选择--',
                'select' => $model->industry,
            )
        );?>
    </div>
    <div class = "row">
        <?php echo $form->labelEx($model, "描述");?>
        <?php echo $form->textArea($model, "description",
            array(
                'class'=>'text-area',
                'value' => $model->description,
            ));
        ?>
    </div>

    <div class = 'row'>
        <?php echo $form->labelEx($model, "地址");?>
        <?php echo $form->textField($model, "address",
            array(
                'value' => $model->address
            )
        );
        ?>
    </div>
    <div class = "row">
        <?php echo $form->labelEx($model, "接受简历的电子邮件");?>
        <?php echo $form->listBox($model, "emailList", $model->emailList,
            array(
                'id' => 'email_list',
                'style'=>'width:150px'
            )
        );?>
        <?php echo CHtml::button("删除",array(
            'id' => 'email_del',
            'onclick'=>'delEmail($("#email_list")[0])'
        ));?>
    </div>
    <div class = "row">
<!--        --><?php //echo $form->emailField($model, "email");?>
        <?php echo CHtml::emailField("email");?>
        <?php echo CHtml::button('添加',
            array(
                'id'=>'email_add',
                'onclick' => 'addEmail($("#email_list")[0],$("#email").val(),$("#email_errmsg")[0])',
            )
        );?>
        <div class="errorMessage">
            <span id="email_errmsg"></span>
        </div>
    </div>
    <div class = "row">
        <?php echo $form->checkBox($model, "flag",
            array(
                'value' => $model->flag,
            )
        );?>
        是否向普通用户公开扩展信息
    </div>

    <div class = "row">
        <?php echo CHtml::submitButton("保存");?>
<!--        --><?php //echo CHtml::button("取消");?>
    </div>
</div>

<?php
$this->endWidget();
?>