
// Use Parse.Cloud.define to define as many cloud functions as you want.
// For example:
Parse.Cloud.define("hello", function(request, response) {
  response.success("Hello world!");
});


Parse.Cloud.beforeSave(Parse.User, function(request, response) {

	if ( !request.object.get("name") ) {
		response.error("Please enter your full name.");
	} else {
		response.success();
  	}

});



Parse.Cloud.beforeSave("Profile", function(request, response) {
	if (!request.object.get("currentPosition")) {
		response.error("Please set a current position.");
	} else if (!request.object.get("city")) {
		response.error("Please set a city.");
	} else if (!request.object.get("state")) {
		response.error("Please set a state.");
	} else if (!request.object.get("summary")) {
		response.error("Please provide a profile summary.");
	} else if (!request.object.get("education")) {
		response.error("Please provide an education background.");
	} else if (!request.object.get("experience")) {
		response.error("Please provide any job experience.");
	//} else if (!request.object.get("certifications")) {
	//	response.error(""); //some people may not have any certifications.
	} else {
		response.success();
	}
});

Parse.Cloud.beforeSave("connectionRequest", function(request, response) {

	var fromUser = request.object.get("fromUser");
	console.log(fromUser.get("objectId"));

	var toUser = request.object.get("toUser");

	/*
	if (!request.object.get("currentPosition")) {
		response.error("Please set a current position.");
	} else if (!request.object.get("city")) {
		response.error("Please set a city.");
	} else if (!request.object.get("state")) {
		response.error("Please set a state.");
	} else if (!request.object.get("summary")) {
		response.error("Please provide a profile summary.");
	} else if (!request.object.get("education")) {
		response.error("Please provide an education background.");
	} else if (!request.object.get("experience")) {
		response.error("Please provide any job experience.");
	//} else if (!request.object.get("certifications")) {
	//	response.error(""); //some people may not have any certifications.
	} else {
		response.success();
	}*/
});




Parse.Cloud.define("acceptConnectionRequest", function(request, response) {


	var CRobjectId = request.params.id;

	var ConnectionRequestObject = Parse.Object.extend("connectionRequest");
	var connectionRequestObject = new Parse.Query(ConnectionRequestObject);

	connectionRequestObject.get(CRobjectId, {
		success: function(connectionRequestObject) {
			//var fromUser = new Parse.User({id:request.params.userId});
			var fromUser = connectionRequestObject.get("fromUser");
			var toUser = connectionRequestObject.get("toUser");
			
			//fromUser = fromUser.get("objectId");
			//fromUser = fromUser.fetch();
			
			fromUser.fetch({
			  success: function(fromUser, toUser) {
			    // The object was refreshed successfully.
			    response.success(fromUser);
			    fromUser.addUnique("connectionsTest", toUser);
				fromUser.save();
			  },
			  error: function(fromUser, error) {
			    // The object was not refreshed successfully.
			    // error is a Parse.Error with an error code and message.
			    response.error( "failed" );
			  }
			});
			/*
			toUser.fetch({
			  success: function(toUser, fromUser) {
			    // The object was refreshed successfully.
			    fromUser.addUnique("connectionsTest", fromUser);
				fromUser.save();
			  },
			  error: function(toUser, error) {
			    // The object was not refreshed successfully.
			    // error is a Parse.Error with an error code and message.
			    response.error( "failed" );
			  }
			});*/
			/*
			var toUser = connectionRequestObject.get("toUser");
			toUser = toUser.fetch();
			
			fromUser.addUnique("connectionsTest", toUser);
			fromUser.save(true);
			toUser.addUnique("connectionsTest", fromUser);
			toUser.save(true);
			connectionRequestObject.destroy();
			*/
			//response.success( "finished" );
		// The object was retrieved successfully.
		},
		error: function( error ) {
			response.error( error );
		// The object was not retrieved successfully.
		// error is a Parse.Error with an error code and message.
		}
	});
	
	//response.error( "No connection request was given." );

});
