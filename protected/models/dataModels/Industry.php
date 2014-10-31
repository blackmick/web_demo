<?php

/**
 * This is the model class for table "{{indtype}}".
 *
 * The followings are the available columns in table '{{indtype}}':
 * @property integer    $id
 * @property string     $name
 * @property string     $e_name
 * @property integer    $create_time
 * @property integer    $update_time
 * @property integer    $status
 */
class Industry extends CActiveRecord
{
    private static $indTypeMap = array(
        "1"=>"计算机软件",
        "2"=>"电子技术/半导体/集成电路",
        "3"=>"金融/投资/证券",
        "4"=>"贸易/进出口",
        "5"=>"快速消费品(食品、饮料、化妆品)",
        "6"=>"服装/纺织/皮革",
        "7"=>"专业服务(咨询、人力资源、财会)",
        "8"=>"制药/生物工程",
        "9"=>"建筑/建材/工程",
        "11"=>"餐饮业",
        "12"=>"广告",
        "13"=>"文字媒体/出版",
        "14"=>"机械/设备/重工",
        "15"=>"印刷/包装/造纸",
        "16"=>"采掘业/冶炼",
        "17"=>"娱乐/休闲/体育",
        "18"=>"法律",
        "19"=>"石油/化工/矿产/地质",
        "20"=>"环保",
        "21"=>"交通/运输/物流",
        "22"=>"批发/零售",
        "23"=>"教育/培训/院校",
        "24"=>"学术/科研",
        "26"=>"房地产开发",
        "27"=>"生活服务",
        "28"=>"政府/公共事业",
        "29"=>"农/林/牧/渔",
        "30"=>"其他行业",
        "31"=>"通信/电信/网络设备",
        "32"=>"互联网/电子商务",
        "33"=>"汽车及零配件",
        "34"=>"中介服务",
        "35"=>"仪器仪表/工业自动化",
        "36"=>"电气/电力/水利",
        "37"=>"计算机硬件",
        "38"=>"计算机服务(系统、数据服务、维修)",
        "39"=>"通信/电信运营、增值服务",
        "40"=>"网络游戏",
        "41"=>"会计/审计",
        "42"=>"银行",
        "43"=>"保险",
        "44"=>"家具/家电/玩具/礼品",
        "45"=>"办公用品及设备",
        "46"=>"医疗/护理/卫生",
        "47"=>"医疗设备/器械",
        "48"=>"公关/市场推广/会展",
        "49"=>"影视/媒体/艺术/文化传播",
        "50"=>"家居/室内设计/装潢",
        "51"=>"物业管理/商业中心",
        "52"=>"检测，认证",
        "53"=>"酒店/旅游",
        "54"=>"美容/保健",
        "55"=>"航天/航空",
        "56"=>"原材料和加工",
        "57"=>"非盈利机构",
        "58"=>"多元化业务集团公司",
        "59"=>"外包服务",
        "60"=>"奢侈品/收藏品/工艺品/珠宝",
        "61"=>"新能源",
        "62"=>"信托/担保/拍卖/典当",
        "63"=>"租赁服务",
    );

    private static $indTypeMapE = array(
        "1"=>"Computers,Software",
        "2"=>"Electronics/Semiconductor/IC",
        "3"=>"Finance/Investments/Securities",
        "4"=>"Trading/Import & Export",
        "5"=>"FMCG(Food,Beverage,Cosmetics)",
        "6"=>"Apparel/Textiles/Leather Goods",
        "7"=>"Professional Services (Consulting, HR, Finance/Accounting)",
        "8"=>"Pharmaceuticals/Biotechnology",
        "9"=>"Architectural Services/Building Materials/Construction",
        "11"=>"Restaurant & Food Services",
        "12"=>"Advertising",
        "13"=>"Print Media/Publishing",
        "14"=>"Machinery, Equipment, Heavy Industries",
        "15"=>"Printing/Packaging/Paper",
        "16"=>"Mining/Metallurgy",
        "17"=>"Entertainment/Leisure/Sports & Fitness",
        "18"=>"Legal",
        "19"=>"Oils/Chemicals/Mines/Geology",
        "20"=>"Environmental Protection",
        "21"=>"Transportation/Logistic/Distribution",
        "22"=>"Wholesale/Retail",
        "23"=>"Education/Training/Universities and Colleges",
        "24"=>"Science/Research",
        "26"=>"Real Estate Development",
        "27"=>"Personal Care & Services",
        "28"=>"Government/Public Service",
        "29"=>"Agriculture/Forestry/Husbandry/Fishery",
        "30"=>"Others",
        "31"=>"Telecom & Network Equipment",
        "32"=>"Internet/E-commerce",
        "33"=>"Automobile & Components",
        "34"=>"Agency",
        "35"=>"Instrument/Industry Automation",
        "36"=>"Electricity/Utilities/Energy",
        "37"=>"Computers, Hardware",
        "38"=>"Computer Services",
        "39"=>"Telecom Operators/Service Providers",
        "40"=>"Online Game",
        "41"=>"Accounting, Auditing",
        "42"=>"Banking",
        "43"=>"Insurance",
        "44"=>"Furniture/Home Appliances/Toys/Gifts",
        "45"=>"Office Supplies & Equipment",
        "46"=>"Medical Care/Healthcare/Public Health",
        "47"=>"Medical Facilities/Equipment",
        "48"=>"Public Relations/Marketing/Exhibitions",
        "49"=>"Flim & Television/Media/Arts/Communication",
        "50"=>"Interior Design/Decoration",
        "51"=>"Property Management",
        "52"=>"Testing, Certification",
        "53"=>"Hospitality/Tourism",
        "54"=>"Beauty/Health",
        "55"=>"Aerospace/Aviation/Airlines",
        "56"=>"Raw Materials & Processing",
        "57"=>"Non-Profit Organizations",
        "58"=>"Conglomerates",
        "59"=>"Outsourcing Services",
        "60"=>"Luxury/Collectibles/Arts&Craft/Jewelry",
        "61"=>"New Energy",
        "62"=>"Trust/Auction/Guarantee/Pawn",
        "63"=>"Leasing Service",
    );
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{indtype}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('id, name', 'required'),
//			array('id, create_time, update_time, status', 'numerical', 'integerOnly'=>true),
//			array('name', 'length', 'max'=>64),
//            array('e_name', 'length', 'max'=>64),
//
//			// The following rule is used by search().
//			// @todo Please remove those attributes that should not be searched.
//			array('id, name, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
//			'id' => 'ID',
//			'name' => 'Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
//		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Industry the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /*
    public function getName($id = null){
        if ($id){
            $this->findByPk($id);
        }

        //var_dump($this->);
        return $this->name ? $this->name : "未知";
    }
    */

    public static function getName($id, $lang="cn"){
        $map = array();
        if ($lang == "cn"){
            $map = self::$indTypeMap;
        }else{
            $map = self::$indTypeMapE;
        }

        if(!$id || !isset($map[$id])){
            return "未知";
        }

        return $map[$id];
    }

    public static function getList(){
        return self::$indTypeMap;
    }
}
