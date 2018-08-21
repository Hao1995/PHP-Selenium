<?php

namespace App\Facebook;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\WebDriverCurlException;

use Illuminate\Support\Facades\Mail;

use App\EnChuKong;

class FacebookSelenium
{

    public function index(){

        header("Content-Type: text/html; charset=UTF-8");
        $waitSeconds = 3;
        $host = 'http://localhost:4444/wd/hub';
        $capabilities = DesiredCapabilities::chrome();
        $driver = RemoteWebDriver::create($host, $capabilities, 5000);
        $url = 'https://ws.eck.org.tw/EckNetReg/Kreg/DoctorList.aspx?Func=Reg&DivInfo=5500';
        try {
            $driver->get($url);
        } catch(WebDriverCurlException $e) {
            $isExists = false;
            $driver->quit();
            return "Can't get " . $url;
        }

        $doctorName = '江怡慧';
        try {
            $driver->wait($waitSeconds)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(
                    WebDriverBy::partialLinkText($doctorName)
                )
            );
            $elements = $driver->findElements(WebDriverBy::partialLinkText($doctorName));
        } catch (NoSuchElementException $e) {
            $isExists = false;
            $driver->quit();
            return "Can't get button: " . $doctorName;
        }
    
        $errorMessage = '';

        for ($i = 0; $i < count($elements); $i++) {
            $elements = $driver->findElements(WebDriverBy::partialLinkText($doctorName));
            $elements[$i]->sendKeys($doctorName)->click();
            
            try {
                $element = $driver->findElement(WebDriverBy::cssSelector('tr > td > table > tbody > tr:last-child > td:nth-child(1) > span'));
                $date = $element->getText();

                $element = $driver->findElement(WebDriverBy::cssSelector('tr > td > table > tbody > tr:last-child > td:nth-child(3) > span'));
                $week = $element->getText();

                $element = $driver->findElement(WebDriverBy::cssSelector('tr > td > table > tbody > tr:last-child > td:nth-child(6) > span'));
                $doctor = $element->getText();

                $element = $driver->findElement(WebDriverBy::cssSelector('tr > td > table > tbody > tr:last-child > td:nth-child(9) > input'));
                $status = $element->getAttribute('value');

                $dateSplit = explode("/", $date);
                if (count($dateSplit) == 3){
                    $year = (int)$dateSplit[0] + 1911;
                    $dateFormat = (string)$year . '-' . $dateSplit[1] . '-' . $dateSplit[2];
                }else{
                    $date = null;
                }
                EnChuKong::create([
                    'date'      => $dateFormat,
                    'week'      => $week,
                    'doctor'    => $doctor,
                    'status'    => $status,
                ])->save();
    
                if ($status == '我要預約'){
                    $content = $date . ' - ' . $week . ' - ' . $status;
                    makeAnAppointment($content, $driver);
                }
                $driver->navigate()->back();

            } catch (NoSuchElementException $e){
                $errorMessage = $errorMessage . '   ===   ' .'Error when forech '. $i . ' element : No Such Element';
                $driver->quit();
            }
            //catch timeout
        }

        $driver->quit();

        return 'Successful';

    }
}

function switchToEndWindow($driver){   
    $arr = $driver->getWindowHandles();
    foreach ($arr as $k=>$v){
        if($k == (count($arr)-1)){
            $driver->switchTo()->window($v);
        }
    }
}

function makeAnAppointment($content, $driver){
    $data = [
        'title' => 'You can make an appointment',
        'content' => $content
    ];

    Mail::send('emails.test', $data, function($message){
        $message->to($_ENV['MAIL_TARGET'], 'Harry')->subject('Selenium - En Chu Kong');
    });

    try {
        $btn = $driver->findElement(WebDriverBy::cssSelector('tr > td > table > tbody > tr:last-child > td:nth-child(9) > input'));
        $btn->click();
    }catch(NoSuchElementException $e){
        $isExists = false;
    }
    
    $driver->navigate()->back();
}

?>