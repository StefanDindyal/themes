(function(){
  "use strict";

  console.log('form ok');

  var FORM                            = '.publisher-form';
  var FORM_MESSAGE                    = '.message';
  var FIRST_NAME                      = '.publisher-form input[name="firstName"]';
  var LAST_NAME                       = '.publisher-form input[name="lastName"]';
  var EMAIL                           = '.publisher-form input[name="email"]';
  var PHONE                           = '.publisher-form input[name="phoneNumber"]';
  var RADIO_UNIQUE                    = '.publisher-form input[name="montlyTraffic"]';
  var RADIO_TYPE                      = '.publisher-form input[name="inventoryType"]';
  var CHECKBOX_WEB                    = '.publisher-form input[value="Mobile Web"]';
  var CHECKBOX_APP                    = '.publisher-form input[value="Mobile App"]';
  var CHECKBOX_TABLET                 = '.publisher-form input[value="Tablet"]';
  var CHECKBOX_DESKTOP                = '.publisher-form input[value="Desktop"]';
  var MESSAGE                         = '.publisher-form input[name="message"]';
  var PUBURL                          = '.publisher-form input[name="website"]'; //added
  var MESSAGE_SENT                    = '#publisher-form-success';
  var SUBMIT                          = '.submit-publisher';
  var STEP_INPUTS                     = '.publisher-form .step';

  var $textarea;
  var $website; //added
  var $form; 
  var $firstName; 
  var $lastName; 
  var $phone; 
  var $email;
  var $rUnique; 
  var $rType; 
  var $checkboxWeb; 
  var $checkboxApp; 
  var $checkboxTablet; 
  var $checkboxDesktop;
  var $messageSent;
  var $step1Inputs;
  var $submit;

  /** Hubspot Form Fields **/

  var HBSPT_FORM              = '';
  var HBSPT_FN                = '.hs-input[name="firstname"]';
  var HBSPT_LN                = '.hs-input[name="lastname"]';
  var HBSPT_EM                = '.hs-input[name="email"]';
  var HBSPT_PH                = '.hs-input[name="phone"]';
  var HBSPT_MUT               = '.hs-input[name="monthly_unique_traffic"]';
  var HBSPT_IT                = '.hs-input[name="inventory_type"]';
  var HBSPT_ME                = '.hs-input[name="how_are_you_interested_in_working_with_us_"]';
  var HBSPT_PUBURL            = '.hs-input[name="website"]'; //added
  var HBSPT_WEB               = '.hs-input[value="Mobile Web"]';
  var HBSPT_APP               = '.hs-input[value="Mobile App"]';
  var HBSPT_TABLET            = '.hs-input[value="Tablet"]';
  var HBSPT_DESKTOP           = '.hs-input[value="Desktop"]';  

  var $hbsForm;
  var $hbsFirstName;
  var $hbsLastName;
  var $hbsPhone;
  var $hbsEmail;
  var $hbsMontly;
  var $hbsInventory;
  var $hsbWeb;
  var $hsbTablet;
  var $hsbDesktop;
  var $hbsInterested;
  var $hbsMessage;
  var $hbsWebsite; //added

  function init(hbspt_id){
    $textarea = $(FORM_MESSAGE);
    $website = $(PUBURL); //added
    $form = $(FORM); 
    $firstName = $(FIRST_NAME); 
    $lastName = $(LAST_NAME); 
    $phone = $(PHONE); 
    $email = $(EMAIL);
    $checkboxWeb = $(CHECKBOX_WEB); 
    $checkboxApp = $(CHECKBOX_APP); 
    $checkboxTablet = $(CHECKBOX_TABLET); 
    $checkboxDesktop = $(CHECKBOX_DESKTOP);
    $step1Inputs = $(STEP_INPUTS);
    $submit = $(SUBMIT);
    $messageSent = $(MESSAGE_SENT); 

    HBSPT_FORM = hbspt_id;
    autogrowTextArea($textarea);
    analyzeStep1();
    setPhoneMask();
    submitForm();
    var isRedirect= app.lib.util.getUrlParameter('hubspot');
    if(isRedirect){
      finalMessage();
    }
  }

  function autogrowTextArea($item){
    app.lib.util.autogrowTextArea($item);
  }

  function analyzeStep1(){
    $step1Inputs.change(function(){
      if($(this).attr("name") === "email"){
        validateInputEmail($(this));
      }else if ($(this).val() === '' && $(this).attr("name") !== "phone"){
        if(!$(this).hasClass('invalid')){ $(this).addClass('invalid'); }
      }else{
        $(this).removeClass('invalid');
      }
    });
  }

  function validateInputEmail($el){
    var result = validateEmail($el.val());
    if(!result){
      $el.addClass("invalid");
    }else{
      $el.removeClass("invalid");
    }
  }
  function validateEmail(email){
    return app.lib.util.validateEmail(email);    
  }

  function setPhoneMask(){
    $phone.mask("(999) 999-9999");
  }

  function step1Complete(){
    var complete = true; 
    if($firstName.val().trim() === "" || $lastName.val().trim() === ""  || $textarea.val().trim() === "" || $website.val().trim() === ""){ //added
      complete = false;
    }
    if($email.val().trim() === "" || $email.hasClass("invalid")){
      complete = false;
    }
    console.log('complete');
    return complete;
  }

  function submitForm(){
    $form.submit(function(event){
      event.preventDefault();
      if(step1Complete()){
        populateAndSubmitHubspotForm();
      } else {
        console.log('Sorry there is an error');
      }
    });
  }

  function populateAndSubmitHubspotForm(){
    $rUnique = $(RADIO_UNIQUE + ':checked');
    $rType = $(RADIO_TYPE + ':checked');
    $hbsMontly = $(HBSPT_MUT + '[value="' + $rUnique.val() + '"]');
    $hbsInventory = $(HBSPT_IT + '[value="' + $rType.val() + '"]');

    $hbsForm = $(HBSPT_FORM);
    $hbsFirstName = $(HBSPT_FORM + ' ' + HBSPT_FN);
    $hbsLastName = $(HBSPT_FORM + ' ' + HBSPT_LN);
    $hbsPhone = $(HBSPT_FORM + ' ' + HBSPT_PH);
    $hbsEmail = $(HBSPT_FORM + ' ' + HBSPT_EM);
    $hbsMessage = $(HBSPT_FORM + ' ' + HBSPT_ME);
    $hbsWebsite = $(HBSPT_FORM + ' ' + HBSPT_PUBURL); //added
    $hsbWeb = $(HBSPT_FORM + ' ' + HBSPT_WEB);
    $hsbTablet = $(HBSPT_FORM + ' ' + HBSPT_APP);
    $hsbDesktop = $(HBSPT_FORM + ' ' + HBSPT_TABLET);
    $hbsInterested = $(HBSPT_FORM + ' ' + HBSPT_DESKTOP);

    $hbsFirstName.val($firstName.val());
    $hbsLastName.val($lastName.val());
    $hbsPhone.val($phone.val());
    $hbsEmail.val($email.val());
    $hbsMessage.val($textarea.val());
    $hbsWebsite.val($textarea.val()); //added
    $hsbWeb.prop("checked", $checkboxWeb.prop("checked"));
    $hsbTablet.prop("checked", $checkboxApp.prop("checked"));
    $hsbDesktop.prop("checked", $checkboxTablet.prop("checked"));
    $hbsInterested.prop("checked", $checkboxDesktop.prop("checked"));
    $hbsMontly.prop("checked", true);
    $hbsInventory.prop("checked", true);

    // $hbsForm.submit();

    var info = $hbsForm.serialize();
    console.log(info);
  }

  function finalMessage(){
    $messageSent.modal('show'); 
    setTimeout(function(){ $messageSent.modal('hide'); }, 3000);
  }

  app.components.publisherForm = {
    init: init
  };

})();