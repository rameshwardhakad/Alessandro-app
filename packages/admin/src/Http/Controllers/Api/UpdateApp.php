<?php

namespace Admin\Http\Controllers\Api;

use ZipArchive;

class UpdateApp
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $zip = new ZipArchive;
        $res = $zip->open(base_path('files.zip'));

        if ($res === true) {
            $zip->extractTo(base_path());
            $zip->close();
        }

        return [
            'status' => 'done',
        ];
    }
}
