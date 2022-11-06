<?php

namespace App\Http\Controllers\S3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * S3UploadController
 *
 * @property \Illuminate\Filesystem\AwsS3V3Adapter $storage
 */
class S3UploadController extends Controller
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
        $file = $request->file('file');
        $path = '/upload';

        $this->storage->append($path, $file);

        return redirect(route('s3.index'));
    }
}
