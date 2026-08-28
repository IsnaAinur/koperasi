<?php

namespace Config;

class Paths
{
    /**
     * SYSTEM FOLDER NAME
     *
     * Path relatif dari lokasi file Paths.php ke folder system.
     */
    public string $systemDirectory = __DIR__ . '/../../system';

    /**
     * APPLICATION FOLDER NAME
     *
     * Path relatif dari lokasi file Paths.php ke folder app.
     */
    public string $appDirectory = __DIR__ . '/..';

    /**
     * WRITABLE FOLDER NAME
     *
     * Path relatif dari lokasi file Paths.php ke folder writable.
     */
    public string $writableDirectory = __DIR__ . '/../../writable';

    /**
     * TESTS FOLDER NAME
     *
     * Path relatif dari lokasi file Paths.php ke folder tests.
     */
    public string $testsDirectory = __DIR__ . '/../../tests';

    /**
     * VIEW FOLDER NAME
     *
     * Path relatif dari lokasi file Paths.php ke folder views.
     */
    public string $viewDirectory = __DIR__ . '/../Views';
}