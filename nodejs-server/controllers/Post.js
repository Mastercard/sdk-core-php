'use strict';

var url = require('url');


var Post = require('./PostService');


module.exports.addPost = function addPost (req, res, next) {
  Post.addPost(req.swagger.params, res, next);
};

module.exports.deletePost = function deletePost (req, res, next) {
  Post.deletePost(req.swagger.params, res, next);
};

module.exports.listPosts = function listPosts (req, res, next) {
  Post.listPosts(req.swagger.params, res, next);
};

module.exports.readPost = function readPost (req, res, next) {
  Post.readPost(req.swagger.params, res, next);
};

module.exports.updatePost = function updatePost (req, res, next) {
  Post.updatePost(req.swagger.params, req, res, next);
};
