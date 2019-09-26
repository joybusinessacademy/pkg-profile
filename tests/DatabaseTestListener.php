<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/25/2019
 * Time: 7:22 PM
 */

namespace JoyBusinessAcademy\Profile\Tests;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestSuite;


class DatabaseTestListener implements TestListener
{
    use TestListenerDefaultImplementation;

    /**
     * Set up the database for testing.
     *
     * @param TestSuite $suite
     */
    public function startTestSuite(TestSuite $suite): void
    {
        //dump($suite->getName());

    }

    /**
     * Clean up the database files.
     *
     * @param TestSuite $suite
     */
    public function endTestSuite(TestSuite $suite): void
    {

    }
}