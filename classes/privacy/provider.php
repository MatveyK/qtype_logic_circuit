<?php
namespace qtype_logic\privacy;

class provider implements \core_privacy\local\metadata\null_provider {
    use \core_privacy\local\legacy_polyfill;
    /**
     * Get the language string identifier with the component's language
     * file to explain why this plugin stores no data.
     *
     * @return  string
     */
    public static function get_reason() :string {
        return 'privacy:null_reason';
    }
}
