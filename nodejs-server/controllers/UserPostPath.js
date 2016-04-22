'use strict';

var url = require('url');


var UserPostPath = require('./UserPostPathService');


module.exports.readUserPostWithPath = function readUserPostWithPath (req, res, next) {
  UserPostPath.readUserPostWithPath(req.swagger.params, req, res, next);
};
