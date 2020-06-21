<?php
namespace App;

class TeamPointsComposer
{
    public function __construct(\App\Teams\Repository $teams)
    {
        $this->teams = $teams;
    }

    public function compose(\Illuminate\View\View $view)
    {
        $view->with('points', $this->teams->points(\App\Team::first()));
    }
}
