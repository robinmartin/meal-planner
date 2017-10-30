<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepeatRuleUpdateRequest;
use App\RepeatRule;

class RepeatRuleApiController extends Controller
{

    public function update(RepeatRuleUpdateRequest $request, RepeatRule $repeatRule)
    {
        //RepeatRuleUpdating model event fired
        $repeatRule->end_date = $request->input('end_date');
        $repeatRule->save();

        return response(null, 204);
    }
}
