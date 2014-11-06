<?php
/**
 * Created by PhpStorm.
 * User: 韩啸
 * Date: 2014/11/6
 * Time: 14:14
 */
?>
<!--For Test-->
<?php
    $model=array();
    for($i=0;$i<3;$i++){
        $exp = new Experience();
        $exp->start_time = time()-100000*$i;
        $exp->end_time = time()-20000*$i;
        $exp->company='Company_'.$i;
        //$exp->industry = $i;
        $model[] = $exp;
    }
?>
<script type="text/javascript">

</script>
<?php
    if (is_array($model)&& count($model)){
        echo "<table>";
        $index=0;
        foreach($model as $exp){
            $index++;
?>
            <tr>
                <td>
                    <?php echo $index;?>
                </td>
                <td>
                    <?php echo $exp->start_time.'-'.$exp->end_time;?>
                </td>
                <td>
                    <?php echo $exp->company;?>
                </td>
                <td>
                    <?php echo $index;?>
                </td>
                <td>
                    <?php
                        echo CHtml::link('修改','javascript:;', array('id'=>'exp_modify_'.$index));
                        echo CHtml::link('删除','javascript:;', array('id'=>'exp_delete_'.$index));
                    ?>
                </td>
            </tr>
<?php
        }
        echo "</table>";
    }
?>