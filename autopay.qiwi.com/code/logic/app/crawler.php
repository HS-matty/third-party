<?php

class Logic_App_Crawler extends Std_Class{




	public static function fetch($name, $element){



		require_once PATH_LIB.'/PEAR/Testing/Selenium.php';
		require_once (PATH_LIB.'/sel/Selenium.php');
		require_once(PATH_LIB.'/curl.php');


		$vendor = (string) $element->getElement('vendor');
		$model = (string) $element->getElement('model');
		$year_start = (string) $element->getParam('year_start');
		$year_end = (string) $element->getParam('year_end');
		switch ($name){

			case 'cars.com':

				$test = new Testing_Selenium("*firefox", "http://www.cars.com");
				$test->start();
				$test->open("/");



				$test->click("id=page");
				$test->click("id=adv-search-link");
				$test->waitForPageToLoad("30000");
				$test->click("id=rd");
				$test->select("id=rd", "label=100");
				$test->type("id=zc", "80111");
				$test->click("id=make_0");
				$test->select("id=make_0", "label={$vendor}");
				$test->click("css=option[value=\"20049\"]");
				$test->select("id=model_0", "label={$model}");
				$test->select("id=yearlow", "label={$year_start}");
				$test->select("id=yearhigh", "label={$year_end}");
				//	$test->select("id=color", "label=Black");
				//	$test->click("id=drive");
				//	$test->select("id=drive", "label=4x2/2-wheel drive");
				//	$test->select("id=trans", "label=Automanual");
				$test->click("css=option[value=\"28114\"]");
				//	$test->select("id=trans", "label=Manual");
				//	$test->click("id=fuel4");
				$test->click("id=sellertype28879");
				$test->select("id=rpp", "label=250");
				$test->click("css=#rpp > option[value=\"250\"]");
				$test->click("link=Search");
				$test->waitForPageToLoad("30000");
				sleep(10);

				/*				$test->click("id=adv-search-link");
				$test->click("id=rd");
				$test->select("id=rd", "label=100");
				$test->click("css=option[value=\"100\"]");
				$test->type("id=zc", "80111");
				$test->select("id=make_0", "label={{$vendor}}");
				$test->click("css=option[value=\"20049\"]");
				$test->click("id=model_0");
				$test->select("id=model_0", "label={$model}");
				$test->select("id=yearlow", "label={$year_start}");
				$test->select("id=yearhigh", "label={$year_end}");
				$test->click("id=date");
				$test->click("id=date");
				$test->click("id=sellertype28879");
				$test->click("id=rpp");
				$test->select("id=rpp", "label=250");
				$test->click("css=#rpp > option[value=\"250\"]");
				$test->click("link=Search");
				$test->waitForPageToLoad(9000);
				sleep(10);*/


				/*				$test->select("name=make", "label={$vendor}");
				$test->click("name=model");
				$test->select("name=model", "label={$model}");
				$test->click("name=prMx");
				$test->select("name=prMx", "label=No Maximum Price");
				$test->click("css=select[name=\"prMx\"] > option");
				$test->click("id=select-rd-new");
				$test->select("id=select-rd-new", "label=100 Miles");
				$test->type("id=zc2", "80111");
				$test->click("id=selSearchUSED");
				$test->click("id=submitSearchButton");
				$test->waitForPageToLoad(9000);*/
				//$test->isElementPresent()

				/*$test->waitForCondition("var x = selenium.browserbot.findElementOrNull('resultswrapper');"
				+ "x != null && x.style.display == 'none';", "50000");*/
				//sleep(15);


				break;
			case 'autotrader.com':
				$test = new Testing_Selenium("*firefox", "http://www.autotrader.com");
				$test->start();
				$test->open("/");


				$test->select("id=j_id_37-j_id_39-j_id_3a_8w-j_id_3a_9m-j_id_3a_9p-j_id_3a_9q-make", "label={$vendor}");
				$test->click("id=j_id_37-j_id_39-j_id_3a_8w-j_id_3a_9m-j_id_3a_9p-j_id_3a_9y-j_id_3a_a3-j_id_3a_a3");
				$test->waitForPageToLoad("30000");
				$test->click("id=j_id_2i-col1-listingsSearch-search-type-listingType-3");
				$test->select("id=j_id_2i-col1-listingsSearch-search-area-fr-searchRange", "label=100 Miles");
				$test->select("id=j_id_2i-col1-listingsSearch-makemodel-model1", "label={$model}");
				$test->select("id=j_id_2i-col1-listingsSearch-years-col1-fr1-fromYear", "label={$year_start}");
				$test->select("id=j_id_2i-col1-listingsSearch-years-col2-fr2-toYear", "label={$year_end}");
				$test->click("id=j_id_2i-col1-listingsSearch-sellerType-forsaleby-2");
				$test->click("id=j_id_2i-col1-listingsSearch-j_id_7z-j_id_81-j_id_81");
				$test->waitForPageToLoad("30000");
				sleep(10);


				/*
				$test->select("id=j_id_37-j_id_39-j_id_3a_8w-j_id_3a_9m-j_id_3a_9p-j_id_3a_9q-make", "label={$vendor}");
				$test->type("id=j_id_37-j_id_39-j_id_3a_8w-j_id_3a_9m-j_id_3a_9p-j_id_3a_9y-zipCode", "80111");
				$test->click("id=j_id_37-j_id_39-j_id_3a_8w-j_id_3a_9m-j_id_3a_9p-j_id_3a_9y-j_id_3a_a3-j_id_3a_a3");
				$test->waitForPageToLoad("30000");
				$test->click("id=j_id_2i-col1-listingsSearch-search-type-listingType-3");
				$test->select("id=j_id_2i-col1-listingsSearch-search-area-fr-searchRange", "label=100 Miles");
				$test->select("id=j_id_2i-col1-listingsSearch-makemodel-model1", "label={$model}");
				$test->click("css=div.atcui-clear");
				$test->select("id=j_id_2i-col1-listingsSearch-years-col1-fr1-fromYear", "label={$year_start}");
				$test->select("id=j_id_2i-col1-listingsSearch-years-col2-fr2-toYear", "label={$year_end}");
				$test->click("id=j_id_2i-col1-listingsSearch-sellerType-forsaleby-2");
				$test->click("id=j_id_2i-col1-listingsSearch-j_id_7z-j_id_81-j_id_81");
				$test->waitForPageToLoad("30000");*/

				/*$test->type("id=j_id_37-j_id_39-j_id_3a_8w-j_id_3a_9m-j_id_3a_9p-j_id_3a_9y-zipCode", "80111");
				$test->click("id=j_id_37-j_id_39-j_id_3a_8w-j_id_3a_9m-j_id_3a_9p-j_id_3a_9y-j_id_3a_a3-j_id_3a_a3");
				$test->waitForPageToLoad("30000");
				$test->click("id=j_id_2i-col1-listingsSearch-search-type-listingType-3");
				$test->select("id=j_id_2i-col1-listingsSearch-search-area-fr-searchRange", "label=100 Miles");
				$test->select("id=j_id_2i-col1-listingsSearch-makemodel-make1", "label=".$vendor);
				$test->select("id=j_id_2i-col1-listingsSearch-makemodel-model1", "label=".$model);
				$test->select("id=j_id_2i-col1-listingsSearch-years-col1-fr1-fromYear", "label=".$year_start);
				$test->select("id=j_id_2i-col1-listingsSearch-years-col2-fr2-toYear", "label=".$year_end);
				$test->click("id=j_id_2i-col1-listingsSearch-sellerType-forsaleby-2");
				$test->click("id=j_id_2i-col1-listingsSearch-j_id_7z-j_id_81-j_id_81");
				$test->waitForPageToLoad("9000");*/
				sleep(10);




				break;

			case 'craigslist.com':

				$test = new Testing_Selenium("*firefox", "http://denver.craigslist.org/");
				$test->start();
				$test->open("/cto/");
				$test->click("link=by owner");
				$test->waitForPageToLoad("30000");
				$test->type("id=query", "{$vendor}");
				$test->click("css=input[type=\"submit\"]");
				$test->waitForPageToLoad("30000");
				$test->type("id=query", "{$vendor} {$model}");
				$test->click("css=input[type=\"submit\"]");
				$test->waitForPageToLoad("30000");
				$test->click("name=hasPic");
				//	$test->click("id=gridview");
				$test->click("id=picview");
				$test->waitForPageToLoad("9000");
				sleep(10);

				break;


			case 'backpage.com':

				$test= new Testing_Selenium("*firefox", "http://denver.backpage.com/");
				$test->start();

				$test->open("/");
				$test->click("link=auto-truck-rv");
				$test->waitForPageToLoad("30000");
				$test->click("name=keyword", "{$model} {$vendor}");
				$test->click("id=searchButton");
				$test->waitForPageToLoad("30000");

				/*$test->open("/automotive/");
				$test->type("name=keyword", "{$vendor} {$model}");
				$test->select("css=select[name=\"category\"]", "label=autos for sale");
				$test->click("id=searchButton");
				$test->waitForPageToLoad("30000");
				$test->click("link=summary");
				$test->waitForPageToLoad("30000");*/
				sleep(10);
				break;



		}
		sleep(5);



		$query_string =  $test->getLocation();

		//elem = driver.find_element_by_xpath("//*")
		//source_code = elem.get_attribute("outerHTML")
		//	$test->setSpeed(200);
		//sleep(5);
		//$html = $test->getAttribute('resultswrapper');
		$html = $test->getHtmlSource();
		//	$test->getEval('window.focus();'); //executeScript("window.focus();");
		//	$test->keyUpNative(122);//key_press_native(122)
		$test->windowFocus();;
		$test->windowMaximize();;
		$test->getEval('window.scrollBy(0,100);');
		$screenshot = $test->captureScreenshotToString();



		/*       $test->setSpeed(4000);
		$html_source2 = $test->getHtmlSource();
		$html_source = $test->getHtmlSource();
		$test->setSpeed(0); */

		//$html  =	$html_source.$html_source2;


		//		/$
		//$test->getHtmlSource();

		//$curl = new cURL();
		//$query = 'http://www.cars.com/for-sale/searchresults.action?stkTyp=N&tracktype=newcc&rd=100000&zc=02108&searchSource=TRAIL_HEAD&enableSeo=1';
		//$html = $curl->get($query);

		$element->setParam('html',$html);
		$element->setParam('query_string',$query_string);
		$element->setParam('screenshot',$screenshot);
		sleep(2);
		$test->stop();
		return $element;




	}



}


?>