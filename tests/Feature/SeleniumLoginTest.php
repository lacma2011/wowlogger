<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;
use Illuminate\Support\Facades\Config;
use App\User;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedConditions;
use Facebook\WebDriver\Remote\DesiredCapabilities;


class SeleniumLoginTest extends TestCase
{
protected $driver;

    public function setUp() {
        parent::setUp();
        $host_name = Config::get('services.selenium.host');
        $port = Config::get('services.selenium.port');
        $host = 'http://' . $host_name . ':' . $port . '/wd/hub'; // this is the default
        $this->driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
    }
    
    public function testSimple() {
        $url = 'https://github.com';
        $this->driver->get($url);
        // checking that page title contains word 'GitHub'
        $this->assertContains('GitHub', $this->driver->getTitle());
    }

    public function testToDos() {
        try {
            print "\nNavigating to URL\n";
            $this->driver->get("http://crossbrowsertesting.github.io/todo-app.html");
            sleep(3);
            print "Clicking Checkbox\n";
            $this->driver->findElement(WebDriverBy::name("todo-4"))->click();
            print "Clicking Checkbox\n";
            $this->driver->findElement(WebDriverBy::name("todo-5"))->click();
            $elems = $this->driver->findElements(WebDriverBy::className("done-true"));
            $this->assertEquals(2, count($elems));
            print "Entering Text\n";
            $this->driver->findElement(WebDriverBy::id("todotext"))->sendKeys("Run your first Selenium test");
            print "Adding todo to the list\n";
            $this->driver->findElement(WebDriverBy::id("addbutton"))->click();
            $spanText = $this->driver->findElement(WebDriverBy::xpath("/html/body/div/div/div/ul/li[6]/span"))->getText();
            $this->assertEquals("Run your first Selenium test", $spanText);
            print "Archiving old todos\n";
            $this->driver->findElement(WebDriverBy::linkText("archive"))->click();
            $elems = $this->driver->findElements(WebDriverBy::className("done-false"));
            $this->assertEquals(4, count($elems));
            // if we've made it this far, assertions have passed and we'll set the score to pass.
        } catch (Exception $ex) {
            // if we caught an exception along the way, an assertion failed and we'll set the score to fail.
            print "Caught Exception: " . $ex->getMessage();
        }
    }

    public function testBlizzardLogin()
    {
        $url = route('loginsocial', [
            'provider' => 'battlenet-stateful',
            'region' => 'us',
        ]);

        $this->driver->get($url);

        // checking that page title is really Blizzard's
        $this->assertContains('Blizzard Login', $this->driver->getTitle());

        
        // TODO:
        // enter username and password
        // check if 2-factor auth is waiting on, and if so, get the code
        // 
//        $content = $this->driver->getPageSource();
//        var_dump($content);
//        exit;
    }

    public function tearDown() {
        $this->driver->quit();
        parent::tearDown();
    }

}
