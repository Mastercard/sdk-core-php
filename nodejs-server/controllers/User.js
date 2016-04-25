'use strict';

var url = require('url');


var User = require('./UserService');


module.exports.addUser = function addUser (req, res, next) {
  User.addUser(req.swagger.params, res, next);
};

module.exports.deleteUser = function deleteUser (req, res, next) {
  User.deleteUser(req.swagger.params, res, next);
};

module.exports.listUsers = function listUsers (req, res, next) {
  User.listUsers(req.swagger.params, res, next);
};

module.exports.readUser = function readUser (req, res, next) {
  User.readUser(req.swagger.params, res, next);
};

module.exports.updateUser = function updateUser (req, res, next) {
  User.updateUser(req.swagger.params, res, next);
};
