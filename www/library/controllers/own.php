<?php

class Own extends Controller
{
    public function get()
    {
        foreach(R::getAll("SELECT name, SUM(sum*share) AS sum FROM debt WHERE deleted IS NULL || deleted != true GROUP BY name") as $debt)
        {
            $debts[$debt["name"]] = $debt["sum"];
        }
        if ($debts["Åsa"] > $debts["Erik"])
        {
            $own = array(
                'name' => 'Åsa',
                'sum'  => $debts['Åsa'] - $debts['Erik']
            );
        }
        elseif ($debts["Erik"] > $debts["Åsa"])
        {
            $own = array(
                'name' => 'Erik',
                'sum'  => $debts['Erik'] - $debts['Åsa']
            );
        }
        else
        {
            $own = array(
                'name' => 'Ingen',
                'sum'  => 0
            );
        }
        header("Content-type: application/json;charset=utf-8;");
        echo json_encode($own);
        exit();
    }
}