<?php

namespace App\Http\Controllers\S3;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * S3DownloadController
 *
 * @property \Illuminate\Filesystem\AwsS3V3Adapter $storage
 */
class S3DownloadController extends Controller
{
    /**
     * constructor
     */
    public function __construct()
    {
        $this->storage = Storage::disk('s3');
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $name = $request->input('name');
        $path = $request->input('origin_name');

        if (empty($path) || !$this->storage->exists($path)) {
            throw new FileNotFoundException("file not exists, [{$path}]");
        }

        return $this->storage->download($path, $name);
    }
}
