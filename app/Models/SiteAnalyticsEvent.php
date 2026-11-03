<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * One page view or click by a logged-in kiosk user (role "user").
 * Written by TrackPageView and SiteAnalyticsController, read by the admin Website Health page.
 */
class SiteAnalyticsEvent extends Model
{
    public const PAGE_VIEW = 'page_view';
    public const CLICK = 'click';

    public const UPDATED_AT = null;

    protected $fillable = [
        'event',
        'user_id',
        'store_id',
        'route_name',
        'path',
        'label',
        'target',
        'product_id',
    ];

    /**
     * Readable names for the logged-in pages, used on the Website Health page.
     */
    public const PAGE_NAMES = [
        'user.dashboard' => 'Dashboard',
        'user.showQuestionnaire' => 'Questionnaires',
        'user.products' => 'Browse Wines',
        'user.featuredproducts' => 'Featured Products',
        'user.cheeses' => 'Browse Cheeses',
        'user.cheese.show' => 'Cheese Details',
        'user.productdetails' => 'Wine Details',
        'products.show' => 'Wine Details',
        'user.matchedproducts' => 'Wine Matches (questionnaire results)',
        'user.cart' => 'Cart',
        'user.userprofile.show' => 'Profile',
        'user.storeprofile.show' => 'Store Profile',
        'questionnaires.show' => 'Questionnaire',
    ];

    public static function pageName(?string $routeName): string
    {
        return self::PAGE_NAMES[$routeName] ?? ($routeName ?: 'Other');
    }
}
