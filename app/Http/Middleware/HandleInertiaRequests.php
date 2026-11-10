<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            // ওয়েবসাইট জুড়ে লাইভ সেটিংস শেয়ার
'settings' => SiteSetting::first() ?? [
    'brand_name' => 'Pure Sip',
    'header_phone' => '01306-312372',
    'logo' => '/images/logo.png',
    'banner_image' => '/images/banner.jpeg',
    'banner_title' => '100% Pure Botanical Refreshment',
    'banner_subtitle' => 'Handcrafted digestive, cooling & immunity tonics brewed from authentic fruits and herbs.',
    'phone_primary' => '01306-312372',
    'phone_secondary' => '018265-813373',
    'whatsapp_number' => '+8801306312372',
    'email' => 'info@puresipbeverage.com',
    'address' => 'Pure Sip Beverage, Dhaka, Bangladesh',
],
        ];
    }
}