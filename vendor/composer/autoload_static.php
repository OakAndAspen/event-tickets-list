<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4b99518a1af39ad55722912a4c0a06bc
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PrestaShop\\Module\\EventTicketsList\\Controller\\' => 46,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PrestaShop\\Module\\EventTicketsList\\Controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Controller',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4b99518a1af39ad55722912a4c0a06bc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4b99518a1af39ad55722912a4c0a06bc::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}