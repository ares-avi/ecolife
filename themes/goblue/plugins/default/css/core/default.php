/******************************
	Basic
**********************************/

body {
	font-size: 14px;
	background-color: #eaeaea;
	font-family: 'PT Sans', sans-serif;
	height: 100%;
}

.el-required {
	color: #a94442;
}

::-webkit-scrollbar {
	width: 12px;
}

::-webkit-scrollbar-track {
	background-color: #eaeaea;
	border-left: 1px solid #ccc;
}

::-webkit-scrollbar-thumb {
	background-color: #ccc;
}

::-webkit-scrollbar-thumb:hover {
	background-color: #aaa;
}

.el-form input[type='number'],
.el-form input[type='email'],
.el-form input[type='password'],
.el-form text,
.el-form select,
.el-form textarea,
.el-form input[type='text'] {
	width: 100%;
	background-color: #f9f9f9;
	border: 1px solid #ccd0d5;
	padding: 8px;
	margin-bottom: 5px;
	outline: none;
	display: block;
	resize: vertical;
	border-radius: 5px;
	border-radius: 5px;
	box-shadow: none;
	-webkit-box-shadow: none
}

.el-form input[type='number']:focus,
.el-form input[type='email']:focus,
.el-form input[type='password']:focus,
.el-form text:focus,
.el-form select:focus,
.el-form textarea:focus,
.el-form input[type='text']:focus {
	outline: none;
}

.el-form input[readonly],
.el-form input[readonly],
.el-form input[readonly],
.el-form select[readonly],
.el-form textarea[readonly],
.el-form input[readonly] {
	background: #dbdbdb;
}

.btn:focus,
.btn:active {
	outline: none !important;
}

.form-control {
	height: initial;
}

.el-form-group-half {
	display: inline-block;
	width: calc(50% - 2px);
	float: left;
	box-sizing: border-box;
}

.radio-block-container {
	margin-bottom: 20px;
}

.el-form input[type='submit'] {
	margin-top: 5px;
	margin-bottom: 5px;
}

.el-red-borders {
	border: 1px solid #a94442 !important;
}

.fa {
	margin-right: 5px;
}

.el-hidden {
	display: none;
}

p {
	font-size: 15px;
}

.col-center {
	float: none;
	margin: 0 auto;
}

.container-table {
	display: table;
	width: 100%;
}

.center-row {
	display: table-cell;
	text-align: center;
}

.radio-block {
	margin-top: 10px;
	margin-bottom: 10px;
}

.radio-block span {
	display: inline-block;
	margin-right: 10px;
	font-size: 15px;
	font-weight: bold;
	margin-left: 10px;
}

.btn {
	border-radius: 2px;
	padding: 4px 8px;
}

.btn-primary {
	background-color: #2a87a7;
}

a {
	color: #0f3b4a;
}


/************************************
	Layouts
************************************/


/** didn't we have a minimum page height in goblue? #702 **/

.el-layout-module,
.el-layout-contents,
.el-layout-media,
.el-layout-newsfeed {
	margin-top: 10px;
	min-height: 400px;
}

.el-home-container,
.el-layout-startup {
	min-height: 560px;
}

.el-home-container .el-page-contents {
	background: rgba(255, 255, 255, 0);
	border: 1px solid rgba(238, 238, 238, 0);
}

.el-layout-startup {
	min-height: 560px;
}

.el-layout-startup-background {
	min-height: 560px;
	background: url("<?php echo el_add_cache_to_url(el_theme_url('images/background.jpg'));?>") no-repeat;
	background-size: cover;
}

.el-layout-startup .col-md-11 {
	width: 100%;
}

.el-layout-startup footer .el-footer-menu a {
	color: #fff;
}

.el-home-container {
	margin-top: 20px;
}

.el-layout-newsfeed .newsfeed-right {}

.el-page-container {
	overflow-x: hidden;
	min-height: 400px;
}

.el-layout-module {
	margin-top: 10px;
	background: #fff;
	border: 1px solid #eee;
	padding: 10px;
}

.el-layout-module .module-title {
	background: #F9F7F7;
	border: 1px solid #eee;
	padding: 10px;
}

.el-layout-module .module-contents {
	padding: 10px;
}

.el-layout-module .module-title .title {
	font-weight: bold;
	display: inline-block;
}

.el-layout-module .controls {
	float: right;
	display: inline-table;
}

.el-layout-media {
	margin-top: 10px;
}

.el-layout-media .like-share,
.el-layout-media .comments-list {
	margin-left: -10px;
	margin-right: -10px;
}

.el-layout-media .content,
.el-page-contents {
	background: #fff;
	padding: 10px;
	border: 1px solid #eee;
}

.opensource-socalnetwork {
	min-height: 500px;
}

.el-home-container .row {
	margin-right: 10px;
	margin-left: 10px;
}

#el-signup-errors {
	display: none;
	margin-top: 10px;
}

.el-error-page {
	text-align: center;
	padding: 100px;
}

.el-error-page .error-heading {
	font-size: 50px;
	font-weight: bold;
}

.el-error-page .error-text {
	font-size: 16px;
}

.el-error-page .fa-exclamation-triangle {
	font-size: 100px;
}

.el-group-members {
	margin-right: 5px;
}

.el-page-loading-annimation {
	background: #fff;
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
}

.el-page-loading-annimation .el-page-loading-annimation-inner {
	width: 24px;
	margin: 0 auto;
	margin-top: 20%;
}

.newsfeed-middle-top {
	display: none;
	background-color: #fff;
	box-shadow: inset 0 0 0 1px rgba(144, 144, 144, 0.25);
	border-radius: 3px;
	margin-top: 2px;
	margin-bottom: 4px;
	padding: 9px;
}


/*******************************
	Topbar	
********************************/

.topbar {
	background: #0b769c;
	color: #fff;
	z-index: 1;
	position: relative;
	height: 48px;
}

.topbar .fa {
	font-size: 20px;
	margin-top: 5px;
}

.topbar .site-name a {
	text-transform: uppercase;
	font-size: 20px;
	padding: 10px;
	color: #fff;
	display: block;
	font-weight: bold;
}

.topbar .site-name a:hover {
	text-decoration: none;
}

.topbar-menu-left {
	position: relative;
	z-index: 1;
}

.topbar-menu-right li,
.topbar-menu-left li {
	display: inline-block;
}

.topbar-menu-right li a,
.topbar-menu-left li a {
	padding: 10px;
	display: block;
	color: #fff;
}

.topbar-menu-right li:hover,
.topbar-menu-left li:hover {
	cursor: pointer;
	background-color: #0a6586;
}

.topbar .right-side-nospace .topbar-menu-right {
	margin-right: 0px;
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;
}

.topbar .right-side-space .topbar-menu-right {
	margin-right: 10px;
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;
}

.topbar .el-icons-topbar-friends,
.topbar .el-icons-topbar-messages,
.topbar .el-icons-topbar-notification i {
	color: #0f3b4a;
}

.topbar .el-icons-topbar-friends-new,
.topbar .el-icons-topbar-messages-new,
.topbar .el-icons-topbar-notifications-new i {
	color: #fff;
}

.el-topbar-dropdown-menu {
	float: right;
}

.el-topbar-dropdown-menu ul li a,
.el-topbar-dropdown-menu ul li {
	display: block;
	width: 100%;
	color: #000;
}

.el-topbar-dropdown-menu .dropdown-menu {
	margin: 1px -120px 0;
}


/***********************************
	el Wall
*************************************/

.el-wall {}

.el-wall-items {}

.el-wall-item {
	padding: 30px;
	padding-top: 10px;
	border: 1px solid #eee;
	margin-top: 20px;
	background-color: #fff;
	padding-bottom: 0px;
	border-radius: 4px;
}

.el-wall-item:first-child {
	margin-top: 0px;
}

.el-wall-item .friends a {
	text-decoration: none;
}

.el-wall-item .friends a:first-child:before {
	content: "-";
	margin-left: 5px;
	margin-right: 5px;
}

.el-wall-item .user-img {
	border-radius: 50px;
	display: inline-block;
	float: left;
	margin-right: 10px;
}

.el-wall-item .meta {}

.el-wall-item .meta .user {
	margin-top: 3px;
}

.el-wall-item .meta .user a {
	font-weight: bold;
}

.el-wall-item .meta .user span {
	color: #999;
}

.el-wall-item .post-contents {
	margin-top: 15px;
}

.el-wall-item .post-contents p {
	/** Incorrect Hyphenation in the theme GoBlue 3.0 #824 **/
	word-break: break-word;
	text-align: justify;
}

.el-wall-item .post-contents img {
	max-width: 100%;
	border: 1px solid #eae8e8;
	display: block;
	margin-bottom: 10px;
}

.el-wall-item .meta .post-menu {
	float: right;
}

.el-wall-container {
	border-radius: 2px;
	margin-top: -5px;
	margin-bottom: 10px;
}

.el-wall-container textarea {
	padding: 10px;
	width: 100%;
	border: 1px solid;
	border-color: #E5E6E9 #DFE0E4;
	border-bottom: 0px;
	border-top: 0px;
	resize: none;
	outline: none;
	background: #fff;
	border-radius: 0;
}

.el-wall-container .controls {
	background-color: #F6F7F8;
	border-bottom: 1px solid #E9EAED;
	border-left: 1px solid #E9EAED;
	border-right: 1px solid #E9EAED;
	min-height: 40px;
	width: 100%;
	margin-top: 3px;
	margin-top: -5px;
	padding-right: 10px;
}

.el-wall-container .wall-tabs {
	border-bottom: 1px solid #E5E5E5;
	background-color: #F6F7F8;
	border: 1px solid #E9EAED;
	margin-top: 5px;
}

.el-wall-container .wall-tabs .item {
	padding: 10px;
	display: inline-flex;
	cursor: pointer;
	border-bottom: 1px solid #eee;
	font-weight: bold;
	font-size: 13px;
}

.el-wall-container .wall-tabs .item:hover {
	background: #eee;
}

.el-wall-container .wall-tabs .item div {
	display: inline-block;
}

.el-wall-container .wall-tabs .item .text {
	font-weight: bold;
	margin-top: 1px;
	margin-left: 5px;
	position: absolute;
	font-size: 15px;
}

.el-wall-container .tabs-input {}

.el-wall-container .controls li {
	padding: 10px;
	display: inline-block;
	cursor: pointer;
}

.el-wall-container .controls li:hover {
	background: #eee;
}

.el-wall-privacy {
	float: right;
	margin-right: 5px;
}

.el-wall-container input[type='submit'] {
	padding: 3px 20px;
	display: block;
	margin-top: 6px;
}

.el-wall-container i {
	font-size: 15px;
}

.el-wall-container input[type="file"] {
	border-left: 1px solid #EEE;
	border-right: 1px solid #EEE;
	background: #fff;
}

.el-wall-container input[type="file"],
.el-wall-container input[type="text"] {
	width: 100%;
	border-top: 1px dashed #EEE;
	padding: 5px;
	margin-bottom: 5px;
	margin-top: -5px;
	outline: none;
}

#token-input-el-wall-friend-input {
	width: 100% !important;
	border-top: 1px dashed #EEE;
	padding: 7px;
	margin-bottom: 5px;
	margin-top: -5px;
	background: #fff;
	border: 0;
}

#el-wall-location-input {
	background: #fff;
	border-radius: 0;
}

#el-wall-form .el-loading {
	margin: 7px;
}

.el-wall-item-type {
	display: inline-block;
}

.el-wall-item .friends {
	display: inline-block;
}


/*******************************
	Comments Likes
********************************/

.el-comment-menu {
	float: right;
	margin-left: 10px;
}

.comments-item:hover .el-comment-menu {
	display: block;
	margin-left: 10px;
}

.comments-likes {
	min-height: 50px;
	width: 100%;
}

.menu-likes-comments-share {
	margin-bottom: 10px;
}

.menu-likes-comments-share li {
	display: inline-block;
}

.menu-likes-comments-share li::after {
	content: "-";
	margin-left: 5px;
	margin-right: 5px;
	color: #ccc;
}

.menu-likes-comments-share li:last-child:after {
	content: " ";
}

.comments-list {
	background-color: #FBFBFB;
	margin-left: -15px;
	margin-right: -15px;
	padding-left: 10px;
	padding-right: 10px;
}

.comments-list .comments-item {
	padding-top: 10px;
	padding-bottom: 5px;
}

.comments-list .comments-item:first-child {
	margin-top: 0px;
	padding-top: 10px;
}

.comments-list .comments-item:last-child {
	border-bottom: none;
}

.comments-list .comments-item .comment-user-img {
	display: inline-block;
	border-radius: 32px;
}


/** UI improvements comments #1524 **/

.comments-list .comments-item .comment-contents {
	display: inline-block;
	margin-top: -3px;
	background-color: #ebedf0;
	border-radius: 18px;
	width: auto;
	line-height: 16px;
	padding: 6px 12px 7px 12px;
}

.comment-container {
	padding-bottom: 10px;
	position: relative;
	z-index: 0;
}

.comments-item .col-md-11 {
	padding-left: 0px;
}

.comment-metadata .time-created,
.comment-metadata a {
	display: inline-block;
}

.comment-contents p {
	margin: 0px;
	word-break: break-word;
	text-align: left;
}

.comment-contents p img {
	display: block;
	margin-top: 10px;
	margin-bottom: 10px;
	max-width: 100%;
}

.comment-contents .owner-link {
	font-weight: bold;
	margin-right: 5px;
	font-size: 14px;
}

.comment-contents {
	width: 100%;
}

.comment-container span[readonly='readonly'],
.comment-container input[readonly='readonly'] {
	background: #eee;
}

.comment-box {
	width: 100%;
	border: 1px solid #eee;
	padding: 6px 65px 6px 12px !important;
	margin-bottom: 5px;
	outline: none;
	display: block;
	resize: vertical;
	min-height: 32px;
	background-color: #f2f3f5;
	border: 1px solid #ccd0d5;
	border-radius: 15px;
	word-break: break-word;
	text-align: left;
}

[contentEditable=true]:empty:not(:focus)::before {
	content: attr(placeholder);
}


/*********************************
	Like
************************************/

.like-share {
	border-top: 1px solid #eee;
	border-bottom: 1px solid #eee;
	padding: 10px;
	margin-top: 10px;
	background-color: #FBFBFB;
	margin-left: -15px;
	margin-right: -15px;
	padding-left: 20px;
	padding-right: 20px;
}

.el-like-comment,
.el-total-likes {
	margin-left: 10px;
}


/********************************
	Global
***********************************/

.time-created {
	font-size: 14px;
	font-style: italic;
	color: #999;
}


/********************************
	Sidebar Nav
*********************************/

.sidebar {
	background-color: #333;
	height: 200px;
	z-index: 1000;
	width: 200px;
	position: absolute;
	height: 100%;
	margin-left: -200px;
	overflow-y: auto;
	overflow-x: hidden;
	color: #fff;
}

.sidebar a {
	color: #fff;
}

.sidebar-close {
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;
}

.sidebar-open {
	margin-left: 0px;
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;
}

.sidebar-open-no-annimation {
	margin-left: 0px;
}

.sidebar-open-page-container {
	margin-left: 200px;
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;
}

.sidebar-open-page-container-no-annimation {
	margin-left: 200px;
}

.sidebar-close-page-container {
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;
}

.newseed-uinfo {
	padding: 10px;
}

.newseed-uinfo img {
	display: inline-block;
	border-radius: 50px;
	float: left;
}

.newseed-uinfo .name {
	display: inline-block;
	width: 100px;
	margin-left: 10px;
	margin-top: -2px;
}

.newseed-uinfo .name a {
	font-weight: bold;
	display: block;
	color: #fff;
	font-size: 13px;
}

.newseed-uinfo .name .edit-profile {
	font-weight: inherit;
}

.sidebar-menu-nav {
	overflow: auto;
	font-family: verdana;
	font-size: 12px;
	font-weight: 200;
	top: 0px;
	width: 100%;
	height: 100%;
}

.sidebar-menu-nav ul,
.sidebar-menu-nav li {
	list-style: none;
	padding: 0px;
	margin: 0px;
	line-height: 35px;
	cursor: pointer;
}

.sidebar-menu-nav ul:not(collapsed) .arrow:before,
.sidebar-menu-nav li:not(collapsed) .arrow:before {
	font-family: FontAwesome;
	content: "\f078";
	display: inline-block;
	padding-left: 10px;
	padding-right: 10px;
	vertical-align: middle;
	float: right;
}

.sidebar-menu-nav ul .sub-menu li {
	padding-left: 20px;
}

.sidebar-menu-nav ul .sub-menu li,
.sidebar-menu-nav li .sub-menu li {
	border: none;
	line-height: 28px;
	border-bottom: 1px solid #23282e;
	margin-left: 0px;
}

.sidebar-menu-nav ul .sub-menu li:hover,
.sidebar-menu-nav li .sub-menu li:hover {
	background-color: #020203;
}

.sidebar-menu-nav ul .sub-menu li:before,
.sidebar-menu-nav li .sub-menu li:before {
	font-family: FontAwesome;
	content: "\f105";
	display: inline-block;
	padding-left: 10px;
	padding-right: 10px;
	vertical-align: middle;
}

.sidebar-menu-nav li {
	padding-left: 0px;
	border-bottom: 1px solid #23282e;
}

.sidebar-menu-nav li a {
	text-decoration: none;
	color: #fff;
}

.sidebar-menu-nav li a i {
	padding-left: 10px;
	width: 20px;
	padding-right: 20px;
}

.sidebar-menu-nav li:hover {
	border-left: 3px solid #fff;
	background-color: #4f5b69;
	-webkit-transition: all 1s ease;
	-moz-transition: all 1s ease;
	-o-transition: all 1s ease;
	-ms-transition: all 1s ease;
	transition: all 1s ease;
}

@media (max-width: 767px) {
	.sidebar-menu-nav {
		position: relative;
		width: 100%;
		margin-bottom: 10px;
	}
	.el-group-members {
		height: 75px !important;
	}
}


/******************************
	el global css clsses
*******************************/

.right {
	float: right;
}

.left {
	float: left;
}

.text-right {
	text-align: right;
}

.text-left {
	text-align: left;
}

.text-center {
	text-align: center;
}

.margin-top-10 {
	margin-top: 10px;
}

.margin-top-20 {
	margin-top: 20px;
}


/************************
	Dropdown
***************************/

.dropdown-submenu {
	position: relative;
}

.dropdown-submenu>.dropdown-menu {
	top: 0;
	left: 100%;
	margin-top: -6px;
	margin-left: -1px;
	-webkit-border-radius: 0 6px 6px 6px;
	-moz-border-radius: 0 6px 6px;
	border-radius: 0 6px 6px 6px;
}

.dropdown-submenu:hover>.dropdown-menu {
	display: block;
}

.dropdown-submenu>a:after {
	display: block;
	content: " ";
	float: right;
	width: 0;
	height: 0;
	border-color: transparent;
	border-style: solid;
	border-width: 5px 0 5px 5px;
	border-left-color: #ccc;
	margin-top: 5px;
	margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
	border-left-color: #fff;
}

.dropdown-submenu.pull-left {
	float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
	left: -100%;
	margin-left: 10px;
	-webkit-border-radius: 6px 0 6px 6px;
	-moz-border-radius: 6px 0 6px 6px;
	border-radius: 6px 0 6px 6px;
}

.dropmenu-topbar-icons {
	left: inherit;
	right: 0;
}


/******************************************
	el Ads
*******************************************/

.el-ad-item {}

.el-ad-item .ad-image {
	max-width: 100%;
	margin: 0 auto;
	display: block;
}

.el-ad-item a {
	text-decoration: none;
	color: #000;
	cursor: pointer;
}

.el-ad-item .ad-title {
	font-weight: bold;
	font-size: 15px;
	margin-bottom: 5px;
}

.el-ad-item .ad-link {
	margin-bottom: 5px;
}

.el-ad-item p {
	margin-top: 10px;
	text-align: justify;
}


/*****************************
	Widgets
******************************/

.el-widget {
	margin-bottom: 10px;
	background-color: #fff;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
	border-bottom-left-radius: 3px;
	border-bottom-right-radius: 3px;
}

.el-widget .widget-heading {
	background: #F6F7F8;
	border: 1px solid #eee;
	padding: 10px;
	font-weight: bold;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
}

.el-widget .widget-contents {
	padding: 10px;
	border-bottom: 1px solid #eee;
	border-bottom-left-radius: 3px;
	border-bottom-right-radius: 3px;
}

.el-privacy .radio-block {
	margin-bottom: 0;
	margin-top: 0;
	display: flex;
}

.el-privacy label {
	margin-bottom: 0px;
}

.el-privacy .radio-block span {
	font-weight: normal;
	width: 85%;
	margin-top: 7px;
}

.group-add-privacy .radio-block span {
	margin-top: 5px;
}

.group-add-privacy .radio-block .el-radio-input {
	float: left;
}


/***********************************
	el Notifications
***************************************/

.el-notifications-box {
	width: 430px;
	color: #000;
}

.el-notifications-box .notificaton-item {
	border-bottom: 1px solid #eee;
}

.el-notifications-box .notificaton-item:hover,
.el-notifications-box .notificaton-item .active {
	background-color: #F9F9F9;
}

.el-notifications-box .type-name {
	font-size: 13px;
	font-weight: bold;
	padding: 1px 10px 5px 10px;
	color: #000;
	height: 25px;
	border-bottom: 1px solid #DDDDDD;
}

.el-notification-box-loading {
	margin: 0 auto;
	margin-top: 20px;
	margin-bottom: 20px;
}

.el-no-notification {
	text-align: center;
	padding: 10px;
}

.el-notifications-box .type-name .title {
	display: inline-block;
}

.el-notifications-box .type-name .links {
	display: inline-block;
	float: right;
}

.el-notifications-box .type-name .links a {
	color: #337ab7;
	display: inline;
	font-weight: normal;
}

.el-notifications-box .notification-image,
.el-notifications-box .notification-image img {
	width: 50px;
	height: 50px;
	display: inline-block;
}

.el-notifications-box .bottom-all a,
.el-notifications-box .notfi-meta strong {
	color: #337ab7;
}

.el-notifications-box .notfi-meta {
	width: 330px;
	margin-left: 5px;
	display: inline-block;
	float: right;
	color: #000;
}

.el-notifications-box .bottom-all a {
	font-weight: bold;
}

.el-notifications-box .bottom-all {
	background: #F7F7F7;
	text-align: center;
	padding: 0px;
	padding-top: 10px;
	display: block;
	height: 40px;
	border-top: 1px solid #eee;
}

.el-notifications-box .metadata {
	margin-bottom: -5px;
}

.el-notifications-box .messages-inner {
	max-height: 400px;
	overflow: hidden;
	overflow-y: scroll;
}

.latest-users img {
	margin-bottom: 5px;
}

.el-notification-mark-read {
	float: right;
}

.el-notifications-all a {}

.el-notifications-all li {
	padding: 10px;
	display: block;
}

.el-notifications-all a:hover {
	cursor: pointer;
	background-color: transparent;
	text-decoration: none;
}

.el-notifications-box li:hover,
.el-notifications-box a:hover,
.el-notifications-all a:hover,
.el-notifications-all li:hover {
	background: #F9F9F9;
}

.el-notification-container {
	background-color: #dc0d17;
	background-image: -webkit-linear-gradient(#fa3c45, #dc0d17);
	color: #fff;
	min-height: 13px;
	padding: 1px 3px;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, .4);
	-webkit-border-radius: 2px;
	-webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .7);
	-webkit-background-clip: padding-box;
	display: inline-block;
	font-size: 11px;
	line-height: normal;
	position: absolute;
	margin-left: -10px;
	z-index: 1;
}

.notification-friends .image {
	width: 50px;
	height: 50px;
	display: inline-table;
	float: left;
}

.el-notifications-friends-inner {
	padding: 6px;
}

.el-notifications-friends-inner form {
	display: inline-table;
}

.el-notification-page li img {
	display: none;
}

.notification-friends li {
	margin-bottom: 5px;
	width: 100%;
	border-bottom: 1px solid #eee;
}

.notification-friends .notfi-meta a {
	color: #337ab7;
	font-weight: bold;
	display: inline-block;
	width: 200px;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}

.el-notifications-friends-inner .controls {
	float: right;
	margin-top: 6px;
	display: inline-block;
}

.el-notifications-friends-inner .btn {
	padding: 3px 9px;
	border-radius: 1px;
}

.notification-friends {
	max-height: 400px;
}


/*******************************
	Profile
********************************/

.el-profile .top-container {
	background: #fff;
	border: 1px solid #C4CDE0;
	border-width: 1px 1px 2px;
}

.el-profile .top-container .profile-cover {
	height: 200px;
	overflow: hidden;
	opacity: .99;
	background: -moz-linear-gradient(top, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 1%, rgba(0, 0, 0, .38) 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(0, 0, 0, 0)), color-stop(1%, rgba(0, 0, 0, 0)), color-stop(100%, rgba(0, 0, 0, .38)));
	background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 1%, rgba(0, 0, 0, .38) 100%);
	background: -o-linear-gradient(top, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 1%, rgba(0, 0, 0, .38) 100%);
	background: -ms-linear-gradient(top, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 1%, rgba(0, 0, 0, .38) 100%);
	background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 1%, rgba(0, 0, 0, .38) 100%);
	filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#94000000', GradientType=0);
	position: relative;
}

.el-profile .top-container .profile-cover img {
	width: auto;
}

.el-profile-row {
	margin-bottom: 20px;
}

.profile-hr-menu ul {
	margin-bottom: 0px;
	padding: 0px;
}

.profile-hr-menu ul li {
	display: inline-block;
}

.profile-hr-menu ul li a {
	display: block;
	padding: 15px;
	margin-right: 5px;
	font-weight: bold;
	border-right: 1px solid #eee;
}

.profile-hr-menu .dropdown-menu {
	margin-left: 0px;
}

.profile-hr-menu .dropdown-menu li {
	display: block;
}

.profile-hr-menu .dropdown a i {
	margin-left: 5px;
}

.profile-hr-menu .dropdown-menu li a {
	border-right: 0px;
	margin-right: 0px;
}

.profile-hr-menu ul li:hover {}

.profile-hr-menu {
	border-bottom: 1px solid #eee;
}

.profile-hr-menu ul li:last-child {
	border-right: none;
}

.el-profile .profile-photo {
	position: absolute;
	margin-left: 20px;
	margin-top: -190px;
	background-color: #fff;
	border: 1px solid #CCC;
	border-radius: 2px 2px 2px 2px;
	-webkit-border-radius: 2px 2px 2px 2px;
	-moz-border-radius: 2px 2px 2px 2px;
	padding: 2px;
}

.el-profile .profile-photo img {}

.el-profile .user-fullname {
	color: #FFF;
	font-weight: bold;
	margin-top: -155px;
	font-size: 35px;
	font-size: 2.3vw;
	margin-left: 211px;
	position: absolute;
	text-shadow: 0 0 3px #000;
	/** overlapping issue with longer names on profile page #630 **/
	max-width: 820px;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}

.el-profile-role {
	font-size: 25px !important;
	margin-top: -105px !important;
}

.btn-standalone-grey {
	color: #333;
	font-weight: bold;
	text-decoration: none;
	width: auto;
	margin: 0;
	font-size: 12px;
	line-height: 16px;
	padding: 5px 6px;
	cursor: pointer;
	outline: none;
	text-align: center;
	white-space: nowrap;
	-webkit-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 #FFF;
	-moz-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.10), inset 0 1px 0 #fff;
	box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 #FFF;
	border: 1px solid #999;
	border-bottom-color: #888;
	background: #EEE;
	background: -webkit-gradient(linear, 0 0, 0 100%, from(#F5F6F6), to(#E4E4E3));
	background: -moz-linear-gradient(#f5f6f6, #e4e4e3);
	background: -o-linear-gradient(#f5f6f6, #e4e4e3);
	background: linear-gradient(#F5F6F6, #E4E4E3);
	text-decoration: none;
}

.btn-standalone-grey:active {
	background: #ddd;
	border-bottom-color: #999;
	box-shadow: none;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
}

.btn-standalone-grey:hover {
	color: #333;
	text-decoration: none;
}

.profile-cover-controls {
	position: absolute;
	width: 100%;
	margin-right: -32px;
	margin-top: 150px;
	z-index: 1;
}

.change-cover {
	float: right;
	position: relative;
	margin-right: 50px !important;
}

.reposition-cover {
	float: right;
	position: relative;
	margin-right: 5px !important;
}

.profile-menu {
	float: right;
	position: relative;
	margin-top: -40px;
	margin-right: 20px;
}

#cover-menu {
	display: none;
}

.upload-photo {
	background: #000;
	opacity: 0.5;
	width: 170px;
	padding: 10px;
	position: absolute;
	color: #FFF;
	text-align: center;
	font-size: 15px;
	font-family: sans-serif;
}

.upload-photo span {
	width: 100%;
	padding: 12px;
	text-align: center;
}

.user-cover-uploading {
	opacity: 0.4;
}

.user-photo-uploading {
	height: 100%;
	opacity: 0.8;
	background: #fff;
	width: 100%;
	padding: 7px;
	position: absolute;
	border-radius: 2px;
}

.user-photo-uploading span {
	display: none;
}

.el-profile-bottom {
	margin-top: 10px;
}

.page-sidebar,
.el-profile-sidebar {}

.el-layout-media .content {
	margin-right: 10px;
	margin-left: 10px;
}

.el-profile-extra-menu {
	display: inline-block;
}


/*****************************
    Groups
*****************************/

.el-group-cover img {
	width: auto;
}


/*****************************
	Side Menu icons
*******************************/

.menu-section-item-newsfeed:before {
	content: "\f0a1" !important;
}

.menu-section-item-friends:before {
	content: "\f0c0" !important;
}

.menu-section-item-allgroups:before {
	content: "\f0c0" !important;
}

.menu-section-item-photos:before {
	content: "\f03e" !important;
}

.menu-section-item-messages:before {
	content: "\f0e0" !important;
}

.menu-section-item-invite-friends:before {
	content: "\f234" !important;
}

.menu-section-item-addgroup:before {
	content: "\f067" !important;
}

li[class^="menu-section-item-"] {
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
	width: 200px;
	padding-right: 10px;
}


/******************************
	Search
******************************/

.el-menu-search li {
	display: block;
}

.el-menu-search li:hover {
	background: #F9F9F9;
}

.el-menu-search li a {
	display: block;
	width: 100%;
	padding: 5px;
}

.el-menu-search li a:hover {
	text-decoration: none;
}

.el-menu-search li a .text {
	display: inline-block;
}

.el-search-page .el-users-list-item {
	margin-left: 0px;
	margin-right: 0px;
}

.el-search-page .el-users-list-item .uinfo {
	margin-left: 25px;
}

.el-menu-search-users .text:before {
	font-family: FontAwesome;
	content: "\f007";
	display: absolute;
	padding-right: 10px;
	vertical-align: middle;
	float: left;
}

.el-menu-search-groups .text:before {
	font-family: FontAwesome;
	content: "\f0c0";
	display: absolute;
	padding-right: 10px;
	vertical-align: middle;
	float: left;
}


/******************************
	Token Input
*******************************/

ul.token-input-list {
	overflow: hidden;
	height: auto !important;
	height: 1%;
	width: 100%;
	cursor: text;
	font-size: 12px;
	font-family: Verdana;
	min-height: 1px;
	z-index: 999;
	padding: 0;
	margin: 0;
	margin-top: -5px;
	background-color: #fff;
	list-style-type: none;
	clear: left;
	color: #2B5470;
	border-top: 1px dashed #EEE;
	border-right: 1px solid #EEE;
	border-left: 1px solid #EEE;
}

li.token-input-token {
	overflow: hidden;
	height: auto !important;
	height: 15px;
	margin: 3px;
	padding: 1px 3px;
	background-color: #eff2f7;
	color: #2B5470;
	cursor: default;
	font-weight: bold;
	border: 1px solid #ccd5e4;
	font-size: 11px;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	float: left;
	white-space: nowrap;
}

li.token-input-token p {
	display: inline;
	padding: 0;
	margin: 0;
	font-size: 12px;
}

li.token-input-token span {
	color: #a6b3cf;
	margin-left: 5px;
	font-weight: bold;
	cursor: pointer;
}

li.token-input-selected-token {
	background-color: #F9F9F9;
	border: 1px solid #eee;
	color: #2B5470;
	font-weight: bold;
}

li.token-input-input-token {
	float: left;
	margin: 0;
	padding: 0;
	list-style-type: none;
}

div.token-input-dropdown {
	position: absolute;
	width: 400px;
	background-color: #fff;
	overflow: hidden;
	border-left: 1px solid #ccc;
	border-right: 1px solid #ccc;
	border-bottom: 1px solid #ccc;
	cursor: default;
	font-size: 11px;
	font-family: Verdana;
	z-index: 1;
}

div.token-input-dropdown p {
	margin: 0;
	padding: 5px;
}

div.token-input-dropdown ul {
	margin: 0;
	padding: 0;
}

div.token-input-dropdown ul li {
	background-color: #fff;
	padding: 3px;
	margin: 0;
	list-style-type: none;
}

div.token-input-dropdown ul li.token-input-dropdown-item {
	background-color: #fff;
}

div.token-input-dropdown ul li.token-input-dropdown-item2 {
	background-color: #fff;
}

div.token-input-dropdown ul li em {
	font-weight: bold;
	font-style: normal;
}

div.token-input-dropdown ul li.token-input-selected-dropdown-item {
	background-color: #F9F9F9;
	color: #2B5470;
	font-weight: bold;
}


/******************************************
		System Messages
*******************************************/

.el-system-messages .el-system-messages-inner {
	margin-top: 20px;
	margin-bottom: 20px;
	display: none;
	padding-left: 15px;
	padding-right: 15px;
}

.el-system-messages .el-system-messages-inner .alert {
	margin-bottom: 0px;
}


/** v1-v3 compitible **/

.el-message-done {
	border: 1px solid #1EB0DF;
	border-width: 1px;
	background-color: #DAF6FF;
	padding: 13px;
	text-align: left;
}


/*************************************
	0ssn modal box
***************************************/

.el-halt {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	z-index: 10000;
	background-color: #000;
	opacity: 0.9;
	cursor: auto;
	height: 100%;
	display: none;
}

.el-light {
	opacity: 0.4;
}

.el-viewer {
	width: 940px;
	margin: 0 auto;
	position: relative;
}

.el-viewer .el-container {
	height: 200px;
	position: fixed;
	width: 900px;
	z-index: 10000;
	margin-top: 70px;
	min-height: 515px;
}

.el-viewer-loding {
	font-size: 15px;
}

.el-viewer .el-container .close-viewer {
	float: right;
	cursor: pointer;
	margin-right: 5px;
	font-weight: bold;
	font-size: 13px;
	color: #ccc;
}

.el-container tbody {
	background: #000;
}

.el-halt {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	z-index: 10000;
	background-color: #000;
	opacity: 0.9;
	cursor: auto;
	height: 100%;
	display: none;
}

.el-viewer .info-block {
	background: #fff;
	height: 100%;
	width: 325px;
	float: right;
	margin-left: -3px;
}

.image-block img {
	max-width: 700px;
}

.el-message-box {
	width: 470px;
	min-width: 470px;
	min-height: 96px;
	background: #fff;
	border: 1px solid #999;
	position: fixed;
	top: 0px;
	left: 0px;
	right: 0px;
	margin-left: auto;
	margin-right: auto;
	z-index: 60000;
	margin-top: 100px;
	border-radius: 3px;
	display: none;
	box-shadow: 0 2px 26px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(0, 0, 0, 0.1);
}

.el-message-box .close-box {
	float: right;
	color: #ccc;
	cursor: pointer;
}

.el-message-box .title {
	background: #F5F6F7;
	padding: 11px;
	border-radius: 3px;
	border-bottom: 1px solid #E5E5E5;
	color: #5E5656;
	font-size: 14px;
	font-weight: bold;
}

.el-message-box .contents {
	padding: 10px;
	min-height: 150px;
	max-height: 420px;
	overflow-x: auto;
	overflow: overlay;
	overflow-x: -moz-hidden-unscrollable
}

.el-message-box .control {
	margin-left: 10px;
	margin-right: 10px;
	height: 45px;
	padding: 10px;
	border-top: 1px solid #E9EAED;
}

.el-message-box .control .controls {
	float: right;
}

.el-message-box .control .controls .btn {
	padding: 2px 13px;
	border-radius: 2px;
}

.el-message-box .contents input[type='text'] {
	border: 1px solid #EEE;
	width: 292px;
	padding: 7px;
}

.el-message-box .contents input[type='text'],
.el-message-box .contents label {
	display: inline-table;
}

.el-message-box .contents label {
	color: #666;
	font-weight: bold;
	margin-right: 13px;
}

.el-form input[type=radio] {
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
	display: inline-block;
	position: relative;
	background-color: #ececec;
	color: #666;
	top: 5px;
	height: 20px;
	width: 20px;
	border: 0;
	border-radius: 50px;
	cursor: pointer;
	margin-right: 7px;
	outline: none;
}

.el-form input[type=radio]:checked::before {
	position: absolute;
	font: 9px/1 'Open Sans', sans-serif;
	left: 7px;
	top: 5px;
	content: '\02143';
	transform: rotate(40deg);
}

.el-form input[type=radio]:hover {
	background-color: #f7f7f7;
}

.el-form input[type=radio]:checked {
	background-color: #0b769c;
	color: #fff;
	font-weight: bold;
}


/*******************************
	el Blocked
*********************************/

.el-blocked i {
	font-size: 100px;
}

.el-blocked {
	text-align: center;
	padding: 100px;
}

.el-blocked div {
	font-size: 50px;
	font-weight: bold;
}

.el-blocked p {
	font-size: 16px;
}


/********************************
	Loading Icon
    @source: https://github.com/jlong/css-spinners
*********************************/

@-moz-keyframes three-quarters-loader {
	0% {
		-moz-transform: rotate(0deg);
		transform: rotate(0deg);
	}
	100% {
		-moz-transform: rotate(360deg);
		transform: rotate(360deg);
	}
}

@-webkit-keyframes three-quarters-loader {
	0% {
		-webkit-transform: rotate(0deg);
		transform: rotate(0deg);
	}
	100% {
		-webkit-transform: rotate(360deg);
		transform: rotate(360deg);
	}
}

@keyframes three-quarters-loader {
	0% {
		-moz-transform: rotate(0deg);
		-ms-transform: rotate(0deg);
		-webkit-transform: rotate(0deg);
		transform: rotate(0deg);
	}
	100% {
		-moz-transform: rotate(360deg);
		-ms-transform: rotate(360deg);
		-webkit-transform: rotate(360deg);
		transform: rotate(360deg);
	}
}


/* :not(:required) hides this rule from IE9 and below */

.el-loading:not(:required) {
	-moz-animation: three-quarters-loader 1250ms infinite linear;
	-webkit-animation: three-quarters-loader 1250ms infinite linear;
	animation: three-quarters-loader 1250ms infinite linear;
	border: 8px solid #38e;
	border-right-color: transparent;
	border-radius: 16px;
	box-sizing: border-box;
	position: relative;
	overflow: hidden;
	text-indent: -9999px;
	width: 24px;
	height: 24px;
}

.el-box-loading {
	margin-left: 216px;
	margin-top: 37px;
}


/*******************************
	Buttons
*********************************/

.button-grey,
.btn-action {
	color: #333;
	font-weight: bold;
	width: auto;
	margin: 0;
	font-size: 12px;
	line-height: 16px;
	padding: 5px 6px;
	cursor: pointer;
	outline: none;
	text-align: center;
	white-space: nowrap;
	-webkit-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 #FFF;
	-moz-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.10), inset 0 1px 0 #fff;
	box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 #FFF;
	border: 1px solid #ccc;
	background: -webkit-gradient(linear, 0 0, 0 100%, from(#F5F6F6), to(#E4E4E3));
	background: -moz-linear-gradient(#f5f6f6, #e4e4e3);
	background: -o-linear-gradient(#f5f6f6, #e4e4e3);
	background: linear-gradient(#F5F6F6, #E4E4E3);
	border-radius: 4px;
	text-decoration: none;
}

.button-grey:hover,
.btn-action:hover {
	text-decoration: none;
	background: -webkit-gradient(linear, 0 0, 0 100%, from(#E4E4E3), to(#F5F6F6));
	background: -moz-linear-gradient(#E4E4E3, #F5F6F6);
	background: -o-linear-gradient(#E4E4E3, #F5F6F6);
	background: linear-gradient(#E4E4E3, #F5F6F6);
}


/******************************
	Users List
*******************************/

.el-users-list-item .users-list-controls {
	margin-top: 20px;
}

.el-users-list-item .users-list-controls a {
	margin-left: 5px;
}

.el-users-list-item {
	border: 1px solid #E9EAED;
	margin-bottom: 10px;
	margin-right: -10px;
	margin-left: -10px;
}

.el-users-list-item .uinfo a {
	font-size: 14px;
	font-weight: bold;
	margin-top: 20px;
	float: left;
	text-overflow: ellipsis;
	width: 300px;
	white-space: nowrap;
	overflow: hidden;
}

.el-users-list-item .col-md-2 {
	text-align: center;
}


/*********************************
	Footer
**********************************/

footer {
	margin-top: 20px;
	padding-top: 5px;
}

footer .col-md-11 {
	border-top: 1px solid #E8E8E8;
}

footer .container {}

footer .el-footer-menu {
	padding-bottom: 10px;
}

footer .el-footer-menu a {
	color: #807D7D;
	font-size: 13px;
}

footer .el-footer-menu a::after {
	content: "|";
	margin-left: 10px;
	margin-right: 10px;
}

footer .el-footer-menu a:nth-last-child(2)::after,
footer .el-footer-menu a:last-child::after {
	content: "";
}

.menu-footer-powered {
	float: right;
}

.menu-footer-powered:after {
	display: none;
}

.menu-footer-a_copyrights {
	text-transform: uppercase;
}


/****************************
	Home
****************************/

.home-left-contents {}

.home-left-contents .logo {
	text-align: center;
}

.home-left-contents .description {
	font-size: 17px;
	text-transform: uppercase;
	font-weight: bold;
	margin-top: 20px;
	text-align: justify;
	color: #fff;
}

.home-left-contents .buttons {
	text-align: center;
	margin-top: 10px;
}

#el-home-signup p {
	margin-top: 10px;
}

#el-home-signup .radio-block {
	margin-top: 0;
	margin-bottom: 0;
}

#el-home-signup .el-form-group-half:last-child {
	float: right;
}

#el-home-signup .form-group {
	margin-bottom: 0px;
}


/**************************
	System
***************************/

.el-list-users {
	height: 60px;
	border-bottom: 1px solid #E9EAED;
	display: block;
	margin-left: 5px;
	margin-bottom: 10px;
}

.el-list-users img,
.el-list-users .uinfo {
	display: inline-block;
}

.el-list-users .uinfo .userlink {
	font-size: 14px;
	font-weight: bold;
	float: right;
	margin-left: 12px;
	text-overflow: ellipsis;
	width: 370px;
	white-space: nowrap;
	overflow: hidden;
}

.el-list-users .friendlink {
	float: right;
	margin-top: 10px;
	margin-right: 9px;
	text-overflow: ellipsis;
	width: 280px;
	white-space: nowrap;
	overflow: hidden;
}

.sidebar-menu-nav .sidebar-menu .menu-content {
	display: block;
}

.el-box-inner {
	width: 446px;
}

.home-left-contents .some-icons i {
	font-size: 45px;
}

.home-left-contents .some-icons li {
	display: inline-block;
	color: #fff;
	border: 3px solid #fff;
	border-radius: 100%;
	padding: 20px;
	margin-right: 20px;
	margin-bottom: 20px;
	width: 90px;
	height: 90px;
}

.home-left-contents .some-icons {
	margin-top: 10%;
	text-align: center;
}


/**************************
	Similies
**************************/

.el-smiley-item {
	display: inline-block !important;
	margin-left: 2px;
	margin-right: 2px;
	width: initial !important;
	margin-bottom: 0px !important;
	margin-top: 0px !important;
	border: 0px !important;
}


/**************************
	Embed
 **************************/

.el_embed_video {
	margin-top: 10px;
	margin-bottom: 10px;
	padding-top: 0px;
}


/**************************
	Photos
***************************/

.el-photo-viewer .image-block img,
.el-photo-viewer {
	max-width: 100% !important;
}

.ui-draggable {
	opacity: 0.7;
}


/**************************
	Mobile Layout Settings
***************************/

@media (max-width: 480px) {
	.el-wall-privacy {
		float: none;
		margin-right: 0;
	}
	.el-wall-container .controls {
		height: auto;
	}
	/***********************
    	Comments
     ***********************/
	.comments-list .comments-item .comment-user-img {
		display: none;
	}
	.comments-item .col-md-11 {
		padding-left: 15px;
	}
	/************************
    	Wall
     ************************/
	.el-wall-item-type {
		display: block;
	}
	.el-list-users .uinfo .userlink {
		text-overflow: ellipsis;
		width: 195px;
		white-space: nowrap;
		overflow: hidden;
	}
	.el-list-users a.right.btn.btn-primary {
		display: none;
	}
	.el-list-users a.right.btn.btn-danger {
		display: none;
	}
	.el-message-box .contents {
		height: 280px;
		overflow-x: auto;
		overflow: overlay;
	}
	/***************************
    	Topbar notification box
   *****************************/
	.el-notifications-box {
		width: 300px;
	}
	.el-notifications-box .notfi-meta {
		width: 230px;
	}
	.notification-friends .notfi-meta a {
		width: 100px;
	}
	.el-notifications-box .notfi-meta,
	.el-notification-messages .user-item .data {
		width: 215px !important;
	}
	.el-notification-messages .user-item .data .name {
		width: 110px !important;
	}
	.el-notification-messages .reply-text-from {
		width: 200px !important;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	/******************************
    	Profile
    ********************************/
	.el-profile .profile-photo img {
		width: 100px;
		height: 100px;
	}
	.el-profile .user-fullname {
		font-size: 16px;
		margin-left: 135px;
		margin-top: -100px;
		width: 140px;
	}
	.el-profile .top-container .profile-cover {
		height: 188px;
	}
	.el-profile .profile-photo {
		margin-top: -130px;
	}
	.profile-menu {
		float: right;
		margin-right: 10px;
	}
	.el-profile .top-container .profile-cover img {
		width: auto;
	}
	.el-group-cover-button,
	.profile-cover-controls {
		display: none !important;
	}
	.upload-photo {
		width: 100px;
	}
	.profile-hr-menu ul li {
		display: block;
		border-bottom: 1px solid rgb(238, 238, 238);
		margin-right: 0px;
	}
	.profile-hr-menu ul li a {
		margin-right: 0px;
		padding: 10px;
	}
	.el-profile-role {
		display: none;
	}
	/*****************************
     	System
     *****************************/
	.el-users-list-item img {
		display: none;
	}
	.el-users-list-item .users-list-controls {
		margin-top: 10px;
		margin-bottom: 10px;
	}
	.el-users-list-item .uinfo a {
		margin-top: 10px;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		width: 90px;
	}
	.el-search-page .el-users-list-item .uinfo a {
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		width: 100px;
	}
	.el-system-messages {
		padding-left: 15px;
		padding-right: 15px;
	}
	.el-users-list-item {
		padding-bottom: 10px;
	}
	.el-widget .widget-contents {
		padding: 5px;
	}
	.el-message-box {
		min-width: 300px;
		width: 300px;
	}
	.el-box-loading {
		margin-left: 150px;
		margin-top: 37px;
	}
	.el-message-box .contents input[type="text"] {
		width: 195px;
	}
	.el-box-inner {
		width: 280px;
	}
	footer .el-footer-menu a:nth-last-child(2)::after {
		content: "|";
	}
	/**********************
    	Groups
    ************************/
	.el-group-cover {
		height: 100px !important;
	}
	.groups-buttons {
		float: none !important;
	}
	.el-group-cover-header,
	.el-group-profile .profile-header,
	.el-group-profile .profile-header .header-bottom {
		height: auto !important;
	}
	.el-group-profile .profile-header {
		max-height: inherit !important;
	}
	.groups-buttons {
		margin-top: 50px;
	}
	.el-group-profile .profile-header .group-name {
		float: none !important;
	}
	#group-header-menu li,
	#group-header-menu {
		width: 100% !important;
	}
	#group-header-menu li {
		border-bottom: 1px solid #EEE !important;
	}
	.group-name {
		text-align: center;
		width: 100%;
		border-bottom: 1px solid #eee;
	}
	.el-group-members {
		margin-left: 15px;
		margin-right: 15px;
	}
	.el-group-members .request-controls,
	.el-group-members .uinfo {
		display: inline-block;
	}
	.el-group-members .uinfo .userlink {
		width: 130px;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	.sidebar-menu-nav .sidebar-menu .menu-content {
		display: block;
	}
	.sidebar-hide-contents-xs {
		display: none;
	}
	.home-left-contents .some-icons {
		display: none;
	}
	/**************************
     	Layouts
     ****************************/
	.newsfeed-right {
		display: none;
	}
	.newsfeed-middle-top {
		display: block;
	}
	.el-messages .message-with .user-icon,
	.el-messages .messages-recent .messages-from .user-item .image {
		display: none;
	}
	.el-messages .message-inner .row {
		margin-left: 0px !important;
	}
	/*************************
     	Home Page
     **************************/
	.logo img {
		width: 260px;
	}
	.home-left-contents .description {
		font-size: 16px;
	}
	.home-left-contents {
		margin-bottom: 20px;
	}
	/*****************************
    	Wall Menu
    ******************************/
	.dropdown-menu {
		margin-left: -110px;
	}
	.menu-footer-powered {
		float: none;
	}
}


/***************************************
	Tablets
****************************************/

@media only screen and (max-width: 992px) {
	.dropdown-menu {
		margin-left: -110px;
	}
	.el-profile .user-fullname {
		max-width: 500px;
	}
	/***********************
    	Comments
     ***********************/
	.comments-list .comments-item .comment-user-img {
		display: none;
	}
	.comments-item .col-md-11 {
		padding-left: 15px;
	}
	/**************************
     	Layouts
     ****************************/
	.newsfeed-right {
		display: none;
	}
	.newsfeed-middle-top {
		display: block;
	}
	/*******************
     	Messages
     *******************/
	.el-messages .message-with .user-icon,
	.el-messages .messages-recent .messages-from .user-item .image {
		display: none;
	}
	.el-messages .message-inner .row {
		margin-left: 0px !important;
	}
	.sidebar-menu-nav .sidebar-menu .menu-content {
		display: block;
	}
}

@media only screen and (max-width: 1199px) {
	.comments-list .comments-item .col-md-1,
	.comments-list .comments-item .comment-user-img {
		display: none;
	}
	.comments-list .comments-item .col-md-11 {
		width: 100%;
	}
	.comments-item .col-md-11 {
		padding-left: 15px;
	}
	.group-search-details {
		margin-left: 10px;
	}
	.el-search-page .el-users-list-item .uinfo {
		margin-left: 35px;
	}
	.el-search-page .el-users-list-item .uinfo a {
		text-overflow: ellipsis;
		width: 200px;
		white-space: nowrap;
		overflow: hidden;
	}
	.el-users-list-item .users-list-controls {
		margin-bottom: 10px;
	}
	.el-profile .user-fullname {
		max-width: 640px;
	}
}

@media only screen and (max-width: 767px) {
	.el-profile .user-fullname {
		max-width: 767px;
	}
	.el-search-page .el-users-list-item .uinfo {
		margin-left: 0;
	}
}


/*****************************************************
		Adding icons for some 3rd party components
******************************************************/

.sidebar-menu-nav ul .sub-menu li:before {
	font-family: FontAwesome;
	display: inline-block;
	padding-left: 10px;
	padding-right: 10px;
	vertical-align: middle;
}

.menu-section-item-groups:before {
	content: "\f07b" !important
}

@media screen and (min-width:1500px) {
	.el-wall-container .wall-tabs i {
		margin-top: 3px;
	}
}
