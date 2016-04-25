'use strict';

var url = require('url');


var UserPostHeader = require('./UserPostHeaderService');


module.exports.readUserPostWithHeader = function readUserPostWithHeader (req, res, next) {
  UserPostHeader.readUserPostWithHeader(req.swagger.params, req, res, next);
};
