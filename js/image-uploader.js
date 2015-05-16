function uploadImage(file) {
  return new Promise(function(resolve, reject){
    var fd = new FormData();
    fd.append("image", file);

    var xhr = new XMLHttpRequest();

    xhr.open("POST", "https://api.imgur.com/3/upload", true);

    xhr.setRequestHeader('Authorization', 'Client-ID xxxxxxxxxxxxxxx')

    xhr.onload = function() {
      resolve(xhr.responseText);
    }

    xhr.send(fd);
  })
}
