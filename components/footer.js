(function(){
  "use strict";
  var $pageColumns;
  var $links;
  var $triangle;
  var $form1;
  var $form2;
  var $email;
  var $submit;
  var $firstName;
  var $lastName;
  var $job;
  var $company;
  var $modalButtons;
  var $successMessage;
  var $modalEmail;
  var $step1Inputs;

  /** Hubppot Form Fields **/
 
  var HBSPT_FORM_COMPLETE = '';
  var $hbsForm;
  var $hbsEmail;
  var $hbsFirstName;
  var $hbsLastName;
  var $hbsCompany;
  var $hbsJob;
  var $hbsInterest;

  function init(hbspt_complete_id){
    HBSPT_FORM_COMPLETE = hbspt_complete_id;

    $pageColumns        = $(".footer-bar > .menu-item");
    $links              = $(".links-and-submit");
    $triangle           = $(".triangle-background");
    $form1              = $(".footer-newsletter");
    $form2              = $(".newsletter-complete");
    $submit             = $(".submit-email");
    $firstName          = $("input[name='newsFirstName']");
    $lastName           = $("input[name='newsLastName']");
    $job                = $("input[name='newsJob']");
    $company            = $("input[name='newsCompany']");
    $email              = $("input[name='email2']");
    $modalButtons       = $("#modal-buttons");
    $modalEmail         = $("#newsletter-part2");
    $successMessage     = $(".sucess-message-form");
    $step1Inputs        = $(".newsletter-complete .step");

    injectClasses();
    resizeTriangle();
    analyzeStep();
    triggerModal();
    triggerHubspotForm();
    var id = app.lib.util.createUniqueId();
    var isRedirect= app.lib.util.getUrlParameter('step');
    showMessage(isRedirect);
  }

  function injectClasses(){
    $pageColumns.each(function(){
      $(this).addClass("col-xs-6 col-sm-3");
    });
  }

  function resizeTriangle(){
    var newHeight = $links.innerHeight();
    $triangle.css("border-bottom-width", newHeight);
    $(window).resize(function(){
      newHeight = $links.innerHeight();
      $triangle.css("border-bottom-width", newHeight);
    });
  }


  function triggerModal(){
    $form1.click(function() {
      $modalEmail.modal('show');
    });
  }

  function triggerHubspotForm(){
    $form2.on('submit', function(event){
      event.preventDefault();
      var interests =  $(".footer-interest:checked"); 
      if(interests.length > 0 && stepComplete()){
        populateAndSubmitHubspotForm2(interests);
      }
    });
  }

 function analyzeStep(){
    $step1Inputs.change(function(){
      if($(this).attr("name") === "email2"){
        validateInputEmail($(this));
      }else if ($(this).val() === ''){
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

  function stepComplete(){
    var complete = true; 
    if($firstName.val().trim() === "" || $lastName.val().trim() === ""  || $job.val().trim() === "" || $company.val().trim() === ""){
      complete = false;
    }
    if($email.val().trim() === "" || $email.hasClass("invalid") ){
      complete = false;
    }
    return complete;
  }

  function populateAndSubmitHubspotForm2($interests){
    $hbsForm     = $(HBSPT_FORM_COMPLETE);
    $hbsFirstName = $(HBSPT_FORM_COMPLETE + ' .hs-input[name="firstname"]');
    $hbsLastName  = $(HBSPT_FORM_COMPLETE + ' .hs-input[name="lastname"]');
    $hbsEmail     = $(HBSPT_FORM_COMPLETE + ' .hs-input[name="email"]');
    $hbsJob       = $(HBSPT_FORM_COMPLETE + ' .hs-input[name="jobtitle"]');
    $hbsCompany   = $(HBSPT_FORM_COMPLETE + ' .hs-input[name="company"]');

    $hbsFirstName.val($firstName.val());
    $hbsLastName.val($lastName.val());
    $hbsJob.val($job.val());
    $hbsEmail.val($email.val());
    $hbsCompany.val($company.val());
    // /$(HBSPT_FORM_COMPLETE + ' .hs-input[name="sign_up_for_our_newsletter"]').prop("checked", true);
    $.each($interests, function(key, value){
      $hbsInterest = $(HBSPT_FORM_COMPLETE + ' .hs-input[value="'+$(value).attr("name")+'"]');
      $hbsInterest.prop("checked", true);
    });
    $hbsForm.submit();
  }

  function showMessage(step){
    if (step==="one") {
      $modalEmail.modal('show');
      $("#newsletter-part2 :input").prop("disabled", true);
      $(".btn-okay").prop("disabled", false);
      $modalButtons.hide();
      $successMessage.show();
    }
  }

  app.components.footer = {
    init: init
  };

})();