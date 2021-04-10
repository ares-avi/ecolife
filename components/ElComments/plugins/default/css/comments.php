.el-comment-attach-photo {
    width: 100%;	
}

.el-comment-attach-photo .fa-camera {
    float: right;
    position: relative;
    margin-right: 5px;
    margin-top: 5px;
    width: 25px;
    height: 25px;
    padding: 5px;
    cursor:pointer;
}
.el-comment-attachment {
    width: 115px;
    margin-left: 40px;
    padding-bottom: 10px;
    margin-top: -5px;
	display:none;
}
.el-comment-attachment  .image-data  {
    padding: 6px;
    background: #fff;
    border: 1px solid #eee;
    
    /* Please, check scaling algorithm of comment picture previews #682 */
    /** 
    comments attachment image not responsive #938
    display: flex; **/
    
    max-height: 180px;       
    text-align: center;
}
.el-comment-attachment  .image-data img {
	max-width:100%;
	height: 100px;
	border: 1px solid #ccc;
}
.el-viewer-comments .el-comment-attachment {
	width:115px;
}
.el-viewer .comments-item .row {
	margin-left:10px;
    margin-right:10px;
}
.el-viewer .comments-item .col-md-1 {
	display:none;
}
.el-viewer-comments .comments-likes .el-comment-attach-photo .fa-camera {
	float:none;
    margin-right:0px;
    margin-left:10px;
}

.el-viewer-comments .el-comment-attachment {
    margin-left: 10px;
    padding-bottom: 10px;
    margin-top: 5px;
}
.el-viewer-comments .like-share {
	margin-left:0px;
    margin-right:0px;
}
.el-form textarea#comment-edit{
    height: 125px;
}
.el-delete-comment {
    color: #EC2020 !important;
}
