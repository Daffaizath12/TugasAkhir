<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9af51e9320b87243fb4831316d32ef74
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9af51e9320b87243fb4831316d32ef74::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9af51e9320b87243fb4831316d32ef74::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9af51e9320b87243fb4831316d32ef74::$classMap;

        }, null, ClassLoader::class);
    }
}