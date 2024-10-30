// JavaScript Document

// Toaster notification
function notify(message) {
	jQuery.toaster({ 	
		title 		:	'Notification ', 
		message 	:	message, 
		priority 	:	'info', 
		settings 	:	{'timeout' : 5000, 'toaster' : {css : {'top':'20px'} } } 
   });
}

function notify_warning(message) {
	jQuery.toaster({ 	
		title 		:	'Notification ', 
		message 	:	message, 
		priority 	:	'danger', 
		settings 	:	{'timeout' : 5000, 'toaster' : {css : {'top':'20px'} } } 
   });
}