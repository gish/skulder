<?php

class Own extends Controller
{
    public function get()
    {
        global $settings;

        foreach(R::getAll("SELECT name, SUM(sum*share) AS sum FROM debt WHERE deleted IS NULL || deleted != true GROUP BY name") as $debt)
        {
            $debts[$debt["name"]] = $debt["sum"];
        }

        if ($debts[$settings['users'][0]] > $debts[$settings['users'][1]])
        {
            $own = array(
                'name' => $settings['users'][0],
                'sum'  => $debts[$settings['users'][0]] - $debts[$settings['users'][1]]
            );
        }
        elseif ($debts[$settings['users'][1]] > $debts[$settings['users'][0]])
        {
            $own = array(
                'name' => $settings['users'][1],
                'sum'  => $debts[$settings['users'][1]] - $debts[$settings['users'][0]]
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
