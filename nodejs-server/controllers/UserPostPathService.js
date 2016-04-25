'use strict';

exports.readUserPostWithPath = function(args, req, res, next) {
  /**
   * parameters expected in the args:
  * userId (Long)
  **/
    var examples = {};
  examples['application/json'] = [ {
  "id" : 1,
  "title" : "My Title",
  "body" : "some body text",
  "userId" : 1
} ];
  if(Object.keys(examples).length > 0) {
    res.setHeader('Content-Type', 'application/json');
    res.end(JSON.stringify(examples[Object.keys(examples)[0]] || {}, null, 2));
  }
  else {
    res.end();
  }
  
}

