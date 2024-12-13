<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $table = 'pages';
    protected $guarded = ['id'];

    const PRIVACY_POLICY = 'privacy-policy';
    const TERMS_CONDITIONS = 'terms-and-conditions';
    const CANCELLATION_POLICY = 'cancellation-policy';
    const ABOUT_US = 'about-us';
    const COOKIE_POLICY = 'cookie-policy';
    const TERM_OF_USE = 'term-of-use';
    const FAQ = 'faq';
    const HELP = 'help';
    const DRIVER_PRIVACY_POLICY = 'driver-privacy-policy';
    const DRIVER_TERMS_CONDITIONS = 'driver-terms-conditions';
    const DRIVER_FAQ = 'driver-faq';


    const PageType = [
        self::ABOUT_US => 'About Us',
        self::CANCELLATION_POLICY => 'Cancellation and Refund',
        self::COOKIE_POLICY => 'Cookie Policy',
        self::PRIVACY_POLICY => 'Privacy Policy',
        self::TERMS_CONDITIONS => 'Terms & Conditions',
        self::TERM_OF_USE => 'Term of Use',
        self::FAQ => 'FAQ\'s',
        self::HELP => 'Help',
        self::DRIVER_PRIVACY_POLICY => 'Driver Privacy Policy',
        self::DRIVER_TERMS_CONDITIONS => 'Driver Terms & Conditions',
        self::DRIVER_FAQ => 'Driver FAQ\'s',
    ];

}
