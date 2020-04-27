// Ajax.as
// This class will make it easier to work with Ajax

function Ajax() {
	
	this.req = null;				// XMLHttpRequest object
	this.url = null;				// Location of Server Script
	this.method = "POST";			// Method of delivery
	this.async = true;				// Continue JS execution
	this.status = null;			// HTTP status code
	this.statusText = "";			// HTTP status text
	this.postData = null;			// Data to send
	this.readyState = null;		// 0:Open, 1:loading, 2:loaded, 3:downloading, 4:completed
	this.responseText = null;		// Response as a String
	this.responseXML = null;		// Response as XML document
	this.handleResp = null;		// Response handler
	this.responseFormat = "text"; 	// text, xml, object
	this.mimeType = null;			// Our MimeType
	
	
	// Init function
	// Create the XMLHttpRequest Object
	this.init = function() {
		if(!this.req) {
			try {
				// Try to create object for Firefox, Safari, IE7
				this.req = new XMLHttpRequest();
			} catch(e) {
				try {
					// Try to create object for later versions of IE
					this.req = new ActiveXObject("MSXML2.XMLHTTP");
				} catch(e) {
					try {
						// Try to create object for early versions of IE
						this.req = new ActiveXObject("Microsoft.XMLHTTP");
					} catch(e) {
						// Could not create an XMLHttpRequest object
						return false;
					}
				}
			}
		}
		return this.req;
	};
	
	// doReq function
	// Call init, prepare request, send and error if fail 
	// Also deal with readyStates
	this.doReq = function() {
		if(!this.init()) {
			alert("ERROR: Could not create XMLHttpRequest object");
			return;
		}
		this.req.open(this.method, this.url, this.async);
		
		if(this.mimeType) {
			try {
				req.overrideMimeType(this.mimeType);
			} catch(e) {
				alert("ERROR: Couldn't override MIME type");
			}
		}
		
		var self = this; // Fix loss of scope
		this.req.onreadystatechange = function() {
			
			// Switch on current ready state
			switch(self.req.readyState) {
				case 0: // open
					// Handle open
					break;
				case 1: // loading
					// Handle loading
					break;
				case 2: // loaded
					// Handle loaded
					break;
				case 3: // downloading
					// Handle downloading
					break;
				case 4: // completed
					
					switch(self.responseFormat) {
						case "text":
							resp = self.req.responseText;
							break;
						case "xml":
							resp = self.req.responseXML;
							break;
						case "object":
							resp = req;
							break;
					}
					
					if(self.req.status >= 200 && self.req.status <=299) {
						self.handleResp(resp);
					} else {
						self.handleErr(resp);
					}
					
					break;
				default:
					alert("ERROR: Fatal readyState");
					break;
			}
		};
		
		this.req.send(this.postData);
	};
	
	// setMimeType Function
	// Set our MimeType
	this.sexMimeType = function(mimeType) {
		this.mimeType = mimeType;
	};
	
	// handleErr Function
	// Handle an error
	this.handleErr = function() {
		var errorWin;
		try {
			//errorWin = window.open("", "errorWin");
			//errorWin.document.body.innerHTML = this.responseText;
		} catch(e) {
			alert( "ERROR: An error occurred, but the error message cannot "
				  +"be displayed.\nPopup blockers must be disabled to see it.\n"
				  +"Status Code: "+this.req.status+"\n"
				  +"Status Description: "+this.req.statusText);
		}
	};
	
	// setHandlerErr Function
	// Custom error handler
	this.setHandlerErr = function(funcRef) {
		this.handleErr = funcRef;
	};
	
	// setHandlerBoth Function
	// Handle both successes and errors
	this.setHandlerBoth = function(funcRef) {
		this.handleResp = funcRef;
		this.handleErr = funcRef;
	};
	
	// abort Function
	// Stop a bad script
	this.abort = function() {
		if(this.req) {
			this.req.onreadystatechange = function() { };
			this.req.abort();
			this.req = null;
		}
	};
	
	// doGet Function
	// User function to call ajax script
	this.doGet = function(url, hand, format) {
		this.url = url;
		this.handleResp = hand;
		this.responseFormat = format || "text";
		this.doReq();
	};
}