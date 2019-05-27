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

        $doctorName = '江怡慧 (00015)';
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
            $elements[$i]->click();
            
            $eInfo = $driver->findElements(WebDriverBy::cssSelector('#TableSchedule > tbody > tr'));
            
            foreach ($eInfo as $info) {
                try {

                    $eTd = $info->findElements(WebDriverBy::cssSelector('td'));
                    if (count($eTd) != 9) {
                        continue;
                    }

                    $date = $eTd[0]->findElement(WebDriverBy::cssSelector('span'))->getText();

                    $dateSplit = explode("/", $date);
                    if (count($dateSplit) != 3){
                        // the formate of data should like 2019/03/04
                        continue;
                    }

                    $week = $eTd[2]->findElement(WebDriverBy::cssSelector('span'))->getText();
                    $doctor = $eTd[5]->findElement(WebDriverBy::cssSelector('span'))->getText();
                    $status = $eTd[8]->findElement(WebDriverBy::cssSelector('input'))->getAttribute('value');

                    $year = (int)$dateSplit[0] + 1911; // 轉換民國幾年至西元幾年
                    $dateFormat = (string)$year . '-' . $dateSplit[1] . '-' . $dateSplit[2];
                    EnChuKong::create([
                        'date'      => $dateFormat,
                        'week'      => $week,
                        'doctor'    => $doctor,
                        'status'    => $status,
                    ])->save();
        
                    // '我要預約', '額滿', '停止掛號'
                    if ($status == '我要預約'){
                        $content = $date . ' - ' . $week . ' - ' . $status;
                        makeAnAppointment($content, $driver);
                        try {
                            $btn = $eTd[8]->findElement(WebDriverBy::cssSelector('input'));
                            // $btn = $driver->findElement(WebDriverBy::cssSelector('tr > td > table > tbody > tr:last-child > td:nth-child(9) > input'));
                            $btn->click();
                            // ---
                            // Not yet completed the reservation action
                            // ---
                        }catch(NoSuchElementException $e){
                            $isExists = false;
                        }
                    }
                    
                    $driver->navigate()->back();

                    break;

                } catch (NoSuchElementException $e){
                    $errorMessage = $errorMessage . '   ===   ' .'Error when forech '. $i . ' element : No Such Element';
                    $driver->quit();
                }
            }
        }

        $driver->quit();

        return;
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
}

?>