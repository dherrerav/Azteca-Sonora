<?php
move_uploaded_file($_FILES['Filedata']['tmp_name'], 'uploads/'.$_FILES['Filedata']['name']);
?>