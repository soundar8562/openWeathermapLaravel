<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City_list;

class APIcontroller extends Controller
{

	public function create()
	{
		$json_file = file_get_contents(asset('/json/city_list.json'));
		$tempArray = json_decode($json_file);
		$size=sizeof($tempArray);

		foreach ($tempArray as $value) {
			$city_name[]=$value;	
		}
		for ($i=92050; $i <= $size ; $i++) {
			City_list::create(['name' => $city_name[$i]->name,]); 
		}
	}

	public function api()
	{
		return view('welcome');	
	}

	public function apicall(Request $req)
	{

		$instant_search=$req->search;
		$city=City_list::where('name','LIKE',"%$instant_search%")->limit(6)->get();
		$sz=sizeof($city);
		for ($i=0; $i <$sz ; $i++) { 
			$city_name=$city[$i]->name;
			echo "<style>
			a{
				  margin-top: -1px; /* Prevent double borders */
				  background-color: transperant;
				  padding: 10px;
				  text-decoration: none;
				  font-size: 18px;
				  color: black;
				  display: block
			}
			a:hover{
				  border: 1px solid #ddd;
				  margin-top: -1px; /* Prevent double borders */
				  background-color: #f6f6f6;
				  padding: 12px;
				  text-decoration: none;
				  font-size: 18px;
				  color: black;
				  display: block
			}
			</style>";
			echo "<a style='padding-left:12px;cursor:pointer;' role='presentation' id='$city_name' class='hov'>$city_name</a>";
		}
		
	}

	public function city(Request $req)
	{
		$city=$req->city;
		$url ="http://api.openweathermap.org/data/2.5/forecast?q=$city&APPID=face8e6010b8225cdc1456350031f406";
		$arr=file_get_contents($url);
		$apiret=json_decode($arr);
		$city_id=$apiret->city->id;
		$url ="http://api.openweathermap.org/data/2.5/weather?id=$city_id&lang=en&units=metric&APPID=face8e6010b8225cdc1456350031f406";
		$arr=file_get_contents($url);
		$apiret=json_decode($arr);
		
		$country=$apiret->sys->country;
		$long=$apiret->coord->lon;
		$lat=$apiret->coord->lat;

		$desc=$apiret->weather[0]->description;
		$climate=$apiret->weather[0]->main;	
			if($climate=='Clear'){
				$weather_img=asset('/img/sunny.gif');
			}
			elseif ($climate=='Rain') {
				$weather_img=asset('/img/rainy.gif');
			}
			elseif ($climate=='Drizzle') {
				$weather_img=asset('/img/rainy.gif');
			}
			elseif ($climate=='Snow') {
				$weather_img=asset('/img/snow.gif');
			}
			else{
				$weather_img=asset('/img/cloudy.gif');
			}
		$city=$apiret->name;
		$rnd=$apiret->main->temp;
		$temp=round($rnd);
		$wthr_ret[] = array(
							"wcity_name"	=>  $city,
							"country"	=>  $country,
							"long" 	        =>  $long,
							"lat" 	        =>  $lat,
							"wcity_img"		=>  $weather_img,
				 			"wcity_desc" 	=>  $desc,
							"wcity_temp"	=>  $temp,
                        );
		return json_encode($wthr_ret);
	}
}
