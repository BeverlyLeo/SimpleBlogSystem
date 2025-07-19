CREATE TABLE blog_system_bloggers (
    bloggerID INT(11) PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE blog_system_post (
    postID INT(11) PRIMARY KEY AUTO_INCREMENT,
    bloggerID INT(11),
    post VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bloggerID) REFERENCES blog_system_bloggers(bloggerID)
);

CREATE TABLE blog_system_viewer (
    viewerID INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(500),
    postID INT(11),
    FOREIGN KEY (postID) REFERENCES blog_system_post(postID)
);

CREATE TABLE blog_system_comments (
    commentID INT(11) PRIMARY KEY AUTO_INCREMENT,
    bloggerID INT(11),
    postID INT(11),
    comment VARCHAR(800),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    viewerID INT(11),
    FOREIGN KEY (bloggerID) REFERENCES blog_system_bloggers(bloggerID),
    FOREIGN KEY (postID) REFERENCES blog_system_post(postID),
    FOREIGN KEY (viewerID) REFERENCES blog_system_viewer(viewerID)
);