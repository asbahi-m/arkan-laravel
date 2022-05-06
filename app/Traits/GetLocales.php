<?php

namespace App\Traits;

use App\Models\Locale;

Trait GetLocales
{
    function locales() {
        $locales = Locale::query()
            // ->where('short_sign', '!=', DEFAULT_LOCALE))
            ->whereNull('is_disabled')
            ->select('id', 'short_sign')
            ->get();
        return $locales;
    }
}
