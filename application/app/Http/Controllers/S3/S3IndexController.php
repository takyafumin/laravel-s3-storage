<?php

namespace App\Http\Controllers\S3;

use App\Http\Controllers\Controller;
use App\Support\S3Storage;
use Illuminate\Support\Facades\Storage;

/**
 * S3IndexController
 *
 * @property S3Storage $storage storage
 */
class S3IndexController extends Controller
{
    /**
     * constructor
     *
     * @param S3Storage $storage storage
     */
    public function __construct(
        private S3Storage $storage
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $path  = '/upload';
        $files = Storage::disk('s3')->allFiles($path);

        $file_list = collect($files)->map(function ($item) {

            $url_info = $this->storage->getTemporaryUrl($item);
            return [
                'url'           => $url_info['url'],
                'filePath'      => $url_info['filePath'],
                'fileUrl'       => $url_info['fileUrl'],
                'fileExtention' => $url_info['fileExtention']
            ];
        });

        return view('dashboard', [
            'file_list' => $file_list->toArray()
        ]);
    }
}
