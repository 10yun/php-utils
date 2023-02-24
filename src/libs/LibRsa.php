<?php

namespace shiyunQueue\common\logic;

use shiyun\support\Env;

class LibRsa
{
    /**
     * 
     */
    /**
     * @desc 生成RSA2文件
     * @param int $userId
     * @return array
     * @throws \Exception
     */
    public function generateRsa($userId = 0)
    {
        $runtime = syPathRuntime();
        $pemPath = $runtime . 'pem/' . date('Ym/');
        !is_dir($pemPath) && mkdir($pemPath, 0755, true);

        // 生成原始 RSA私钥文件 PKCS1(非JAVA适用)
        $pkcs1PrivateFileName = $pemPath . 'rsa_private_key_pkcs1_' . $userId . '.pem';
        system("openssl genrsa -out {$pkcs1PrivateFileName} 1024");

        // 将原始 RSA私钥转换为 pkcs8格式 PKCS8(JAVA适用)
        $pkcs8PrivateFileName = $pemPath . 'rsa_private_key_pkcs8_' . $userId . '.pem';
        system("openssl pkcs8 -topk8 -inform PEM -in {$pkcs1PrivateFileName} -outform PEM -nocrypt -out {$pkcs8PrivateFileName}");

        // 生成RSA公钥
        $rsaPublicFileName = $pemPath . 'rsa_public_key_pkcs8_' . $userId . '.pem';
        system("openssl rsa -in {$pkcs1PrivateFileName} -pubout -out {$rsaPublicFileName}");

        $pkcs1PrivateContent = file_get_contents($pkcs1PrivateFileName);
        $pkcs8PrivateContent = file_get_contents($pkcs8PrivateFileName);
        $rsaPublicContent    = file_get_contents($rsaPublicFileName);

        @unlink($pkcs1PrivateFileName);
        @unlink($pkcs8PrivateFileName);
        @unlink($rsaPublicFileName);

        return [
            'pkcs1PrivateContent' => $pkcs1PrivateContent,
            'pkcs8PrivateContent' => $pkcs8PrivateContent,
            'rsaPublicContent'    => $rsaPublicContent
        ];
    }
}
