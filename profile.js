
  const fileInput = document.getElementById('fileInput');
  const profileImage = document.getElementById('profileImage');

  // Load saved image from localStorage when page opens
  const savedImage = localStorage.getItem("profile-photo");
  if (savedImage) {
    profileImage.src = savedImage;
  }

  fileInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const imageData = e.target.result;
        profileImage.src = imageData;         // show preview
        localStorage.setItem("profile-photo", imageData); // save in browser
      };
      reader.readAsDataURL(file);
    }
  });

