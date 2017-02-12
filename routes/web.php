<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
//Upload and process race
Route::get('/upload-race', 'UploadRaceController@uploadRace');
Route::post('/upload-race/complete', 'UploadRaceController@storeRace')->name('upload-race-complete');
//Upload and process atheltes
Route::get('/upload-athlete', 'UploadAthleteController@uploadAthlete');
Route::post('/upload-athlete/complete', 'UploadAthleteController@storeAthlete')->name('upload-athlete-complete');

//Change User Name Page
Route::get('/profile-settings', 'UserSettingsController@profileSettings');
Route::post('/change-username/complete', 'UserSettingsController@userNameChanged')->name('username-changed');

//Create Athletes Page that lists all athletes
Route::get('/athletes','AthleteController@index');

//Individual Athlete Pages
Route::get('/athletes/{id}','AthleteController@showAthletes');

//Results Home Page
Route::get('/results','ResultsController@results');
//Show Results
Route::get('/results/{id}','ResultsController@showResults');

//Allow user to set lineup
Route::get('/set-lineup', 'SetLineupController@setLineup')->name('set-lineup');
Route::get('/set-lineup/men', 'SetLineupController@setLineupMen')->name('set-lineup-men');
Route::get('/set-lineup/women', 'SetLineupController@setLineupWomen')->name('set-lineup-women');

//ajax route for setting lineup
Route::get('/get-users-lineup', 'SetLineupController@getUsersLineup');
//ajax route for saving lineup
Route::post('/save-users-lineup', 'SetLineupController@saveUsersLineup');
Route::get('/get-athlete-stats', 'SetLineupController@getAthleteStats');

//Route for leagues page
Route::get('/leagues','LeagueController@displayLeagues');
//Individual league pages
Route::get('/leagues/{id}','LeagueController@showLeague');
//League Created Page
Route::post('/leagues/created','LeagueController@createNewLeague')->name('league-created');

//ajax route for joining a league
Route::post('/join-league', 'LeagueController@joinLeague');

//ajax route for leaving a league
Route::post('/leave-league', 'LeagueController@leaveLeague');

// Send a message by Javascript.
Route::post('/message', 'HomeController@message');

//Profile picture submit route
Route::post('/profile-settings','UserSettingsController@changeProfilePic');

//User profiles
Route::get('/user/{name}','UserController@showUser');

//Give user points
Route::get('/score-race','ScoreRaceController@score');

//Score race submit route
Route::post('/score-race','ScoreRaceController@scoreRace');

//Rankings Page
Route::get('/rankings','RankingController@ranking');

//Set Time to close lineup selection
Route::get('/close-lineups','UploadAthleteController@uploadTimes');

//Submit route close lineups
Route::post('/close-lineups','UploadAthleteController@storeTimes');

//post route to unsubsribe from emails
Route::post('/unsubscribe','UserSettingsController@unsubscribe');


