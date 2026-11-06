<?php

namespace App\Services;

/** Source identity, never the component label, determines manual entry eligibility. */
final class GradebookComponentEntry
{
    public static function manual($component)
    {
        $source = $component->data_source ?? null;
        return is_scalar($source) && is_numeric($source) && (int) $source >= 100
            && (string) (int) $source === (string) $source;
    }

    public static function supportedMaximum($maximum)
    {
        return is_numeric($maximum) && $maximum > 0 && $maximum <= 2147483647 && floor($maximum) == $maximum;
    }
}
