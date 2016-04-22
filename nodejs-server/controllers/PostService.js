'use strict';

exports.addPost = function(args, res, next) {
  /**
   * parameters expected in the args:
  * body (Post)
  **/
    var examples = {};
  examples['application/json'] = {
  "id" : 1,
  "title" : "My Title",
  "body" : "some body text",
  "userId" : 1
};
  if(Object.keys(examples).length > 0) {
    res.setHeader('Content-Type', 'application/json');
    res.end(JSON.stringify(examples[Object.keys(examples)[0]] || {}, null, 2));
  }
  else {
    res.end();
  }
  
}

exports.deletePost = function(args, res, next) {
  /**
   * parameters expected in the args:
  * id (Long)
  **/
  // no response value expected for this operation
  res.setHeader('Content-Type', 'application/json');
  res.end("{}");
}

exports.listPosts = function(args, res, next) {
  /**
   * parameters expected in the args:
  * max (Long)
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

exports.readPost = function(args, res, next) {
  /**
   * parameters expected in the args:
  * id (Long)
  **/
    var examples = {};
  examples['application/json'] = {
  "id" : 1,
  "title" : "My Title",
  "body" : "some body text",
  "userId" : 1
};
  if(Object.keys(examples).length > 0) {
    res.setHeader('Content-Type', 'application/json');
    res.end(JSON.stringify(examples[Object.keys(examples)[0]] || {}, null, 2));
  }
  else {
    res.end();
  }
  
}

exports.updatePost = function(args, req, res, next) {
  /**
   * parameters expected in the args:
  * id (Long)
  * body (Post)
  **/

    var examples = {};
  examples['application/json'] = {
  "id" : 1,
  "title" : req.body.title,
  "body" : req.body.body,
  "userId" : 1
};
  if(Object.keys(examples).length > 0) {
    res.setHeader('Content-Type', 'application/json');
    res.end(JSON.stringify(examples[Object.keys(examples)[0]] || {}, null, 2));
  }
  else {
    res.end();
  }
  
}

