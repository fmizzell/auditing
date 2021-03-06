<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit50186ff0ad762fb6a7d692c6716f5a31
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Fmizzell\\Auditing\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Fmizzell\\Auditing\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit50186ff0ad762fb6a7d692c6716f5a31::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit50186ff0ad762fb6a7d692c6716f5a31::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
