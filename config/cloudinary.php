<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Cloudinary settings. The CLOUDINARY_URL
    | env variable uses the format: cloudinary://api_key:api_secret@cloud_name
    |
    */

    'cloud_url' => env('CLOUDINARY_URL'),
    'secure' => true,
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL', null),
];
