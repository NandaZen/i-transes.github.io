<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<h3>Pilih Gambar Profil</h3>
<form id="profilePicForm" method="POST">
    <div class="row">
        <div class="col-md-4">
            <img src="../../assets/profile_pics/user1.jpg" alt="User 1" class="img-thumbnail" style="cursor: pointer;" onclick="selectProfilePic('user1.jpg')">
        </div>
        <div class="col-md-4">
            <img src="../../assets/profile_pics/user2.jpg" alt="User 2" class="img-thumbnail" style="cursor: pointer;" onclick="selectProfilePic('user2.jpg')">
        </div>
        <div class="col-md-4">
            <img src="../../assets/profile_pics/user3.jpg" alt="User 3" class="img-thumbnail" style="cursor: pointer;" onclick="selectProfilePic('user3.jpg')">
        </div>
    </div>

    <input type="hidden" name="selectedProfilePic" id="selectedProfilePic">
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>
 
</body>
</html>