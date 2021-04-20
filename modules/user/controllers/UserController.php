<?php

namespace app\modules\user\controllers;

use app\modules\pd\models\PdWork;
use app\modules\user\models\AuthAssignment;
use app\modules\user\models\AuthItem;
use app\modules\user\models\AuthItemChild;
use app\modules\user\models\CreateRole;
use app\modules\user\models\CreateRolePermission;
use Yii;
use app\modules\user\models\User;
use app\modules\user\models\SearchUser;
use app\modules\user\models\SignupForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class UserController extends Controller
{


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	
    public function actionCreate()
    {
        // $model = new User();

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }

        // return $this->render('create', [
        //     'model' => $model,
        // ]);

        $model = new SignupForm();

        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            $user = new User();
            $user->username = trim($model->username);
            $user->password = \Yii::$app->security->generatePasswordHash(trim($model->password));
            $user->branch_id = $model->branch_id;
            $user->position = $model->position;
            $user->fio = $model->fio;
            $user->phone = $model->phone;
            $user->email = $model->email;
            $user->enabled = $model->enabled;
//            $user->role_id = $model->role_id;
			if($user->save()){
			$auth = Yii::$app->authManager;
			$role = $auth->getRole($model->role_id);
			$auth->assign($role, $user->id);

			return $this->redirect(['index']);
			}

        }

        return $this->render('signup', compact('model'));
    }



    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }



    public function actionUpdatePassword($id)
    {
        $model = $this->findModel($id);

        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            $model->password = \Yii::$app->security->generatePasswordHash($model->password);

            if($model->save()){
                return $this->redirect(['index']);
            }

        }

        return $this->render('updatepass', [
            'model' => $model,
        ]);
    }


    public function actionCreatePermission()
    {

        function checkbox($count,$all_permission){
        return '<input type="checkbox" id="cheak'.$count.'" class ="checkbox_check" value="'.$all_permission['name'].'">
                              <label for="cheak'.$count.'">'.$all_permission['name'].'</label><br>';
        }
        function search($name , $all_permission){
        $patt = preg_quote($name, '~');
        return preg_match_all("~\w*$patt\w*~", $all_permission['name']);
        }

        $role_all = Yii::$app->getAuthManager()->getRoles();
        $model = new CreateRole();
        $all_permissions =  AuthItem::find()->where(['=','type','2'])->orderBy('name')->asArray()->all();
        $lu = '';
        $pd = '';
        $brigade = '';
        $tr = '';
        $other = '';
        $audit = '';
        $count = 0;
        //Создаем массивы для рендора
        foreach ($all_permissions as $all_permission){
            $count++;
            if ( search('lu_' , $all_permission))
                $lu .= checkbox($count,$all_permission);
            elseif (search( 'pd_', $all_permission))
                $pd .= checkbox($count,$all_permission);
            elseif (search('brigade_', $all_permission))
                $brigade .= checkbox($count,$all_permission);
            elseif (search( 'tr_', $all_permission))
                $tr .= checkbox($count,$all_permission);
            elseif (search( 'audit_', $all_permission))
                $audit .= checkbox($count,$all_permission);
            else
                $other .= checkbox($count,$all_permission);


        }
        if ($model->load(Yii::$app->request->post())) {
            //Удаление всех разрешений для пользователя
            $personal_permission =  Yii::$app->authManager->getPermissionsByUser($model['username']) ;
            $personal_permission = array_keys($personal_permission);
            AuthAssignment::deleteAll(['and',
                    ['user_id'=>$model['username']],
                    ['in', 'item_name', $personal_permission]]
            );
            if (!empty($model['permission'])){
                $auth = Yii::$app->authManager;
                //Анализирование разрешение для ролей определенного пользователя
                $roles_user =  array_keys($auth->getRolesByUser($model['username']));
                foreach ($roles_user as $role_user){
                    if(isset($permission_role)) {
                        $arr_permission = array_flip(array_keys($auth->getPermissionsByRole($role_user)));
                        $permission_role = array_merge($permission_role, $arr_permission);
                    }
                    else
                        $permission_role =  array_flip(array_keys($auth->getPermissionsByRole($role_user)));
                }
                //Массив разрешений полученный
                $permissions = explode(",", $model['permission']);
                //Добавление разрешений
                foreach ($permissions as $permission)
                    if (!isset($permission_role[$permission]))
                        $auth->assign($auth->getPermission($permission), $model['username']);
            }
            return $this->redirect(['index']);
        }

        return $this->render('create_permission', [
            'model' => $model,
            'role_all' => $role_all,
            'lu'=>$lu,
            'pd'=>$pd,
            'brigade'=>$brigade,
            'tr'=>$tr,
            'audit'=>$audit,
            'other'=>$other,
        ]);
    }
    public function actionCreateRolePermission()
    {
        function checkbox($count,$all_permission){
            return '<input type="checkbox" id="cheak'.$count.'" class ="checkbox_check" value="'.$all_permission['name'].'">
                              <label for="cheak'.$count.'">'.$all_permission['name'].'</label><br>';
        }
        function search($name , $all_permission){
            $patt = preg_quote($name, '~');
            return preg_match_all("~\w*$patt\w*~", $all_permission['name']);
        }

        $model = new CreateRolePermission();
        $all_permissions =  AuthItem::find()->where(['=','type','2'])->orderBy('name')->asArray()->all();
        $lu = '';
        $pd = '';
        $brigade = '';
        $tr = '';
        $other = '';
        $audit = '';
        $count = 0;
        //Создаем массивы для рендора
        foreach ($all_permissions as $all_permission){
            $count++;
            if ( search('lu_' , $all_permission)){
                $lu .= checkbox($count,$all_permission);
            }
            elseif (search( 'pd_', $all_permission)){
                $pd .= checkbox($count,$all_permission);
            }
            elseif (search('brigade_', $all_permission)){
                $brigade .= checkbox($count,$all_permission);
            }
            elseif (search( 'tr_', $all_permission)){
                $tr .= checkbox($count,$all_permission);
            }
            elseif (search( 'audit_', $all_permission)){
                $audit .= checkbox($count,$all_permission);
            }
            else{
                $other .= checkbox($count,$all_permission);
            }

        }

        if ($model->load(Yii::$app->request->post())) {
            $auth =  Yii::$app->authManager;
            if ($model['create'] == 1){
                $author = $auth->createRole($model['role_create']);
                $text = $model['description'] . ' (доб.в ручную)';
                $author->description = $text;
                $auth->add($author);

                if ($model['permission']){
                    $permissions = explode(",", $model['permission']);
                    foreach ($permissions as $permission) {
                        $auth->addChild($auth->getRole($model['role_create']), $auth->getPermission($permission));
                    }
                }
            }
            else{
                $role_permission =  Yii::$app->authManager->getPermissionsByRole($model['role_id']) ;
                $role_permission = array_keys($role_permission);
                AuthItemChild::deleteAll(['and',
                        ['parent'=>$model['role_id']],
                        ['in', 'child', $role_permission]]
                );
                if (!empty($model['permission'])){
                    $permissions = explode(",", $model['permission']);
                    foreach ($permissions as $permission) {
                        $auth->addChild($auth->getRole($model['role_id']), $auth->getPermission($permission));
                    }
                }

            }
            return $this->redirect(['index']);
        }

        return $this->render('create_role_permission', [
            'model' => $model,
            'lu'=>$lu,
            'pd'=>$pd,
            'brigade'=>$brigade,
            'tr'=>$tr,
            'audit'=>$audit,
            'other'=>$other,
        ]);
    }



    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }


    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionChangePermission()
    {
        if(\Yii::$app->request->isAjax){
            $peopleId = Yii::$app->request->post('people');
            if (\Yii::$app->authManager-> getAssignment('ca',$peopleId))
                $permissions = AuthItem::find()->where(['=','type','2'])->andWhere(['=','permission','1'])->all();
            else
                $permissions = AuthItem::find()->where(['=','type','2'])->andWhere(['=','permission','0'])->all();

            foreach ($permissions as $permission){
                echo '<option value="'.$permission['name'].'">'.$permission['name'].'</option>';
            }
            return true;

        }

        return false;
    }

    public function actionViewPermission()
    {
         if(\Yii::$app->request->isAjax){
            $role = Yii::$app->request->post('role_id');
            $role_permissions =  Yii::$app->authManager->getPermissionsByRole($role) ;
            $role_permissions = array_keys($role_permissions);
            foreach ($role_permissions as $role_permission){
                if (isset($permissions))
                    $permissions .= ',' . $role_permission;
                else
                    $permissions = $role_permission;
            }
             if (!isset($permissions))
                 $permissions = '';
            return $permissions;

        }

        return false;
    }
    public function actionViewPermissionForPeople()
    {
         if(\Yii::$app->request->isAjax){
            $user = Yii::$app->request->post('id_user');
            $role_permissions =  Yii::$app->authManager->getPermissionsByUser($user) ;
            $role_permissions = array_keys($role_permissions);
            foreach ($role_permissions as $role_permission){
                if (isset($permissions))
                    $permissions .= ',' . $role_permission;
                else
                    $permissions = $role_permission;
            }
            if (!isset($permissions))
                $permissions = '';
            return $permissions;

        }

        return false;
    }




	// public function actionSignup(){

 //    	$model = new SignupForm();

 //    	if($model->load(\Yii::$app->request->post()) && $model->validate()){

 //    		$user = new User();
 //    		$user->username = $model->username;
 //    		$user->password = \Yii::$app->security->generatePasswordHash($model->password);
 //     		$user->branch_id = $model->branch_id;
 //    		$user->position = $model->position;
 //    		$user->fio = $model->fio;
 //    		$user->phone = $model->phone;
 //    		$user->enabled = $model->enabled;
 //    		$user->role_id = $model->role_id;

 //    		if($user->save()){
 //    			return $this->goHome();
 //    		}
 //    	}

 //    	return $this->render('signup', compact('model'));
	// }


}
