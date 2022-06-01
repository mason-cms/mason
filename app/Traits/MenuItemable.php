<?php

namespace App\Traits;

use App\Models\MenuItem;

trait MenuItemable
{
    /**
     * ==================================================
     * Static Methods
     * ==================================================
     */

    protected static function bootMenuItemable()
    {
        /**
         * When updating a menuItemable record, we will update the href and title attributes of the attached
         * menu items with the new url and title, only if the menu item was using the previous version.
         * This prevents overwriting of values that were set manually to be different.
         */
        static::updating(function ($menuItemable) {
            $new = $menuItemable;
            $old = $menuItemable->fresh();

            foreach ($menuItemable->menu_items as $menuItem) {
                if ($menuItem->href === $old->url) {
                    $menuItem->href = $new->url;
                }

                if ($menuItem->title = $old->title) {
                    $menuItem->title = $new->title;
                }

                if ($menuItem->isDirty()) {
                    $menuItem->save();
                }
            }
        });

        /**
         * When a menuItemable has been deleted, we need to delete all the associated menu items.
         */
        static::deleted(function ($menuItemable) {
            $menuItemable->menu_items()->delete();
        });
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function menu_items()
    {
        return $this->morphMany(MenuItem::class, 'target');
    }
}
