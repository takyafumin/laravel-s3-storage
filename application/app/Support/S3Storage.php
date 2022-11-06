<?php

namespace App\Support;

use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * S3Storage
 *
 * @property \Illuminate\Filesystem\AwsS3V3Adapter $s3storage S3ストレージ
 * @property array $config S3ストレージ設定
 */
class S3Storage
{
    /** 有効時間(分) */
    private const AVIABLE_MINUTES = 1;

    /**
     * constructor
     */
    public function __construct()
    {
        /** @var \Illuminate\Filesystem\AwsS3V3Adapter */
        $this->s3storage = Storage::disk('s3');
        $this->config  = $this->s3storage->getConfig();
    }

    /**
     * 署名付きURL情報を返却する
     *
     * @param string $fileName ファイル名
     * @return array<int, string>
     */
    public function getTemporaryUrl(string $filePath): array
    {
        /** @var \Illuminate\Filesystem\AwsS3V3Adapter|\Illuminate\Filesystem\Filesystem $storage */
        $storage = $this->s3storage;
        if ($this->config['use_path_style_endpoint']) {
            $endpoint = Str::match('/https?:\/\/[^\/]*/', $this->config['url']);
            $storage = Storage::build(Arr::set($this->config, 'endpoint', $endpoint));
        }

        $client = $storage->getClient();
        $command = $client->getCommand('PutObject', [
            'Bucket' => $this->config['bucket'],
            'Key'    => $filePath,
        ]);

        // 有効時間
        $expiration = CarbonImmutable::now()->addMinutes(self::AVIABLE_MINUTES);

        // 署名付きURL
        $presignedUrl = (string) $client->createPresignedRequest($command, $expiration)->getUri();
        $fileUrl = $storage->temporaryUrl($filePath, $expiration);

        return [
            'url'      => $presignedUrl,
            'filePath' => $filePath,
            'fileUrl'  => $fileUrl,
            'fileExtention' => File::extension($filePath),
        ];
    }
}
