<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3e525bba1520fdd94c4c1042223b3d29
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DiDom\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DiDom\\' => 
        array (
            0 => __DIR__ . '/..' . '/imangazaliev/didom/src/DiDom',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3e525bba1520fdd94c4c1042223b3d29::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3e525bba1520fdd94c4c1042223b3d29::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3e525bba1520fdd94c4c1042223b3d29::$classMap;

        }, null, ClassLoader::class);
    }
}
