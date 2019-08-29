<?php
$image = $data['image'];  // your base64 encoded
$image = str_replace('data:image/png;base64,', '', $image);
$image = str_replace(' ', '+', $image);
$imageName = $data['imageName'];
\Illuminate\Support\Facades\File::put('uploads'. '/' . $imageName, base64_decode($image));
?>
