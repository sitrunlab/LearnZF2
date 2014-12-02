<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'modules_list' => [
        0 => [
            'module_name' => 'LearnZF2Ajax',
            'module_desc' => 'Learn Ajax with ZF2',
            'module_route' => 'learnZF2Ajax',
        ],
        1 => [
            'module_name' => 'LearnZF2FormUsage',
            'module_desc' => 'Learn Form Usage with ZF2',
            'module_route' => 'learn-zf2-form-usage',
        ],
        2 => [
            'module_name' => 'LearnZF2Barcode',
            'module_desc' => 'Learn Barcode Usage with ZF2',
            'module_route' => 'learn-zf2-barcode-usage',
        ],
    ]
];
