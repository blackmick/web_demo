<?php
/**
 * Created by PhpStorm.
 * User: 韩啸
 * Date: 14-10-31
 * Time: 下午12:54
 */

?>

<div class="create_form">
    <?php
        echo $form = $this->beginWidget('CActiveForm',
            array(
                'id' => 'ProfileCreateForm',
            )
        );
    ?>
    <div class = "row">
        <?php echo $form->labelEx($model, 'name');?>
    </div>
</div>