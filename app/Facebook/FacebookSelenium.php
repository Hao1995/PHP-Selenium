<?php

namespace App\Facebook;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Illuminate\Support\Facades\Mail;

use App\EnChuKong;

class FacebookSelenium
{

    public function test(){
        return 'test';
    }

    public function index(){

        header("Content-Type: text/html; charset=UTF-8");
        $waitSeconds = 3;
        $host = 'http://localhost:4444/wd/hub'; // this is the default
        $capabilities = DesiredCapabilities::chrome();
        $driver = RemoteWebDriver::create($host, $capabilities, 5000);
        $driver->get('https://ws.eck.org.tw/EckNetReg/Kreg/DoctorList.aspx?Func=Reg&DivInfo=5500');

        $doctorName = '麥珮怡';
        try {
            // 等待新的页面加载完成....
            $driver->wait($waitSeconds)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(
                    WebDriverBy::partialLinkText($doctorName)
                )
            );
            $elements = $driver->findElements(WebDriverBy::partialLinkText($doctorName));
        } catch (NoSuchElementException $e) {
            $isExists = false;
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

                $element = $driver->findElement(WebDriverBy::cssSelector('tr > td > table > tbody > tr:last-child > td:nth-child(9) > input'));
                $status = $element->getAttribute('value');

                EnChuKong::create([
                    'date' =>  $date,
                    'week' =>  $week,
                    'status' => $status,
                ])->save();

                if ($status == '我要預約'){
                    $data = [
                        'title' => 'Hi student ....',
                        'content' => $date . ' - ' . $week . ' - ' . $status
                    ];
                
                    Mail::send('emails.test', $data, function($message){
                        $message->to('y26704325@gmail.com', 'Harry')->subject('Selenium - En Chu Kong');
                    });
                }

            } catch (NoSuchElementException $e){
                $errorMessage = $errorMessage . 'No Such Element';
            }
            $driver->navigate()->back();
        }

        $driver->quit();

        if ($errorMessage != ''){
            $output = $errorMessage;
        } else {
            $output = 'Successful';
        }

        return $output;

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

?>