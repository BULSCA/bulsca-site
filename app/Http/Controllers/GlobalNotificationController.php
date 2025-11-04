<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateGlobalBannerNotificationRequest;
use App\Models\GlobalNotification;
use Illuminate\Support\Facades\Cache;

class GlobalNotificationController extends Controller
{
    public function updateBannerNotification(UpdateGlobalBannerNotificationRequest $request)
    {

        $banner = GlobalNotification::where('type', 'GLOBAL_BANNER')->firstOrNew();

        $banner->content = $request->content == '' ? null : $request->content;
        $banner->type = 'GLOBAL_BANNER';

        $banner->save();

        Cache::forget('gn_banner');

        return redirect()->back();
    }
}
