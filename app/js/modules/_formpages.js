define(['jquery', 'spin'], function($) {

    var $win;

    /**
     * Add spinner to element (not apppending element)
     * @param {[type]} elem element to contain the spinner
     */
    var addSpinnerToElement = function( elem ) {
        var opts = {
          lines: 11, // The number of lines to draw
          length: 29, // The length of each line
          width: 8, // The line thickness
          radius: 56, // The radius of the inner circle
          corners: 1, // Corner roundness (0..1)
          rotate: 0, // The rotation offset
          direction: 1, // 1: clockwise, -1: counterclockwise
          color: '#000', // #rgb or #rrggbb or array of colors
          speed: 1.1, // Rounds per second
          trail: 36, // Afterglow percentage
          shadow: false, // Whether to render a shadow
          hwaccel: false, // Whether to use hardware acceleration
          className: 'spinner', // The CSS class to assign to the spinner
          zIndex: 2e9, // The z-index (defaults to 2000000000)
          top: '50%', // Top position relative to parent
          left: '50%' // Left position relative to parent
        };

        var spinner = new Spinner(opts).spin( elem );
    }

    /** 
     * validate through required inputs to ensure no empty value
     * @return {nil}    
     */
    var requiredMeetsValidation = function() {
        validated = true;
        $('.required').each( function() {

                
            if ( $(this).is('input[type=checkbox]') || $(this).is('input[type=radio]') ) {
                var ID = $(this).attr('name');
                if ( !$('input[name=' + ID + ']:checked').val() ) {
                    validated = false;
                    $(this).parent().parent().parent().addClass('error-input');
                } else {
                    $(this).parent().parent().parent().removeClass('error-input');
                }
            } else if ( $(this).val() === "") {
                validated = false;
                $(this).addClass('error-input');
            } else if ( !$(this).hasClass('.phone-validation') &&  !$(this).hasClass('.email-validation') ) {
                $(this).removeClass('error-input');
            }
        });

        return validated;
    }

    /**
     * Validation of Email
     * @param  {string} email
     * @return {bool}
     */
    var validateEmail = function(email) { 
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    } 


    /**
     * Make User ID cookie
     */
    var makeUIDCookie = function() {
        var r = randString(10),
            t = $.now(),
            hash = stringHash( $win[0].navigator.userAgent );
            uid = r+'_'+t+'_'+hash;
        $.cookie(SESSION_USERID, uid, { expires: 365, path: '/' });

        return uid;
    }

    /**
     * Make User Project ID cookie
     */
    var makePIDCookie = function(uid) {
        var r = randString(10),
            t = $.now(),
            hash = stringHash( uid );
            pid = r+'_'+t+'_'+hash;
        $.cookie(uid, pid, { expires: 30, path: '/' });

        return pid;
    }

    /**
     * Add cookies
     * @param {Array} data Associated array of information
     */
    var addCookies = function( data ) {
        var uid = '', oldDataString, submittedData, pid;

        if ( ! $.cookie(SESSION_USERID) ) {
            uid = makeUIDCookie();
            pid = makePIDCookie(uid);

        } else {
            uid = $.cookie(SESSION_USERID);

            if ( ! $.cookie(uid) || $.cookie(uid) == "" ) {
                pid = makePIDCookie(uid);
            } else {
                pid = $.cookie(uid);
            }
        }
        
        if ( data ) {
            oldDataString = $.cookie(pid);
            if (oldDataString && oldDataString !== "" && oldDataString !== "undefined") {
                
                submittedData = $.parseJSON(oldDataString);

                for (var key in data) {
                    submittedData[key] = data[key];
                };
            } else {
                submittedData = data;
            }

            $.cookie(uid, pid, { expires: 30, path: '/' });
            $.cookie(pid,JSON.stringify(submittedData), { expires: 30, path: '/' });

            return submittedData;
        }

        return null;
    }

    /**
     * persist data on form page
     * @param  {the current object calling saving form session}   obj
     * @param  {Function} callback
     * @return {nil}
     */
    var saveSessionData = function(obj, callback ) {
        if (!$win[0].finished) {
            var persistedArray = {};
            $('.persist').each(function() {
                if ( $(this).attr('name') ) {
                    if ( ($(this).attr('type') == 'radio' ||  $(this).attr('type') == 'checkbox') && this.checked ) {
                        persistedArray[$(this).attr('name')] = $(this).val();
                    } else if ( !($(this).attr('type') == 'radio' ||  $(this).attr('type') == 'checkbox') ) {
                        persistedArray[$(this).attr('name')] = $(this).val();
                        
                    }
                }
            });

            persistedArray = addCookies( persistedArray );

            $.ajax({
                url: '/wp-content/themes/kerftheme/lib/classes/form_session.php',
                type: 'POST',
                data: persistedArray,
                datatype: 'json',
                success: function(data) {
                    console.log('persisted success!');
                    if (typeof(callback) == "function") {
                        callback(obj);
                    }
                },
                error: function(xhr, textStatus, thrownError) {
                    console.log("ERROR:" + textStatus +" - "+thrownError + " - " + xhr.responseText);
                    if (typeof(callback) == "function") {
                        callback(obj);
                    }
                }
            });
        }
    }

    /**
     * Actions on page away
     * @param  {html or jquery element} element
     * @return {false}
     */
    var formClickAway = function( element, callback) {
        var validated = requiredMeetsValidation();

        $('.error-input').each( function() {
            validated = false;
            $(this).effect("shake");
        });


        if ( validated) {
            saveSessionData(element, function( elem ) {
                $('#form-main').fadeTo("fast", 0.01, function(){
                    
                    if ( $(elem).attr('href')) {
                        $win[0].location = $(elem).attr('href');
                    } else if (typeof(callback) == "function") {
                        callback();
                    }
                });
            });
        } else {
            if ($('.error-input').length > 0) {
                var p = $('.error-input').offset().top-200;
                $win.scrollTop(p);
            }
        }
        return false;
    }


    /**
     * Uploading file handler using XHR
     * @param  {HTML element} input element storing the file
     * @return {nil}      
     */
    var uploadFile = function( elem ) {
        var progressID = $(elem).attr('data-progress'),
            progressBar = $('#'+progressID),
            file = $(elem)[0].files[0],
            name = $(elem).attr('name'),
            progress = 0,
            progressWidth,
            fd,
            uid = $win.user_cookie_id,
            pid = $win.project_cookie_id;

        updateProgress(progressBar, .05);
        var fd = new FormData();
        fd.append("uid", $win.user_cookie_id);
        fd.append("pid", $win.project_cookie_id);
        fd.append("file_submission",file, file.name);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr['status'] == 200 ) {
                    var msg = xhr['msg'];
                    var response = $.parseJSON(xhr.responseText);
                    var filename = response['name'];
                    var url = response["msg"]
                    var htmlString = '<a id="delete-' + name + '" href="javascript:void(0);">Remove</a>';
                    htmlString += '<input class="persist" type="hidden" name="' + name + '" value="' + url + '">';

                    updateProgress(progressBar, 1, function() {
                        console.log('appending with message');
                        progressBar.html( htmlString );
                        // progressBar.fitText();
                        progressBar.css('opacity','1');
                        $(elem).removeAttr('name').removeClass('persist');
                        $('#delete-'+name).on('click', function() {
                            deleteFile( url, this, nicelyRemoveFile, cannotRemoveFile );
                        })
                    });
                } else {    
                    var randomString = randString(5);
                    var htmlString = '<a id="delete-' + randomString + '" href="javascript:void(0);">Remove</a>';
                    progressBar.addClass('error');
                    updateProgress(progressBar, 1, function() {
                        console.log('appending error message');
                        progressBar.html( htmlString)
                        progressBar.css('opacity','1');
                        $(elem).removeAttr('name').removeClass('persist');
                        $('#delete-'+randomString).on('click', function() {
                            nicelyRemoveFile(this, null);
                        });

                    });
                }
            }
        }

        xhr.open('POST', '/wp-content/themes/kerftheme/lib/classes/s3_uploader.php', true); //MUST BE LAST LINE BEFORE YOU SEND 
        xhr.send(fd);
    }


    /**
     * Remove the file from s3
     * @param  {String} deleteLink         url of the deleted file
     * @param  {jquery element} obj                for usage on callback
     * @param  {function} callbackComplete   callback on success
     * @param  {function} callbackIncomplete callback on error
     * @return {nil}                    
     */
    var deleteFile = function(deleteLink, obj, callbackComplete, callbackIncomplete) {
        var data = {"delete_file": deleteLink};


        $.ajax({
            url: '/wp-content/themes/kerftheme/lib/classes/s3_deleter.php',
            type: 'POST',
            data: data,
            datatype: 'json',
            success: function(data) {
                if (typeof(callbackComplete) == "function") {
                    callbackComplete(obj, data);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                if (typeof(callbackIncomplete) == "function") {
                    callbackIncomplete(obj, xhr, textStatus, thrownError);
                }
            }
        });
        console.log('ajax sent to remove file!');
    }

    /**
     * Removes the recent uploaded file from view
     * @param  {Jquer Element} element used if necessary to animate
     * @param  {Misc} data    data to be used by callback
     * @return {nil}         
     */
    var nicelyRemoveFile = function( element, data ) {

        $(element).parent().parent().parent().fadeOut(function() {
            if ($('#cloneable-upload').length == 1) {
                addAnotherUploadInput();
            }
            $(this).remove();
        });
    }

    /**
     * Shows that the file cannot be removed for some reason or another
     * @param  {misc} obj         data used by callback
     * @param  {object} xhr         for reference to http request
     * @param  {object} textStatus  status of receiver
     * @param  {object} thrownError error!
     * @return {nil}             
     */
    var cannotRemoveFile = function(obj, xhr, textStatus, thrownError) {
        $(element).effect('shake');
    }

    /**
     * Adding another uploader input for user
     */
    var addAnotherUploadInput = function() {

        var cloneableElement = $('#cloneable-upload');
        var clonedUploadElement = cloneableElement.last().clone();
        var idArray = clonedUploadElement.attr('data-loc').split('-');
        var input, progressBar;
        var newID;

        if ( idArray.length == 1 ) {
            newID = idArray[0]+'-1';
            clonedUploadElement.attr('name', idArray[0]+'-1');
            clonedUploadElement.attr('data-loc', idArray[0]+'-1');
        } else {
            var index = parseInt(idArray[1])
            newID = idArray[0]+'-'+(index+1)
        }

        //child elements
        progressBar = clonedUploadElement.find('.uploader-progress');
        input = clonedUploadElement.find('input');

        //change all the references of cloneable objects
        clonedUploadElement.attr('data-loc', newID);
        progressBar.attr('id', 'upload-'+newID);
        progressBar.removeClass('error');
        progressBar.removeAttr('style');
        progressBar.css('width', '0');
        progressBar.html('');
        input.attr('name', newID);
        input.attr('data-progress', 'upload-'+newID);

        //add file uploader listener
        input.change(function() {
            uploadFile( $(this) );
        })

        clonedUploadElement.css("display","none");
        $('.cloneable-upload-wrapper').append(clonedUploadElement);
        cloneableElement.attr('id','');
        $('#cloneable-upload').fadeIn();
    }

    /**
     * submit entire form!
     * @param  {Function} callback used for callback after submission is complete
     * @return {nil}            
     */
    var submitForm = function(callback) {
        var userID = $win.user_cookie_id;
        var projectID = $win.project_cookie_id;
        var allProjectData = $.parseJSON( $.cookie($win.project_cookie_id) );

        if ( userID && projectID && allProjectData ) {

            $.ajax({
                url: '/wp-content/themes/kerftheme/lib/classes/process_submission.php',
                type: 'POST',
                data: {
                    'user_id': userID,
                    'project_id': projectID,
                    'project_data': JSON.stringify( allProjectData )
                },
                datatype: 'json',
                success: function(data) {
                    console.log('finished Submission!!');
                    if (typeof(callback) == "function") {
                        callback();
                        $.removeCookie($win.user_cookie_id, { path: '/' });
                        $.removeCookie($win.project_cookie_id, { path: '/' });
                        $win.finished = true;
                    }
                },
                error: function(xhr, textStatus, thrownError) {
                    console.log("ERROR:" + textStatus +" - "+thrownError + " - " + xhr.responseText);
                }
            });
        }
    }

    /**
     * update the progress of an uploader
     * @param  {jquery element}   progressBar element to change width
     * @param  {float}   value       0-1 done
     * @param  {function} callback    call back after done animating
     * @return {nil}               
     */
    var updateProgress = function(progressBar, value, callback) {
        progress = value;

        progressWidth = 100 * progress;
        progressBar.animate({
            width: progressWidth+'%'
        }, 2000, callback);
    }

    /**
     * Function generates a random string for use in unique IDs, etc
     *
     * @param <int> n - The length of the string
     */
    var randString = function(n) {
        n = !n ? 5 : n;

        var text = '';
        var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        for(var i=0; i < n; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    }

    /** 
     * Function generates a random string hash
     * @param  {String} s representative string
     * @return {STring}   Hash of the string
     */
    var stringHash = function(s) {
    	var i = s.length, c = 0;
    	while(i--){
    		c = (c << 5) ^ (s.charCodeAt(i) - c);
    	}
    	return c;
    }

    return {
        init: function($w) {
            $win = $w;

            addCookies();
            //Store the current cookie sessions!
            $win.user_cookie_id = $.cookie(SESSION_USERID);
            $win.project_cookie_id = $.cookie($win.user_cookie_id);
            $win.finished = false;

            	//uploader listener on change
            $('.file-upload').change(function() {
            	uploadFile( $(this) );
            })

            $('.remove-stored-file').on('click',function() {
            	var removedObj = $(this);
            	var removedLink = removedObj.siblings('.persist').val();

            	deleteFile(removedLink, removedObj, function(removedObj, data) {
            		console.log('deletion successful!');
            		removedObj.parent().fadeOut(function() {
            			removedObj.siblings('.persist').val('');
            		});
            	}, function(removedObj, xhr, textStatus, thrownError) {
            		console.log("ERROR:" + textStatus +" - "+thrownError + " - " + xhr.responseText);
            		removedObj.parent().effect("shake");
            	});
            });

            //create more uploaders
            $('.more-files-button').on('click', addAnotherUploadInput);

            //add hover feature for optioned inputs
            $('.option-li .input-wrapper').hover( function() {
            	$(this).siblings('.hover-image').css({ "display" : "block"})
            }, function() {
            	$(this).siblings('.hover-image').css({ "display" : "none"})
            });

            //add email validation to elements
            if ($('.email-validation').length > 0 ) {
            	var emailElem = $('.email-validation');
              	var value = $(emailElem).val();
            	$(emailElem).addClass('error-input');
            	$(emailElem).removeClass('valid-input');

            	if (validateEmail(value)) {
            		$(emailElem).removeClass('error-input');
            		$(emailElem).addClass('valid-input');
            	}
            }


            //add phone validation to elements
            if ( $('.phone-validation').length > 0) {
            	var phoneElem = $('.phone-validation');
              	var value = $(phoneElem).val();
            	$(phoneElem).addClass('error-input');
            	$(phoneElem).removeClass('valid-input');

            	// remove all non-digits
            	var phone_val = value.replace(/[^\-\d]/g,''); 
            	$(phoneElem).val(phone_val);
            	phone_val = phone_val.replace(/[\-]/g,'');
            	if(phone_val && phone_val.length >= 10) {
            		$(phoneElem).removeClass('error-input');
            		$(phoneElem).addClass('valid-input');
            	}
            }

            //input email validation
            $('.email-validation').on("input", function() {
              	var value = $(this).val();
            	$(this).addClass('error-input');
            	$(this).removeClass('valid-input');

            	if (validateEmail(value)) {
            		$(this).removeClass('error-input');
            		$(this).addClass('valid-input');
            	}
            });

            //input email validation
            $('.phone-validation').on("input", function() {
              	var value = $(this).val();
            	$(this).addClass('error-input');
            	$(this).removeClass('valid-input');

            	// remove all non-digits
            	var phone_val = value.replace(/[^\-\d]/g,''); 
            	$(this).val(phone_val);
            	phone_val = phone_val.replace(/[\-]/g,'');
            	if(phone_val && phone_val.length >= 10) {
            		$(this).removeClass('error-input');
            		$(this).addClass('valid-input');
            	}
            });

            //create persistence and ux for form navigation
            $('.form-headers li a').click( function() {
            	if (!$win.finished) {

            		$('.spinner-wrapper').fadeIn();
            		$('html body').animate({scrollTop : 0},100);
            		addSpinnerToElement( $('.progress-spinner')[0] );
            		return formClickAway( this, null );
            	}
            });

            //create jquery action from next button click
            $('#next-button').click( function() {
            	if (!$win.finished) {

            		$('.spinner-wrapper').fadeIn();
            		$('html body').animate({scrollTop : 0},100);
            		addSpinnerToElement( $('.progress-spinner')[0] );
            		return formClickAway( this, null );
            	}
            });

            //create jquery action from previous button click
            $('#prev-button').click( function() {
            	if (!$win.finished) {

            		$('.spinner-wrapper').css("display", "block");
            		$('html body').animate({scrollTop : 0},100);
            		addSpinnerToElement( $('.progress-spinner')[0] );
            		return formClickAway( this, null );
            	}
            });


            //perist any form data into session variables
            $win[0].onbeforeunload = function() {
            	if (!$win.finished) {
            		console.log('saving session');
            		return saveSessionData();
            	}
            };

            //What happens when you submit the entire form!
            $('#submit-form').click( function() {
            	$('.form-headers').slideUp();
            	$('.submit-spinner-wrapper').fadeIn();
            	$('html body').animate({scrollTop : 0},100);
            	addSpinnerToElement( $('.submit-spinner-wrapper .progress-spinner')[0] );

            	formClickAway( this, function() {
            		submitForm( function() {
            			$('#form-main').slideUp( function() {
            				$(this).remove();
            			});
            			$('.submit-spinner-wrapper .progress-spinner').remove();
            			$('.submit-spinner-wrapper').remove();
            			$('#submitted-main').fadeIn();
            		});
            	});

            	return false;
            });
        }
    };
});
