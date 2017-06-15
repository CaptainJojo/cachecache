fetch('http://cachecache.dev/comment')
.then(function(response) {
  return response.json().then(function(json) {
    var commentsDiv = document.getElementById('comments');
    var htmlComment = '';
    json.map(function(comment){
      htmlComment += '<h3>' + comment.author + '</h3><p>' + comment.content + '</p>';
    });

    commentsDiv.innerHTML = htmlComment;
  });
});
