//Script for Analytics
<!--//--><![CDATA[//><!--
var _rgdataLayer=[]; 
if(window.location.hash == '#thankyou') {_rgdataLayer.push({'formType':'Newsletter','formAction': 'Submitted'})}; 
if(window.location.hash == '#block') {_rgdataLayer.push({'formType':'Newsletter','formAction': 'Geo Blocked'})};
_rgdataLayer.push({'cust01':'19841.disney.fc.myplaydirectcrm.com'});
(function() {
    var e = document.createElement("script");
    e.type = "text/javascript"; e.async = true;
    e.src = "http" + (document.location.protocol === "https:" ? "s://ssl" : "://") + "tag.myplay.com/t/a/19841.disney.fc.myplaydirectcrm.com";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(e, s);
  })();
//--><!]]>
//Social Feature JS variables
var _rgfbAppId='270397179822351';
var _fbHashIdValue="19841";
var _scRegisterUrl='https://fc.myplay.com/apps/sc/register';
var _rgfbAppRight='email, user_birthday, user_interests, user_location';
var _formType='newsletter';
var _continueSignUpText="Hey %%FIRST_NAME%%, please fill additional fields to continue";

var _fbHashId='19841';
var _fcInstGratURL='https://fc.myplay.com/apps/sf/instantgrat';
var _fcCntryNtfcnURL='https://fc.myplay.com/apps/sf/countrynotifications';
var _fcPageTarget='top';

//Form relevant JS Variables
var signupValidationRequiredMessages=  { email: 'Please enter your email address', dob: 'Enter your Birth Date'};
var signupValidationInvalidMessages=  { first_name: 'Enter your First Name', last_name: 'Enter your Last Name', email: 'Please enter your email address', dob: 'Enter your Birth Date'};
//client side validation
var version=Math.floor(Math.random()*1001);
var fr=document.createElement('script');
fr.setAttribute("type","text/javascript");
fr.setAttribute("src", "//fcmedia.myplayd2c.com/common/js/sFC.js?vr="+version);
if (typeof fr!="undefined") {
	document.getElementsByTagName("head")[0].appendChild(fr);
}

//Ensures there will be no 'console is undefined' errors
window.console = window.console || (function(){
    var c = {}; c.log = c.warn = c.debug = c.info = c.error = c.time = c.dir = c.profile = c.clear = c.exception = c.trace = c.assert = function(){};
    return c;
})();

console.log('_fcInstGratURL = ' +_fcInstGratURL);
console.log('_fcCntryNtfcnURL = ' +_fcCntryNtfcnURL);
//For country specific notification - Start
var primaryNotification, secondaryNotification;

function getParameterByName(name){
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.search);
  if (results == null)
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}

var userName;
var jsonObj = {};
var initAppStatus;
var paramsJson;
var parsedJson;
var showInfoMsg=false;
var fbApiCallsCounter=0;
var totalFBApiCallsCount=21;
var graphApiDataLimit=100;

window.fbAsyncInit = function() {
	FB.init({
	  appId      : _rgfbAppId, // App ID
	  channelUrl : '', // Channel File
	  status     : true, // check login status
	  cookie     : true, // enable cookies to allow the server to access the session
	  xfbml      : true  // parse XFBML
	});

	FB.Event.subscribe('auth.authResponseChange', function(response)
		{
		 if (response.status === 'connected')
		{
			//document.getElementById("message").innerHTML +=  "<br>Connected to Facebook";		//SUCCESS
		}
		else if (response.status === 'not_authorized')
		{
			//document.getElementById("message").innerHTML +=  "<br>Failed to Connect";			//FAILED
		} else
		{
			//document.getElementById("message").innerHTML +=  "<br>Logged Out"; 			//UNKNOWN ERROR
		}
	});
};

// Load the SDK asynchronously
(function() {
	var e = document.createElement('script'); e.async = true;
	e.src = document.location.protocol +  '//connect.facebook.net/en_US/all.js';
	document.getElementById('fb-root').appendChild(e);
}());

function getFBData()
{
	FB.login(function(response) {
	//Populate initAppStatus once user logs into FB
	FB.getLoginStatus(function(response){
		//console.log('The App ID = ' + _rgfbAppId + ', Response Status = ' + response.status);
		initAppStatus=response.status;
	});

		if (response.authResponse)
		{
				// Get access token
				var access_token = response.authResponse.accessToken;
				jsonObj["accessToken"] = ((access_token === undefined) ? "" : access_token);
				//console.log('Access Token : '+access_token);

				//Begin FB Data Fetch 
				//Type I - The response data having different format and no pagination
				var beginTime = new Date();
				FB.api('/me',function(response) {
					jsonObj["userData"]=response;
					fbApiCallsCounter++;
				});
				FB.api('/me/picture?type=normal', function(response) {
					jsonObj["userPicture"]=response;
					fbApiCallsCounter++;
				});
				
				//Type II - The response data having pagination probability
				getAllFBData('/app', "userApp");
				getAllFBData('/me/accounts', "userAccounts");
				getAllFBData('/me/likes', "userLikes");
				getAllFBData('/me/interests', "userInterests");
				getAllFBData('/me/activities', "userActivities");
				getAllFBData('/me/books', "userBooks");				
				getAllFBData('/me/checkins', "userCheckins");
				getAllFBData('/me/events', "userEvents");
				getAllFBData('/me/friendlists', "userFriendlists");
				getAllFBData('/me/friends', "userFriends");
				getAllFBData('/me/games', "userGames");
				getAllFBData('/me/groups', "userGroups");
				getAllFBData('/me/permissions', "userPermissions");
				getAllFBData('/me/movies', "userMovies");
				getAllFBData('/me/music', "userMusic");
				getAllFBData('/me/music.listens', "userMusicListens");
				getAllFBData('/me/video.watches', "userVideoWatches");
				getAllFBData('/me/news.reads', "userNewsReads");
				getAllFBData('/me/notes', "userNotes");
				
				//Submit Social Data
				var myVar=setInterval(function(){
						
						if (fbApiCallsCounter == totalFBApiCallsCount) {
							clearInterval(myVar);

							if(_formType == 'contest'){
								hideContest(true);
							}
							//get the stringified json
							paramsJson = JSON.stringify(jsonObj);
							//parse the string into json object
							parsedJson = JSON.parse(paramsJson);
							
							//to save the data in DB
							saveFBData(paramsJson);
							
							//to set the field values with FB data
							setFieldValues(parsedJson);
							
							//to display the fields which are not having any data
							displayFormElements();
							
							document.getElementById('signup_source').value = 'FACEBOOK';
							fbApiCallsCounter=0;

							// Auto subscribe if no user input required
							if(showInfoMsg == false){
								var thisForm = document.forms[0];
                                                                if(validateSignupForm(thisForm)){
                                                                        thisForm.submit();
                                                                }
							}
						}
				},100);
		} else
		{
		 //console.log('User cancelled login or did not fully authorize.');
		}
	},{scope: _rgfbAppRight});				
}
		
function Logout()
{
	FB.logout(function(){document.location.reload();});
}

function setFieldValues(parsedJson){
	userName = parsedJson.userData.first_name === undefined ? 'there' : parsedJson.userData.first_name;
	var gender = parsedJson.userData.gender;
	if(elementExists('gender',true)){
		if(gender == 'male'){
			document.getElementsByName('gender')[1].checked = true;
		}
		else if(gender == 'female'){
			document.getElementsByName('gender')[0].checked = true;
		}
	}

	if(elementExists('first_name',true) && parsedJson.userData.first_name !== undefined ){
		document.getElementsByName('first_name')[0].value = parsedJson.userData.first_name;
	}

	if(elementExists('last_name',true) && parsedJson.userData.last_name !== undefined ){
		document.getElementsByName('last_name')[0].value = parsedJson.userData.last_name;
	}

	if(elementExists('email',true)  && parsedJson.userData.email !== undefined ){
		document.getElementsByName('email')[0].value = parsedJson.userData.email;
	}

	if( (elementExists('birth_month',true) ||
		elementExists('birth_day',true) ||
		elementExists('birth_year',true))   && parsedJson.userData.birthday !== undefined ){
		setBirthMonth(parsedJson.userData.birthday);
		setBirthDay(parsedJson.userData.birthday);
	}
	if(elementExists('city',true)  &&
		parsedJson.userData.location !== undefined  &&
		parsedJson.userData.location.name !== undefined ){
		setCityName(parsedJson.userData.location.name);
	}
}

function hideContest(flipContestVal){
	if(flipContestVal == true){
		if(elementExists('contest1_div',false)){
			document.getElementById('contest1_div').style.display = "none";
		}
		if(elementExists('contest2_div',false)){
			document.getElementById('contest2_div').style.display = "none";
		}
		if(elementExists('contest3_div',false)){
			document.getElementById('contest3_div').style.display = "none";
		}
		if(elementExists('contest4_div',false)){
			document.getElementById('contest4_div').style.display = "none";
		}
		if(elementExists('contest5_div',false)){
			document.getElementById('contest5_div').style.display = "none";
		}

	}else if(flipContestVal == false){
		if(elementExists('contest1_div',false)){
			showInfoMsg = true;
			document.getElementById('contest1_div').style.display = "block";
		}
		if(elementExists('contest2_div',false)){
			showInfoMsg = true;
			document.getElementById('contest2_div').style.display = "block";
		}
		if(elementExists('contest3_div',false)){
			showInfoMsg = true;
			document.getElementById('contest3_div').style.display = "block";
		}
		if(elementExists('contest4_div',false)){
			showInfoMsg = true;
			document.getElementById('contest4_div').style.display = "block";
		}
		if(elementExists('contest5_div',false)){
			showInfoMsg = true;
			document.getElementById('contest5_div').style.display = "block";
		}
	}
}

function saveFBData(params)
{
	jQuery.ajax({
		  url: _scRegisterUrl,
		  type: 'POST',
		  dataType: "json",
		  data: {
				fbJsonData: params,
				initAppStatus: initAppStatus,
				formIdHash: _fbHashIdValue,
				vendorCode : "FACEBOOK"
		  },
		  success: function( data ) {
		  }
	});
}

function setCityName(cityVal){
	var splitted = cityVal.split(',');
	document.getElementsByName('city')[0].value = splitted[0];
}

function setBirthMonth(birthDayVal) {
	var birthDayArrayVal = birthDayVal.split('/');
	var birthMonth = "Month";
	switch (birthDayArrayVal[0])
	{
	  case "01": birthMonth = "JAN";
				 break;
	  case "02": birthMonth = "FEB";
				 break;
	  case "03": birthMonth = "MAR";
				 break;
	  case "04": birthMonth = "APR";
				 break;
	  case "05": birthMonth = "MAY";
				 break;
	  case "06": birthMonth = "JUN";
				 break;
	  case "07": birthMonth = "JUL";
				 break;
	  case "08": birthMonth = "AUG";
				 break;
	  case "09": birthMonth = "SEP";
				 break;
	  case "10": birthMonth = "OCT";
				 break;
	  case "11": birthMonth = "NOV";
				 break;
	  case "12": birthMonth = "DEC";
				 break;
	  default:  birthMonth = "Month";
	}
	document.getElementsByName('birth_month')[0].value = birthMonth;
	document.getElementsByName('birth_year')[0].value = birthDayArrayVal[2];
}

function setBirthDay(birthDayVal) {
	var bDayArrayVal = birthDayVal.split('/');
	var birthDay = "Day";
	switch (bDayArrayVal[1])
	{
	  case "01": birthDay = "1";
				 break;
	  case "02": birthDay = "2";
				 break;
	  case "03": birthDay = "3";
				 break;
	  case "04": birthDay = "4";
				 break;
	  case "05": birthDay = "5";
				 break;
	  case "06": birthDay = "6";
				 break;
	  case "07": birthDay = "7";
				 break;
	  case "08": birthDay = "8";
				 break;
	  case "09": birthDay = "9";
				 break;
	  case "10": birthDay = "10";
				 break;
	  case "11": birthDay = "11";
				 break;
	  case "12": birthDay = "12";
				 break;
	  case "13": birthDay = "13";
				 break;
	  case "14": birthDay = "14";
				 break;
	  case "15": birthDay = "15";
				 break;
	  case "16": birthDay = "16";
				 break;
	  case "17": birthDay = "17";
				 break;
	  case "18": birthDay = "18";
				 break;
	  case "19": birthDay = "19";
				 break;
	  case "20": birthDay = "20";
				 break;
	  case "21": birthDay = "21";
				 break;
	  case "22": birthDay = "22";
				 break;
	  case "23": birthDay = "23";
				 break;
	  case "24": birthDay = "24";
				 break;
	  case "25": birthDay = "25";
				 break;
	  case "26": birthDay = "26";
				 break;
	  case "27": birthDay = "27";
				 break;
	  case "28": birthDay = "28";
				 break;
	  case "29": birthDay = "29";
				 break;
	  case "30": birthDay = "30";
				 break;
	  case "31": birthDay = "31";
				 break;
	  default:  birthDay = "Day";
	}
	document.getElementsByName('birth_day')[0].value = birthDay;
}

function getPhoto()
{
	var continueSignUpText = _continueSignUpText.replace('%%FIRST_NAME%%', userName);
	FB.api('/me/picture?type=normal', function(response) {
		document.getElementById("infoDiv").innerHTML="<center><img src='"+response.data.url+"' /></center><div style='font:10pt arial;font-weight:bold;color:red;'>" + continueSignUpText + "</div>";;
	});
}

function displayFormElements(){
	document.getElementById('mainForm').style.display = "block";

	if(elementExists('first_name',true)){
		if (document.getElementsByName('first_name')[0].value != '') {
			document.getElementById('fnLabel').style.display = "none";
			document.getElementById('firstNameDiv').style.display = "none";
		} else {
			showInfoMsg = true;
			document.getElementById('fnLabel').style.display = "block";
			document.getElementById('firstNameDiv').style.display = "block";
		}
	}

	if(elementExists('last_name',true)){
		if (document.getElementsByName('last_name')[0].value != '') {
			document.getElementById('lnLabel').style.display = "none";
			document.getElementById('lastNameDiv').style.display = "none";
		} else {
			showInfoMsg = true;
			document.getElementById('lnLabel').style.display = "block";
			document.getElementById('lastNameDiv').style.display = "block";
		}
	}

	if(elementExists('email',true)){
		if (document.getElementsByName('email')[0].value != '') {
			document.getElementById('emailLabel').style.display = "none";
			document.getElementById('emailDiv').style.display = "none";
		} else {
			showInfoMsg = true;
			document.getElementById('emailLabel').style.display = "block";
			document.getElementById('emailDiv').style.display = "block";
		}
	}

	if(elementExists('gender',true)){
		if (document.getElementsByName('gender')[0].checked == true || document.getElementsByName('gender')[1].checked == true) {
			document.getElementById('genderLabel').style.display = "none";
			document.getElementById('genderDiv_F').style.display = "none";
			document.getElementById('genderDiv_M').style.display = "none";
		} else {
			showInfoMsg = true;
			document.getElementById('genderLabel').style.display = "block";
			document.getElementById('genderDiv_F').style.display = "block";
			document.getElementById('genderDiv_M').style.display = "block";
		}
	}

	if(elementExists('city',true)){
		if (document.getElementsByName('city')[0].value != '') {
			document.getElementById('cityLabel').style.display = "none";
			document.getElementById('cityDiv').style.display = "none";
		} else {
			showInfoMsg = true;
			document.getElementById('cityLabel').style.display = "block";
			document.getElementById('cityDiv').style.display = "block";
		}
	}

	if(elementExists('country',true)){
		if (document.getElementsByName('country')[0].value != '') {
			document.getElementById('countryLabel').style.display = "none";
			document.getElementById('countryDiv').style.display = "none";
		} else {
			showInfoMsg = true;
			document.getElementById('countryLabel').style.display = "block";
			document.getElementById('countryDiv').style.display = "block";
		}
	}

	if(elementExists('birth_month',true) ||
	   elementExists('birth_day',true) ||
	   elementExists('birth_year',true)){
		if (document.getElementsByName('birth_month')[0].value == 'Month'
			|| document.getElementsByName('birth_day')[0].value == 'Day'
			|| document.getElementsByName('birth_year')[0].value == 'Year') {
			showInfoMsg = true;
			document.getElementById('birthDateLabel').style.display = "block";
			document.getElementById('birthDateDiv').style.display = "block";
		} else {
			document.getElementById('birthDateLabel').style.display = "none";
			document.getElementById('birthDateDiv').style.display = "none";
		}
	}
	if(_formType == 'contest'){
		hideContest(false);
	}
	
	var reqFields = document.getElementsByName('required_fields');
	for(var i=0; i<reqFields.length; i++){
		if((reqFields[i].value).indexOf('privacy_check') == 0){
			showInfoMsg = true;
			break;
		}
	}

	var services = document.getElementsByName('list');
	for(var index=0; index<services.length; index++){
		if(services[index].type == 'checkbox'){
			showInfoMsg = true;
			break;
		}
	}
	if(showInfoMsg){
		getPhoto();
		document.getElementById('infoDiv').style.display = "block";
	}
}

function showDiv(){
	document.getElementById('mainForm').style.display = "block";
}

function elementExists(elementIdentifier, byName){
	if(byName){
		return (document.getElementsByName(elementIdentifier).length > 0);
	}
	else {
		return (document.getElementById(elementIdentifier) != null);
	}
}

//Util Function to get all Data from Graph API
function getAllFBData(apiURL, dataCategory) {
        var isDataForJson=false;
		
        FB.api(apiURL, function(response){
                //Impose the limitation
                apiURL = apiURL+'?limit='+graphApiDataLimit;

                var apiResp = {"data" : []};
                var intResp = response;
                var nextUrl;

                if (typeof intResp.data === 'undefined')
                        console.log('response.data missing for apiURL = ' +apiURL);
                //Case I - less Data recieved than set Limit
                if (intResp.data && intResp.data.length < graphApiDataLimit) {
                        apiResp.data = apiResp.data.concat(intResp.data);
                        isDataForJson=true;
                }

                //Case II - Data recived is equal to set Limit(graphApiDataLimit), hence, probably more data available.
                while (intResp && 
						(intResp.data && intResp.data.length == graphApiDataLimit) && 
						(intResp.paging && (intResp.paging.next || (intResp.paging.cursors && intResp.paging.cursors.after)))
					) {
                        //Move the intermediate data to apiResp
                        apiResp.data = apiResp.data.concat(intResp.data);

                        //Format nextURL based on pagination option available
                        if (intResp.paging.next)
                            nextUrl = intResp.paging.next;
                        else
                            nextUrl = apiURL+'&after='+intResp.paging.cursors.after;

                        //Fetch more data with the help of nextUrl
                        FB.api(nextUrl, function(response) {
                            intResp = response;
                        });
                        isDataForJson=true;
                }

                //Add the final Data Response to jsonObj and increament the FB API calls counter
                if(isDataForJson)
                        jsonObj[dataCategory]=apiResp;
                fbApiCallsCounter++;
        });
}