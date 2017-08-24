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
                'type' => 'order_members_changed',
                'tg_bot_status' => 'none',
                'user_id' => Auth::id(),
                'arg_id' => $poly->id,
                'details' => serialize([
                    'polygraphy_approved' => $poly->id,
                    'team_id' => $poly->team_id,
                    'from' => $poly->getOriginal('members_ids'),
                    'to' => $poly->members_ids
                ])
            ]);
        }

    }
}