<?php

class CompanyController extends SafeController
{
	/**
	 * 创建企业数据,只有管理员能创建企业数据
	 *
	 */
	public function actionCreate()
	{
        $user = $this->validatePrivilege();
        if ($user->type != User::UT_ADMIN){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE, 'create company');
        }

        $company = $this->createCompany();

        $oData['id'] = $company->id;
        ErrorHelper::Success($oData);
	}

    public function actionDetail(){
        $user = $this->validatePrivilege();
        if ($user->type > 3){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE);
        }

        $company = Company::model()->findByPk(DataHelper::getIntReq('id'));
        $data[] = $company->getData();
        $this->render(null, $data, false, 'data');
    }

    public function actionList(){

    }

    public function actionSearch(){
        $user = $this->validatePrivilege();
        $type = DataHelper::getIntReq('');
        $keyword = DataHelper::getStrReq('kw');

//        $data = $this->search();
//        $this->render(NULL, $data, false, 'data');
    }

	public function actionUpdate(){
        $user = $this->validatePrivilege();
        if ($user->type != User::UT_ADMIN){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE, 'create company');
        }
        $company = $this->updateCompany();

        $data = $company->getData();
        ErrorHelper::Success($data);
	}

	public function actionDelete(){
        $admin = $this->validatePrivilege();
        if ($admin->type != User::UT_ADMIN){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE,'not admin');
        }
        $this->loadModel(DataHelper::getIntReq('id'))->delete();

        ErrorHelper::Success();
	}

    /**
     * 企业用户关联到该企业
     * @param uid
     * @param token
     * @param cid
     *
     */
    public function actionAssociate(){
        $admin = $this->validatePrivilege();
        if ($admin->type != User::UT_ADMIN){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE, 'not admin');
        }

        $user = User::model()->findByPk(DataHelper::getIntReq('user_id'));
        $company = Company::model()->findByPk(DataHelper::getIntReq('cid'));
        if (!$user || !$company){
            ErrorHelper::Fatal(ErrorHelper::ERR_INTERNAL_ERROR);
        }

        if ($user->type != User::UT_ENTERPRISE){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE, 'user type is not company');
        }

        $user->profile = $company->id;
        $isOk = $user->save();
        if (!$isOk){
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, 'user save fail.'.json_encode($user->getErrors()));
        }

        ErrorHelper::Success();
    }

	public function loadModel($id)
	{
		$model=Company::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    private function createCompany(){
        $name = DataHelper::getStrReq('name');
        $type = DataHelper::getIntReq('type');
        $indtype = DataHelper::getIntReq('indtype');
        $scale  = DataHelper::getIntReq('scale');
        $homepage = DataHelper::getStrReq('homepage');
        $desc = DataHelper::getStrReq('desc');
        $address = DataHelper::getStrReq('address');
        $contact = DataHelper::getStrReq('contact');
        $phone = DataHelper::getStrReq('phone');
        $mobile = DataHelper::getStrReq('mobile');
        $email = DataHelper::getStrReq('email');

        $company = Company::model()->find("name = '${name}' and status = '0'");
        if ($company){
            ErrorHelper::Fatal(ErrorHelper::ERR_DUP_COMPANY);
        }

        $company = new Company();
        $company->name = $name;
        $company->type = $type;
        $company->industry = $indtype;
        $company->scale = $scale;
        $company->homepage = $homepage;
        $company->desc = $desc;
        $company->address = $address;
        $company->contact = $contact;
        $company->phone = $phone;
        $company->mobile = $mobile;
        $company->email = $email;

        $isOk = $company->save();
        if (!$isOk){
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, 'create company fail.'.json_encode($company->getErrors()));
        }

        return $company;
    }

    private function updateCompany(){
        $id = DataHelper::getIntReq('id');
        $name = DataHelper::getStrReq('name');
        $type = DataHelper::getIntReq('type');
        $indtype = DataHelper::getIntReq('indtype');
        $scale  = DataHelper::getIntReq('scale');
        $homepage = DataHelper::getStrReq('homepage');
        $desc = DataHelper::getStrReq('desc');
        $address = DataHelper::getStrReq('address');
        $contact = DataHelper::getStrReq('contact');
        $phone = DataHelper::getStrReq('phone');
        $mobile = DataHelper::getStrReq('mobile');
        $email = DataHelper::getStrReq('email');

        $company = Company::model()->findByPk($id);
        if (!$company){
            ErrorHelper::Fatal(ErrorHelper::ERR_COMPANY_NOT_FOUND);
        }

        $company->name = $name;
        $company->type = $type;
        $company->industry = $indtype;
        $company->scale = $scale;
        $company->homepage = $homepage;
        $company->desc = $desc;
        $company->address = $address;
        $company->contact = $contact;
        $company->phone = $phone;
        $company->mobile = $mobile;
        $company->email = $email;

        $isOk = $company->save();
        if (!$isOk){
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, 'create company fail.'.json_encode($company->getErrors()));
        }

        return $company;

    }

    private function setCompany($company){}
}
