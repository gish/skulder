<?php

class Debts extends Controller
{
    public function get()
    {
        $amount = $_GET['amount'];
        $offset = $_GET['offset'];
        $debtsIds = R::find('debt', " 1 ORDER BY id DESC LIMIT {$offset},{$amount}");
        
        foreach($debtsIds as $debt)
        {
            $debts[] = array(
                'id'          => $debt->id,
                'name'        => $debt->name,
                'date'        => $debt->date,
                'description' => $debt->description,
                'sum'         => $debt->sum,
                'share'       => $debt->share,
                'deleted'     => $debt->deleted
            );
        }
        header("Content-type: application/json;charset=utf-8;");
        echo json_encode($debts);
        exit();
    }
}