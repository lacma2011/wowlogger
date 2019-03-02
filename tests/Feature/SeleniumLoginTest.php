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
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeOptions;


class SeleniumLoginTest extends TestCase
{
    protected $driver;
    
    public function setUp() {
        parent::setUp();


        $host_name = Config::get('services.selenium.host');
        $port = Config::get('services.selenium.port');
        $host = 'http://' . $host_name . ':' . $port . '/wd/hub'; // this is the default

        // options for chrome
        $options = new ChromeOptions();
	$options->addArguments(array(
	    '--disable-extensions',
	    '--headless',
	    '--disable-gpu',
	    '--no-sandbox',
	    
        ));
	$caps = DesiredCapabilities::chrome();
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);
    
        $this->driver = RemoteWebDriver::create($host, $caps);
    }
    
    /**
     * @group online
     * @group selenium
     */
    public function testSimple() {
        $url = 'https://github.com';
        $this->driver->get($url);
        // checking that page title contains word 'GitHub'
        $this->assertContains('GitHub', $this->driver->getTitle());
    }

    /**
     * @group online
     * @group selenium
     */
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

    /**
     * @group online
     * @group selenium
     */
    public function testBlizzardLogin()
    {
        $driver = $this->driver;
	$screenshot = function() use ($driver) {
            $filename = __DIR__ . '/myfile.png';
            $screenshot = $driver->takeScreenshot();
            file_put_contents($filename, $screenshot);
        };

        $url = route('loginsocial', [
            'provider' => 'battlenet-stateful',
            'region' => 'us',
        ]);

        $driver->get($url);

        //var_dump($driver->getCurrentUrl());

        // checking that page title is really Blizzard's
        $this->assertContains('Blizzard Login', $driver->getTitle());

	$user = Config::get('services.battlenet-account.user');
	$pass = Config:: get('services.battlenet-account.pass');
	$tagname = Config:: get('services.battlenet-account.tagname');

        $driver->findElement(WebDriverBy::id("accountName"))->sendKeys($user);
        $driver->findElement(WebDriverBy::id("password"))->sendKeys($pass);
	$driver->findElement(WebDriverBy::id('submit'))->click();

        $element = $driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('h1.heading-1'))
        );
        $headerText = $element->getText();
	$this->assertContains('Check your Authenticator', $headerText);

	// let user know to check their authenticator
	echo $headerText . "\n\n";
        ob_flush();

	usleep(10000000);
        //$screenshot();

        //echo "Selenium redirected to: " . $driver->getCurrentUrl() . PHP_EOL;

        //$content = $driver->getPageSource();
        //var_dump($content);
        //ob_flush();

        $driver->wait(10, 500)->until(WebDriverExpectedCondition::titleIs('User Page: ' . $tagname));
	$this->assertContains('User Page: ' . $tagname, $this->driver->getTitle());

	//$element = $driver->findElement(WebDriverBy::id('first_name'));
        //$driver->wait(10, 1000)->until(
            //WebDriverExpectedCondition::visibilityOf($element)
	//);

    }

    public function tearDown() {
        $this->driver->quit();
        parent::tearDown();
    }

}
