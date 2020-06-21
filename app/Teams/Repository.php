<?php
namespace App\Teams;

class Repository
{
    public function points($team)
    {
        $users = $team->where('teams.id', $team->id)
            ->join('users', 'teams.id', '=', 'users.team_id')
            ->select('users.id');

        return $team->where('teams.id', $team->id)
            ->join('tickets', 'teams.id', '=', 'tickets.team_id')
            ->join('points', 'tickets.id', '=', 'points.ticket_id')
            ->whereIn('points.owner_id', $users)
            ->sum('points.value');
    }
}
