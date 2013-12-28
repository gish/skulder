<?php

class Debt extends Controller
{
    public function add()
    {
        $params = json_decode(file_get_contents("php://input"));
        $name = $params->name;
        $description = $params->description;
        $sum = $params->sum;
        $share = $params->share;
        
        $debt = R::dispense('debt');
        $debt->name = $name;
        $debt->description = $description;
        $debt->share = $share;
        $debt->sum = $sum;
        $debt->date = date('Y-m-d');
        $debt->deleted = false;
        $id = R::store($debt);
        header("Content-type: application/json;charset=utf-8;");        
        echo json_encode(array(
            'id'   => $id,
            'date' => date('Y-m-d')
        ));
        exit();
    }
    
    public function get($id)
    {
        $debt = R::findOne('debt', ' id = :id', array('id' => $id));
        header("Content-type: application/json;charset=utf-8;");
        echo json_encode($debt);
        exit();
    }
    
    public function update()
    {
        $params = json_decode(file_get_contents("php://input"));
        $debt = R::findOne('debt', ' id = :id', array('id' => $params->id));
        $debt->name = $params->name;
        $debt->description = $params->description;
        $debt->share = $params->share;
        $debt->sum = $params->sum;
        $debt->deleted = $params->deleted == 1;
        R::store($debt);
        exit();
    }
    
    public function delete($debt_id)
    {
        $this->debt_id = $debt_id;
        $debt = R::findOne('debt', ' id = :id', array('id' => $debt_id));
        $debt->deleted = true;
        R::store($debt);
    }
}