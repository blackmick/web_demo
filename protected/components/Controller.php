<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    private $_className;
    protected $config;
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public function __construct($id, $module = null){
        parent::__construct($id, $module);
        $this->_className = get_class($this);

        $this->config = Yii::app()->params[$this->_className];
    }

    public function render($view,$data=null,$return=false, $otype = 'page')
    {
        if ($otype === 'data')
        {
            $oData = array();
            $return_num = count($data);
            if ($return_num == 0)
            {
                $oData['status'] = 'no result';
            }else{
                $oData['data'] = $data;
                $oData['status'] = 'success';
            }
            $oData['return number'] = $return_num;


            if ($return)
            {
                return json_encode($oData);
            }else{
//                header("Content-Type:\"application/json;charset=utf-8\"");
                echo json_encode($oData);
            }

        }else{
            return parent::render($view, $data, $return);
        }
    }
}