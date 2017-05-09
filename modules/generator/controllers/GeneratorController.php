<?php
/**
 * Created by Vokuro-Cli.
 * User: dwiagus
 * Date: !data
 * Time: 20:05:54
 */

namespace Modules\Generator\Controllers;
use Modules\Generator\Models\Module;

use Modules\Frontend\Controllers\ControllerBase;
class GeneratorController extends ControllerBase
{
    public function initialize()
    {
        $this->assets
            ->collection('footer')
            ->setTargetPath("themes/admin/assets/js/combined-gen.js")
            ->setTargetUri("themes/admin/assets/js/combined-gen.js")
            ->join(true)
            ->addJs($this->config->application->modulesDir."generator/views/js/main.js")
            ->addFilter(new \Phalcon\Assets\Filters\Jsmin());
    }

    public function indexAction()
    {

        if ($this->request->isPost()) {
            $info = array(
            '{generator_name}'  => $this->request->getPost('generator_name'),
            '{module_name}'     => \Phalcon\Text::camelize($this->request->getPost('generator_name'), "_-"),
            '{module_name_l}'   => $this->clean($this->request->getPost('generator_name')),
            '{description}'     => $this->request->getPost('description'),
            '{author}'          => $this->request->getPost('author'),
            '{website}'         => $this->request->getPost('website'),
            '{package}'         => $this->request->getPost('package'),
            '{copyright}'       => $this->request->getPost('copyright'),
            '{model_fields}'    => $this->makeModel($this->request->getPost()),
            );
            $this->flash->success($info['{model_fields}']);
            //print_r($this->request->getPost());
        }
        $this->view->pick("index");
    }

    private function clean($nametoclean)
    {
        $fixes = array(' ','-');
        return strtolower(str_replace($fixes, '_',$nametoclean));
    }

    private function makeModel($fields)
    {
        $model_fields = '';
        foreach ($fields['name'] as $key => $field) {
            for ($i=0; $i < ; $i++) { 
                # code...
            }
            $text = $this->clean($field);
            $model_fields .= sprintf("'%s' => \$%s;\n\t", $text, $text);
        }
        return $model_fields;
    }

    public function listAction()
    {
        $this->view->disable();
        $arProp = array();
        $current = intval($this->request->getPost('current'));
        $rowCount = intval($this->request->getPost('rowCount'));
        $searchPhrase = $this->request->getPost('searchPhrase');
        $sort = $this->request->getPost('sort');
        if ($searchPhrase != '') {
            $arProp['conditions'] = "title LIKE ?1 OR slug LIKE ?1 OR content LIKE ?1";
            $arProp['bind'] = array(
                1 => "%".$searchPhrase."%"
            );
        }
        $qryTotal = Module::find($arProp);
        $rowCount = $rowCount < 0 ? $qryTotal->count() : $rowCount;
        $arProp['order'] = "created DESC";
        $arProp['limit'] = $rowCount;
        $arProp['offset'] = (($current*$rowCount)-$rowCount);
        if($sort){
            foreach ($sort as $k => $v) {
                $arProp['order'] = $k.' '.$v;
            }
        }
        $qry = Module::find($arProp);
        $arQry = array();
        $no =1;
        foreach ($qry as $item){
            $arQry[] = array(
                'no'    => $no,
                'id'    => $item->id,
                	'name' => $item->name,
		'slug' => $item->slug,
		'version' => $item->version,
		'menu' => $item->menu,
		'description' => $item->description,
		'enabled' => $item->enabled,
	
                'created' => $item->created
            );
            $no++;
        }
        //$arQry = $qry->toArray();
        $data = array(
            'current'   => $current,
            'rowCount'  => $qry->count(),
            'rows'      => $arQry,
            'total'     => $qryTotal->count(),
            'filter'    => $arProp
        );
        $response = new \Phalcon\Http\Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setJsonContent($data);
        return $response->send();
    }

    public function createAction()
    {
        $this->view->disable();
        $data = new Module();
        	$data->name;
		$data->slug;
		$data->version;
		$data->menu;
		$data->description;
		$data->enabled;
	
        if($data->save()){
            $alert = "sukses";
            $msg .= "Edited Success ";
        }else{
            $alert = "error";
            $msg .= "Edited failed";
        }
        $response = new \Phalcon\Http\Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setJsonContent(array('_id' => $this->request->getPost("title"),'alert' => $alert, 'msg' => $msg ));
        return $response->send();
    }

    public function editAction()
    {
        $this->view->disable();
        $data = Module::findFirst($this->request->getPost('hidden_id'));
        	$data->name;
		$data->slug;
		$data->version;
		$data->menu;
		$data->description;
		$data->enabled;
	

        if (!$data->save()) {
            foreach ($data->getMessages() as $message) {
                $alert = "error";
                $msg .= $message." ";
            }
        }else{
            $alert = "sukses";
            $msg .= "page was created successfully";
        }
        $response = new \Phalcon\Http\Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setJsonContent(array('_id' => $this->request->getPost("title"),'alert' => $alert, 'msg' => $msg ));
        return $response->send();

    }

    public function getAction()
    {
        $data = Module::findFirst($this->request->getQuery('id'));
        $response = new \Phalcon\Http\Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setJsonContent($data->toArray());
        return $response->send();
    }

    public function deleteAction($id)
    {
        $this->view->disable();
        $data   = Module::findFirstById($id);

        if (!$data->delete()) {
            $alert  = "error";
            $msg    = $data->getMessages();
        } else {
            $alert  = "sukses";
            $msg    = "Module was deleted ";
        }
        $response = new \Phalcon\Http\Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setJsonContent(array('_id' => $id,'alert' => $alert, 'msg' => $msg ));
        return $response->send();
    }
}