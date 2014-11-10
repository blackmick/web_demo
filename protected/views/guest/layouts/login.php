<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/11/3
 * Time: 下午6:06
 */
?>

<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
    <style type="text/css">
        /*body*/
        /*{*/
            /*margin: 0;*/
            /*padding: 0;*/
            /*color: #555;*/
            /*font: normal 10pt Arial,Helvetica,sans-serif;*/
            /*background: #EFEFEF;*/

            /*border-style: solid none none none;*/
        /*}*/
        #container
        {
            border: 3px #E13738;
            width: 1200px;
            margin:0 auto;
            padding: 0;
        }
        .content-main
        {
            width: 80%;
            height: 400px;
        }
        #page
        {
            margin-top: 5px;
            margin-bottom: 5px;
            background: none;
            /*border: 3px #E13738;*/
            /*border-style: solid none none none;*/
            background-image: url(/myjober/images/index_background.jpg);
            background-repeat:no-repeat;
            background-position:center top;
        }
        #footer
        {
            border-top: 0;
        }
    </style>
    <div id="tab-cards" style="float:right">
        <?php echo $content; ?>
    </div><!-- content -->
<?php $this->endContent(); ?>