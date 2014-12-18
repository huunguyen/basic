<?php

class ProductController extends Controller {

    public $defaultAction = 'index';

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {
        return array(
            array('allow', 'actions' => array('captcha'), 'users' => array('*')),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('getAttGroup', 'loadAttribute', 'addCartAuto', 'getcart', 'search', 'showPack', 'buildSearch', 'deletePack', 'addPackcart', 'editcart', 'deletecart', 'index', 'view', 'view_Menu', 'showprice', 'addCart', 'showCart', 'addrate', 'addcomment'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionGetAttGroup() {

        $id_att = Yii::app()->getRequest()->getParam('id_att', null);
        $id_pro = Yii::app()->getRequest()->getParam('id_pro', null);
        if ($id_att != null) {
            $maps = explode(',', $id_att);
            $model = Product::model()->findByPk($id_pro);
            $criteria_product_att = new CDbCriteria();
            $criteria_product_att->with = array('tblProductAttributeCombinations');
            $criteria_product_att->compare('id_product_attribute', 'tblProductAttributeCombinations.id_product_attribute');
            $criteria_product_att->condition = "id_product=$id_pro AND tblProductAttributeCombinations.id_attribute in($id_att)";
            $Product_attribute = ProductAttribute::model()->findAll($criteria_product_att);
            $id_attributes = $temp = $array0 = array();
            $array = new CMap();
            foreach ($Product_attribute as $value):
                $criteria = new CDbCriteria();
                $criteria->condition = "id_product_attribute=$value->id_product_attribute";
                $ProductAttributeCombinations = ProductAttributeCombination::model()->findAll($criteria);
                foreach ($ProductAttributeCombinations as $ProductAttributeCombination):
                    if (!in_array($ProductAttributeCombination->id_attribute, $array0)):
                        $array0[] = $ProductAttributeCombination->id_attribute;
                    endif;
                endforeach;
                $flag = true;
                foreach ($maps as $item) {
                    if (!in_array($item, $array0)) {
                        $flag = false;
                    }
                }
                if ($flag) {
                    //$array= $value->id_product_attribute;
                    $array->mergeWith($array0);
                }
                $array0 = array();
            endforeach;
            foreach ($array as $value):
                $id_attributes[] = $value;
            endforeach;
            $id_attributess = implode(',', $id_attributes);
            $criteria0 = new CDbCriteria();
            $criteria0->condition = "id_attribute in($id_attributess)";
            $attributes = Attribute::model()->findAll($criteria0);
            foreach ($attributes as $attribute):
                if (!in_array($attribute->id_attribute_group, $temp)):
                    $temp[] = $attribute->id_attribute_group;
                endif;
            endforeach;
            //group
            $id_attribute_groups = implode(',', $temp);
            $criteria2 = new CDbCriteria();
            $criteria2->condition = "id_attribute_group in($id_attribute_groups)";
            $criteria2->order = "position asc";
            $groups = AttributeGroup::model()->findAll($criteria2);
            $this->renderpartial('_attribute', array('array' => $maps, 'model' => $model, 'groups' => $groups, 'attributes' => $attributes), FALSE, TRUE);
        }elseif ($id_att == null) {
            $temp = array();
            $criteria1 = new CDbCriteria();
            $criteria1->addCondition("id_attribute in (SELECT id_attribute FROM tbl_product_attribute_combination WHERE id_product_attribute in(SELECT id_product_attribute FROM tbl_product_attribute WHERE id_product=:id))");
            $criteria1->params = array(":id" => $id_pro);
            $criteria1->order = "position asc";
            $attributes = Attribute::model()->findAll($criteria1);
            foreach ($attributes as $attribute):
                if (!in_array($attribute->id_attribute_group, $temp)):
                    $temp[] = $attribute->id_attribute_group;
                endif;
            endforeach;
            $id_attribute_groups = implode(',', $temp);
            $criteria2 = new CDbCriteria();
            $criteria2->condition = "id_attribute_group in($id_attribute_groups)";
            $criteria2->order = "position asc";
            $groups = AttributeGroup::model()->findAll($criteria2);
            $model = $this->loadModel($id_pro);
            $maps = array();
            $this->renderpartial('_attribute', array('array' => $maps, 'model' => $model, 'groups' => $groups, 'attributes' => $attributes), FALSE, TRUE);
        }
    }

    public function actionLoadAttribute() {
        $id_att = Yii::app()->getRequest()->getParam('id_att', null);
        $id_pro = Yii::app()->getRequest()->getParam('id_pro', null);
        $criteria_product_att = new CDbCriteria();
        $criteria_product_att->with = array('tblProductAttributeCombinations');
        $criteria_product_att->compare('id_product_attribute', 'tblProductAttributeCombinations.id_product_attribute');
        $criteria_product_att->condition = "id_product=$id_pro AND tblProductAttributeCombinations.id_attribute=$id_att";
        $Product_attribute = ProductAttribute::model()->findAll($criteria_product_att);
        $dropDown = "";
        foreach ($Product_attribute as $value):
            $name = "";
            $criteria = new CDbCriteria();
            $criteria->with = array('idAttribute');
            $criteria->compare('id_attribute', 'idAttribute.id_attribute');
            $criteria->condition = "id_product_attribute=$value->id_product_attribute AND idAttribute.id_attribute_group!=2";
            $product_att = ProductAttributeCombination::model()->findAll($criteria);

            $criteria0 = new CDbCriteria();
            $criteria0->with = array('idAttribute');
            $criteria0->compare('id_attribute', 'idAttribute.id_attribute');
            $criteria0->condition = "id_product_attribute=$value->id_product_attribute AND idAttribute.id_attribute_group=2";
            $color_att = ProductAttributeCombination::model()->find($criteria0);
            if (!empty($product_att)) {
                foreach ($product_att as $values) {
                    $name.='[' . $values->idAttribute->idAttributeGroup->name . ']' . $values->idAttribute->name . ' ';
                }
            } else {
                $name = $color_att->idAttribute->name;
            }
            $dropDown.= CHtml::tag('option', array('value' => $value->id_product_attribute), CHtml::encode($name), true);
        endforeach;

        echo CJSON::encode(array(
            'dropDown' => $dropDown
        ));
    }

    public function actionBuildSearch() {
        /*
         * Building Search for news & post
         */
        setlocale(LC_CTYPE, 'vi_VN.UTF-8');
        $analyzer = new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive();
        Zend_Search_Lucene_Analysis_Analyzer::setDefault($analyzer);
        $index = new Zend_Search_Lucene(Yii::getPathOfAlias('common.build.product'), true);
        $product = Product::model()->findAll();
        foreach ($product as $row) {
            try {
                $name = PostHelper::removeVNtoEN($row->name);
            } catch (Exception $exc) {
                $name = $row->name;
            }

            try {
                $description_short = PostHelper::removeVNtoEN($row->description_short);
            } catch (Exception $exc) {
                $description_short = '';
            }
            try {
                $description = PostHelper::removeVNtoEN($row->description);
            } catch (Exception $exc) {
                $description = '';
            }
            $doc = new Zend_Search_Lucene_Document();
            $doc->addField(Zend_Search_Lucene_Field::UnIndexed('id_product', $row->id_product));

            $doc->addField(Zend_Search_Lucene_Field::Text('name', $name, 'UTF-8'));
            $doc->addField(Zend_Search_Lucene_Field::Text('name_vi', $row->name, 'UTF-8'));


            $slug = preg_replace('/_/', ' ', $row->slug);
            $doc->addField(Zend_Search_Lucene_Field::keyword('slug_vi', $slug, 'UTF-8'));

            $doc->addField(Zend_Search_Lucene_Field::text('description_short', $description_short, 'UTF-8'));

            $doc->addField(Zend_Search_Lucene_Field::text('description_short_vi', $row->description_short, 'UTF-8'));

            $doc->addField(Zend_Search_Lucene_Field::text('description', $description, 'UTF-8'));

            $doc->addField(Zend_Search_Lucene_Field::text('description_vi', $row->description, 'UTF-8'));

            $index->addDocument($doc);
        }
        $index->optimize();
        $index->commit();

        Yii::app()->user->setFlash('success', "<strong>Thành công! </strong> tạo chỉ mục cho");
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionSearch() {
        $this->layout = "//layouts/content3";
        setlocale(LC_CTYPE, 'vi_VN.UTF-8');
        if (isset($_SERVER['HTTP_REFERER'])):
            $url = $_SERVER['HTTP_REFERER'];
            Yii::app()->request->cookies['url'] = new CHttpCookie('url', $url);
        endif;
        $Keywords = Yii::app()->getRequest()->getParam('search', null);
        $id_category = Yii::app()->getRequest()->getParam('category', null);
        $from = Yii::app()->getRequest()->getParam('from', null);
        $to = Yii::app()->getRequest()->getParam('to', null);
        $id_tag = Yii::app()->getRequest()->getParam('tag', null);
        $condition = Yii::app()->getRequest()->getParam('condition', null);
        $words = array_map('trim', preg_split('/ /', strtolower($Keywords), NULL, PREG_SPLIT_NO_EMPTY));
        $otherwords = array_map('trim', preg_split('/ /', PostHelper::ChangeVNtoEN(strtolower($Keywords)), NULL, PREG_SPLIT_NO_EMPTY));

        // lấy tag
        $keyen = PostHelper::ChangeVNtoEN(strtolower($Keywords));
        $criteriaa = new CDbCriteria();
        $criteriaa->with = array('tblProducts');
        $criteriaa->condition = "name like :key or name_en like :keyen";
        $criteriaa->params = array(':key' => "%$Keywords%", ":keyen" => "%$keyen%");
        $criteriaa->order = "frequency desc";
        $criteriaa->limit = 100;
        $tag = Tag::model()->findAll($criteriaa);

        $tags = ProductTag::model()->findAllByAttributes(array('id_tag' => $id_tag));
        $temps = array();
        foreach ($tags as $value) {
            $temps[] = $value->id_product;
        }
        foreach ($otherwords as $word) {
            if (!in_array($word, $words))
                $words[] = $word;
        }
        foreach ($words as $key => $value) {
            if (strlen($value) <= 2)
                unset($words[$key]);
        }

        if (($words != null) && !empty($words)) {
            Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('utf-8');
            Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());
            Zend_Search_Lucene::setResultSetLimit(10);
            $index = Zend_Search_Lucene::open(Yii::getPathOfAlias('common.build.product'));

            $query = new Zend_Search_Lucene_Search_Query_Boolean();
            $subquery1 = new Zend_Search_Lucene_Search_Query_MultiTerm();
            foreach ($words as $word) {
                $subquery1->addTerm(new Zend_Search_Lucene_Index_Term($word));
            }

            $subquery2a = new Zend_Search_Lucene_Search_Query_MultiTerm();
            foreach ($words as $word) {
                $word1 = $word;
                $subquery2a->addTerm(new Zend_Search_Lucene_Index_Term($word1, 'name'));
                $subquery2a->addTerm(new Zend_Search_Lucene_Index_Term($word1, 'slug_vi'));
                $subquery2a->addTerm(new Zend_Search_Lucene_Index_Term($word1, 'description_short'));
                $subquery2a->addTerm(new Zend_Search_Lucene_Index_Term($word1, 'description'));
            }

            $subquery2b = new Zend_Search_Lucene_Search_Query_MultiTerm();
            foreach ($words as $word) {
                $subquery2b->addTerm(new Zend_Search_Lucene_Index_Term($word, 'name_vi'));
                $subquery2b->addTerm(new Zend_Search_Lucene_Index_Term($word, 'slug_vi'));
                $subquery2b->addTerm(new Zend_Search_Lucene_Index_Term($word, 'description_short_vi'));
                $subquery2b->addTerm(new Zend_Search_Lucene_Index_Term($word, 'description_vi'));
            }
            $query->addSubquery($subquery1);
            $query->addSubquery($subquery2a);
            $query->addSubquery($subquery2b);
            try {
                $query = Zend_Search_Lucene_Search_QueryParser::parse($query, 'UTF-8');
                $results = $index->find($query);
                if (!empty($results)) {
                    $categorys = array();
                    $temp = array();
                    if (isset($id_category) && $id_category != null) {
                        $temp0 = $category = array();
                        $temp0[] = $id_category;
                        $this->LoadMenu($id_category, $category);
                        foreach ($category as $value):
                            $temp0[] = $value->id_category;
                        endforeach;
                        $str_idcategory = implode(',', $temp0);
                        foreach ($results as $values) {
                            $temp[] = $values->id_product;
                        }
                        $string = implode(",", $temp);
                        $criteria = new CDbCriteria();
                        $criteria->condition = "id_product in($string) AND id_category_default in($str_idcategory) AND active=1";
                        $criteria->order = "id_product desc";
                        $count = Product::model()->count($criteria);
                        $pages = new CPagination($count);
                        $pages->pageSize = 32;
                        $pages->pageVar = "pageseach_cate";
                        $currentAction_cate = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
                        if (Yii::app()->user->hasState('currentAction_cate')) {
                            if ($currentAction_cate != Yii::app()->user->getState('currentAction_cate')) {
                                Yii::app()->user->setState('currentAction_cate', $currentAction_cate);
                                if (Yii::app()->user->hasState('currentPages_cate')) {
                                    Yii::app()->user->setState('currentPages_cate', 0);
                                }
                            }
                        } else {
                            Yii::app()->user->setState('currentAction_cate', $currentAction_cate);
                        }
                        if (Yii::app()->request->isAjaxRequest && isset($_GET['pageseach_cate'])) {
                            $currentPage = $_GET['pageseach_cate'] - 1;
                            Yii::app()->user->setState('currentPages_cate', $currentPage);
                        }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pageseach_cate'])) {
                            Yii::app()->user->setState('currentPages_cate', 0);
                        } else if (Yii::app()->user->hasState('currentPages_cate')) {
                            $pages->setCurrentPage(Yii::app()->user->getState('currentPages_cate'));
                        }
                        $pages->applyLimit($criteria);
                        $data = Product::model()->findAll($criteria);
                        foreach ($data as $model):
                            if ($model->id_category_default != $id_category):
                                if (isset($categorys[$model->id_category_default])) {
                                    $categorys[$model->id_category_default] = $categorys[$model->id_category_default] + 1;
                                } else {
                                    $categorys[$model->id_category_default] = 1;
                                }
                            endif;
                        endforeach;
                        $category_default = $category_defaults = array();
                        foreach ($categorys as $key => $value):
                            $category = null;
                            $this->LoadParent($key, $category);
                            $category_default['category'] = $category;
                            $category_default['total'] = $value;
                            $category_defaults[] = $category_default;
                        endforeach;
                        $id_categorys = array();
                        foreach ($category_defaults as $value):
                            if (!isset($id_categorys[$value['category']->id_category])) {
                                $id_categorys[$value['category']->id_category] = $value['total'];
                            } else {
                                $id_categorys[$value['category']->id_category] = $id_categorys[$value['category']->id_category] + $value['total'];
                            }
                        endforeach;
                        $this->render('search', array("tag" => $tag, 'id_categorys' => $id_categorys, "category" => $categorys, "id_category" => $id_category, "data" => $data, 'key' => $Keywords, 'pages' => $pages));
                    }if (isset($id_tag) && $id_tag != null) {
                        foreach ($results as $values) {
                            $temp[] = $values->id_product;
                        }
                        foreach ($temps as $value1) {
                            if (!isset($temp[$value1])) {
                                $temp[] = $value1;
                            }
                        }
                        $string = implode(",", $temp);
                        $criteria = new CDbCriteria();
                        $criteria->condition = "id_product in($string) AND active=1";
                        $criteria->order = "id_product desc";
                        $count = Product::model()->count($criteria);
                        $pages = new CPagination($count);
                        $pages->pageSize = 32;
                        $pages->pageVar = "pageseach_cate";
                        $currentAction_cate = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
                        if (Yii::app()->user->hasState('currentAction_cate')) {
                            if ($currentAction_cate != Yii::app()->user->getState('currentAction_cate')) {
                                Yii::app()->user->setState('currentAction_cate', $currentAction_cate);
                                if (Yii::app()->user->hasState('currentPages_cate')) {
                                    Yii::app()->user->setState('currentPages_cate', 0);
                                }
                            }
                        } else {
                            Yii::app()->user->setState('currentAction_cate', $currentAction_cate);
                        }
                        if (Yii::app()->request->isAjaxRequest && isset($_GET['pageseach_cate'])) {
                            $currentPage = $_GET['pageseach_cate'] - 1;
                            Yii::app()->user->setState('currentPages_cate', $currentPage);
                        }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pageseach_cate'])) {
                            Yii::app()->user->setState('currentPages_cate', 0);
                        } else if (Yii::app()->user->hasState('currentPages_cate')) {
                            $pages->setCurrentPage(Yii::app()->user->getState('currentPages_cate'));
                        }
                        $pages->applyLimit($criteria);
                        $data = Product::model()->findAll($criteria);
                        foreach ($data as $model):
                            if (isset($categorys[$model->id_category_default])) {
                                $categorys[$model->id_category_default] = $categorys[$model->id_category_default] + 1;
                            } else {
                                $categorys[$model->id_category_default] = 1;
                            }
                        endforeach;
                        $category_default = $category_defaults = array();
                        foreach ($categorys as $key => $value):
                            $category = null;
                            $this->LoadParent($key, $category);
                            $category_default['category'] = $category;
                            $category_default['total'] = $value;
                            $category_defaults[] = $category_default;
                        endforeach;
                        $id_categorys = array();
                        foreach ($category_defaults as $value):
                            if (!isset($id_categorys[$value['category']->id_category])) {
                                $id_categorys[$value['category']->id_category] = $value['total'];
                            } else {
                                $id_categorys[$value['category']->id_category] = $id_categorys[$value['category']->id_category] + $value['total'];
                            }
                        endforeach;
                        $this->render('search', array("tag" => $tag, 'id_categorys' => $id_categorys, "category" => $categorys, "id_category" => $id_category, "data" => $data, 'key' => $Keywords, 'pages' => $pages));
                    } else {
                        foreach ($results as $values) {
                            $temp[] = $values->id_product;
                        }
                        $string = implode(",", $temp);
                        $criteria = new CDbCriteria();
                        $criteria->condition = "id_product in($string) AND active=1";
                        if (isset($from) && $from != null && isset($to) && $to != null) {
                            $criteria->addCondition("price BETWEEN $from AND $to");
                        }
                        if (isset($condition) && $condition != null) {
                            $criteria->addCondition("t.condition=:condition");
                            $criteria->params = array(":condition" => $condition);
                        }
                        $criteria->order = "id_product desc";
                        $count = Product::model()->count($criteria);
                        $pages = new CPagination($count);
                        $pages->pageSize = 32;
                        $pages->pageVar = "pageseach";
                        $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
                        if (Yii::app()->user->hasState('currentAction')) {
                            if ($currentAction != Yii::app()->user->getState('currentAction')) {
                                Yii::app()->user->setState('currentAction', $currentAction);
                                if (Yii::app()->user->hasState('currentPages')) {
                                    Yii::app()->user->setState('currentPages', 0);
                                }
                            }
                        } else {
                            Yii::app()->user->setState('currentAction', $currentAction);
                        }
                        if (Yii::app()->request->isAjaxRequest && isset($_GET['pageseach'])) {
                            $currentPage = $_GET['pageseach'] - 1;
                            Yii::app()->user->setState('currentPages', $currentPage);
                        }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pageseach'])) {
                            Yii::app()->user->setState('currentPages', 0);
                        } else if (Yii::app()->user->hasState('currentPages')) {
                            $pages->setCurrentPage(Yii::app()->user->getState('currentPages'));
                        }
                        $pages->applyLimit($criteria);
                        $data = Product::model()->findAll($criteria);
                        foreach ($data as $model):
                            if (isset($categorys[$model->id_category_default])) {
                                $categorys[$model->id_category_default] = $categorys[$model->id_category_default] + 1;
                            } else {
                                $categorys[$model->id_category_default] = 1;
                            }
                        endforeach;
                        $category_default = $category_defaults = array();
                        foreach ($categorys as $key => $value):
                            $category = null;
                            $this->LoadParent($key, $category);
                            $category_default['category'] = $category;
                            $category_default['total'] = $value;
                            $category_defaults[] = $category_default;
                        endforeach;
                        $id_categorys = array();
                        foreach ($category_defaults as $value):
                            if (!isset($id_categorys[$value['category']->id_category])) {
                                $id_categorys[$value['category']->id_category] = $value['total'];
                            } else {
                                $id_categorys[$value['category']->id_category] = $id_categorys[$value['category']->id_category] + $value['total'];
                            }
                        endforeach;
                        $this->render('search', array("tag" => $tag, 'id_categorys' => $id_categorys, "category" => $categorys, "id_category" => $id_category, "data" => $data, 'key' => $Keywords, 'pages' => $pages));
                    }
                } else {
                    $error = "<strong> $Keywords: không tìm thấy! </strong> ";
                    $this->render('erro_search', array('error' => $error));
                }
            } catch (Zend_Search_Lucene_Search_QueryParserException $e) {
                $this->redirect(Yii::app()->homeUrl);
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    public function actionView_Menu() {
        $this->layout = "//layouts/content4";
        if (isset($_SERVER['HTTP_REFERER'])):
            $url = $_SERVER['HTTP_REFERER'];
            Yii::app()->request->cookies['url'] = new CHttpCookie('url', $url);
        endif;
        $model1 = Configuration::model()->findByPk(7);
        $model2 = Configuration::model()->findByPk(8);
        $model3 = Configuration::model()->findByPk(9);
        $price = explode(',', $model2->value);
        if (isset($_GET['cate_default']) && $_GET['cate_default'] != NULL) {
            $id = $_GET['cate_default'];
            $parent = array();
            $this->LoadMenuParent($id, $parent);
            krsort($parent);
            $child = array();
            $this->LoadMenu($id, $child);
            $item = array();
            $item[] = $id;
            foreach ($child as $value) {
                $item[] = $value->id_category;
            }
            $str = implode(",", $item);
            $category_name = Category::model()->findByPk($id);
            $criteria = new CDbCriteria();
            $criteria->addCondition("id_category_default in ($str) AND active=1 OR id_product in(select id_product from tbl_category_product where id_category in($str) AND active=1)");
            if (isset($_GET['soft'])) {
                $key = preg_replace("/[^a-zA-Z0-9-]/", '', $_GET['soft']);
                if ($key == "product") {
                    $criteria->order = "id_product desc";
                }if ($key === 'priceasc') {
                    $criteria->order = "price asc";
                }if ($key == "pricedesc") {
                    $criteria->order = "price desc";
                }
                if ($key == 7) {
                    $criteria->addCondition("price>=$model1->value");
                    $criteria->order = 'id_product desc';
                }
                if ($key == 8) {
                    $criteria->addCondition("price BETWEEN $price[0] AND $price[1]");
                    $criteria->order = 'id_product desc';
                } elseif ($key == 9) {
                    $criteria->addCondition("price<=$model3->value");
                    $criteria->order = 'id_product desc';
                }
            } else {
                $criteria->order = 'id_product desc';
            }
            //
            if (isset($_GET['attributes']) && $_GET['attributes'] != null) {
                $id_attributes = $_GET['attributes'];
                $criteria->addCondition("id_product in(SELECT id_product FROM tbl_product_attribute WHERE id_product_attribute IN(SELECT id_product_attribute FROM tbl_product_attribute_combination WHERE id_attribute IN($id_attributes)))");
            }
            $count = Product::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 20;
            $pages->pageVar = "page_menu";
            $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
            if (Yii::app()->user->hasState('currentAction')) {
                if ($currentAction != Yii::app()->user->getState('currentAction')) {

                    Yii::app()->user->setState('currentAction', $currentAction);
                    if (Yii::app()->user->hasState('currentPages')) {
                        Yii::app()->user->setState('currentPages', 0);
                    }
                }
            } else {
                Yii::app()->user->setState('currentAction', $currentAction);
            }
            if (Yii::app()->request->isAjaxRequest && isset($_GET['page_menu'])) {
                $currentPage = $_GET['page_menu'] - 1;
                Yii::app()->user->setState('currentPages', $currentPage);
            }if (Yii::app()->request->isAjaxRequest && !isset($_GET['page_menu'])) {
                Yii::app()->user->setState('currentPages', 0);
            } else if (Yii::app()->user->hasState('currentPages')) {
                $pages->setCurrentPage(Yii::app()->user->getState('currentPages'));
            }

            $pages->applyLimit($criteria);
            $models = Product::model()->findAll($criteria);

            //lấy dac trưng sản phẩm
            $id_attribute_groups = array();
            foreach ($models as $value):
                $product_attributes = ProductAttribute::model()->findAllByAttributes(array('id_product' => $value->id_product));
                foreach ($product_attributes as $product_attribute):
                    $product_attribute_combinations = ProductAttributeCombination::model()->findAllByAttributes(array('id_product_attribute' => $product_attribute->id_product_attribute));
                    foreach ($product_attribute_combinations as $product_attribute_combination):
                        $attributes = Attribute::model()->findAllByAttributes(array('id_attribute' => $product_attribute_combination->id_attribute));
                        foreach ($attributes as $attribute):
                            if (!in_array($attribute->id_attribute_group, $id_attribute_groups)):
                                $id_attribute_groups[] = $attribute->id_attribute_group;
                            endif;
                        endforeach;
                    endforeach;
                endforeach;
            endforeach;
            $str_id_attribute_groups = implode(',', $id_attribute_groups);
            if ($str_id_attribute_groups != '') {
                $criteria1 = new CDbCriteria();
                $criteria1->condition = "id_attribute_group in($str_id_attribute_groups)";
                $groups = AttributeGroup::model()->findAll($criteria1);
            } else {
                $groups = AttributeGroup::model()->findAll();
            }
            $this->render('View_Product_menu', array(
                'models' => $models,
                'category' => $category_name,
                'pages' => $pages,
                'parent' => $parent,
                'child' => $child,
                'model1' => $model1,
                'model2' => $model2,
                'model3' => $model3,
                'groups' => $groups
            ));
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    public function actionIndex() {
        $this->layout = "//layouts/content4";
        if (isset($_SERVER['HTTP_REFERER'])):
            $url = $_SERVER['HTTP_REFERER'];
            Yii::app()->request->cookies['url'] = new CHttpCookie('url', $url);
        endif;
        $model1 = Configuration::model()->findByPk(7);
        $model2 = Configuration::model()->findByPk(8);
        $model3 = Configuration::model()->findByPk(9);
        $price = explode(',', $model2->value);
        $criteria = new CDbCriteria();
        $criteria->condition = "t.condition='new' AND active=1";
        if (isset($_GET['soft'])) {
            $key = preg_replace("/[^a-zA-Z0-9-]/", '', $_GET['soft']);
            if ($key == "product") {
                $criteria->order = "id_product desc";
            }if ($key === 'priceasc') {
                $criteria->order = "price asc";
            }if ($key == "pricedesc") {
                $criteria->order = "price desc";
            }if ($key == 7) {
                $criteria->addCondition("price>=$model1->value");
                $criteria->order = 'id_product desc';
            }
            if ($key == 8) {
                $criteria->addCondition("price BETWEEN $price[0] AND $price[1]");
                $criteria->order = 'id_product desc';
            } elseif ($key == 9) {
                $criteria->addCondition("price<=$model3->value");
                $criteria->order = 'id_product desc';
            }
        } else {
            $criteria->order = 'id_product desc';
        }
        $item_count = Product::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = 20;
        $pages->pageVar = "pagepro";
        $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
        if (Yii::app()->user->hasState('currentAction')) {
            if ($currentAction != Yii::app()->user->getState('currentAction')) {

                Yii::app()->user->setState('currentAction', $currentAction);
                if (Yii::app()->user->hasState('currentPages')) {
                    Yii::app()->user->setState('currentPages', 0);
                }
            }
        } else {
            Yii::app()->user->setState('currentAction', $currentAction);
        }
        if (Yii::app()->request->isAjaxRequest && isset($_GET['pagepro'])) {
            $currentPage = $_GET['pagepro'] - 1;
            Yii::app()->user->setState('currentPages', $currentPage);
        }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pagepro'])) {
            Yii::app()->user->setState('currentPages', 0);
        } else if (Yii::app()->user->hasState('currentPages')) {
            $pages->setCurrentPage(Yii::app()->user->getState('currentPages'));
        }


        $pages->applyLimit($criteria);
        $data = Product::model()->findAll($criteria);

        $criteria_id = new CDbCriteria();
        $criteria_id->select = "id_product";
        $criteria_id->group = "id_product";
        $criteria_id->order = "COUNT(1) DESC";
        $id_pro = Customization::model()->findAll($criteria_id);
        $item = array();
        foreach ($id_pro as $value) {
            $item[] = $value->id_product;
        }
        $str = implode(",", $item);
        if ($str != "") {
            $criteria = new CDbCriteria();
            $criteria->condition = "id_product in ($str) AND active=1";
            $item_count = Product::model()->count($criteria);
            $pages_hot = new CPagination($item_count);
            $pages_hot->pageSize = 20;
            $pages_hot->pageVar = "pagehot";

            $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
            if (Yii::app()->user->hasState('currentAction')) {
                if ($currentAction != Yii::app()->user->getState('currentAction')) {

                    Yii::app()->user->setState('currentAction', $currentAction);
                    if (Yii::app()->user->hasState('currentPages_hot')) {
                        Yii::app()->user->setState('currentPages_hot', 0);
                    }
                }
            } else {
                Yii::app()->user->setState('currentAction', $currentAction);
            }
            if (Yii::app()->request->isAjaxRequest && isset($_GET['pagehot'])) {
                $currentPage = $_GET['pagehot'] - 1;
                Yii::app()->user->setState('currentPages_hot', $currentPage);
            }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pagehot'])) {
                Yii::app()->user->setState('currentPages_hot', 0);
            } else if (Yii::app()->user->hasState('currentPages_hot')) {
                $pages_hot->setCurrentPage(Yii::app()->user->getState('currentPages_hot'));
            }
            $pages_hot->applyLimit($criteria);
            $data_hot = Product::model()->findAll($criteria);
        }
        $this->render("index", array(
            "data" => $data,
            "pages" => $pages,
            'data_hot' => isset($data_hot) ? $data_hot : null,
            'pages_hot' => isset($pages_hot) ? $pages_hot : null,
            'model1' => $model1,
            'model2' => $model2,
            'model3' => $model3,
        ));
    }

    public function actionView($id) {
        $this->layout = "//layouts/content3";
        $modeltheard = new CustomerThread();
        $model1 = new CustomerMessage("requestByCustomer");
        $total_percent = 0;
        $total_rate = 0;
        $ListImages = array();
        $cookie = array();
        $model = $this->loadModel($id);
        $price = $model->price;
        if (isset($_SERVER['HTTP_REFERER'])):
            $url = $_SERVER['HTTP_REFERER'];
            Yii::app()->request->cookies['url'] = new CHttpCookie('url', $url);
        endif;
        //lưu sản phẩm xuống cookie
        if (!isset(Yii::app()->request->cookies['cookie'])) {
            $cookie[] = $id;
            Yii::app()->request->cookies['cookie'] = new CHttpCookie('cookie', serialize($cookie));
        } else {
            $cookie = unserialize(Yii::app()->request->cookies['cookie']->value);
            if (!in_array($id, $cookie)):
                $cookie[] = $id;
                Yii::app()->request->cookies['cookie'] = new CHttpCookie('cookie', serialize($cookie));
            endif;
        }
        // lấy toàn bộ hình ảnh
        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->condition = 'id_product=' . $id;
        $images = Image::model()->findAll($criteria);
        if (!empty($images)) {
            foreach ($images as $image) {
                $img = ImageHelper::FindImageByPk(Image::TYPE, $image->id_image);
                if ($img != NULL) {
                    $ListImages[] = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Image::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($image->name, Image::TYPE, "640x480"));
                } else {
                    $ListImages[] = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
                }
            }
        } else {
            $ListImages[] = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
        }

        // lấy sản phầm cùng loại
        $criteria_pr = new CDbCriteria();
        $criteria_pr->condition = 'id_category_default=:id_category AND id_product!=:id_pr AND active=1 ';
        $criteria_pr->params = array(':id_category' => $model->id_category_default, ':id_pr' => $id);
        $count = Product::model()->count($criteria_pr);
        $pages = new CPagination($count);
        $pages->pageSize = 9;
        $pages->pageVar = "pageSam";
        $currentAction_sam = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
        if (Yii::app()->user->hasState('currentAction')) {
            if ($currentAction_sam != Yii::app()->user->getState('currentAction')) {

                Yii::app()->user->setState('currentAction', $currentAction_sam);
                if (Yii::app()->user->hasState('currentPages_sam')) {
                    Yii::app()->user->setState('currentPages_sam', 0);
                }
            }
        } else {
            Yii::app()->user->setState('currentAction', $currentAction_sam);
        }
        if (Yii::app()->request->isAjaxRequest && isset($_GET['pageSam'])) {
            $currentPage_sam = $_GET['pageSam'] - 1;
            Yii::app()->user->setState('currentPages_sam', $currentPage_sam);
        }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pageSam'])) {
            Yii::app()->user->setState('currentPages_sam', 0);
        } else if (Yii::app()->user->hasState('currentPages_sam')) {
            $pages->setCurrentPage(Yii::app()->user->getState('currentPages_sam'));
        }
        $pages->applyLimit($criteria_pr);
        $product_similar = Product::model()->findAll($criteria_pr);

        //lấy thuộc tính
        $temp = array();
        $criteria1 = new CDbCriteria();
        $criteria1->addCondition("id_attribute in (SELECT id_attribute FROM tbl_product_attribute_combination WHERE id_product_attribute in(SELECT id_product_attribute FROM tbl_product_attribute WHERE id_product=:id))");
        $criteria1->params = array(":id" => $id);
        $criteria1->order = "position asc";
        if ($attributes = Attribute::model()->findAll($criteria1)):
            foreach ($attributes as $attribute):
                if (!in_array($attribute->id_attribute_group, $temp)):
                    $temp[] = $attribute->id_attribute_group;
                endif;
            endforeach;
            $id_attribute_groups = implode(',', $temp);
            $criteria2 = new CDbCriteria();
            $criteria2->condition = "id_attribute_group in($id_attribute_groups)";
            $criteria2->order = "position asc";
            $groups = AttributeGroup::model()->findAll($criteria2);
        endif;
        // lấy giá khuyến mãi
        $date = date('Y-m-d H:i:s');
        $criteria_spe = new CDbCriteria();
        $criteria_spe->condition = "t.to>='$date' AND t.from<='$date'";
        $spe = SpecificPriceRule::model()->findAll($criteria_spe);
        $item = array();
        foreach ($spe as $value_spe) {
            $item[] = $value_spe->id_specific_price_rule;
        }
        $str = implode(",", $item);
        if ($str != '') {
            $criteria_hot = new CDbCriteria();
            $criteria_hot->distinct = true;
            $criteria_hot->addCondition('id_product=:id AND id_specific_price_rule in(' . $str . ')');
            $criteria_hot->params = array(':id' => $id);
            $hot_deal = ProductHotDeal::model()->find($criteria_hot);
            if (!empty($hot_deal)) {
                $price_hot = $hot_deal->price;
            } else {
                $price_hot = $model->unit_price_ratio;
            }
        } else {
            $price_hot = $model->unit_price_ratio;
        }
        // nhà cung cấp
        $supplier = Supplier::model()->findByPk($model->id_supplier_default);
        // bình chọn
        $rate = Rate::model()->findByPk($id);
        if (!empty($rate)) {
            $total_rate = $rate->total_rate;
            $avg = $rate->level / $total_rate;
            $total_percent = ($avg / $rate->level_max) * 100;
        }
        //sản phẩm khuyến khích mua
        $criteria_ary = new CDbCriteria();
        $criteria_ary->condition = 'id_product_1=:id';
        $criteria_ary->params = array(':id' => $id);
        $accessry = Accessory::model()->findAll($criteria_ary);
        $item1 = array();
        foreach ($accessry as $value) {
            $item1[] = $value->id_product_2;
        }
        $str1 = implode(",", $item1);
        if ($str1 != "") {
            $criteria_ac = new CDbCriteria();
            $criteria_ac->condition = "id_product in (" . $str1 . ") AND active=1";
            $data_accessory = Product::model()->findAll($criteria_ac);
        }
        // câu hỏi
        $criteria_post = new CDbCriteria();
        $criteria_post->order = "id_post desc";
        $criteria_post->condition = "status=:stt AND categories=:cate";
        $criteria_post->params = array(':stt' => 'PUBLISHED', ':cate' => 'QUESTION');
        $item_post = Post::model()->count($criteria_post);
        $pages_post = new CPagination($item_post);
        $pages_post->pageSize = 9;
        $pages_post->pageVar = "pagePost";

        $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
        if (Yii::app()->user->hasState('currentAction')) {
            if ($currentAction != Yii::app()->user->getState('currentAction')) {

                Yii::app()->user->setState('currentAction', $currentAction);
                if (Yii::app()->user->hasState('currentPages_post')) {
                    Yii::app()->user->setState('currentPages_post', 0);
                }
            }
        } else {
            Yii::app()->user->setState('currentAction', $currentAction);
        }
        if (Yii::app()->request->isAjaxRequest && isset($_GET['pagePost'])) {
            $currentPage = $_GET['pagePost'] - 1;
            Yii::app()->user->setState('currentPages_post', $currentPage);
        }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pagePost'])) {
            Yii::app()->user->setState('currentPages_post', 0);
        } else if (Yii::app()->user->hasState('currentPages_post')) {
            $pages_post->setCurrentPage(Yii::app()->user->getState('currentPages_post'));
        }
        $pages_post->applyLimit($criteria_post);
        $post = Post::model()->findAll($criteria_post);

        //comemt

        $dataProvider = CustomerThread::model()->findAllByAttributes(array('id_product' => $id));
        $list_message = array();
        $item0 = array();
        foreach ($dataProvider as $value) {
            $item0[] = $value->id_customer_thread;
        }
        $str0 = implode(',', $item0);
        if (!empty($str0)) {
            $criteria = new CDbCriteria();
            $criteria->condition = "id_customer_thread in($str0) AND id_user is NULL";
            $criteria->order = "date_add desc";
            $count = CustomerMessage::model()->count($criteria);
            $pages_comment = new CPagination($count);
            $pages_comment->pageSize = 18;
            $pages_comment->pageVar = "pagecomment";
            $currentAction_comment = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
            if (Yii::app()->user->hasState('currentAction')) {
                if ($currentAction_comment != Yii::app()->user->getState('currentAction')) {

                    Yii::app()->user->setState('currentAction', $currentAction_comment);
                    if (Yii::app()->user->hasState('currentPages_comment')) {
                        Yii::app()->user->setState('currentPages_comment', 0);
                    }
                }
            } else {
                Yii::app()->user->setState('currentAction', $currentAction_comment);
            }
            if (Yii::app()->request->isAjaxRequest && isset($_GET['pagecomment'])) {
                $currentPage_comment = $_GET['pagecomment'] - 1;
                Yii::app()->user->setState('currentPages_comment', $currentPage_comment);
            }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pagecomment'])) {
                Yii::app()->user->setState('currentPages_comment', 0);
            } else if (Yii::app()->user->hasState('currentPages_comment')) {
                $pages_comment->setCurrentPage(Yii::app()->user->getState('currentPages_comment'));
            }
            $pages_comment->applyLimit($criteria);
            $Message = CustomerMessage::model()->findAll($criteria);
            foreach ($Message as $value1) {
                $list_message[] = $value1;
            }
        }
        Yii::app()->getController()->createAction('captcha')->getVerifyCode(true);
        $total = ProductHelper::totalproduct($model);
        $this->render('view', array(
            'model' => $model,
            'price' => $price,
            'price_hot' => $price_hot,
            'images' => $ListImages,
            'groups' => isset($groups) ? $groups : array(),
            'attributes' => $attributes,
            'product_similar' => isset($product_similar) ? $product_similar : null,
            'pages' => $pages,
            'supp' => $supplier,
            'total_rate' => $total_rate,
            'total_percent' => $total_percent,
            'data_accessory' => isset($data_accessory) ? $data_accessory : null,
            'post' => $post,
            'pages_post' => $pages_post,
            'data_comment' => $list_message,
            'pages_comment' => isset($pages_comment) ? $pages_comment : null,
            'model1' => $model1,
            'modeltheard' => $modeltheard,
            'total' => $total,
        ));
    }

    public function actionDeletecart() {
        if (Yii::app()->request->isAjaxRequest) {
            $key = Yii::app()->getRequest()->getParam('key', null);
            $cart = Yii::app()->session['cart'];
            unset($cart[$key]);
            Yii::app()->session['cart'] = $cart;
            $data = isset(Yii::app()->session['cart']) ? Yii::app()->session['cart'] : null;
            $data_cart_pack = isset(Yii::app()->session['cart_pack']) ? Yii::app()->session['cart_pack'] : null;
            $this->renderpartial("_viewcart", array('data' => Yii::app()->session['cart'], 'data_cart_pack' => $data_cart_pack), FALSE, true);
            Yii::app()->end();
        }
    }

    public function actionGetcart() {
        if (Yii::app()->request->isAjaxRequest) {
            $count = 0;
            $array1 = isset(Yii::app()->session['cart']) ? Yii::app()->session['cart'] : null;
            $array2 = isset(Yii::app()->session['cart_pack']) ? Yii::app()->session['cart_pack'] : null;
            $count = count($array1) + count($array2);
            echo $count;
            Yii::app()->end();
        }
    }

    public function actionDeletePack() {
        if (Yii::app()->request->isAjaxRequest) {
            $id_pack = Yii::app()->getRequest()->getParam('key', null);
            $cart = Yii::app()->session['cart_pack'];
            unset($cart[$id_pack]);
            Yii::app()->session['cart_pack'] = $cart;
            $data = isset(Yii::app()->session['cart']) ? Yii::app()->session['cart'] : null;
            $data_cart_pack = $cart;
            $this->renderpartial("_viewcart", array('data' => Yii::app()->session['cart'], 'data_cart_pack' => $data_cart_pack), FALSE, true);
            Yii::app()->end();
        }
    }

    public function actionEditcart() {
        if (Yii::app()->request->isAjaxRequest) {
            $key = Yii::app()->getRequest()->getParam('key', null);
            $quannty = Yii::app()->getRequest()->getParam('quannty', null);
            $cart = Yii::app()->session['cart'];
            $cart[$key]['soluong'] = $quannty;
            Yii::app()->session['cart'] = $cart;
            $data = isset(Yii::app()->session['cart']) ? Yii::app()->session['cart'] : null;
            $data_cart_pack = isset(Yii::app()->session['cart_pack']) ? Yii::app()->session['cart_pack'] : null;
            $this->renderpartial("_viewcart", array('data' => Yii::app()->session['cart'], 'data_cart_pack' => $data_cart_pack), FALSE, true);
            Yii::app()->end();
        }
    }

    public function actionAddCart() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->getRequest()->getParam('id_pro', null);
            $id_att = Yii::app()->getRequest()->getParam('att', null);

            $quanty = Yii::app()->getRequest()->getParam('quannty', null);
            $date = date('Y-m-d H:i:s');
            if (!isset(Yii::app()->session['cart'])) {
                Yii::app()->session['cart'] = array();
            }
            $array = array();
            if ($id_att != null) {
                $maps = explode(',', $id_att);
                $Product_attribute = ProductAttribute::model()->findAllByAttributes(array('id_product' => $id));
                foreach ($Product_attribute as $value):
                    $criteria = new CDbCriteria();
                    $criteria->condition = "id_product_attribute=$value->id_product_attribute";
                    $ProductAttributeCombinations = ProductAttributeCombination::model()->findAll($criteria);
                    foreach ($ProductAttributeCombinations as $ProductAttributeCombination):
                        if (!in_array($ProductAttributeCombination->id_attribute, $array)):
                            $array[] = $ProductAttributeCombination->id_attribute;
                        endif;
                    endforeach;
                    $flag = true;
                    foreach ($maps as $item) {
                        if (!in_array($item, $array)) {
                            $flag = false;
                        }
                    }
                    if ($flag) {
                        $product_att = ProductAttribute::model()->findByPk($value->id_product_attribute);
                    }
                    $array = array();
                endforeach;
            }
            $model = Product::model()->findByPk($id);
            /// lấy thông tin của giá bán $price_hot
            if (isset($product_att) && !empty($product_att)) {
                $criteria_spe = new CDbCriteria();
                $criteria_spe->condition = "t.to>='$date' AND t.from<='$date'";
                $spe = SpecificPriceRule::model()->findAll($criteria_spe);
                $item = array();
                foreach ($spe as $value_spe) {
                    $item[] = $value_spe->id_specific_price_rule;
                }
                $str = implode(",", $item);
                if ($str != "") {
                    $criteria_hot = new CDbCriteria();
                    $criteria_hot->addCondition('id_product=:id_pro AND id_product_attribute=:id_att AND id_specific_price_rule in(' . $str . ')');
                    $criteria_hot->params = array(':id_pro' => $id, ':id_att' => $product_att->id_product_attribute);
                    $hot_deal = ProductHotDeal::model()->find($criteria_hot);
                    if (!empty($hot_deal)) {
                        $price_hot = $hot_deal->price;
                    } else {
                        $price_hot = $product_att->price;
                    }
                } else {
                    $price_hot = $product_att->price;
                }
            } else {

                $criteria_spe = new CDbCriteria();
                $criteria_spe->condition = "t.to>='$date' AND t.from<='$date'";
                $spe = SpecificPriceRule::model()->findAll($criteria_spe);
                $item = array();
                foreach ($spe as $value_spe) {
                    $item[] = $value_spe->id_specific_price_rule;
                }
                $str = implode(",", $item);
                if ($str != "") {
                    $criteria_hot = new CDbCriteria();
                    $criteria_hot->addCondition('id_product=:id_pro AND id_specific_price_rule in(' . $str . ')');
                    $criteria_hot->params = array(':id_pro' => $id);
                    $hot_deal = ProductHotDeal::model()->find($criteria_hot);
                    if (!empty($hot_deal)) {
                        $price_hot = $hot_deal->price;
                    } else {
                        $price_hot = $model->unit_price_ratio;
                    }
                } else {
                    $price_hot = $model->unit_price_ratio;
                }
            }
            // thêm vào giỏ hàng
            $temp = array();
            if (isset($product_att) && !empty($product_att)) {
                $session = Yii::app()->session['cart'];
                $temp['id_sp'] = $id;
                $temp['soluong'] = $quanty;
                $temp['id_att'] = $product_att->id_product_attribute;
                $temp['gia'] = $price_hot;
                $session[] = $temp;
                Yii::app()->session['cart'] = $session;
            } else {
                $session = Yii::app()->session['cart'];
                $temp['id_sp'] = $id;
                $temp['soluong'] = $quanty;
                $temp['id_att'] = NULL;
                $temp['gia'] = $price_hot;
                $session[] = $temp;
                Yii::app()->session['cart'] = $session;
            }
            $total = isset(Yii::app()->session['cart_pack']) ? count(Yii::app()->session['cart_pack']) : 0;
            $data = count(Yii::app()->session['cart']) + $total;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionAddCartAuto() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->getRequest()->getParam('id_pro', null);
            $id_att = Yii::app()->getRequest()->getParam('att', null);
            $quanty = Yii::app()->getRequest()->getParam('quannty', null);
            $date = date('Y-m-d H:i:s');
            if (!isset(Yii::app()->session['cart'])) {
                Yii::app()->session['cart'] = array();
            }
            $product_att = ProductAttribute::model()->findByPk($id_att);
            /// lấy thông tin của giá bán $price_hot
            if (!empty($product_att)) {
                $criteria_spe = new CDbCriteria();
                $criteria_spe->condition = "t.to>='$date' AND t.from<='$date'";
                $spe = SpecificPriceRule::model()->findAll($criteria_spe);
                $item = array();
                foreach ($spe as $value_spe) {
                    $item[] = $value_spe->id_specific_price_rule;
                }
                $str = implode(",", $item);
                if ($str != "") {
                    $criteria_hot = new CDbCriteria();
                    $criteria_hot->addCondition('id_product=:id_pro AND id_product_attribute=:id_att AND id_specific_price_rule in(' . $str . ')');
                    $criteria_hot->params = array(':id_pro' => $id, ':id_att' => $product_att->id_product_attribute);
                    $hot_deal = ProductHotDeal::model()->find($criteria_hot);
                    if (!empty($hot_deal)) {
                        $price_hot = $hot_deal->price;
                    } else {
                        $price_hot = $product_att->price;
                    }
                } else {
                    $price_hot = $product_att->price;
                }
            } else {

                $criteria_spe = new CDbCriteria();
                $criteria_spe->condition = "t.to>='$date' AND t.from<='$date'";
                $spe = SpecificPriceRule::model()->findAll($criteria_spe);
                $item = array();
                foreach ($spe as $value_spe) {
                    $item[] = $value_spe->id_specific_price_rule;
                }
                $str = implode(",", $item);
                if ($str != "") {
                    $criteria_hot = new CDbCriteria();
                    $criteria_hot->addCondition('id_product=:id_pro AND id_specific_price_rule in(' . $str . ')');
                    $criteria_hot->params = array(':id_pro' => $id);
                    $hot_deal = ProductHotDeal::model()->find($criteria_hot);
                    if (!empty($hot_deal)) {
                        $price_hot = $hot_deal->price;
                    } else {
                        $price_hot = $model->unit_price_ratio;
                    }
                } else {
                    $price_hot = $model->unit_price_ratio;
                }
            }
            // thêm vào giỏ hàng
            $temp = array();
            $session = Yii::app()->session['cart'];
            $temp['id_sp'] = $id;
            $temp['soluong'] = $quanty;
            $temp['id_att'] = $id_att;
            $temp['gia'] = $price_hot;
            $session[] = $temp;
            Yii::app()->session['cart'] = $session;
            $total = isset(Yii::app()->session['cart_pack']) ? count(Yii::app()->session['cart_pack']) : 0;
            $data = count(Yii::app()->session['cart']) + $total;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionAddPackcart() {
        if (Yii::app()->request->isAjaxRequest) {
            $id_pack = Yii::app()->getRequest()->getParam('id_pack', null);
            $temp = array();
            if (!isset(Yii::app()->session['cart_pack'])) {
                Yii::app()->session['cart_pack'] = array();
            }
            $model = PackGroup::model()->findByPk($id_pack);
            $data = Pack::model()->findAllByAttributes(array("id_pack_group" => $id_pack));
            $data_cart = Yii::app()->session['cart_pack'];
            if (isset(Yii::app()->session['cart_pack'][$id_pack])) {
                $key = array_rand($data_cart[$id_pack]);
                $total = $data_cart[$id_pack][$key]['total_pack'] + 1;
            } else {
                $total = 1;
            }
            if ($model->reduction_type == 'percentage' && !empty($data)) {
                foreach ($data as $value) {
                    if ($value->id_product_attribute != null) {
                        $product = ProductAttribute::model()->findByPk($value->id_product_attribute);
                        $price = $product->price;
                    } else {
                        $product = Product::model()->findByPk($value->id_product);
                        $price = $product->price;
                    }

                    if (isset(Yii::app()->session['cart_pack'][$id_pack])) {
                        $session = Yii::app()->session['cart_pack'];
                        $temp['id_sp'] = $value->id_product;
                        $temp['soluong'] = $value->quantity * $total;
                        $temp['id_att'] = $value->id_product_attribute;
                        $temp['gia'] = round($price * ($model->reduction / 100), 3);
                        $temp['reduction'] = 0;
                        $temp['id_pack_group'] = $id_pack;
                        $temp['id_pack'] = $value->id_pack;
                        $temp['total_pack'] = $total;
                        $session[$id_pack][$value->id_product] = $temp;
                        Yii::app()->session['cart_pack'] = $session;
                    } else {
                        $session = Yii::app()->session['cart_pack'];
                        $temp['id_sp'] = $value->id_product;
                        $temp['soluong'] = $value->quantity * $total;
                        $temp['id_att'] = $value->id_product_attribute;
                        $temp['gia'] = round($price * ($model->reduction / 100), 3);
                        $temp['reduction'] = 0;
                        $temp['id_pack_group'] = $id_pack;
                        $temp['id_pack'] = $value->id_pack;
                        $temp['total_pack'] = $total;
                        $session[$id_pack][$value->id_product] = $temp;
                        Yii::app()->session['cart_pack'] = $session;
                    }
                }
            } elseif ($model->reduction_type == 'amount' && !empty($data)) {
                $count = 0;
                foreach ($data as $pack) {
                    $count+=$pack->quantity;
                }
                $price_sale = ($model->reduction / $count);
                foreach ($data as $value) {
                    if ($value->id_product_attribute != null) {
                        $product = ProductAttribute::model()->findByPk($value->id_product_attribute);
                        $price = $product->price;
                    } else {
                        $product = Product::model()->findByPk($value->id_product);
                        $price = $product->price;
                    }
                    if (isset(Yii::app()->session['cart_pack'][$id_pack])) {
                        $session = Yii::app()->session['cart_pack'];
                        $temp['id_sp'] = $value->id_product;
                        $temp['soluong'] = $value->quantity * $total;
                        $temp['id_att'] = $value->id_product_attribute;
                        $temp['gia'] = round(($price - $price_sale), 3);
                        $temp['reduction'] = $price_sale;
                        $temp['id_pack_group'] = $id_pack;
                        $temp['id_pack'] = $value->id_pack;
                        $temp['total_pack'] = $total;
                        $session[$id_pack][$value->id_product] = $temp;
                        Yii::app()->session['cart_pack'] = $session;
                    } else {
                        $session = Yii::app()->session['cart_pack'];
                        $temp['id_sp'] = $value->id_product;
                        $temp['soluong'] = $value->quantity * $total;
                        $temp['id_att'] = $value->id_product_attribute;
                        $temp['gia'] = round(($price - $price_sale), 3);
                        $temp['reduction'] = $price_sale;
                        $temp['id_pack_group'] = $id_pack;
                        $temp['id_pack'] = $value->id_pack;
                        $temp['total_pack'] = $total;
                        $session[$id_pack][$value->id_product] = $temp;
                        Yii::app()->session['cart_pack'] = $session;
                    }
                }
            }
            $total = isset(Yii::app()->session['cart']) ? count(Yii::app()->session['cart']) : 0;
            $data = count(Yii::app()->session['cart_pack']) + $total;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionShowPack($id) {
        if (isset($_SERVER['HTTP_REFERER'])):
            $url = $_SERVER['HTTP_REFERER'];
            Yii::app()->request->cookies['url'] = new CHttpCookie('url', $url);
        endif;
        $model = PackGroup::model()->findByPk($id);
        $data = Pack::model()->findAllByAttributes(array("id_pack_group" => $id));
        $this->render("ViewPack", array('data' => $data, 'model' => $model));
    }

    public function actionAddcomment() {

        if (Yii::app()->request->isAjaxRequest) {
            $model = new CustomerThread();
            $model1 = new CustomerMessage();
            $content = addslashes(Yii::app()->getRequest()->getParam('text', NULL));
            $id_product = Yii::app()->getRequest()->getParam('id_product', NULL);
            $captcha_text = Yii::app()->getRequest()->getParam('captcha', NULL);
            $captcha = Yii::app()->getController()->createAction("captcha");
            $product = Product::model()->findByPk($id_product);
            $code = $captcha->verifyCode;
            if ($captcha_text == $code) {
                $cus = Customer::model()->findByPk(Yii::app()->user->id);
                $model->id_product = $id_product;
                $model->id_contact = 8;
                $model->email = isset($cus->email) ? $cus->email : null;
                $model->id_customer = isset(Yii::app()->user->id) ? Yii::app()->user->id : null;
                $model->status = 'open';
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save()) {
                        $model1->id_customer_thread = $model->id_customer_thread;
                        $model1->message = $content;
                        $model1->title = "thắc mắc về sản phẩm " . $product->name . "";
                        $model1->verifyCode = $captcha_text;
                        if ($model1->save()) {
                            $dataProvider = CustomerThread::model()->findAllByAttributes(array('id_product' => $id_product));
                            $list_message = array();
                            $item = array();
                            foreach ($dataProvider as $value) {
                                $item[] = $value->id_customer_thread;
                            }
                            $str = implode(',', $item);
                            if (!empty($str)) {
                                $criteria = new CDbCriteria();
                                $criteria->condition = "id_customer_thread in($str) AND id_user is NULL";
                                $criteria->order = "date_add desc";
                                $count = CustomerMessage::model()->count($criteria);
                                $pages_comment = new CPagination($count);
                                $pages_comment->pageSize = 18;
                                $pages_comment->pageVar = "pagecomment";
                                $currentAction_comment = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
                                if (Yii::app()->user->hasState('currentAction')) {
                                    if ($currentAction_comment != Yii::app()->user->getState('currentAction')) {

                                        Yii::app()->user->setState('currentAction', $currentAction_comment);
                                        if (Yii::app()->user->hasState('currentPages_comment')) {
                                            Yii::app()->user->setState('currentPages_comment', 0);
                                        }
                                    }
                                } else {
                                    Yii::app()->user->setState('currentAction', $currentAction_comment);
                                }
                                if (Yii::app()->request->isAjaxRequest && isset($_GET['pagecomment'])) {
                                    $currentPage_comment = $_GET['pagecomment'] - 1;
                                    Yii::app()->user->setState('currentPages_comment', $currentPage_comment);
                                }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pagecomment'])) {
                                    Yii::app()->user->setState('currentPages_comment', 0);
                                } else if (Yii::app()->user->hasState('currentPages_comment')) {
                                    $pages_comment->setCurrentPage(Yii::app()->user->getState('currentPages_comment'));
                                }
                                $pages_comment->applyLimit($criteria);
                                $Message = CustomerMessage::model()->findAll($criteria);
                                foreach ($Message as $value1) {
                                    $list_message[] = $value1;
                                }
                            }
                            $modeltheard = new CustomerThread();
                            $model1 = new CustomerMessage("requestByCustomer");
                            $data = array();
                            $data['id_product'] = $model->id_product;
                            $data['data'] = $list_message;
                            $data['pages_comment'] = $pages_comment;
                            $data['model'] = $modeltheard;
                            $data['model1'] = $model1;
                            Yii::app()->getController()->createAction('captcha')->getVerifyCode(true);
                            $this->renderpartial('_comment', $data, FALSE, TRUE);
                        }
                    }
                    $transaction->commit();
                } catch (Exception $ex) {
                    $transaction->rollback();
                    echo (int) 1;
                }
            } else {
                echo (int) 1;
            }
            Yii::app()->end();
        }
    }

    public function actionShowCart() {
        $this->layout = "//layouts/content8";
        if (isset($_SERVER['HTTP_REFERER'])):
            $url = $_SERVER['HTTP_REFERER'];
            Yii::app()->request->cookies['url'] = new CHttpCookie('url', $url);
        endif;
        if (isset($_POST['next'])) {
            if (isset(Yii::app()->session['cart_pack']) && count(Yii::app()->session['cart_pack']) != 0 || isset(Yii::app()->session['cart']) && count(Yii::app()->session['cart']) != 0) {
                //Yii::app()->session['count'] dùng để tạo liên kết phía trên
                if (!isset(Yii::app()->request->cookies['count'])) {
                    Yii::app()->request->cookies['count'] = new CHttpCookie('count', 0);
                }
                $config = Configuration::model()->findByPk(10);
                if (Yii::app()->user->isGuest&&$config->value == 1){
                    $modelc = new Customer('insert');
                    $modelc->default_role = "member";
                    $pass = $modelc->passwordSave = $modelc->repeatPassword = "quangcaodongnai1111";
                    $modelc->secure_key = null;
                    $email = $modelc->email = md5(mt_rand() . mt_rand() . mt_rand()) . '@gmail.com';
                    $modelc->default_role = "member";
                    $modelc->active = 1;
                    $modelc->term = true;
                    if ($modelc->save()) {
                        $modellogin = new LoginFormCustomer('login');
                        $modellogin->username = $email;
                        $modellogin->password = $pass;
                        $modellogin->login();
                    }
                }
                $this->redirect(array('address/create'));
            } else {
                $this->redirect(array('site/index'));
            }
        }
        if (isset($_POST['back'])) {
            $this->redirect(array('site/index'));
        }
        $data = isset(Yii::app()->session['cart']) ? Yii::app()->session['cart'] : null;
        $data_cart_pack = isset(Yii::app()->session['cart_pack']) ? Yii::app()->session['cart_pack'] : null;
        $this->render('cart', array('data' => $data, 'data_cart_pack' => $data_cart_pack));
    }

    public function LoadMenu($id, &$temp) {
        if (!isset($temp))
            $temp = array();
        $criteria = new CDbCriteria();
        $criteria->condition = "id_parent=$id AND active=1";
        $criteria->order = "position desc";
        $models = Category::model()->findAll($criteria);
        if ($models != null) {
            foreach ($models as $value) {
                $temp[] = $value;
                $this->LoadMenu($value->id_category, $temp);
            }
            return $temp;
        } else
            return $temp;
    }

    public function LoadMenuParent($id, &$temp) {
        if (!isset($temp))
            $temp = array();
        $criteria = new CDbCriteria();
        $criteria->condition = "id_category=$id AND active=1";
        $model = Category::model()->find($criteria);
        $temp[] = $model;
        if ($model->id_parent != null) {
            $this->LoadMenuParent($model->id_parent, $temp);
            return $temp;
        } else
            return $temp;
    }

    public function LoadParent($id, &$temp) {
        if (!isset($temp))
            $temp = NULL;
        $model = Category::model()->findByPk($id);
        if ($model->id_parent == null) {
            $temp = $model;
            return $temp;
        } else {
            $this->LoadParent($model->id_parent, $temp);
            return $temp;
        }
    }

    public function actionAddrate() {
        if (Yii::app()->request->isAjaxRequest) {
            $total_percent = 0;
            $total_rate = 0;
            $id_product = Yii::app()->getRequest()->getParam('id_pro', NULL);
            $level_id = Yii::app()->getRequest()->getParam('level', NULL);
            $rate = Rate::model()->findByPk($id_product);
            if (!Yii::app()->user->hasState("Rate" . $id_product . "")) {
                Yii::app()->user->setState("Rate" . $id_product . "", '0');
                if (empty($rate)) {
                    $model = new Rate();
                    $model->id_product = $id_product;
                    $model->level_name = '';
                    $model->level = $level_id;
                    $model->level_max = 5;
                    $model->total_rate = 1;
                    $model->final_rate_date = '';
                    $model->active = 1;
                    $model->save();
                    $total_rate = 1;
                    $total_percent = $level_id;
                } else {
                    $total_rate = $rate->total_rate + 1;
                    $avg = $rate->level + $level_id;
                    $level = ($avg / $total_rate);
                    $total_percent = ($level / 5) * 100;
                    $rate->level = $avg;
                    $rate->total_rate = $total_rate;
                    $rate->save();
                }
            } else {
                $total_rate = $rate->total_rate;
                $avg = $rate->level;
                $level = ($avg / $total_rate);
                $total_percent = ($level / 5) * 100;
                $rate->level = $avg;
                $rate->total_rate = $total_rate;
            }

            $this->renderpartial('_viewRate', array('total_rate' => $total_rate, 'total_percent' => $total_percent, 'id_pro' => $id_product), FALSE, true);
            Yii::app()->end();
        }
    }

    public function actionshowprice() {
        if (Yii::app()->request->isAjaxRequest) {
            $id_att = Yii::app()->getRequest()->getParam('id_att', null);
            $id_pro = Yii::app()->getRequest()->getParam('id_pro', null);
            if ($id_att != NULL) {
                $date = date('Y-m-d H:i:s');
                $maps = explode(',', $id_att);
                $array = array();
                $Product_attribute = ProductAttribute::model()->findAllByAttributes(array('id_product' => $id_pro));
                foreach ($Product_attribute as $value):
                    $criteria = new CDbCriteria();
                    $criteria->condition = "id_product_attribute=$value->id_product_attribute";
                    $ProductAttributeCombinations = ProductAttributeCombination::model()->findAll($criteria);
                    foreach ($ProductAttributeCombinations as $ProductAttributeCombination):
                        if (!in_array($ProductAttributeCombination->id_attribute, $array)):
                            $array[] = $ProductAttributeCombination->id_attribute;
                        endif;
                    endforeach;
                    $flag = true;
                    foreach ($maps as $item) {
                        if (!in_array($item, $array)) {
                            $flag = false;
                        }
                    }
                    if ($flag) {
                        $att = ProductAttribute::model()->findByPk($value->id_product_attribute);
                    }
                    $array = array();
                endforeach;
                if (!empty($att)) {
                    $product = $this->loadModel($id_pro);
                    $price = $att->price;
                    $total = ProductHelper::totalproduct($product, $att);
                    $criteria_spe = new CDbCriteria();
                    $criteria_spe->condition = "t.to>='$date' AND t.from<='$date'";
                    $spe = SpecificPriceRule::model()->findAll($criteria_spe);
                    $item = array();
                    foreach ($spe as $value_spe) {
                        $item[] = $value_spe->id_specific_price_rule;
                    }
                    $str = implode(",", $item);
                    if ($str != "") {
                        $criteria_hot = new CDbCriteria();
                        $criteria_hot->addCondition('id_product=:id_pro AND id_product_attribute=:id_att AND id_specific_price_rule in(' . $str . ')');
                        $criteria_hot->params = array(':id_pro' => $id_pro, ':id_att' => $att->id_product_attribute);
                        $hot_deal = ProductHotDeal::model()->find($criteria_hot);
                        if (!empty($hot_deal)) {
                            $price_hot = $hot_deal->price;
                        } else {
                            $price_hot = $att->price;
                        }
                    } else {
                        $price_hot = $att->price;
                    }
                    $data = array('html' => $this->renderpartial('_viewPrice', array('model' => $product, 'price' => $price, 'price_hot' => $price_hot, 'total' => $total), true), 'button' => $total);
                    echo CJSON::encode($data);
                }
            } else {
                $product = $this->loadModel($id_pro);
                $price = $product->price;
                $total = ProductHelper::totalproduct($product);
                // lấy giá khuyến mãi
                $date = date('Y-m-d H:i:s');
                $criteria_spe = new CDbCriteria();
                $criteria_spe->condition = "t.to>='$date' AND t.from<='$date'";
                $spe = SpecificPriceRule::model()->findAll($criteria_spe);
                $item = array();
                foreach ($spe as $value_spe) {
                    $item[] = $value_spe->id_specific_price_rule;
                }
                $str = implode(",", $item);
                if ($str != '') {
                    $criteria_hot = new CDbCriteria();
                    $criteria_hot->distinct = true;
                    $criteria_hot->addCondition('id_product=:id AND id_specific_price_rule in(' . $str . ')');
                    $criteria_hot->params = array(':id' => $id_pro);
                    $hot_deal = ProductHotDeal::model()->find($criteria_hot);
                    if (!empty($hot_deal)) {
                        $price_hot = $hot_deal->price;
                    } else {
                        $price_hot = $product->unit_price_ratio;
                    }
                } else {
                    $price_hot = $product->unit_price_ratio;
                }
                $data = array('html' => $this->renderpartial('_viewPrice', array('model' => $product, 'price' => $price, 'price_hot' => $price_hot, 'total' => $total), true), 'button' => $total);
                echo CJSON::encode($data);
            }
        }
        Yii::app()->end();
    }

    public function loadModel($id) {
        $model = Product::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
