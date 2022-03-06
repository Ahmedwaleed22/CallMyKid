<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? $title : "Call My Kid"; ?></title>
  <link rel="shortcut icon" href="<?php echo $img . 'logo.jpeg' ?>" />
  <?php if (isset($custom_styles)) { ?>
    <link rel="stylesheet" href="<?php echo $css . $custom_styles ?>">
  <?php } ?>
  <link rel="stylesheet" href="<?php echo $css . 'style.css' ?>">
</head>

<body>