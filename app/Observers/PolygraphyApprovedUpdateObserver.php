<?php

namespace App\Observers;

use App\GdLogEntry;
use App\PolygraphyApproved;
use Auth;

class PolygraphyApprovedUpdateObserver
{
    public function updating(PolygraphyApproved $poly)
    {
        $changed = array_diff_assoc($poly->getAttributes(), $poly->getOriginal());
        $changedFields = array_keys($changed);

        if (in_array('members_ids', $changedFields)) {
            GdLogEntry::create([
                'type' => 'pl_print_d_changed',
                'tg_bot_status' => 'inqueue',
                'user_id' => Auth::id(),
                'arg_id' => $poly->order()->id,
                'details' => serialize([
                    'order' => $poly->order()->id,
                    'team_id' => $poly->team_id,
                    'from' => $poly->getOriginal('members_ids'),
                    'to' => $poly->members_ids
                ])
            ]);
        }

    }
}