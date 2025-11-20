<?php
global $upload_image_url;
?>
<script>
  function uploadImageAsync(imageFile) {
    return new Promise((resolve, reject) => {
      var fd = new FormData();
      fd.append('image', imageFile);
      $.ajax({
        url: "<?= $upload_image_url ?>",
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response) {
          if (response.success != 0) {
            resolve(response.message)
          } else {
            // alert('file not uploaded');
            reject('Image not uploaded!')
          }
        },
      });
      setTimeout(() => reject('Time out error!'), 10000)
    })

  }
</script>